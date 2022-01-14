<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyAPI extends Model {

	protected $table = 'company';

	//protected $connection = DB::connection();

	protected $fillable = [

		'id',
	];

	protected $hidden = [

		'more_about_us_text', 'about_us_text', 'mission_statement',  'objectives',  'terms_conditions', 'marquee_text', 'welcome_text', 'welcome_heading'  
	];

}
