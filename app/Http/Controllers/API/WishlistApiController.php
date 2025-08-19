<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\WishlistItems;
use App\Models\Sku;
use App\Models\User;
use App\Models\SkuValues;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Http;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

class WishlistApiController extends Controller
{

    public function addToWishlist(Request $request)
    {
        try {
            if (!\Auth::guard('api')->check()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please login to add items to your wishlist.',
                ], 401);
            }
    
            $product = Product::find($request->product_id);
            $sku = Sku::where('product_id', $request->product_id)
                ->where('id', $request->sku_id)
                ->first();
    
            $skValues = SkuValues::where('product_id', $request->product_id)
                ->where('sku_id', $request->sku_id)
                ->get()
                ->pluck('id');
    
            $wishlist = Wishlist::where('customer_id', \Auth::guard('api')->id())->first();
    
            if (!$wishlist) {
                $wishlist = new Wishlist();
                $wishlist->customer_id = \Auth::guard('api')->id();
                $wishlist->date = date('Y-m-d H:i:s');
                $wishlist->save();
            }
    
            $wishlistItems = WishlistItems::where('wishlist_id', $wishlist->id)
                ->where('product_id', $request->product_id)
                ->where('sku_id', $request->sku_id)
                ->first();
    
            if (!$wishlistItems) {
                $wishlistItems = new WishlistItems();
                $wishlistItems->wishlist_id = $wishlist->id;
                $wishlistItems->customer_id = $wishlist->customer_id;
                $wishlistItems->product_id = $request->product_id;
                $wishlistItems->product_name = $product->product_name;
                $wishlistItems->sku_id = $request->sku_id;
                $wishlistItems->sku = $sku->sku;
                $wishlistItems->combination = $sku->combination_set;
                $wishlistItems->combination_id = $sku->combination_id;
                $wishlistItems->price = $sku->price;
                $wishlistItems->special_price = $sku->special_price;
                $wishlistItems->discount = $sku->discount;
                $wishlistItems->save();
    
                return response()->json([
                    'status' => true,
                    'message' => 'Item added to wishlist successfully',
                    'wishlist' => $wishlist,
                    'WishlistItems' => $wishlistItems
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Already present in wishlist'
                ]);
            }
        }
    
        catch (AuthenticationException $e) {
            return response()->json([
                'status' => false,
                'error' => 'Authentication Error',
                'message' => $e->getMessage()
            ], 401);
        }
    
        catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'error' => 'Validation Error',
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        }
    
        catch (\Exception $e) {
            \Log::error('AddToWishlist Error: ' . $e->getMessage());
    
            return response()->json([
                'status' => false,
                'error' => 'General Error',
                'message' => 'Something went wrong while adding to wishlist.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
	
	

	
	
   public function fetchWishlist(Request $request)
    {
        try {
            $user = \Auth::guard('api')->id();
    
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please login to view your wishlist.',
                ], 401);
            }
    
            $wishlist = Wishlist::where('customer_id', $user)->first();
    
            if (!$wishlist) {
                return response()->json([
                    'status' => false,
                    'message' => 'No wishlist found.',
                    'wishlistItems' => []
                ]);
            }    
            //$wishlistItems = WishlistItems::with('productItems')->where('wishlist_id', $wishlist->id)->get();
    
            $wishlistItems = WishlistItems::with('sku_images', 'productItems')
                                ->where('wishlist_id', $wishlist->id)
                                ->get();
    
            return response()->json([
                'status' => true,
                'wishlist' => $wishlist,
                'wishlistItems' => $wishlistItems
            ]);
    
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => false,
                'error' => 'Authentication Error',
                'message' => $e->getMessage()
            ], 401);
    
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'error' => 'Validation Error',
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            \Log::error('FetchWishlist Error: ' . $e->getMessage());
    
            return response()->json([
                'status' => false,
                'error' => 'General Error',
                'message' => 'Something went wrong while fetching wishlist.',
                'details' => $e->getMessage()
            ], 500);
        }
    }


    public function removeWishlistItems(Request $request)
    {
        try {
            $wishlistItemId = $request->input('wishlist_item_id');
    
            $wishlistItem = WishlistItems::find($wishlistItemId);
    
            if (!$wishlistItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wish List item not found.',
                ], 404);
            }
    
            $wishlistItem->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Wishlist item removed successfully.',
            ]);
        }
    
        catch (AuthenticationException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Authentication Error',
                'message' => $e->getMessage()
            ], 401);
        }
    
        catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Validation Error',
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        }
    
        catch (\Exception $e) {
            \Log::error('RemoveWishlistItem Error: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'error' => 'General Error',
                'message' => 'Something went wrong while removing wishlist item.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    
    
    
    public function wishlistCount()
    {
        try {
            $user = auth()->user();
    
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please login to get wishlist count.'
                ], 401);
            }
    
            $wishlist = Wishlist::where('customer_id', $user->id)->first();
    
            $wishlistItemCount = $wishlist ? $wishlist->wishlistItems()->count() : 0;
    
            return response()->json([
                'status' => true,
                'count' => $wishlistItemCount
            ]);
        }
    
        catch (AuthenticationException $e) {
            return response()->json([
                'status' => false,
                'error' => 'Authentication Error',
                'message' => $e->getMessage()
            ], 401);
        }
    
        catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'error' => 'Validation Error',
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        }
    
        catch (\Exception $e) {
            \Log::error('WishlistCount Error: ' . $e->getMessage());
    
            return response()->json([
                'status' => false,
                'error' => 'General Error',
                'message' => 'Failed to fetch wishlist count.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    
   
}
