<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model

{
    
    use HasFactory;
    protected $table="config_module";
    public $timestamps=false;
    
    public static function getAll($module_name,$field){
        $data=Config::where('module_name',$module_name)->first();

        if(isset($data)){
            
            return $data->$field;
        }
       
    }
    public static function getModuleName($module_name,){
        $data=Config::where('module_name',$module_name)->first();

        if(isset($data)){
            
            return $data->module_name;
        }
       
    }
    
}
