@extends('layouts.frontlayout')
@section('styles')

@endsection
@section('content')
<section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>Shop</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{url('/')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Shop  </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
</section>
    <!-- Breadcrumb Section End -->

    <!-- Shop Section Start -->
<section class="section-b-space shop-section">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="show-button">
                        <div class="top-filter-menu-2">
                            <div class="sidebar-filter-menu" data-bs-toggle="collapse"
                                data-bs-target="#collapseExample">
                                <a href="javascript:void(0)"><i class="fa-solid fa-filter"></i> Filter Menu</a>
                            </div>

                            <div class="ms-auto d-flex align-items-center">
                                <div class="category-dropdown me-md-3">
                                    <h5 class="text-content">Sort By :</h5>
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
                                            data-bs-toggle="dropdown">
                                            <span>Default</span> <i class="fa-solid fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item sort-item" id="pop"
                                                    href="javascript:void(0)" data-sort-order="">Default</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item sort-item" id="low" href="javascript:void(0)" data-sort-order="l2h">Low - High
                                                    Price</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item sort-item" id="high" href="javascript:void(0)"  data-sort-order="h2l">High - Low
                                                    Price</a>
                                            </li> 
                                            {{--  <li>
                                                <a class="dropdown-item sort-item" id="aToz" href="javascript:void(0)"  data-sort-order="a2z">A - Z
                                                    Order</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item sort-item" id="zToa" href="javascript:void(0)"  data-sort-order="z2a">Z - A
                                                    Order</a>
                                            </li>   --}}
                                        </ul>
                                    </div>
                                </div>

                                <div class="grid-option grid-option-2">
                                    <ul>
                                        <li class="three-grid d-xxl-inline-block d-none">
                                            <a href="javascript:void(0)">
                                                <img src="https://themes.pixelstrap.com/fastkart/assets/svg/grid-3.svg" class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li class="grid-btn five-grid active">
                                            <a href="javascript:void(0)">
                                                <img src="https://themes.pixelstrap.com/fastkart/assets/svg/grid-4.svg"
                                                    class="blur-up lazyload d-lg-inline-block d-none" alt="">
                                                <img src="https://themes.pixelstrap.com/fastkart/assets/svg/grid.svg"
                                                    class="blur-up lazyload img-fluid d-lg-none d-inline-block" alt="">
                                            </a>
                                        </li>
                                        <li class="list-btn">
                                            <a href="javascript:void(0)">
                                                <img src="https://themes.pixelstrap.com/fastkart/assets/svg/list.svg" class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="top-filter-category" id="collapseExample">
                        <div class="row g-sm-4 g-3"> 
							<div class="col-xl-6 col-md-6">
                                <div class="category-title">
                                    <h3>Price</h3>
                                </div>
                                <div class="range-slider">
                                    <input type="text" class="js-range-slider" id="price-range" value="">
                                </div>
                            </div>

                             

                            <div class="col-xl-6 col-md-6">
                                <div class="category-title">
                                    <h3>Category</h3>
                                </div>
                                <ul class="category-list custom-padding custom-height">
									@foreach($categories as $item)
                                    <li>
                                        <div class="form-check ps-0 m-0 category-list-box">
                                            <input class="checkbox_animated filter_category" type="checkbox" id="flexCheckDefault5{{$loop->index}}" value="{{$item->id}}" {{{isset($category) && $category->id == $item->id? 'checked' : ''}}}>
                                            <label class="form-check-label" for="flexCheckDefault5{{$loop->index}}">
                                                <span class="name">{{$item->category_name}}</span>
                                            </label>
                                        </div>
                                    </li>
									@endforeach 
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row g-sm-4 g-3 row-cols-xxl-5 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">
                         
					 
                    </div>
					<div class="row nothingFound" style="display:none;">
						<div class="col-12" style="padding:4em;font-size:2em">
							<center>Nothing found ! </center>
						</div>
					</div>
					 <nav class="custome-pagination"></nav>
                    
                </div>
            </div>
        </div>
</section> 


@endsection
@section('scripts')
 <script src="{{asset('assets/front/js/quantity-2.js')}}"></script>
<script>
 var page=1;
 var filter_category=[]; 
 var price_range_from='';
 var price_range_to='';
 var search=$('#searchQuery').val();
 var sort=$('#dropdownMenuButton1').attr('data-sort-order');
 @if(isset($request) && $request->has('search') )
 
	search="{{$request->search}}";
	$('#searchQuery').val(search);
 @endif
 load(1);
 


async function load(page){
	$('.nothingFound').hide();
	price_range_from=$('#price-range').val().split(';')[0];
	price_range_to=$('#price-range').val().split(';')[1];
	sort=$('#dropdownMenuButton1').attr('data-sort-order');
	let fc=await filter_category_init();
	let fd={'page':page,'filter_category':filter_category,'price_range_from':price_range_from,'price_range_to':price_range_to,'sort':sort,'search':search};
	$.ajax({
		url:"{{url('load-shop-items')}}",
		type:"get",
		data:fd,
		success: function(res){
			$('.product-list-section').html(res.items); 
			$('.custome-pagination').html(res.footer);
			if(res.items == '')
			{
				$('.nothingFound').show();
			}
		}
	});
}


$(document).on('click','.loadBtn',function(){
	page=$(this).attr('data-page');
	total_page=$(this).attr('data-total-page');
	if(page != 0 && page <= total_page)
	{
		load(page);
	}
});
$('.filter_category').on('change',function(){
	filter_category_init();
	page=1;
	load(page);
});
function filter_category_init(){
	filter_category=[];
	$('.filter_category').each(function(){
		if($(this).is(':checked'))
		{
			filter_category.push($(this).val());
			filter_category=[...new Set(filter_category)]; 
		}
	});
} 

$('.sort-item').on('click',function(){
	$('#dropdownMenuButton1').attr('data-sort-order',$(this).attr('data-sort-order'));
	 page=1;
	 load(page);
}); 
var price_slider=0;
$('.js-range-slider').on('change',function(){
	price_slider=1;
}); 


setInterval(function(){
	if ($('.irs:hover').length == 0 && price_slider== 1) {
		page=1;
		price_slider=0;
		load(page);
	}
},1500);


 $(document).on('click',".addcart-button",function () {
     $(this).next().addClass("open");
     //$(".add-to-cart-box .qty-input").val('0');
 });

 $(document).on('click','.add-to-cart-box',function () {
     var $qty = $(this).siblings(".qty-input");
     var currentVal = parseInt($qty.val());
     if (!isNaN(currentVal)) {
         $qty.val(currentVal + 1);
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
					text: "Item Added to Cart",
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