@extends('layouts.frontlayout')
@section('styles')
    <!-- Iconly css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/bulk-style.css') }}">
@endsection
@section('content')
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2 class="mb-2">Log In</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{url('/') }}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Log In</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- log in section start -->
    <section class="log-in-section background-image-2 section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row">
                <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                    <div class="image-contain">
                        <img src="{{ asset('assets/front/images/inner-page/log-in.png') }}" class="img-fluid" alt="">
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-5 col-lg-6 me-auto">
                    <div class="log-in-box">
                        @if(Session::has('reg_message'))
                       <div class="log-in-title">
                            <h3 style="color:#0da487;text-align: center;">{{Session::get('reg_message') }}</h3>
                        
                        </div>
                        @endif
                        <div class="log-in-title">
                            <h3>Log In Your Account</h3>
                        </div>

                        <div class="input-box">
                            <form class="row g-4"  method="POST"action="{{ route('login') }}">
                              @csrf
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email Address"value="{{ old('email') }}" >
                                        <label for="email">Email Address</label>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror   
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"name="password" id="password"
                                            placeholder="Password"  value="{{ old('password') }}">
                                        <label for="password">Password</label>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="forgot-box">
                                        <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-animation w-100 justify-content-center" type="submit">Log
                                        In</button>
                                </div>
                            </form>
                        </div>
                        <div class="sign-up-box">
                            <h4>Don't have an account?</h4>
                            <a href="{{ url('signup')}}">Sign Up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- log in section end -->
@endsection
@section('scripts')
@if(\Session::has('login_message') && \Session::get('login_message') == true)
<script>
Toastify({
		text: "Login & Continue",
		duration:3000,
		style: {
			background: "linear-gradient(to right,  #e91e63, #ff5722)",
		},
	}).showToast();
</script>
@endif
@endsection