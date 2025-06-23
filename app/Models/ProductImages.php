<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductImages extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table="product_images";
     public $timestamps = true;

     protected $dates = ['deleted_at'];

   
   
     public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    
    public function sku()
    {
        return $this->belongsTo(Sku::class, 'sku_id', 'id')->select(['id', 'discount']);
    }

}
