<?php

namespace App\Http\Controllers;

use App\Library\Common\MyLib;
use App\NewsWeb;
use DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

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


	public function index() {

		$title = "Dashboard";
    
		if (auth()->user() != null) {
			return redirect()->route('user_profile');
		} else {
			return redirect()->route('login');
		}

	}

	public function form() {

		return view('form');

	}

}
