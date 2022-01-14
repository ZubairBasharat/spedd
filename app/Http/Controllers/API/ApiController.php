<?php

namespace App\Http\Controllers\Api;

use App\FinanceSettings;
use App\Http\Controllers\Controller;
use App\Library\Common\MyLib;
use App\User;
use App\UserOrder;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Mail;
use Validator;

class APIController extends Controller {

	private $userstable;

	public function __construct() {

		$this->connection = DB::connection();

		$this->schema = 'u385705170_speedws';

		$this->userstable = $this->schema . '.users';

	}

	public function createuser(Request $request) {
		// dd($request);
		$validator = Validator::make($request->all(), [

			'first_name' => 'required|string',

			// 'last_name' => 'required|string',

			//'cnic_no' => 'required|string',

			'cnic_no' => 'nullable|string',

			//'citizen_type' => 'required|string',
			'citizen_type' => 'nullable|string',

			// 'city' => 'required|string',

			'car_plate' => 'nullable|string',

			'license_expire_date' => 'nullable',

			'car_modal_year' => 'nullable',

			// 'username' => 'required|string|unique:users',

			'email' => 'required|email|unique:users',

			'password' => 'required|min:8',

			'mobile_no' => 'required',

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
			$response['status'] = $this->wrapError($validator->messages());
			return $response;
		}

		try {

			ini_set('max_execution_time', 120);

			$user = new User();

			// $user->name = request('first_name') . ' ' . request('last_name');

			$user->name = request('first_name');

			$user->country = 'Saudi Arabia';

			// $user->city = request('city');
			$user->city = '';

			$user->citizen_type = request('citizen_type');

			// $user->username = request('username');
			$user->username = null;

			$user->email = request('email');

			$user->password = bcrypt(request('password'));

			$user->mobile_no = request('mobile_no');

			$user->user_type = 3; //driver

			$user->active = 0;

			$user->unique_id = MyLib::generateUserUniqueID();

			$user->moderate_profile = 1;

			$user->token = 'token-' . date("YmdHis", time()) . '-' . str_random(25);

			//$user->cnic_no = request('cnic_no');

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

				$data = json_decode(json_encode($user), true);

				$emailsent = $this->sendRegistrationEmail($data);

				$response['status'] = $this->wrapSuccess('User Successfully Saved. An activation email is sent to you on your email, Please activate your account. ' . $emailsent);

				$user = User::find($user->id);
				$data2 = [
					'id' => $user->id,
					'name' => $user->name,
					'username' => $user->username,
					'email' => $user->email,
					'email_verified' => $user->verified,
					'account_active' => $user->active,
					'mobile_no' => $user->mobile_no,
					'profile_picture' => $user->profile_picture,
					'iqama_id_picture' => $user->iqama_id_picture,
					'active_order_id' => $user->active_order_id,
					'istemara_picture' => $user->istemara_picture,
					'license_picture' => $user->license_picture,
					'car_right_picture' => $user->car_right_picture,
					'car_left_picture' => $user->car_left_picture,
					'car_back_picture' => $user->car_back_picture,
					'car_front_picture' => $user->car_front_picture,
					'insurance_picture' => $user->insurance_picture,
					'car_plate' => $user->car_plate,
					'license_expire_date' => $user->license_expire_date,
					'car_modal_year' => $user->car_modal_year,
					'city' => $user->city,
					'citizen_type' => $user->citizen_type,
					'country' => $user->country,
					'current_lat' => $user->current_lat,
					'current_lang' => $user->current_lang,
					'created_at' => $user->created_at,
				];
				$response['user'] = json_decode(json_encode($data2));

				return $response;
			} else {
				$response['status'] = $this->wrapError('Unable to register user. ');
				return $response;
			}

		} catch (\Exception $ex) {
			$response['status'] = $this->wrapError('Unable to make request. ' . $ex->getMessage());
			return $response;
		}

	}

	public function saveIqamaImages(Request $request, $user_id) {

		$file = $request->file('iqama_id_picture');

		try
		{

			$filename = "user-" . $user_id . "-iqama_id_picture-" . date("YmdHis", time()) . "." . $file->getClientOriginalExtension();

			$_imagename = url('/usersimages/' . $filename); //to store in db full path to pic

			$file->move("usersimages", $filename);

			$this->connection->table($this->userstable)->where('id', $user_id)->update(['iqama_id_picture' => $_imagename]);

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

			$this->connection->table($this->userstable)->where('id', $user_id)->update([$column_name => $_imagename]);

		} catch (Illuminate\Filesystem\FileNotFoundException $e) {

			dd($e);

		}

	}

	public function userlogin(Request $request) {

		$validator = Validator::make($request->all(), [

			'email' => 'required',

			'password' => 'required|string',

		]);

		if ($validator->fails()) {

			// $response['status'] = $validator->messages();

			$response['status'] = $this->wrapError($validator->messages());

			return $response;

		} else {

			$user = User::where('email', request('email'))->first();

			if (empty($user)) {

				$response['status'] = $this->wrapError('Login Failed. Please check credentials.');

				return $response;

			}

			if ($user->verified == 1) {
				if ($user->active == 1) {
					if ($user->user_type == 3) {
						if (Hash::check(request('password'), $user->password)) {

							$response['status'] = $this->wrapSuccess('Login Successful');
							$user = User::where('email', request('email'))->first();
							// $response['token'] = $user->token;
							$data = [
								'id' => $user->id,
								'name' => $user->name,
								'username' => $user->username,
								'email' => $user->email,
								'email_verified' => $user->verified,
								'account_active' => $user->active,
								'mobile_no' => $user->mobile_no,
								'active_order_id' => $user->active_order_id,
								'profile_picture' => $user->profile_picture,
								'iqama_id_picture' => $user->iqama_id_picture,
								'active_order_id' => $user->active_order_id,
								'istemara_picture' => $user->istemara_picture,
								'license_picture' => $user->license_picture,
								'car_right_picture' => $user->car_right_picture,
								'car_left_picture' => $user->car_left_picture,
								'car_back_picture' => $user->car_back_picture,
								'car_front_picture' => $user->car_front_picture,
								'insurance_picture' => $user->insurance_picture,
								'car_plate' => $user->car_plate,
								'license_expire_date' => $user->license_expire_date,
								'car_modal_year' => $user->car_modal_year,
								'city' => $user->city,
								'citizen_type' => $user->citizen_type,
								'is_driver_busy' => $user->is_driver_busy,
								'is_driver_online' => $user->is_driver_online,
								'device_type' => $user->device_type,
								'device_token' => $user->device_token,
								'api_token' => $user->token,
								'device_type' => $user->device_type,
								'current_lat' => $user->current_lat,
								'current_lang' => $user->current_lang,
								'created_at' => $user->created_at,
							];

							$response['user'] = json_decode(json_encode($data));

							return $response;

						} else {

							$response['status'] = $this->wrapError('Login Failed. Please check credentials.');

							return $response;

						}
					} else {
						$response['status'] = $this->wrapError('Your account is not registered as driver.');

						return $response;
					}

				} else {

					$response['status'] = $this->wrapError('Your account is not activated. Please activate your account and try again.');

					return $response;

				}
			} else {

				$response['status'] = $this->wrapError('Your email is not verified yet. Please confirm your email and try again.');
				return $response;
			}

		}

	}

	public function getFinancialSettings() {

		$data = FinanceSettings::first();

		if (empty($data)) {

			$response['status'] = $this->wrapError('No record found');

			return $response;

		}

		$response['status'] = $this->wrapSuccess('Record Found');

		$response['data'] = json_decode(json_encode($data));

		return $response;

	}

	public function userprofile($user_id) {

		$user = User::where('id', $user_id)

			->first();

		if (empty($user)) {

			$response['status'] = $this->wrapError('No record found');

			return $response;

		}

		$response['status'] = $this->wrapSuccess('Record Found');

		//$response['token'] = $user->token;

		// $response['user'] = json_decode(json_encode($user));
		$data = [
			'id' => $user->id,
			'name' => $user->name,
			'username' => $user->username,
			'email' => $user->email,
			'email_verified' => $user->verified,
			'account_active' => $user->active,
			'mobile_no' => $user->mobile_no,
			'profile_picture' => $user->profile_picture,
			'iqama_id_picture' => $user->iqama_id_picture,
			'active_order_id' => $user->active_order_id,
			'istemara_picture' => $user->istemara_picture,
			'license_picture' => $user->license_picture,
			'car_right_picture' => $user->car_right_picture,
			'car_left_picture' => $user->car_left_picture,
			'car_back_picture' => $user->car_back_picture,
			'car_front_picture' => $user->car_front_picture,
			'insurance_picture' => $user->insurance_picture,
			'car_plate' => $user->car_plate,
			'license_expire_date' => $user->license_expire_date,
			'car_modal_year' => $user->car_modal_year,
			'city' => $user->city,
			'citizen_type' => $user->citizen_type,
			'is_driver_busy' => $user->is_driver_busy,
			'is_driver_online' => $user->is_driver_online,
			'device_type' => $user->device_type,
			'device_token' => $user->device_token,
			'device_type' => $user->device_type,
			'current_lat' => $user->current_lat,
			'current_lang' => $user->current_lang,
			'created_at' => $user->created_at,
		];

		$response['user'] = json_decode(json_encode($data));

		return $response;

	}

	public function uploadprofilepicture(Request $request) {

		$validator = Validator::make($request->all(), [

			'user_id' => 'required|numeric',

			'profile_picture' => ['mimes:jpeg,png,jpg,bmp', 'max:4096'],

		]);

		if ($validator->fails()) {

			$response['status'] = $this->wrapError($validator->messages());

			return $response;

		} else {

			$user = User::where('id', $request->user_id)->first();

			if (empty($user)) {

				$response['status'] = $this->wrapError('No record found.');

				return $response;

			}

			$response['status'] = $this->wrapSuccess('Profile Picture Updated.');

			$this->saveWebImages($request, $request->user_id);

			//$response['token'] = $user->token;

			$data = [
				'id' => $user->id,
				'name' => $user->name,
				'username' => $user->username,
				'email' => $user->email,
				'email_verified' => $user->verified,
				'account_active' => $user->active,
				'mobile_no' => $user->mobile_no,
				'profile_picture' => $user->profile_picture,
				'active_order_id' => $user->active_order_id,
				'iqama_id_picture' => $user->iqama_id_picture,
				'istemara_picture' => $user->istemara_picture,
				'license_picture' => $user->license_picture,
				'car_right_picture' => $user->car_right_picture,
				'car_left_picture' => $user->car_left_picture,
				'car_back_picture' => $user->car_back_picture,
				'car_front_picture' => $user->car_front_picture,
				'insurance_picture' => $user->insurance_picture,
				'car_plate' => $user->car_plate,
				'license_expire_date' => $user->license_expire_date,
				'car_modal_year' => $user->car_modal_year,
				'city' => $user->city,
				'citizen_type' => $user->citizen_type,
				'is_driver_busy' => $user->is_driver_busy,
				'is_driver_online' => $user->is_driver_online,
				'device_type' => $user->device_type,
				'device_token' => $user->device_token,
				'device_type' => $user->device_type,
				'current_lat' => $user->current_lat,
				'current_lang' => $user->current_lang,
				'created_at' => $user->created_at,
			];

			$response['user'] = json_decode(json_encode($data));
			// $response['user'] = json_decode(json_encode($user));

			return $response;

		}

	}

	public function uploadprofilepicturenew(Request $request) {

		$validator = Validator::make($request->all(), [

			'user_id' => 'required|numeric',

			'profile_picture' => 'required',

		]);

		if ($validator->fails()) {

			$response['status'] = $this->wrapError($validator->messages());

			return $response;

		} else {

			$user = User::where('id', $request->user_id)

				->first();

			if (empty($user)) {

				$response['status'] = $this->wrapError('No record found.');

				return $response;

			}

			$response['status'] = $this->wrapSuccess('Profile Picture Updated.');

			$this->saveWebImagesNew($request->user_id);

			//$response['token'] = $user->token;

			$data = [
				'id' => $user->id,
				'name' => $user->name,
				'username' => $user->username,
				'email' => $user->email,
				'email_verified' => $user->verified,
				'account_active' => $user->active,
				'mobile_no' => $user->mobile_no,
				'profile_picture' => $user->profile_picture,
				'active_order_id' => $user->active_order_id,
				'iqama_id_picture' => $user->iqama_id_picture,
				'istemara_picture' => $user->istemara_picture,
				'license_picture' => $user->license_picture,
				'car_right_picture' => $user->car_right_picture,
				'car_left_picture' => $user->car_left_picture,
				'car_back_picture' => $user->car_back_picture,
				'car_front_picture' => $user->car_front_picture,
				'insurance_picture' => $user->insurance_picture,
				'car_plate' => $user->car_plate,
				'license_expire_date' => $user->license_expire_date,
				'car_modal_year' => $user->car_modal_year,
				'city' => $user->city,
				'citizen_type' => $user->citizen_type,
				'is_driver_busy' => $user->is_driver_busy,
				'is_driver_online' => $user->is_driver_online,
				'device_type' => $user->device_type,
				'device_token' => $user->device_token,
				'current_lat' => $user->current_lat,
				'current_lang' => $user->current_lang,
				'created_at' => $user->created_at,
			];

			$response['user'] = json_decode(json_encode($data));

			// $response['user'] = json_decode(json_encode($user));

			return $response;

		}

	}

	public function updateOrderStatus(Request $request) {

		$validator = Validator::make($request->all(), [
			'driver_id' => 'nullable|numeric',
			'status' => 'required',
			'device_type' => 'nullable',
			'order_id' => 'required|numeric',
			'active_order_id' => 'nullable|numeric',
		]);

		if ($validator->fails()) {
			$response['status'] = $this->wrapError($validator->messages());
			return $response;
		} else {
			$order = UserOrder::where('id', request('order_id'))->first();
			if (empty($order)) {
				$response['status'] = $this->wrapError('Order details not found.');
				return $response;
			}

			$response['status'] = $this->wrapSuccess('Record found.');

			$order->status = request('status');
			$order->device_type = request('device_type');
			
			if ($request->has('driver_id')) {
				$user = User::where('id', request('driver_id'))->first();
				if (request('status') == "Completed") {
					$user->is_driver_busy = 0;
					$user->active_order_id = 0;
					$order->completed_at = \Carbon\Carbon::now();

				} elseif (request('status') == "Accepted") {
					$order->driver_id = request('driver_id');
					$user->is_driver_busy = 1;
					$user->active_order_id = request('active_order_id');
					$order->accepted_at = \Carbon\Carbon::now();
				}
				elseif(request('status') == "Picked")
				{
					$order->picked_at = \Carbon\Carbon::now();	
				}
				$user->save();
			}
			$order->save();
					
			$order->active_order_id = request('active_order_id');
			$response['data'] = json_decode(json_encode($order));

			return $response;
		}

	}

	public function getOnlineStatus(Request $request) {

		$validator = Validator::make($request->all(), [

			'driver_id' => 'required|numeric',
		]);

		if ($validator->fails()) {

			// $response['status'] = $validator->messages();

			$response['status'] = $this->wrapError($validator->messages());

			return $response;

		} else {

			$user = User::where('id', request('driver_id'))->first();

			if (empty($user)) {

				$response['status'] = $this->wrapError('Driver details not found.');

				return $response;

			}

			$response['status'] = $this->wrapSuccess('Record found.');

			$data = [
				'id' => $user->id,
				'name' => $user->name,
				'username' => $user->username,
				'email' => $user->email,
				'email_verified' => $user->verified,
				'account_active' => $user->active,
				'mobile_no' => $user->mobile_no,
				'profile_picture' => $user->profile_picture,
				'active_order_id' => $user->active_order_id,
				'iqama_id_picture' => $user->iqama_id_picture,
				'istemara_picture' => $user->istemara_picture,
				'license_picture' => $user->license_picture,
				'car_right_picture' => $user->car_right_picture,
				'car_left_picture' => $user->car_left_picture,
				'car_back_picture' => $user->car_back_picture,
				'car_front_picture' => $user->car_front_picture,
				'insurance_picture' => $user->insurance_picture,
				'car_plate' => $user->car_plate,
				'license_expire_date' => $user->license_expire_date,
				'car_modal_year' => $user->car_modal_year,
				'city' => $user->city,
				'citizen_type' => $user->citizen_type,
				'is_driver_busy' => $user->is_driver_busy,
				'is_driver_online' => $user->is_driver_online,
				'device_type' => $user->device_type,
				'device_token' => $user->device_token,
				'current_lat' => $user->current_lat,
				'current_lang' => $user->current_lang,
				'created_at' => $user->created_at,
			];

			$response['user'] = json_decode(json_encode($data));

			return $response;
		}

	}

	public function updateDeviceToken(Request $request) {

		$validator = Validator::make($request->all(), [

			'driver_id' => 'required|numeric',
			'device_token' => 'required',
			'device_type' => 'required',
		]);

		if ($validator->fails()) {

			// $response['status'] = $validator->messages();

			$response['status'] = $this->wrapError($validator->messages());

			return $response;

		} else {

			$user = User::where('id', request('driver_id'))->first();

			if (empty($user)) {

				$response['status'] = $this->wrapError('Driver details not found.');

				return $response;

			}

			$response['status'] = $this->wrapSuccess('Record found.');

			$user->device_token = request('device_token');
			$user->device_type = request('device_type');
			$user->save();

			$data = [
				'id' => $user->id,
				'name' => $user->name,
				'username' => $user->username,
				'email' => $user->email,
				'email_verified' => $user->verified,
				'account_active' => $user->active,
				'mobile_no' => $user->mobile_no,
				'profile_picture' => $user->profile_picture,
				'active_order_id' => $user->active_order_id,
				'iqama_id_picture' => $user->iqama_id_picture,
				'istemara_picture' => $user->istemara_picture,
				'license_picture' => $user->license_picture,
				'car_right_picture' => $user->car_right_picture,
				'car_left_picture' => $user->car_left_picture,
				'car_back_picture' => $user->car_back_picture,
				'car_front_picture' => $user->car_front_picture,
				'insurance_picture' => $user->insurance_picture,
				'car_plate' => $user->car_plate,
				'license_expire_date' => $user->license_expire_date,
				'car_modal_year' => $user->car_modal_year,
				'city' => $user->city,
				'citizen_type' => $user->citizen_type,
				'is_driver_busy' => $user->is_driver_busy,
				'is_driver_online' => $user->is_driver_online,
				'device_token' => $user->device_token,
				'device_type' => $user->device_type,
				'current_lat' => $user->current_lat,
				'current_lang' => $user->current_lang,
				'created_at' => $user->created_at,
			];

			$response['user'] = json_decode(json_encode($data));

			return $response;
		}

	}

	public function updateOnlineStatus(Request $request) {

		$validator = Validator::make($request->all(), [

			'driver_id' => 'required|numeric',
			'status' => 'required|numeric',
		]);

		if ($validator->fails()) {

			// $response['status'] = $validator->messages();

			$response['status'] = $this->wrapError($validator->messages());

			return $response;

		} else {

			$user = User::where('id', request('driver_id'))->first();

			if (empty($user)) {

				$response['status'] = $this->wrapError('Driver details not found.');

				return $response;

			}

			$response['status'] = $this->wrapSuccess('Record found.');

			$user->is_driver_online = request('status');
			$user->save();

			$data = [
				'id' => $user->id,
				'name' => $user->name,
				'username' => $user->username,
				'email' => $user->email,
				'email_verified' => $user->verified,
				'account_active' => $user->active,
				'mobile_no' => $user->mobile_no,
				'profile_picture' => $user->profile_picture,
				'active_order_id' => $user->active_order_id,
				'iqama_id_picture' => $user->iqama_id_picture,
				'istemara_picture' => $user->istemara_picture,
				'license_picture' => $user->license_picture,
				'car_right_picture' => $user->car_right_picture,
				'car_left_picture' => $user->car_left_picture,
				'car_back_picture' => $user->car_back_picture,
				'car_front_picture' => $user->car_front_picture,
				'insurance_picture' => $user->insurance_picture,
				'car_plate' => $user->car_plate,
				'license_expire_date' => $user->license_expire_date,
				'car_modal_year' => $user->car_modal_year,
				'city' => $user->city,
				'citizen_type' => $user->citizen_type,
				'is_driver_busy' => $user->is_driver_busy,
				'is_driver_online' => $user->is_driver_online,
				'device_token' => $user->device_token,
				'device_type' => $user->device_type,
				'current_lat' => $user->current_lat,
				'current_lang' => $user->current_lang,
				'created_at' => $user->created_at,
			];

			$response['user'] = json_decode(json_encode($data));

			return $response;
		}

	}

	public function updateDriverLocation(Request $request) {

		$validator = Validator::make($request->all(), [

			'driver_id' => 'required|numeric',
			'latitude' => 'required',
			'longitude' => 'required',
		]);

		if ($validator->fails()) {

			// $response['status'] = $validator->messages();

			$response['status'] = $this->wrapError($validator->messages());

			return $response;

		} else {

			$user = User::where('id', request('driver_id'))->first();

			if (empty($user)) {

				$response['status'] = $this->wrapError('Driver details not found.');

				return $response;

			}

			$response['status'] = $this->wrapSuccess('Record found.');

			$user->current_lat = request('latitude');
			$user->current_lang = request('longitude');
			$user->save();

			$data = [
				'id' => $user->id,
				'name' => $user->name,
				'username' => $user->username,
				'email' => $user->email,
				'email_verified' => $user->verified,
				'account_active' => $user->active,
				'mobile_no' => $user->mobile_no,
				'profile_picture' => $user->profile_picture,
				'active_order_id' => $user->active_order_id,
				'iqama_id_picture' => $user->iqama_id_picture,
				'istemara_picture' => $user->istemara_picture,
				'license_picture' => $user->license_picture,
				'car_right_picture' => $user->car_right_picture,
				'car_left_picture' => $user->car_left_picture,
				'car_back_picture' => $user->car_back_picture,
				'car_front_picture' => $user->car_front_picture,
				'insurance_picture' => $user->insurance_picture,
				'car_plate' => $user->car_plate,
				'license_expire_date' => $user->license_expire_date,
				'car_modal_year' => $user->car_modal_year,
				'city' => $user->city,
				'citizen_type' => $user->citizen_type,
				'is_driver_busy' => $user->is_driver_busy,
				'is_driver_online' => $user->is_driver_online,
				'device_token' => $user->device_token,
				'device_type' => $user->device_type,
				'current_lat' => $user->current_lat,
				'current_lang' => $user->current_lang,
				'created_at' => $user->created_at,
			];

			$response['user'] = json_decode(json_encode($data));

			return $response;
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

	public function saveWebImagesNew($user_id) {

		$file = request('profile_picture');

		try

		{

			$image = base64_decode($file);

			$imageName = "user-" . $user_id . "-" . date("YmdHis", time()) . ".png";

			$path = public_path() . "/usersimages/" . $imageName;

			file_put_contents($path, $image);

			$path_for_db = url("/usersimages/" . $imageName);

			$this->connection->table($this->userstable)->where('id', $user_id)->update(['profile_picture' => $path_for_db]);

		} catch (Illuminate\Filesystem\FileNotFoundException $e) {

			dd($e);

		}

	}

	public function forgotpassword(Request $request) {

		$validator = Validator::make($request->all(), [

			'email' => 'required',

		]);

		if ($validator->fails()) {

			$response['status'] = $this->wrapError($validator->messages());

			return $response;

		} else {

			if ($user = User::where('email', $request->input('email'))->first()) {

				//$token = Str::random(60);

				$token = app(\Illuminate\Auth\Passwords\PasswordBroker::class)->createToken($user);

				$user->token = $token;

				$user->save();

				//'token'=> 'FiSpedqSHR6CQ8KjWPMOMsnvUEuJ1lx9eaafYCiZ'//hash('sha256', $token)

				$data = [

					'email' => $request->email,

					'token' => $token,

				];

				//dd($data);

				$emailsent = $this->sendResetLinkEmail($data);

				if ($emailsent == 'ok') {
					$response['status'] = $this->wrapSuccess('Password reset email has been successfully sent to your account.');
				} else {
					$response['status'] = $this->wrapError($emailsent);
				}

			} else {

				$response['status'] = $this->wrapError('No user found against entered email.');

			}

		}

		return $response;

	}

	public function sendRegistrationEmail($data) {

		try
		{

			Mail::send('emails.emailverification', $data, function ($message) use ($data) {

				$message->from(env('MAIL_USERNAME', 'info@speeds.ws'));

				$message->to($data['email']);

				$message->subject('Registration Confirmation');

			});

			return 'Email has been successfully sent.';

		} catch (\Swift_TransportException $e) {
			return $e->getMessage();
		}

	}

	public function sendResetLinkEmail($data) {

		try
		{

			Mail::send('emails.passwordreset', $data, function ($message) use ($data) {

				$message->from(env('MAIL_USERNAME', 'info@speeds.ws'));

				$message->to($data['email']);

				$message->subject('Password Reset Email');

			});

			return 'ok';

		} catch (\Swift_TransportException $e) {
			return ('Unable to send email on given email address. ' . $e->getMessage());
		}

	}

	public function email_confirmation($token) {

		$user = User::where('token', $token)->first();

		if (!is_null($user)) {

			$user->verified = 1;

			// $user->active = 1;

			$user->token = '';

			$user->save();

			return view('emails.email_verified', compact('user'));
		}

		return redirect()->route('login')->withErrors(['Unable to activate your account.']);

	}

	public function updateuser(Request $request) {

		$user_id = request('id');

		$validator = Validator::make($request->all(), [

			'id' => 'required|numeric',

			'name' => 'required|string',

			'mobile_no' => 'required|string',

			'cnic_no' => 'required|string',

			'present_address' => 'required|string',

			'facebook_link' => 'nullable|' . Rule::unique('users')->ignore($user_id, 'id' ?? 'null'),

			'twitter_link' => 'nullable|' . Rule::unique('users')->ignore($user_id, 'id' ?? 'null'),

			'website_link' => 'nullable|' . Rule::unique('users')->ignore($user_id, 'id' ?? 'null'),

			'instagram_link' => 'nullable|' . Rule::unique('users')->ignore($user_id, 'id' ?? 'null'),

		]);

		if ($validator->fails()) {

			$response['status'] = $this->wrapError($validator->messages());

			return $response;

		}

		$user = User::find(request('id'));

		if (!empty($user)) {

			$user->mobile_no = request('mobile_no');

			$user->present_address = request('present_address');

			$user->cnic_no = request('cnic_no');

			if ($request->has('facebook_link')) {
				$user->facebook_link = request('facebook_link');
			}

			if ($request->has('twitter_link')) {
				$user->twitter_link = request('twitter_link');
			}

			if ($request->has('instagram_link')) {
				$user->instagram_link = request('instagram_link');
			}

			if ($request->has('website_link')) {
				$user->website_link = request('website_link');
			}

			$user->save();

			$response['status'] = $this->wrapSuccess('User Record Updated Successfully');

			$response['user'] = json_decode(json_encode($user));

		} else {

			$response['status'] = $this->wrapError('No user found against provided user-id.');

		}

		return $response;

	}

	public function deleteuser(Request $request) {

		$validator = Validator::make($request->all(), [

			'user_name' => 'required',

		]);

		if ($validator->fails()) {

			$response['status'] = $this->wrapError($validator->messages());

			return $response;

		}

		$user = User::where('username', request('user_name'))->first();

		if (!empty($user)) {

			$user->active = 0;

			$user->save();

			$response['status'] = $this->wrapSuccess('User Record Updated Successfully');

			$response['user'] = [

				'id' => $user->id,

				'name' => $user->name,

				'username' => $user->username,

				'Email' => $user->email,

				'Active' => $user->active,

			];

		} else {

			$response['status'] = $this->wrapError('No user found against provided user_name.');

		}

		return $response;

	}

	public function changepassword(Request $request) {

		$validator = Validator::make($request->all(), [

			'user_id' => 'required',

			//'new_password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*\d).+$/',

			'new_password' => 'required|min:8',

			'current_password' => 'required',

		]);

		if ($validator->fails()) {

			$response['status'] = $this->wrapError($validator->messages());

			return $response;

		} else {

			$user = User::where('id', request('user_id'))->first();

			if (empty($user)) {

				$response['status'] = $this->wrapError('No user record found.');

				return $response;

			}

			if (Hash::check(request('current_password'), $user->password)) {

				$user->password = bcrypt(request('new_password'));

				$user->save();

				$response['user'] = [

					'id' => $user->id,

					'name' => $user->name,

					'username' => $user->username,

					'Email' => $user->email,

				];

				$response['status'] = $this->wrapSuccess('Password Successfully Changed.');

				//$response['token'] = $user->token;

				return $response;

			} else {

				$response['status'] = $this->wrapError('Old Password, Not Matched.');

				return $response;

			}

		}

	}

	public function company_details() {

		$company = MyLib::getCompanyDetailsForAPI();

		if (empty($company)) {
			$response['status'] = $this->wrapError('No Record Found');
			return $response;
		}

		$response['status'] = $this->wrapSuccess('Record Found');

		$response['company'] = json_decode(json_encode($company));

		return $response;
	}

	public function users() {

		$users = MyLib::getActiveUsers();

		if (empty($users)) {

			$response['status'] = $this->wrapError('No Record Found');

			return $response;

		}

		$response['status'] = $this->wrapSuccess('Record Found');

		$response['users'] = json_decode(json_encode($users));

		return $response;

	}

	public function orders($driver_id) {

		$orders = UserOrder::join('users as u', 'u.id', 'orders.created_by')
					->select('orders.*', 'u.id as restaurant_id', 'u.name as restaurant_name', 'u.phone_number as restaurant_number', 'u.restaurant_location', 'u.profile_picture as restaurant_image')
					->where('driver_id', $driver_id)
					->get();

		if (empty($orders)) {

			$response['status'] = $this->wrapError('No Record Found');

			return $response;

		}

		$response['status'] = $this->wrapSuccess('Record Found');

		$response['orders'] = json_decode(json_encode($orders));

		return $response;

	}

	public function getDailyDriverStatistics($driver_id) {

		$user = User::where('id', $driver_id)->first();

		if (empty($user)) {
			$response['status'] = $this->wrapError('No driver record found.');
			return $response;
		}

		$orders = UserOrder::where('driver_id', $driver_id)->where('created_at', '>=', \Carbon\Carbon::today())->where('status', 'Completed')->count();

		$delivery_fee = UserOrder::where('driver_id', $driver_id)->where('created_at', '>=', \Carbon\Carbon::today())->where('status', 'Completed')->sum('delivery_fee');

		$wallet = $user->wallet;

		$enable = 0;
		$settings = FinanceSettings::first();

		//make max_due_amount negative
		$dueAmount = $settings->max_due_amount;
		if ($settings->max_due_amount > 0) {
			$dueAmount = (-1 * $settings->max_due_amount);
		}

		if ($user->wallet >= $dueAmount) {
			$enable = 1;
		}

		$response['status'] = $this->wrapSuccess('Record Found');

		$response['completed_orders'] = $orders;

		$response['delivery_fee'] = $delivery_fee;

		$response['wallet'] = $wallet;

		$response['enable'] = $enable;

		return $response;

	}

	public function getDriverStatistics($driver_id) {

		$user = User::where('id', $driver_id)->first();

		if (empty($user)) {
			$response['status'] = $this->wrapError('No driver record found.');
			return $response;
		}

		$orders = UserOrder::where('driver_id', $driver_id)->where('status', 'Completed')->count();

		$delivery_fee = UserOrder::where('driver_id', $driver_id)->where('status', 'Completed')->sum('delivery_fee');

		$response['status'] = $this->wrapSuccess('Record Found');

		$response['completed_orders'] = $orders;

		$response['delivery_fee'] = $delivery_fee;

		return $response;

	}

	public function getDriverActiveOrder($driver_id) {

		$user = User::where('id', $driver_id)->first();

		if (empty($user)) {
			$response['status'] = $this->wrapError('No driver record found.');
			return $response;
		}

		$order = UserOrder::where('id', $user->active_order_id)->first();
		if (empty($order)) {
			$response['status'] = $this->wrapError('No active order found.');
			return $response;
		}

		$response['status'] = $this->wrapSuccess('Active Order Found');

		$response['data'] = json_decode(json_encode($order));

		return $response;

	}

	public function logoutDriver($driver_id) {

		$user = User::where('id', $driver_id)->first();

		if (empty($user)) {
			$response['status'] = $this->wrapError('No driver record found.');
			return $response;
		}

		$response['status'] = $this->wrapSuccess('Record Found.');

		$user->is_driver_online = 0;
		$user->save();

		$data = [
			'id' => $user->id,
			'name' => $user->name,
			'username' => $user->username,
			'email' => $user->email,
			'email_verified' => $user->verified,
			'account_active' => $user->active,
			'mobile_no' => $user->mobile_no,
			'profile_picture' => $user->profile_picture,
			'active_order_id' => $user->active_order_id,
			'iqama_id_picture' => $user->iqama_id_picture,
			'istemara_picture' => $user->istemara_picture,
			'license_picture' => $user->license_picture,
			'car_right_picture' => $user->car_right_picture,
			'car_left_picture' => $user->car_left_picture,
			'car_back_picture' => $user->car_back_picture,
			'car_front_picture' => $user->car_front_picture,
			'insurance_picture' => $user->insurance_picture,
			'car_plate' => $user->car_plate,
			'license_expire_date' => $user->license_expire_date,
			'car_modal_year' => $user->car_modal_year,
			'city' => $user->city,
			'citizen_type' => $user->citizen_type,
			'is_driver_busy' => $user->is_driver_busy,
			'is_driver_online' => $user->is_driver_online,
			'device_token' => $user->device_token,
			'device_type' => $user->device_type,
			'current_lat' => $user->current_lat,
			'current_lang' => $user->current_lang,
			'created_at' => $user->created_at,
		];

		$response['data'] = json_decode(json_encode($data));

		return $response;

	}

	public function getOrderDetails($order_id) {

		$order = UserOrder::join('users as u', 'u.id', 'orders.created_by')
				->select('orders.*', 'u.id as restaurant_id', 'u.name as restaurant_name', 'u.phone_number as restaurant_number', 'u.restaurant_location', 'u.profile_picture as restaurant_image')
				->where('orders.id', $order_id)
				->first();

		if (empty($order)) {

			$response['status'] = $this->wrapError('No record found');

			return $response;

		}

		$response['status'] = $this->wrapSuccess('Record Found');

		$response['data'] = json_decode(json_encode($order));

		return $response;

	}

	public function usertypes() {

		$usertypes = MyLib::getUserTypesList();

		if (empty($usertypes)) {

			$response['status'] = $this->wrapError('No Record Found');

			return $response;

		}

		$response['status'] = $this->wrapSuccess('Record Found');

		$response['usertypes'] = json_decode(json_encode($usertypes));

		return $response;

	}

	public function findNearbyDriver(Request $request) {
		$latitude = request('latitude');
		$longitude = request('longitude');
		$radius = request('radius');
		$rawQuery = "users.* , ( 6371  * acos( cos( radians(" . $latitude . ") ) * cos( radians( current_lat ) ) * cos( radians( current_lang ) - radians(" . $longitude . ") ) + sin( radians(" . $latitude . ") ) * sin( radians( current_lat ) ) ) ) AS distance";

		$drivers = User::where('user_type', 3)
			->where('is_driver_busy', 0)
			->where('is_driver_online', 1)
			->where('active', 1)
			->where('verified', 1)
			->selectRaw($rawQuery)
			->having("distance", "<=", $radius)
			->orderBy("distance", 'asc')
			->get();
		// dd($drivers);
		if (empty($drivers)) {
			$response['status'] = $this->wrapError('No Record Found');
			$response['drivers'] = json_decode(json_encode($drivers));
			return $response;
		} elseif (count($drivers) == 0) {
			$response['status'] = $this->wrapError('No Record Found');
			$response['drivers'] = json_decode(json_encode($drivers));
			return $response;
		}

		//send notification  to drivers
		foreach ($drivers as $driver) {
			$reg_ids = $driver->device_token;
			$order_id = 0;
			$data = [
				"order" => $order_id,
			];

			$res = $this->sendPushNotification($reg_ids, "Test notification", "Test notification for " . $driver->id, $data);
			//end notification
		}

		$response['status'] = $this->wrapSuccess('Record Found');

		$response['drivers'] = json_decode(json_encode($drivers));

		return $response;
	}

	public function findNearbyRestaurants(Request $request) {
		$latitude = request('latitude');
		$longitude = request('longitude');
		$radius = 10;
		$rawQuery = "users.* , ( 6371  * acos( cos( radians(" . $latitude . ") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(" . $longitude . ") ) + sin( radians(" . $latitude . ") ) * sin( radians( latitude ) ) ) ) AS distance";

		$restaurants = User::where('user_type', 2)
			->where('active', 1)
			->where('verified', 1)
			->selectRaw($rawQuery)
			->having("distance", "<=", $radius)
			->orderBy("distance", 'asc')
			->get();
		// dd($drivers);
		if (empty($restaurants)) {
			$response['status'] = $this->wrapError('No Record Found');
			$response['restaurants'] = json_decode(json_encode($restaurants));
			return $response;
		} elseif (count($restaurants) == 0) {
			$response['status'] = $this->wrapError('No Record Found');

			$response['restaurants'] = json_decode(json_encode($restaurants));
			return $response;
		}

		$response['status'] = $this->wrapSuccess('Record Found');

		$response['restaurants'] = json_decode(json_encode($restaurants));

		return $response;
	}

	public static function sendPushNotification($reg_ids, $title, $message, $data = array()) {
		// $API_ACCESS_KEY = 'AAAAg-EwI40:APA91bG_P0Vfi5nTV0xL4PEPEqPPouO5HHmqJwwkk6RrHmr4_CDUfRYtISgvdpcGGihkYikL5dzpKCEij6_hSxXuI2N7vRO7MLpRWXUszF0t-gs6hpZldn6LB5FA_U3SY5BezkxNfNG6';

		try {

			$API_ACCESS_KEY = 'AAAARaAgIeo:APA91bF4y0iJR5OWyfaUG4YON3VnOHGOZHx-x_FFsw2_ZtjOSew9cirQqEX7PBrinzbPiaSDYsOTgaFD_adUwMCKRi5XpSnCgz8xZO0k1CpPCFlpzbl342sDZoiG-l-aceFxlHIQa_Ml';

			//  for ANDROID only
			// 			$order_id = 0;
			// 			$data["notification"] = [
			// 				"title" => $title,
			// 				"body" => $message,
			// 				"sound" => 'jingle_bells_sms.wav',
			// 				"priority" => "high",
			// 				"order_id" => $order_id,
			// 				"click_action" => ".appUI.Main.TabBarController",
			// 			];

// 			$temp[0] = $reg_ids;
			// 			$fields = array
			// 				(
			// 				'registration_ids' => $temp,
			// 				'data' => $data,
			// 				'priority' => 'high',
			// 				'notification' => array(
			// 					'body' => $message,
			// 					'title' => $title,
			// 					'sound' => 'jingle_bells_sms.wav', //'default',
			// 					'icon' => 'icon',
			// 					//  'badge' => '1'

// 				),
			// 			);

			//  for ANDROID only
			$order_id = $data['order_id'];
			// $data["notification"] = [
			// 	"title" => $title,
			// 	"body" => $message,
			// 	"sound" => 'default',
			// 	"priority" => "high",
			// 	"order_id" => $order_id,
			// 	"click_action" => '.appUI.Main.TabBarController',
			// ];

			$temp[0] = $reg_ids;
			$fields = array
				(
				'registration_ids' => $temp,
				'data' => $data,
				'priority' => 'high',
				'notification' => array(
					'body' => $message,
					'title' => $title,
					'sound' => 'default',
					"priority" => "high",
					'icon' => 'icon',
					"order_id" => $order_id,
					"click_action" => '.appUI.Main.TabBarController',
					//  'badge' => '1'

				),
				'apns' => array(
					'payload' => array(
						'headers' => array
						(
							'apns-priority' => "10",
						),
						'aps' => array
						(
							'category' => "new_order",
							'order_id' => $order_id,
							'alert' => array
							(
								'body' => $message,
							),
						),
					),
				),

				'android' => array(
					'priority' => 'high',
					'notification' => array(
						'click_action' => '.appUI.Main.TabBarController',
					),
				),

				'webpush' => array(
					'headers' => array(
						'TTL' => '4500',
					),
				),

			);

			$headers = array
				(
				'Authorization: key=' . $API_ACCESS_KEY,
				'Content-Type: application/json',
			);
			//echo json_encode( $fields); die();
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
			$result = curl_exec($ch);
			//var_dump($result); die();
			file_put_contents("../fcmlog.txt", $result);
			curl_close($ch);
			return $result;
		} catch (\Exception $e) {
			dd($e->getMessage());
			return $e->getMessage();
		}
	}

	////////////////////// wraping error and success messages

	public function wrapError($message) {

		$str = '';

		$count = 1;

		if (is_array($message) || is_object($message)) {

			$arr = $message->toArray();

			foreach ($arr as $key => $value) {

				$str .= $value[0];

				if (count($arr) != $count) {

					$str .= "\n";

					$count++;

				}

			}

		} else {

			$str = $message;

		}

		$error = [

			'code' => '601',

			'type' => 'error',

			'message' => $str,

		];

		return $error;

	}

	public function wrapSuccess($message) {

		$error = [

			'code' => '200',

			'type' => 'success',

			'message' => $message,

		];

		return $error;

	}

}
