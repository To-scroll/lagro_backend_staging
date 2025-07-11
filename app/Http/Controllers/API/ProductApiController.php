<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
use App\Models\Review;
use App\Models\Combination;
use App\Models\CartItems;
use App\Models\ProductImages;


use App\Models\Wishlist;
use App\Models\WishlistItems;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\Variants;
use App\Models\VariantOptions;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ProductApiController extends Controller
{
    public function index()
    {
        $data = [];
        $images = [];
        $categories = Category::get();
        foreach ($categories as $category) {
            $products = Product::where('is_published','yes')->where('is_finished', 'yes')->with('category','skuNew','badge','variants.variantOptions')->where('category_ids', $category->id)->select(
        'id',
        'product_name',
        'category_ids',
        'badge_id',
        'slug',
        'brand',
        'description',
        'short_description',
        'meta_description',
        DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
        DB::raw("CONCAT('" . asset('public/images/product/') . "/', image2) AS image2"),
        DB::raw("CONCAT('" . asset('public/images/product/') . "/', image3) AS image3"),
        DB::raw("CONCAT('" . asset('public/images/product/') . "/', image4) AS image4"),
        DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
        
        /*'image1',
        'image2',
        'image3',
        'image4',
        'icon',*/
        'type'
        )->take(2);
            $category->products = $products->get()->toArray();

            $data[] = $category;

        }
        return response()->json(['data' => $data]);

    }
    
    
    
    public function productDetails($id)
    {
        // \Log::info('Request Headers1:', request()->headers->all());
        $product = Product::with('category','skuNew','badge','variants.variantOptions')->where('slug', $id)->where('is_finished', 'yes')->select(
        'id',
        'product_name',
        'category_ids',
        'badge_id',
        'slug',
        'brand',
        'description',
        'short_description',
        'meta_description',
        /*
        DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
          DB::raw("CONCAT('" . asset('public/images/product/') . "/', image2) AS image2"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image3) AS image3"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image4) AS image4"),*/
        DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
        
        'image1',
        'image2',
        'image3',
        'image4',
        // 'icon',
        'type'
        )
        ->first();
            
        
        if (!$product) 
        {

            return response()->json(['status'=>false,'message'=>'Product Not Found']);
        }
       
         $allowReview = false;
        
        
        $reviews = Review::where('product_id', $product->id)->where('is_approved', 'yes')->orderby('created_at', 'DESC')->limit(10)->get();
        $review_count = Review::where('product_id', $product->id)->where('is_approved', 'yes')->count();
        $averageRating = Review::where('product_id', $product->id)
            ->where('is_approved', 'yes')
            ->avg('rating');
            
        $userId = Auth::guard('api')->id();
        //for check allow review
         if ($userId) {
            $existingReview = Review::where('product_id', $product->id)
                ->where('user_id', $userId)
                ->first();
    
            if (!$existingReview) {
                $order = Orders::where('customer_id', $userId)
                    ->whereHas('orderItems', function ($query) use ($product) {
                        $query->where('product_id', $product->id);
                    })
                    ->where('delivery_status', 'delivered')
                    ->first();
                   
                if ($order) {
                    $allowReview = true;
                }
            }
        }
        
        $isCartAdded = CartItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
        $isWishlistAdded = WishlistItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
        
        // \Log::info($isCartAdded);
        // \Log::info($isWishlistAdded);
        
        $product->is_cart_added = $isCartAdded;
        $product->is_wishlist_added = $isWishlistAdded;
        $product->allow_review = $allowReview;
        $product->review_count = $review_count;
        $product->averageRating = $averageRating;
        $product->reviews = $reviews;
        
        
        
        $product->images = array_filter([
            
            $product->image1 ? asset('public/images/product/' . $product->image1) : null,
            $product->image2 ? asset('public/images/product/' . $product->image2) : null,
            $product->image3 ? asset('public/images/product/' . $product->image3) : null,
            $product->image4 ? asset('public/images/product/' . $product->image4) : null,
            
        ]);
        unset($product->image1, $product->image2, $product->image3, $product->image4,);
        return response()->json([
            'product' => $product]);
    }
    
    
    
    
    /*public function productDetails($id)
    {
    \Log::info('Request Headers1:', request()->headers->all());

    $product = Product::with('category', 'sku', 'badge', 'variants.variantOptions')
        ->where('id', $id)
        ->select('id', 'product_name', 'category_ids', 'badge_id', 'slug', 'brand', 'description', 'short_description', 'meta_description', 'image1', 'image2', 'image3', 'image4', 'icon', 'type')
        ->first();

    if (!$product) {
        return response()->json(['status' => false, 'message' => 'Product Not Found']);
    }

    $reviews = Review::where('product_id', $product->id)->where('is_approved', 'yes')->orderby('created_at', 'DESC')->limit(10)->get();
    $review_count = Review::where('product_id', $product->id)->where('is_approved', 'yes')->count();
    $averageRating = Review::where('product_id', $product->id)
        ->where('is_approved', 'yes')
        ->avg('rating');

    $userId = Auth::guard('api')->id();
    \Log::info($userId);

    $isCartAdded = CartItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
    \Log::info($isCartAdded);

    $sku = $product->sku;
    
     $variantList = collect($product->variants)->map(function ($variant) {
        return [
            "attribute" => $variant->attribute_name,
            "options" => collect($variant->variantOptions)->pluck('option_name')->filter()->values()
        ];
    })->filter(function ($variant) {
        return $variant['options']->isNotEmpty();
    })->values();

    // Construct frontend-style response
    $response = [
        "id" => (string) $product->id,
        "category" => optional($product->category)->category_name,
        "type" => $product->type,
        "name" => $product->product_name,
        "new" => true,
        "sale" => $sku && $sku->special_price < $sku->price,
        "rate" => $averageRating ?? 0,
        "price" => $sku->special_price ?? $sku->price ?? 0,
        "originPrice" => $sku->price ?? 0,
        "brand" => $product->brand,
        "sold" => 0,
        "quantity" => $sku->quantity ?? 0,
        "quantityPurchase" => 1,
        "outOfStock" => ($sku->quantity ?? 0) <= 0,
        "sizes" => ["S", "M", "L", "XL"], 
         "variantion" => $variantList,
        "thumbImage" => [
            "/public/images/product/icon" . $product->icon,
        ],
        "images" => [
            "/public/images/product/" . $product->image1,
            "/public/images/product/" . $product->image2,
            "/public/images/product/" . $product->image3,
            "/public/images/product/" . $product->image4
        ],
        "description" => $product->description,
        "action" => "add to cart",
        "slug" => $product->slug,
        "aboutThisProduct" => [
            $product->short_description,
            "Category: " . optional($product->category)->category_name,
            "Brand: " . $product->brand
        ]
    ];

    return response()->json([
        'product' => $response,
        'reviews' => $reviews,
        'review_count' => $review_count,
        'averageRating' => $averageRating
    ]);
}*/

    
   /* 
   public function productDetails($id)
    {
        \Log::info('Request Headers1:', request()->headers->all());
        $product = Product::with('category','badge','variants.variantOptions')->where('slug', $id)->select('id','product_name','category_ids','badge_id','slug','brand','description','short_description','meta_description','image1','image2','image3','image4','icon','type')->first();
        if (!$product) {

            return response()->json(['status'=>false,'message'=>'Product Not Found']);
        }
        
        $reviews = Review::where('product_id', $product->id)->where('is_approved', 'yes')->orderby('created_at', 'DESC')->limit(10)->get();
        $review_count = Review::where('product_id', $product->id)->where('is_approved', 'yes')->count();
        $averageRating = Review::where('product_id', $product->id)
            ->where('is_approved', 'yes')
            ->avg('rating');
        $userId = Auth::guard('api')->id();
        \Log::info($userId);
        $isCartAdded = CartItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
        \Log::info($isCartAdded);
        $product->is_cart_added = $isCartAdded;
        return response()->json(['product' => $product, 'reviews' => $reviews,
            'review_count' => $review_count,
            'averageRating' => $averageRating]);
    }
    */
    
    
    
    
    
    
    /*public function getAllCategories()
    {
        $categories = Category::select('id','category_name','is_parent','parent_category_id','slug','icon')->get();
        return response()->json(['status'=>true,'data'=>$categories]);
    }*/
    /*
        public function getAllCategories()
        {
            $allCategories = Category::where('status','yes')->select('id', 'category_name', 'slug', 'icon', 'is_parent', 'parent_category_id','description')->get();
            $parentCategories = $allCategories->filter(function ($cat) {
                return $cat->is_parent === 'yes' && $cat->parent_category_id == 0;
            })->values();
            $categoriesWithSub = $parentCategories->map(function ($parent) use ($allCategories) {
                $productCount = Product::whereRaw("FIND_IN_SET(?, category_ids)", [$parent->id])->count();
        
                $subcategories = $allCategories->filter(function ($sub) use ($parent) {
                    return $sub->parent_category_id == $parent->id && $sub->is_parent === 'no';
                })->map(function ($sub) {
                    $sub->product_count = Product::whereRaw("FIND_IN_SET(?, category_ids)", [$sub->id])->count();
                    return [
                        'id' => $sub->id,
                        'category_name' => $sub->category_name,
                        'slug' => $sub->slug,
                        'icon' => $sub->icon,
                        'description' => $sub->description,
                        'product_count' => $sub->product_count,
                    ];
                })->values();
                return [
                    'id' => $parent->id,
                    'category_name' => $parent->category_name,
                    'slug' => $parent->slug,
                    'icon' => $parent->icon,
                    'description' => $parent->description,
                    'product_count' => $productCount,
                    'subcategories' => $subcategories
                ];
            });
        
            return response()->json([
                'status' => true,
                'data' => $categoriesWithSub
            ]);
        }
    */
    
     public function getfourCategories()
    {
        $fourCategories = Category::where('status', 'yes')
            ->where('is_parent','yes')
            ->inRandomOrder()
            ->take(4)
            ->select('id', 'category_name', 'slug', DB::raw("CONCAT('" . asset('public/images/category/') . "/', icon) AS icon"), 'is_parent', 'parent_category_id', 'description')
            ->get();
            
            return response()->json([
            'status' => true,
            'data' => $fourCategories
        ]);
    }
    
    
    public function getAllCategories()
    {
        $allCategories = Category::where('status', 'yes')
            ->select('id', 'category_name', 'slug', DB::raw("CONCAT('" . asset('public/images/category/') . "/', icon) AS icon"), 'is_parent', 'parent_category_id', 'description')
            ->get();
    
        // Recursive function to get subcategories
        $getChildren = function ($parentId) use (&$getChildren, $allCategories) {
            $children = $allCategories->filter(function ($cat) use ($parentId) {
                return $cat->parent_category_id == $parentId;
            })->map(function ($cat) use (&$getChildren) {
                $productCount = Product::whereRaw("FIND_IN_SET(?, category_ids)", [$cat->id])->count();
    
                return [
                    'id' => $cat->id,
                    'category_name' => $cat->category_name,
                    'slug' => $cat->slug,
                    'icon' => $cat->icon,
                    'description' => $cat->description,
                    'product_count' => $productCount,
                    'subcategories' => $getChildren($cat->id)
                ];
            })->values();
    
            return $children;
        };
    
        // Get top-level parents (with no parent)
        $parentCategories = $allCategories->filter(function ($cat) {
            return $cat->is_parent === 'yes' && $cat->parent_category_id == 0;
        })->values();
    
        // Build full tree
        $categoriesWithSub = $parentCategories->map(function ($parent) use ($getChildren) {
            $productCount = Product::whereRaw("FIND_IN_SET(?, category_ids)", [$parent->id])->count();
    
            return [
                'id' => $parent->id,
                'category_name' => $parent->category_name,
                'slug' => $parent->slug,
                'icon' => $parent->icon,
                'description' => $parent->description,
                'product_count' => $productCount,
                'subcategories' => $getChildren($parent->id)
            ];
        });
    
        return response()->json([
            'status' => true,
            'data' => $categoriesWithSub
        ]);
    }
    
    
/*
    public function getAllProducts(Request $request)
    {
        \Log::info($request->all());
        
        $categories = Category::select('id','category_name','slug','icon')->get();
        $query = Product::where('is_published','yes')->where('is_finished', 'yes')->with('category','skuNew','badge','variants.variantOptions')->select(
            'id',
            'product_name',
            'category_ids',
            'badge_id',
            'slug',
            'brand',
            'description',
            'short_description',
            'meta_description',
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
              DB::raw("CONCAT('" . asset('public/images/product/') . "/', image2) AS image2"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image3) AS image3"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image4) AS image4"),
            DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
            'type'
            );
            
        if ($request->has('category_id') && $request->category_id != '') {
            $categoryIds = explode(',', $request->category_id); 
            $query->whereIn('category_ids', $categoryIds);
            // $query->where('category_ids', $request->category_id);
        }
        if ($request->has('brand') && $request->brand != '') {
            $brands = explode(',', $request->brand);
            $query->whereIn('brand', $brands);
            // $query->where('brand', 'LIKE', '%' . $request->brand . '%'); 
         }

        $brandsQuery = Product::select('brand')->distinct();

        if ($request->has('category_id') && $request->category_id != '') {
            $categoryIds = explode(',', $request->category_id); 
            $brandsQuery->whereIn('category_ids', $categoryIds);
            // $brandsQuery->where('category_ids', $request->category_id);
        }
        
        $categoryBrands = $brandsQuery->pluck('brand');
        $page = $request->has('page') ? (int) $request->page : 1;
        $limit = 2;
        $offset = ($page - 1) * $limit;
        $total = (clone $query)->count();
        $products = $query->skip($offset)->take($limit)->get();
        $userId = Auth::guard('api')->id();
        foreach ($products as $product) {
            
            
            $isCartAdded = CartItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
            $product->is_cart_added = $isCartAdded;
            
          
        
            $isWishlistAdded = WishlistItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
            $product->is_wishlist_added = $isWishlistAdded;
        }
       
        return response()->json([
            'status' => true,
            'current_page' => $page,
            'per_page' => $limit,
            'total' => $total,
            'last_page' => ceil($total / $limit),
            'products' => $products,
            'brands' => $categoryBrands,
            
            
        ]);
    }
 */
 
 /*
    public function getAllProducts(Request $request)
    {
       
        // Get all categories
        $categories = Category::select('id', 'category_name', 'slug', 'icon')->get();
        
    
        // Build product query
        $query = Product::where('is_published', 'yes')
            ->where('is_finished', 'yes')
            ->with('category', 'skuNew', 'badge', 'variants.variantOptions')
            ->select(
                'id',
                'product_name',
                'category_ids',
                'badge_id',
                'slug',
                'brand',
                'description',
                'short_description',
                'meta_description',
                DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
                DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
                'type'
            );
        
        // if ($request->has('category_slug') && $request->category_slug != '') {
        //     $slugs = explode(',', $request->category_slug); // support multiple slugs
        //     $categoryIds = Category::whereIn('slug', $slugs)->pluck('id')->toArray();
        //     if (!empty($categoryIds)) {
        //         $query->whereIn('category_ids', $categoryIds);
        //     }
        // }
        
        if ($request->has('category_slug') && $request->category_slug != '') {
            $slug = $request->category_slug; 
            $categoryId = Category::where('slug', $slug)->pluck('id')->toArray();
            $query->where('category_ids', $categoryId);
            
        }
        
        if ($request->has('brand') && $request->brand != '') {
            $brands = explode(',', $request->brand);
            $query->whereIn('brand', $brands);
            // $query->where('brand', 'LIKE', '%' . $request->brand . '%'); 
         }
         $brandsQuery = Product::select('brand')->distinct();
         
         if ($request->has('category_slug') && $request->category_slug != '') {
            $slug = $request->category_slug; 
            $categoryId = Category::where('slug', $slug)->pluck('id')->toArray();
            $brandsQuery->whereIn('category_ids', $categoryId);
            // $brandsQuery->where('category_ids', $request->category_id);
        }

        
        $categoryBrands = $brandsQuery->pluck('brand');
        $page = $request->has('page') ? (int) $request->page : 1;
        $limit = $request->limit;
        $offset = ($page - 1) * $limit;
        $total = (clone $query)->count();
        $products = $query->skip($offset)->take($limit)->get();
    
        
        foreach ($products as $product) {
            $product->description = strip_tags($product->description);
        }
    
  
        $userId = Auth::guard('api')->id();
    
        foreach ($products as $product) {
            $isCartAdded = CartItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
            $product->is_cart_added = $isCartAdded;
    
            $isWishlistAdded = WishlistItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
            $product->is_wishlist_added = $isWishlistAdded;
        }
    
        return response()->json([
            'status' => true,
            'current_page' => $page,
            'per_page' => $limit,
            'last_page' => ceil($total / $limit),
            // 'total' => $total,
            'products' => $products,
            'categories' => $categories,
            'brands' => $categoryBrands,
        ]);
    }
*/
/*

    public function getAllProducts(Request $request)
    {
         
        $categories = Category::select('id', 'category_name', 'slug', 'icon')->get();
    
        $query = Product::where('is_published', 'yes')
            ->where('is_finished', 'yes')
            ->with('category', 'skuNew', 'badge', 'variants.variantOptions')
            ->select(
                'id',
                'product_name',
                'category_ids',
                'badge_id',
                'slug',
                'brand',
                'description',
                'short_description',
                'meta_description',
                DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
                DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
                'type',
                'updated_at'
            );
    
        // Category filter
        if (!empty($request->category_slug)) {
            $categoryIds = Category::where('slug', $request->category_slug)->pluck('id')->toArray();
            $query->whereIn('category_ids', $categoryIds);
        }
    
        // Brand filter
        if (!empty($request->brand)) {
            $brands = explode(',', $request->brand);
            $query->whereIn('brand', $brands);
        }
        
        
       $product_ids = [];
        if (!empty($request->variant_ids)) {
            $variant_ids = explode(',', $request->variant_ids);
        
            if (!empty($variant_ids)) {
                $product_ids = Variants::with('variantOptions')
                    ->whereIn('id', $variant_ids)
                    ->pluck('product_id')
                    ->unique()
                    ->toArray();
            }
        }
         \Log::info($product_ids);
        
        // Pagination
        $page = (int) ($request->page ?? 1);
        $limit = (int) ($request->limit ?? 10);
        $offset = ($page - 1) * $limit;
    
        // Fetch all products
        $allProducts = $query->get();
    
        // Price filtering
        $min = (float) ($request->min_price ?? 0);
        $max = (float) ($request->max_price ?? 999999);
        if ($min > $max) {
            [$min, $max] = [$max, $min];
        }
    
        $filtered = $allProducts->filter(function ($product) use ($min, $max) 
        {
            $filteredSkus = collect($product->skuNew)->filter(function ($sku) use ($min, $max) {
                $price = (float) ($sku->special_price > 0 ? $sku->special_price : $sku->price);
                return $price >= $min && $price <= $max;
            });
        
            $product->skuNew = $filteredSkus->values();
            return $filteredSkus->isNotEmpty();
        });
        
        $sort = $request->sort ?? null;
        if ($sort === 'oldtoNew') {
            $filtered = $filtered->sortBy('updated_at')->values();
        } elseif ($sort === 'newtoOld') {
            $filtered = $filtered->sortByDesc('updated_at')->values();
        }
        
        // pagination after sorting
        $total = $filtered->count();
        $products = $filtered->slice($offset, $limit)->values();

    
        // Clean HTML from description
        foreach ($products as $product) {
            $product->description = strip_tags($product->description);
        }
    
        // Wishlist and cart flags
        $userId = Auth::guard('api')->id();
        foreach ($products as $product) {
            $product->is_cart_added = CartItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
            $product->is_wishlist_added = WishlistItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
        }
    
        // Unique brands for UI
        $brandsQuery = Product::select('brand')->distinct();
        if (!empty($request->category_slug)) {
            $categoryIds = Category::where('slug', $request->category_slug)->pluck('id')->toArray();
            $brandsQuery->whereIn('category_ids', $categoryIds);
        }
        $categoryBrands = $brandsQuery->pluck('brand');
    
        return response()->json([
            'status' => true,
            'current_page' => $page,
            'per_page' => $limit,
            'last_page' => ceil($total / $limit),
            'products' => $products,
            'categories' => $categories,
            'brands' => $categoryBrands,
        ]);
    }
    
  */  
    
    public function getAllProducts(Request $request)
{
    $categories = Category::select('id', 'category_name', 'slug', 'icon')->get();

    $query = Product::where('is_published', 'yes')
        ->where('is_finished', 'yes')
        ->with('category', 'skuNew', 'badge', 'variants.variantOptions')
        ->select(
            'id',
            'product_name',
            'category_ids',
            'badge_id',
            'slug',
            'brand',
            'description',
            'short_description',
            'meta_description',
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
            DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
            'type',
            'updated_at'
        );

    // Category filter
    if (!empty($request->category_slug)) {
        $categoryIds = Category::where('slug', $request->category_slug)->pluck('id')->toArray();
        $query->whereIn('category_ids', $categoryIds);
    }

    // Brand filter
    if (!empty($request->brand)) {
        $brands = explode(',', $request->brand);
        $query->whereIn('brand', $brands);
    }

    // change: Variant filter using attribute name and option
    $product_ids = [];

    if (!empty($request->variant_attribute) && !empty($request->variant_option)) {
        $attributes = explode(',', $request->variant_attribute);
        $options = explode(',', $request->variant_option);
    
        if (count($attributes) === count($options)) {
            $mergedProductIds = [];
    
            foreach ($attributes as $index => $attribute) {
                $option = $options[$index];
    
                $productIds = Variants::where('attribute_name', $attribute)
                    ->whereHas('variantOptions', function ($query) use ($option) {
                        $query->where('option_name', $option);
                    })
                    ->pluck('product_id')
                    ->toArray();
    
                $mergedProductIds = array_merge($mergedProductIds, $productIds);
            }
    
            // Remove duplicates
            $product_ids = array_unique($mergedProductIds);
    
            if (!empty($product_ids)) {
                $query->whereIn('id', $product_ids);
            } else {
                $query->whereRaw('0=1'); // No matches
            }
        }
    }
    // \Log::info($product_ids);

    // Pagination
    $page = (int) ($request->page ?? 1);
    $limit = (int) ($request->limit ?? 10);
    $offset = ($page - 1) * $limit;

    // Fetch all products
    $allProducts = $query->get();

    // Price filtering
    $min = (float) ($request->min_price ?? 0);
    $max = (float) ($request->max_price ?? 999999);
    if ($min > $max) {
        [$min, $max] = [$max, $min];
    }

    $filtered = $allProducts->filter(function ($product) use ($min, $max) {
        $filteredSkus = collect($product->skuNew)->filter(function ($sku) use ($min, $max) {
            $price = (float) ($sku->special_price > 0 ? $sku->special_price : $sku->price);
            return $price >= $min && $price <= $max;
        });

        $product->skuNew = $filteredSkus->values();
        return $filteredSkus->isNotEmpty();
    });

    // Sorting
    $sort = $request->sort ?? null;
    if ($sort === 'oldtoNew') {
        $filtered = $filtered->sortBy('updated_at')->values();
    } elseif ($sort === 'newtoOld') {
        $filtered = $filtered->sortByDesc('updated_at')->values();
    }

    // Pagination after sorting
    $total = $filtered->count();
    $products = $filtered->slice($offset, $limit)->values();

    // Clean HTML from description
    foreach ($products as $product) {
        $product->description = strip_tags($product->description);
    }

    // Wishlist and cart flags
    $userId = Auth::guard('api')->id();
    foreach ($products as $product) {
        $product->is_cart_added = CartItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
        $product->is_wishlist_added = WishlistItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
    }

    // Unique brands for UI
    $brandsQuery = Product::select('brand')->distinct();
    if (!empty($request->category_slug)) {
        $categoryIds = Category::where('slug', $request->category_slug)->pluck('id')->toArray();
        $brandsQuery->whereIn('category_ids', $categoryIds);
    }
    $categoryBrands = $brandsQuery->pluck('brand');

    return response()->json([
        'status' => true,
        'current_page' => $page,
        'per_page' => $limit,
        'last_page' => ceil($total / $limit),
        'products' => $products,
        'categories' => $categories,
        'brands' => $categoryBrands,
    ]);
}




    public function getShopByCatProducts()
    {
        $categories = Category::select('id', 'category_name', 'slug', 'icon')->get();
        $selectedProducts = collect();
        $categoryIds = Category::pluck('id');
    
        foreach ($categoryIds as $categoryId) {
            $product = Product::with('sku', 'badge')
                ->where('is_published','yes')
                ->where('category_ids', $categoryId)
                ->select('id', 
                'product_name', 
                'category_ids', 
                'badge_id', 
                'slug', 
                'brand', 
                'description', 
                'short_description', 
                'meta_description', 
                DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
                DB::raw("CONCAT('" . asset('public/images/product/') . "/', image2) AS image2"),
                DB::raw("CONCAT('" . asset('public/images/product/') . "/', image3) AS image3"),
                DB::raw("CONCAT('" . asset('public/images/product/') . "/', image4) AS image4"),
                DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
                'type')
                ->first();
            if ($product) {
                $selectedProducts->push($product);
            }
            if ($selectedProducts->count() >= 6) {
                break;
            }
        }
        $userId = Auth::guard('api')->id();
        foreach ($selectedProducts as $product) {
            
            $isCartAdded = CartItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
            $product->is_cart_added = $isCartAdded;
            
           
            
            $isWishlistAdded = WishlistItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
            $product->is_wishlist_added = $isWishlistAdded;
        }
        return response()->json([
            'status' => true,
            'total_products' => $selectedProducts->count(),
            'products' => $selectedProducts,
        ]);  
    }
    
    // for featured products
    public function getFeaturedProducts()
    {
        $query = Product::where('is_published','yes')->where('is_finished', 'yes')->where('is_featured','yes')->with('category','skuNew','badge','variants.variantOptions')->select(
            'id',
            'product_name',
            'category_ids',
            'badge_id',
            'slug',
            'brand',
            'description',
            'short_description',
            'meta_description',
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image2) AS image2"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image3) AS image3"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image4) AS image4"),
            DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
            'type');
        $take = 8;
        $products = $query->take($take)->get();
        $userId = Auth::guard('api')->id();
        foreach ($products as $product) {
            $isCartAdded = CartItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
            $product->is_cart_added = $isCartAdded;
            
            $isWishlistAdded = WishlistItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
            $product->is_wishlist_added = $isWishlistAdded;
        }
        return response()->json([
            'status' => true,
            'total_products' => $products->count(),
            'products' => $products,
        ]); 
    }
    
    
    public function getProductPrice(Request $request)
    {
        // dd($request);
        // \Log::info($request);
        $variantOptions = $request->input('variant_option_ids', []);
        $variantString = implode('-', $variantOptions);
        // \Log::info($variantString);
        $com=Combination::where('var_option_id',$variantString)->first();
        // \Log::info($com);
        $sku=Sku::where('combination_id',$com->id)->where('combination_set',$com->combination)->first();
        
        $productImages = ProductImages::where('sku_id', $sku->id)
            ->where('product_id', $sku->product_id)
            ->get(['id', 'product_id', 'sku_id', 'image'])
            ->map(function ($img) {
                return [
                    'id' => $img->id,
                    'product_id' => $img->product_id,
                    'sku_id' => $img->sku_id,
                    'image' => asset('public/images/products/image/' . $img->image), // Update path as needed
                ];
            });
        // \Log::info($sku);
        return response()->json(['status'=>true,'message'=>'price','sku'=>$sku,'images'=>$productImages]);
        
    }
    
    /*public function searchProducts(Request $request)
    {
        $search = trim($request->input('search'));
        if (!$search) {
            return response()->json([
                'status' => false,
                'message' => 'Search keyword is required',
                'products' => [],
                'categories' => [],
                'suggestions' => []
            ]);
        }
        $products = Product::with('category')->where('is_published', 'yes')
            ->where(function ($query) use ($search) {
                $query->where('product_name', 'LIKE', "%{$search}%")
                    ->orWhere('brand', 'LIKE', "%{$search}%")
                    ->orWhere('short_description', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            })
            ->select('id', 'product_name', 'slug', 'brand', 'icon','category_ids')
            ->limit(10)
            ->get();
        $fetchedProductNames = $products->pluck('product_name')->toArray();
        $categoryIds = $products->pluck('category_ids')->unique()->toArray();
        $categories = Category::whereIn('id', $categoryIds)
            ->select('id', 'category_name', 'slug', 'icon')
            ->get();
        $searchWords = explode(' ', $search);
        $baseKeyword = $searchWords[0]; // Get the first word (e.g., "iPhone" from "iPhone 14")
    
        // Fetch related product suggestions dynamically
        $suggestions = Product::where('is_published', 'yes')
            ->where('product_name', 'NOT LIKE', "%{$search}%") // Exclude exact search term
            ->where(function ($query) use ($baseKeyword) {
                $query->where('product_name', 'LIKE', "%{$baseKeyword}%") // Find similar names
                      ->orWhere('brand', 'LIKE', "%{$baseKeyword}%"); // Match brand if needed
            })
            ->orderByRaw("CASE WHEN product_name LIKE '{$baseKeyword}%' THEN 1 ELSE 2 END") // Prioritize matches starting with the keyword
            ->select('product_name')
            ->distinct()
            ->limit(5)
            ->pluck('product_name');
        return response()->json([
            'status' => true,
            'products' => $products,
            'categories' => $categories,
            'suggestions' => $suggestions
        ]); 
    }*/
    
    public function searchProducts(Request $request)
    {
        $search = trim($request->input('search'));
    
        if (!$search) {
            return response()->json([
                'status' => false,
                'message' => 'Search keyword is required',
                'products' => [],
                'categories' => [],
                'suggestions' => []
            ]);
        }
        $searchWithoutSpace = str_replace(' ', '', $search);
        $products = Product::with('category','skuNew','badge','variants.variantOptions')->where('is_published', 'yes')->where('is_finished', 'yes')
                ->where(function ($query) use ($search, $searchWithoutSpace) {
                $query->whereRaw("REPLACE(product_name, ' ', '') LIKE ?", ["%{$searchWithoutSpace}%"])
                    ->orWhereRaw("REPLACE(brand, ' ', '') LIKE ?", ["%{$searchWithoutSpace}%"])
                    ->orWhere('short_description', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            })
            ->select('id', 'product_name', 'slug', 'brand', DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"), 'category_ids')
            ->limit(10)
            ->get();
        $fetchedProductNames = $products->pluck('product_name')->toArray();
        $fetchedProductCategoryIds = $products->pluck('category_ids')->toArray();
        $categoryIds = $products->pluck('category_ids')->unique()->toArray();
        $categories = Category::whereIn('id', $categoryIds)
            ->select('id', 'category_name', 'slug', 'icon')
            ->get();
    
        $searchWords = explode(' ', $search);
        $baseKeyword = $searchWords[0];

       $suggestions = Product::where('is_published', 'yes')
        ->whereNotIn('product_name', $fetchedProductNames) 
        ->whereIn('category_ids', $fetchedProductCategoryIds) 
        ->distinct()
        ->limit(5)
        ->select('id', 'product_name', 'category_ids','slug')
        ->get();

    
        return response()->json([
            'status' => true,
            'products' => $products,
            'categories' => $categories,
            'suggestions' => $suggestions
        ]);
    }

    
    // for get newly arrived product
    public function getNewProducts()
    {
        $query = Product::where('is_published','yes')->where('is_finished', 'yes')->where('is_new','yes')->with('category','skuNew','badge','variants.variantOptions')->select(
            'id',
            'product_name',
            'category_ids',
            'badge_id',
            'slug',
            'brand',
            'description',
            'short_description',
            'meta_description',
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image2) AS image2"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image3) AS image3"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image4) AS image4"),
            DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
            'type');
            
        $take = 4;
        
        $products = $query->inRandomOrder()->take($take)->get();
        $userId = Auth::guard('api')->id();
        foreach ($products as $product) {
            $isCartAdded = CartItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
            $product->is_cart_added = $isCartAdded;
            
            
        
            $isWishlistAdded = WishlistItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
            $product->is_wishlist_added = $isWishlistAdded;
        }
        return response()->json([
            'status' => true,
            'total_products' => $products->count(),
            'products' => $products,
        ]); 
    }
    
    // for get trending
    public function getTrendingProducts()
    {
        $query = Product::where('is_published','yes')->where('is_finished', 'yes')->where('is_trending','yes')->with('category','skuNew','badge','variants.variantOptions')->select(
            'id',
            'product_name',
            'category_ids',
            'badge_id',
            'slug',
            'brand',
            'description',
            'short_description',
            'meta_description',
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image2) AS image2"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image3) AS image3"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image4) AS image4"),
            DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
            'type');
        $take = 4;
        $products = $query->inRandomOrder()->take($take)->get();
        $userId = Auth::guard('api')->id();
        foreach ($products as $product) {
            $isCartAdded = CartItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
            $product->is_cart_added = $isCartAdded;
            
            
        
            $isWishlistAdded = WishlistItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
            $product->is_wishlist_added = $isWishlistAdded;
        }
        return response()->json([
            'status' => true,
            'total_products' => $products->count(),
            'products' => $products,
        ]); 
    }
    
    
    public function getCategorisedProducts($slug)
    {
        $category=Category::where('slug',$slug)->first();
        $categoryIds=$category->id;
        \Log::info($categoryIds);
        $query = Product::where('is_published','yes')->where('is_finished', 'yes')->where('category_ids',$categoryIds)->with('category','skuNew','badge','variants.variantOptions')->select(
            'id',
            'product_name',
            'category_ids',
            'badge_id',
            'slug',
            'brand',
            'description',
            'short_description',
            'meta_description',
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image2) AS image2"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image3) AS image3"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image4) AS image4"),
            DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
            'type');
        
        $take = 4;
        $products = $query->inRandomOrder()->take($take)->get();
        
        return response()->json([
            'status' => true,
            'products' => $products,
        ]); 
    }
   
   
   
    public function getPriceFilteredProducts(Request $request)
    {
        $min = (float) ($request->min_price ?? 0);
        $max = (float) ($request->max_price ?? 999999);
        if ($min > $max) {
            [$min, $max] = [$max, $min];
        }
    
        $query = Product::where('is_published', 'yes')
            ->where('is_finished', 'yes')
            ->with(['category', 'skuNew', 'badge', 'variants.variantOptions'])
            ->select(
                'id',
                'product_name',
                'category_ids',
                'badge_id',
                'slug',
                'brand',
                'description',
                'short_description',
                'meta_description',
                DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
                DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
                'type'
            );
    
        // If category_slug is provided, filter by it
        if ($request->has('category_slug')) {
            $category = Category::where('slug', $request->category_slug)->first();
            if ($category) {
                $query->where('category_ids', $category->id);
            } else {
                // No matching category found
                return response()->json([
                    'status' => true,
                    'total_products' => 0,
                    'products_inpage' => 0,
                    'current_page' => 1,
                    'per_page' => 15,
                    'last_page' => 1,
                    'products' => [],
                ]);
            }
        }
    
        $products = $query->get();
    
    
        $filtered = $products->filter(function ($product) use ($min, $max) {
            $filteredSkus = collect($product->skuNew)->filter(function ($sku) use ($min, $max) {
                $special = (float) $sku->special_price;
                $regular = (float) $sku->price;
                $price = ($special > 0) ? $special : $regular;
    
                return $price >= $min && $price <= $max;
            });
    
            $product->skuNew = $filteredSkus->values();
            return $filteredSkus->isNotEmpty();
        });
    
        $page = (int) ($request->page ?? 1);
        $limit = 15;
        $total = $filtered->count();
        $lastPage = (int) ceil($total / $limit);
        $offset = ($page - 1) * $limit;
    
        $paginated = $filtered->slice($offset, $limit)->values();
    
        $userId = Auth::guard('api')->id();
    
        foreach ($paginated as $product) {
            $product->description = strip_tags($product->description);
    
            $product->is_cart_added = CartItems::where('customer_id', $userId)
                ->where('product_id', $product->id)
                ->exists();
    
            $product->is_wishlist_added = WishlistItems::where('customer_id', $userId)
                ->where('product_id', $product->id)
                ->exists();
        }
    
        return response()->json([
            'status' => true,
            'total_products' => $total,
            'products_inpage' => $paginated->count(),
            'current_page' => $page,
            'per_page' => $limit,
            'last_page' => $lastPage,
            'products' => $paginated,
        ]);
    }
    
    
    public function getAllVariants(Request $request)
    {
        \Log::info($request);
        $productIds = [];
    
        if (!empty($request->category_slug)) {
            $category = Category::where('slug', $request->category_slug)->first();
    
            if ($category) {
                $productIds = Product::where('category_ids', $category->id)->pluck('id')->toArray();
            }
        }
        
           $variants = Variants::with('variantOptions')
            ->when(!empty($productIds), function ($query) use ($productIds) {
                $query->whereIn('product_id', $productIds);
            })
            ->get();
        
        // Group by attribute_name to ensure uniqueness
        $uniqueVariants = $variants->groupBy('attribute_name')->map(function ($group) {
            $firstVariant = $group->first(); // get the first variant for this attribute
            return [
                'id' => $firstVariant->id,
                'attribute_name' => $firstVariant->attribute_name,
                'options' => $group->flatMap(function ($variant) {
                    return $variant->variantOptions->pluck('option_name');
                })->unique()->values(), // get all unique options under this attribute
            ];
        })->values(); // reset array keys
        
        return response()->json([
            'status' => true,
            'variants' => $uniqueVariants,
        ]);

           
       
        
    }

}