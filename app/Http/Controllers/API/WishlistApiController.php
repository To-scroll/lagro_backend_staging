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
class WishlistApiController extends Controller
{

    public function addToWishlist(Request $request)
	{
		if(\Auth::guard('api')->check())
		{
		    
    		$product=Product::find($request->product_id);
    		$sku=Sku::where('product_id',$request->product_id)->where('id',$request->sku_id)->first();
    		$skValues=SkuValues::where('product_id',$request->product_id)->where('sku_id',$request->sku_id)->get()->pluck('id');
            
            $wishlist = Wishlist::where('customer_id', \Auth::guard('api')->id())->first();
        	if(!$wishlist)
		    {
		        $wishlist=new Wishlist();
		        $wishlist->customer_id= \Auth::guard('api')->id();
        		$wishlist->date=date('Y-m-d H:i:s');
        		$wishlist->save();
		    }
                
            $wishlistItems = WishlistItems::where('wishlist_id', $wishlist->id)->where('product_id',$request->product_id)->where('sku_id',$request->sku_id)->first();
        	if(!$wishlistItems)
        	{
        		$wishlistItems=new WishlistItems();
    
        		$wishlistItems->wishlist_id=$wishlist->id;
        		$wishlistItems->customer_id=$wishlist->customer_id;
        		$wishlistItems->product_id=$request->product_id;
        		$wishlistItems->product_name=$product->product_name;
        		$wishlistItems->sku_id=$request->sku_id;
        		$wishlistItems->sku=$sku->sku;
        		$wishlistItems->combination=$sku->combination_set;
        		$wishlistItems->combination_id=$sku->combination_id;
        		$wishlistItems->price=$sku->price;
        		$wishlistItems->special_price=$sku->special_price;
        		$wishlistItems->discount=$sku->discount;
        		$wishlistItems->save();
        		return response()->json(['message' => 'Item added to wishlist successfully','wishlist'=>$wishlist,'WishlistItems'=>$wishlistItems]);

        	}
        	else
        	{
        		return response()->json(['message' => 'already presesnt in wishlist']);

        	}
		
		}
	}
	
	

	
	
    public function fetchWishlist(Request $request)
    {
      $user = \Auth::guard('api')->id();
      $wishlist = Wishlist::where('customer_id', $user)->first();
      if (!$wishlist) {
        return response()->json([
            'items' => 'no items',
            
        ]);
    }
  
    $wishlistItems = WishlistItems::with('sku_images','productItems')
                                    ->where('wishlist_id', $wishlist->id)
                                    ->get();
    //$wishlistItems = WishlistItems::with('productItems')->where('wishlist_id', $wishlist->id)->get();
   
   
    return response()->json(['wishlist'=>$wishlist,'wishlistItems'=>$wishlistItems,]);
    }


    public function removeWishlistItems(Request $request)
    {
        // dd($request);
      $wishlistItemId = $request->input('wishlist_item_id');

        $wishlistItem = WishlistItems::find($wishlistItemId);

        if (!$wishlistItem) {
           
            return response()->json([
                'success' => false,
                'message' => 'Wish List item not found.',
                
            ]);
        }

        $wishlistItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wishlist item removed successfully.',
           
        ]);
    }
    
    
    
    public function wishlistCount()
    {
      $user = auth()->user();
      $wishlist = Wishlist::where('customer_id', $user->id)->first();

      if ($wishlist) {
          $wishlistItemCount = $wishlist->wishlistItems()->count();
      } else {
          $wishlistItemCount = 0;
      }
      // dd($cartItemCount);
      return response()->json(['count' => $wishlistItemCount]);
    }
    
    
   
}
