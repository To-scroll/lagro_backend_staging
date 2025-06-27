<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
class Orders extends Model
{
    use SoftDeletes;
    //use HasFactory;
// 	protected $table='orders';
protected $guarded =[];
	public $timestamps = true;
    protected $dates = ['deleted_at'];
	public static function boot()
	{
		parent::boot();
		self::creating(function ($model) {
			$model->order_no = IdGenerator::generate(['table' => 'orders','field'=>'order_no', 'length' =>10, 'prefix' =>'ORD'.date('ym')]);
		});
	}
		/*
	public function orderItems()
	{
		 return $this->hasMany(OrderItems::class,'order_id','id')->select('id','order_id','product_id','product_name','thumbnail','combination','combination_id','skuvalues_ids','qty','price','special_price','total');
	}
	*/
	
	public function orderItems()
    {
        return $this->hasMany(OrderItems::class, 'order_id', 'id')
            
            ->selectRaw('id, order_id, product_id, product_name,product_slug, CONCAT("' . asset('public/images/product/icon/') . '/", thumbnail) AS thumbnail, combination, combination_id,sku_title, skuvalues_ids, qty, price, special_price, total');
    }
    
     public function offerSku()
    {
        return $this->belongsTo(Sku::class, 'offer_productsku', 'id')
            ->with('sku_images', 'sku_values');
    }

    
    
    
	public function customers()
    {
        return $this->belongsTo(Customer::class,'customer_id','user_id');
    }
    public function customer_address()
    {
        return $this->belongsTo(Address::class,'customer_id','customer_id');
    }

    public static function getOrderCount($delivery_status)
    {
        $data=Self::where('delivery_status',$delivery_status)->count();
        if($data)
        {
            return $data;
        }else{
        	return 0;
        }
    }

    public static function getOrderProcessingCount()
    {
        $data=Self::where('delivery_status','processing')->orwhere('delivery_status','on transit')->count();
        if($data)
        {
            return $data;
        }else{
            return 0;
        }
    }
    
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    
    
   public static function isReviewable($productId,$userId)
   {
    
        $data=Self::withCount(['orderItems'=>function($q) use($productId)
        {
            $q->where('product_id',$productId);
        }])
            ->where('delivery_status','delivered')
            ->where('customer_id',$userId)
            ->get();
        
        info(json_encode($data));
        // if(isset($data) && $data->order_items_count != 0)
        // {
           
        //     return true;
        // }else{
        //     return false;
        // }
        foreach ($data as $order) {
            if ($order->order_items_count != 0) {
                
                return true;
            }
        }
        return false;
        
   }
   
   
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'order_id');
    }
   
}
