<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Review extends Model
{

     use SoftDeletes;
     protected $table='review';
     public $timestamps = true;

     protected $dates = ['deleted_at'];
     public function reviewPackage()
    {
    	return $this->hasOne(Package::class,'id','package_id');
    }
     public function reviewUser()
    {
    	return $this->hasOne(Customer::class,'user_id','user_id');
    }
}