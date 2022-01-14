<?php

namespace App\Http\Controllers\Auth;

use App;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Str;
use \Illuminate\Http\Request;

class LoginController extends Controller {

	use AuthenticatesUsers;

	/**

	 * Where to redirect users after login.

	 *

	 * @var string

	 */

	protected $redirectTo = '/home';

	/**

	 * Create a new controller instance.

	 *

	 * @return void

	 */

	public function __construct() {
		$this->middleware('guest')->except('logout');

		//if(strpos($_SERVER['REQUEST_URI'], 'public') === false) //if not public
		// {
		// 	$this->redirectTo = 'public/home';
		// }
		// else
		// {
		// 	$this->redirectTo = '/home';
		// }
		$this->redirectTo = '/home';
	}

	public function username() {

		return 'username';

	}

	public function view() {

		return view('auth.login');

	}

	/**

	 * Get the needed authorization credentials from the request.

	 *

	 * @param  \Illuminate\Http\Request  $request

	 * @return array

	 */

	// stuff to do after user logs in
	protected function authenticated(Request $request, $user) {

	}

	protected function credentials(Request $request) {

		$credentials = $request->only($this->username(), 'password');
		$credentials['active'] = 1;
		$credentials['verified'] = 1;

		return $credentials;
	}

	protected function sendFailedLoginResponse(Request $request) {

		$errors = [$this->username() => 'Your login credentials are incorrect.'];

		// Load user from database

		$user = \App\User::where($this->username(), $request->{$this->username()})->first();

		// Check if user was successfully loaded, that the password matches

		///if driver want to login //restrict him
		if ($user && $user->user_type == 3) {

			$errors = [$this->username() => 'You cant not login on web system. Please login using driver mobile application.'];

		}

		// and active is not 1. If so, override the default error message.
		if ($user && $user->verified != 1) {

			$errors = [$this->username() => 'Your email address is not verified yet.'];

		} elseif ($user && $user->active != 1) {

			$errors = [$this->username() => 'Your account is not activated.'];

		}

		if ($request->expectsJson()) {

			return response()->json($errors, 422);

		}

		return redirect()->route('login')

			->withInput($request->only($this->username(), 'remember'))

			->withErrors($errors);

	}

	public function showRegistrationForm() {

		return redirect('login');

	}

	public function show_login_form($locale) {
		// session()->put('locale', 'en');
		if (!in_array($locale, ['en', 'ar'])) {
			return redirect()->route('login');
		}

		App::setLocale($locale);

		return view('auth.login');
	}

	public function register() {

	}

}
