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

use App\Models\Offer;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ProductApiController extends Controller
{
    public function index()
    {
        $data = [];
        $categories = Category::get();
        foreach ($categories as $category) {
            $products = Product::with('category','skuNew','badge','variants.variantOptions')
                ->where('is_published','yes')
                ->where('is_finished', 'yes')
                ->where('category_id', $category->id)->select(
                                                        'id',
                                                        'product_name',
                                                        'category_id',
                                                        'badge_id',
                                                        'slug',
                                                        'brand',
                                                        'description',
                                                        'short_description',
                                                        'meta_description',
                                                        DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
                                                        /*  DB::raw("CONCAT('" . asset('public/images/product/') . "/', image2) AS image2"),
                                                            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image3) AS image3"),
                                                            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image4) AS image4"),*/
                                                        DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
                                                        
                                                        /*'image1',
                                                        'image2',
                                                        'image3',
                                                        'image4',
                                                        'icon',*/
                                                        'type'
                                                        )->take(8);
            $products->transform(function ($product) 
            {
                $product->description = strip_tags($product->description);
                return $product;
            });
            $category->products = $products->get()->toArray();
            $data[] = $category;

        }
        return response()->json(['data' => $data]);

    }
    
    
    
    public function productDetails($id)
    {
        $userId = auth('api')->id();  
        //   \Log::info($userId);
        
        $product = Product::with(['category','badge','variants.variantOptions','skuNew' => function ($query) use ($userId) 
                                {
                                    $query->with([
                                        'sku_images',
                                        'cartItem' => function ($q) use ($userId) {
                                            // \Log::info('Customer ID in cartItem query: ' . $userId);
                                            $q->where('customer_id', $userId);
                                        }
                                    ]);
                                     
                                }
                            ])
                            ->where('slug', $id)->where('is_finished', 'yes')
                            ->select('id',
                                    'product_name',
                                    'category_id',
                                    'badge_id',
                                    'slug',
                                    'brand',
                                    'description',
                                    'short_description',
                                    'meta_description',
                                    DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
                                    /*  DB::raw("CONCAT('" . asset('public/images/product/') . "/', image2) AS image2"),
                                        DB::raw("CONCAT('" . asset('public/images/product/') . "/', image3) AS image3"),
                                        DB::raw("CONCAT('" . asset('public/images/product/') . "/', image4) AS image4"),*/
                                    DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
                                    
                                    /*'image1',
                                    'image2',
                                    'image3',
                                    'image4',
                                    'icon',*/
                                    'type'
                                    )
                                    ->first();
        
        if (!$product) 
        {

            return response()->json(['status'=>false,'message'=>'Product Not Found']);
        }
       $product->description = strip_tags($product->description);


       

        $reviews = Review::where('product_id', $product->id)->where('is_approved', 'yes')->orderby('created_at', 'DESC')->limit(10)->get();
        $review_count = Review::where('product_id', $product->id)->where('is_approved', 'yes')->count();
        $averageRating = Review::where('product_id', $product->id)
            ->where('is_approved', 'yes')
            ->avg('rating');
        $userId = Auth::guard('api')->id();
        
        $isCartAdded = CartItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
        $isWishlistAdded = WishlistItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
        
        $product->is_cart_added = $isCartAdded;
        $product->is_wishlist_added = $isWishlistAdded;

        return response()->json([
            'product' => $product, 
            'reviews' => $reviews,
            'review_count' => $review_count,
            'averageRating' => $averageRating]);
    }
    
    
    
    public function getProductWithCartSkus($productId)
    {
        $userId = auth()->id();
    
        // Load product with skus and sku images
        $product = Product::with('skuNew.sku_images')->findOrFail($productId);
        $product->description = strip_tags($product->description);
        // Extract SKU IDs
        $skuIds = $product->skuNew->pluck('id');
    
        // Get matching cart items for the logged-in user
        $cartItems = CartItems::whereIn('sku_id', $skuIds)
                              ->where('customer_id', $userId)
                              ->get()
                              ->keyBy('sku_id'); // key by sku_id for easy lookup
    
        // Attach cart info manually
        foreach ($product->skuNew as $sku) {
            $cartItem = $cartItems->get($sku->id);
            $sku->cart_item_id = $cartItem->id ?? null;
            $sku->quantity = $cartItem->quantity ?? 0;
        }
    
        return response()->json($product);
    }

    
    
    /*public function productDetails($id)
    {
    \Log::info('Request Headers1:', request()->headers->all());

    $product = Product::with('category', 'sku', 'badge', 'variants.variantOptions')
        ->where('id', $id)
        ->select('id', 'product_name', 'category_id', 'badge_id', 'slug', 'brand', 'description', 'short_description', 'meta_description', 'image1', 'image2', 'image3', 'image4', 'icon', 'type')
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
        $product = Product::with('category','badge','variants.variantOptions')->where('slug', $id)->select('id','product_name','category_id','badge_id','slug','brand','description','short_description','meta_description','image1','image2','image3','image4','icon','type')->first();
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
                $productCount = Product::whereRaw("FIND_IN_SET(?, category_id)", [$parent->id])->count();
        
                $subcategories = $allCategories->filter(function ($sub) use ($parent) {
                    return $sub->parent_category_id == $parent->id && $sub->is_parent === 'no';
                })->map(function ($sub) {
                    $sub->product_count = Product::whereRaw("FIND_IN_SET(?, category_id)", [$sub->id])->count();
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
                $productCount = Product::whereRaw("FIND_IN_SET(?, category_id)", [$cat->id])->count();
    
                return [
                    'id' => $cat->id,
                    'category_name' => $cat->category_name,
                    'slug' => $cat->slug,
                    'icon' => $cat->icon,
                    'description' => strip_tags($cat->description),
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
            $productCount = Product::whereRaw("FIND_IN_SET(?, category_id)", [$parent->id])->count();
    
            return [
                'id' => $parent->id,
                'category_name' => $parent->category_name,
                'slug' => $parent->slug,
                'icon' => $parent->icon,
                'description' => strip_tags($parent->description),
                'product_count' => $productCount,
                'subcategories' => $getChildren($parent->id)
            ];
        });
    
        return response()->json([
            'status' => true,
            'data' => $categoriesWithSub
        ]);
    }


    public function getAllProducts(Request $request)
    {
        // \Log::info($request->all());
        
        $categories = Category::select('id','category_name','slug','icon')->get();
        $query = Product::where('is_published','yes')->where('is_finished', 'yes')->with('category','skuNew','badge','variants.variantOptions')->select(
            'id',
            'product_name',
            'category_id',
            'badge_id',
            'slug',
            'brand',
            'description',
            'short_description',
            'meta_description',
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
            /*  DB::raw("CONCAT('" . asset('public/images/product/') . "/', image2) AS image2"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image3) AS image3"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image4) AS image4"),*/
            DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
            'type'
            );
            
        
        $page = $request->has('page') ? (int) $request->page : 1;
        $limit = 15;
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
        }
        foreach ($products as $product) {
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
                ->where('category_id', $categoryId)
                ->select('id', 
                'product_name', 
                'category_id', 
                'badge_id', 
                'slug', 
                'brand', 
                'description', 
                'short_description', 
                'meta_description', 
                DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
               /*  DB::raw("CONCAT('" . asset('public/images/product/') . "/', image2) AS image2"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image3) AS image3"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image4) AS image4"),*/
                DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
                'type')
                ->first();
            if ($product) {
                // Clean HTML from description
                $product->description = strip_tags($product->description);
                $product->short_description = strip_tags($product->short_description);
                
                $selectedProducts->push($product);
            }
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
            'category_id',
            'badge_id',
            'slug',
            'brand',
            'description',
            'short_description',
            'meta_description',
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
            /*  DB::raw("CONCAT('" . asset('public/images/product/') . "/', image2) AS image2"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image3) AS image3"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image4) AS image4"),*/
            DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
            'type');
        $products = $query->take($take)->get();
        $userId = Auth::guard('api')->id();
        foreach ($products as $product) {
            
            $product->description = strip_tags($product->description);
            
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
        $productImages=ProductImages::where('sku_id',$sku->id)->where('product_id',$sku->product_id)->get();
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
            ->select('id', 'product_name', 'slug', 'brand', 'icon','category_id')
            ->limit(10)
            ->get();
        $fetchedProductNames = $products->pluck('product_name')->toArray();
        $categoryIds = $products->pluck('category_id')->unique()->toArray();
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
            ->select('id', 'product_name', 'slug', 'brand', 'icon', 'category_id')
            ->limit(15)
            ->get();
        $fetchedProductNames = $products->pluck('product_name')->toArray();
        $fetchedProductCategoryIds = $products->pluck('category_id')->toArray();
        $categoryIds = $products->pluck('category_id')->unique()->toArray();
        $categories = Category::whereIn('id', $categoryIds)
            ->select('id', 'category_name', 'slug', 'icon')
            ->get();
    
        $searchWords = explode(' ', $search);
        $baseKeyword = $searchWords[0];

       $suggestions = Product::where('is_published', 'yes')
        ->whereNotIn('product_name', $fetchedProductNames) 
        ->whereIn('category_id', $fetchedProductCategoryIds) 
        ->distinct()
        ->limit(15)
        ->select('id', 'product_name', 'category_id','slug')
        ->get();
        foreach ($products as $product) {
            $product->description = strip_tags($product->description);
        }
    
        return response()->json([
            'status' => true,
            'products' => $products,
            'categories' => $categories,
            'suggestions' => $suggestions
        ]);
    }

    
    // for get newly arrived product
    public function getNewProducts(Request $request)
    {
        
     
    
        $query = Product::where('is_published','yes')->where('is_finished', 'yes')->where('is_new','yes')->with('category','skuNew','badge','variants.variantOptions')->select(
            'id',
            'product_name',
            'category_id',
            'badge_id',
            'slug',
            'brand',
            'description',
            'short_description',
            'meta_description',
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
           /* DB::raw("CONCAT('" . asset('public/images/product/') . "/', image2) AS image2"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image3) AS image3"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image4) AS image4"),*/
            DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
            'type');
        
        
        $page = $request->has('page') ? (int) $request->page : 1;
        $limit = 15;
        $offset = ($page - 1) * $limit;
        $total = (clone $query)->count();
        $products = $query->skip($offset)->take($limit)->get();
        
        $userId = Auth::guard('api')->id();
        foreach ($products as $product) {
            $product->description = strip_tags($product->description);
    
            $isCartAdded = CartItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
            $product->is_cart_added = $isCartAdded;
       
            $isWishlistAdded = WishlistItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
            $product->is_wishlist_added = $isWishlistAdded;
        }
        return response()->json([
            'status' => true,
            'total_products' => $total,
            'current_page' => $page,
            'per_page' => $limit,
            //'total_products' => $products->count(),
            'last_page' => ceil($total / $limit),
            'products' => $products,
        ]); 
    }
    
    // for get trending
    public function getTrendingProducts(Request $request)
    {
       
        
        $query = Product::where('is_published','yes')->where('is_finished', 'yes')->where('is_trending','yes')->with('category','skuNew','badge','variants.variantOptions')->select(
            'id',
            'product_name',
            'category_id',
            'badge_id',
            'slug',
            'brand',
            'description',
            'short_description',
            'meta_description',
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
           /*  DB::raw("CONCAT('" . asset('public/images/product/') . "/', image2) AS image2"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image3) AS image3"),
            DB::raw("CONCAT('" . asset('public/images/product/') . "/', image4) AS image4"),*/
            DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
            'type');

        $page = $request->has('page') ? (int) $request->page : 1;
        $limit = 15;
        $offset = ($page - 1) * $limit;
        $total = (clone $query)->count();
        $products = $query->skip($offset)->take($limit)->get();
        
        $userId = Auth::guard('api')->id();
       foreach ($products as $product) {
            $product->description = strip_tags($product->description);
 
            $isCartAdded = CartItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
            $product->is_cart_added = $isCartAdded;
       
            $isWishlistAdded = WishlistItems::where('customer_id', $userId)->where('product_id', $product->id)->exists();
            $product->is_wishlist_added = $isWishlistAdded;
        }
        return response()->json([
            'status' => true,
            'total_products' => $total,
            'current_page' => $page,
            'per_page' => $limit,
            //'total_products' => $products->count(),
            'last_page' => ceil($total / $limit),
            'products' => $products,
            
        ]); 
    }
    
    
    
    
    public function setProductRating()
    {
        $product = Product::where('id',$request->product_id)->first();
           
        return response()->json([
            'status' => true,
            'total_products' => $products->count(),
            'products' => $products,
        ]); 
    }
    
     public function getOfferDetails()
    {
        $offer = Offer::where('is_apply', 'yes')->first();
        return response()->json([
            'offer' => $offer
            ]);
    }
    
    
    
    public function getOfferProducts()
    {
        $userId = Auth::guard('api')->id();
        
        $total = CartItems::where('customer_id',$userId)->first();
    
        $offer = Offer::where('is_apply', 'yes')->first();
    
        if (!$offer) {
            return response()->json(['status' => false, 'result' => 'No active offer found']);
        }
        if ($total->total >= $offer->offer_limit) 
        {
            $skus = Sku::with('sku_images')->get();

            $offer_products = [];
            
            foreach ($skus as $sku) {
                if ($sku->special_price < $sku->price) 
                {
                    if ($sku->special_price <= $offer->offer_limit) 
                    {
                        $offer_products[] = $sku;
                    }
                } 
                else 
                {
                    if ($sku->price <= $offer->offer_limit) 
                    {
                        $offer_products[] = $sku;
                    }
                }
            }
            
            return response()->json([
                'status' => true,
                'result' => 'success',
                'products' => $offer_products
            ]);

        } 
        else 
        {
            return response()->json(['status' => false, 'result' => 'no offer products available']);
        }
    }


   

    public function getFilteredProducts(Request $request)
    {
        $categories = Category::select('id', 'category_name', 'slug', 'icon')->get();
        // Build product query
        $query = Product::where('is_published', 'yes')
            ->where('is_finished', 'yes')
            ->with('category', 'skuNew', 'badge', 'variants.variantOptions')
            ->select(
                'id',
                'product_name',
                'category_id',
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
        if ($request->has('category_slug') && $request->category_slug != '') {
            $slug = $request->category_slug;
            $category = Category::where('slug', $slug)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }


    
        // Pagination
        $page = $request->has('page') ? (int) $request->page : 1;
        $limit = 15;
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
            'total products of all ' . $request->category_slug => $total,
            'current_page' => $page,
            'per_page' => $limit,
            //'total_products' => $products->count(),
            'last_page' => ceil($total / $limit),
            'products' => $products,
            'categories' => $categories,
        ]);
    }

/*

    public function getPriceFilteredProducts(Request $request)
    {
        $min = $request->min_price ?? 0;
        $max = $request->max_price ?? 999999;
    
        $query = Product::where('is_published', 'yes')
            ->where('is_finished', 'yes')
            ->with(['category', 'skuNew', 'badge', 'variants.variantOptions'])
            ->select(
                'id',
                'product_name',
                'category_id',
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
    
        $products = $query->get();
    
        $min = (float) ($request->min_price ?? 0);
        $max = (float) ($request->max_price ?? 999999);
        if ($min > $max) {
            [$min, $max] = [$max, $min];
        }
        
       $filtered = $products->filter(function ($product) use ($min, $max) {
            $filteredSkus = collect($product->skuNew)->filter(function ($sku) use ($min, $max) {
                $special = (float) $sku->special_price;
                $regular = (float) $sku->price;
                $price = ($special > 0) ? $special : $regular;
        
                return $price >= $min && $price <= $max;
            });
        
            // Replace product's skuNew with only matched SKUs
            $product->skuNew = $filteredSkus->values();
            return $filteredSkus->isNotEmpty();
        });

        // Paginate manually
        $page = $request->has('page') ? (int) $request->page : 1;
        $limit = 15;
        $total = $filtered->count();
        $lastPage = ceil($total / $limit);
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
*/
    
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
                'category_id',
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
                $query->where('category_id', $category->id);
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
    
    
    public function getLargestpriceproduct()
    {
        $products = Product::where('is_published', 'yes')
            ->where('is_finished', 'yes')
            ->with(['category', 'skuNew', 'badge', 'variants.variantOptions'])
            ->select(
                'id',
                'product_name',
                'category_id',
                'badge_id',
                'slug',
                'brand',
                'description',
                'short_description',
                'meta_description',
                DB::raw("CONCAT('" . asset('public/images/product/') . "/', image1) AS image1"),
                DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
                'type'
            )->get();
    
        $maxPrice = 0;
        $maxProduct = null;
        $maxSku = null;
    
        foreach ($products as $product) {
            foreach ($product->skuNew as $sku) {
                $price = (float) ($sku->special_price > 0 ? $sku->special_price : $sku->price);
                if ($price > $maxPrice) {
                    $maxPrice = $price;
                    $maxProduct = $product;
                    $maxSku = $sku;
                }
            }
        }
    
        if ($maxProduct) {
            return response()->json([
                'status' => true,
                'product_id' => $maxProduct->id,
                'product_name' => $maxProduct->product_name,
                'sku_id' => $maxSku->id,
                'price' => $maxPrice,
                'product' => $maxProduct,
                'sku' => $maxSku 
            ]);
        }

    
        return response()->json([
            'status' => false,
            'message' => 'No product found',
        ]);
    }


}
