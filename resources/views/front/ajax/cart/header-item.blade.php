@if(count($cart_items) != 0) 
<ul class="cart-list" style="flex-direction: column;">
	@foreach($cart_items as $item)
		<li class="product-box-contain">
			<div class="drop-cart">
				<a href="{{url('shop/item')}}/{{$item->productItems->slug}}" class="drop-image">
					<img src="{{asset('public/images/product')}}/{{$item->productItems->image1}}"
						class="blur-up lazyload" alt="" style="width:30px !important;">
				</a>

				<div class="drop-contain">
					<a href="{{url('shop/item')}}/{{$item->productItems->slug}}">
							<h5>{{ substr($item->productItems->product_name,0,26) }} @if(strlen($item->productItems->product_name) > 26 ) ...@endif</h5>
					</a> 
					<h6><span>{{$item->quantity}} x</span> {{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->special_price}}</h6>
					<button class="close-button close_button removeHeaderCartItemBtn" value="{{$item->id}}">
						<i class="fa-solid fa-xmark"></i>
					</button>
				</div>
			</div>
		</li> 	 
	@endforeach
</ul>

<div class="price-box">
	<h5>Total :</h5>
	<h4 class="theme-color fw-bold header-cart-list-total">{{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$total}} </h4>
</div>

<div class="button-group">
	<a href="{{url('cart')}}" class="btn btn-sm cart-button">View Cart</a>
	@if(!\Auth::guest())
	<a href="{{url('checkout')}}" class="btn btn-sm cart-button theme-bg-color
		text-white">Checkout</a>
	@else
	<a href="{{url('checkout/login')}}" class="btn btn-sm cart-button theme-bg-color
		text-white">Login & Checkout</a>
	@endif
</div>
@endif