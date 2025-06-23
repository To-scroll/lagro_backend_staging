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
					<h2>Cart</h2>
					<nav>
						<ol class="breadcrumb mb-0">
							<li class="breadcrumb-item">
								<a href="index.html">
									<i class="fa-solid fa-house"></i>
								</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">Cart</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Breadcrumb Section End -->

<!-- Cart Section Start -->
<section class="cart-section section-b-space">
	<div class="container-fluid-lg">
		<div class="row g-sm-5 g-3">
			<div class="col-xxl-9">
				<div class="cart-table">
					<div class="table-responsive-xl">
						<table class="table">
							<tbody id="cart-items">
								 
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="col-xxl-3">
				<div class="summery-box p-sticky">
					<div class="summery-header">
						<h3>Cart Total</h3>
					</div>

					<div class="summery-contain">
						{{--  <div class="coupon-cart">
							<h6 class="text-content mb-2">Coupon Apply</h6>
							<div class="mb-3 coupon-box input-group">
								<input type="email" class="form-control" id="exampleFormControlInput1"
									placeholder="Enter Coupon Code Here...">
								<button class="btn-apply">Apply</button>
							</div>
						</div>  --}}
						<ul>
							<li>
								<h4>Subtotal</h4>
								<h4 class="price subtotal-price">0</h4>
							</li>

							{{--  <li>
								<h4>Coupon Discount</h4>
								<h4 class="price">(-) 0.00</h4>
							</li>

							<li class="align-items-start">
								<h4>Shipping</h4>
								<h4 class="price text-end">$6.90</h4>
							</li>  --}}
						</ul>
					</div>

					<ul class="summery-total">
						<li class="list-total border-top-0">
							<h4>Total  </h4>
							<h4 class="price theme-color total-price">0</h4>
						</li>
					</ul>

					<div class="button-group cart-button">
						<ul>
							<li>
								@if(!\Auth::guest())
								<a  href ="{{url('checkout')}}"
									class="btn btn-animation proceed-btn fw-bold checkoutBtn" data-href="{{url('checkout')}}">Process To Checkout</a>
								@else
								<a  href ="{{url('checkout/login')}}"
									class="btn btn-animation proceed-btn fw-bold checkoutBtn" data-href="{{url('checkout/login')}}">Login & Checkout</a>	
								@endif
							</li>

							<li>
								<a href = "{{url('shop')}}"
									class="btn btn-light shopping-button text-dark">
									<i class="fa-solid fa-arrow-left-long"></i>Return To Shopping</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('scripts')
<script>
loadCart();
function loadCart()
{
	
	$.ajax({
		url:"{{url('fetchCart')}}",
		type:"get",
		data:{'type':'cart_page'},
		success:function(res){
			console.log(res.items);
			 $('#cart-items').html(res.items);
			 $('.subtotal-price').html(res.sub_total);
			 $('.total-price').html(res.total);
			 if(res.count == 0)
			 {
				$('.checkoutBtn').attr('href','#');
			 }else{
				$('.checkoutBtn').each(function(){
					let h=$(this).attr('data-href');
					$(this).attr('href',h);
				});
			 }
		}
	});icon1
}

$(document).on('click','.qty-right-plus',function(){
	let qty=parseInt($(this).parent().find('.qty-input').val());
	qty=qty+1;
	let cart_item_id=$(this).val();
	qtyUpadte(qty,cart_item_id);
	$(this).parent().find('.qty-input').val(qty);	
});
$(document).on('click','.qty-left-minus',function(){
	let qty=parseInt($(this).parent().find('.qty-input').val());
	qty=qty-1;
	let cart_item_id=$(this).val();
	if(qty == 0){
		qty=1;
	}
	qtyUpadte(qty,cart_item_id);
	$(this).parent().find('.qty-input').val(qty);
});

function qtyUpadte(qty,cart_item_id){
	 $.ajax({
		url:"{{url('updateCart')}}",
		type:"post",
		data:{'_token':"{{csrf_token()}}",'id':cart_item_id,'quantity':qty},
		success:function(res){
			 loadCart();
			 Toastify({
					text: " Cart Updated",
					duration:5000,
					style: {
						background: "linear-gradient(to right, #00b09b, #96c93d)",
					},
				}).showToast();
				fetchCart();
		}
	});
}

$(document).on('click','.removeCartItemBtn',function(){
	let id=$(this).attr('data-value');
	$.ajax({
		url:"{{url('deleteCartItem')}}",
		type:"post",
		data:{'_token':"{{csrf_token()}}",'id':id},
		success:function(res){
				
			 loadCart();
			 Toastify({
					text: "Removed",
					duration:3000,
					style: {
						background: "linear-gradient(to right,  #e91e63, #ff5722)",
					},
				}).showToast();
				fetchCart();
		}
	});
});
 
</script>
@endsection