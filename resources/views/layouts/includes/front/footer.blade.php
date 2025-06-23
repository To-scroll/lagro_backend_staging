<footer class="section-t-space footer-section-2 footer-color-2">
    <div class="container-fluid-lg">
        <div class="main-footer">
            <div class="row g-md-4 gy-sm-5">
                <div class="col-xxl-3 col-xl-4 col-sm-6">
                    <a href="{{url('/')}}" class="foot-logo theme-logo">
                        <img src="{{asset('public/images/settings/logo')}}/{{\App\Models\Settings::getSettingsvalue('logo')}}" class="img-fluid blur-up lazyload"
                            alt="">
                    </a>
                    <p class="information-text information-text-2">{{\App\Models\Settings::getSettingsvalue('footer_description')}}</p>
                    <ul class="social-icon">
						@if(App\Models\Settings::getSettingsvalue('facebook') != '')
                        <li class="light-bg">
                            <a href="{{ App\Models\Settings::getSettingsvalue('facebook') }}" class="footer-link-color">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li> 
						@endif
						@if(App\Models\Settings::getSettingsvalue('twitter') != '')
                        <li class="light-bg">
                            <a href="{{ App\Models\Settings::getSettingsvalue('twitter') }}" class="footer-link-color">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
						@endif	
						@if(App\Models\Settings::getSettingsvalue('instagram') != '')
                        <li class="light-bg">
                            <a href="{{ App\Models\Settings::getSettingsvalue('instagram') }}" class="footer-link-color">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
						@endif
                    </ul>
                </div>

                <div class="col-xxl-2 col-xl-4 col-sm-6">
                    <div class="footer-title">
                        <h4 class="text-white">About {{ App\Models\Settings::getSettingsvalue('site_name') }}</h4>
                    </div>
                    <ul class="footer-list footer-contact footer-list-light">
                        <li>
                            <a href="{{url('faq')}}" class="light-text">FAQs</a>
                        </li>
                        <li>
                            <a href="{{url('about-us')}}" class="light-text">About Us</a>
                        </li>
                        <li>
                            <a href="{{url('contact-us')}}" class="light-text">Contact Us</a>
                        </li>
						<li>
                            <a href="{{url('page/privacy-policy')}}" class="light-text">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="{{url('page/terms-and-conditions')}}" class="light-text">Terms & Coditions</a>
                        </li>
                    </ul>
                </div>

                <div class="col-xxl-2 col-xl-4 col-sm-6">
                    <div class="footer-title">
                        <h4 class="text-white">Useful Link</h4>
                    </div>
                    <ul class="footer-list footer-list-light footer-contact">
                        <li>
                            <a href="{{url('shop')}}" class="light-text">Shop</a>
                        </li>
                        <li>
                            <a href="{{url('cart')}}" class="light-text">Cart</a>
                        </li>
						@if(!\Auth::guest())
						<li>
							<a href="{{url('dashboard')}}" class="light-text">Your Account</a>
						</li>
                        @endif 
                       
                    </ul>
                </div>

                <div class="col-xxl-2 col-xl-4 col-sm-6">
                    <div class="footer-title">
                        <h4 class="text-white">Categories</h4>
                    </div>
                    <ul class="footer-list footer-list-light footer-contact">
						@foreach ($categories as $item)
							@if ($loop->index < 5)
							<li>
								<a href="{{url('shop-category/'.$item->slug)}}" class="light-text">{{$item->category_name}}</a>
							</li>
							@endif
						@endforeach
                        
                    </ul>
                </div>

                <div class="col-xxl-3 col-xl-4 col-sm-6">
                    <div class="footer-title">
                        <h4 class="text-white">Store infomation</h4>
                    </div>
                    <ul class="footer-address footer-contact">
                        <li>
                            <a href="javascript:void(0)" class="light-text">
                                <div class="inform-box flex-start-box">
                                    <i data-feather="map-pin"></i>
                                    <p>{{\App\Models\Settings::getSettingsvalue('address')}}</p>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)" class="light-text">
                                <div class="inform-box">
                                    <i data-feather="phone"></i>
                                    <p>Call us: {{\App\Models\Settings::getSettingsvalue('support_no')}}</p>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)" class="light-text">
                                <div class="inform-box">
                                    <i data-feather="mail"></i>
                                    <p>Email Us: {{\App\Models\Settings::getSettingsvalue('support_email')}}</p>
                                </div>
                            </a>
                        </li>

                         
                    </ul>
                </div>
            </div>
        </div>

        <div class="sub-footer sub-footer-lite section-b-space section-t-space">
            <div class="left-footer">
                <p class="light-text">All Rights reserved        {{str_replace('https://','',str_replace('http://','',request()->getHost()))}} &copy; 2022 </p>
            </div>

            <ul class="payment-box">
                <li>
                    <img src="{{ asset('assets/front/images/icon/paymant/visa.png') }}" class="blur-up lazyload"
                        alt="">
                </li>
                <li>
                    <img src="{{ asset('assets/front/images/icon/paymant/discover.png') }}" alt=""
                        class="blur-up lazyload">
                </li>
                <li>
                    <img src="{{ asset('assets/front/images/icon/paymant/american.png') }}" alt=""
                        class="blur-up lazyload">
                </li>
                <li>
                    <img src="{{ asset('assets/front/images/icon/paymant/master-card.png') }}" alt=""
                        class="blur-up lazyload">
                </li>
                <li>
                    <img src="{{ asset('assets/front/images/icon/paymant/giro-pay.png') }}" alt=""
                        class="blur-up lazyload">
                </li>
            </ul>
        </div>
    </div>
</footer>
