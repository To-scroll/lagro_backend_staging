<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
Class Faq extends Model{

     use SoftDeletes;

     protected $table = 'faq';
     protected $primaryKey = 'id';

     public $timestamps = true;

     protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'faq_category_id');
    }

}
?>