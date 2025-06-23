<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table="review";
    public $timestamps=false;
    
    public function productName()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }
 
}

