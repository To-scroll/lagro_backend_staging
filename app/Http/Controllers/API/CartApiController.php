<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItems;
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
class CartApiController extends Controller
{

   

    public function addToCart(Request $request)
    {
        try {
            if (!\Auth::guard('api')->check()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please login to add items to your cart.',
                ], 401);
            }
    
            $customer_id = \Auth::guard('api')->id();
            $cart_type = $request->cart_type ?? 'cart';
    
            $product = Product::find($request->product_id);
            $sku = Sku::where('product_id', $request->product_id)
                      ->where('id', $request->sku_id)
                      ->first();
    
            if (!$product || !$sku) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid product or SKU.',
                ], 404);
            }
    
            $skValues = SkuValues::where('product_id', $request->product_id)
                                 ->where('sku_id', $request->sku_id)
                                 ->pluck('id');
    
            $newQty = $request->quantity;
            if ($newQty > $sku->quantity) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only ' . $sku->quantity . ' items available in stock for this product.',
                ], 422);
            }
    
            if ($cart_type === 'buy') {
                CartItems::where('customer_id', $customer_id)
                    ->where('cart_type', 'buy')
                    ->delete();
            }
    
            $cartItems = CartItems::where('customer_id', $customer_id)
                ->where('product_id', $request->product_id)
                ->where('sku_id', $request->sku_id)
                ->where('cart_type', $cart_type)
                ->first();
    
            if (!$cartItems) {
                $cartItems = new CartItems();
                $cartItems->quantity = $request->quantity;
            } else {
                $cartItems->quantity = $request->quantity;
            }
    
            $cartItems->customer_id = $customer_id;
            $cartItems->cart_id = 1;
            $cartItems->product_id = $request->product_id;
            $cartItems->product_name = $product->product_name;
            $cartItems->sku_id = $request->sku_id;
            $cartItems->sku = $sku->sku;
            $cartItems->combination = $sku->combination_set;
            $cartItems->combination_id = $sku->combination_id;
            $cartItems->discount = $sku->discount;
            $cartItems->cart_type = $cart_type;
            $cartItems->price = $sku->price;
            $cartItems->special_price = $sku->special_price;
    
            $cartItems->total = ($sku->special_price == '' || $sku->special_price == 0)
                ? $cartItems->quantity * $sku->price
                : $cartItems->quantity * $sku->special_price;
    
            if (count($skValues) > 0) {
                $cartItems->skuvalues_ids = implode(',', $skValues->toArray());
            }
    
            $cartItems->created_at = now();
            $cartItems->updated_at = now();
            $cartItems->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Item added to cart successfully',
            ], 200);
    
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
            \Log::error('AddToCart Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'error' => 'General Error',
                'message' => 'Something went wrong while adding to cart.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

	
	
	
	
	
    public function fetchCart(Request $request)
    {
        try {
            if (!\Auth::guard('api')->check()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized. Please log in to view your cart.',
                ], 401);
            }
    
            $customer_id = \Auth::guard('api')->id();
    
            $cartItems = \App\Models\CartItems::with('sku_images', 'productItems')
                ->where('customer_id', $customer_id)
                ->where('cart_type', 'cart')
                ->get();
    
            $subTotal = $cartItems->sum('total');
            $total = $subTotal;
    
            return response()->json([
                'status' => true,
                'cartItems' => $cartItems,
                'subTotal' => $subTotal,
                'total' => $total,
            ], 200);
    
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => false,
                'error' => 'Authentication Error',
                'message' => $e->getMessage(),
            ], 401);
    
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'error' => 'Validation Error',
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
    
        } catch (\Exception $e) {
            \Log::error('FetchCart Error: ' . $e->getMessage());
    
            return response()->json([
                'status' => false,
                'error' => 'General Error',
                'message' => 'Failed to fetch cart.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }





    public function removeCartItems(Request $request)
    {
        try {
            $cartItemId = $request->input('cart_item_id');
    
            $cartItem = CartItems::find($cartItemId);
    
            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found.'
                ], 404);
            }
    
            $cartItem->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Cart item removed successfully.'
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove cart item.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    
   
    
  
    public function updateCart(Request $request)
    {
        try {
            $cartItem = CartItems::find($request->cart_item_id);
        
            if (!$cartItem) {
                return response()->json(['message' => 'Cart item not found'], 404);
            }
    
            $sku = Sku::find($cartItem->sku_id);
            
            if (!$sku) {
                return response()->json(['message' => 'Product SKU not found'], 404);
            }
    
            if ($request->quantity > $sku->quantity) {
                return response()->json([
                    'status' => false,
                    'message' => "Only {$sku->quantity} item(s) available in stock."
                ], 400);
            }
    
            $cartItem->quantity = $request->quantity;
            $price = ($cartItem->special_price > 0) ? $cartItem->special_price : $cartItem->price;
            $cartItem->total = $request->quantity * $price;
    
            $cartItem->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Cart item updated successfully'
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update cart item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    
    
    


    public function productBuy(Request $request)
    {
        try {
            if (!\Auth::guard('api')->check()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized. Please log in to continue.'
                ], 401);
            }
    
            $customer_id = \Auth::guard('api')->id();
    
            $cartItems = \App\Models\CartItems::with('sku_images', 'productItems')
                ->where('customer_id', $customer_id)
                ->where('cart_type', 'buy')
                ->get();
    
            return response()->json([
                'status' => true,
                'cartItems' => $cartItems,
            ], 200);
    
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
            \Log::error('ProductBuy Error: ' . $e->getMessage());
    
            return response()->json([
                'status' => false,
                'error' => 'General Error',
                'message' => 'Failed to fetch cart items for purchase.',
                'details' => $e->getMessage()
            ], 500);
        }
    }


}
