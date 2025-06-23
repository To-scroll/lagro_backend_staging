@extends('layouts.frontlayout')
@section('styles')
<style>
.checkout-section .custom-accordion .accordion-item .accordion-header .accordion-button::before {
    position: absolute;
    font-weight: 900; 
    top: 50%;
    transform: translateY(-50%);
    right: 30px;
    transition: transform 0.2s ease-in-out 0s, -webkit-transform 0.2s ease-in-out 0s;
	display:none!important;
}
</style>
@endsection
@section('content')
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>Checkout</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.html">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="checkout-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row g-sm-4 g-3">
                <div class="col-xxl-3 col-lg-4">
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills nav-justified custom-navtab" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <div class="nav-link active" id="shopping-cart" data-bs-toggle="tab"
                                data-bs-target="#s-cart" role="tab">
                                <div class="nav-item-box">
                                    <div>
                                        <span>STEP 1</span>
                                        <h4>Shopping Cart</h4>
                                    </div>
                                    <lord-icon target=".nav-item" src="https://cdn.lordicon.com/ggihhudh.json"
                                        trigger="loop-on-hover"
                                        colors="primary:#121331,secondary:#646e78,tertiary:#0baf9a" class="lord-icon">
                                    </lord-icon>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item" role="presentation">
                            <div class="nav-link" id="delivery-address" data-bs-toggle="tab" data-bs-target="#d-address"
                                role="tab">
                                <div class="nav-item-box">
                                    <div>
                                        <span>STEP 2</span>
                                        <h4>Delivery Address</h4>
                                    </div>
                                    <lord-icon target=".nav-item" src="https://cdn.lordicon.com/oaflahpk.json"
                                        trigger="loop-on-hover" colors="primary:#0baf9a" class="lord-icon">
                                    </lord-icon>
                                </div>
                            </div>
                        </li>

                         

                        <li class="nav-item" role="presentation">
                            <div class="nav-link" id="payment-option" data-bs-toggle="tab" data-bs-target="#p-options"
                                role="tab">
                                <div class="nav-item-box">
                                    <div>
                                        <span>STEP 3</span>
                                        <h4>Payment Options</h4>
                                    </div>
                                    <lord-icon target=".nav-item" src="https://cdn.lordicon.com/qmcsqnle.json"
                                        trigger="loop-on-hover" colors="primary:#0baf9a,secondary:#0baf9a"
                                        class="lord-icon">
                                    </lord-icon>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="col-xxl-9 col-lg-8">
                    <!-- Tab panes -->
                    <div class="tab-content" id="progressBar">
                        <div class="tab-pane active" id="s-cart" role="tabpanel" aria-labelledby="shopping-cart">
                            <h2 class="tab-title">Shopping Cart</h2>
                            <div class="cart-table p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
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
																		class="text-title">Quantity</span> - {{$item->quantity}}
																</li>
 
                                                                <li class="text-content"> 
																	<h5 class="text-content d-inline-block">Price :</h5>
																	<span>{{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->special_price}}</span>
																	<span class="text-content">{{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->price}}</span>
																</li>

                                                                @if($item->price - $item->special_price != 0)
																<li>
																	<h5 class="saving theme-color">Saving : {{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->price - $item->special_price}}</h5>
																</li>
																@endif
 
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="price">
                                                    <h4 class="table-title text-content">Price</h4>
                                                    <h5>{{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->special_price}} <del class="text-content">{{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->price}}</del></h5>
                                                    @if($item->price - $item->special_price != 0)
														<h6 class="theme-color">You Save : {{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->price - $item->special_price}}</h6>
													@endif
												</td>
                                                
                                                <td class="subtotal">
                                                    <h4 class="table-title text-content">Total</h4>
                                                    <h5>{{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->total}}</h5>
                                                </td>

                                            </tr>
											@endforeach
 
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="button-group">
                                <ul class="button-group-list">
                                    <li>
                                        <a href="{{url('shop')}}"
                                            class="btn btn-light shopping-button text-dark"><i
                                                class="fa-solid fa-arrow-left-long ms-0"></i>Continue Shopping</a>
                                    </li>

                                    <li>
                                        <button class="btn btn-animation proceed-btn" type="button" value="delivery-address">Continue Delivery Address</button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-pane" id="d-address" role="tabpanel" aria-labelledby="delivery-address">
                            <div class="d-flex align-items-center mb-3">
                                <h2 class="tab-title mb-0">Delivery Address</h2>
                                <button class="btn btn-animation btn-sm fw-bold ms-auto" type="button"
                                    id="addNewAddressBtn">
                                    <i class="fa-solid fa-plus d-block d-sm-none m-0"></i>
                                    <span class="d-none d-sm-block">+ Add New</span>
                                </button>
                            </div>

                            <div class="row g-4"  id="address-container">
                                
                            </div>

                            <div class="button-group">
                                <ul class="button-group-list">
                                    <li>
                                        <button class="btn btn-light shopping-button backward-btn text-dark proceed-btn" type="button" value="shopping-cart">
                                            <i class="fa-solid fa-arrow-left-long ms-0"></i>Return To Shopping
                                            Cart</button>
                                    </li>

                                    <li>
                                        <button class="btn btn-animation proceed-btn" type="button" value="payment-option">Continue Payment Option</button>
                                    </li>
                                </ul>

                            </div>
                        </div>

                         

                        <div class="tab-pane" id="p-options" role="tabpanel" aria-labelledby="payment-option">
                            <h2 class="tab-title">Payment Option</h2>
                            <div class="row g-sm-4 g-2">
                                <div class="col-xxl-4 col-lg-12 col-md-5 order-xxl-2 order-lg-1 order-md-2">
                                    <div class="summery-box">
                                        <div class="summery-header bg-white">
                                            <h3>Order Summery</h3>
                                            <a href="{{url('cart')}}">Edit Cart</a>
                                        </div>

                                        <ul class="summery-contain bg-white custom-height">
                                            @foreach ($cart_items as $item)
												<li>
                                               	 	<h4>{{$item->product_name}} <span>X {{$item->quantity}}</span></h4>
                                                	<h4 class="price">{{$item->total}}</h4>
                                            	</li>
											@endforeach
                                            
                                        </ul>

                                        <ul class="summery-total bg-white">
                                            <li>
                                                <h4>Subtotal</h4>
                                                <h4 class="price">{{number_format($sub_total,2)}} </h4>
                                            </li>

                                            

                                            <li class="list-total">
                                                <h4>Total </h4>
                                                <h4 class="price"> {{number_format($total,2)}}</h4>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-xxl-8 col-lg-12 col-md-7 order-xxl-1 order-lg-2 order-md-1">
                                    <div class="accordion accordion-flush custom-accordion" id="accordionFlushExample">
                                        <div class="accordion-item">
                                            <div class="accordion-header" id="flush-headingOne">
                                                <div class="accordion-button collapsed" >
                                                    <div class="custom-form-check form-check mb-0">
                                                        <label class="form-check-label" for="credit">
															<input
                                                                class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault11" id="credit" checked>Online Payment</label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div> 
                                    </div>
                                </div>
                            </div>

                            <div class="button-group">
                                <ul class="button-group-list">
                                    <li>
                                        <button class="btn btn-light shopping-button backward-btn text-dark proceed-btn" type="button" value="delivery-address">
                                            <i class="fa-solid fa-arrow-left-long ms-0"></i>Return To Delivery
                                            Option</button>
                                    </li>

                                    <li>
                                        <button  
                                            class="btn btn-animation" id="placeorderBtn">Place Order</button>
 
                                </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<div class="modal fade theme-modal" id="add-address" tabindex="-1" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><span class="address-title">Add   new </span> address</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<i class="fa-solid fa-xmark"></i>
				</button>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn theme-bg-color btn-md text-white" id="addressSubmitBtn">Save
					changes</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade theme-modal remove-profile" id="removeProfile" tabindex="-1"
	aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header d-block text-center">
				<h5 class="modal-title w-100" id="exampleModalLabel22">Are You Sure ?</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<i class="fa-solid fa-xmark"></i>
				</button>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">No</button>
				<button type="button" class="btn theme-bg-color btn-md fw-bold text-light"
						id="removeAddressBtn">Yes</button>
			</div>
		</div>
	</div>
</div> 
@endsection
@section('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>

$('.proceed-btn').on('click',function(){
	let id=$(this).val();
	if(id == 'payment-option' && $('#address_avlbl').val() == 0)
	{
		$('#payment-option').attr('data-bs-toggle','');
		Toastify({
			text: 'Add atleast one address',
			duration:5000,
			style: {
				background: "linear-gradient(to right,  #e91e63, #ff5722)",
			},
		}).showToast();
		$("#addNewAddressBtn").click();
		return false;
	}else{
		$('#payment-option').attr('data-bs-toggle','tab');
	}
	$('#'+id).click();
});
var addressType='new';
$('#addNewAddressBtn').on('click',function(){
	$('#add-address').find('.address-title').html('Add new ');
	addressType='new';
	$.ajax({
		url:"{{url('getAddressModal')}}",
		type:"get",
		data:{'type':'new'},
		success:function(res){
			$("#add-address").find('.modal-body').html(res);
			$("#add-address").modal('show');
		}
	});
});
$('#addressSubmitBtn').on('click',function(){
	$('#formUserEdit').find('.form-control').css('border','');
	$('.modal-err').remove();
	let successMsg=addressType == 'new' ? 'Added ' : 'Updated';
	let fd=$('#add-address').find('form').serialize()+"&_token={{csrf_token()}}&address_type="+addressType;
	$.ajax({
		url:"{{url('storeAddress')}}",
		type:"post",
		data:fd,
		success:function(res){
			$("#add-address").find('.modal-body').html('');
			$("#add-address").modal('hide');
			Toastify({
				text: successMsg,
				duration:3000,
				style: {
					background: "linear-gradient(to right, #00b09b, #96c93d)",
				},
			}).showToast();
			loadAddress();
		},
		error: function(res){
			$.each(res.responseJSON.errors,function(i,e){
				 $(document).find('#add-address').find('[name='+i).css('border',' 1px solid #e91e63');
				 $(document).find('#add-address').find('[name='+i).after('<span class="modal-err" style="color:#e91e63">'+e+'</span>');
			});
		}
	});
});
loadAddress();
function loadAddress(){
	$.ajax({
		url:"{{url('loadAddress')}}",
		type:"get",
		data:{'type':'checkout'},
		success:function(res){
			$('#address-container').html(res);
			if($('#address_avlbl').val() == 0)
			{
				$('#payment-option').attr('data-bs-toggle','');
				 
				 
			}else{
				$('#payment-option').attr('data-bs-toggle','tab');
			}
		}
	});
}
$(document).on('click','.editAddresBtn',function(){
	$('#add-address').find('.address-title').html('Edit ');
	let id=$(this).val();
	addressType='edit';
	$.ajax({
		url:"{{url('getAddressModal')}}",
		type:"get",
		data:{'type':'edit','id':id},
		success:function(res){
			$("#add-address").find('.modal-body').html(res);
			$("#add-address").modal('show');
		}
	});
});
var addressDeleteId=0;
$(document).on('click','.removeAddresBtn',function(){
	addressDeleteId=$(this).val();
	$('#removeProfile').modal('show');
});
$('#removeAddressBtn').on('click',function(){
	$.ajax({
		url:"{{url('removeAddressModal')}}",
		type:"post",
		data:{'_token':"{{csrf_token()}}",'id':addressDeleteId},
		success:function(res){
			 if(res == '1'){
				Toastify({
					text: 'Removed',
					duration:3000,
					style: {
						background: "linear-gradient(to right, #00b09b, #96c93d)",
					},
				}).showToast();
				loadAddress();
				$('#removeProfile').modal('hide');
			 }
		}
	});
});
$(document).on('click','.defualtBtn',function(){
	let id=$(this).attr('data-value');
	$.ajax({
		url:"{{url('changeAddressStatus')}}",
		type:"get",
		data:{'id':id},
		success:function(res){
				Toastify({
					text: 'Updated',
					duration:3000,
					style: {
						background: "linear-gradient(to right, #00b09b, #96c93d)",
					},
				}).showToast();
		}
	});
});




//
var cart_id='';
var orders;
$('#placeorderBtn').on('click',function(){
	let fd={'_token':"{{csrf_token()}}",'cart_id':cart_id};
	$.ajax({
		url:"{{url('placeorder')}}",
		type:"post",
		data:fd,
		success:function(res){
			orders=res;
			cart_id=res.cart_id;
			completePayment(res);
		}
	});
});
var razorpay_payment_id;
function completePayment(res)
{
 var json=res;
           options = {
            "key": "{{env('RAZOR_KEY')}}",  
            "amount": json.amount, 
            "currency": "INR",
            "name": "Ilaayurveda",
            
            "order_id":json.id ,
            "handler": function (response){

                var pid=(response.razorpay_payment_id);
				razorpay_payment_id=pid;
                var oid=(response.razorpay_order_id); 
                //console.log(response);
				checkStatus(response);
            },
            "prefill": {
                "name": json.reciept,
                "email": json.email,
                "contact": json.phone
            },
            "notes": {
                "address": json.notes.address
            },
            "theme": {
                "color": "#333"
            }
        };
        rzp1 = new Razorpay(options);
        rzp1.open();
        rzp1.on('payment.failed', function (response){
            $.alert({
                title: 'Something went Wrong!',
                content: 'Cannot complete payment ,Any amount deducted will be refunded by next 3 - 7 working days ',
            });
        });

}

function checkStatus(response){
	$.ajax({
		url:"{{url('checkPayment')}}",
		type:"post",
		data:{'_token':"{{csrf_token()}}",'payment_id':response.razorpay_payment_id,'cart_id':cart_id},
		success:function(res){
			if(res != null)
			{
				 
				location.href="{{url('order-success')}}/"+res;
			}
		}
	});
}
</script>
@endsection