@extends('layouts.frontlayout')
@section('styles')
@endsection
@section('content')
<section class="breadscrumb-section pt-0">
	<div class="container-fluid-lg">
		<div class="row">
			<div class="col-12">
				<div class="breadscrumb-contain">
					<h2>Signup</h2>
					<nav>
						<ol class="breadcrumb mb-0">
							<li class="breadcrumb-item">
								<a href="{{ url('/') }}">
									<i class="fa-solid fa-house"></i>
								</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">Signup </li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shop Section Start -->
<section class="log-in-section section-b-space">
	<div class="container-fluid-lg w-100">
		<div class="row">
			<div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
				<div class="image-contain">
					<img src="{{ asset('assets/front/images/inner-page/sign-up.png') }}" class="img-fluid"
						alt="">
				</div>
			</div>

			<div class="col-xxl-4 col-xl-5 col-lg-6 me-auto">
				<div class="log-in-box">
					<div id="registerMsg" style="font-size:30px;color:black;"></div>
					<div class="log-in-title">
						<h3>Create New Account</h3>
					</div>

					<div class="input-box">
						<form class="row g-4" method="post" id="signUpForm">
							@csrf
							<div class="col-12">
								<div class="form-floating theme-form-floating">
									<input type="text" class="form-control" name="fullname"id="fullname"
										placeholder="Full Name">
									<label for="fullname">Full Name</label>
								</div>
							</div>
							<div class="col-12">
								<div class="form-floating theme-form-floating">
									<input type="email" class="form-control" name="email"id="email"
										placeholder="Email Address">
									<label for="email">Email Address</label>
								</div>
							</div>
							<div class="col-12">
								<div class="form-floating theme-form-floating">
									<input type="number" class="form-control" name="phone"id="phone" 
										placeholder="Phone">
									<label for="phone">Phone</label>
								</div>
							</div>
							<div class="col-12">
								<div class="form-floating theme-form-floating">
									<input type="password" class="form-control" name="password" id="password"
										placeholder="Password">
									<label for="password">Password</label>
								</div>
							</div>

							<div class="col-12">
								<div class="forgot-box">
									<div class="form-check ps-0 m-0 remember-box">
										<input class="checkbox_animated check-box" type="checkbox"
											id="flexCheckDefaultAgree">
										<label class="form-check-label" for="flexCheckDefaultAgree">I agree with
											<span>Terms</span> and <span>Privacy</span></label>
									</div>
								</div>
								<div id="checkboxmsg"></div>
							</div>

							<div class="col-12">
								<button class="btn btn-animation w-100" type="submit">Sign Up</button>
							</div>
						</form>
					</div>

					 

					<div class="other-log-in">
						<h6></h6>
					</div>

					<div class="sign-up-box">
						<h4>Already have an account?</h4>
						<a href="{{ route('login') }}">Log In</a>
					</div>
				</div>
			</div>

			<div class="col-xxl-7 col-xl-6 col-lg-6"></div>
		</div>
	</div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('assets/front/js/quantity-2.js') }}"></script>
<script>
	$("#signUpForm").on('submit', (function(e) {
		$(".errors").html('');
		$('#registerMsg').text('');
		$('#checkboxmsg').text('');
		if (($('#email').val() != '') && ($('#password').val() != '')) {
			if ($('#flexCheckDefaultAgree').is(':checked') == false) {
				$('#checkboxmsg').html('<span style="color:red;">Please Agree the Conditions</span>');
				return false;
			}
		}
		e.preventDefault();
		$.ajax({
			url: "{{ route('signUpFormStore') }}",
			type: "post",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			success: function(data) {
				$('#registerMsg').text('Registered Successfully');
				$('#signUpForm')[0].reset();
				window.location.href = "{{ route('login') }}";
			},
			error: function(response) {
				$('#preloader').fadeOut(100);
				jsonValue = jQuery.parseJSON(response.responseText);
				$.each(jsonValue.errors, function(field_name, error) {
					$(document).find('[name=' + field_name + ']').after(
						'<small class="form-control-feedback text-danger errors"> ' +
						error + ' </small>')
				});
			}
		});
	}));
	function phonenumber(){
		let phone=$('#phone').val();
		//phone=phone.replace('e','');
		phone=phone.substr(0,10);
		$('#phone').val(phone);
	}
	$('#phone').on('keyup',function(){
		phonenumber();
	});
</script>
@endsection
