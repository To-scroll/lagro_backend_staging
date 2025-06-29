<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
	protected $table='address';
	public $timestamps=false;
	public function groupId()
	{
		 return $this->hasMany(GroupDetails::class,'pincode','id');
	}

}
