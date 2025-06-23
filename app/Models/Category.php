<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;
Class Category extends Model{

     use SoftDeletes;

     protected $table = 'category';
     protected $primaryKey = 'id';

     public $timestamps = true;

     protected $dates = ['deleted_at'];
	 protected $appends = ['product_count'];

   	public function product()
    {
        return $this->hasMany('App\Models\Product');
    }
//checking 
    public function setSlugAttribute($value) {

	    if (static::where('slug',$slug = Str::slug($value))->exists()) {

	        $slug = $this->incrementSlug($slug);
	    }

    	$this->attributes['slug'] = $slug;
	}

	public function incrementSlug($slug) {

    $original = $slug;

    $count = 2;

	   	while (static::where('slug',$slug)->exists()) {

	        $slug = "{$original}-" . $count++;
	    }

    return $slug;

	}

	public function getProductCountAttribute()
	{
		$data=Product::whereRaw("find_in_set('".$this->id."',category_id)")->count();
		return $data;
	}
	public static function getNameFromIds($ids)
	{
		$idsArray=explode(',',$ids);
		if(count($idsArray) != 0)
		{
			$data=Self::find($idsArray[0]);
			if($data)
			{
				return $data->category_name;
			}
		}
		return '';
	}
   public static function getCategories()
   {
      $data=Self::get();
	  return $data;
   }
   
   
    public function products()
    {
	    return $this->hasMany(Product::class,'category_id','id');
    }



    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }


    public function discounts()
    {
        return $this->hasMany(CategoryDiscount::class, 'category_id');
    }
}
?>