<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
use App\Models\SkuValues;
use App\Models\Variants;
use App\Models\VariantOptions;
use App\Models\Combination;
use App\Models\Cart;
use App\Models\CartItems;
use App\Models\User;
use App\Models\Faq;
use App\Models\Contact;
use App\Models\Banner;
use App\Models\Cms;
use Session;
use \Auth;

class FrontController extends Controller
{
    public function index()
	{
	   // foreach(Product::get() as $product)
	   // {
	   //     Sku::where('product_id',$product->id)->update(['is_default'=>'no']);
	   //     $update=Sku::where('product_id',$product->id)->orderBy('price','asc')->first();
	   //     $update->is_default='yes';
	   //     $update->save();
	   // }
		$categories=Category::where('status','yes')->orderBy('position','asc')->get(); 
		$featured=Category::where('status','yes')->where('is_featured','yes')->orderBy('position','asc')->take(2)->get(['id','category_name']);
		$products1=Sku::with('productItems')
		->whereHas('productItems',function($q)use($featured){
			if(count($featured) != 0)
			{
				$q->whereRaw("find_in_set('".$featured[0]['id']."',category_ids)");
			}
		})
		->whereHas('productItems',function($q){
			$q->where('is_published','yes');
		})
		->get();
		if(count($featured) >= 2)
		{
			$products2=Sku::with('productItems')
			->whereHas('productItems',function($q)use($featured){
				if(count($featured) != 0)
				{
					$q->whereRaw("find_in_set('".$featured[1]['id']."',category_ids)");
				}
			})
			->whereHas('productItems',function($q){
				$q->where('is_published','yes');
			})
			->get();
		}else{
			$products2=new \StdClass();
		} 

		$banner=Banner::where('type','banner')->first();

		return view('front.index',[
			'categories'=>$categories,
			'products1'=>$products1,
			'products2'=>$products2,
			'featured'=>$featured,
			'banner'=>$banner
		]);
	}
	public function contactUs(Request $request)
	{
		return view('front.contact-us');
	}
	public function shopCategory($slug)
	{
		$categories=Category::where('status','yes')->orderBy('position','asc')->get(); 
		$category=Category::where('slug',$slug)->first(); 
		return view('front.shop',[
			'categories'=>$categories,
			'slug'=>$slug,
			'category'=>$category
		]);
	}
	public function shop(Request $request )
	{
		 
		$categories=Category::where('status','yes')->orderBy('position','asc')->get(); 	
		return view('front.shop',[
			'categories'=>$categories,
			'request'=>$request
		]);
	}
	public function item($slug)
	{
		$product=Product::with(['badge','sku'=>function($q){
			$q->where('is_default','yes');
		}])
		->where('slug',$slug)
		->first();
		$options=VariantOptions::select('variant_options.variant_id','variants.attribute_name','variant_options.id as variant_option_id','variant_options.option_name')
		->leftJoin('variants','variants.id','variant_options.variant_id')
		->where('variant_options.product_id',$product->id)
		->orderBy('variant_options.variant_id','asc')
		->get();
		$option_group=[];
		foreach($options->pluck('attribute_name')->unique() as $item)
		{
			$new_array=$options->filter(function($value)use($item){
			   return $value->attribute_name == $item;
			});
			$option_group[$item]=$new_array;
		}
		 
		
		$tags;
		if($product->category_ids != '')
		{
			$ids=explode(',',$product->category_ids);
			$tags=Category::whereIn('id',$ids)->get();
		}
		//echo  "<pre>".json_encode($product->sku[0]);exit();
		$related_category_ids=explode(',',$product->category_ids);
		$related_products=Sku::with('productItems')
		->whereHas('productItems',function($q)use($related_category_ids){
			if(count($related_category_ids) != 0)
			{
				$firstValue=$related_category_ids[0];
				$q->whereRaw("find_in_set('".$firstValue."',category_ids)"); 
				foreach($related_category_ids as $value)
				{
					if($firstValue != $value)
					{
						$q->orWhereRaw("find_in_set('".$value."',category_ids)");
					}
				}
			}
			
		})
		->whereHas('productItems',function($q){
			$q->where('is_published','yes');
		})
		->where('is_default','yes')
		->where('product_id','!=',$product->id)
		->get();
		return view('front.item',[
			'product'=>$product,
			'option_group'=>$option_group,
			'tags'=>$tags,
			'related_products'=>$related_products
		]);
	}
	public function loadShopItems(Request $request)
	{
		
		$page=$request->has('page') && $request->page != null ? $request->page :1;
		$take=5;
		$skip=$page == 1 ? 0 : $take * ($page-1);

		$items=Sku::where('is_default','yes')->with('productItems')
		->whereHas('productItems',function($q){
			$q->where('is_published','yes');
		});
		if($request->has('search') && $request->search != '')
		{
			$items=$items->whereHas('productItems',function($q)use($request){
				$q->where('product_name','like','%'.$request->search.'%');
			});
		}
		if($request->has('price_range_from') && $request->price_range_from != '')
		{
			$items=$items->where(function($q)use($request){
				$q->where('special_price','>=',$request->price_range_from)
				->orWhere('price','>=',$request->price_range_from);
			});
		}
		if($request->has('price_range_to') && $request->price_range_to != '')
		{
			$items=$items->where(function($q)use($request){
				$q->where('special_price','<=',$request->price_range_to)
				->orWhere('price','<=',$request->price_range_to);
			});
		}
		if($request->has('filter_category') && count($request->filter_category) != 0)
		{
			$firstValue=$request->filter_category[0];
			// $items=$items->whereHas('productItems',function($q)use($firstValue){
			// 			$q->whereRaw("find_in_set('".$firstValue."',category_ids)");
			// }); 
			// foreach($request->filter_category as $value) {
			// 	if($firstValue != $value)
			// 	{
			// 		$items=$items->whereHas('productItems',function($q)use($value){
			// 			$q->whereRaw("find_in_set('".$value."',category_ids)");
			// 		});
			// 	}
			// }

			$items=$items->whereHas('productItems',function($q)use($request){
					$firstValue=$request->filter_category[0];
					$q->whereRaw("find_in_set('".$firstValue."',category_ids)"); 
					foreach($request->filter_category as $value)
					{
						if($firstValue != $value)
						{
				 			$q->orWhereRaw("find_in_set('".$value."',category_ids)");
						}
					}
			});
		}
		if($request->has('sort') && $request->sort != '')
		{
			if($request->sort == 'a2z' || $request->sort == 'z2a')
			{
				$sort_order=$request->sort == 'a2z' ? 'asc' : 'desc';
				// $items=$items->sortBy('order_product_name');
				
			}
			if($request->sort == 'l2h' || $request->sort == 'h2l')
			{
				$sort_order=$request->sort == 'l2h' ? 'asc' : 'desc';
				$items=$items->orderBy('special_price',$sort_order); 
			}
		}
		$items=$items->where('is_default','yes');
		$items=$items
		->skip($skip)
		->take($take)
		->get();
		//return response()->json($items); 
		$itemsCount=Sku::where('is_default','yes')->with('productItems')
		 
		->whereHas('productItems',function($q){
			$q->where('is_published','yes');
		});
		if($request->has('search') && $request->search != '')
		{
			$itemsCount=$itemsCount->whereHas('productItems',function($q)use($request){
				$q->where('product_name','like','%'.$request->search.'%');
			});
		}
		if($request->has('price_range_from') && $request->price_range_from != '')
		{
			$itemsCount=$itemsCount->where(function($q)use($request){
				$q->where('special_price','>=',$request->price_range_from)
				->orWhere('price','>=',$request->price_range_from);
			});
		}
		if($request->has('price_range_to') && $request->price_range_to != '')
		{
			$itemsCount=$itemsCount->where(function($q)use($request){
				$q->where('special_price','<=',$request->price_range_to)
				->orWhere('price','<=',$request->price_range_to);
			});
		}
		if($request->has('filter_category') && count($request->filter_category) != 0)
		{
			$itemsCount=$itemsCount->whereHas('productItems',function($q)use($request){
					$firstValue=$request->filter_category[0];
					$q->whereRaw("find_in_set('".$firstValue."',category_ids)"); 
					foreach($request->filter_category as $value)
					{
						if($firstValue != $value)
						{
				 			$q->orWhereRaw("find_in_set('".$value."',category_ids)");
						}
					}
			});
		}
		$itemsCount=$itemsCount->where('is_default','yes');
		$itemsCount=$itemsCount
		->skip($skip)
		->take($take)
		->count();
		 
		 	
		$items=view('front.ajax.shop.item',[
			'items'=>$items
		])->render();

		$footer=view('front.ajax.shop.item-footer',[
			'current_page'=>$page,
			'total_page'=>ceil($itemsCount/$take),
			'total_count'=>$itemsCount
		])->render();

		return response()->json([
			'footer'=>$footer,
			'items'=>$items,
			'current_page'=>$page,
		]);
	}
	public function filter(Request $request)
	{
		return $this->shop($request);
	}
	public function search(Request $request)
	{
		$request->merge(['search'=>$request->q]);
		return $this->shop($request);
	}
	public function stockCheck(Request $request)
	{
		$ids=collect($request->variant_option_id)->sortBy('ASC')->toArray();
		$id=implode('-',$ids);
		$data=Combination::select('sku.*','combination.id as combination_id','combination.var_option_id')
		->leftJoin('sku','sku.combination_id','combination.id')
		->where('combination.var_option_id',$id)
		->where('sku.product_id',$request->product_id)
		->first();
		return response()->json($data);

	}
	public function cart()
	{
		// if(\Auth::guest())
		// {
		// 	Session::flash('login_message',true);
		// 	return redirect('login');
		// }
		return view('front.cart');
	}
	public function checkout()
	{
	    if (\Auth::check())
        {
            if (\Auth::user()->user_type == 'admin')
            {
                Auth::logout();
                return redirect('login');
            }
        }
		if(\Auth::guest())
		{
			Session::put('checkout_login',false);
			Session::flash('login_message',true);
			return redirect('login');
		}
		$cart=Cart::where('customer_id',\Auth::user()->id)->first();
		if(!isset($cart))
		{
			return redirect('cart');
		}
		$cart_items=CartItems::where('cart_id',$cart->id)->where('customer_id',\Auth::user()->id)->get();
		$total=CartItems::where('cart_id',$cart->id)->where('customer_id',\Auth::user()->id)->sum('total');
		return view('front.checkout',[
			'cart_items'=>$cart_items,
			'total'=>$total,
			'sub_total'=>$total
		]);
	}
	public function fetchCart(Request $request)
	{
	   // echo 'jkj  '.Session::get('session_id');exit;
		$customer_id= Auth::guest() != true ? Auth::user()->id : Session::get('session_id');
		$cart=Cart::where('customer_id',$customer_id)->first();
		if(!$cart)
		{
			$customer_id=Session::get('session_id');
			$cart=Cart::where('customer_id',$customer_id)->first();
		}
		
		if($request->has('type') && $request->type == 'cart_page')
		{
			$cart_items=[];
			$cartItemsView=view('front.ajax.cart.item',compact('cart_items'))->render();
			if(!$cart)
			{
				return response()->json([
					'items'=>$cartItemsView,
					'count'=>0,
					'sub_total'=>0,
					'total'=>0
				]);
			}
			
			$cart_items=CartItems::where('cart_id',$cart->id)->where('customer_id',$customer_id)->get();
			$count=CartItems::where('cart_id',$cart->id)->where('customer_id',$customer_id)->count();
			$total=CartItems::where('cart_id',$cart->id)->where('customer_id',$customer_id)->sum('total');
			$total=\App\Models\Settings::getSettingsvalue('currency_symbol').''.number_format($total,2);
			$cartItemsView=view('front.ajax.cart.item',compact('cart_items'))->render();
			return response()->json([
				'items'=>$cartItemsView,
				'count'=>$count,
				'sub_total'=>$total,
				'total'=>$total
				
			]);
		}
		if(isset($cart))
		{
			$cart_items=CartItems::where('cart_id',$cart->id)->where('customer_id',$customer_id)->take(5)->get();
			$count=CartItems::where('cart_id',$cart->id)->where('customer_id',$customer_id)->count();
			$total=CartItems::where('cart_id',$cart->id)->sum('total');
			$cartItemsView=view('front.ajax.cart.header-item',compact('cart_items','total'))->render();
			return response()->json([
				'items'=>$cartItemsView,
				'count'=>$count
			]);
		}
		return response()->json([
				'items'=>'' ,
				'count'=>0
			]);
	}
	public function updateCart(Request $request)
	{
		$data=CartItems::find($request->id);
		$data->quantity=$request->quantity;
		$price=$data->special_price != '' ?  $data->special_price : $data->price ;
		$data->total=$request->quantity*$price;
		$data->save();
		if(!\Auth::guest())
		{
			$cart=Cart::find($data->cart_id);
			$cart->customer_id=\Auth::user()->id;
			$cart->save();
			$cart_items=CartItems::where('customer_id',$data->customer_id)->update(['customer_id'=>$cart->customer_id]);
		}
		echo 1;
	}
	public function deleteCartItem(Request $request)
	{
		$data=CartItems::findorFail($request->id)->delete();
		echo 1;
	}
	public function checkoutLogin($login)
	{
		if($login=='login')
		{
			Session::put('checkout_login',true);
		}else{
			Session::put('checkout_login',false);
		}
		return redirect('login');
	}
	public function aboutUs()
	{
		return view('front.about-us');
	}
	public function signUp()
	{
		return view('front.signup');
	}
	public function uploadProfileImage(Request $request)
	{
		if($request->has('file'))
		{
			$file=$request->file('file');
			$name=time().str_replace(' ' ,'',$file->getClientOriginalName());
			$path=public_path().'/uploads/images/profile';
			if($file->move($path,$name))
			{
				$user=User::find(\Auth::User()->id);
				$user->profile_image=$name;
				$user->save();
				echo 1;exit;
			}
				echo 0;exit;
		}
	}
	public function faq()
	{
		$data=Faq::get();
		return view('front.faq',[
			'data'=>$data
		]);
	}
	public function storePolicy()
	{
		return view('front.store-policy',[]);
	}
	public function storeContactUs(Request $request)
	{
		$request->validate([
			'name'=>'required',
			'email'=>'required|email',
			'phone'=>'required',
			'message'=>'required'
		]);
		$contact=new Contact();
		$contact->name=$request->name;
		$contact->email=$request->email;
		$contact->phone=$request->phone;
		$contact->message=$request->message;
		$contact->created_at=date('Y-m-d H:i:s');
		$contact->save();
		echo 1;exit;

	}
	public function page($page)
	{
		$page=Cms::where('route',$page)->where('is_published','yes')->first();
		if(!isset($page))
		{
			return redirect('404');
		}
		return view('front.page',['page'=>$page]);
	}
}
