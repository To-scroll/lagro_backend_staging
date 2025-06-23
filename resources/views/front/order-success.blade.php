@extends('layouts.frontlayout')
@section('styles')

@endsection
@section('content')
<section class="breadscrumb-section pt-0">
	<div class="container-fluid-lg">
		<div class="row">
			<div class="col-12">
				<div class="breadscrumb-contain breadscrumb-order">
					<div class="order-box">
						<div class="order-image">
							<img src="{{asset('assets/front/images/inner-page/order-success.png')}}" class="blur-up lazyload"
								alt="">
						</div>

						<div class="order-contain">
							<h3 class="theme-color">Order Success</h3>
							<h5 class="text-content">Payment Is Successfully And Your Order Is On The Way</h5>
							<h6>Payment ID: {{$order->reference_no}}</h6>
							<h6>Order No: {{$order->order_no}}</h6>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="cart-section section-b-space">
	<div class="container-fluid-lg">
		<div class="row g-sm-4 g-3">
			<div class="col-xxl-9 col-lg-8">
				<div class="cart-table order-table">
					<div class="table-responsive">
						<table class="table mb-0">
							<tbody>
								@foreach($orderItems as $item)
								<tr>
									<td class="product-detail">
										<div class="product border-0">
											<a href="#" class="product-image">
												<img src="{{asset('public/images/product')}}/{{$item->thumbnail}}"
													class="img-fluid blur-up lazyload" alt="">
											</a>
											<div class="product-detail">
												<ul>
													<li class="name">
														<a href="#">{{$item->product_name}}</a>
													</li>
													<li class="text-content">Quantity - {{$item->qty}}</li>

													@php
														$options=explode('-',$item->combination);
													@endphp
													@foreach ($options as $option)
														<span style="padding: 2px 5px;  background: #b5b5b5; border-radius: 3px;">{{$option}}</span>
													@endforeach
												</ul>
											</div>
										</div>
									</td>

									<td class="price">
										<h4 class="table-title text-content">Price</h4>
										<h6 class="theme-color">{{$item->special_price}}</h6>
									</td>

									<td class="quantity">
										<h4 class="table-title text-content">Qty</h4>
										<h4 class="text-title">{{$item->qty}}</h4>
									</td>

									<td class="subtotal">
										<h4 class="table-title text-content">Total</h4>
										<h5>{{number_format($item->total,2)}}</h5>
									</td>
								</tr>
								@endforeach
								<tr>
									<td class="subtotal" colspan="3">
										<h3>Grand Total</h3>
									</td>
									<td class="subtotal"  >
										<h5>{{number_format($order->total,2)}}</h5>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="col-xxl-3 col-lg-4">
				<div class="row g-4">
					

					<div class="col-lg-12 col-sm-6">
						<div class="summery-box">
							<div class="summery-header d-block">
								<h3>Shipping Address</h3>
							</div>

							<ul class="summery-contain pb-0 border-bottom-0">
								<li class="d-block">
									<h4>{{$order->address_name}}</h4>
									<h4 class="mt-2">{{$order->address}}<br> {{$order->landmark}} <br> Pincode : {{$order->pincode}}</h4>
								</li>

								{{--  <li class="pb-0">
									<h4>Expected Date Of Delivery:</h4>
									<h4 class="price theme-color">
										<a href="order-tracking.html" class="text-danger">Track Order</a>
									</h4>
								</li>  --}}
							</ul>

							
						</div>
					</div>

					 
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('scripts')

@endsection