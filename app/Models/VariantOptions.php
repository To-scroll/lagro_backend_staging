<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
Class VariantOptions extends Model{

     use SoftDeletes;

     protected $table = 'variant_options';
     protected $primaryKey = 'id';

     public $timestamps = true;

     protected $dates = ['deleted_at'];
     
   public static function get_option_names($id)
    {
        $data=Self::find($id);
        if($data)
        {
            return $data->option_name;
        }
    }

}
?>