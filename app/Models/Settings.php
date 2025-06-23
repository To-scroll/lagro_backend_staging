<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
Class Settings extends Model{

     

     protected $table = 'settings';
     protected $primaryKey = 'id';

     public $timestamps = false;

    public static function getSettingsvalue($label)
    {
         $data = self::where('label', '=', $label)->first();
         
         if($data){
             return $data->value;
         } else {
             return '';
         }
     }

     public static function getSettingsId($label)
    {
         $data = self::where('label', '=', $label)->first();
         
         if($data){
             return $data->id;
         } else {
             return '';
         }
     }


   

}
?>