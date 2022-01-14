<?php



namespace App\Http\Middleware;



use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Closure;


class VerifyCsrfToken extends BaseVerifier

{

    /**

     * The URIs that should be excluded from CSRF verification.

     *

     * @var array

     */

    public function handle($request, Closure $next)
	{
		if($request->input('_token'))
		{
		    if ( \Session::token() != $request->input('_token'))
		    {

		      //notify()->flash('Your session has expired. Please try logging in again.', 'warning');

		      return redirect()->route('login')->withErrors(['Your session has expired. Please try logging in again.']);
		    }
		}
		return parent::handle($request, $next);
	}

    protected $except = [

        //

    ];

}

