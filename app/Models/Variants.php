<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
Class Variants extends Model{

     use SoftDeletes;

     protected $table = 'variants';
     protected $primaryKey = 'id';

     public $timestamps = true;

     protected $dates = ['deleted_at'];

  
   public static function get_variant_atr_name($id)
    {
        $data=Self::find($id);
        if($data)
        {
            return $data->attribute_name;
        }
    }

    public function variants()
    {
    return $this->hasMany(Variants::class,'variant_id','id');
    }
    public function variantOptions()
    {
    return $this->hasMany(VariantOptions::class,'variant_id','id')->select('id','product_id','variant_id','option_name');
    }

}
?>