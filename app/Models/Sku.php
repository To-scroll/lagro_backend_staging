<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
Class Sku extends Model{

     use SoftDeletes;

     protected $table = 'sku';
     protected $primaryKey = 'id';

     public $timestamps = true;

     protected $dates = ['deleted_at'];
	 protected $appends = ['order_product_name'];

     public function sku_values()
     {
     	return $this->hasMany(SkuValues::class,'sku_id','id');
     }
     public function productItems()
     {
     	return $this->belongsTo(Product::class,'product_id','id');
     }
	 public function getOrderProductNameAttribute()
	 {
		$data=Product::find($this->product_id);
		if($data){
			return $data->product_name;
		}
		return '';
	 } 
	 
	 
	 public function sku_images()
    {
        return $this->hasMany(ProductImages::class, 'sku_id', 'id')
            ->selectRaw('id, sku_id, product_id, CONCAT("' . asset('public/images/products/image/') . '/", image) AS image');
    }
	 
	 public function cartItem()
    {
        return $this->hasOne(CartItems::class, 'sku_id', 'id') ->selectRaw('id, sku_id, quantity');
    }
 }