<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Customer extends Model
{
	use SoftDeletes; 
    use HasFactory;
	protected $table='customer';
	//protected $guarded=[];
	protected $primaryKey = 'id';

     public $timestamps = true;

     protected $dates = ['deleted_at'];


	// public function orders()
 //    {
 //        return $this->hasMany('App\Models\Orders');
 //    }


	// public function customer_address()
 //    {
 //        return $this->hasMany(Address::class,'customer_id','user_id');
 //    }
}
