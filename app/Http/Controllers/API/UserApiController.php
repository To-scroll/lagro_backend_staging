<?php

namespace App\Http\Controllers\API;
use App\Models\Address;
use App\Models\Pincodes;
use App\Models\GroupDetails;
use App\Models\ProductGroup;
use App\Models\CartItems;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\Coupons;
use App\Models\Review;
use App\Models\Invoice;
use App\Models\InvoiceItems;
use App\Models\Sku;

use App\Models\Warehouse;
use App\Models\Location;
use App\Models\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Validator;

use Carbon\Carbon;
use Razorpay\Api\Api;
use PDF;
use Illuminate\Http\Request;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

class UserApiController extends Controller
{
    public function addAddress(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'city' => 'required',
                'pincode' => 'required',
                'state' => 'required',
                'country' => 'required',
            ], [
                'name.required' => 'please enter name',
                'phone.required' => 'please enter phone',
                'address.required' => 'please enter address',
                'city.required' => 'please enter city',
                'pincode.required' => 'please enter pincode',
                'state.required' => 'please enter state',
                'country.required' => 'please enter country',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'error' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 400);
            }
    
            $user = auth()->user();
            $existing = Address::where('customer_id', $user->id)->first();
            if ($existing) {
                return response()->json([
                    'status' => false,
                    'error' => 'Only one address is allowed per customer'
                ], 400);
            }
    
            $data = new Address();
            $data->name = $request->name;
            $data->customer_id = $user->id;
            $data->address = $request->address;
            $data->phone_number = $request->phone;
            $data->city = $request->city;
            $data->pincode = $request->pincode;
            $data->state = $request->state;
            $data->country = $request->country;
            $data->save();
    
            $count = Address::where('customer_id', $user->id)->count();
            if ($count == 1) {
                Address::where('customer_id', $user->id)->update(['is_default' => 'yes']);
            }
    
            return response()->json([
                'status' => true,
                'message' => 'Address added successfully'
            ], 200);
    
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'error' => 'Validation Error',
                'messages' => $e->errors()
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

    
    
    
    public function updateAddress(Request $request)
    {
        try {
            // Validation block
            $validator = Validator::make($request->all(), [
                'address_id' => 'required',
                'name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'city' => 'required',
                'pincode' => 'required',
                'state' => 'required',
                'country' => 'required',
            ],[
                'address_id.required' => 'please Select address id',
                'name.required' => 'please enter name',
                'phone.required' => 'please enter phone',
                'address.required' => 'please enter address',
                'city.required' => 'please enter city',
                'pincode.required' => 'please enter pincode',
                'state.required' => 'please enter state',
                'country.required' => 'please enter country',
            ]);
    
            if ($validator->fails()) {
                // Validation error response
                return response()->json([
                    'status' => false,
                    'error' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 400);
            }
    
            // Find and update address
            $data = Address::find($request->address_id);
            $data->name = $request->name;
            $data->customer_id = auth()->user()->id;
            $data->address = $request->address;
            $data->phone_number = $request->phone;
            $data->city = $request->city;
            $data->pincode = $request->pincode;
            $data->state = $request->state;
            $data->country = $request->country;
            $data->save();
    
            // Success response
            return response()->json(['message' => 'Address updated successfully'], 200);
    
        } catch (AuthenticationException $e) {
            // Auth error catch
            return response()->json([
                'status' => false,
                'error' => 'Authentication Error',
                'message' => $e->getMessage()
            ], 401);
        } catch (ValidationException $e) {
            // Extra catch block if validation fails outside
            return response()->json([
                'status' => false,
                'error' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // General error catch
            return response()->json([
                'status' => false,
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    
    public function getAddress()
    {
        try {
            // Fetch address list for authenticated user
            $addressList = Address::where('customer_id', auth()->user()->id)
                ->select('id', 'name', 'address', 'phone_number', 'pincode', 'city', 'state', 'country', 'is_default')
                ->get();
    
            // Success response
            return response()->json([
                'status' => true,
                'message' => 'address fetch successfully',
                'addressList' => $addressList
            ]);
            
        } catch (AuthenticationException $e) {
            // Auth error catch
            return response()->json([
                'status' => false,
                'error' => 'Authentication Error',
                'message' => $e->getMessage()
            ], 401);
        } catch (\Exception $e) {
            // General error catch
            return response()->json([
                'status' => false,
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    
    
    public function deleteAddress(Request $request)
    {
        try {
            // Get the address ID from request
            $addressId = $request->input('address_id');
    
            // Find the address
            $address = Address::find($addressId);
    
            if ($address) {
                // Delete the address
                $address->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Address deleted successfully'
                ], 200);
            } else {
                // Address not found response
                return response()->json([
                    'status' => false,
                    'error' => 'Address not found'
                ], 404);
            }
    
        } catch (AuthenticationException $e) {
            // Auth error catch
            return response()->json([
                'status' => false,
                'error' => 'Authentication Error',
                'message' => $e->getMessage()
            ], 401);
        } catch (\Exception $e) {
            // General error catch
            return response()->json([
                'status' => false,
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }

   
    public function applyCoupon(Request $request)
    {
        try {
            // Get the coupon code from the request
            $code = $request->code;
    
            // Find the coupon by code
            $coupon = Coupons::where('coupon_code', $code)->first();
            
            if ($coupon) {
                // Get current date and created date
                $currentDate = date('Y-m-d H:i:s');
                $createdDate = $coupon->created_at;
    
                // Calculate the number of days since coupon creation
                $dateDiff = strtotime($currentDate) - strtotime($createdDate);
                $daysDiff = floor($dateDiff / (60 * 60 * 24));
    
                // Check if the coupon is still valid
                if ($daysDiff <= $coupon->valid_upto) {
                    // Get total from cart items
                    $cartItems = CartItems::where('customer_id', auth()->user()->id)->get();
                    $total = $cartItems->sum('total');
    
                    // Calculate discount
                    $discountpercent = $coupon->offer_percent;
                    $discounttotal = $total * $discountpercent / 100;
                    $totalPrize = $total - $discounttotal;
    
                    // Success response
                    return response()->json([
                        'message' => 'Coupon applied! ' . $discountpercent . '% discount has been applied.',
                        'totalPrize' => $totalPrize,
                        'coupon_id' => $coupon->id
                    ]);
                } else {
                    // Coupon expired
                    return response()->json([
                        'message' => 'Coupon has expired.'
                    ]);
                }
            } else {
                // Invalid coupon
                return response()->json([
                    'message' => 'Invalid coupon code.'
                ]);
            }
    
        } catch (AuthenticationException $e) {
            // Auth error catch
            return response()->json([
                'status' => false,
                'error' => 'Authentication Error',
                'message' => $e->getMessage()
            ], 401);
        } catch (\Exception $e) {
            // General error catch
            return response()->json([
                'status' => false,
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    
    /*
    public function placeOrder(Request $request)
    {	

         
        $user=auth()->user();
        if(!$user)
        {
            return response()->json(['status'=>false,'message'=>'User Not Found']);
        }
        
        //$cartItems= CartItems::where('customer_id', $user->id)->get();
        
        
        if ($request->cart_type === 'buy')
        {
            $cartItems = CartItems::where('customer_id', $user->id)
            ->where(function ($query) {
                $query->where('cart_type', 'buy');
            })
            ->get();
        
        }
        
        if ($request->cart_type === 'cart' || $request->cart_type === null)
        {
            $cartItems = CartItems::where('customer_id', $user->id)
                ->where('cart_type', 'cart')
                ->get();
        }
        
        \Log::info($cartItems);

        $amount = $cartItems->sum('total');
        
        $shipping_charge=$request->shipping_charge;
        
        $address = Address::find($request->address_id);
        
        $totalAmount=100.00;
        //$totalAmount = ($amount + $shipping_charge) * 100;
        $offer_sku=$request->offersku_id;
        

        //$razorKey = 'rzp_test_6M10IZtEi8FbEZ';  
        //$razorSecret = 'Aokvn8WzjWuEzXEGCr7fdxzg';
        
        $razorKey = env('RAZORPAY_KEY');  
        $razorSecret = env('RAZORPAY_SECRET');
        
        \Log::info('RAZORPAY_KEY');
        \Log::info($razorKey);
        
        \Log::info('RAZORPAY_SECRET');
        \Log::info($razorSecret);
         
        $api = new Api($razorKey, $razorSecret);
        
        try {
        $order = $api->order->create([
            'receipt' => 'ORDER_' . uniqid(),
            'amount' => $totalAmount,
            'currency' => 'INR',
            'notes' => [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $address->phone_number,
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => 'Error creating Razorpay order: ' . $e->getMessage()]);
    }
    $order = $order->toArray();

    try {
        $newOrder = Orders::create([
            'payment_order_id' => $order['id'],
            'total_amount' => $order['amount'] / 100,
            'customer_id' => $user->id,
            'customer_name' => $address->name,
            'customer_phone' => $address->phone_number,
            'customer_email' => $user->email,
            'address' => $address->address,
            'landmark' => $address->city,
            'pincode' => $address->pincode,
            
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'date' => Carbon::now()->toDateTimeString(),
            'offer_productsku' =>$offer_sku,
            'shipping_charge' =>$shipping_charge,
        ]);
        
       
        foreach ($cartItems as $item) 
        {
            $sku = Sku::find($item->sku_id);
        
            if (!$sku) {
                return response()->json([
                    'status' => false,
                    'message' => "SKU not found for item ID: {$item->sku_id}",
                ], 404);
            }
        
            if ($sku->quantity < $item->quantity) {
                return response()->json([
                    'status' => false,
                    'message' => "Insufficient stock for SKU: {$sku->id}. Available: {$sku->quantity}, Requested: {$item->quantity}",
                ], 400);
            }
            OrderItems::create([
                'order_id' => $newOrder->id,
                'order_no' => $newOrder->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product_name,
                'product_slug' => Product::getProductSlug($item->product_id),
                'thumbnail' => Product::getProductThumbnail($item->product_id),
                'sku_id' => $item->sku_id,
                'sku_title' => $item->sku,
                'combination' => $item->combination,
                'combination_id' => $item->combination_id,
                'skuvalues_ids' => $item->skuvalues_ids,
                'qty' => $item->quantity,
                'price' => $item->price,
                'special_price' => $item->special_price,
                'total' => $item->total,
            ]);
        }

        
        //here create ordertimes
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }

    return response()->json(['success' => true, 'message' => 'Order Generated', 'order' => $order ,'offer_productsku_id' => $offer_sku,]);
    }
    */
  
    public function placeOrder(Request $request)
    {
        try {
            $user = auth()->user();
    
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'User Not Found']);
            }
    
            // Get cart items based on cart type
            if ($request->cart_type === 'buy') {
                $cartItems = CartItems::where('customer_id', $user->id)
                    ->where(function ($query) {
                        $query->where('cart_type', 'buy');
                    })
                    ->get();
            }
    
            if ($request->cart_type === 'cart' || $request->cart_type === null) {
                $cartItems = CartItems::where('customer_id', $user->id)
                    ->where('cart_type', 'cart')
                    ->get();
            }
    
            \Log::info($cartItems);
    
            $amount = $cartItems->sum('total');
            $shipping_charge = $request->shipping_charge;
            $address = Address::find($request->address_id);
            $offer_sku = $request->offersku_id;
    
            // TODO: Replace with actual amount calculation if needed
            $totalAmount = 100.00;
    
            $razorKey = env('RAZORPAY_KEY');
            $razorSecret = env('RAZORPAY_SECRET');
    
            \Log::info('RAZORPAY_KEY');
            \Log::info($razorKey);
            \Log::info('RAZORPAY_SECRET');
            \Log::info($razorSecret);
    
            $api = new Api($razorKey, $razorSecret);
    
            // Create Razorpay Order
            try {
                $order = $api->order->create([
                    'receipt' => 'ORDER_' . uniqid(),
                    'amount' => $totalAmount,
                    'currency' => 'INR',
                    'notes' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $address->phone_number,
                    ]
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Error creating Razorpay order: ' . $e->getMessage()
                ], 500);
            }
    
            $order = $order->toArray();
    
            // Save order and items to DB
            try {
                $newOrder = Orders::create([
                    'payment_order_id' => $order['id'],
                    'total_amount' => $order['amount'] / 100,
                    'customer_id' => $user->id,
                    'customer_name' => $address->name,
                    'customer_phone' => $address->phone_number,
                    'customer_email' => $user->email,
                    'address' => $address->address,
                    'landmark' => $address->city,
                    'pincode' => $address->pincode,
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                    'date' => Carbon::now()->toDateTimeString(),
                    'offer_productsku' => $offer_sku,
                    'shipping_charge' => $shipping_charge,
                ]);
    
                foreach ($cartItems as $item) {
                    $sku = Sku::find($item->sku_id);
    
                    if (!$sku) {
                        return response()->json([
                            'status' => false,
                            'message' => "SKU not found for item ID: {$item->sku_id}",
                        ], 404);
                    }
    
                    if ($sku->quantity < $item->quantity) {
                        return response()->json([
                            'status' => false,
                            'message' => "Insufficient stock for SKU: {$sku->id}. Available: {$sku->quantity}, Requested: {$item->quantity}",
                        ], 400);
                    }
    
                    OrderItems::create([
                        'order_id' => $newOrder->id,
                        'order_no' => $newOrder->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product_name,
                        'product_slug' => Product::getProductSlug($item->product_id),
                        'thumbnail' => Product::getProductThumbnail($item->product_id),
                        'sku_id' => $item->sku_id,
                        'sku_title' => $item->sku,
                        'combination' => $item->combination,
                        'combination_id' => $item->combination_id,
                        'skuvalues_ids' => $item->skuvalues_ids,
                        'qty' => $item->quantity,
                        'price' => $item->price,
                        'special_price' => $item->special_price,
                        'total' => $item->total,
                    ]);
                }
    
                // Optionally: you could clear cart items here
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Database error: ' . $e->getMessage()
                ], 500);
            }
    
            // Success response
            return response()->json([
                'success' => true,
                'message' => 'Order Generated',
                'order' => $order,
                'offer_productsku_id' => $offer_sku,
            ]);
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Authentication Error: ' . $e->getMessage()
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    /*
    public function verifyPayment(Request $request)
    {
       
         try 
         {
        
        //$razorKey = 'rzp_test_6M10IZtEi8FbEZ';  
        //$razorSecret = 'Aokvn8WzjWuEzXEGCr7fdxzg';
        
        $razorKey = env('RAZORPAY_KEY');  
        $razorSecret = env('RAZORPAY_SECRET');
        \Log::info('RAZORPAY_KEY');
        \Log::info($razorKey);
        
        \Log::info('RAZORPAY_SECRET');
        \Log::info($razorSecret);
        
        $api = new Api($razorKey, $razorSecret);

        $payment = $api->payment->fetch($request->razorpay_payment_id);

            //$cartItems = CartItems::where('customer_id', \Auth::user()->id)->get();
            $cartItems = CartItems::where('customer_id', \Auth::user()->id)
                ->where('cart_type', 'buy')
                ->get();
            
            if ($cartItems->isEmpty()) {
                $cartItems = CartItems::where('customer_id', \Auth::user()->id)
                    ->where('cart_type', 'cart')
                    ->get();
            }

            $orderData = Orders::where('payment_order_id',$request->payment_order_id)->first();
            $orderData->r_payment_id=$request->razorpay_payment_id;
            
            $orderData->signature=$request->razorpay_signature;
            $orderData->is_paid = 'yes';
            $orderData->payment_method = $payment->method;
            
            
             if ($orderData->save()) {
    
                $invoice = new Invoice();
                $invoice->order_id = $orderData->id;
                $invoice->order_no = $orderData->order_no;
                $invoice->customer_id = \Auth::user()->id;
                $invoice->customer_name = \Auth::user()->name;
                $invoice->customer_phone = $orderData->customer_phone;
                $invoice->customer_email = $orderData->customer_email;
                $invoice->date = date('Y-m-d H:i:s');
                $invoice->payment_method = $orderData->payment_method;
                $invoice->offer_productsku = $orderData->offer_productsku;
                $invoice->shipping_charge = $orderData->shipping_charge;
                $invoice->total_amount = $orderData->total_amount;
                $invoice->is_paid = 'yes';
                $invoice->invoice_generated = 'yes';
                $invoice->address = $orderData->address;
                $invoice->landmark = $orderData->landmark;
                $invoice->pincode = $orderData->pincode;
                $invoice->created_by = \Auth::user()->id;
                $invoice->updated_by = \Auth::user()->id;
                $invoice->created_at = date('Y-m-d H:i:s');
                $invoice->updated_at = date('Y-m-d H:i:s');
                 
                $invoice->save();
                $orderItems = OrderItems::where('order_id', $orderData->id)->get();
                foreach ($orderItems as $row) {
                    $invoiceItem = new InvoiceItems();
                    $invoiceItem->order_id = $orderData->id;
                    $invoiceItem->order_no = $orderData->order_no;
                    $invoiceItem->invoice_no = $invoice->invoice_no;
                    $invoiceItem->invoice_id = $invoice->id;
                    $invoiceItem->order_item_id = $row->id;
                    $invoiceItem->product_id = $row->product_id;
                    $invoiceItem->product_name = $row->product_name;
                    $invoiceItem->sku_id = $row->sku_id;
                    $invoiceItem->sku_title = $row->sku_title;
                    $invoiceItem->combination = $row->combination;
                    $invoiceItem->qty = $row->qty;
                    $invoiceItem->price = $row->price;
                    $invoiceItem->special_price = $row->special_price;
                    $invoiceItem->total = $row->total;
                    $invoiceItem->skuvalues_ids = $row->skuvalues_ids;
                     
                    $invoiceItem->save();
                    
                }
               
                foreach ($cartItems as $item) {
                    $sku = Sku::find($item->sku_id);
                    $sku->quantity -= $item->quantity;
                    if ($sku->quantity == 0) 
                    {
                        $sku->stock_status = 'out-of-stock'; 
                    }
                
                    $sku->save();
                    $item->delete();
                    
                    if ($item->cart_type === 'buy') {
                        CartItems::where('customer_id', $item->customer_id)
                            ->where('product_id', $item->product_id)
                            ->where('sku_id', $item->sku_id)
                            ->where('cart_type', 'cart')
                            ->delete();
                    }
                   
                }
                if (!empty($orderData->offer_productsku)) {
                    $offerSku = Sku::find($orderData->offer_productsku);
                    
                    if ($offerSku) {
                        $offerSku->quantity -= 1;
                
                        if ($offerSku->quantity <= 0) {
                            $offerSku->quantity = 0;
                            $offerSku->stock_status = 'out-of-stock';
                        }
                
                        $offerSku->save();
                    }
                }
                return response()->json([
                    'message' => 'Order Placed',
                    'status' => true,
                ]);
    
            }
            return response()->json(['status'=>true,
                                   
                                    'message'=>'Successflly Placed']);
        }
        
        
            catch (\Exception) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while verifying payment.',
                
            ]);
        }
    }
    */
    public function verifyPayment(Request $request)
    {
        try 
        {
            //$razorKey = 'rzp_test_6M10IZtEi8FbEZ';  
            //$razorSecret = 'Aokvn8WzjWuEzXEGCr7fdxzg';
    
            $razorKey = env('RAZORPAY_KEY');  
            $razorSecret = env('RAZORPAY_SECRET');
            \Log::info('RAZORPAY_KEY');
            \Log::info($razorKey);
            
            \Log::info('RAZORPAY_SECRET');
            \Log::info($razorSecret);
            
            $api = new Api($razorKey, $razorSecret);
    
            $payment = $api->payment->fetch($request->razorpay_payment_id);
    
            //$cartItems = CartItems::where('customer_id', \Auth::user()->id)->get();
            $cartItems = CartItems::where('customer_id', \Auth::user()->id)
                ->where('cart_type', 'buy')
                ->get();
    
            if ($cartItems->isEmpty()) {
                $cartItems = CartItems::where('customer_id', \Auth::user()->id)
                    ->where('cart_type', 'cart')
                    ->get();
            }
    
            $orderData = Orders::where('payment_order_id',$request->payment_order_id)->first();
            $orderData->r_payment_id = $request->razorpay_payment_id;
            $orderData->signature = $request->razorpay_signature;
            $orderData->is_paid = 'yes';
            $orderData->payment_method = $payment->method;
    
            if ($orderData->save()) {
    
                $invoice = new Invoice();
                $invoice->order_id = $orderData->id;
                $invoice->order_no = $orderData->order_no;
                $invoice->customer_id = \Auth::user()->id;
                $invoice->customer_name = \Auth::user()->name;
                $invoice->customer_phone = $orderData->customer_phone;
                $invoice->customer_email = $orderData->customer_email;
                $invoice->date = date('Y-m-d H:i:s');
                $invoice->payment_method = $orderData->payment_method;
                $invoice->offer_productsku = $orderData->offer_productsku;
                $invoice->shipping_charge = $orderData->shipping_charge;
                $invoice->total_amount = $orderData->total_amount;
                $invoice->is_paid = 'yes';
                $invoice->invoice_generated = 'yes';
                $invoice->address = $orderData->address;
                $invoice->landmark = $orderData->landmark;
                $invoice->pincode = $orderData->pincode;
                $invoice->created_by = \Auth::user()->id;
                $invoice->updated_by = \Auth::user()->id;
                $invoice->created_at = date('Y-m-d H:i:s');
                $invoice->updated_at = date('Y-m-d H:i:s');
                $invoice->save();
    
                $orderItems = OrderItems::where('order_id', $orderData->id)->get();
                foreach ($orderItems as $row) {
                    $invoiceItem = new InvoiceItems();
                    $invoiceItem->order_id = $orderData->id;
                    $invoiceItem->order_no = $orderData->order_no;
                    $invoiceItem->invoice_no = $invoice->invoice_no;
                    $invoiceItem->invoice_id = $invoice->id;
                    $invoiceItem->order_item_id = $row->id;
                    $invoiceItem->product_id = $row->product_id;
                    $invoiceItem->product_name = $row->product_name;
                    $invoiceItem->sku_id = $row->sku_id;
                    $invoiceItem->sku_title = $row->sku_title;
                    $invoiceItem->combination = $row->combination;
                    $invoiceItem->qty = $row->qty;
                    $invoiceItem->price = $row->price;
                    $invoiceItem->special_price = $row->special_price;
                    $invoiceItem->total = $row->total;
                    $invoiceItem->skuvalues_ids = $row->skuvalues_ids;
                    $invoiceItem->save();
                }
    
                foreach ($cartItems as $item) {
                    $sku = Sku::find($item->sku_id);
                    $sku->quantity -= $item->quantity;
                    if ($sku->quantity == 0) {
                        $sku->stock_status = 'out-of-stock';
                    }
                    $sku->save();
                    $item->delete();
    
                    if ($item->cart_type === 'buy') {
                        CartItems::where('customer_id', $item->customer_id)
                            ->where('product_id', $item->product_id)
                            ->where('sku_id', $item->sku_id)
                            ->where('cart_type', 'cart')
                            ->delete();
                    }
                }
    
                if (!empty($orderData->offer_productsku)) {
                    $offerSku = Sku::find($orderData->offer_productsku);
                    if ($offerSku) {
                        $offerSku->quantity -= 1;
                        if ($offerSku->quantity <= 0) {
                            $offerSku->quantity = 0;
                            $offerSku->stock_status = 'out-of-stock';
                        }
                        $offerSku->save();
                    }
                }
    
                return response()->json([
                    'message' => 'Order Placed',
                    'status' => true,
                ]);
            }
    
            return response()->json([
                'status' => true,
                'message' => 'Successfully Placed',
            ]);
        } 
        
        catch (AuthenticationException $e) {
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
            \Log::error('VerifyPayment Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'error' => 'General Error',
                'message' => 'Something went wrong while verifying payment.',
                'details' => $e->getMessage() // Optional: hide in production
            ], 500);
        }
    }

  
   
   
    public function checkout(Request $request)
    {
    
        $cartItems= CartItems::where('customer_id', $user->id)->get();
        $amount = CartItems::where('id', $cartItems->id)->sum('total');
        $address = Address::where('is_defualt', 'yes')->where('customer_id', $cartItems->customer_id)->first();
// dd($cartItems);
        $orderData = new Orders();
        $orderData->customer_id = $cart->customer_id;
        $orderData->customer_name = \Auth::user()->name;
        $orderData->customer_email = \Auth::user()->email;
        $orderData->customer_phone = \Auth::user()->phone;
        if ($request->is_coupon_applied == "true") {
            $orderData->is_coupon_applied = 'yes';

            
            if ($couponId) {
                $coupon = Coupons::where('id', $couponId)->first();
                if ($coupon) {
                    $total = $cartItem->sum('total');

                    $discountPercent = $coupon->offer_percent;

                    $discountAmount = $total * $discountPercent / 100;
                    $totalPrize = $total - $discountAmount;

                    $orderData->total_amount = $totalPrize;
                   
                }
            }
        } else {
            $orderData->is_coupon_applied = 'no';
            $orderData->total_amount = $amount;
        }
        $orderData->date = date('Y-m-d H:i:s');
        $orderData->address = $address->address;
        $orderData->landmark = $address->landmark;
        $orderData->payment_method=$request->payment_method;
        $orderData->reference_no=$request->reference_no;
        $orderData->pincode = $address->pincode;
        $orderData->address_name = $address->name;
        $orderData->address_type = $address->type;
        $orderData->created_by = \Auth::user()->id;
        $orderData->updated_by = \Auth::user()->id;
        $orderData->created_at = date('Y-m-d H:i:s');
        $orderData->updated_at = date('Y-m-d H:i:s');
        $orderData->reference_no = $request->payment_id;
        $orderData->is_paid = 'yes';
        if ($orderData->save()) {
            $total = 0;
            $orderItemsData = [];
            foreach ($cartItems as $item) {
                $orderItem = new OrderItems();
                $orderItem->order_id = $orderData->id;
                $orderItem->order_no = $orderData->order_no;
                $orderItem->product_id = $item->product_id;
                $orderItem->product_name = $item->product_name;
                $orderItem->thumbnail = Product::getProductThumbnail($item->product_id);
                $orderItem->sku_id = $item->sku_id;
                $orderItem->sku_title = $item->sku;
                $orderItem->combination = $item->combination;
                $orderItem->combination_id = $item->combination_id;
                $orderItem->skuvalues_ids = $item->skuvalues_ids;
                $orderItem->qty = $item->quantity;
                $orderItem->price = $item->price;
                $orderItem->special_price = $item->special_price;
                $orderItem->total = $item->total;
                $orderItem->save();
                $orderItemsData[] = $orderItem;
                $total += $orderItem->total;

            }
            $orderData->total = $total;

            $orderData->save();

            $invoice = new Invoice();
            $invoice->order_id = $orderData->id;
            $invoice->order_no = $orderData->order_no;
            $invoice->customer_id = \Auth::user()->id;
            $invoice->customer_name = \Auth::user()->name;
            $invoice->customer_phone = \Auth::user()->phone;
            $invoice->customer_email = \Auth::user()->email;;
            $invoice->date = date('Y-m-d H:i:s');
            $invoice->payment_method = $request->payment_method;
            $invoice->total_amount = $orderData->total;
            $invoice->reference_no = $orderData->reference_no;
            $invoice->address = $orderData->address;
            $invoice->landmark = $orderData->landmark;
            $invoice->pincode = $orderData->pincode;
            $invoice->created_by = \Auth::user()->id;
            $invoice->updated_by = \Auth::user()->id;
            $invoice->created_at = date('Y-m-d H:i:s');
            $invoice->updated_at = date('Y-m-d H:i:s');
            $invoice->save();
            $orderItems = OrderItems::where('order_id', $orderData->id)->get();
            foreach ($orderItems as $row) {
                $invoiceItem = new InvoiceItems();
                $invoiceItem->order_id = $orderData->id;
                $invoiceItem->order_no = $orderData->order_no;
                $invoiceItem->invoice_no = $invoice->invoice_no;
                $invoiceItem->invoice_id = $invoice->id;
                $invoiceItem->order_item_id = $row->id;
                $invoiceItem->product_id = $row->product_id;
                $invoiceItem->product_name = $row->product_name;
                $invoiceItem->sku_id = $row->sku_id;
                $invoiceItem->sku_title = $row->sku_title;
                $invoiceItem->combination = $row->combination;
                $invoiceItem->qty = $row->qty;
                $invoiceItem->price = $row->price;
                $invoiceItem->special_price = $row->special_price;
                $invoiceItem->total = $row->total;
                $invoiceItem->skuvalues_ids = $row->skuvalues_ids;
                $invoiceItem->save();
            }
           
            $cartDelete = Cart::where('id', $cart->id)->delete();
            $cartItemsDelete = CartItems::where('cart_id', $cart->id)->delete();
            return response()->json([
                'message' => 'Order Placed',
            ]);

        }

    }
    
    
    
    public function orderHistory(Request $request)
    {
        try {
            $user = auth()->user();
    
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }
    
            // Fetch order history with relations
            $orderHistory = Orders::where('customer_id', $user->id)
                ->where('is_paid', 'yes')
                ->with(['orderItems', 'offerSku', 'invoice.invoiceItems'])
                ->select('id', 'order_no', 'total_amount', 'date', 'status', 'delivery_status', 'offer_productsku', 'shipping_charge')
                ->orderBy('updated_at', 'desc')
                ->get();
    
            // Success response
            return response()->json([
                'status' => true,
                'orderHistory' => $orderHistory
            ]);
    
        } catch (AuthenticationException $e) {
            // Handle auth errors
            return response()->json([
                'status' => false,
                'message' => 'Authentication Error: ' . $e->getMessage()
            ], 401);
    
        } catch (\Exception $e) {
            // Handle general exceptions
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    
    
    public function cancelOrder(Request $request)
    {
        try {
            // Auth error handling
            $user = auth()->user();
            if (!$user) {
                throw new AuthenticationException('User not authenticated');
            }
    
            // Validation error handling
            $validator = Validator::make($request->all(), [
                'order_id' => 'required|exists:orders,id',
            ], [
                'order_id.required' => 'Order ID is required',
                'order_id.exists' => 'Order not found in records',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'error' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            // Get the order for the authenticated user
            $order = Orders::where('customer_id', $user->id)
                ->where('id', $request->order_id)
                ->where('is_paid', 'yes')
                ->first();
    
            if (!$order) {
                return response()->json([
                    'status' => false,
                    'error' => 'Order not eligible for cancellation or does not exist'
                ], 404);
            }
    
            // Cancel order and update status
            $order->cancel_status = 'yes';
            $order->status = 'rejected';
            $order->delivery_status = 'cancelled';
            $order->save();
    
            // Update invoice status
            $invoice = Invoice::where('order_id', $order->id)->first();
            if ($invoice) {
                $invoice->cancel_status = 'yes';
                $invoice->save();
            }
    
            // Restore stock for order items
            $orderItems = OrderItems::where('order_id', $order->id)->get();
            foreach ($orderItems as $item) {
                $sku = Sku::find($item->sku_id);
                if ($sku) {
                    $sku->quantity += $item->qty;
                    $sku->stock_status = 'in-stock';
                    $sku->save();
                }
            }
    
            // Restore offer SKU stock if used
            if (!empty($order->offer_productsku)) {
                $offerSku = Sku::find($order->offer_productsku);
                if ($offerSku) {
                    $offerSku->quantity += 1;
                    $offerSku->stock_status = 'in-stock';
                    $offerSku->save();
                }
            }
    
            // Success response
            return response()->json([
                'status' => true,
                'message' => 'Order cancelled and stock restored successfully'
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
            \Log::error('Cancel order failed: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'error' => 'General Error',
                'message' => 'Something went wrong while cancelling the order',
                'details' => $e->getMessage() // Optional in production
            ], 500);
        }
    }

    
    
    public function addReview(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'rating' => 'required',
                'comment' => 'required',
                'product_id' => 'required',
            ], [
                'rating.required' => 'please mark rating',
                'comment.required' => 'please enter comment',
                'product_id.required' => 'please select product',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 400);
            }
    
            $user = auth()->user();
    
            $review = Review::where('user_id', $user->id)
                ->where('product_id', $request->product_id)
                ->first();
    
            if ($review) {
                $review->rating = $request->rating;
                $review->comment = $request->comment;
                $review->updated_by = \Auth::user()->id;
                $review->updated_at = now();
                $review->save();
    
                return response()->json([
                    'status' => true,
                    'message' => 'Review updated successfully'
                ]);
            }
    
            $data = new Review();
            $data->name = $user->name;
            $data->user_id = $user->id;
            $data->email = $user->email;
            $data->rating = $request->rating;
            $data->comment = $request->comment;
            $data->product_id = $request->product_id;
            $data->created_by = \Auth::user()->id;
            $data->created_at = now();
            $data->updated_by = \Auth::user()->id;
            $data->updated_at = now();
            $data->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Reviewed successfully'
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
            \Log::error('AddReview Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'error' => 'General Error',
                'message' => 'Something went wrong while adding the review.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    

   
    public function CheckAvailable(Request $request)
    {
        try {
            if (!\Auth::guard('api')->check()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please login to add items to your cart.',
                ], 401);
            }
    
            $customer_id = Auth::guard('api')->id();
    
            if ($request->cart_type === 'buy') {
                $cartItems = CartItems::where('customer_id', $customer_id)
                    ->where(function ($query) {
                        $query->where('cart_type', 'buy');
                    })
                    ->get();
            } else {
                $cartItems = CartItems::where('customer_id', $customer_id)
                    ->where('cart_type', 'cart')
                    ->get();
            }
    
            if ($cartItems->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Your cart is empty. Please add items before checking availability.',
                ], 400);
            }
    
            $customerPincode = $request->pincode;
            $totalPrice = $cartItems->sum('total');
    
            $geoResponse =Http::get("http://api.geonames.org/postalCodeSearchJSON", [
                'postalcode' => $customerPincode,
                'country' => 'IN',
                'maxRows' => 1,
                'username' => 'Lagro_V1'
            ]);
    
            if (!$geoResponse->ok() || empty($geoResponse['postalCodes'])) {
                return response()->json([
                    'error' => 'Invalid pincode or GeoNames error.'
                ], 400);
            }
    
            $customerLat = $geoResponse['postalCodes'][0]['lat'];
            $customerLng = $geoResponse['postalCodes'][0]['lng'];
            $customerState = $geoResponse['postalCodes'][0]['adminName1'];
    
            //$warehouses = Warehouse::where('state', $customerState)->get();
            $warehouses = Location::where('state', $customerState)->get();
    
            if ($warehouses->isEmpty()) {
                return response()->json([
                    'error' => 'No warehouses available in your state.'
                ], 404);
            }
    
            $minDistance = null;
            $nearestWarehouse = null;
    
            foreach ($warehouses as $warehouse) {
                $distance = $this->calculateDistance($customerLat, $customerLng, $warehouse->latitude, $warehouse->longitude);
    
                if (is_null($minDistance) || $distance < $minDistance) {
                    $minDistance = $distance;
                    $nearestWarehouse = $warehouse;
                }
            }
    
            $roundedDistance = round($minDistance);
    
            $response = [
                'warehouse' => [
                    'id' => $nearestWarehouse->id,
                    'warehouse_name' => $nearestWarehouse->location_name,
                    'latitude' => $nearestWarehouse->latitude,
                    'longitude' => $nearestWarehouse->longitude,
                ],
                'distance_km' => $roundedDistance
            ];
            
            $shippingKm = Settings::where('label', 'shipping_km')->value('value');
            $shippingChargeLimit = Settings::where('label', 'shipping_charge')->value('value');
    
            if ($roundedDistance <= $shippingKm) {
                $shippingCharge = 0;
            } elseif ($roundedDistance > 100 && $totalPrice <= 25000) {
                $shippingCharge = $shippingChargeLimit;
            } else {
                $shippingCharge = 0;
            }
    
            $response['shipping_charge'] = $shippingCharge;
            $response['total_price'] = $totalPrice;
            $response['customer_state'] = $customerState;
    
            return response()->json($response);
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
            \Log::error('CheckAvailable Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'error' => 'General Error',
                'message' => 'Something went wrong while checking availability.',
                'details' => $e->getMessage() // Optional: hide in production
            ], 500);
        }
    }




    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        
        $earthRadius = 6371;
        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);
    
        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);
    
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }  
        
   
    public function downloadInvoice(Request $request)
    {
        try {
            $id = $request->invoice_id;
    
            $data = Invoice::with('InvoiceItems', 'customers', 'customerAddress')->find($id);
    
            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invoice not found.'
                ], 404);
            }
    
            $offerproduct = null;
    
            if (!empty($data->offer_productsku)) {
                $offerproduct =Sku::with('productItems')->find($data->offer_productsku);
            }
    
            $pdf = PDF::loadView('admin.invoice.invoice', compact('data', 'offerproduct'));
    
            return $pdf->download('invoice' . $data->invoice_no . '.pdf');
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
            \Log::error('DownloadInvoice Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'error' => 'General Error',
                'message' => 'Failed to generate invoice PDF.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    
}
