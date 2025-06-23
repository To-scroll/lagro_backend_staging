<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
Class SkuValues extends Model{

     use SoftDeletes;

     protected $table = 'sku_values';
     protected $primaryKey = 'id';

     public $timestamps = true;

     protected $dates = ['deleted_at'];
 }