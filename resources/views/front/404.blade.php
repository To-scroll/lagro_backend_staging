{{--
@extends('layouts.frontlayout')
@section('content')
<section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>404 </h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{url('/')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">404</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- 404 Section Start -->
    <section class="section-404 section-lg-space">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="image-404">
                        <img src="{{asset('assets/front//images/inner-page/404.png')}}" class="img-fluid blur-up lazyload" alt="">
                    </div>
                </div>

                <div class="col-12">
                    <div class="contain-404">
                        <h3 class="text-content">The page you are looking for could not be found. The link to this
                            address may be outdated or we may have moved the since you last bookmarked it.</h3>
                        <button onclick="location.href = "{{url('/')}}";"
                            class="btn btn-md text-white theme-bg-color mt-4 mx-auto">Back To Home </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 Page Not Found</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/front/css/style.css"> <!-- Adjust path to your actual CSS -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link id="color-link" rel="stylesheet" type="text/css" href="{{asset('assets/front/css/style.css')}}">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<body>


<!-- 404 Section Start -->
<section class="section-404 section-lg-space">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="image-404">
                    <img src="assets/front/images/inner-page/404.png" class="img-fluid lazyload" alt="404 Image">
                </div>
            </div>

            <div class="col-12">
                <div class="contain-404">
                    <h3 class="text-content">
                        The page you are looking for could not be found. The link to this address may be outdated or we may have moved the page since you last bookmarked it.
                    </h3>
                    <a href="{{ url('/') }}" class="btn btn-md text-white theme-bg-color mt-4 mx-auto d-table">
                        Back To Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- 404 Section End -->

</body>
</html>
