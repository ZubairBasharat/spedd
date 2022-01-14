<?php

Route::get('/clear', function () {

	Artisan::call('cache:clear');

	Artisan::call('config:clear');

	Artisan::call('route:clear');

	Artisan::call('view:clear');

	return 'cleared';

});

// Route::get('/test/time', function () {
// 	dd(\Carbon\Carbon::now());
// });

Route::get('change/locale/{locale}', 'UserController@change_locale')->name('change_locale');

Auth::routes();

Route::get('login/{locale?}', 'Auth\LoginController@show_login_form')->name('show_login_form');

Route::get('email/verification/{token}', 'API\ApiController@email_confirmation')->name('email_confirmation');

Route::post('email/resend', 'UserController@resend_activation_email')->name('resend_activation_email');

Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset.token');

Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('reset_password');

Route::post('user/save/register', 'UserController@user_register')->name('user_register');

Route::group(['middleware' => ['auth', 'locale']], function () {

	foreach (File::allFiles(__DIR__ . '/modules') as $partial) {

		require $partial->getPathname();

	}

	Route::get('/logout', function () {

		Auth::logout();

		return Redirect::to('login');

	});

	///////// user profile

	Route::get('/', 'DashboardController@index')->name('home');

	Route::get('/home', 'DashboardController@index')->name('home');

	Route::get('/dashboard', 'UserController@index')->name('user_profile');

	Route::get('/admin', 'UserController@admin_user_profile')->name('admin_user_profile');

	Route::get('user/details/{user_id}', 'UserController@user_details')->name('user_details');

	Route::post('user/profile/update', 'UserController@update_profile')->name('update_profile');

	Route::post('user/password/update', 'UserController@update_password')->name('update_password');

	Route::get('make/order', 'UserController@make_order')->name('make_order');
	Route::post('make/order', 'UserController@make_order_post')->name('make_order_post');
	Route::get('resend/order/{order_id}', 'UserController@resend_order')->name('resend_order');

	Route::get('orders/dashboard', 'UserController@orders_dashboard')->name('orders_dashboard');

	Route::get('order/details/{order_id}', 'UserController@order_details')->name('order_details');

	Route::get('admin/manage/restaurants', 'AdminController@manage_restaurants')->name('manage_restaurants');


	Route::get('change/subadmin/restaurant/{restaurant_id}', 'AdminController@change_subadmin_restaurant')->name('change_subadmin_restaurant');

	

	Route::get('restaurant/details/{id}', 'AdminController@restaurant_details')->name('restaurant_details');

	Route::get('admin/manage/drivers', 'AdminController@manage_drivers')->name('manage_drivers');



	Route::get('driver/details/{id}', 'AdminController@driver_details')->name('driver_details');

	Route::get('sale/report', 'UserController@sales_report')->name('sales_report');
	Route::post('sale/report', 'UserController@sales_report_post')->name('sales_report_post');

	Route::get('testmapicon', 'UserController@testmapicon')->name('testmapicon');

	///////////// Administration
	Route::group(['middleware' => 'isAdmin'], function () {

		Route::get('manage/restaurants/add', 'AdminController@add_restaurant')->name('add_restaurant');

		Route::post('manage/restaurants/add', 'AdminController@save_restaurant')->name('save_restaurant');

		Route::get('admin/manage/restaurant/edit/{restaurant_id}', 'AdminController@edit_restaurant')->name('edit_restaurant');
		
		Route::get('manage/drivers/add', 'AdminController@add_driver')->name('add_driver');

		Route::post('manage/drivers/add', 'AdminController@save_driver')->name('save_driver');

		Route::get('admin/manage/driver/edit/{driver_id}', 'AdminController@edit_driver')->name('edit_driver');
		
		Route::get('manage/subadmin/restaurant', 'AdminController@manage_restaurant_subadmins')->name('manage_restaurant_subadmins');

		Route::post('admin/add/restaurant/subadmin', 'AdminController@add_restaurant_subadmin')->name('add_restaurant_subadmin');

		Route::get('manage/sub_admins', 'AdminController@manage_subadmins')->name('manage_subadmins');

		Route::post('admin/add/subadmin', 'AdminController@add_subadmin')->name('add_subadmin');

		Route::get('manage/finance', 'AdminController@manage_finance_settings')->name('manage_finance_settings');

		Route::post('manage/finance', 'AdminController@manage_finance_settings_post')->name('manage_finance_settings_post');

		Route::post('admin/manage/account/status/modal', 'AdminController@edit_account_status_modal')->name('edit_account_status_modal');

		Route::post('admin/manage/update/account/status', 'AdminController@update_account_status_post')->name('update_account_status_post');

		Route::get('admin/manage/users', 'UserController@manage_users')->name('manage_users');

		Route::post('admin/manage/moderate/profiles/modal', 'UserController@edit_links_modal')->name('edit_links_modal');

		Route::get('admin/manage/disabled/profiles', 'UserController@disabled_profiles')->name('disabled_profiles');

		Route::get('admin/toggle/account/status/{user_id}', 'AdminController@toggle_account_status')->name('toggle_account_status');
	});

});
