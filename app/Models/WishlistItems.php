<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WishlistItems extends Model
{
    use HasFactory;
	protected $table='wishlist_items';
    //  protected  $guarded=[];
     protected $fillable = [
        'customer_id', 'wishlist_id', 'product_id', 'product_name', 'sku_id',
        'sku', 'combination', 'combination_id', 'price',
        'special_price', 'skuvalues_ids'
    ];
    
     public function productItems()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')->selectRaw("
            id, 
            product_name, 
            slug,
            brand,
            add_badge_status,
            badge_id,
            category_id,
            description,
            meta_description,
            short_description,
            CONCAT('" . asset('public/images/product/') . "/', image1) AS image,
            CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon,
            type
        ");
    }
    
    public function sku_images()
    {
        return $this->hasMany(ProductImages::class, 'sku_id', 'sku_id')
                ->selectRaw(' sku_id, product_id, CONCAT("' . asset('public/images/products/image/') . '/", image) AS image');
    }
    
}
