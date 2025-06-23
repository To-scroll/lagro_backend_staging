<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Location extends Model{

     protected $table = 'locations';
     protected $primaryKey = 'id';

     public $timestamps = true;

    
}
?>