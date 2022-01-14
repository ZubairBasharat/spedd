<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

// Route::group(['middleware' => 'cors'], function () {

// });
header("Access-Control-Allow-Origin: *");

////////////////////////// USER
////////////////////////// GET
Route::get('/orders/listing/{driver_id}', 'API\ApiController@orders');
Route::get('/users/listing', 'API\ApiController@users');
Route::get('/user/types/listing', 'API\ApiController@usertypes');
Route::get('/get/order/details/{order_id}', 'API\ApiController@getOrderDetails');
Route::get('/get/driver/active/order/{driver_id}', 'API\ApiController@getDriverActiveOrder');

Route::get('/user/profile/{user_id}', 'API\ApiController@userprofile');
Route::get('/user/email/verification/{token}', 'API\ApiController@email_confirmation')->name('email_confirmation');

Route::get('/company/details', 'API\ApiController@company_details');
Route::get('/get/driver/statistics/{driver_id}', 'API\ApiController@getDriverStatistics');

Route::get('/get/daily/driver/statistics/{driver_id}', 'API\ApiController@getDailyDriverStatistics');

Route::get('/logout/driver/{driver_id}', 'API\ApiController@logoutDriver');

//////////////////// POST
Route::post('/user/login', 'API\ApiController@userlogin');
Route::post('/user/password/update', 'API\ApiController@changepassword');
Route::post('/user/password/forgot', 'API\ApiController@forgotpassword');

Route::post('/driver/register', 'API\ApiController@createuser');
Route::post('/driver/update/online/status', 'API\ApiController@updateOnlineStatus');
Route::post('/update/order/status', 'API\ApiController@updateOrderStatus');
Route::post('/driver/get/online/status', 'API\ApiController@getOnlineStatus');
Route::post('/driver/update/device/token', 'API\ApiController@updateDeviceToken');
Route::get('/get/financial/settings', 'API\ApiController@getFinancialSettings');

Route::post('/user/update', 'API\ApiController@updateuser');
Route::post('/user/delete', 'API\ApiController@deleteuser');
Route::post('/user/picture/update', 'API\ApiController@uploadprofilepicture');
Route::post('/user/picture/update/new', 'API\ApiController@uploadprofilepicturenew');

Route::post('/driver/update/location', 'API\ApiController@updateDriverLocation');
Route::post('/find/nearby/driver', 'API\ApiController@findNearbyDriver');
Route::post('/find/nearby/restaurants', 'API\ApiController@findNearbyRestaurants');
