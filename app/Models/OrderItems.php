<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;
// 	protected $table='order_items';
protected $guarded =[];
	public $timestamps = false;

	public function productData()
	{
		 return $this->belongsTo(Product::class,'product_id','id');
	}
	public function productSku()
	{
		 return $this->belongsTo(Sku::class,'sku_id','id');
	}
	public function product()
	{
		return $this->belongsTo(Product::class);
	}
	public function orders()
    {
        return $this->belongsTo(Orders::class);
    }
    

}
