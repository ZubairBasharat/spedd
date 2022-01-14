<?php

namespace App\Library\Common;

use App\CompanyAPI;
use App\FinanceSettings;
use App\SubadminRestaurant;
use App\User;
use App\UserOrder;
use DB;

class MyLib {

	public static function sendNotificationToDrivers($radius, $latitude, $longitude, $order_id, UserOrder $order_obj) {

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

		$settings = FinanceSettings::first();
		//make max_due_amount negative
		$dueAmount = $settings->max_due_amount;
		if ($settings->max_due_amount > 0) {
			$dueAmount = (-1 * $settings->max_due_amount);
		}
		// dd($drivers);

		if (!empty($drivers)) {
			if (count($drivers) > 0) {
				foreach ($drivers as $driver) {
					//send notification  to driver if wallet is >= due amount
					if ($driver->wallet >= $dueAmount) {
						$reg_ids = $driver->device_token;
						$data = [
							"order_id" => $order_id,

							"order" => [
								"order_id" => $order_id,
								"order_description" => $order_obj->order_description,
								"order_amount" => $order_obj->order_amount,
								"delivery_fee" => $order_obj->delivery_fee,
								"grand_total" => $order_obj->grand_total,
								"status" => $order_obj->status,
								"pickup_address" => $order_obj->pickup_address,
								"pickup_latitude" => $order_obj->pickup_latitude,
								"pickup_longitude" => $order_obj->pickup_longitude,
								"dropoff_address" => $order_obj->dropoff_address,
								"dropoff_latitude" => $order_obj->dropoff_latitude,
								"customer_name" => $order_obj->customer_name,
								"customer_number" => $order_obj->customer_number,
								"restaurant_name" => $order_obj->restaurant_name,
								"restaurant_number" => auth()->user()->phone_number,
							],
						];

						$res = MyLib::sendPushNotification($reg_ids, "New Delivery Received", "New delivery is ready to pick.", $data, $order_id);
						//send notification
					}
				}
				return 'Notification has been sent to drivers.';
			} else {
				return 'no';
			}
		} else {
			return 'no';
		}
	}

	public static function sendPushNotification($reg_ids, $title, $message, $data = array(), $order_id) {
		// $API_ACCESS_KEY = 'AAAAg-EwI40:APA91bG_P0Vfi5nTV0xL4PEPEqPPouO5HHmqJwwkk6RrHmr4_CDUfRYtISgvdpcGGihkYikL5dzpKCEij6_hSxXuI2N7vRO7MLpRWXUszF0t-gs6hpZldn6LB5FA_U3SY5BezkxNfNG6';

		try {

			$API_ACCESS_KEY = 'AAAARaAgIeo:APA91bF4y0iJR5OWyfaUG4YON3VnOHGOZHx-x_FFsw2_ZtjOSew9cirQqEX7PBrinzbPiaSDYsOTgaFD_adUwMCKRi5XpSnCgz8xZO0k1CpPCFlpzbl342sDZoiG-l-aceFxlHIQa_Ml';

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

	public static function generateUserUniqueIDString() {

		$strength = 15;
		$random_string = '';
		$input = 'RSTUVWXYZFGABCDEFGHIJKCDEFGHIJKLMNOPQWXYZFGABCDEFGHIJKCDEFGHIJKLMNOPQRSTUVWXYZFGABCDEFGHIJKLMNOPQRSTUVWSTUVWXYZFGRSTUVWXYZFGABCDEFGHIJKLMNOPQRSWXYZFGABCDEFGHIJKCDEFGHIJKLMNOPQRSTUVWXYZFGABCDEFGHIJKLMNOPQRSJKLMNOPQWXYZFGABCDEFGHIJKCDEFGHIJKLMNOPQRSTUVWXYZFGATUVWSTUVWXYZFGTUVWSTUVWXYZFGHIJKLMNOWXYZFGABCDEFGHIJKCDEFGHIJKLJKLMNOPQWXYZFGABCDEFGHIJKCDEFGHIJKLMNOPQRSTUVWXYZFGAMNOPQRSTUVWXYZFGABCDEFGHIJKLMNOPQRSTUVWSTUVWXYZFGPQRSTUVWXYJKLMNOPQWXYZFGABCDEFGHIJKCDEFGHIJKLMNOPQRSTUVWXYZFGAZABCDEFGHIJKLMNOP';
		$input_length = strlen($input);

		for ($i = 0; $i < $strength; $i++) {
			$random_character = $input[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}

		if (MyLib::isStringUnique($random_string)) {
			return $random_string;
		} else {
			MyLib::generateUserUniqueIDString();
		}
	}

	public static function generateUserUniqueID() {

		$last_user = User::orderby('id', 'desc')->first();
		$last_user_id = $last_user->id;

		$start_from = 10000;

		$unique_id = $start_from + $last_user_id + 1;

		if (MyLib::isStringUnique($unique_id)) {
			return $unique_id;
		} else {
			MyLib::generateUserUniqueID();
		}
	}

	public static function isStringUnique($generated_string) {
		$user = User::where('unique_id', $generated_string)->first();

		if (empty($user)) {
			return true;
		} else {
			return false;
		}
	}

	public static function getCompanyDetails() {

		$result = null;

		$result = DB::connection()->table('company as e')
			->first();

		return $result;

	}

	public static function getCompanyDetailsForAPI() {

		$result = null;

		$result = CompanyAPI::first();

		return $result;

	}

	public static function getActiveUsers() {

		$result = null;

		$result = DB::connection()->table('users as e')

			->select(

				'e.id',

				'e.name',

				'e.username',

				'e.email',

				'e.active'

			)

			->where('e.active', 1)

			->get();

		return $result;

	}

	public static function getUsersList() {

		$result = null;

		$result = DB::connection()->table('users as e')

			->select(

				'e.id',

				'e.name',

				'e.username',

				'e.email',

				'e.region',

				'e.facebook_link',

				'e.youtube_link',

				'e.twitter_link',

				'e.website_link',

				'e.instagram_link',

				'e.profile_picture',

				'e.verified',

				'e.active',

				'e.created_at',

				'e.updated_at'

			)

			->where('e.active', 1)

			->get();

		return $result;

	}

	public static function getModerateProfiles() {

		$result = null;

		$result = DB::connection()->table('users as e')

			->select(

				'e.id',

				'e.name',

				'e.username',

				'e.email',

				'e.region',

				'e.facebook_link',

				'e.youtube_link',

				'e.twitter_link',

				'e.website_link',

				'e.instagram_link',

				'e.profile_picture',

				'e.active',

				'e.verified',

				'e.created_at',

				'e.updated_at'

			)

			->where('parent_id', 0)
			->where('sponsor_id', auth()->user()->id)

			->get();

		return $result;

	}

	public static function getDisabledProfiles() {

		$result = null;

		$result = DB::connection()->table('users as e')

			->join('user_types as ut', 'ut.id', 'e.user_type')

			->select(

				'e.id',

				'e.name',

				'e.username',

				'e.email',

				'e.region',

				'e.facebook_link',

				'e.youtube_link',

				'e.twitter_link',

				'e.website_link',

				'e.instagram_link',

				'e.profile_picture',

				'e.active',

				'e.verified',

				'e.created_at',

				'e.updated_at',

				'ut.title as user_type_title',

				'ut.description as user_type_description'

			)

			->where('e.active', '!=', 1)

			->get();

		return $result;

	}

	public static function getAllUsersList() {

		$result = null;

		$result = DB::connection()->table('users as e')

			->join('user_types as ut', 'ut.id', 'e.user_type')

			->select(

				'e.id',

				'e.name',

				'e.username',

				'e.email',

				'e.region',

				'e.facebook_link',

				'e.youtube_link',

				'e.twitter_link',

				'e.website_link',

				'e.instagram_link',

				'e.profile_picture',

				'e.active',

				'e.verified',

				'e.created_at',

				'e.updated_at',

				'ut.title as user_type_title',

				'ut.description as user_type_description'

			)

			->get();

		return $result;

	}

	public static function getAllDriversList() {
		$result = null;
		$result = DB::connection()->table('users as e')
			->join('user_types as ut', 'ut.id', 'e.user_type')
			->where('user_type', 3)
			->select(
				'e.*',
				'e.id',
				'ut.title as user_type_title',
				'ut.description as user_type_description'
			)
			->get();
		return $result;
	}

	public static function getAllRestaurantSubAdminList() {
		$result = null;
		$result = DB::connection()->table('users as e')
			->join('user_types as ut', 'ut.id', 'e.user_type')
			->where('user_type', 5)
			->select(
				'e.*',
				'e.id',
				'ut.title as user_type_title',
				'ut.description as user_type_description'
			)
			->get();

		if (!empty($result)) {
			foreach ($result as $key => $r) {
				$r->restaurants = MyLib::getSubAdminRestaurants($r->id);
			}
		}
		return $result;
	}

	public static function getSubAdminRestaurants($user_id) {
		$result = null;
		$result = SubadminRestaurant::join('users as u', 'u.id', 'subadmin_restaurants.restaurant_id')
			->where('user_id', $user_id)
			->where('subadmin_restaurants.active', 1)
			->select('u.id', 'u.name', 'subadmin_restaurants.id as subadmin_restaurants_id', 'subadmin_restaurants.restaurant_id')
			->get();
		return $result;
	}

	public static function getAllSubAdminList() {
		$result = null;
		$result = DB::connection()->table('users as e')
			->join('user_types as ut', 'ut.id', 'e.user_type')
			->where('user_type', 4)
			->select(
				'e.*',
				'e.id',
				'ut.title as user_type_title',
				'ut.description as user_type_description'
			)
			->get();
		return $result;
	}

	public static function getAllRestaurantsList() {
		$result = null;
		$result = DB::connection()->table('users as e')
			->join('user_types as ut', 'ut.id', 'e.user_type')
			->where('user_type', 2)
			->select(
				'e.*',
				'e.id',
				'ut.title as user_type_title',
				'ut.description as user_type_description'
			)
			->get();
		return $result;
	}

	public static function getUsersDetails($user_id) {

		$result = null;

		$result = DB::connection()->table('users as e')

			->leftjoin('users as u', 'u.id', 'e.parent_id')

			->leftjoin('users as u2', 'u2.id', 'e.sponsor_id')

			->where('e.id', $user_id)

			->select(

				'e.*',

				'u.name as parentname',

				'u2.name as sponsorname'

			)

		//->where('e.active', 1)

			->first();

		return $result;

	}

	public static function getUserTypesList() {

		$result = null;

		$result = DB::connection()->table('user_types as e')

			->select(

				'e.*'

			)

			->where('e.active', 1)

			->get();

		return $result;

	}

}
