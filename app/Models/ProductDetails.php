<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
Class ProductDetails extends Model{

     //use SoftDeletes;

     protected $table = 'product_details';
     protected $primaryKey = 'id';

     public $timestamps = false;

    // protected $dates = ['deleted_at'];



}
?>