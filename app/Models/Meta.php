<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    use HasFactory;
	protected $table='meta';
	protected $guarded = [];
	public $timestamps=false;

	public static function getMeta($model,$id,$key)
	{
		$meta=Meta::where('model',$model)->where('model_id',$id)->first();
		if($meta)
		{
			return $meta->$key;
		}
		else
		{
			return '';
		}
	}
	 
}
