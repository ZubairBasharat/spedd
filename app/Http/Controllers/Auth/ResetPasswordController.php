<?php



namespace App\Http\Controllers\Auth;



use DB;



use App\User;



use Illuminate\Http\Request;



use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\ResetsPasswords;



class ResetPasswordController extends Controller

{

    /*

    |--------------------------------------------------------------------------

    | Password Reset Controller

    |--------------------------------------------------------------------------

    |

    | This controller is responsible for handling password reset requests

    | and uses a simple trait to include this behavior. You're free to

    | explore this trait and override any methods you wish to tweak.

    |

    */



    use ResetsPasswords;



    /**

     * Where to redirect users after resetting their password.

     *

     * @var string

     */

    protected $redirectTo = '/';



    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        $this->middleware('guest');

    }



    public function showResetForm($token)

    {

        return View('auth.resetpassword', compact('token'));

    }



    public function reset(Request $request)

    {

        if($user = User::Where('email', $request->email)->first())

        {

            if($request->token == $user->token)

            {

                //dd($user, $request);
                $user->token = '';

                $user->password = bcrypt($request->password);

                $user->save();

                return redirect()->route('login')->with('status','Your Password is successfully changed.') ;

            }

            return redirect()->route('login')->withErrors(['Unable to change password.']) ;

        }

        

        return redirect()->route('login')->withErrors(['User not found against entered email.']) ;

    }

}

