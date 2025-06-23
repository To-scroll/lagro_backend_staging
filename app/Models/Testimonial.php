<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
Class Testimonial extends Model{

     use SoftDeletes;

     protected $table = 'testimonial';
     protected $primaryKey = 'id';

     public $timestamps = true;

     protected $dates = ['deleted_at'];



}
?>