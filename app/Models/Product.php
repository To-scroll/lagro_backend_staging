<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Str;
Class Product extends Model{

     use SoftDeletes;

     protected $table = 'product';
     protected $primaryKey = 'id';

     public $timestamps = true;

     protected $dates = ['deleted_at'];


    public function badge()
    {
    	return $this->belongsTo(Badge::class,'badge_id','id')->select('id','badge_name');
    }
    public function category()
    {
    return $this->belongsTo(Category::class,'category_id','id')->select('id','category_name','slug', DB::raw("CONCAT('" . asset('public/images/category/') . "/', icon) AS icon"));
    }
   
    public function variants()
    {
    return $this->hasMany(Variants::class,'product_id','id')->select('id','product_id','attribute_name');
    }
     public function combinations()
    {
    return $this->hasMany(Combination::class,'product_id','id')->select('id','product_id','combination','var_option_id');
    }
    public function variantsOptions()
    {
    return $this->hasMany(VariantOptions::class,'product_id','id')->select('id','product_id','variant_id','option_name');
    }
     public function allSku()
     {
      return $this->HasMany(Sku::class,'product_id','id')->select('id','product_id','sku','price','special_price','quantity','stock_status','combination_id','combination_set');
     }
     public function sku()
     {
      return $this->HasOne(Sku::class,'product_id','id')->select('id','product_id','sku','price','special_price','quantity','stock_status','combination_id','combination_set');
     }
     
    
     public function skuNew()
     {
      return $this->HasMany(Sku::class,'product_id','id')->with(['sku_images']);
     }
     
     
     
      public function skuValues()
     {
      return $this->HasMany(SkuValues::class,'product_id','id');
     }
     
    /*public function productimages()
     {
      return $this->HasMany(ProductImages::class,'product_id','id');
     }*/
     public function productimages()
    {
        return $this->HasMany(ProductImages::class, 'product_id', 'id')
            ->selectRaw('id, product_id, CONCAT("' . asset('public/images/products/image/') . '/", image) AS image');
    }
    
    //forapisingleproduct
     public function cartItem()
    {
        return $this->hasOne(CartItems::class, 'sku_id', 'id') ->selectRaw('id, sku_id, quantity');
    }

   //checking 
    public function setSlugAttribute($value) {

      if (static::where('slug',$slug = Str::slug($value))->exists()) {

          $slug = $this->incrementSlug($slug);
      }

      $this->attributes['slug'] = $slug;
  }

      public function incrementSlug($slug) {
    
        $original = $slug;
    
        $count = 2;
    
          while (static::where('slug',$slug)->exists()) {
    
              $slug = "{$original}-" . $count++;
          }
    
        return $slug;
    
      }
    public static function getProductThumbnail($id)
      {
    	$data=Self::find($id);
    	if(isset($data) && $data->icon != '')
    	{
    		$path=public_path('images/product/icon/'.$data->icon);
    		if(file_exists($path))
    		{
    			return $data->icon;
    		}
    	}
    	if(isset($data) && $data->image2 != '')
    	{
    		$path=public_path('images/product/'.$data->image2);
    		if(file_exists($path))
    		{
    			return $data->image2;
    		}
    	}
    	if(isset($data) && $data->image3 != '')
    	{
    		$path=public_path('images/product/'.$data->image3);
    		if(file_exists($path))
    		{
    			return $data->image3;
    		}
    	}
    	if(isset($data) && $data->image4 != '')
    	{
    		$path=public_path('images/product/'.$data->image4);
    		if(file_exists($path))
    		{
    			return $data->image4;
    		}
    	}
	return '';
    }
      public function reviews()
      {
          return $this->hasMany(Review::class);
      }
    public static function getProductCount()
    {
      return Self::count();
       
        
        
    }
    public static function getProductStatusCount($status)
    {
        $data=Self::where($status,'yes')->count();
        if($data)
        {
            return $data;
        }else{
        	return 0;
        }
    }
    
    
    
    public function orderItems()
    {
        return $this->hasMany(OrderItems::class, 'product_id');
    }
   
   
   public function categoryDiscounts()
    {
        return $this->belongsToMany(CategoryDiscount::class, 'categorydiscount_product', 'product_id', 'category_discount_id');
    }
    
    public static function getProductSlug($id)
      {
    	$data=Self::find($id);
    	return $data->slug;
      }
}
?>