<?php



namespace App;



use DB;

use Carbon\Carbon;

use App\UserOrder;

use Illuminate\Database\Eloquent\Model;



class FinanceSettings extends Model

{



    protected $table = 'finance_settings';

    //protected $connection = DB::connection();

    

    protected $fillable = [

        'id'

    ];





}

