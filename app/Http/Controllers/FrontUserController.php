<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Category;
use App\Models\Coupons;
use App\Models\GroupDetails;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Pincodes;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\Sku;
use App\Models\SkuValues;
use App\Models\Review;

use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
// use PayPal\Core\SandboxEnvironment;

use Session;

class FrontUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $categories = Category::with(['products' => function ($query) {
        //     $query->limit(2);
        // }])->get();
        $data = [];
        $categories = Category::get();
        foreach ($categories as $category) {
            $products = Product::with('sku')->where('category_ids', $category->id)->take(8)->get();
            $productCount = Product::with('sku')->where('category_ids', $category->id)->count();
            $category->products = $products->toArray();
          
            $category->productCount = $productCount;
            $data[] = $category;

        }
        // echo "<pre>";
        // print_r($productCount);
        // exit;
        return view('shopping.index', [
            'data' => $data,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getProductsByCategory(Request $request)
    {
        // $category=Category::get();
        // return response()->json($category);
        $categoryId = $request->input('id');

        $category = Category::find($categoryId);

        if (!$category) {
            // Category not found
            return response()->json(['error' => 'Category not found'], 404);
        }

        $products = Product::with('sku')->where('category_ids', $categoryId)->take(8)->get();

        $view = View('shopping.productItems', [
            'products' => $products,

        ]);
        return $view;
    }
    public function aboutUsPage()
    {
        return view('shopping.aboutpage');
    }
    public function contactUsPage()
    {
        return view('shopping.contactus');
    }
    public function shopCategory($slug)
    {
        $categories = Category::where('status', 'yes')->orderBy('position', 'asc')->get();
        $category = Category::where('slug', $slug)->first();

        if (!$category) {

            return response()->json(['error' => 'Category not found'], 404);
        }

        $products = Product::with('sku')->where('category_ids', $category->id)->get();

        return view('shopping.categoryproducts', [
            'products' => $products,
            'category' => $category,
            'categories' => $categories,
        ]);

    }
    public function productDetails($slug)
    {
        //  dd($slug);
        $product = Product::with('sku')->where('slug', $slug)->first();
        if (!$product) {
            // Handle the case when the product is not found, redirect or show an error message.
            return redirect()->route('product.not.found');
        }
        $reviews=Review::where('product_id',$product->id)->where('is_approved','yes')->orderby('created_at','DESC')->limit(10)->get();
		$review_count=Review::where('product_id',$product->id)->where('is_approved','yes')->count();
        $averageRating = Review::where('product_id', $product->id)
        ->where('is_approved', 'yes')
        ->avg('rating');
        // dd($product);
        //     echo "<pre>";
        // print_r($product);
        // exit;
    //  echo "<pre>";
    //  print_r($review_count);
    //  exit;
        return view('shopping.singleProduct', [
            'product' => $product,
            'reviews'=>$reviews,
			'review_count'=>$review_count,
            'averageRating' => $averageRating,

        ]);
    }
    public function addToCart(Request $request)
    {

        $session_id = Session::get('session_id') == null ? 0 : Session::get('session_id');
        if (\Auth::guest()) {
            $cart = Cart::where('customer_id', $session_id)->first();

            if (!isset($cart)) {

                $this->initCart();
                $session_id = Session::get('session_id');
                $cart = Cart::where('customer_id', $session_id)->first();
            }

        } else {

            $cart = Cart::where('customer_id', \Auth::user()->id)->first();
            if (!$cart) {
                $customer_id = Session::get('session_id');
                $cart = Cart::where('customer_id', $customer_id)->first();
            }
            if (!$cart) {
                $this->initCart();
                $cart = Cart::where('customer_id', \Auth::user()->id)->first();
            } else {
                $this->initCartId();
                $cart = Cart::where('customer_id', \Auth::user()->id)->first();
            }
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
        // if($request->has('request_from') && $request->request_from == 'list')
        // {
        //     $cartItems->quantity=$cartItems->quantity+$request->quantity;
        // }
        $cartItems->price = $sku->price;
        $cartItems->special_price = $sku->special_price;
        if ($sku->special_price == '' || $sku->special_price == 0) {
            $cartItems->total = $request->quantity * $sku->price;
        } else {
            $cartItems->total = $request->quantity * $sku->special_price;
        }
        if (count($skValues) > 0) {
            $cartItems->skuvalues_ids = implode(',', $skValues->toArray());
        }
        $cartItems->save();
        echo 1; //jkfkjk

    }
    public function initCart()
    {
        $session_id = Session::get('session_id');
        if ($session_id == null || $session_id == '') {
            $session_id = time() . str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz');
            Session::put('session_id', $session_id);
        }
        $session_id = Session::get('session_id');
        $cart = new Cart();
        if (\Auth::guest()) {
            $cart->customer_id = $session_id;
        } else {
            //$this->initCartId();
            $cart->customer_id = \Auth::user()->id;

        }
        $cart->date = date('Y-m-d H:i:s');
        $cart->save();
    }
    public function initCartId()
    {
        $session_id = Session::get('session_id') == null ? \Auth::user()->id : Session::get('session_id');
        if (\Auth::guest() != true) {
            $cart = Cart::where('customer_id', \Auth::user()->id)->first();
            if (!isset($cart)) {
                $cart = Cart::where('customer_id', $session_id)->update(['customer_id' => \Auth::user()->id]);
            }
            $items = CartItems::where('cart_id', $cart->id)->update(['customer_id' => $cart->customer_id]);
            Session::put('session_id', null);
            return true;
        }
        return true;
    }
    public function removeCartItem(Request $request)
    {
        $cartItemId = $request->input('cartItemId');

        $cartItem = CartItems::find($cartItemId);

        if (!$cartItem) {
            // Cart item not found
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
    public function getCartItemCount()
    {

        $customerId = Auth::guest() ? Session::get('session_id') : Auth::user()->id;

        $cart = Cart::where('customer_id', $customerId)->first();

        if ($cart) {
            $cartItemCount = $cart->cartItems()->count();
        } else {
            $cartItemCount = 0;
        }
        // dd($cartItemCount);
        return response()->json(['count' => $cartItemCount]);
    }
    public function updateCart(Request $request)
    {

        $data = CartItems::find($request->id);

        $data->quantity = $request->quantity;
        $price = $data->special_price != '' ? $data->special_price : $data->price;
        $data->total = $request->quantity * $price;
        $data->save();
        if (!\Auth::guest()) {
            $cart = Cart::find($data->cart_id);
            $cart->customer_id = \Auth::user()->id;
            $cart->save();
            $cart_items = CartItems::where('customer_id', $data->customer_id)->update(['customer_id' => $cart->customer_id]);
        }
        // $cart = Cart::find($data->cart_id);
        // $subtotal = CartItems::where('cart_id', $cart->id)->sum('total');
        // $vat = $subtotal * 0.20;
        // $total = $subtotal + $vat;

        // return response()->json([
        //     'subtotal' => $subtotal,
        //     'vat' => $vat,
        //     'total' => $total,
        // ]);
        echo 1;

    }
    public function viewFullCart()
    {
        $customerId = Auth::guest() ? Session::get('session_id') : Auth::user()->id;
        $cart = Cart::where('customer_id', $customerId)->first();

        if (!$cart) {
            return response()->json([
                'items' => '',
                'sub_total' => 0,
                'vat' => 0,
                'total' => 0,
            ]);
        }

        $cartItems = CartItems::with('productItems')->where('cart_id', $cart->id)->get();
        $subTotal = $cartItems->sum('total');
        //  return $subTotal;
        // $vat = $subTotal * 0.2; // Assuming VAT is 20%
        $total = $subTotal;
        return view('shopping.cartfull', [
            'cartItems' => $cartItems,
        ]);
    }
    public function checkOut()
    {
        if (\Auth::check()) {
            $customerid = auth()->user()->id;
            $cartItems = CartItems::with('productItems')->where('customer_id', $customerid)->get();
            $subTotal = $cartItems->sum('total');
            //  return $subTotal;
            // Assuming VAT is 20%
            // $deliverycharge = "80";
            $total = $subTotal;

            return view('shopping.checkout', [
                'subTotal' => $subTotal,
                'total' => $total,
            ]);
        } else {
            Session::put('redirect_url', route('checkout'));
            return redirect('login');
        }

    }
    public function checkoutLogin(Request $request)
    {
        // dd($request);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            if (Session::has('redirect_url')) {
                $redirectUrl = Session::get('redirect_url');
                Session::forget('redirect_url');
                return redirect()->to($redirectUrl);
            }

            return redirect('/');
        } else {

            return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
        }
    }
    public function signUp()
    {
        return view('shopping.register');
    }
    public function search(Request $request)
    {
        $searchTerm = $request->input('q');

        $pincodes = Pincodes::where('division_name', 'LIKE', "%{$searchTerm}%")->get();

        $data = [];

        foreach ($pincodes as $pincode) {
            $data[] = [

                'id' => $pincode->division_name,
                'officename' => $pincode->office_name,
            ];
        }
        //  dd($data);
        return response()->json($data);
    }
    public function getCityState(Request $request)
    {
        $pincode = $request->input('pincode');
        $pincodes = Pincodes::where('pincode', $pincode)->first();

        if ($pincodes) {
            $city = $pincodes->division_name;
            $state = $pincodes->statename;
        } else {
            $city = '';
            $state = '';
        }

        return response()->json([
            'city' => $city,
            'state' => $state,
        ]);
    }
    public function storeAddress(Request $request)
    {
        // dd($request);
        $request->validate([
            'firstname' => 'required',
            'phonenumber' => 'required',
            'address' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'state' => 'required',
            'country' => 'required',
        ]);

        $data = new Address();
        $data->name = $request->firstname;
        $data->customer_id = auth()->user()->id;
        $data->address = $request->address;
        $data->phone_number = $request->phonenumber;
        $data->city = $request->city;
        $data->pincode = $request->pincode;
        $data->state = $request->state;
        $data->country = $request->country;
        $data->save();
        $count = Address::where('customer_id', auth()->user()->id)->count();
        if ($count == 1) {
            Address::where('customer_id', auth()->user()->id)->update(['is_defualt' => 'yes']);
        }
        return response()->json(['message' => 'Address added successfully'], 200);
    }
    public function loadAddress(Request $request)
    {

        $addressList = Address::where('customer_id', auth()->user()->id)->get();

        $addressListView = View::make('front.address1.listaddress', ['addressList' => $addressList])->render();

        return response()->json(['addressList' => $addressListView]);
    }
    public function deleteAddress(Request $request)
    {
        $addressId = $request->input('addressId');

        $address = Address::find($addressId);

        if ($address) {
            $address->delete();
            return response()->json(['message' => 'Address deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Address not found'], 404);
        }

    }
    public function checkProductAvailability(Request $request)
    {
        $couponId = $request->coupon_id; // Fetch the coupon ID from the request
        $pincode = $request->pincode;

        $findGroup = GroupDetails::where('pincode', $pincode)->get();
        $addressgroup = $findGroup[0]['group_id'];

        $customerId = auth()->user()->id;
        $cartProducts = Cartitems::where('customer_id', $customerId)->get();
        $productIds = [];
        foreach ($cartProducts as $item) {
            $productIds[] = $item['product_id'];
        }

        $products = Product::whereIn('id', $productIds)->get();

        $productGroups = ProductGroup::whereIn('product_id', $productIds)
            ->get();

        $allProductsAvailable = true;
        $unavailableProduct = null;

        foreach ($products as $product) {
            $matchingProductGroup = null;
            foreach ($productGroups as $group) {
                if ($group['product_id'] == $product->id && $group['group_id'] == $addressgroup) {
                    $matchingProductGroup = $group;
                    break;
                }
            }

            if (!$matchingProductGroup) {
                $allProductsAvailable = false;
                $unavailableProduct = $product->product_name;
                return response()->json([
                    'message' => 'error',
                    'unavailableProduct' => $unavailableProduct,
                ]);
                break;
            }
        }

        if ($allProductsAvailable) {
            if ($request->has('cart_id') && $request->cart_id != '') {
                $cart = Cart::where('id', $request->cart_id)->first();
            } else {
                $cart = Cart::where('customer_id', \Auth::user()->id)->first();
            }
            $cartItems = CartItems::where('cart_id', $cart->id)->get();
            $amount = CartItems::where('cart_id', $cart->id)->sum('total');
            $address = Address::where('pincode', $pincode)->first();

            $orderData = new Orders();
            $orderData->customer_id = $cart->customer_id;
            $orderData->customer_name = \Auth::user()->name;
            $orderData->customer_email = \Auth::user()->email;
            $orderData->customer_phone = $address->phone_number;

            if ($request->is_coupon_applied == "true") {
                $orderData->is_coupon_applied = 'yes';

                // Check if coupon ID is valid and calculate the discount
                if ($couponId) {
                    $coupon = Coupons::where('id', $couponId)->first();
                    if ($coupon) {
                        $total = $cartItems->sum('total');

                        $discountPercent = $coupon->offer_percent;

                        $discountAmount = $total * $discountPercent / 100;
                        $totalPrize = $total - $discountAmount;

                        $orderData->total_amount = $totalPrize;
                        // echo "<pre>";
                        // print_r($orderData->total_amount );
                        // exit;
                    }
                }
            } else {
                $orderData->is_coupon_applied = 'no';
                $orderData->total_amount = $amount;
            }

            // $orderData->total_amount = 00;
            $orderData->date = date('Y-m-d H:i:s');
            $orderData->address = $address->address;
            $orderData->landmark = $address->landmark;
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
                    $total += $orderItem->total;
                }

                $orderData->total = $total;
                //  echo "<pre>";
                //         print_r($orderData->toArray() );
                //         exit;
                $orderData->save();
                $cartDelete = Cart::findOrFail($cart->id)->delete();
                $cartItemsDelete = CartItems::where('cart_id', $cart->id)->delete();
                return response()->json([
                    'message' => 'success',
                ]);
            } else {
                return response()->json([
                    'message' => 'error',
                    'unavailableProduct' => 'Failed to create the order.',
                ]);
            }
        } else {
            return response()->json([
                'message' => 'error',
                'unavailableProduct' => $unavailableProduct,
            ]);
        }
    }
    public function paymentPage()
    {
        return view('shopping.payment');
    }

    public function sortProducts(Request $request, $categoryId)
    {
        $category = Category::findOrFail($categoryId);

        $sortOption = $request->input('sort');

        $products = Product::with('sku')
            ->where('category_ids', $category->id)
            ->get();

        switch ($sortOption) {
            case 'low_to_high':
                $products = $products->sortBy(function ($product) {
                    return $product->sku[0]['price'] ?? PHP_INT_MAX;
                });
                break;
            case 'high_to_low':
                $products = $products->sortByDesc(function ($product) {
                    return $product->sku[0]['price'] ?? 0;
                });
                break;
            default:

                $products = $products->sortBy(function ($product) {
                    return $product->sku[0]['price'] ?? PHP_INT_MAX;
                });
        }

        return view('shopping.productsort.sortproduct', [
            'products' => $products,
        ]);
    }
    public function loadMore(Request $request)
    {
        $categoryId = $request->categoryId;
        $page = $request->page;
        $take = 3;
        $skip = $page == 1 ? 0 : $take * ($page - 1);
        // $skip = ($page - 1) * $take;
        // $nextskip = ($page) * $take;
        $products = Product::with('sku')
            ->where('category_ids', $categoryId);
        if ($request->has('sort') && $request->sort != '') {
            if ($request->sort == 'high_to_low') {
                $products = $products->whereHas('sku', function ($q) use ($request) {
                    $q->orderBy('price', 'desc');
                });
            }
            if ($request->sort == 'low_to_high') {
                $products = $products->whereHas('sku', function ($q) use ($request) {
                    $q->orderBy('price', 'asc');
                });
            }
        }
        $products = $products->skip($skip)
            ->take($take)
            ->get();

        $nextcount = Product::with('sku')
            ->where('category_ids', $categoryId)
            ->skip($skip)
            ->take($take)
            ->count();
        // ->select('id','product_name')
        //    echo "<pre>";
        //     print_r($products->toArray());
        //     exit;
        // return view('shopping.productsort.sortproduct',[
        //     'products'=>$products,
        // ]);
        $items = view('shopping.productsort.sortproduct', [

            'products' => $products,

        ])->render();

        $footer = view('shopping.page.pagination', [

            'current_page' => $page,
            'total_page' => ceil($nextcount / $take),
            'total_count' => $nextcount,
            'items_per_page' => $take,

        ])->render();

        // dd($footer);
        return response()->json([
            'items' => $items,
            'footer' => $footer,
            'current_page' => $page,
        ]);

    }
    public function loadmorepage(Request $request)
    {
        $categoryId = $request->categoryId;
        $page = $request->has('page') && $request->page != null ? $request->page : 1;
        $take = 6;
        $skip = $page == 1 ? 0 : $take * ($page - 1);
        $filter_category = $request->filter_category;
        //    dd($filter_category);
        $items = Sku::where('is_default', 'yes')
            ->with('productItems')
            ->whereHas('productItems', function ($q) use ($filter_category) {
                $q->where('is_published', 'yes');
                $q->where(function ($query) use ($filter_category) {
                    foreach ($filter_category as $categoryId) {
                        $query->orWhere('category_ids', $categoryId);
                    }
                });

                $q->whereNotNull('category_ids');

            });

        if ($request->has('search') && $request->search != '') {
            $items = $items->whereHas('productItems', function ($q) use ($request) {
                $q->where('product_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('price_range_from') && $request->price_range_from != '') {
            $items = $items->where(function ($q) use ($request) {
                $q->where('special_price', '>=', $request->price_range_from)
                    ->orWhere('price', '>=', $request->price_range_from);
            });
        }

        if ($request->has('price_range_to') && $request->price_range_to != '') {
            $items = $items->where(function ($q) use ($request) {
                $q->where('special_price', '<=', $request->price_range_to)
                    ->orWhere('price', '<=', $request->price_range_to);
            });
        }

        if ($request->has('sort') && $request->sort != '') {
            if ($request->sort == 'low_to_high' || $request->sort == 'high_to_low') {
                $sort_order = $request->sort == 'low_to_high' ? 'asc' : 'desc';
                $items = $items->orderBy('special_price', $sort_order);
            } elseif ($request->sort == 'high_to_low' || $request->sort == 'high_to_low') {
                $sort_order = $request->sort == 'high_to_low' ? 'asc' : 'desc';
                $items = $items->orderBy('special_price', $sort_order);
            }
        }

        $items = $items->skip($skip)->take($take)->get();
        $itemsCount = $items->count();

        $total_count = Sku::where('is_default', 'yes')
            ->with('productItems')
            ->whereHas('productItems', function ($q) use ($filter_category) {
                $q->where('is_published', 'yes');

                $q->where(function ($query) use ($filter_category) {
                    foreach ($filter_category as $categoryId) {
                        $query->orWhere('category_ids', $categoryId);
                    }
                });

                $q->whereNotNull('category_ids');
            })

        // Apply filters based on $request parameters for counting total items
            ->count();

        $total_page = ceil($total_count / $take);

        $items = view('shopping.productsort.sortproduct', [
            'items' => $items,
        ])->render();

        $footer = view('shopping.page.pagination', [
            'current_page' => $page,
            'total_page' => $total_page,
            'total_count' => $total_count,
            'take' => $take,
        ])->render();
//    echo "<pre>";
//         print_r($items);
//         exit;
// return response()->json(['items'=>$items]);
        return response()->json([
            'footer' => $footer,
            'items' => $items,
            'current_page' => $page,
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $code = $request->code;

        $coupon = Coupons::where('coupon_code', $code)->first();

        if ($coupon) {

            $currentDate = date('Y-m-d H:i:s');

            $createdDate = $coupon->created_at;

            $dateDiff = strtotime($currentDate) - strtotime($createdDate);

            $daysDiff = floor($dateDiff / (60 * 60 * 24));

            // echo "<pre>";
            // print_r($coupon->valid_upto);
            // exit;
            if ($daysDiff <= $coupon->valid_upto) {
                $cartItems = CartItems::where('customer_id', auth()->user()->id)->get();
                $total = $cartItems->sum('total');
                $discountpercent = $coupon->offer_percent;

                $discounttotal = $total * $discountpercent / 100;
                $totalPrize = $total - $discounttotal;
                // dd($totalPrize);

                return response()->json(['message' => 'Coupon applied!' . $discountpercent . '% discount has been applied.', 'totalPrize' => $totalPrize, 'coupon_id' => $coupon->id]);

            } else {
                return response()->json(['message' => 'Coupon has expired.']);

            }
        } else {
            return response()->json(['message' => 'Invalid coupon code.']);

        }
    }
    public function reviewStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'commemt' => 'required',
            'rating' => 'required',
        ]);

        $checkcount = Review::where('user_id', \Auth::user()->id)->where('product_id', $request->product_id)->where('is_approved', 'yes')->count();
        if ($checkcount == 0) {

            $data = new Review();
            $data->user_id = \Auth::user()->id;
            $data->product_id =$request->product_id;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->rating = $request->rating;
            $data->comment = $request->commemt;
            $data->created_by = \Auth::user()->id;
            $data->created_at = date('Y-m-d H:i:s');
            $data->updated_by = \Auth::user()->id;
            $data->updated_at = date('Y-m-d H:i:s');
            $data->save();
            echo "Review Submitted Successfully.";
        } else {
            echo "You have already submitted review for this package.";

        }

    }
}
