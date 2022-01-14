<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Mail;

class ForgotPasswordController extends Controller {

	/*

		    |--------------------------------------------------------------------------

		    | Password Reset Controller

		    |--------------------------------------------------------------------------

		    |

		    | This controller is responsible for handling password reset emails and

		    | includes a trait which assists in sending these notifications from

		    | your application to your users. Feel free to explore this trait.

		    |

	*/

	use SendsPasswordResetEmails;

	/**

	 * Create a new controller instance.

	 *

	 * @return void

	 */

	public function __construct() {

		$this->middleware('guest');

	}

	public function sendResetLinkEmail(Request $request) {

		try

		{

			if ($user = User::where('email', $request->input('email'))->first()) {

				$token = app(\Illuminate\Auth\Passwords\PasswordBroker::class)->createToken($user);

				$user->token = $token;

				$user->save();

				$data = [

					'email' => $request->email,

					'token' => $token,

				];

				Mail::send('emails.passwordreset', $data, function ($message) use ($data) {

					$message->from(env('MAIL_USERNAME', 'info@speeds.ws'));

					$message->to($data['email']);

					$message->subject('Password Reset Email');

				});

				return redirect()->route('login')->with('status', 'Password reset email has been send. Please check your email.');

			} else {

				return redirect()->route('login')->withErrors('This email is not associated with any user account. Please check your email.');

			}

		} catch (\Swift_TransportException $e) {
			return redirect()->route('login')->withErrors(['Unable to send email on given email address.' . $e->getMessage()]);
		}

	}

}
