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
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
class ProductApiController extends Controller
{
    public function index()
    {
        \Log::info("haii");
        try {
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
            return response()->json(['data' => $data], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    
    
    
    public function productDetails($id)
    {
        try {
            $userId = auth('api')->id();  
            //   \Log::info($userId);
            
            $product = Product::with([
                                'category',
                                'badge',
                                'variants.variantOptions',
                                'skuNew' => function ($query) use ($userId) {
                                    $query->with([
                                        'sku_images',
                                        'cartItem' => function ($q) use ($userId) {
                                            // \Log::info('Customer ID in cartItem query: ' . $userId);
                                            $q->where('customer_id', $userId);
                                        }
                                    ]);
                                }
                            ])
                            ->where('slug', $id)
                            ->where('is_finished', 'yes')
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
            
            if (!$product) {
                return response()->json(['status' => false, 'message' => 'Product Not Found'], 404);
            }
    
            $product->description = strip_tags($product->description);
    
            $reviews = Review::where('product_id', $product->id)
                             ->where('is_approved', 'yes')
                             ->orderby('created_at', 'DESC')
                             ->limit(10)
                             ->get();
    
            $review_count = Review::where('product_id', $product->id)
                                  ->where('is_approved', 'yes')
                                  ->count();
    
            $averageRating = Review::where('product_id', $product->id)
                                   ->where('is_approved', 'yes')
                                   ->avg('rating');
    
            $userId = Auth::guard('api')->id();
    
            $isCartAdded = CartItems::where('customer_id', $userId)
                                    ->where('product_id', $product->id)
                                    ->exists();
    
            $isWishlistAdded = WishlistItems::where('customer_id', $userId)
                                            ->where('product_id', $product->id)
                                            ->exists();
    
            $product->is_cart_added = $isCartAdded;
            $product->is_wishlist_added = $isWishlistAdded;
    
            return response()->json([
                'product' => $product,
                'reviews' => $reviews,
                'review_count' => $review_count,
                'averageRating' => $averageRating
            ], 200);
    
        }
        catch (AuthenticationException $e) 
        {
            return response()->json([
                'status' => false,
                'message' => 'Authentication failed. Please log in again.'
            ], 401);

        } 
        catch (\Exception $e) 
        {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while fetching products.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    
    public function getProductWithCartSkus($productId)
    {
        \Log::info("haii2");
        try {
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
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Product not found.'
            ], 404);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong.',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    
    public function getAllCategories()
    {
        \Log::info("haii3");
        try {
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
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while fetching categories.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function getAllProducts(Request $request)
    {
        \Log::info("haii4");
        try {
            // \Log::info($request->all());
    
            $categories = Category::select('id','category_name','slug','icon')->get();
            $query = Product::where('is_published','yes')
                ->where('is_finished', 'yes')
                ->with('category','skuNew','badge','variants.variantOptions')
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
                    /*  DB::raw("CONCAT('" . asset('public/images/product/') . "/', image2) AS image2"),
                        DB::raw("CONCAT('" . asset('public/images/product/') . "/', image3) AS image3"),
                        DB::raw("CONCAT('" . asset('public/images/product/') . "/', image4) AS image4"),*/
                    DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
                    'type'
                );
    
            /*
            $page = $request->has('page') ? (int) $request->page : 1;
            $limit = 15;
            $offset = ($page - 1) * $limit;
            $total = (clone $query)->count();
            $products = $query->skip($offset)->take($limit)->get();
            */
            $page = $request->has('page') ? (int) $request->page : null;
            $limit = 15;
    
            if ($page) {
                $offset = ($page - 1) * $limit;
                $total = (clone $query)->count();
                $products = $query->skip($offset)->take($limit)->get();
            } else {
                $total = $query->count();
                $products = $query->get();
            }
    
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
    
            if ($page) 
            {
                return response()->json([
                    'status' => true,
                    'current_page' => $page,
                    'per_page' => $limit,
                    'total' => $total,
                    'last_page' => ceil($total / $limit),
                    'products' => $products,
                ]);
            } 
            else 
            {
                return response()->json([
                    'status' => true,
                    'total' => $total,
                    'products' => $products,
                ]);
            }
    
            /*
            // Original Response Format (Always paginated):
            return response()->json([
                'status' => true,
                'current_page' => $page,
                'per_page' => $limit,
                'total' => $total,
                'last_page' => ceil($total / $limit),
                'products' => $products,
            ]);
            */
    
        } 
        catch (AuthenticationException $e) 
        {
            return response()->json([
                'status' => false,
                'message' => 'Authentication failed. Please log in again.'
            ], 401);

        } 
        catch (\Exception $e) 
        {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while fetching products.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
    
    
    public function getShopByCatProducts()
    {
        \Log::info("haii5");
        try {
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
                        'type'
                    )
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
    
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated',
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    // for featured products
    public function getFeaturedProducts()
    {
        \Log::info("haii6");
        try {
            $take = request()->get('take', 8); // Default to 8 if not provided
    
            $query = Product::where('is_published', 'yes')
                ->where('is_finished', 'yes')
                ->where('is_featured', 'yes')
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
                    /*  DB::raw("CONCAT('" . asset('public/images/product/') . "/', image2) AS image2"),
                        DB::raw("CONCAT('" . asset('public/images/product/') . "/', image3) AS image3"),
                        DB::raw("CONCAT('" . asset('public/images/product/') . "/', image4) AS image4"),*/
                    DB::raw("CONCAT('" . asset('public/images/product/icon/') . "/', icon) AS icon"),
                    'type'
                );
    
            $products = $query->take($take)->get();
    
            $userId = Auth::guard('api')->id();
    
            foreach ($products as $product) {
                $product->description = strip_tags($product->description);
    
                $isCartAdded = CartItems::where('customer_id', $userId)
                    ->where('product_id', $product->id)
                    ->exists();
                $product->is_cart_added = $isCartAdded;
    
                $isWishlistAdded = WishlistItems::where('customer_id', $userId)
                    ->where('product_id', $product->id)
                    ->exists();
                $product->is_wishlist_added = $isWishlistAdded;
            }
    
            return response()->json([
                'status' => true,
                'total_products' => $products->count(),
                'products' => $products,
            ]);
    
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
    public function getProductPrice(Request $request)
    {
        \Log::info("haii7");
        try {
    
            $variantOptions = $request->input('variant_option_ids', []);
    
            if (!is_array($variantOptions) || empty($variantOptions)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Variant options are required'
                ], 422);
            }
    
            $variantString = implode('-', $variantOptions);
    
            $com = Combination::where('var_option_id', $variantString)->first();
    
            if (!$com) {
                return response()->json([
                    'status' => false,
                    'message' => 'No combination found for the given variant options'
                ], 404);
            }
    
            $sku = Sku::where('combination_id', $com->id)
                      ->where('combination_set', $com->combination)
                      ->first();
    
            if (!$sku) {
                return response()->json([
                    'status' => false,
                    'message' => 'SKU not found for the selected combination'
                ], 404);
            }
    
            $productImages = ProductImages::where('sku_id', $sku->id)
                                          ->where('product_id', $sku->product_id)
                                          ->get();
 
            return response()->json([
                'status' => true,
                'message' => 'price',
                'sku' => $sku,
                'images' => $productImages
            ]);
    
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    
    public function searchProducts(Request $request)
    {
        \Log::info("haii8");
        try {
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
    
            $products = Product::with('category', 'skuNew', 'badge', 'variants.variantOptions')
                ->where('is_published', 'yes')
                ->where('is_finished', 'yes')
                ->where(function ($query) use ($search, $searchWithoutSpace) {
                    $query->whereRaw("REPLACE(product_name, ' ', '') LIKE ?", ["%{$searchWithoutSpace}%"])
                        ->orWhereRaw("REPLACE(brand, ' ', '') LIKE ?", ["%{$searchWithoutSpace}%"])
                        ->orWhere('short_description', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%");
                })
                ->select(
                    'id',
                    'product_name',
                    'slug',
                    'brand',
                    'icon',
                    'category_id',
                    'description',
                    'short_description'
                )
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
                ->select('id', 'product_name', 'category_id', 'slug')
                ->get();
    
            foreach ($products as $product) {
                $product->description = strip_tags($product->description);
                $product->short_description = strip_tags($product->short_description);
            }
    
            return response()->json([
                'status' => true,
                'products' => $products,
                'categories' => $categories,
                'suggestions' => $suggestions
            ]);
    
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function getNewProducts(Request $request)
    {
        \Log::info("haii9");
        try {
            $query = Product::where('is_published','yes')
                ->where('is_finished', 'yes')
                ->where('is_new','yes')
                ->with('category','skuNew','badge','variants.variantOptions')
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
                    /* DB::raw("CONCAT('" . asset('public/images/product/') . "/', image2) AS image2"),
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
    
            $userId = Auth::guard('api')->id();
    
            foreach ($products as $product) {
                $product->description = strip_tags($product->description);
    
                $isCartAdded = CartItems::where('customer_id', $userId)
                                        ->where('product_id', $product->id)
                                        ->exists();
                $product->is_cart_added = $isCartAdded;
    
                $isWishlistAdded = WishlistItems::where('customer_id', $userId)
                                                ->where('product_id', $product->id)
                                                ->exists();
                $product->is_wishlist_added = $isWishlistAdded;
            }
    
            return response()->json([
                'status' => true,
                'total_products' => $total,
                'current_page' => $page,
                'per_page' => $limit,
                // 'total_products' => $products->count(),
                'last_page' => ceil($total / $limit),
                'products' => $products,
            ]);
    
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated',
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    

    public function getTrendingProducts(Request $request)
    {
        \Log::info("haii10");
        try {
            $query = Product::where('is_published','yes')
                ->where('is_finished', 'yes')
                ->where('is_trending','yes')
                ->with('category','skuNew','badge','variants.variantOptions')
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
    
            $userId = Auth::guard('api')->id();
    
            foreach ($products as $product) {
                $product->description = strip_tags($product->description);
    
                $isCartAdded = CartItems::where('customer_id', $userId)
                                        ->where('product_id', $product->id)
                                        ->exists();
                $product->is_cart_added = $isCartAdded;
    
                $isWishlistAdded = WishlistItems::where('customer_id', $userId)
                                                ->where('product_id', $product->id)
                                                ->exists();
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
    
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated',
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
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
        try {
            $offer = Offer::where('is_apply', 'yes')->first();
    
            if (!$offer) {
                return response()->json([
                    'status' => false,
                    'message' => 'No active offer found.',
                    'offer' => null
                ]);
            }
    
            return response()->json([
                'status' => true,
                'offer' => $offer
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch offer details.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    
    
    public function getOfferProducts()
    {
        \Log::info("haii11");
        try {
            $userId = Auth::guard('api')->id();
            
            $total = CartItems::where('customer_id', $userId)->first();
        
            $offer = Offer::where('is_apply', 'yes')->first();
        
            if (!$offer) {
                return response()->json(['status' => false, 'result' => 'No active offer found']);
            }
    
            if ($total && $total->total >= $offer->offer_limit) 
            {
                $skus = Sku::with('sku_images')->get();
    
                $offer_products = [];
                
                foreach ($skus as $sku) {
                    
                    if ($sku->quantity <= 0) 
                    {
                        continue; 
                    }
    
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
    
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
    
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated',
            ], 401);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



   

    public function getFilteredProducts(Request $request)
    {
        \Log::info("haii12");
        try {
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
                'total_products' => $total,
                'current_page' => $page,
                'per_page' => $limit,
                //'total_products' => $products->count(),
                'last_page' => ceil($total / $limit),
                'products' => $products,
                'categories' => $categories,
            ]);
    
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
    
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    
    public function getPriceFilteredProducts(Request $request)
    {
        \Log::info("haii13");
        try {
            $min = (float) ($request->min_price ?? 0);
            $max = (float) ($request->max_price ?? 999999);
            if ($min > $max) {
                [$min, $max] = [$max, $min];
            }
            $sortBy = $request->sort_by;
    
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
                    'type',
                    'is_new',
                    'is_trending',
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
    
            // sort  by  product_type
            $productType = $request->product_type;
            if ($productType === 'new') {
                $filtered = $filtered->filter(function ($product) {
                    return $product->is_new == 'yes';
                })->values();
            } elseif ($productType === 'trending') {
                $filtered = $filtered->filter(function ($product) {
                    return $product->is_trending == 'yes';
                })->values();
            }
    
            // sort  by  low to high or high to low
            if ($sortBy === 'low_to_high' || $sortBy === 'high_to_low') {
                $filtered = $filtered->sortBy(function ($product) {
                    $sku = $product->skuNew->first();
                    $special = (float) ($sku->special_price ?? 0);
                    $regular = (float) ($sku->price ?? 0);
                    return ($special > 0) ? $special : $regular;
                });
    
                if ($sortBy === 'high_to_low') {
                    $filtered = $filtered->reverse();
                }
    
                $filtered = $filtered->values();
            }
    
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
    
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
    
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    
    public function getLargestpriceproduct()
    {
        try {
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
    
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
    
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }



}
