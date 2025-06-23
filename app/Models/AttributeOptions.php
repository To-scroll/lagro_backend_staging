<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
Class AttributeOptions extends Model{

     use SoftDeletes;

     protected $table = 'attribute_options';
     protected $primaryKey = 'id';

     public $timestamps = true;

     protected $dates = ['deleted_at'];



   	
   	public function attribute()
   	{
   	return $this->belongsTo('App\Models\Attribute');
   	}
  

    public static function getAttributeOptionName($id)
    {
        $data=Self::find($id);
        if($data)
        {
            return $data->attribute_option_name;
        }
    }

    public static function getAttributeOptions($id)
    {
        $data=Self::where('attribute_id',$id)->get();
        if($data)
        {
            return $data;
        }
    }
     public static function getOptionsId($attribute_id,$option_name)
     {
        $data=Self::where('attribute_id',$attribute_id)->where('attribute_option_name',$option_name)->first();
        if($data)
        {
            return $data->id;
        }
     }


}
?>