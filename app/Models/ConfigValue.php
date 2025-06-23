<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigValue extends Model
{
    
    use HasFactory;
   
    protected $table="config_module_details";
    public $timestamps=false;
    public static function getvalue($name){
        $data=ConfigValue::where('name',$name)->first();
        if(isset($data)){
            return $data->value ?? '';
        }
       
    }
}
