<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Offer extends Model{

     protected $table = 'offers';
     protected $primaryKey = 'id';

     public $timestamps = true;

    
}
?>