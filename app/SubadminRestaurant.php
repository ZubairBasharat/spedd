<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubadminRestaurant extends Model {

	protected $table = 'subadmin_restaurants';

	//protected $connection = DB::connection();

	protected $fillable = [

		'id',

	];

}
