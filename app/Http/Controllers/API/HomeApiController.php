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
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
class HomeApiController extends Controller
{
   
        // $categories = Category::get();
        // $banner=Banner::get();
        // $testimonials=Testimonial::get();
        // $blogs=Blog::get();
        
       public function index()
    {
        try {
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
    
            $blogs = Blog::where('is_published', 'yes')->get()->map(function ($blog) {
                $blog->image = asset('public/images/blog/' . $blog->image);
                return $blog;
            });
    
            $settings = Settings::get()->map(function ($setting) {
                if ($setting->type === 'file') {
                    $setting->value = asset('public/images/settings/' . $setting->value);
                }
                return $setting;
            });
    
            return response()->json([
                'get-all' => 'Banner,Products,Testimonials,Categories,Faq,Settings,pages,blog',
                'settings' => $settings,
                'banner' => $banner,
                'testimonials' => $testimonials,
                'categories' => $categories,
                'faq' => $result,
                'pages' => $pages,
                'blogs' => $blogs
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch homepage content',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    
    public function addToContact(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
            ]);
    
            $data = new Contact();
            $data->name = $request->name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->message = $request->message;
            $data->created_at = now();
            $data->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Successfully entered'
            ], 200);
    
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'error' => 'Validation Error',
                'messages' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    
    
    public function getLocations(Request $request)
    {
        try {
            $locations = Location::get();
    
            return response()->json([
                'status' => true,
                'locations' => $locations
            ], 200);
    
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'error' => 'Validation Error',
                'messages' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    
    
    public function getPages(Request $request)
    {
        try {
            $pages = Cms::get();
    
            return response()->json([
                'status' => true,
                'pages' => $pages
            ], 200);
    
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'error' => 'Validation Error',
                'messages' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
