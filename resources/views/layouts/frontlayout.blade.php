@php
$categories=\App\Models\Category::where('status','yes')->where('is_parent','yes')->orderBy('category_name','asc')->get();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{\App\Models\Settings::getSettingsvalue('site_name')}}">
    <meta name="keywords" content="{{\App\Models\Settings::getSettingsvalue('site_name')}}">
    <meta name="author" content="{{\App\Models\Settings::getSettingsvalue('site_name')}}">
    <link rel="icon" href="{{asset('public//images/settings/favicon')}}/{{\App\Models\Settings::getSettingsvalue('favicon')}}" type="image/x-icon">
    <title>  Shopping | {{\App\Models\Settings::getSettingsvalue('site_name')}}</title>

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&amp;display=swap" rel="stylesheet">

    <!-- bootstrap css -->
    <link id="rtl-link" rel="stylesheet" type="text/css" href="{{asset('assets/front/css/vendors/bootstrap.css')}}">

    <!-- wow css -->
    <link rel="stylesheet" href="{{asset('assets/front/css/animate.min.css')}}" />

    <!-- font-awesome css -->
    {{--  <link rel="stylesheet" type="text/css" href="{{asset('assets/front/css/vendors/font-awesome.css')}}">  --}}
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- feather icon css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/front/css/vendors/feather-icon.css')}}">

    <!-- Plugin CSS file with desired skin css -->
    <link rel="stylesheet" href="{{asset('assets/front/css/vendors/ion.rangeSlider.min.css')}}">

    <!-- slick css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/front/css/vendors/slick/slick.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/front/css/vendors/slick/slick-theme.css')}}">

    <!-- animation css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/front/css/font-style.css')}}">

    <!-- Template css -->
    <link id="color-link" rel="stylesheet" type="text/css" href="{{asset('assets/front/css/style.css')}}">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
	@yield('style')
	@yield('styles')
</head>

<body class="theme-color-3" style="--theme-color: #000000; --theme-color-rgb:#000000;">

    <!-- Loader Start -->
    <div class="fullpage-loader">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    <!-- Loader End -->

    <!-- Header Start -->
    @include('layouts.includes.front.header')
    <!-- Header End -->

    <!-- mobile fix menu start -->
    @include('layouts.includes.front.mobile-header')
    <!-- mobile fix menu end -->

	@yield('content')

    <!-- Footer Start -->
    @include('layouts.includes.front.footer')
    <!-- Footer End -->

    

    

    <!-- Bg overlay Start -->
    <div class="bg-overlay"></div>
    <!-- Bg overlay End -->

    <!-- latest jquery-->
    <script src="{{asset('assets/front/js/jquery-3.6.0.min.js')}}"></script>

    <!-- jquery ui-->
    <script src="{{asset('assets/front/js/jquery-ui.min.js')}}"></script>

    <!-- Bootstrap js-->
    <script src="{{asset('assets/front/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/front/js/bootstrap/bootstrap-notify.min.js')}}"></script>
    <script src="{{asset('assets/front/js/bootstrap/popper.min.js')}}"></script>

    <!-- feather icon js-->
    <script src="{{asset('assets/front/js/feather/feather.min.js')}}"></script>
    <script src="{{asset('assets/front/js/feather/feather-icon.js')}}"></script>

    <!-- Lazyload Js -->
    <script src="{{asset('assets/front/js/lazysizes.min.js')}}"></script>

    <!-- Slick js-->
    <script src="{{asset('assets/front/js/slick/slick.js')}}"></script>
    <script src="{{asset('assets/front/js/slick/slick-animation.min.js')}}"></script>
    <script src="{{asset('assets/front/js/custom-slick-animated.js')}}"></script>
    <script src="{{asset('assets/front/js/slick/custom_slick.js')}}"></script>

    <!-- Range slider js -->
    <script src="{{asset('assets/front/js/ion.rangeSlider.min.js')}}"></script>

    <!-- Auto Height Js -->
    <script src="{{asset('assets/front/js/auto-height.js')}}"></script>

    <!-- Lazyload Js -->
    <script src="{{asset('assets/front/js/lazysizes.min.js')}}"></script>

    <!-- Quantity js -->
     

    <!-- Fly Cart Js -->
    <script src="{{asset('assets/front/js/fly-cart.js')}}"></script>

    <!-- Timer Js -->
    {{--  <script src="{{asset('assets/front/js/timer.js')}}"></script>
    <script src="{{asset('assets/front/js/timer1.js')}}"></script>  --}}

    <!-- Copy clipboard Js -->
    <script src="{{asset('assets/front/js/clipboard.min.js')}}"></script>
    <script src="{{asset('assets/front/js/copy-clipboard.js')}}"></script>

    <!-- WOW js -->
    <script src="{{asset('assets/front/js/wow.min.js')}}"></script>
    <script src="{{asset('assets/front/js/custom-wow.js')}}"></script>

    <!-- script js -->
    <script src="{{asset('assets/front/js/script.js')}}"></script>

    <!-- thme setting js -->
    <script src="{{asset('assets/front/js/theme-setting.js')}}"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
	@yield('scripts')
	<script>
		$('.searchBtn').on('click',function(){
			search=$('#searchQuery').val();
			if("{{url()->current()}}" == 'shop')
			{
				page=1;
				load(page);
			}else{
				location.href="{{url('search')}}?q="+search;
			}
		});
		fetchCart();
		function fetchCart(){
			$.ajax({
				url:"{{url('fetchCart')}}",
				type:"get",
				success:function(res){
					$('.header-cart-list-badge').html(res.count+'  <span class="visually-hidden">unread messages</span>');
					if(res.items == ''){
						$('.header-cart-list .header-cart-list-items').hide();
						$('.header-cart-list .header-cart-list-items').css('display','none');
						$('.header-cart-list .header-cart-list-items').off('hover');
						return false;
					}else{
						$('.header-cart-list .header-cart-list-items').show();
						$('.header-cart-list .header-cart-list-items').css('display','block');
						$('.header-cart-list .header-cart-list-items').on('hover');
					}
					$('.header-cart-list .header-cart-list-items').html(res.items);
				}

			});
		}
		
		$(document).on('click','.removeHeaderCartItemBtn',function(){
			let id=$(this).val();
			$.ajax({
				url:"{{url('deleteCartItem')}}",
				type:"post",
				data:{'_token':"{{csrf_token()}}",'id':id},
				success:function(res){
					 
					Toastify({
							text: "Removed",
							duration:3000,
							style: {
								background: "linear-gradient(to right,  #e91e63, #ff5722)",
							},
						}).showToast();
						fetchCart();

						if("{{ str_contains(url()->current(),'/cart') }}" == 1)
						{
							loadCart();
						}
				}
			});
		});
	 
	</script>
</body>

 
</html>