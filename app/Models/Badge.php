<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;
Class Badge extends Model{

     use SoftDeletes;

     protected $table = 'badge';
     protected $primaryKey = 'id';

     public $timestamps = true;

     protected $dates = ['deleted_at'];


 	public function product()
    {
        //return $this->hasMany('App\Models\Product');
        return $this->hasMany(Product::class,'badge_id','id');
    }
	

}
?>