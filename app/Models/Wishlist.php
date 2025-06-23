<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
	protected $table='wishlist';
	protected $fillable = [
    'customer_id', 'date' // Add other required columns
];

//  protected  $guarded=[];
	public $timestamps=false;
	public function wishlistItems()
    {
        return $this->hasMany(WishlistItems::class);
    }

}
