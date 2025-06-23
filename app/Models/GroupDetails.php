<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupDetails extends Model
{
    use HasFactory;
    protected $table="group_details";
    public $timestamps=false;
    public function orderItems()
	{
		 return $this->hasMany(Orders::class,'id','pincode');
	}
}
