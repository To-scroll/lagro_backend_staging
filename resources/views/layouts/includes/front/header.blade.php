<header class="pb-md-4 pb-0">
	{{-- <div class="header-top">
		<div class="container-fluid-lg">
			<div class="row">
				<div class="col-xxl-3 d-xxl-block d-none">
					<div class="top-left-header">
						<i class="iconly-Location icli text-white"></i>
						<span class="text-white">{{\App\Models\Settings::getSettingsvalue('address')}}</span>
					</div>
				</div>

				<div class="col-xxl-9 col-lg-9 d-lg-block d-none">
					<div class="header-offer">
						<div class="notification-slider">
							<div>
								<div class="timer-notification">
									<h6><strong class="me-1">{{\App\Models\Settings::getSettingsvalue('header_description')}}
										</strong>

									</h6>
								</div>
							</div>
 
						</div>
					</div>
				</div>


			</div>
		</div>
	</div> --}}

	<div class="top-nav top-header sticky-header">
		<div class="container-fluid-lg">
			<div class="row">
				<div class="col-12">
					<div class="navbar-top">
						<button class="navbar-toggler d-xl-none d-inline navbar-menu-button" type="button"
							data-bs-toggle="offcanvas" data-bs-target="#primaryMenu">
							<span class="navbar-toggler-icon">
								<i class="fa-solid fa-bars"></i>
							</span>
						</button>
						<a href="{{url('/')}}" class="web-logo nav-logo">
							<!--<H4><b>Ila Ayurveda</b></H4>-->
							  <img src="{{asset('public/images/settings/logo')}}/{{\App\Models\Settings::getSettingsvalue('logo')}}" class="img-fluid blur-up lazyload"
								alt=""> 
						</a>

						<div class="middle-box">


							<div class="search-box">
								<div class="input-group">
									<input type="search" class="form-control" placeholder="I'm searching for..."
										 value="" aria-describedby="button-addon2" id="searchQuery">
									<button class="btn searchBtn" type="button" id="button-addon2">
										<i data-feather="search"></i>
									</button>
								</div>
							</div>
						</div>

						<div class="rightside-box">
							<div class="search-full">
								<div class="input-group">
									<span class="input-group-text">
										<i data-feather="search" class="font-light"></i>
									</span>
									<input type="text" class="form-control search-type" placeholder="Search here..">
									<span class="input-group-text close-search">
										<i data-feather="x" class="font-light"></i>
									</span>
								</div>
							</div>
							<ul class="right-side-menu">
								<li class="right-side">
									<div class="delivery-login-box">
										<div class="delivery-icon">
											<div class="search-box">
												<i data-feather="search"></i>
											</div>
										</div>
									</div>
								</li>
								<li class="right-side">
									<a href="{{url('contact-us')}}" class="delivery-login-box">
										<div class="delivery-icon">
											<i data-feather="phone-call"></i>
										</div>
										<div class="delivery-detail">
											<h6>Speed Delivery</h6>
											<h5>{{ \App\Models\Settings::getSettingsvalue('support_no') }}</h5>
										</div>
									</a>
								</li>
								
								<li class="right-side header-cart-list">
									<div class="onhover-dropdown header-badge">
										<button type="button" class="btn p-0 position-relative header-wishlist">
											<i data-feather="shopping-cart"></i>
											<span class="position-absolute top-0 start-100 translate-middle badge header-cart-list-badge">
												0
												<span class="visually-hidden">unread messages</span>
											</span>
										</button>

										<div class="onhover-div header-cart-list-items">
											 
	
											
										</div>
									</div>
								</li>
								<li class="right-side onhover-dropdown">
									<div class="delivery-login-box">
										<div class="delivery-icon">
											<i data-feather="user"></i>
										</div>
										@guest 
										@else
										<div class="delivery-detail">
											@auth <h6>Hello {{auth()->user()->name}},</h6> @endauth
											<h5>My Account</h5>
										</div>
										@endguest
										
									</div>
									
									<div class="onhover-div onhover-div-login">
										<ul class="user-box-name">
											@guest
											<li class="product-box-contain">
												<i></i>
												<a href="{{url('login')}}">Log In</a>
											</li>

											<li class="product-box-contain">
												<a href="{{url('signup')}}">Register</a>
											</li>

											 
											@else
											<li class="product-box-contain">
												<i></i>
												<a href="{{url('dashboard')}}">Dashboard</a>
											</li>	
											<li class="product-box-contain">
												<i></i>
												<a href="{{url('logout')}}">Logout</a>
											</li>	
											@endguest
										</ul>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid-lg">
		<div class="row">
			<div class="col-12">
				<div class="header-nav-left">
					<div class="header-nav-middle">
						<div class="main-nav navbar navbar-expand-xl navbar-light navbar-sticky">
							<div class="offcanvas offcanvas-collapse order-xl-2" id="primaryMenu">
								<div class="offcanvas-header navbar-shadow">
									<h5>Menu</h5>
									<button class="btn-close lead" type="button" data-bs-dismiss="offcanvas"
										aria-label="Close"></button>
								</div>
								<div class="offcanvas-body">
									<ul class="navbar-nav">
										<li class="nav-item">
											<a class="nav-link nav-link-2" href="{{url('/')}}">Home</a>
										</li>
										<li class="nav-item ">
											<a class="nav-link nav-link-2" href="{{url('shop')}}">Shop</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link nav-link-2" href="#">Categories</a>
											<ul class="dropdown-menu">
												@foreach ($categories as $item)
												<li>
													<a class="dropdown-item" href="{{url('shop-category/'.$item->slug)}}">{{$item->category_name}} </a>
												</li>
												@endforeach
                                            </ul>
										</li>
										 <li class="nav-item">
											<a class="nav-link nav-link-2" href="{{url('cart')}}">Cart</a>
										</li>
										<li class="nav-item">
											<a class="nav-link nav-link-2" href="{{url('faq')}}">FAQ</a>
										</li>
										{{--  <li class="nav-item">
											<a class="nav-link nav-link-2" href="{{url('faq')}}">Store Policies</a>
										</li>  --}}
										{{--  <li class="nav-item">
											<a class="nav-link nav-link-2" href="{{url('contact-us')}}">Support</a>
										</li>  --}}
										<li class="nav-item">
											<a class="nav-link nav-link-2" href="{{url('contact-us')}}">Contact Us</a>
										</li>
										<li class="nav-item">
											<a class="nav-link nav-link-2" href="{{url('about-us')}}">About Us</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>


				</div>
			</div>
		</div>
	</div>
</header>