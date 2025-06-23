<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
	protected $table='cart';
	protected $fillable = [
    'customer_id', 'date' // Add other required columns
];

//  protected  $guarded=[];
	public $timestamps=false;
	public function cartItems()
{
    return $this->hasMany(CartItems::class);
}

}
