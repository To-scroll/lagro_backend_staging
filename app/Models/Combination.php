<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
Class Combination extends Model{

     use SoftDeletes;

     protected $table = 'combination';
     protected $primaryKey = 'id';

     public $timestamps = true;

     protected $dates = ['deleted_at'];

   

}
?>