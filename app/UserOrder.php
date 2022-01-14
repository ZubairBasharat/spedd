<?php



namespace App;



use DB;

use Carbon\Carbon;

use App\UserOrder;

use Illuminate\Database\Eloquent\Model;



class UserOrder extends Model

{



    protected $table = 'orders';

    //protected $connection = DB::connection();

    

    protected $fillable = [

        'id'

    ];





}

