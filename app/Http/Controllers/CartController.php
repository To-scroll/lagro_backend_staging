<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Invoice;
use App\Models\InvoiceItems;
use \App\Models\User;
use App\Models\Sku;
use App\Models\SkuValues;
use App\Models\Product;
use App\Models\Address;
use App\Models\Orders;
use App\Models\OrderItems;
use Razorpay\Api\Api;
use Session;
use Http;
class CartController extends Controller
{
    public function addToCart(Request $request)
	{
	    
		
		$session_id=Session::get('session_id') == null ? 0 : Session::get('session_id'); 
		if(\Auth::guest())
		{
			$cart=Cart::where('customer_id',$session_id)->first();
			
			if(!isset($cart))
			{
			     
				$this->initCart();
                $session_id=Session::get('session_id');
				$cart=Cart::where('customer_id',$session_id)->first();
			}
		 
			 
		}else{
			 
			
			$cart=Cart::where('customer_id',\Auth::user()->id)->first();
			if(!$cart)
			{
				$customer_id=Session::get('session_id');
				$cart=Cart::where('customer_id',$customer_id)->first();
			}
			if(!$cart)
			{
				$this->initCart();
				$cart=Cart::where('customer_id',\Auth::user()->id)->first();
			}else{
				$this->initCartId();
				$cart=Cart::where('customer_id',\Auth::user()->id)->first();
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
		// if($request->has('request_from') && $request->request_from == 'list')
		// {
		// 	$cartItems->quantity=$cartItems->quantity+$request->quantity;
		// }
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
		echo 1; //jkfkjk


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
		if(\Auth::guest())
		{
			$cart->customer_id=$session_id;
		}else{
			//$this->initCartId();
			$cart->customer_id=\Auth::user()->id;
			 
		}
		$cart->date=date('Y-m-d H:i:s');
		$cart->save();
	}
	public function initCartId()
	{
		$session_id=Session::get('session_id') == null ? \Auth::user()->id : Session::get('session_id');
		if(\Auth::guest() != true)
		{
			$cart=Cart::where('customer_id',\Auth::user()->id)->first();
			if(!isset($cart))
			{
				$cart=Cart::where('customer_id',$session_id)->update(['customer_id'=>\Auth::user()->id]);
			}
			$items=CartItems::where('cart_id',$cart->id)->update(['customer_id'=>$cart->customer_id]);
			Session::put('session_id',null);
			return true;
		} 
		return true;
	}

	
	public function placeorder(Request $request)
	{
		if($request->has('cart_id') && $request->cart_id != '')
		{
			$cart=Cart::where('id',$request->cart_id)->first();
		}else{
			$cart=Cart::where('customer_id',\Auth::user()->id)->first();
		}
		$cartItems=CartItems::where('cart_id',$cart->id)->get();
		$amount=CartItems::where('cart_id',$cart->id)->sum('total');
		$address=Address::where('is_defualt','yes')->where('customer_id',$cart->customer_id)->first();

		$api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
		$order=$api->order->create(array('receipt' => $address->name, 'amount' => $amount*100 , 'currency' => 'INR', 'notes'=> array('address'=> $address->address,'landmark'=>$address->landmark,'pincode'=>$address->pincode)));
        $order=$order->toArray();
		$order['phone']=\Auth::user()->phone;
		$order['email']=\Auth::user()->email;
		$order['cart_id']=$cart->id;
        return response()->json($order);
        
	}
	public function checkPayment(Request $request)
	{
		$response=Http::get('https://api.razorpay.com/v1/payments/'.$request->payment_id.'/status?key_id='.env('RAZOR_KEY'));
		$res=json_decode($response->body());
		if(isset($res) &&  isset($res->razorpay_payment_id) )
		{
			$cart=Cart::where('id',$request->cart_id)->first();
			$cartItems=CartItems::where('cart_id',$cart->id)->get();
			$address=Address::where('is_defualt','yes')->where('customer_id',$cart->customer_id)->first();

			$orderData=new Orders();
			$orderData->customer_id=$cart->customer_id;
			$orderData->customer_name=\Auth::user()->name;
			$orderData->customer_email=\Auth::user()->email;
			$orderData->customer_phone=\Auth::user()->phone;
			$orderData->total_amount=00;
			$orderData->date=date('Y-m-d H:i:s');
			$orderData->address=$address->address;			
			$orderData->landmark=$address->landmark;			
			$orderData->pincode=$address->pincode;			
			$orderData->address_name=$address->name;			
			$orderData->address_type=$address->type;	
			$orderData->created_by=\Auth::user()->id;	
			$orderData->updated_by=\Auth::user()->id;	
			$orderData->created_at=date('Y-m-d H:i:s');	
			$orderData->updated_at=date('Y-m-d H:i:s');
			$orderData->reference_no=$request->payment_id;
			$orderData->is_paid='yes';	
			if($orderData->save())
			{
				$total=0;
				foreach($cartItems as $item)
				{
					$orderItem=new OrderItems();
					$orderItem->order_id=$orderData->id;
					$orderItem->order_no=$orderData->order_no;
					$orderItem->product_id=$item->product_id;
					$orderItem->product_name=$item->product_name;
					$orderItem->thumbnail=Product::getProductThumbnail($item->product_id);
					$orderItem->sku_id=$item->sku_id;
					$orderItem->sku_title=$item->sku;
					$orderItem->combination=$item->combination;
					$orderItem->combination_id=$item->combination_id;
					$orderItem->skuvalues_ids=$item->skuvalues_ids;
					$orderItem->qty=$item->quantity;
					$orderItem->price=$item->price;
					$orderItem->special_price=$item->special_price;
					$orderItem->total=$item->total;
					$orderItem->save();
					$total+=$orderItem->total;

				}
				$orderData->total=$total;
				$orderData->total_amount=$total;
				$orderData->save();
				$cartDelete=Cart::findOrFail($cart->id)->delete();
				$cartItemsDelete=CartItems::where('cart_id',$cart->id)->delete();
				return encrypt($orderData->id);
				
			}	
		}
		return null;
	}
	public function orderSuccess($order_id)
	{
		$order_id=decrypt($order_id);
		$orderData=Orders::find($order_id);
		
		$orderItem=OrderItems::where('order_id',$order_id)->get();
		return view('front.order-success',[
			'order'=>$orderData,
			'orderItems'=>$orderItem
		]);
	}
	public function getOrderItems(Request $request)
	{
		$order=Orders::where('id',$request->id)->first();
		$orderItems=OrderItems::where('order_id',$request->id)->orderBy('special_price','desc')->get();
		$html=view('front.ajax.dashboard.order-items',compact('orderItems'))->render();
		return response()->json([
			'html'=>$html,
			'order_no'=>$order->order_no
		]);
	}
	 
	 
	 
	 
	// public function checkout(Request $request)
	// {
	// 	$cart=Cart::where('customer_id',\Auth::user()->id)->first();
	// 	$cartItems=CartItems::where('cart_id',$cart->id)->get();
	// 	$customer=Customer::where('user_id',\Auth::user()->id)->first();
	// 	$address=Address::find($request->address_id);
	// 	$user=User::find(\Auth::user()->id);
	// 	$orderTotal=0;
	// 	$order=new Orders();
	// 	$order->customer_id=\Auth::user()->id;
	// 	$order->customer_name=$customer->name;
	// 	$order->customer_phone=$customer->phone;
	// 	$order->customer_email=$user->email;
	// 	$order->date=date('Y-m-d H:i:s');
	// 	$order->remarks=$request->remarks;
	// 	$order->payment_method=$request->payment_method;
	// 	$order->reference_no=$request->reference_no;
	// 	$order->address=$address->address;
	// 	$order->landmark=$address->landmark;
	// 	$order->pincode=$address->pincode;
	// 	$order->created_by=\Auth::user()->id;
	// 	$order->updated_by=\Auth::user()->id;
	// 	$order->created_at=date('Y-m-d H:i:s');
	// 	$order->updated_at=date('Y-m-d H:i:s');
	// 	if($order->save())
	// 	{
	// 		foreach($cartItems as $item)
	// 		{
	// 			$orderItem=new OrderItems();
	// 			$orderItem->order_id=$order->id;
	// 			$orderItem->order_no=$order->order_no;
	// 			$orderItem->product_id=$item->product_id;
	// 			$orderItem->product_name=$item->product_name;
	// 			$orderItem->sku_id=$item->sku_id;
	// 			$orderItem->sku_title=$item->sku;
	// 			$orderItem->combination=$item->combination;
	// 			$orderItem->qty=$item->qty;
	// 			$orderItem->price=$item->price;
	// 			$orderItem->special_price=$item->special_price;
	// 			$orderItem->total=$item->total;
	// 			$orderItem->skuvalues_ids=$item->skuvalues_ids;
	// 			$orderItem->save();
	// 			$orderTotal+=$orderItem->total;
	// 		}
	// 	}
	// 	$order=Orders::find($order->id);
	// 	$order->total_amount=$orderTotal;
	// 	$order->save();


	// 	$invoice=new Invoice();
	// 	$invoice->order_id=$order->id;
	// 	$invoice->order_no=$order->order_no;
	// 	$invoice->customer_id=\Auth::user()->id;
	// 	$invoice->customer_name=$customer->name;
	// 	$invoice->customer_phone=$customer->phone;
	// 	$invoice->customer_email=$user->email;
	// 	$invoice->date=date('Y-m-d H:i:s');
	// 	$invoice->payment_method=$request->payment_method;
	// 	$invoice->total_amount=$order->total_amount;
	// 	$invoice->reference_no=$order->reference_no;
	// 	$invoice->address=$order->address;
	// 	$invoice->landmark=$order->landmark;
	// 	$invoice->pincode=$order->pincode;
	// 	$invoice->created_by=\Auth::user()->id;
	// 	$invoice->updated_by=\Auth::user()->id;
	// 	$invoice->created_at=date('Y-m-d H:i:s');
	// 	$invoice->updated_at=date('Y-m-d H:i:s');
	// 	$invoice->save();
	// 	$orderItems=OrderItems::where('order_id',$order->id)->get();
	// 	foreach($orderItems as $row)
	// 		{
	// 			$invoiceItem=new InvoiceItems();
	// 			$invoiceItem->order_id=$order->id;
	// 			$invoiceItem->order_no=$order->order_no;
	// 			$invoiceItem->invoice_no=$invoice->invoice_no;
	// 			$invoiceItem->invoice_id=$invoice->id;
	// 			$invoiceItem->order_item_id=$row->id;
	// 			$invoiceItem->product_id=$row->product_id;
	// 			$invoiceItem->product_name=$row->product_name;
	// 			$invoiceItem->sku_id=$row->sku_id;
	// 			$invoiceItem->sku_title=$row->sku_title;
	// 			$invoiceItem->combination=$row->combination;
	// 			$invoiceItem->qty=$row->qty;
	// 			$invoiceItem->price=$row->price;
	// 			$invoiceItem->special_price=$row->special_price;
	// 			$invoiceItem->total=$row->total;
	// 			$invoiceItem->skuvalues_ids=$row->skuvalues_ids;
	// 			$invoiceItem->save();
		
	// 		}

	// }
	
}
