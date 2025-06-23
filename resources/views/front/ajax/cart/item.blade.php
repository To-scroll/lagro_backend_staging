@foreach ($cart_items as $item)
<tr class="product-box-contain">
<td class="product-detail">
<div class="product border-0">
	<a href="product-left.html" class="product-image">
		<img src="{{asset('public/images/product')}}/{{$item->productItems->image1}}"
			class="img-fluid blur-up lazyload" alt="">
	</a>
	<div class="product-detail">
		<ul>
			<li class="name">
				<a href="{{url('shop/item')}}/{{$item->productItems->slug}}">{{ $item->product_name }}</a>
			</li>
			<li class="name">
					@php
						$options=explode('-',$item->combination);
					@endphp
					@foreach ($options as $option)
						<span style="padding: 2px 5px;  background: #b5b5b5; border-radius: 3px;">{{$option}}</span>
					@endforeach
			</li>
			<li class="text-content"><span
					class="text-title">Quantity</span> - {{$item->quantity}}</li>

			<li>
				<h5 class="text-content d-inline-block">Price :</h5>
				<span>{{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->special_price}}</span>
				<span class="text-content">{{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->price}}</span>
			</li>
			@if($item->price - $item->special_price != 0)
			<li>
				<h5 class="saving theme-color">Saving : {{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->price - $item->special_price}}</h5>
			</li>
			@endif
			<li class="quantity-price-box">
				<div class="cart_qty">
					<div class="input-group">
						<button type="button" class="btn qty-left-minus"
							data-type="minus" data-field="">
							<i class="fa fa-minus ms-0"
								aria-hidden="true"></i>
						</button>
						<input class="form-control input-number qty-input"
							type="text" name="quantity" value="{{$item->quantity}}">
						<button type="button" class="btn qty-right-plus"
							data-type="plus" data-field="">
							<i class="fa fa-plus ms-0"
								aria-hidden="true"></i>
						</button>
					</div>
				</div>
			</li>

			<li>
				<h5>Total: {{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->total}}</h5>
			</li>
		</ul>
	</div>
</div>
</td>

<td class="price">
<h4 class="table-title text-content">Price</h4>
<h5>{{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->special_price}} <del class="text-content">{{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->price}}</del></h5>
	@if($item->special_price - $item->special_price != 0) 
	<h6 class="theme-color">You Save :  {{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->special_price - $item->special_price}} </h6>
	@endif
</td>

<td class="quantity">
<h4 class="table-title text-content">Qty</h4>
<div class="quantity-price">
	<div class="cart_qty">
		<div class="input-group">
			<button type="button" class="btn qty-left-minus"
				data-type="minus" data-field="" value="{{$item->id}}">
				<i class="fa fa-minus ms-0" aria-hidden="true"></i>
			</button>
			<input class="form-control input-number qty-input" type="text"
				name="quantity" value="{{$item->quantity}}">
			<button type="button" class="btn qty-right-plus"
				data-type="plus" data-field="" value="{{$item->id}}">
				<i class="fa fa-plus ms-0" aria-hidden="true"></i>
			</button>
		</div>
	</div>
</div>
</td>

<td class="subtotal">
<h4 class="table-title text-content">Total</h4>
<h5>{{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->total}}</h5>
</td>

<td class="save-remove">
<h4 class="table-title text-content">Action</h4>
<a class="remove close_button removeCartItemBtn" href="#" data-value="{{$item->id}}">Remove</a>
</td>
</tr>
@endforeach

@if(count($cart_items) == 0)
<tr>
	<td>
		<div class="text-center" style="padding:8em 0;">
			 <b style="font-size:x-large">Cart is empty !</b>  <br>
			 <div class="text-center pt-4">
				<center>
				<a  href="{{url('shop')}}" class="btn btn-light shopping-button text-dark" style="border: 1px solid #060606;background-color: #f9fafb;width: 300px;">
					<i class="fa-solid fa-arrow-left-long"></i>&nbsp;&nbsp;Return To Shopping
				</a>
				</center>
			 </div>
		</div>
		
	</td>
</tr>
@endif