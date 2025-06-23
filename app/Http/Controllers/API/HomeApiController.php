<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
use App\Models\Review;
use App\Models\Banner;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Settings;
use App\Models\Contact;
use App\Models\Location;
use App\Models\Cms;
use App\Models\Blog;

use Illuminate\Http\Request;
use Validator;

class HomeApiController extends Controller
{
    public function index()
    {
        
        // $categories = Category::get();
        // $banner=Banner::get();
        // $testimonials=Testimonial::get();
        // $blogs=Blog::get();
        
        $categories = Category::get()->map(function ($category) {
            $category->icon = asset('public/images/category/' . $category->icon);
            return $category;
        });
        
        $banner = Banner::get()->map(function ($item) {
            $item->image = asset('public/images/banner/' . $item->image);
            return $item;
        });
        
        $testimonials = Testimonial::get()->map(function ($testimonial) {
            $testimonial->image = asset('public/images/testimonial/' . $testimonial->image);
            return $testimonial;
        });
        
        $faqCategories = FaqCategory::with('faqs')->get();
        $result = $faqCategories->map(function ($category) {
            return [
                'tab' => $category->category,
                'questions' => $category->faqs->map(function ($faq) {
                    return [
                        'id' => $faq->id,
                        'question' => $faq->question,
                        'answer' => $faq->answer,
                    ];
                }),
            ];
        });
        
        $pages = Cms::where('is_published', 'yes')->get();

        
        $blogs = Blog::where('is_published','yes')->get()->map(function ($blog) {
            $blog->image =  asset('public/images//blog/' . $blog->image);
            return $blog;
        });
        
        $settings = Settings::get()->map(function ($setting) {
            if ($setting->type === 'file') {
                $setting->value =  asset('public/images/settings/' . $setting->value);
            }
            return $setting;
        });
        
        return response()->json(['get-all' => 'Banner,Products,Testimonials,Categories,Faq,Settings,pages,blog','settings'=>$settings,'banner'=>$banner,'testimonials'=>$testimonials,'categories'=>$categories,'faq'=>$result,'pages'=>$pages,'blogs'=>$blogs]);

    }
    
    public function addToContact(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);          
        $data=new Contact();
        $data->name = $request->name;
        $data->email=$request->email;                                      
        $data->phone=$request->phone;                                      
        $data->message=$request->message; 
        $data->created_at =now();
        $data->save();
        return response()->json(['status'=>true,'message'=>'successfully entered']);
           
        
    }
    
    
     public function getLocations(Request $request)
    {
		 $locations = Location::get();
		return response()->json(['status'=>true,'locations'=>$locations]);
    }
    
    
    public function getPages(Request $request)
    {
		 $pages = Cms::get();
		return response()->json(['status'=>true,'pages'=>$pages]);
    }
}
