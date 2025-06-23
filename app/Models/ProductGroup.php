<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGroup extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table="product_group";
    public $timestamps=true;
    
     protected $dates = ['deleted_at'];
    
    public function groups()
    {
    return $this->hasMany(Groups::class,'id','group_id');
    }
   
}
