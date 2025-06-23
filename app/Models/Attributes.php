<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
Class Attributes extends Model{

     use SoftDeletes;

     protected $table = 'attributes';
     protected $primaryKey = 'id';

     public $timestamps = true;

     protected $dates = ['deleted_at'];

  
   	public function attribute_options()
    {
    return $this->hasMany('App\Models\AttributeOptions');
    }
  
   	public static function getColorId()
   	{
   	    $data=Self::where('attribute_name','color')->first();
   	    if($data)
   	    {
   	        return $data->id;
   	    }
   	}


    public static function getid_attr($atr_name)
    {
        $data=Self::where('attribute_name',$atr_name)->first();
        if($data)
        {
            return $data->id;
        }
    }
    

}
?>