<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
Class ProductVariants extends Model{

    // use SoftDeletes;

     protected $table = 'product_variants';
     protected $primaryKey = 'id';

     public $timestamps = false;

     //protected $dates = ['deleted_at'];

   	public function product()
   	{
   	return $this->belongsTo('App\Models\Product');
   	}
   	
   	public function attributes()
   	{
   	return $this->belongsTo('App\Models\Attributes');
   	}
   

}
?>