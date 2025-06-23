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
class CartApiController extends Controller
{

    /*public function addToCart(Request $request)
    {

        try {
           
            $user = auth()->user();
            // dd($user);

            $cart = Cart::where('customer_id', $user->id)->first();
            if (!$cart) {
                $cart = new Cart();
                $cart->customer_id = $user->id;
                $cart->date = date('Y-m-d H:i:s');
                $cart->save();
            }

            $product = Product::find($request->product_id);
            $sku = Sku::where('product_id', $request->product_id)->where('id', $request->sku_id)->first();
            $skValues = SkuValues::where('product_id', $request->product_id)->where('sku_id', $request->sku_id)->get()->pluck('id');

            $cartItems = CartItems::where('cart_id', $cart->id)
                ->where('product_id', $request->product_id)
                ->where('sku_id', $request->sku_id)
                ->first();
            if (!isset($cartItems)) {
                $cartItems = new CartItems();
            }
            $cartItems->customer_id = $cart->customer_id;
            $cartItems->cart_id = $cart->id;
            $cartItems->product_id = $request->product_id;
            $cartItems->product_name = $product->product_name;
            $cartItems->sku_id = $request->sku_id;
            $cartItems->sku = $sku->sku;
            $cartItems->combination = $sku->combination_set;
            $cartItems->combination_id = $sku->combination_id;
            $cartItems->quantity = $request->quantity;
            $cartItems->price = $sku->price;
            $cartItems->special_price = $sku->special_price;
            // $cartItems->total = $request->quantity * $request->price;
            if ($sku->special_price == '' || $sku->special_price == 0) {
                $cartItems->total = $request->quantity * $sku->price;
            } else {
                $cartItems->total = $request->quantity * $sku->special_price;
            }
            if (count($skValues) > 0) {
                $cartItems->skuvalues_ids = implode(',', $skValues->toArray());
            }

            $cartItems->save();
            $updatedCart = Cart::with('cartItems')->find($cart->id);
            return response()->json(['message' => 'Item added to cart successfully','updatedCart'=>$updatedCart]);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Something went wrong while adding the item to the cart.'], 500);
        }
    }*/
   
   /*
    public function addToCart(Request $request)
	{
	     \Log::info($request);

	    \Log::info('Request Headers:', request()->headers->all());
        \Log::info('Cookies:', request()->cookies->all());

	    Session::put('test_key', 'Hello');
		$session_id=Session::get('session_id') == null ? 0 : Session::get('session_id'); 
	   // dd(\Auth::guard('api')->check());
		if(\Auth::guard('api')->check() != true)
		{
		  //  	dd("hai");
			$cart=Cart::where('customer_id',$session_id)->first();
			
			if(!isset($cart))
			{
			     
				$this->initCart();
                $session_id=Session::get('session_id');
				$cart=Cart::where('customer_id',$session_id)->first();
			}
		}else{
		    
			$cart=Cart::where('customer_id', \Auth::guard('api')->id())->first();
			if(!$cart)
			{
				$customer_id=Session::get('session_id');
				$cart=Cart::where('customer_id',$customer_id)->first();
			}
			if(!$cart)
			{
				$this->initCart();
				$cart=Cart::where('customer_id', \Auth::guard('api')->id())->first();
			}else{
				$this->initCartId();
				$cart=Cart::where('customer_id', \Auth::guard('api')->id())->first();
			}
		}
		$product=Product::find($request->product_id);
		$sku=Sku::where('product_id',$request->product_id)->where('id',$request->sku_id)->first();
		$skValues=SkuValues::where('product_id',$request->product_id)->where('sku_id',$request->sku_id)->get()->pluck('id');
        
		$cartItems=CartItems::where('cart_id',$cart->id)
		->where('product_id',$request->product_id)
		->where('sku_id',$request->sku_id)
		->first();
		if(!isset($cartItems))
		{
			$cartItems=new CartItems();
		}
		$cartItems->customer_id=$cart->customer_id;
		$cartItems->cart_id=$cart->id;
		$cartItems->product_id=$request->product_id;
		$cartItems->product_name=$product->product_name;
		$cartItems->sku_id=$request->sku_id;
		$cartItems->sku=$sku->sku;
		$cartItems->combination=$sku->combination_set;
		$cartItems->combination_id=$sku->combination_id;
		$cartItems->quantity=$request->quantity;
		$cartItems->price=$sku->price;
		$cartItems->special_price=$sku->special_price;
		if($sku->special_price=='' || $sku->special_price==0)
		{
			$cartItems->total=$request->quantity*$sku->price;
		}else{
			$cartItems->total=$request->quantity*$sku->special_price;
		}
		if(count($skValues) > 0)
		{
			$cartItems->skuvalues_ids=implode(',',$skValues->toArray()); 
		}
		$cartItems->save();
		$updatedCart = Cart::with('cartItems')->find($cart->id);
		\Log::info('All Session Data Cart:', Session::all());
		

        return response()->json(['message' => 'Item added to cart successfully','updatedCart'=>$updatedCart]);


	}
	
	public function initCart()
	{
		$session_id=Session::get('session_id');
		if($session_id == null|| $session_id == '')
		{
			$session_id=time().str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz');
			Session::put('session_id',$session_id);
		}
		$session_id=Session::get('session_id');
		$cart=new Cart();
	    if(\Auth::guard('api')->check() != true)
		{
			$cart->customer_id=$session_id;
		}else{
			//$this->initCartId();
			$cart->customer_id= \Auth::guard('api')->id();
			 
		}
		$cart->date=date('Y-m-d H:i:s');
		$cart->save();
	}
	
	public function initCartId()
	{
		$session_id=Session::get('session_id') == null ?  \Auth::guard('api')->id() : Session::get('session_id');
		if(\Auth::guard('api')->check() != false)

		{
			$cart=Cart::where('customer_id', \Auth::guard('api')->id())->first();
			if(!isset($cart))
			{
				$cart=Cart::where('customer_id',$session_id)->update(['customer_id'=>\Auth::guard('api')->id()]);
			}
			$items=CartItems::where('cart_id',$cart->id)->update(['customer_id'=>$cart->customer_id]);
			Session::put('session_id',null);
			return true;
		} 
		return true;
	}
	
    public function fetchCart(Request $request)
    {
      $user = \Auth::guard('api')->id();
      \Log::info($user);
      $cart = Cart::where('customer_id', $user)->first();
      if (!$cart) {
        return response()->json([
            'items' => '',
            'sub_total' => 0,
            'total' => 0,
        ]);
    }
  
    $cartItems = CartItems::with('productItems')->where('cart_id', $cart->id)->get();
    $subTotal = $cartItems->sum('total');
    $total = $subTotal;
    
   
    return response()->json(['cartItems'=>$cartItems,'subTotal'=>$subTotal,'total'=>$total]);
    }
    
    
    
    */
    /*public function fetchCart(Request $request)
    {
        //  Session::flush();
        // session()->flush();
        $sessionCookie = request()->cookie('laravel_session');
        \Log::info('Session Cookie:', ['laravel_session' => $sessionCookie]);
        \Log::info('Session ID:', [session()->getId()]);

        \Log::info('All Session Data:', Session::all());
        $user = auth()->user();
        \Log::info('All Session Data:', $user);
        $session_id = Session::get('session_id') ?? 0;
        \Log::info($session_id);
        if (!$user) {
            $cart = Cart::where('customer_id', $session_id)->first();
        } else {
            $cart = Cart::where('customer_id', $user->id)->first();
            if (!$cart) {
                $cart = Cart::where('customer_id', $session_id)->first();
                if ($cart) {
                    $cart->update(['customer_id' => $user->id]);
                    CartItems::where('cart_id', $cart->id)->update(['customer_id' => $user->id]);
    
                    // Clear the session cart ID after migration
                    Session::forget('session_id');
                }
            }
        }
        if (!$cart) {
            return response()->json([
                'items' => [],
                'sub_total' => 0,
                'total' => 0,
            ]);
        }
        $cartItems = CartItems::with('productItems')->where('cart_id', $cart->id)->get();
        $subTotal = $cartItems->sum('total');
        $total = $subTotal ;
    
        return response()->json([
            'cartItems' => $cartItems,
            'subTotal' => $subTotal,
            'total' => $total
        ]);
    }*/

	    public function addToCart(Request $request)
	    {

	    if (\Auth::guard('api')->check()) {
            $customer_id = \Auth::guard('api')->id();
        } 
        
		$product=Product::find($request->product_id);
		$sku=Sku::where('product_id',$request->product_id)->where('id',$request->sku_id)->first();
		$skValues=SkuValues::where('product_id',$request->product_id)->where('sku_id',$request->sku_id)->get()->pluck('id');

	    $cartItems=CartItems::where('customer_id', $customer_id)->where('product_id',$request->product_id)
    		->where('sku_id',$request->sku_id)
    		->first();
    		
    	// for check availability
        $newQty = $request->quantity;
    
        if ($newQty > $sku->quantity) {
            return response()->json([
                'status' => false,
                'message' => 'Only ' . $sku->quantity . ' items available in stock for this product.',
            ], 422);
        }		
    		
    	if (!$cartItems) 
    	{
            $cartItems = new CartItems();
            $cartItems->quantity = $request->quantity;
        } 
        else 
        {
            $cartItems->quantity = $request->quantity;
        }
		
		$cartItems->customer_id=$customer_id;
		$cartItems->cart_id=1;
		$cartItems->product_id=$request->product_id;
		$cartItems->product_name=$product->product_name;
		$cartItems->sku_id=$request->sku_id;
		$cartItems->sku=$sku->sku;
		$cartItems->combination=$sku->combination_set;
		$cartItems->combination_id=$sku->combination_id;
		$cartItems->discount=$sku->discount;
// 		$cartItems->quantity=$request->quantity;
		$cartItems->price=$sku->price;
		$cartItems->special_price=$sku->special_price;
		
		
		
		if($sku->special_price=='' || $sku->special_price==0)
		{
			$cartItems->total=$cartItems->quantity*$sku->price;
		}else{
			$cartItems->total=$cartItems->quantity*$sku->special_price;
		}
		if(count($skValues) > 0)
		{
			$cartItems->skuvalues_ids=implode(',',$skValues->toArray()); 
		}
		$cartItems->created_at=now();
		$cartItems->updated_at=now();
		$cartItems->save();
		

        return response()->json(['message' => 'Item added to cart successfully',]);


	}
	
	
	
	
	
	
	public function fetchCart(Request $request)
    {
        $customer_id = null;
       
        if (\Auth::guard('api')->check()) {
            $customer_id = \Auth::guard('api')->id();
        } 
        
        // Get cart items
        //$cartItems = CartItems::with('productItems')
        $cartItems = CartItems::with('sku_images','productItems')
            ->where('customer_id', $customer_id)
            ->get();
    
        $subTotal = $cartItems->sum('total');
        $total = $subTotal; 
    
        return response()->json([
            'cartItems' => $cartItems,
            'subTotal' => $subTotal,
            'total' => $total,
        ]);
    }




    public function removeCartItems(Request $request)
    {
        // dd($request);
      $cartItemId = $request->input('cart_item_id');

        $cartItem = CartItems::find($cartItemId);

        if (!$cartItem) {
           
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found.',
                
            ]);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart item removed successfully.',
           
        ]);
    }
    
    
    
   
    
    /*
    public function updateCart(Request $request)
    {
        //  \Log::info($request->cart_item_id);
        $cartItem = CartItems::find($request->cart_item_id);
    
        $cartItem->quantity = $request->quantity;
        $price = ($cartItem->special_price > 0) ? $cartItem->special_price : $cartItem->price;

        $cartItem->total = $request->quantity * $price;
        
        $cartItem->save();
    //  \Log::info($cartItem);
        return response()->json(['message' => 'Cart item updated successfully']);
    }
    */
    public function updateCart(Request $request)
    {
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
        ]);
    }

}
