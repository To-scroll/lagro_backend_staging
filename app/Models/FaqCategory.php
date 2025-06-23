<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


Class FaqCategory extends Model{


     protected $table = 'faq_category';
     protected $primaryKey = 'id';

     public $timestamps = true;


    public function faqs()
    {
        return $this->hasMany(Faq::class, 'faq_category_id');
    }

}
?>