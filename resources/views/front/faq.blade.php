@extends('layouts.frontlayout')
@section('styles')
<link id="color-link" rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/bulk-style.css') }}">
@endsection
@section('content') <!-- Breadcrumb Section Start -->
    {{--  <section class="faq-breadscrumb pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>Help Center</h2>
                        <p>We are glad having you here looking for the answer. As our team hardly working on the
                            product, feel free to ask any questions. We Believe only your feedback might move us
                            forward.</p>
                        <div class="faq-form-tag">
                            <div class="input-group">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input type="search" class="form-control" id="exampleFormControlInput1"
                                    placeholder="name@example.com">
                                <div class="dropdown">
                                    <button class="btn btn-md faq-dropdown-button dropdown-toggle" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown">All
                                        Product <i class="fa-solid fa-angle-down ms-2"></i></button>
                                    <ul class="dropdown-menu faq-dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>  --}}
    <!-- Breadcrumb Section End -->

    <!-- Faq Question section Start -->
    <section class="faq-contain">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="slider-4-2 product-wrapper">
                        <div>
                            <div class="faq-top-box">
                                <div class="faq-box-icon">
                                    <img src="{{ asset('assets/front/images/inner-page/faq/start.png') }}" class="blur-up lazyload"
                                        alt="">
                                </div>

                                <div class="faq-box-contain">
                                    <h3>Getting Started</h3>
                                    <p>Bring to the table win-win survival strategies to ensure proactive domination.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="faq-top-box">
                                <div class="faq-box-icon">
                                    <img src="{{ asset('assets/front/images/inner-page/faq/help.png') }}" class="blur-up lazyload" alt="">
                                </div>

                                <div class="faq-box-contain">
                                    <h3>Sales Question</h3>
                                    <p>Lorizzle ipsizzle boom shackalack sit get down get down.</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="faq-top-box">
                                <div class="faq-box-icon">
                                    <img src="{{ asset('assets/front/images/inner-page/faq/price.png') }}" class="blur-up lazyload"
                                        alt="">
                                </div>

                                <div class="faq-box-contain">
                                    <h3>Pricing & Plans</h3>
                                    <p>Curabitizzle fizzle break yo neck, yall quis fo shizzle mah nizzle fo rizzle.</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="faq-top-box">
                                <div class="faq-box-icon">
                                    <img src="{{ asset('assets/front/images/inner-page/faq/contact.png') }}" class="blur-up lazyload"
                                        alt="">
                                </div>

                                <div class="faq-box-contain">
                                    <h3>Support Contact</h3>
                                    <p>Gizzle fo shizzle bow wow wow bizzle leo bibendizzle check out this.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Faq Question section End -->

    <!-- Faq Section Start -->
    <section class="faq-box-contain section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-xxl-4">
                    <div class="faq-contain p-sticky">
                        <h2>Frequently Asked Questions</h2>
                        <p>We are answering most frequent questions. No worries if you not find exact one. You can find
                            out more by searching or continuing clicking button below or directly <a
                                href="#" class="theme-color text-decoration-underline">contact our
                                support.</a></p>
                    </div>
                </div>

                <div class="col-xxl-7 ms-auto">
                    <div class="faq-accordion">
                        <div class="accordion" id="accordionExample">
                            @foreach($data as $key=>$row)
                         
                        
                             <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{$key}}">
                                  
                                    <button class="accordion-button {{$key==0 ? '':'collapsed'}}" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{$key}}" aria-expanded="{{ $key==0 ? 'true':'false' }}"  aria-controls="collapse{{$key}}">
                                        {{ucfirst($row->question)}} <i
                                            class="fa-solid fa-angle-down"></i>
                                    </button>
                                  
                                </h2>
                                <div id="collapse{{$key}}" class="accordion-collapse collapse {{ $key==0 ? 'show':''}}" aria-labelledby="heading{{$key}}"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>{{ ucfirst($row->answer)}}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                        
                          
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Faq Section End -->
    @endsection