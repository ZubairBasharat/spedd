<?php

namespace App\Http\Controllers;

use App;
use App\FinanceSettings;
use App\Library\Common\MyLib;
use App\User;
use App\UserOrder;
use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Mail;
use Validator;

class UserController extends Controller {

	protected $schema, $userstable;

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

		$this->schema = 'u385705170_speedws';

		$this->userstable = $this->schema . '.users';

	}

	public static function envUpdate($key, $value) {
		$path = base_path('.env');

		if (file_exists($path)) {

			file_put_contents($path, str_replace(
				$key . '=' . env($key), $key . '=' . $value, file_get_contents($path)
			));
		}
	}

	public function change_locale($locale) {

		if ($locale == 'en' || $locale == 'ar') {
			// App::setlocale($locale);
			// $this->envUpdate("APP_LANG", $locale);
			\Session::put('locale', $locale);
		}
		return back();
	}

	public function index() {

		$user_id = auth()->user()->id;

		$u = User::find($user_id);

		$user = MyLib::getUsersDetails($user_id);

		$title = "Dashboard";

		if ($u->user_type == 2) //restaurant
		{
			$restaurants[0] = auth()->user();
			$drivers = User::join('orders as o', 'o.driver_id', 'users.id')
				->whereIn('o.status', ['Accepted', 'Pending'])
				->where('user_type', 3)
				->where('is_driver_online', 1)
				->where('o.created_by', auth()->user()->id)
				->get();

			$total_orders = UserOrder::where('created_by', auth()->user()->id)->count();
			$ongoing_orders = UserOrder::whereIn('status', ['Accepted', 'Pending'])->where('created_by', auth()->user()->id)->count();
			$completed_orders = UserOrder::where('status', 'Completed')->where('created_by', auth()->user()->id)->count();
		} elseif ($u->user_type == 4) //region subadmin
		{
			$restaurants = User::where('active', 1)->where('verified', 1)->where('user_type', 2)->where('region', auth()->user()->region)->get();

			$restaurants_ids = $restaurants->pluck('id')->toArray();
			// dd($restaurants);
			$drivers = User::join('orders as o', 'o.driver_id', 'users.id')->whereIn('o.status', ['Accepted', 'Pending'])->where('user_type', 3)->where('is_driver_online', 1)->whereIn('o.created_by', $restaurants_ids)->get();

			$total_orders = UserOrder::whereIn('created_by', $restaurants_ids)->count();
			$ongoing_orders = UserOrder::whereIn('status', ['Accepted', 'Pending'])->whereIn('created_by', $restaurants_ids)->count();
			// dd($ongoing_orders);
			$completed_orders = UserOrder::where('status', 'Completed')->whereIn('created_by', $restaurants_ids)->count();
			// dd($completed_orders);
		} elseif ($u->user_type == 5) //subadmin - restaurant
		{
			// dd(auth()->user()->selected_restaurant);
			$restaurants = User::where('id', auth()->user()->selected_restaurant)->get();

			$drivers = User::join('orders as o', 'o.driver_id', 'users.id')
				->whereIn('o.status', ['Accepted', 'Pending'])
				->where('o.created_by', auth()->user()->selected_restaurant)
				->where('user_type', 3)
				->where('is_driver_online', 1)
				->get();

			$total_orders = UserOrder::where('created_by', auth()->user()->selected_restaurant)->count();
			$ongoing_orders = UserOrder::whereIn('status', ['Accepted', 'Pending'])->where('created_by', auth()->user()->selected_restaurant)->count();
			$completed_orders = UserOrder::where('status', 'Completed')->where('created_by', auth()->user()->selected_restaurant)->count();
		} else //superadmin
		{
			return redirect()->route('admin_user_profile');
		}

		$markers = null;
		foreach ($drivers as $key => $d) {
			$markers[$key] = [
				'latLng' => [
					$d->current_lat,
					$d->current_lang,
				],
				'name' => $d->name,
				'id' => $d->id,
				'id_encrypted' => encrypt($d->id),
				'busy' => $d->is_driver_busy,
			];
		}

		$restaurant_markers = null;
		foreach ($restaurants as $key => $r) {
			$restaurant_markers[$key] = [
				'latLng' => [
					$r->latitude,
					$r->longitude,
				],
				'name' => $r->name,
				'id' => $r->id,
				'id_encrypted' => encrypt($r->id),
			];
		}

		return view('adminlte.user.newprofile', compact('user', 'title', 'markers', 'completed_orders', 'ongoing_orders', 'total_orders', 'restaurant_markers'));
	}

	public function admin_user_profile() {
		// dd('admin');
		$user_id = auth()->user()->id;

		$u = User::find($user_id);

		$user = MyLib::getUsersDetails($user_id);

		$title = "Dashboard";

		$total_orders = UserOrder::count();
		$ongoing_orders = UserOrder::whereIn('status', ['Accepted', 'Pending'])->count();
		$completed_orders = UserOrder::where('status', 'Completed')->count();
		$drivers = User::where('user_type', 3)->where('is_driver_online', 1)->get();
		$restaurants = User::where('active', 1)->where('verified', 1)->where('user_type', 2)->get();

		$markers = null;
		foreach ($drivers as $key => $d) {
			$markers[$key] = [
				'latLng' => [
					$d->current_lat,
					$d->current_lang,
				],
				'name' => $d->name,
				'id' => $d->id,
				'id_encrypted' => encrypt($d->id),
				'busy' => $d->is_driver_busy,
			];
		}

		$restaurant_markers = null;
		foreach ($restaurants as $key => $r) {
			$restaurant_markers[$key] = [
				'latLng' => [
					$r->latitude,
					$r->longitude,
				],
				'name' => $r->name,
				'id' => $r->id,
				'id_encrypted' => encrypt($r->id),
			];
		}

		$top_sale = $this->getTopSale();

		$top_drivers = $this->getTopDrivers();

		$pie_chart_data = $this->makePieChartData($top_drivers);

		// dd($top_sale);
		$daily_sales = $this->getDailySales();

		$weekly_sales = $this->getWeeklySales();

		$daily_orders = $this->getDailyOrders();

		$weekly_orders = $this->getWeeklyOrders();

		return view('adminlte.user.newprofile', compact('user', 'title', 'markers', 'completed_orders', 'ongoing_orders', 'total_orders', 'top_sale', 'pie_chart_data', 'daily_sales', 'weekly_sales', 'daily_orders', 'weekly_orders', 'restaurant_markers'));	
		
		// if(auth()->user()->id == 3)
		// {
		// 	return view('adminlte.user.test_newprofile', compact('user', 'title', 'markers', 'completed_orders', 'ongoing_orders', 'total_orders', 'top_sale', 'pie_chart_data', 'daily_sales', 'weekly_sales', 'daily_orders', 'weekly_orders', 'restaurant_markers'));	
		// }
		// return view('adminlte.user.newprofile', compact('user', 'title', 'markers', 'completed_orders', 'ongoing_orders', 'total_orders', 'top_sale', 'pie_chart_data', 'daily_sales', 'weekly_sales', 'daily_orders', 'weekly_orders', 'restaurant_markers'));
	}

	public function testmapicon() {
		// dd('admin');
		$user_id = auth()->user()->id;

		$u = User::find($user_id);

		$user = MyLib::getUsersDetails($user_id);

		$title = "Dashboard";

		$total_orders = UserOrder::count();
		$ongoing_orders = UserOrder::whereIn('status', ['Accepted', 'Pending'])->count();
		$completed_orders = UserOrder::where('status', 'Completed')->count();
		$drivers = User::where('user_type', 3)->where('is_driver_online', 1)->get();
		$restaurants = User::where('active', 1)->where('verified', 1)->where('user_type', 2)->get();

		$markers = null;
		foreach ($drivers as $key => $d) {
			$markers[$key] = [
				'latLng' => [
					$d->current_lat,
					$d->current_lang,
				],
				'name' => $d->name,
				'id' => $d->id,
				'id_encrypted' => encrypt($d->id),
				'busy' => $d->is_driver_busy,
			];
		}

		$restaurant_markers = null;
		$index = 0;
		foreach ($restaurants as $key => $r) {
			if($r->profile_picture != null)
			{
				$restaurant_markers[$index] = [
					'latLng' => [
						$r->latitude,
						$r->longitude,
					],
					'name' => $r->name,
					'id' => $r->id,
					'id_encrypted' => encrypt($r->id),
					'profile_picture' => $r->profile_picture,
				];
				$index++;
			}
			
		}

		// dd($restaurant_markers);
		$top_sale = $this->getTopSale();

		$top_drivers = $this->getTopDrivers();

		$pie_chart_data = $this->makePieChartData($top_drivers);

		// dd($top_sale);
		$daily_sales = $this->getDailySales();

		$weekly_sales = $this->getWeeklySales();

		$daily_orders = $this->getDailyOrders();

		$weekly_orders = $this->getWeeklyOrders();

		return view('adminlte.user.testmapicon', compact('user', 'title', 'markers', 'completed_orders', 'ongoing_orders', 'total_orders', 'top_sale', 'pie_chart_data', 'daily_sales', 'weekly_sales', 'daily_orders', 'weekly_orders', 'restaurant_markers'));
	}

	public function getWeeklySales() {
		$start_date = \Carbon\Carbon::today()->subDays(7);
		$end_date = \Carbon\Carbon::today()->endOfDay();

		$sales = DB::connection()->table('orders')->selectRaw('date(created_at) as date, sum(grand_total) as total')
			->where('created_at', '>=', $start_date)
			->where('created_at', '<=', $end_date)
			->groupBy('date')
			->orderBy('date')
			->get();

		// dd($sales);
		for ($i = 6; $i > 0; $i--) {
			$last7Days[] = date('Y-m-d', strtotime("-$i days"));
		}

		$last7Days[6] = (date('Y-m-d', strtotime(\Carbon\Carbon::now())));

		$result['labels'] = $last7Days;

		if (!empty($sales)) {
			foreach ($last7Days as $key => $day) {

				$sale = $sales->where('date', $day)->first();

				if (!empty($sale)) {
					$result['sales_data'][$key] = $sale->total;
				} else {
					$result['sales_data'][$key] = 0;
				}
			}
		} else {
			$result['sales_data'] = [0, 0, 0, 0, 0, 0, 0];
		}

		// dd($result['sales_data']);

		return $result;
	}

	public function getDailySales() {
		$sales = DB::connection()->table('orders')->selectRaw('HOUR(created_at) as hour, sum(grand_total) as total')
			->where('created_at', '>=', \Carbon\Carbon::today())
			->groupBy('hour')
			->orderBy('hour')
			->get();

		$result['12AM-06AM'] = 0;
		$result['06AM-12PM'] = 0;
		$result['12PM-06PM'] = 0;
		$result['06PM-12AM'] = 0;

		$result['labels'] = ['12AM-06AM', '06AM-12PM', '12PM-06PM', '06PM-12AM'];

		foreach ($sales as $key => $sale) {
			if ($sale->hour >= 0 && $sale->hour < 6) {
				$result['12AM-06AM'] += $sale->total;
			} elseif ($sale->hour >= 6 && $sale->hour < 12) {
				$result['06AM-12PM'] += $sale->total;
			} elseif ($sale->hour >= 12 && $sale->hour < 18) {
				$result['12PM-06PM'] += $sale->total;
			} elseif ($sale->hour >= 18 && $sale->hour < 24) {
				$result['06PM-12AM'] += $sale->total;
			}
		}

		$result['sales_data'] = [$result['12AM-06AM'], $result['06AM-12PM'], $result['12PM-06PM'], $result['06PM-12AM']];

		return $result;
	}

	public function getWeeklyOrders() {
		$start_date = \Carbon\Carbon::today()->subDays(7);
		$end_date = \Carbon\Carbon::today()->endOfDay();

		$sales = DB::connection()->table('orders')->selectRaw('date(created_at) as date, count(*) as total')
			->where('created_at', '>=', $start_date)
			->where('created_at', '<=', $end_date)
			->groupBy('date')
			->orderBy('date')
			->get();

		// dd($sales);
		for ($i = 6; $i > 0; $i--) {
			$last7Days[] = date('Y-m-d', strtotime("-$i days"));
		}

		$last7Days[6] = (date('Y-m-d', strtotime(\Carbon\Carbon::now())));

		$result['labels'] = $last7Days;

		if (!empty($sales)) {
			foreach ($last7Days as $key => $day) {

				$sale = $sales->where('date', $day)->first();

				if (!empty($sale)) {
					$result['sales_data'][$key] = $sale->total;
				} else {
					$result['sales_data'][$key] = 0;
				}
			}
		} else {
			$result['sales_data'] = [0, 0, 0, 0, 0, 0, 0];
		}

		// dd($result['sales_data']);

		return $result;
	}

	public function getDailyOrders() {
		$sales = DB::connection()->table('orders')->selectRaw('HOUR(created_at) as hour, count(*) as total')
			->where('created_at', '>=', \Carbon\Carbon::today())
			->groupBy('hour')
			->orderBy('hour')
			->get();

		$result['12AM-06AM'] = 0;
		$result['06AM-12PM'] = 0;
		$result['12PM-06PM'] = 0;
		$result['06PM-12AM'] = 0;

		$result['labels'] = ['12AM-06AM', '06AM-12PM', '12PM-06PM', '06PM-12AM'];

		foreach ($sales as $key => $sale) {
			if ($sale->hour >= 0 && $sale->hour < 6) {
				$result['12AM-06AM'] += $sale->total;
			} elseif ($sale->hour >= 6 && $sale->hour < 12) {
				$result['06AM-12PM'] += $sale->total;
			} elseif ($sale->hour >= 12 && $sale->hour < 18) {
				$result['12PM-06PM'] += $sale->total;
			} elseif ($sale->hour >= 18 && $sale->hour < 24) {
				$result['06PM-12AM'] += $sale->total;
			}
		}

		$result['sales_data'] = [$result['12AM-06AM'], $result['06AM-12PM'], $result['12PM-06PM'], $result['06PM-12AM']];

		return $result;
	}

	public function makePieChartData($top_drivers) {
		$colors = ['#f56954', '#00a65a', '#f39c12'];
		foreach ($top_drivers as $key => $r) {
			$data[$key] = [
				'value' => $r->total,
				'color' => $colors[$key],
				'highlight' => $colors[$key],
				'label' => $r->name,
				'driver_id' => $r->driver_id,
                'labelColor' => 'white',
                'labelFontSize' => '16'
			];
		}
		return $data;
	}

	public function getTopDrivers() {
		$drivers = UserOrder::join('users as u', 'u.id', 'orders.driver_id')
			->where('status', 'Completed')
			->select('driver_id', 'u.name', DB::raw('count(*) as total'))
			->groupby('driver_id', 'u.name')
			->orderby('total', 'desc')
			->limit(3)
			->get();
		return $drivers;
	}

	public function getTopSale() {
		$sale = UserOrder::join('users as u', 'u.id', 'orders.created_by')
			->join('users as d', 'd.id', 'orders.driver_id')
			->where('orders.created_at', '>=', \Carbon\Carbon::today())
			->where('status', 'Completed')
			->select('orders.*', 'u.name as restaurant_name', 'u.profile_picture', 'd.name as driver_name')
			->orderby('grand_total', 'desc')
			->first();
		return $sale;
	}

	public function user_details($_user_id) {
		$user_id = decrypt($_user_id);

		$u = User::find($user_id);

		$user = MyLib::getUsersDetails($user_id);

		$title = "User Details";

		return view('adminlte.user.user_details', compact('user', 'title'));
	}

	public function update_password(Request $request) {

		$validator = Validator::make($request->all(), [

			'current_password' => 'required',

			'password' => 'confirmed|min:8',

		]);

		if ($validator->fails()) {

			return redirect()->route('user_profile')->withErrors($validator->messages());

		}

		$user = User::find(auth()->user()->id);

		if (!empty($user)) {

			//if($user->password == bcrypt(request('current_password')))

			if (Hash::check(request('current_password'), $user->password)) {

				$user->password = bcrypt(request('password'));

				$user->save();

				return redirect()->route('user_profile')->with('status', 'Password successfully changed.');

			}

			return redirect()->route('user_profile')->withErrors(['Current password does not match.']);

		}

		return redirect()->route('user_profile')->withErrors(['Ubable to change password.']);

	}

	public function update_profile(Request $request) {

		$user_id = auth()->user()->id;

		$validator = Validator::make($request->all(), [

			'name' => 'required|string',

			'mobile_no' => 'required|string',

			'cnic_no' => 'required|string',

			'present_address' => 'required|string',

			'cnic_image_front' => 'nullable| mimes:jpeg,png,bmp,tiff,jpg |max:4096',

			'cnic_image_back' => 'nullable| mimes:jpeg,png,bmp,tiff,jpg |max:4096',

			'facebook_link' => 'nullable|' . Rule::unique('users')->ignore($user_id, 'id' ?? 'null'),

			'twitter_link' => 'nullable|' . Rule::unique('users')->ignore($user_id, 'id' ?? 'null'),

			'website_link' => 'nullable|' . Rule::unique('users')->ignore($user_id, 'id' ?? 'null'),

			'instagram_link' => 'nullable|' . Rule::unique('users')->ignore($user_id, 'id' ?? 'null'),

		]);

		if ($validator->fails()) {

			return redirect()->route('user_profile')->withErrors($validator->messages());

		}

		$user = User::find(auth()->user()->id);

		if (!empty($user)) {

			$user->name = request('name');

			$user->mobile_no = request('mobile_no');

			$user->cnic_no = request('cnic_no');

			$user->bank_name = request('bank_name');
			$user->branch_name = request('branch_name');
			$user->branch_code = request('branch_code');
			$user->account_number = request('account_number');
			$user->account_title = request('account_title');

			$user->present_address = request('present_address');

			$user->facebook_link = request('facebook_link');

			$user->twitter_link = request('twitter_link');

			$user->website_link = request('website_link');

			$user->instagram_link = request('instagram_link');

			$user->profile_picture = request('profile_picture');

			$user->moderate_profile = 1;

			$user->save();

			if (!empty(request('profile_picture'))) {
				$this->saveProfilePicture($user->id);
			}

			if (!empty(request('cnic_image_front'))) {
				$this->saveImage('users', 'cnic_image_front', $user->id);
			}

			if (!empty(request('cnic_image_back'))) {
				$this->saveImage('users', 'cnic_image_back', $user->id);
			}

			return redirect()->route('user_profile')->with('status', 'Profile successfully updated.');

		} else {

			return redirect()->route('user_profile')->withErrors(['Unable to update profile.']);

		}

	}

	public function make_order() {

		$user_id = auth()->user()->id;

		$u = User::find($user_id);

		$user = MyLib::getUsersDetails($user_id);

		$setting = FinanceSettings::first();

		$title = "Place Order";

		return view('adminlte.user.make_order', compact('user', 'title', 'setting'));
	}

	public function make_order_post(Request $request) {
		// dd($request);
		$validator = Validator::make($request->all(), [
			'pickup_address' => 'required',
			'dropoff_address' => 'required',
			'customer_name' => 'required',
			'customer_number' => 'required',
			// 'restaurant_name' => 'required',
			'order_amount' => 'required',
			'order_description' => 'required',
			'address' => 'required',
			'payment_method' => 'required',
		]);

		if ($validator->fails()) {
			return redirect()->route('make_order')->withErrors($validator->messages());
		}

		if ($request->pickup_address == 'undefined') {
			return redirect()->route('make_order')->withErrors(['Pickup location must not be null.']);
		}

		if ($request->pickup_latitude == null || $request->pickup_longitude == null) {
			return redirect()->route('make_order')->withErrors(['Pickup location must be selected from map.']);
		}

		if ($request->dropoff_address == 'undefined') {
			return redirect()->route('make_order')->withErrors(['Dropoff location must not be null.']);
		}

		if ($request->dropoff_latitude == null || $request->dropoff_longitude == null) {
			return redirect()->route('make_order')->withErrors(['Dropoff location must be selected from map.']);
		}

		try {
			$obj = new UserOrder();
			$obj->pickup_address = request('pickup_address');
			$obj->dropoff_address = request('dropoff_address');
			$obj->customer_name = request('customer_name');
			$obj->customer_number = request('customer_number');
			$obj->restaurant_name = auth()->user()->name;
			$obj->order_description = request('order_description');
			$obj->customer_address = request('address');
			$obj->pickup_latitude = request('pickup_latitude');
			$obj->pickup_longitude = request('pickup_longitude');
			$obj->dropoff_latitude = request('dropoff_latitude');
			$obj->dropoff_longitude = request('dropoff_longitude');
			$obj->order_amount = request('order_amount');
			$obj->delivery_fee = request('delivery_fee');
			$obj->grand_total = request('grand_total');
			$obj->distance = request('total_distance');
			$obj->status = 'Pending';
			$obj->payment_method = request('payment_method');
			$obj->created_by = auth()->user()->id;

			if ($obj->save()) {
				$radius = 10;
				$notify = MyLib::sendNotificationToDrivers($radius, $obj->pickup_latitude, $obj->pickup_longitude, $obj->id, $obj);

				$msg = 'Notification has been sent to drivers.';
				$resend_btn = 0;
				if ($notify == 'no') //driver not found //show resend button
				{
					$resend_btn = 1;
					$msg = 'Unable to find drivers with in 10 km. Please resend notification to search for the drivers again.';
				}

				return redirect()->route('make_order')->with('status', 'Order successfully saved. ' . $msg)->with('resend_btn', $resend_btn)->with('order_id', $obj->id);
			} else {
				return redirect()->route('make_order')->withErrors(['Unable to save order.']);
			}
		} catch (\Exception $e) {
			return redirect()->route('make_order')->withErrors(['Unable to save order. ' . $e->getMessage()]);
		}
	}

	public function sales_report() {

		$title = "Sale Report";
		//$title = __('adminlte.sales_report');

		if (auth()->user()->user_type == 2) //if restaurant
		{
			// $regions[0] = auth()->user()->region;
			$restaurants = null;
		} elseif (auth()->user()->user_type == 4) //subadmin - region
		{
			// $regions[0] = auth()->user()->region;
			$restaurants = User::where('active', 1)
				->where('verified', 1)
				->where('user_type', 2)
				->where('region', auth()->user()->region)
				->get();
		} elseif (auth()->user()->user_type == 5) //subadmin - restaurant
		{
			// $restaurants = MyLib::getSubAdminRestaurants(auth()->user()->id);
			// dd($restaurants);
			$restaurants = null;
		} else //superadmin
		{
			// $regions = [
			// 	'Al Bahah', 'Al Jawf', 'Mecca', 'Riyadh', 'Eastern Province', 'Jizan', 'Medina', 'Qasim', 'Tabuk', 'Hail', 'Narjan', 'Northern Borders'
			// ];

			$restaurants = User::where('active', 1)
				->where('verified', 1)
				->where('user_type', 2)
				->get();
		}
		return view('adminlte.user.sales_report', compact('title', 'restaurants'));
	}

	public function sales_report_post(Request $request) {
		// dd($request);

		$dt = new \DateTime('first day of January 2021');
		$carbon = Carbon::instance($dt);
		$minDate = $carbon->toDateTimeString();
		$maxDate = Carbon::today()->endOfDay()->toDateTimeString();

		if (!$request->from_date == null) {
			$minDate = $request->from_date;
		}

		if (!$request->to_date == null) {
			$date = new Carbon($request->to_date);
			$maxDate = $date->endOfDay();
		}

		if (auth()->user()->user_type == 2) //if restaurant
		{
			// $regions[0] = auth()->user()->region;
			$restaurants[0] = auth()->user()->id;
		} elseif (auth()->user()->user_type == 4) //subadmin
		{
			// $regions[0] = auth()->user()->region;
			if ($request->has('restaurant')) {
				$restaurants = request('restaurant');
			} else {
				$restaurants = User::where('active', 1)
					->where('verified', 1)
					->where('user_type', 2)
					->where('region', auth()->user()->region)
					->get()
					->pluck('id')
					->toArray();
			}
		} elseif (auth()->user()->user_type == 5) //subadmin - restaurant
		{
			// if ($request->has('restaurant')) {
			// 	$restaurants = request('restaurant');
			// } else {
			// 	$restaurants = SubadminRestaurant::where('active', 1)
			// 		->where('user_id', auth()->user()->id)
			// 		->get()
			// 		->pluck('restaurant_id')
			// 		->toArray();
			// }

			$restaurants[0] = auth()->user()->selected_restaurant;
		} else //superadmin
		{
			if ($request->has('restaurant')) {
				$restaurants = request('restaurant');
			} else {
				$restaurants = User::where('active', 1)
					->where('verified', 1)
					->where('user_type', 2)
					->get()
					->pluck('id')
					->toArray();
			}
		}

		$query = $this->connection->table('orders as uo')
			->join('users as u', 'u.id', 'uo.created_by')
			->select(
				'u.name',
				'u.region',
				DB::raw('count(uo.id) as total_orders'),
				DB::raw('sum(uo.grand_total) as grand_total'),
				DB::raw('sum(uo.order_amount) as order_amount'),
				DB::raw('sum(uo.delivery_fee) as delivery_fee')
			)
			->where('uo.status', 'Completed')
			->whereIn('u.id', $restaurants)
			->groupby('u.name', 'u.region');

		if ($minDate != null) {
			$query->where('uo.created_at', '>=', $minDate);
		}
		if ($maxDate != null) {
			$query->where('uo.created_at', '<=', $maxDate);
		}

		$data = $query->get();
		$title = "Sale Report";
		if (auth()->user()->user_type == 2) //if restaurant
		{
			// $regions[0] = auth()->user()->region;
			// $restaurants = User::find(auth()->user()->id);
			$restaurants = null;
		} elseif (auth()->user()->user_type == 4) //subadmin
		{
			// $regions[0] = auth()->user()->region;
			$restaurants = User::where('active', 1)
				->where('verified', 1)
				->where('user_type', 2)
				->where('region', auth()->user()->region)
				->get();
		} elseif (auth()->user()->user_type == 5) {
			$restaurants = MyLib::getSubAdminRestaurants(auth()->user()->id);
		} else //superadmin
		{
			// $regions = [
			// 	'Al Bahah', 'Al Jawf', 'Mecca', 'Riyadh', 'Eastern Province', 'Jizan', 'Medina', 'Qasim', 'Tabuk', 'Hail', 'Narjan', 'Northern Borders'
			// ];

			$restaurants = User::where('active', 1)
				->where('verified', 1)
				->where('user_type', 2)
				->get();
		}
		return view('adminlte.user.sales_report', compact('title', 'restaurants', 'data', 'minDate', 'maxDate'));
	}

	public function resend_order($order_id) {
		$obj = UserOrder::where('id', $order_id)->first();

		if (empty($obj)) {
			return redirect()->route('orders_dashboard')->withErrors(['Order details not found.']);
		}

		if ($obj->created_by != auth()->user()->id && auth()->user()->isAdmin != 1 && auth()->user()->user_type != 4) {
			return redirect()->route('orders_dashboard')->withErrors(['Order can only be resend again from creator/sub admin/admin account.']);
		}

		if ($obj->status != 'Pending') {
			return redirect()->route('orders_dashboard')->withErrors(['Order has already been sent.']);
		}

		$radius = 15;
		$notify = MyLib::sendNotificationToDrivers($radius, $obj->pickup_latitude, $obj->pickup_longitude, $obj->id, $obj);

		$msg = 'Notification has been sent to drivers.';
		$resend_btn = 0;
		if ($notify == 'no') //driver not found //show resend button
		{
			$resend_btn = 1;
			$msg = 'Unable to find drivers with in 15 km. Please resend notification to search for the drivers again.';
		}

		return redirect()->route('orders_dashboard')->with("status", $msg);
	}

	public function orders_dashboard() {

		$title = "Order Dashboard";
		if (auth()->user()->user_type == 2) //if restaurant
		{
			$data = UserOrder::where('created_by', auth()->user()->id)->get();
		} elseif (auth()->user()->user_type == 4) //subadmin
		{
			$restaurants = User::where('active', 1)->where('verified', 1)->where('region', auth()->user()->region)->get()->pluck('id')->toArray();
			$data = UserOrder::whereIn('created_by', $restaurants)->get();
		} elseif (auth()->user()->user_type == 5) //if subadmin-restaurant
		{
			$data = UserOrder::where('created_by', auth()->user()->selected_restaurant)->get();
		} else //superadmin
		{
			$data = UserOrder::all();
		}
		return view('adminlte.user.orders_dashboard', compact('title', 'data'));
	}

	public function order_details($_order_id) {
		try {
			$order_id = decrypt($_order_id);
		} catch (\Exception $e) {
			$order_id = 0;
		}

		// dd($order_id);
		$order = UserOrder::where('id', $order_id)->first();
// dd($order);
		if (!empty($order)) {
			$restaurant = User::where('id', $order->created_by)->first();
			$driver = User::where('id', $order->driver_id)->first();
			$title = "Order Details";
			return view('adminlte.user.order_details2', compact('order', 'restaurant', 'title', 'driver'));
		} else {
			return redirect()->route('orders_dashboard')->with("status", "No order details found.");
		}
	}

	public function user_register(Request $request) {

		$validator = Validator::make($request->all(), [

			'name' => 'required|string',
			'restaurant_type' => 'required',
			'phone_number' => 'required',
			'store_manager_name' => 'required',
			'store_manager_number' => 'required',
			'username' => 'required|string|unique:users',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:8|confirmed',
			'city' => 'required',
			'region' => 'required',
			'restaurant_location' => 'required',
			// 'latitude' => 'required',
			// 'longitude' => 'required',
			'commercial_reg_no' => 'required',
		]);

		if ($validator->fails()) {
			return redirect()->route('login')->withErrors($validator->messages())->with("open_register", true);
		}

		if ($request->latitude == null || $request->latitude == 'undefined' || $request->longitude == null || $request->longitude == 'undefined' || $request->restaurant_location == 'undefined') {
			return redirect()->route('login')->withErrors(['Please select restaurant location by typing in restaurant search.'])->withInput($request->input())->with("open_register", true);
		}

		$this->connection->beginTransaction();
		$email_status = "";

		try {

			$user = new User;
			$user->name = request('name');
			$user->username = request('username');
			$user->email = request('email');
			$user->password = bcrypt(request('password'));
			$user->restaurant_type = request('restaurant_type');
			$user->restaurant_location = request('restaurant_location');
			$user->latitude = request('latitude');
			$user->longitude = request('longitude');
			$user->phone_number = request('phone_number');
			$user->store_manager_number = request('store_manager_number');
			$user->store_manager_name = request('store_manager_name');
			$user->country = 'Saudi Arabia';
			$user->city = request('city');
			$user->region = request('region');
			$user->commercial_reg_no = request('commercial_reg_no');
			$user->unique_id = MyLib::generateUserUniqueID();

			$user->active = 0;
			$user->user_type = 2; //restaurant

			$user->moderate_profile = 1;

			$user->token = 'token-' . date("YmdHis", time()) . '-' . str_random(25);

			if ($user->save()) {
				$user->membership_no = 'SP-' . $user->id;
				if (!empty(request('profile_picture'))) {
					$this->saveProfilePicture($user->id);
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
				return redirect()->route('login')->withErrors(['Unable to send email.'])->with('email_status', $email_status);
			}

			if ($email_status == 'OK') {

				$this->connection->commit();

				return redirect()->route('login')->with('email_status', $email_status)->with('status', 'You have signedup successfully. Confirmation email has been sent. Please check your email.');
			} else {
				$this->connection->rollBack();
				return redirect()->route('login')->withErrors(['Unable to send email.' . $email_status . ''])->with('email_status', $email_status);
			}

		} catch (\Exception $e) {
			$this->connection->rollBack();
			return redirect()->route('login')->withErrors(['Unable to register. ' . $e->getMessage()])->with('email_status', $email_status);
		}
	}

	public function resend_activation_email(Request $request) {
		$validator = Validator::make($request->all(), [

			'email' => 'required|email|exists:users,email',
		]);

		if ($validator->fails()) {

			return redirect()->route('login')->withErrors(['This email does not exists. Please check your email.']);

		} else {
			$this->connection->beginTransaction();

			$email_status = "";

			try {

				$user = User::where('email', $request->email)->first();

				$user->token = 'token-' . date("YmdHis", time()) . '-' . str_random(25);

				$user->save();

				////////////  send registration email  /////////////////////

				$data = json_decode(json_encode($user), true);

				$email_status = $this->sendRegistrationEmail($data);

				if ($email_status == 'OK') {
					$this->connection->commit();

					return redirect()->route('login')->with('email_status', $email_status)->with('status', 'Confirmation email has been resent. Please check your email in inbox/spam. Consider new email for account activation.');
				} else {
					$this->connection->rollBack();
					return redirect()->route('login')->withErrors(['Unable to resend email.' . $email_status . ''])->with('email_status', $email_status);
				}

			} catch (\Exception $e) {
				$this->connection->rollBack();
				return redirect()->route('login')->withErrors(['Unable to resend email.'])->with('email_status', $email_status);
			}
		}
	}

	public function sendRegistrationEmail($data) {

		try

		{

			Mail::send('emails.emailverification', $data, function ($message) use ($data) {

				$message->from(env('MAIL_USERNAME', 'info@speeds.ws'));
				//$message->from('owner@claimtofameentertainment.com');

				$message->to($data['email']);

				$message->subject('Registration Confirmation');

			});

			return 'OK';

		} catch (\Swift_TransportException $e) {
			//dd($e);
			return redirect()->route('login')->withErrors(['Unable to send email on given email address.' . $e->getMessage()]);
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

			$this->connection->table($this->userstable)->where('id', $user_id)->update(['profile_picture' => $_imagename]);

		} catch (Illuminate\Filesystem\FileNotFoundException $e) {

			dd($e);

		}
	}

	public function manage_users() {

		$title = "Manage Users";

		$users = MyLib::getAllUsersList();

		return view('adminlte.user.manage_users', compact('title', 'users'));
	}

	public function disabled_profiles() {

		$title = "Disabled Profiles";

		$users = MyLib::getDisabledProfiles();

		return view('adminlte.user.disabled_profiles', compact('title', 'users'));

	}

	public function moderate_profiles() {

		$title = "Moderate Profiles";

		$users = MyLib::getModerateProfiles();

		return view('adminlte.user.moderate_profiles', compact('title', 'users'));

	}

	public function edit_links_modal(Request $request) {

		$user = User::where('id', $request->user_id)->first();

		if (!empty($user)) {

			return view('adminlte.user.admin_partials.links_edit_modal', compact('user'));

		} else {

			return redirect()->back();

		}

	}

	public function saveImage($tableName, $columnName, $id) {

		$file = request($columnName);

		try
		{
			$filename = "image-" . $columnName . "-" . date("YmdHis", time()) . "." . $file->getClientOriginalExtension();
			$_imagename = url('/usersimages/' . $filename); //to store in db full path to pic
			$file->move("usersimages", $filename);

			$this->connection->table($tableName)->where('id', $id)->update([$columnName => $_imagename]);
		} catch (Illuminate\Filesystem\FileNotFoundException $e) {
			dd($e);
		}
	}

}
