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
					<h2>Dashboard</h2>
					<nav>
						<ol class="breadcrumb mb-0">
							<li class="breadcrumb-item">
								<a href="{{url('/')}}">
									<i class="fa-solid fa-house"></i>
								</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Breadcrumb Section End -->

<!-- User Dashboard Section Start -->
<section class="user-dashboard-section section-b-space">
	<div class="container-fluid-lg">
		<div class="row">
			<div class="col-xxl-3 col-lg-4">
				<div class="dashboard-left-sidebar">
					<div class="close-button d-flex d-lg-none">
						<button class="close-sidebar">
							<i class="fa-solid fa-xmark"></i>
						</button>
					</div>
					<div class="profile-box">
						<div class="cover-image">
							<img src="{{asset('assets/front/images/inner-page/cover-img.jpg')}}" class="img-fluid blur-up lazyload"
								alt="">
						</div>

						<div class="profile-contain">
							<div class="profile-image">
								<div class="position-relative">
									<img @if(\Auth::user()->profile_image != '') 
											src="{{asset('public/uploads/images/profile')}}/{{\Auth::user()->profile_image}}" 
										 @else 
											src="https://ui-avatars.com/api/?name={{\Auth::user()->name}}" 
										 @endif
										class="blur-up lazyload update_img" alt="">
									<div class="cover-icon">
										<i class="fa-solid fa-pen">
											<input type="file"  accept="image/*" onchange="readURL(this,0)">
										</i>
									</div>
								</div>
							</div>

							<div class="profile-name">
								<h3>{{\Auth::user()->name}}</h3>
								<h6 class="text-content">{{\Auth::user()->email}}</h6>
							</div>
						</div>
					</div>

					<ul class="nav nav-pills user-nav-pills" id="pills-tab" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link active" id="pills-dashboard-tab" data-bs-toggle="pill"
								data-bs-target="#pills-dashboard" type="button" role="tab"
								aria-controls="pills-dashboard" aria-selected="true"><i data-feather="home"></i>
								Dashboard</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
								data-bs-target="#pills-profile" type="button" role="tab"
								aria-controls="pills-profile" aria-selected="false"><i data-feather="user"></i>
								Profile</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="pills-address-tab" data-bs-toggle="pill"
								data-bs-target="#pills-address" type="button" role="tab"
								aria-controls="pills-address" aria-selected="false"><i data-feather="map-pin"></i>
								Address</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="pills-order-tab" data-bs-toggle="pill"
								data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
								aria-selected="false"><i data-feather="shopping-bag"></i>Order</button>
						</li>  
					</ul>
				</div>
			</div>

			<div class="col-xxl-9 col-lg-8">
				<button class="btn left-dashboard-show btn-animation btn-md fw-bold d-block mb-4 d-lg-none">Show
					Menu</button>
				<div class="dashboard-right-sidebar">
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-dashboard" role="tabpanel"
							aria-labelledby="pills-dashboard-tab">
							<div class="dashboard-home">
								<div class="title">
									<h2>My Dashboard</h2>
									<span class="title-leaf">
										<svg class="icon-width bg-gray">
											<use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
										</svg>
									</span>
								</div>

								<div class="dashboard-user-name">
									<h6 class="text-content">Hello, <b class="text-title">{{\Auth::user()->name}}</b></h6>
									 
								</div>

								<div class="total-box">
									<div class="row g-sm-4 g-3">
										<div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
											<div class="totle-contain">
												<img src="https://themes.pixelstrap.com/fastkart/assets/images/svg/order.svg"
													class="img-1 blur-up lazyload" alt="">
												<img src="https://themes.pixelstrap.com/fastkart/assets/images/svg/order.svg" class="blur-up lazyload"
													alt="">
												<div class="totle-detail">
													<h5>Total Order</h5>
													<h3>{{$orderCount}}</h3>
												</div>
											</div>
										</div>

										<div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
											<div class="totle-contain">
												<img src="https://themes.pixelstrap.com/fastkart/assets/images/svg/pending.svg"
													class="img-1 blur-up lazyload" alt="">
												<img src="https://themes.pixelstrap.com/fastkart/assets/images/svg/pending.svg" class="blur-up lazyload"
													alt="">
												<div class="totle-detail">
													<h5>Total Pending Order</h5>
													<h3>{{$orderPendingCount}}</h3>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="dashboard-title">
									<h3>Account Information</h3>
								</div>

								<div class="row g-4">
									<div class="col-xxl-12">
										 
										<div class="dashboard-detail">
											<h6 class="text-content">{{\Auth::user()->name}}</h6>
											<h6 class="text-content">{{\Auth::user()->email}}</h6>
											@if(\Auth::user()->phone != '')
												<h6 class="text-content">{{\Auth::user()->phone}}</h6>
											@endif
											 
										</div>
									</div>
 
								</div>
							</div>
						</div>

						 

						<div class="tab-pane fade show" id="pills-order" role="tabpanel"
							aria-labelledby="pills-order-tab">
							<div class="dashboard-order">
								<div class="title">
									<h2>My Orders History</h2>
									<span class="title-leaf title-leaf-gray">
										<svg class="icon-width bg-gray">
											<use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
										</svg>
									</span>
								</div>

								<div class="order-contain">
									@forelse ($orders as $item)
									<div class="order-box dashboard-bg-box">
										<div class="order-container">
											<div class="order-icon">
												<i data-feather="box"></i>
											</div>

											<div class="order-detail" style="width:300px;">
												<h4>{{$item->order_no }}<span 
												@if($item->status == 'pending') style="background:orange!important;" @endif
												@if($item->status == 'accepted') style="background:green!important;" @endif
												 
												>{{ucfirst($item->status)}}</span> </h4>
											</div>
										</div>

										<div class="product-order-detail">
											 

											<div class="order-wrap">
												 
												<ul class="product-size">
													<li>
														<div class="size-box">
															<h6 class="text-content">Price : </h6>
															<h5>{{number_format($item->total,2)}}</h5>
														</div>
													</li>

													 

													<li>
														<div class="size-box">
															<h6 class="text-content">Order Date : </h6>
															<h5>{{date('d M Y h:i A',strtotime($item->date))}}</h5>
														</div>
													</li>
													@if($item->status == 'accepted')
													<li>
														<div class="size-box">
															<h6 class="text-content">Delivery Status : </h6>
															<h5>{{ucfirst($item->delivery_status)}}</h5>
														</div>
													</li>
													@endif
												</ul>
												<br>
												<b class="viewItemsBtn" data-id="{{$item->id}}">View Items</b>
											</div>
										</div>
									</div>
									@empty
										<b>Nothing Found !</b><br>
										<a href="{{url('shop')}}">Start Shopping </a>	
									@endforelse
 
								</div>
							</div>
						</div>

						<div class="tab-pane fade show" id="pills-address" role="tabpanel"
							aria-labelledby="pills-address-tab">
							<div class="dashboard-address">
								<div class="title title-flex">
									<div>
										<h2>My Address Book</h2>
										<span class="title-leaf">
											<svg class="icon-width bg-gray">
												<use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
											</svg>
										</span>
									</div>

									<button class="btn theme-bg-color text-white btn-sm fw-bold mt-lg-0 mt-3"
										 id="addNewAddressBtn"><i data-feather="plus"
											class="me-2"></i> Add New Address</button>
								</div>

								<div class="row g-sm-4 g-3" id="address-container">
									

									{{--  <div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
										<div class="address-box">
											<div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="jack"
														id="flexRadioDefault3">
												</div>

												<div class="label">
													<label>Office</label>
												</div>

												<div class="table-responsive address-table">
													<table class="table">
														<tbody>
															<tr>
																<td colspan="2">Terry S. Sutton</td>
															</tr>

															<tr>
																<td>Address :</td>
																<td>
																	<p>2280 Rose Avenue Kenner, LA 70062</p>
																</td>
															</tr>

															<tr>
																<td>Pin Code :</td>
																<td>+25</td>
															</tr>

															<tr>
																<td>Phone :</td>
																<td>+ 504-228-0969</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>

											<div class="button-group">
												<button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
													data-bs-target="#editProfile"><i data-feather="edit"></i>
													Edit</button>
												<button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
													data-bs-target="#removeProfile"><i data-feather="trash-2"></i>
													Remove</button>
											</div>
										</div>
									</div>

									<div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
										<div class="address-box">
											<div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="jack"
														id="flexRadioDefault4">
												</div>

												<div class="label">
													<label>Neighbour</label>
												</div>

												<div class="table-responsive address-table">
													<table class="table">
														<tbody>
															<tr>
																<td colspan="2">Juan M. McKeon</td>
															</tr>

															<tr>
																<td>Address :</td>
																<td>
																	<p>1703 Carson Street Lexington, KY 40593</p>
																</td>
															</tr>

															<tr>
																<td>Pin Code :</td>
																<td>+78</td>
															</tr>

															<tr>
																<td>Phone :</td>
																<td>+ 859-257-0509</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>

											<div class="button-group">
												<button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
													data-bs-target="#editProfile"><i data-feather="edit"></i>
													Edit</button>
												<button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
													data-bs-target="#removeProfile"><i data-feather="trash-2"></i>
													Remove</button>
											</div>
										</div>
									</div>

									<div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
										<div class="address-box">
											<div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="jack"
														id="flexRadioDefault5">
												</div>

												<div class="label">
													<label>Home 2</label>
												</div>

												<div class="table-responsive address-table">
													<table class="table">
														<tbody>
															<tr>
																<td colspan="2">Gary M. Bailey</td>
															</tr>

															<tr>
																<td>Address :</td>
																<td>
																	<p>2135 Burning Memory Lane Philadelphia, PA
																		19135</p>
																</td>
															</tr>

															<tr>
																<td>Pin Code :</td>
																<td>+26</td>
															</tr>

															<tr>
																<td>Phone :</td>
																<td>+ 215-335-9916</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>

											<div class="button-group">
												<button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
													data-bs-target="#editProfile"><i data-feather="edit"></i>
													Edit</button>
												<button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
													data-bs-target="#removeProfile"><i data-feather="trash-2"></i>
													Remove</button>
											</div>
										</div>
									</div>

									<div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
										<div class="address-box">
											<div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="jack"
														id="flexRadioDefault1">
												</div>

												<div class="label">
													<label>Home 2</label>
												</div>

												<div class="table-responsive address-table">
													<table class="table">
														<tbody>
															<tr>
																<td colspan="2">Gary M. Bailey</td>
															</tr>

															<tr>
																<td>Address :</td>
																<td>
																	<p>2135 Burning Memory Lane Philadelphia, PA
																		19135</p>
																</td>
															</tr>

															<tr>
																<td>Pin Code :</td>
																<td>+26</td>
															</tr>

															<tr>
																<td>Phone :</td>
																<td>+ 215-335-9916</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>

											<div class="button-group">
												<button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
													data-bs-target="#editProfile"><i data-feather="edit"></i>
													Edit</button>
												<button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
													data-bs-target="#removeProfile"><i data-feather="trash-2"></i>
													Remove</button>
											</div>
										</div>
									</div>  --}}
								</div>
							</div>
						</div>

					 

						<div class="tab-pane fade show" id="pills-profile" role="tabpanel"
							aria-labelledby="pills-profile-tab">
							<div class="dashboard-profile">
								<div class="title">
									<h2>My Profile</h2>
									<span class="title-leaf">
										<svg class="icon-width bg-gray">
											<use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
										</svg>
									</span>
								</div>

								 

								<div class="profile-about dashboard-bg-box">
									<div class="row">
										<div class="col-xxl-7">
											<div class="dashboard-title mb-3">
												<h3>Profile <span style="font-size: 14px;padding: 5px 10px;border-radius: 5px;background: #e1f0ed;" data-bs-toggle="modal"
																		data-bs-target="#editProfile">Edit</span></h3>
											</div>

											<div class="table-responsive">
												<table class="table">
													<tbody>
														<tr>
															<td>Name :</td>
															<td>{{\Auth::user()->name  }}</td>
														</tr>
														<tr>
															<td>Phone :</td>
															<td>{{\Auth::user()->phone == '' ? 'N/A' : \Auth::user()->phone}}</td>
														</tr>
														<tr>
															<td>Email :</td>
															<td>{{\Auth::user()->email}}</td>
														</tr>
														<tr>
															<td>Gender :</td>
															<td>{{$user->gender}}</td>
														</tr>
														<tr>
															<td>Birthday :</td>
															<td>{{date('d/m/Y',strtotime($user->dob))}}</td>
														</tr>
														 
														 
													</tbody>
												</table>
											</div>

											<div class="dashboard-title mb-3">
												<h3>Login Details</h3>
											</div>

											<div class="table-responsive">
												<table class="table">
													<tbody>
														<tr>
															<td>Email :</td>
															<td>
																<a href="javascript:void(0)">{{\Auth::user()->email}}
																	 
															</td>
														</tr>
														<tr>
															<td>Password :</td>
															<td>
																<a href="javascript:void(0)">●●●●●●
																	<span data-bs-toggle="modal"
																		data-bs-target="#editProfile">Edit</span></a>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>

										<div class="col-xxl-5">
											<div class="profile-image">
												<img src="../assets/images/inner-page/dashboard-profile.png"
													class="img-fluid blur-up lazyload" alt="">
											</div>
										</div>
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
<!-- User Dashboard Section End --> 
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
<div class="modal fade theme-modal" id="editProfile" tabindex="-1" aria-labelledby="exampleModalLabel2"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
					<form id="formUserEdit">
						<div class="row g-4">
							<div class="col-xxl-12">
								
									<div class="form-floating theme-form-floating">
										<input type="text" class="form-control" name="name" id="name" value="{{$user->name}}" required>
										<label for="name">Full Name</label>
									</div>
								
							</div>

							<div class="col-xxl-6">
								
									<div class="form-floating theme-form-floating">
										<input type="email" class="form-control" id="email" name="email" value=" {{$user->email}}" required>
										<label for="email">Email address</label>
									</div>
								
							</div>

							<div class="col-xxl-6">
								
									<div class="form-floating theme-form-floating">
										<input type="tel" class="form-control" name="phone" id="phone" value="{{$user->phone}}">
										<label for="phone">Phone</label>
									</div>
								
							</div>
	
							<div class="col-xxl-6">
								
									<div class="form-floating theme-form-floating">
										<select class="form-select" id="floatingSelect"  name="gender" required>
											<option selected disabled value="">Choose Gender</option>
											<option value="Male"  @if($user->gender == 'Male'  ) selected @endif> Male</option>
											<option value="Female"@if($user->gender == 'Female'  ) selected @endif>Female</option>
											<option value="Other" @if($user->gender == 'Other'  ) selected @endif>Other</option>
										</select>
										<label for="floatingSelect">Gender</label>
									</div>
								
							</div>

							<div class="col-xxl-6">
								
									<div class="form-floating theme-form-floating">
										<input type="date" class="form-control" id="dob" name="dob" value="{{date('Y-m-d',strtotime($user->phone))}}">
										<label for="address3">Date of birth</label>
									</div>
								
							</div>
							<div class="col-xxl-12">
									<div class="form-floating theme-form-floating">
										<input type="password" class="form-control" id="password" name="password" value="">
										<label for="password">Password (Optional)</label>
									</div>
							</div>
						</div>
					</form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-animation btn-md fw-bold"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" 
                        class="btn theme-bg-color btn-md fw-bold text-light" id="userEditBtn">Save changes</button>
                </div>
            </div>
        </div>
</div>
    <!-- Remove Profile Modal Start -->
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
    <!-- Remove Profile Modal End -->


<div class="modal fade theme-modal" id="orderInfoModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span class="order-no-title"></span> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
</div>
@endsection
@section('scripts')
<script>
$('#userEditBtn').on('click',function(){
	$('#formUserEdit').find('.form-control').css('border','');
	$('.modal-err').remove();
	let fd=$('#formUserEdit').serialize()+"&_token={{csrf_token()}}";
	$.ajax({
		url:"{{url('updateUserDetails')}}",
		type:"post",
		data:fd,
		success:function(res){
			Toastify({
				text: "Updated",
				duration:3000,
				style: {
					background: "linear-gradient(to right, #00b09b, #96c93d)",
				},
			}).showToast();
			$('.modal').modal('hide');
		},
		error: function(res){
			 
			$.each(res.responseJSON.errors,function(i,e){
				  
				 $(document).find('#formUserEdit').find('[name='+i).css('border',' 1px solid #e91e63');
				 $(document).find('#formUserEdit').find('[name='+i).after('<span class="modal-err" style="color:#e91e63">'+e+'</span>');
			});
		}
	});
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
		data:{'type':'dashboard'},
		success:function(res){
			$('#address-container').html(res);
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

$('.viewItemsBtn').on('click',function(){
	let id=$(this).attr('data-id');
	$.ajax({
		url:"{{url('getOrderItems')}}",
		type:"get",
		data:{'id':id},
		success:function(res)
		{
			$('#orderInfoModal .modal-body').html(res.html);
			$('#orderInfoModal .order-no-title').html(res.order_no);
			$('#orderInfoModal').modal('show');
		}
	});
});
$('.cover-icon input[type=file').on('change',function(){
   var fd = new FormData();
   fd.append("_token","{{csrf_token()}}");
   fd.append("file", $('.cover-icon input[type=file')[0].files[0]);
	$.ajax({
		url:"{{url('uploadProfileImage')}}",
		method:"POST",
		data: fd,
		contentType: false,
		cache: false,
		processData: false,  
		success:function(res)
		{
			Toastify({
					text: 'Profile Image updated Successfully',
					duration:3000,
					style: {
						background: "linear-gradient(to right, #00b09b, #96c93d)",
					},
				}).showToast();
		}
	});
});

var heights=[];
var max='400px';
{{--  adjHeight();
function adjHeight()
{
	$('.product-order-detail').each(function(){
		heights.push($(this).width());
	});

}  --}}
{{--  setInterval(function(){
	//max=Math.max.apply(Math,heights); 
	//console.log(heights);
	//$('.product-order-detail').width(max+"px");
},1500);  --}}
$('.nav-item #pills-order-tab').on('click',function(){
	setTimeout(adjHeight,1000);
}); 
function adjHeight(){
	var array=[];
	$('.product-order-detail').each(function(){
		array.push($(this).width());
	});
	let h=Math.max(...array);
	$('.product-order-detail').width(h);
	 
}
setInterval(function(){
    
    if($('.dashboard-left-sidebar.show').length == 1)
    {
        
        $('.bg-overlay').removeClass('show');
    } 
},1000);
</script>
@endsection