@extends('layouts.frontlayout')
@section('styles')

@endsection
@section('content')
 

    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>{{$product->product_name}}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{url('/')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>

                                <li class="breadcrumb-item"><a href="{{url('shop')}}">Shop</a></li>
                                <li class="breadcrumb-item active">{{$product->product_name}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Left Sidebar Start -->
    <section class="product-section">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-9 col-xl-8 col-lg-7 wow fadeInUp">
                    <div class="row g-4">
                        <div class="col-xl-6 wow fadeInUp">
                            <div class="product-left-box">
                                <div class="row g-sm-4 g-2">
                                    <div class="col-xxl-10 col-lg-12 col-md-10 order-xxl-2 order-lg-1 order-md-2">
                                        <div class="product-main no-arrow">
											@if($product->image1 != '')
                                            <div>
                                                <div class="slider-image">
                                                    <img src="{{asset('public/images/product')}}/{{$product->image1}}" id="img-1"
                                                        data-zoom-image="{{asset('public/images/product')}}/{{$product->image1}}" class="
                                                        img-fluid image_zoom_cls-0 blur-up lazyload" alt="">
                                                </div>
                                            </div>
											@endif
                                            @if($product->image2 != '')
                                            <div>
                                                <div class="slider-image">
                                                    <img src="{{asset('public/images/product')}}/{{$product->image2}}" id="img-1"
                                                        data-zoom-image="{{asset('public/images/product')}}/{{$product->image2}}" class="
                                                        img-fluid image_zoom_cls-0 blur-up lazyload" alt="">
                                                </div>
                                            </div>
											@endif 
                                            @if($product->image3 != '')
                                            <div>
                                                <div class="slider-image">
                                                    <img src="{{asset('public/images/product')}}/{{$product->image3}}" id="img-1"
                                                        data-zoom-image="{{asset('public/images/product')}}/{{$product->image3}}" class="
                                                        img-fluid image_zoom_cls-0 blur-up lazyload" alt="">
                                                </div>
                                            </div>
											@endif 
											@if($product->image4 != '')
                                            <div>
                                                <div class="slider-image">
                                                    <img src="{{asset('public/images/product')}}/{{$product->image4}}" id="img-1"
                                                        data-zoom-image="{{asset('public/images/product')}}/{{$product->image4}}" class="
                                                        img-fluid image_zoom_cls-0 blur-up lazyload" alt="">
                                                </div>
                                            </div>
											@endif
                                             
                                        </div>
                                    </div>

                                    <div class="col-xxl-2 col-lg-12 col-md-2 order-xxl-1 order-lg-2 order-md-1">
                                        <div class="left-slider-image left-slider no-arrow slick-top">
											@if($product->image1 != '')
                                            <div>
                                                <div class="sidebar-image">
                                                    <img src="{{asset('public/images/product')}}/{{$product->image1}}"
                                                        class="img-fluid blur-up lazyload" alt="">
                                                </div>
                                            </div>
											@endif
											@if($product->image2 != '')
                                            <div>
                                                <div class="sidebar-image">
                                                    <img src="{{asset('public/images/product')}}/{{$product->image2}}"
                                                        class="img-fluid blur-up lazyload" alt="">
                                                </div>
                                            </div>
											@endif
											@if($product->image3 != '')
                                            <div>
                                                <div class="sidebar-image">
                                                    <img src="{{asset('public/images/product')}}/{{$product->image3}}"
                                                        class="img-fluid blur-up lazyload" alt="">
                                                </div>
                                            </div>
											@endif
											@if($product->image4 != '')
                                            <div>
                                                <div class="sidebar-image">
                                                    <img src="{{asset('public/images/product')}}/{{$product->image4}}"
                                                        class="img-fluid blur-up lazyload" alt="">
                                                </div>
                                            </div>
											@endif
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 wow fadeInUp">
                            <div class="right-box-contain">
                                @if(isset($product->badge) && isset($product->badge->badge_name))
									<h6 class="offer-top">{{$product->badge->badge_name}}</h6>
								@endif
                                <h2 class="name">{{$product->product_name}}</h2>
                                <div class="price-rating">
                                    <h3 class="theme-color price">
											{{\App\Models\Settings::getSettingsvalue('currency_symbol')}}
											{{isset($product->sku) && count($product->sku) != 0 ? $product->sku[0]->special_price : '0'}} 
											@if(isset($product->sku) && $product->sku != null &&  count($product->sku) != 0 && $product->sku[0]->special_price != '')
												<del class="text-content">
												{{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$product->sku[0]->price}}
												</del> 
											@else
												{{isset($product->sku) && count($product->sku) != 0 && $product->sku != null ? $product->sku[0]->price : '0'}}	
											@endif
											@if(isset($product->sku[0]) && $product->sku[0]->special_price != '')
												<span class="offer theme-color">
													@php 
														$perc=(($product->sku[0]->price - $product->sku[0]->special_price)/$product->sku[0]->price)*100;
													@endphp
													@if($product->sku[0]->special_price != '' && $product->sku[0]->price != '')
														({{is_float ($perc) ?  number_format($perc,2) : number_format($perc,0)}}% off)
													@endif
												</span>
											@endif
									</h3>
                                    <div class="product-rating custom-rate">
                                        {{-- <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>  --}}
                                        {{--  <span class="review">23 Customer Review</span>  --}}
                                    </div>
                                </div>

                                <div class="procuct-contain">
                                    <p>
										{{$product->short_description}}
                                    </p>
                                </div>
								@foreach($option_group as $key=>$item)
                                <div class="product-packege">
                                    <div class="product-title">
                                        <h4>{{ucfirst($key)}}</h4>
                                    </div>
                                    <ul class="select-packege">
										@foreach($item as $option)
											<li>
												<a href="javascript:void(0)" 
												   class="{{$loop->index == 0 ? 'active' : '' }}   option_{{$key}} option-btn" data-option="option_{{$key}}"
													data-variant-id="{{$option->variant_id}}"
													data-variant-option-id="{{$option->variant_option_id}}"
													>{{ucfirst($option->option_name)}}</a>
											</li>  
										@endforeach
                                    </ul>
                                </div>
								@endforeach
                                


                                <div class="note-box product-packege cartBtnArea">
                                    <div class="cart_qty qty-box product-qty">
                                        <div class="input-group">
                                            <button type="button" class="qty-right-plus" data-type="plus" data-field="">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                            <input class="form-control input-number qty-input" type="text"
                                                name="quantity" value="1">
                                            <button type="button" class="qty-left-minus" data-type="minus"
                                                data-field="">
                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <button onclick="location.href = '#';"
                                        class="btn btn-md bg-dark cart-button text-white w-100">Add To Cart</button>
                                </div>
								<div class="outofstock" style="display:none">
									<b style="color: #fb3c2d;font-size: 2em;">Out of stock</b>
									<p style=" color: #5a5a5a;">This option currently not available ,Choose another option</p>
								</div>
                                

                                <div class="pickup-box" style="border:none;">
                                    <div class="product-title">
                                        <h4>Store Information</h4>
                                    </div>
 

                                    <div class="product-info">
                                        <ul class="product-info-list product-info-list-2">
                                            <li>SKU : <a href="javascript:void(0)" id="sku-info">{{isset($product->sku)  && count($product->sku) != 0  ? $product->sku[0]->sku : 'N/A'}}</a></li>
                                            <li>Stock : <a href="javascript:void(0)" id="stock-info">
													{{isset($product->sku) && count($product->sku) != 0  && $product->sku[0]->quantity != 0 ?
													  $product->sku[0]->quantity.'   Items Left' :
													 'Out Of Stock'}} 
													</a>
											</li>
                                            @if(count($tags) != 0)
											<li>Tags : 
												@foreach ($tags as $item)
													<a href="{{url('shop-category/'.$item->slug)}}">{{$item->category_name}} 
														@if(count($tags) != $loop->index+1 || count($tags) != 1)
															,
														@endif
													</a>
												@endforeach
											</li>
											@endif
                                        </ul>
                                    </div>
                                </div>

                                {{--  <div class="paymnet-option">
                                    <div class="product-title">
                                        <h4>Guaranteed Safe Checkout</h4>
                                    </div>
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="https://themes.pixelstrap.com/fastkart/assets/images/product/payment/1.svg"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="https://themes.pixelstrap.com/fastkart/assets/images/product/payment/2.svg"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="https://themes.pixelstrap.com/fastkart/assets/images/product/payment/3.svg"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="https://themes.pixelstrap.com/fastkart/assets/images/product/payment/4.svg"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="https://themes.pixelstrap.com/fastkart/assets/images/product/payment/5.svg"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                    </ul>
                                </div>  --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-lg-5 d-none d-lg-block wow fadeInUp">
                    <div class="right-sidebar-box">
                        

                        <div class="pt-25">
                            <div class="hot-line-number">
                                <h5>Hotline Order:</h5>
                                <h3>{{\App\Models\Settings::getSettingsvalue('support_no')}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Left Sidebar End -->

    <!-- Nav Tab Section Start -->
    <section>
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="product-section-box m-0">
                        <ul class="nav nav-tabs custom-nav" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                    data-bs-target="#description" type="button" role="tab" aria-controls="description"
                                    aria-selected="true">Description</button>
                            </li>
 

                            {{--  <li class="nav-item" role="presentation">
                                <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review"
                                    type="button" role="tab" aria-controls="review"
                                    aria-selected="false">Review</button>
                            </li>  --}}
                        </ul>

                        <div class="tab-content custom-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel"
                                aria-labelledby="description-tab">
                                <div class="product-description">
                                     {!! $product->description !!}
                                </div>
                            </div>
 
 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Nav Tab Section End -->
    <!-- Releted Product Section Start -->
    <section class="product-list-section section-b-space">
        <div class="container-fluid-lg">
			@if(count($related_products) != 0)
            <div class="title">
                <h2>Related Products</h2>
                <span class="title-leaf">
                    <svg class="icon-width">
                        <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
                    </svg>
                </span>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="slider-6_1 product-wrapper">
						@foreach ($related_products as $item)
                         <div>
                            <div class="product-box-4 wow fadeInUp">
                                <div class="product-image product-image-2">
                                    <a href="{{url('shop/item')}}/{{$item->productItems->slug}}">
                                        <img src="{{asset('public/images/product')}}/{{$item->productItems->image1}}"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>

                                    {{--  <ul class="option">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i class="iconly-Show icli"></i>
                                            </a>
                                        </li>
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="javascript:void(0)" class="notifi-wishlist">
                                                <i class="iconly-Heart icli"></i>
                                            </a>
                                        </li>
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="#>
                                                <i class="iconly-Swap icli"></i>
                                            </a>
                                        </li>
                                    </ul>  --}}
                                </div>

                                <div class="product-detail">
                                    {{--  <ul class="rating">
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star"></i>
                                        </li>
                                    </ul>  --}}
                                    <a href="{{url('shop/item')}}/{{$item->productItems->slug}}">
                                        <h5 class="name text-title">{{$item->productItems->product_name}}</h5>
                                    </a>
                                    <h5 class="price theme-color">{{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->special_price}}<del>{{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->price}}</del></h5>

                                    <div class="addtocart_btn">
                                        <button class="add-button addcart-button btn buy-button text-light addCartBtn">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                        <div class="qty-box cart_qty">
                                            <div class="input-group">
                                                <button type="button" class="btn qty-left-minus qtyChangeBtn" data-type="minus"
                                                    data-field="">
                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                </button>
                                                <input class="form-control input-number qty-input" type="text"
                                                    name="quantity" value="1" data-product-id="{{$item->productItems->id}}" data-sku-id="{{$item->id}}">
                                                <button type="button" class="btn qty-right-plus qtyChangeBtn" data-type="plus"
                                                    data-field="">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         </div>
						@endforeach

                    </div>
                </div>
            </div>
			@else
			<div class="mt-5 mb-5"></div>
   			@endif
        </div>
    </section>
@endsection
@section('scripts')
<script>
var sku_id="{{isset($product->sku) && $product->sku != null && isset($product->sku->id) ? $product->sku->id : '' }}";
$(".product-packege .select-packege li a").click(function () {
	let option=$(this).attr('data-option');
    $("li a."+option).removeClass("active");
    $(this).addClass("active");
	stockCheck();
});
$('.option-btn.active:eq(0)').click();
async function stockCheck(){
	var variant_option_id=[];
	var variant_id=[];
	var option={'variant_option_id':variant_option_id,'variant_id':variant_id,'product_id':"{{$product->id}}"};
	$(".product-packege .select-packege li a.active").each(function(){
		//let item={
		//'variant_id':$(this).attr('data-variant-id'),
		//'variant_option_id':$(this).attr('data-variant-option-id')
		//};
		variant_option_id.push($(this).attr('data-variant-option-id'));
		variant_id.push($(this).attr('data-variant-id'));
	});
	$.ajax({
		url:"{{url('stockCheck')}}",
		type:"get",
		data:option,
		success: function(res){
			console.log(res);
			if(  res.quantity != 0){
				$('.outofstock').hide();
				$('.cartBtnArea').show();
				$('#stock-info').html(res.quantity);
				sku_id=res.id;
				let symbol="{{\App\Models\Settings::getSettingsvalue('currency_symbol')}}";
				let perc=res.price != '' && res.special_price != '' ? ((res.price - res.special_price)/res.price)*100 : '';
				perc=isNumber(perc) ? "("+parseFloat(perc).toFixed(2) +"%Off)" : '';
				let htmlTem=`${symbol} ${res.special_price}<del class="text-content">
												${symbol} ${res.price}
												</del> 
                                                <span class="offer theme-color">
												   
												</span>`;
				$('.price-rating h3').html(htmlTem);
			}else{
				$('#stock-info').html("<span style='color: red'>Out of Stock</span>");
				$('.cartBtnArea').hide();
				$('.outofstock').show();
			}
			let sku=res.sku != '' ? res.sku : 'N/A';
			$('#sku-info').val(sku);
			sku_id=res.id;
		}
	});
}
$('.qty-right-plus').on('click',function(){
	qty('plus');	
});
$('.qty-left-minus').on('click',function(){
	qty('minus');
});

function qty(type){
	let qty=1;
	let q=$('.cart_qty input[name=quantity]').val() == '' ? 1 : parseInt($('.cart_qty input[name=quantity]').val());
	if(type == 'plus')
	{
		qty=q+1;
	}else{
		qty=q-1;
	}
	if(qty < 1)
	{
		qty=1;
	}
	$('.cart_qty input[name=quantity]').val(qty);
}

$('.cartBtnArea .cart-button').on('click',function(){
	addToCart();
});
function addToCart(){
	if(sku_id == '')
	{
		$('.option-btn.active:eq(0)').click();
	}
	let fd={
		'product_id':"{{$product->id}}",
		'quantity':$('.cart_qty input[name=quantity]').val(),
		'sku_id':sku_id,
		'_token':"{{csrf_token()}}"
	};
	$.ajax({
		url:"{{url('addToCart')}}",
		type:"post",
		data:fd,
		success:function(res){
			if(res == '1'){
				Toastify({
					text: "Item Added to Cart",
					duration:5000,
					style: {
						background: "linear-gradient(to right, #00b09b, #96c93d)",
					},
				}).showToast();
				fetchCart();
			}
		}
	});
}
function isNumber(val){
    return typeof val==='number';
}
</script>
@endsection