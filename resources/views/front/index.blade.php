
@extends('layouts.frontlayout')
@section('styles')

@endsection
@section('content')
    <!-- Home Section Start -->
    <section class="home-section-2 home-section-bg pt-0 overflow-hidden">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="slider-animate">
                        <div>
                            <div class="home-contain rounded-0 p-0">
                                <img src="{{asset('public/images/banner')}}/{{$banner->image}}"
                                    class="img-fluid bg-img blur-up lazyload" alt="">
                                <div class="home-detail home-big-space p-center-left home-overlay position-relative">
                                    <div class="container-fluid-lg">
                                        <div>
                                            <h6 class="ls-expanded theme-color text-uppercase"> 
                                            </h6>
                                            <h1 class="heding-2"></h1>
                                             
                                            <h5 class="text-content">
                                            </h5>
                                            {{--
                                            <button
                                                class="btn theme-bg-color btn-md text-white fw-bold mt-md-4 mt-2 mend-auto"
                                                onclick="location.href =' {{url("shop")}}';">Shop Now <i
                                                    class="fa-solid fa-arrow-right icon"></i></button> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Home Section End -->

    <!-- Banner Section Start -->
    <section class="banner-section overflow-hidden">
        <div class="container-fluid-lg">
            <div class="row g-sm-4 g-3 ratio_65">
                <div class="col-xxl-3 col-sm-6">
                    <div class="banner-contain-3 hover-effect">
                        <a href="javascript:void(0)">
                            <img src="{{asset('public/images/small-banner/1.jpeg')}}" class="bg-img blur-up lazyload" alt="">
                        </a>
                        <!--<div class="banner-detail p-center-left w-60 banner-p-sm mend-auto">-->
                        <!--    <div>-->
                        <!--        <h5 class="fw-light mb-2">50% Discount</h5>-->
                        <!--        <h4 class="fw-bold mb-0">Summer Ice Cream</h4>-->
                        <!--        <button onclick="location.href = '#';"-->
                        <!--            class="btn shop-now-button mt-3 ps-0 mend-auto theme-color fw-bold">Shop Now <i-->
                        <!--                class="fa-solid fa-chevron-right"></i></button>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                </div>

                <div class="col-xxl-3 col-sm-6">
                    <div class="banner-contain-3 hover-effect">
                        <a href="javascript:void(0)">
                            <img src="{{asset('public/images/small-banner/2.jpeg')}}" class="img-fluid bg-img" alt="">
                        </a>
                        <!--<div class="banner-detail p-center-left w-60 banner-p-sm mend-auto">-->
                        <!--    <div>-->
                        <!--        <h5 class="fw-light mb-2">Today Special</h5>-->
                        <!--        <h4 class="fw-bold mb-0">Fruits Juice Series</h4>-->
                        <!--        <button onclick="location.href = '#';"-->
                        <!--            class="btn shop-now-button mt-3 ps-0 mend-auto theme-color fw-bold">Shop Now <i-->
                        <!--                class="fa-solid fa-chevron-right"></i></button>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                </div>

                <div class="col-xxl-3 col-sm-6">
                    <div class="banner-contain-3 hover-effect">
                        <a href="javascript:void(0)">
                            <img src="{{asset('public/images/small-banner/3.jpeg')}}" class="blur-up lazyload bg-img" alt="">
                        </a>
                        <!--<div class="banner-detail p-center-left w-60 banner-p-sm mend-auto">-->
                        <!--    <div>-->
                        <!--        <h5 class="fw-light mb-2">Combo Offer</h5>-->
                        <!--        <h4 class="fw-bold mb-0">Eat Healthy Be Healthy </h4>-->
                        <!--        <button onclick="location.href = '#';"-->
                        <!--            class="btn shop-now-button mt-3 ps-0 mend-auto theme-color fw-bold">Shop Now <i-->
                        <!--                class="fa-solid fa-chevron-right"></i></button>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                </div>

                <div class="col-xxl-3 col-sm-6">
                    <div class="banner-contain-3 hover-effect">
                        <a href="javascript:void(0)">
                            <img src="{{asset('public/images/small-banner/5.jpeg')}}" class="blur-up lazyload bg-img" alt="">
                        </a>
                        <!--<div class="banner-detail p-center-left w-60 banner-p-sm mend-auto">-->
                        <!--    <div>-->
                        <!--        <h5 class="fw-light mb-2">Amazing Deals</h5>-->
                        <!--        <h4 class="fw-bold mb-0">As Fresh As Fruit </h4>-->
                        <!--        <button onclick="location.href = '#';"-->
                        <!--            class="btn shop-now-button mt-3 ps-0 mend-auto theme-color fw-bold">Shop Now <i-->
                        <!--                class="fa-solid fa-chevron-right"></i></button>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->

    <!-- Category Section Start -->
    <section class="category-section-3 " style="{{count($categories) == 0 ? 'display:none;':'' }}">
        <div class="container-fluid-lg">
            <div class="title">
                <h2>Shop By Categories</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="category-slider-1 arrow-slider wow fadeInUp">
						@foreach($categories as $item)
                        <div>
                            <div class="category-box-list">
                                <a href="#" class="category-name">
                                    <h4>{{ucfirst($item->category_name)}}</h4>
                                    {{--  <h6>@if($item->product_count != 0) {{$item->product_count}} items @endif</h6>  --}}
                                </a>
                                <a href="{{url('shop-category/'.$item->slug)}}">
                                    <img src="{{ $item->icon == '' ? asset('public/images/icon/preview130.png')  : asset('public/images/category')}}/{{$item->icon}}"
                                        class="img-fluid blur-up lazyload" alt="">
                                    <button onclick="location.href = {{url('shop-category/'.$item->slug)}};"
                                        class="btn shop-button">Shop Now <i class="fas fa-angle-right"></i></button>
                                </a>
                            </div>
                        </div>
						@endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Category Section End -->

    <!-- Product Fruit & Vegetables Section Start -->
	@if(count($featured) >= 1)
    <section class="product-section-3">
        <div class="container-fluid-lg">
            <div class="title">
                <h2>{{$featured[0]['category_name']}}</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="slider-7_1 arrow-slider img-slider">
					 @foreach ($products1 as $item)
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
                                     
                                    <a href="{{url('shop/item')}}/{{$item->productItems->slug}}">
                                        <h5 class="name text-title">{{$item->productItems->product_name}}</h5>
                                    </a>
                                    <h5 class="price theme-color">{{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->special_price}} </h5>

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
                                                    name="quantity" value="0" data-product-id="{{$item->productItems->id}}" data-sku-id="{{$item->id}}">
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
        </div>
    </section>
	@endif
    <!-- Product Fruit & Vegetables Section End -->

    <!-- Banner Section Start -->
    
    <!-- Banner Section End -->

    
 

    <!-- Product Breakfast & Dairy Section Start -->
    @if(count($featured) >= 2)
    <section class="product-section-3">
        <div class="container-fluid-lg">
            <div class="title">
                <h2>{{$featured[1]['category_name']}}</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="slider-7_1 arrow-slider img-slider">
					 @foreach ($products2 as $item)
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
                                    <h5 class="price theme-color">{{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->special_price}} </h5>

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
                                                    name="quantity" value="0" data-product-id="{{$item->productItems->id}}" data-sku-id="{{$item->id}}">
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
        </div>
    </section>
	@endif
    <!-- Product Breakfast & Dairy Section End -->

    
 

    <!-- Service Section Start -->
    <section class="service-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row g-3 row-cols-xxl-5 row-cols-lg-3 row-cols-md-2">
                <div>
                    <div class="service-contain-2">
                        <svg class="icon-width">
                            <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/svg/service-icon-4.svg#shipping"></use>
                        </svg>
                        <div class="service-detail">
                            <h3>Free Shipping</h3>
                            <h6 class="text-content">Free Shipping world wide</h6>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="service-contain-2">
                        <svg class="icon-width">
                            <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/svg/service-icon-4.svg#service"></use>
                        </svg>
                        <div class="service-detail">
                            <h3>24 x 7 Service</h3>
                            <h6 class="text-content">Online Service For 24 x 7</h6>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="service-contain-2">
                        <svg class="icon-width">
                            <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/svg/service-icon-4.svg#pay"></use>
                        </svg>
                        <div class="service-detail">
                            <h3>Online Pay</h3>
                            <h6 class="text-content">Online Payment Avaible</h6>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="service-contain-2">
                        <svg class="icon-width">
                            <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/svg/service-icon-4.svg#offer"></use>
                        </svg>
                        <div class="service-detail">
                            <h3>Festival Offer</h3>
                            <h6 class="text-content">Super Sale Upto 50% off</h6>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="service-contain-2">
                        <svg class="icon-width">
                            <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/svg/service-icon-4.svg#return"></use>
                        </svg>
                        <div class="service-detail">
                            <h3>100% Original</h3>
                            <h6 class="text-content">100% Money Back</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Service Section End -->
	{{-- <section class="offer-section mb-3">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="offer-box hover-effect">
                        <h2><span>FREE GIFT ANY ORDER</span> 70% oFF</h2>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection
@section('scripts')
 {{--  <script src="{{asset('assets/front/js/quantity-2.js')}}"></script>  --}}
<script>
var max=200;
var arr=[];
adjHeight();
function adjHeight(){
	$('.category-box-list').each(function(){
		arr.push($(this).height());
	});
}
var interval=setInterval(function(){
	max =arr.reduce(function(a, b) {
    	return Math.max(a, b);
	}); 
	$('.category-box-list').height(max);
	if(200 != max){
		clearInterval(interval);
	}
	//console.log(max);
},1500);



 $(document).on('click',".addcart-button",function () {
     $(this).next().addClass("open");
     $(".add-to-cart-box .qty-input").val(0);
	   
 });

 $(document).on('click','.add-to-cart-box',function () {
     var $qty = $(this).siblings(".qty-input");
     var currentVal = parseInt($qty.val());
     if (!isNaN(currentVal)) {
         //$qty.val(currentVal + 1);
     }
	  
 });

 {{--  $(document).on('click','.qty-left-minus', function () {
     var $qty = $(this).siblings(".qty-input");
     var _val = $($qty).val();
     if (_val == '1') {
         var _removeCls = $(this).parents('.cart_qty');
         $(_removeCls).removeClass("open");
     }
     var currentVal = parseInt($qty.val());
     if (!isNaN(currentVal) && currentVal > 0) {
         $qty.val(currentVal - 1);
     }
 });

 $(document).on('click','.qty-right-plus',function () {
     if ($(this).prev().val() < 9) {
         $(this).prev().val(+$(this).prev().val() + 1);
     }
 });  --}}
{{--  
$(document).on('click','.qty-left-minus', function () {
     var $qty = $(this).siblings(".qty-input");
     var _val = $($qty).val();
     if (_val == '1') {
         var _removeCls = $(this).parents('.cart_qty');
         $(_removeCls).removeClass("open");
     }
     var currentVal = parseInt($qty.val());
     if (!isNaN(currentVal) && currentVal > 0) {
         $qty.val(currentVal - 1);
     }
 });  --}}

 $(document).on('click','.qty-right-plus',function () {
    let qty=parseInt($(this).parent().find('.qty-input').val());
	qty=qty+1;
	let product_id=$(this).parent().find('.qty-input').attr('data-product-id');
	let sku_id=$(this).parent().find('.qty-input').attr('data-sku-id');
	addToCart(qty,sku_id,product_id);
	$(this).parent().find('.qty-input').val(qty);
 });
 $(document).on('click','.qty-left-minus',function () {
    let qty=parseInt($(this).parent().find('.qty-input').val());
	qty=qty-1;
	if(qty == 0){
		qty=1;
	}
	let product_id=$(this).parent().find('.qty-input').attr('data-product-id');
	let sku_id=$(this).parent().find('.qty-input').attr('data-sku-id');
	addToCart(qty,sku_id,product_id);
	$(this).parent().find('.qty-input').val(qty);
 });
function addToCart(qty,sku_id,product_id){ 
	let fd={
		'product_id':product_id,
		'quantity':qty,
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
					text: "Cart Updated",
					duration:1000,
					style: {
						background: "linear-gradient(to right, #00b09b, #96c93d)",
					},
				}).showToast();
				fetchCart();
			}
		}
	});
}
</script>
@endsection