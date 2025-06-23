<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug; 
use Spatie\Sluggable\SlugOptions;

class CategoryDiscount extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'category_discount';
    public $timestamps=true;
    protected $dates = ['deleted_at']; 

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    

}