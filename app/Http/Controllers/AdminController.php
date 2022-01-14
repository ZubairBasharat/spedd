<?php

namespace App\Http\Controllers;

use App\FinanceSettings;
use App\Library\Common\MyLib;
use App\SubadminRestaurant;
use App\User;
use App\UserOrder;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use Validator;

class AdminController extends Controller {

	protected $schema;

	public function __construct() {

		$this->initTable();

	}

	public function initTable() {

		if (\Auth::check()) {

		} else {

			$this->middleware(function ($request, $next) {

				return $next($request);

			});

		}

		$this->connection = DB::connection();
	}

	public function change_subadmin_restaurant($r_id) {
		try {
			$id = decrypt($r_id);
			$restaurant = User::where('id', $id)->first();
			if (!empty($restaurant)) {
				$restaurants = MyLib::getSubAdminRestaurants(auth()->user()->id);
				if (!empty($restaurants)) {
					$restaurants_ids = $restaurants->pluck('restaurant_id')->toArray();
					if (in_array($id, $restaurants_ids)) {
						$user = User::where('id', auth()->user()->id)->first();
						$user->selected_restaurant = $id;
						$user->save();
						// dd('yes');
						return redirect()->route('home');
					} else {
						// dd('no');
						return redirect()->route('home')->withErrors(['This restaurant is not assigned to you.']);
					}
				}
				// dd('no 1');
				return redirect()->route('home')->withErrors(['This restaurant is not assigned to you.']);
			} else {
				// dd('no 2');
				return redirect()->route('home')->withErrors(['This restaurant is not assigned to you.']);
			}
		} catch (\Exception $e) {
			// dd('This restaurant is not assigned to you. ' . $e->getMessage());
			return redirect()->route('home')->withErrors(['This restaurant is not assigned to you. ' . $e->getMessage()]);
		}
	}

	public function manage_restaurant_subadmins() {

		$title = "Manage Restaurant Sub-Admin";

		$users = MyLib::getAllRestaurantSubAdminList();

		$restaurants = User::where('user_type', 2)->where('active', 1)->where('verified', 1)->get();

		return view('adminlte.admin.manage_restaurant_subadmins', compact('title', 'users', 'restaurants'));
	}

	public function add_restaurant_subadmin(Request $request) {

		$validator = Validator::make($request->all(), [
			'name' => 'required|string',
			'username' => 'required|string|unique:users',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:8|confirmed',
			'restaurants.*' => 'required',
		]);

		if ($validator->fails()) {
			return redirect()->route('manage_restaurant_subadmins')->withErrors($validator->messages());
		}

		try {

			$user = new User;
			$user->name = request('name');
			$user->username = request('username');
			$user->email = request('email');
			$user->password = bcrypt(request('password'));
			$user->region = request('region');
			$user->unique_id = MyLib::generateUserUniqueID();
			$user->active = 1;
			$user->verified = 1;
			$user->user_type = 5; //subadmin - restaurant
			$user->moderate_profile = 1;
			// $user->created_by = auth()->user()->id;
			$user->token = '';

			if ($user->save()) {

				foreach ($request->restaurants as $key => $r) {
					$obj = new SubadminRestaurant;
					$obj->user_id = $user->id;
					$obj->restaurant_id = $r;
					$obj->active = 1;
					$obj->created_by = auth()->user()->id;
					$obj->created_at = \Carbon\Carbon::now();
					$obj->save();
				}
				return redirect()->route('manage_restaurant_subadmins')->with('status', 'Sub-Admin Account has been created successfully. Email is verified & account is activated automatically.');
			} else {
				return redirect()->route('manage_restaurant_subadmins')->withErrors(['Unable to create sub-admin account.']);
			}

		} catch (\Exception $e) {
			$this->connection->rollBack();
			return redirect()->route('manage_restaurant_subadmins')->withErrors(['Unable to create sub-admin account. ' . $e->getMessage()]);
		}
	}

	public function manage_subadmins() {

		$title = "Manage Sub-Admin";

		$users = MyLib::getAllSubAdminList();

		return view('adminlte.admin.manage_subadmins', compact('title', 'users'));
	}

	public function add_subadmin(Request $request) {

		$validator = Validator::make($request->all(), [
			'name' => 'required|string',
			'username' => 'required|string|unique:users',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:8|confirmed',
			'region' => 'required',
		]);

		if ($validator->fails()) {
			return redirect()->route('manage_subadmins')->withErrors($validator->messages());
		}

		try {

			$user = new User;
			$user->name = request('name');
			$user->username = request('username');
			$user->email = request('email');
			$user->password = bcrypt(request('password'));
			$user->region = request('region');
			$user->unique_id = MyLib::generateUserUniqueID();
			$user->active = 1;
			$user->verified = 1;
			$user->user_type = 4; //subadmin
			$user->moderate_profile = 1;
			// $user->created_by = auth()->user()->id;
			$user->token = '';

			if ($user->save()) {
				return redirect()->route('manage_subadmins')->with('status', 'Sub-Admin Account has been created successfully. Email is verified & account is activated automatically.');
			} else {
				return redirect()->route('manage_subadmins')->withErrors(['Unable to create sub-admin account.']);
			}

		} catch (\Exception $e) {
			$this->connection->rollBack();
			return redirect()->route('manage_subadmins')->withErrors(['Unable to create sub-admin account. ' . $e->getMessage()]);
		}
	}

	public function manage_finance_settings() {

		$title = "Manage Financial Settings";

		$data = FinanceSettings::first();

		return view('adminlte.admin.manage_finance_settings', compact('title', 'data'));
	}

	public function manage_finance_settings_post(Request $request) {

		$validator = Validator::make($request->all(), [
			'currency' => 'required',
			'tax_on_restaurant_order' => 'required',
			'mini_distance' => 'required',
			'mini_distance_charges' => 'required',
			'charges_per_km' => 'required',
			'driver_subscription_fee' => 'required',
			'delivery_fee' => 'required',
			'max_due_amount' => 'required',
		]);

		if ($validator->fails()) {

			return redirect()->route('manage_finance_settings')->withErrors($validator->messages());

		}

		$id = decrypt($request->id);
		$obj = FinanceSettings::where('id', $id)->first();

		if (!empty($obj)) {

			$obj->currency = request('currency');
			$obj->tax_on_restaurant_order = request('tax_on_restaurant_order');
			$obj->mini_distance = request('mini_distance');
			$obj->mini_distance_charges = request('mini_distance_charges');
			$obj->charges_per_km = request('charges_per_km');
			$obj->driver_subscription_fee = request('driver_subscription_fee');
			$obj->delivery_fee = request('delivery_fee');
			$obj->max_due_amount = request('max_due_amount');
			$obj->updated_at = \Carbon\Carbon::now();
			$obj->updated_by = auth()->user()->id;
			$obj->save();

			return redirect()->route('manage_finance_settings')->with('status', 'Settings successfully updated.');

		} else {
			return redirect()->route('manage_finance_settings')->withErrors(['Unable to update settings.']);
		}

	}

	public function manage_restaurants() {

		$title = "Manage Restaurants";

		$users = MyLib::getAllRestaurantsList();

		return view('adminlte.admin.manage_restaurants', compact('title', 'users'));
	}

	public function add_restaurant() {
		$title = "Add Restaurant";
		return view('adminlte.admin.add_restaurant', compact('title'));
	}

	public function save_restaurant(Request $request) {

		//if edit
		if ($request->has('restaurant_id')) {
			$validator = Validator::make($request->all(), [
				'name' => 'required|string',
				'restaurant_type' => 'required',
				'phone_number' => 'required',
				'city' => 'required',
				'region' => 'required',
				'location' => 'required',
				'commercial_reg_no' => 'required',
			]);

			if ($validator->fails()) {
				return redirect()->route('edit_restaurant', request('restaurant_id'))->withErrors($validator->messages())->withInput($request->input());
			}

			if ($request->latitude == null || $request->latitude == 'undefined' || $request->longitude == null || $request->longitude == 'undefined' || $request->restaurant_location == 'undefined') {
				return redirect()->route('edit_restaurant', request('restaurant_id'))->withErrors(['Please select restaurant location by typing in restaurant search.'])->withInput($request->input());
			}
		} else {
			$validator = Validator::make($request->all(), [
				// 'vendor_type' => 'required',
				'name' => 'required|string',
				'restaurant_type' => 'required',
				'phone_number' => 'required',
				'email' => 'required|email|unique:users',
				'username' => 'required|string|unique:users',
				'password' => 'required|min:8|confirmed',
				'city' => 'required',
				'region' => 'required',
				'location' => 'required',
				'commercial_reg_no' => 'required',
			]);

			if ($validator->fails()) {
				return redirect()->route('add_restaurant')->withErrors($validator->messages())->withInput($request->input());
			}

			if ($request->latitude == null || $request->latitude == 'undefined' || $request->longitude == null || $request->longitude == 'undefined' || $request->restaurant_location == 'undefined') {
				return redirect()->route('add_restaurant')->withErrors(['Please select restaurant location by typing in restaurant search.'])->withInput($request->input());
			}
		}

		$this->connection->beginTransaction();
		$email_status = "";

		try {

			if ($request->has('restaurant_id')) {
				$id = decrypt(request('restaurant_id'));
				$user = User::where('id', $id)->first();
				$user->updated_at = \Carbon\Carbon::now();
			} else {
				$user = new User;
				$user->email = request('email');
				$user->username = request('username');
				$user->password = bcrypt(request('password'));
				$user->unique_id = MyLib::generateUserUniqueID();
				$user->active = 0;
				$user->user_type = 2;
				$user->moderate_profile = 1;
				$user->token = 'token-' . date("YmdHis", time()) . '-' . str_random(25);
			}

			$user->name = request('name');
			$user->restaurant_location = request('location');
			$user->latitude = request('latitude');
			$user->longitude = request('longitude');
			$user->phone_number = request('phone_number');
			$user->country = 'Saudi Arabia';
			$user->city = request('city');
			$user->region = request('region');
			$user->commercial_reg_no = request('commercial_reg_no');
			$user->restaurant_type = request('restaurant_type');

			if ($user->save()) {
				$user->membership_no = 'S-' . $user->id;
				if (!empty(request('profile_picture'))) {
					$this->saveProfilePicture($user->id);
				}

				if ($request->has('restaurant_id')) {
					$this->connection->commit();
					return redirect()->route('manage_restaurants')->with('status', 'Restaurant details has been successfully updated.');
				}
			} else {
				if ($request->has('restaurant_id')) {
					return redirect()->route('edit_restaurant', request('restaurant_id'))->withErrors(['Unable to update details.'])->withInput($request->input());
				} else {
					return redirect()->route('add_restaurant')->withErrors(['Unable to save restaurant.'])->withInput($request->input());
				}
			}

			////////////  send registration email  /////////////////////
			$data = json_decode(json_encode($user), true);
			$email_status = '';
			try
			{
				Mail::send('emails.emailverification', $data, function ($message) use ($data) {
					$message->from(env('MAIL_USERNAME', 'info@speeds.ws'));
					$message->to($data['email']);
					$message->subject('Registration Confirmation');
				});

				$email_status = 'OK';

			} catch (\Swift_TransportException $e) {
				$this->connection->rollBack();
				$email_status = 'Unable to send email on given email address.';
				return redirect()->route('add_restaurant')->withErrors(['Unable to send email.'])->withInput($request->input());
			}

			if ($email_status == 'OK') {
				$this->connection->commit();
				return redirect()->route('manage_restaurants')->with('email_status', $email_status)->with('status', 'Restaurant registered successfully. Confirmation email has been sent to activate account.');
			} else {
				$this->connection->rollBack();
				return redirect()->route('add_restaurant')->withErrors(['Unable to send email.' . $email_status . ''])->withInput($request->input());
			}

		} catch (\Exception $e) {
			$this->connection->rollBack();
			return redirect()->route('add_restaurant')->withErrors(['Unable to register. ' . $e->getMessage()])->withInput($request->input());
		}
	}

	public function edit_restaurant($r_id) {

		try {
			// dd('Work in progress');
			$restaurant_id = decrypt($r_id);

			$title = "Update Restaurant";

			$restaurant = User::where('id', $restaurant_id)->first();

			if (!empty($restaurant)) {
				return view('adminlte.admin.add_restaurant', compact('title', 'restaurant'));
			}
		} catch (\Exception $e) {
			return redirect()->route('manage_restaurants')->withErrors(['Unable to find restaurant details.']);
		}
	}

	public function restaurant_details($_id) {
		try {
			$id = decrypt($_id);

			$title = "Restaurant Details";

			$data = User::where('id', $id)->first();

			if (!empty($data)) {
				$sales = $this->connection->table('orders as uo')
					->join('users as u', 'u.id', 'uo.created_by')
					->select(
						'u.name',
						DB::raw('count(uo.id) as total_orders'),
						DB::raw('sum(uo.grand_total) as grand_total'),
						DB::raw('sum(uo.order_amount) as order_amount'),
						DB::raw('sum(uo.delivery_fee) as delivery_fee')
					)
					->where('uo.status', 'Completed')
					->where('u.id', $data->id)
					->first();
				return view('adminlte.admin.restaurant_details', compact('title', 'data', 'sales'));
			} else {
				return redirect()->route('manage_restaurants')->withErrors(['Restaurant details not found.']);
			}
		} catch (\Exception $e) {
			return redirect()->route('manage_restaurants')->withErrors(['Restaurant details not found.']);
		}
	}

	public function saveProfilePicture($user_id) {

		$file = request('profile_picture');

		try

		{

			$filename = "user-" . $user_id . "-" . date("YmdHis", time()) . "." . $file->getClientOriginalExtension();

			//$filename = "/usersimages/"; // pic name

			$_imagename = url('/usersimages/' . $filename); //to store in db full path to pic

			$file->move("usersimages", $filename);

			//dd($user_id, $filename, $_imagename);

			$this->connection->table('users')->where('id', $user_id)->update(['profile_picture' => $_imagename]);

		} catch (Illuminate\Filesystem\FileNotFoundException $e) {
			dd($e);
		}
	}

	public function driver_details($_id) {
		try {
			$id = decrypt($_id);

			$title = "Driver Details";

			$data = User::where('id', $id)->first();

			if (!empty($data)) {

				$data->statistics = $this->getDriverStatistics($data->id);

				$order = null;
				if ($data->is_driver_busy == 1 && $data->active_order_id != null) {
					$order = $this->connection->table('orders as uo')
						->join('users as u', 'u.id', 'uo.created_by')
						->where('uo.id', $data->active_order_id)
						->select('uo.*', 'u.name as restaurant_name')
						->first();
				}

				return view('adminlte.admin.driver_details', compact('title', 'data', 'order'));
			} else {
				return redirect()->route('manage_drivers')->withErrors(['Driver details not found.']);
			}
		} catch (\Exception $e) {
			return redirect()->route('manage_drivers')->withErrors(['Driver details not found.']);
		}
	}

	public function getDriverStatistics($driver_id) {
		$result = UserOrder::where('status', 'Completed')
			->where('driver_id', $driver_id)
			->select(
				DB::raw('count(*) as total_orders'),
				DB::raw('sum(delivery_fee) as total_delivery_fee'),
				DB::raw('sum(order_amount) as total_order_amount'),
				DB::raw('sum(grand_total) as total_grand_amount')
			)
			->first();

		return $result;
	}

	public function manage_drivers() {

		$title = "Manage Drivers";

		$users = MyLib::getAllDriversList();

		return view('adminlte.admin.manage_drivers', compact('title', 'users'));

	}

	public function add_driver() {
		$title = "Add Driver";
		return view('adminlte.admin.add_driver', compact('title'));
	}

	public function save_driver(Request $request) {

		//if edit
		if ($request->has('driver_id')) {
			$validator = Validator::make($request->all(), [
				'name' => 'required|string',
				'cnic_no' => 'nullable|string',
				'citizen_type' => 'nullable|string',
				'city' => 'required|string',
				'car_plate' => 'nullable|string',
				'license_expire_date' => 'nullable',
				'car_modal_year' => 'nullable',
				'mobile_no' => 'required',
				'wallet' => 'required',
				'profile_picture' => ['nullable', 'mimes:jpeg,png,jpg,bmp,jfif'],
				'iqama_id_picture' => ['nullable', 'mimes:jpeg,png,jpg,bmp,jfif'],
				'istemara_picture' => ['nullable', 'mimes:jpeg,png,jpg,bmp,jfif'],
				'license_picture' => ['nullable', 'mimes:jpeg,png,jpg,bmp,jfif'],
				'insurance_picture' => ['nullable', 'mimes:jpeg,png,jpg,bmp,jfif'],
				'car_front_picture' => ['nullable', 'mimes:jpeg,png,jpg,bmp,jfif'],
				'car_back_picture' => ['nullable', 'mimes:jpeg,png,jpg,bmp,jfif'],
				'car_left_picture' => ['nullable', 'mimes:jpeg,png,jpg,bmp,jfif'],
				'car_right_picture' => ['nullable', 'mimes:jpeg,png,jpg,bmp,jfif'],
			]);

			if ($validator->fails()) {
				return redirect()->route('edit_driver', request('driver_id'))->withErrors($validator->messages())->withInput($request->input());
			}
		} else {
			$validator = Validator::make($request->all(), [
				'name' => 'required|string',
				'cnic_no' => 'nullable|string',
				'citizen_type' => 'nullable|string',
				'city' => 'required|string',
				'car_plate' => 'nullable|string',
				'license_expire_date' => 'nullable',
				'car_modal_year' => 'nullable',
				'username' => 'required|string|unique:users',
				'email' => 'required|email|unique:users',
				'password' => 'required|min:8',
				'mobile_no' => 'required',
				'wallet' => 'required',
				'profile_picture' => ['nullable', 'mimes:jpeg,png,jpg,bmp,jfif'],
				'iqama_id_picture' => ['nullable', 'mimes:jpeg,png,jpg,bmp,jfif'],
				'istemara_picture' => ['nullable', 'mimes:jpeg,png,jpg,bmp,jfif'],
				'license_picture' => ['nullable', 'mimes:jpeg,png,jpg,bmp,jfif'],
				'insurance_picture' => ['nullable', 'mimes:jpeg,png,jpg,bmp,jfif'],
				'car_front_picture' => ['nullable', 'mimes:jpeg,png,jpg,bmp,jfif'],
				'car_back_picture' => ['nullable', 'mimes:jpeg,png,jpg,bmp,jfif'],
				'car_left_picture' => ['nullable', 'mimes:jpeg,png,jpg,bmp,jfif'],
				'car_right_picture' => ['nullable', 'mimes:jpeg,png,jpg,bmp,jfif'],
			]);

			if ($validator->fails()) {
				return redirect()->route('add_driver')->withErrors($validator->messages())->withInput($request->input());
			}
		}

		$this->connection->beginTransaction();
		$email_status = "";
		ini_set('max_execution_time', 120);
		try {

			if ($request->has('driver_id')) {
				$id = decrypt(request('driver_id'));
				$user = User::where('id', $id)->first();

			} else {
				$user = new User;
				$user->username = request('username');
				$user->email = request('email');
				$user->password = bcrypt(request('password'));
				$user->user_type = 3; //driver
				$user->active = 0;
				$user->unique_id = MyLib::generateUserUniqueID();
				$user->moderate_profile = 1;

				$user->token = 'token-' . date("YmdHis", time()) . '-' . str_random(25);
			}

			$user->name = request('name');
			$user->country = 'Saudi Arabia';
			$user->city = request('city');
			$user->citizen_type = request('citizen_type');
			$user->mobile_no = request('mobile_no');
			$user->wallet = request('wallet') * (-1);
			//$user->machine_number = request('machine_number');

			if ($request->has('cnic_no')) {
				$user->cnic_no = request('cnic_no');
			}

			if ($request->has('car_plate')) {
				$user->car_plate = request('car_plate');
			}

			if ($request->has('license_expire_date')) {
				$user->license_expire_date = request('license_expire_date');
			}

			if ($request->has('car_modal_year')) {
				$user->car_modal_year = request('car_modal_year');
			}

			if ($user->save()) {
				if ($request->hasFile('profile_picture')) {
					$status = $this->saveWebImages($request, $user->id);
					// return json_decode(json_encode($status));
				}
				if ($request->hasFile('iqama_id_picture')) {
					$this->saveIqamaImages($request, $user->id);
				}
				if ($request->hasFile('istemara_picture')) {
					$this->saveOtherImages($request, $user->id, 'istemara_picture');
				}
				if ($request->hasFile('license_picture')) {
					$this->saveOtherImages($request, $user->id, 'license_picture');
				}
				if ($request->hasFile('insurance_picture')) {
					$this->saveOtherImages($request, $user->id, 'insurance_picture');
				}
				if ($request->hasFile('car_front_picture')) {
					$this->saveOtherImages($request, $user->id, 'car_front_picture');
				}
				if ($request->hasFile('car_back_picture')) {
					$this->saveOtherImages($request, $user->id, 'car_back_picture');
				}
				if ($request->hasFile('car_left_picture')) {
					$this->saveOtherImages($request, $user->id, 'car_left_picture');
				}
				if ($request->hasFile('car_right_picture')) {
					$this->saveOtherImages($request, $user->id, 'car_right_picture');
				}

				if ($request->has('driver_id')) {
					$this->connection->commit();
					return redirect()->route('manage_drivers')->with('status', 'Driver details has been successfully updated.');
				}
			} else {
				if ($request->has('driver_id')) {
					return redirect()->route('edit_driver', request('driver_id'))->withErrors(['Unable to update details.'])->withInput($request->input());
				} else {
					return redirect()->route('add_driver')->withErrors(['Unable to save driver.'])->withInput($request->input());
				}
			}

			////////////  send registration email  /////////////////////
			$data = json_decode(json_encode($user), true);
			$email_status = '';
			try
			{
				Mail::send('emails.emailverification', $data, function ($message) use ($data) {
					$message->from(env('MAIL_USERNAME', 'info@speeds.ws'));
					$message->to($data['email']);
					$message->subject('Registration Confirmation');
				});

				$email_status = 'OK';

			} catch (\Swift_TransportException $e) {
				$this->connection->rollBack();
				$email_status = 'Unable to send email on given email address.';
				return redirect()->route('add_driver')->withErrors(['Unable to send email.'])->withInput($request->input());
			}

			if ($email_status == 'OK') {
				$this->connection->commit();
				return redirect()->route('manage_drivers')->with('email_status', $email_status)->with('status', 'Driver registered successfully. Confirmation email has been sent to activate account.');
			} else {
				$this->connection->rollBack();
				return redirect()->route('add_driver')->withErrors(['Unable to send email.' . $email_status . ''])->withInput($request->input());
			}

		} catch (\Exception $e) {
			$this->connection->rollBack();
			return redirect()->route('add_driver')->withErrors(['Unable to register driver. ' . $e->getMessage()])->withInput($request->input());
		}
	}

	public function edit_driver($r_id) {

		try {
			// dd('Work in progress');
			$driver_id = decrypt($r_id);

			$title = "Update Driver";

			$driver = User::where('id', $driver_id)->first();

			if (!empty($driver)) {
				return view('adminlte.admin.add_driver', compact('title', 'driver'));
			}
		} catch (\Exception $e) {
			return redirect()->route('manage_drivers')->withErrors(['Unable to find driver details.']);
		}
	}

	public function saveWebImages(Request $request, $user_id) {

		$file = $request->file('profile_picture');

		if (!$file->isValid()) {
			return response()->json(['invalid_file_upload'], 400);
		}

		try

		{

			$filename = "user-" . $user_id . "-" . date("YmdHis", time()) . "." . $file->getClientOriginalExtension();

			$_imagename = url('/usersimages/' . $filename); //to store in db full path to pic

			$file->move("usersimages", $filename);

			DB::table('users')->where('id', $user_id)->update(['profile_picture' => $_imagename]);

			return $_imagename;

		} catch (\Exception $e) {

			return $e->getMessage();
			// dd($e->getMessage());

		}

	}

	public function saveIqamaImages(Request $request, $user_id) {

		$file = $request->file('iqama_id_picture');

		try
		{

			$filename = "user-" . $user_id . "-iqama_id_picture-" . date("YmdHis", time()) . "." . $file->getClientOriginalExtension();

			$_imagename = url('/usersimages/' . $filename); //to store in db full path to pic

			$file->move("usersimages", $filename);

			$this->connection->table('users')->where('id', $user_id)->update(['iqama_id_picture' => $_imagename]);

		} catch (Illuminate\Filesystem\FileNotFoundException $e) {

			dd($e);

		}

	}

	public function saveOtherImages(Request $request, $user_id, $column_name) {

		$file = $request->file($column_name);

		try
		{

			$filename = "user-" . $user_id . "-" . $column_name . '-' . date("YmdHis", time()) . "." . $file->getClientOriginalExtension();

			$_imagename = url('/usersimages/' . $filename); //to store in db full path to pic

			$file->move("usersimages", $filename);

			$this->connection->table('users')->where('id', $user_id)->update([$column_name => $_imagename]);

		} catch (Illuminate\Filesystem\FileNotFoundException $e) {

			dd($e);

		}

	}

	public function edit_account_status_modal(Request $request) {
		$user = User::where('id', $request->user_id)->first();
		$selected_restaurants = null;
		$selected_restaurants_ids = null;
		if (!empty($user)) {
			$restaurants = User::where('user_type', 2)->where('active', 1)->where('verified', 1)->get();
			if ($user->user_type == 5) //subadmin restaurant
			{
				$selected_restaurants = MyLib::getSubAdminRestaurants($user->id);
				$selected_restaurants_ids = $selected_restaurants->pluck('restaurant_id')->toArray();
			}

			return view('adminlte.admin.partials.links_edit_modal', compact('user', 'restaurants', 'selected_restaurants', 'selected_restaurants_ids'));
		} else {
			return redirect()->back();
		}
	}

	
	public function toggle_account_status($_user_id) {
		try {
			$user_id = decrypt($_user_id);
			$user = User::where('id', $user_id)->first();
			if (!empty($user)) {
				if($user->active == 1)
				{
					$user->active = 0;
				}
				else
				{
					$user->active = 1;
				}
				$user->save();
				return redirect()->back()->with('status', 'Account updated successfully.');
			} else {
				return redirect()->back()->withErrors(['User record not found.']);
			}
		} catch (\Exception $e) {
			return redirect()->back()->withErrors(['User record not found. ' . $e->getMessage() ]);
		}

	}

	public function update_account_status_post(Request $request) {

		$user_id = decrypt($request->user_id);
		$user = User::where('id', $user_id)->first();

		if (!empty($user)) {

			$user->active = request('active');
			$user->verified = request('email_status');

			//restaurant
			if ($user->user_type == 2) {
				$user->mini_distance = request('mini_distance');
				$user->mini_distance_charges = request('mini_distance_charges');
				$user->charges_per_km = request('charges_per_km');
			}
			//subadmin - restaurant
			elseif ($user->user_type == 5) {
				//delete old entries
				$oldRestaurants = SubadminRestaurant::where('user_id', $user->id)->delete();

				foreach ($request->restaurants as $key => $r) {
					$obj = new SubadminRestaurant;
					$obj->user_id = $user->id;
					$obj->restaurant_id = $r;
					$obj->active = 1;
					$obj->created_by = auth()->user()->id;
					$obj->created_at = \Carbon\Carbon::now();
					$obj->save();
				}
			}

			$user->save();
			return redirect()->back();

		} else {

			return redirect()->back();

		}

	}
}
