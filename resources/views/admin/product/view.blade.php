@extends('layouts.adminlayout')
@section('styles')
  
  

    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3806c3;
        }
        .swiper-button-next:after,.swiper-button-prev:after {
    /* font-family:''; */
        }
    </style>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Product Details</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Product Details</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row gx-lg-5">
                    <div class="col-xl-4 col-md-8 mx-auto">
                        <div class="product-img-slider sticky-side-div">
                            <div class="swiper product-thumbnail-slider p-2 rounded bg-light">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="{{ asset('public/images/product/icon')}}/{{$product->icon }}" alt="" class="img-fluid d-block" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ asset('public/images/product')}}/{{$product->image1 }}" alt="" class="img-fluid d-block" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ asset('public/images/product')}}/{{$product->image2 }}" alt="" class="img-fluid d-block" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ asset('public/images/product')}}/{{$product->image3 }}" alt="" class="img-fluid d-block" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ asset('public/images/product')}}/{{$product->image4 }}" alt="" class="img-fluid d-block" />
                                    </div>
                                </div>
                                <div class="swiper-button-next bg-white shadow"></div>
                                <div class="swiper-button-prev bg-white shadow"></div>
                            </div>
                            <!-- end swiper thumbnail slide -->
                            <div class="swiper product-nav-slider mt-2">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="nav-slide-item">
                                            <img src="{{ asset('public/images/product/icon')}}/{{$product->icon }}" alt="" class="img-fluid d-block" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="nav-slide-item">
                                            <img src="{{ asset('public/images/product')}}/{{$product->image1 }}" alt="" class="img-fluid d-block" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="nav-slide-item">
                                            <img src="{{ asset('public/images/product')}}/{{$product->image2 }}" alt="" class="img-fluid d-block" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="nav-slide-item">
                                            <img src="{{ asset('public/images/product')}}/{{$product->image3 }}" alt="" class="img-fluid d-block" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="nav-slide-item">
                                            <img src="{{ asset('public/images/product')}}/{{$product->image4 }}" alt="" class="img-fluid d-block" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end swiper nav slide -->
                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-8">
                        <div class="mt-xl-0 mt-5">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h4>{{$product->product_name}}</h4>
                                    <div class="hstack gap-3 flex-wrap">
                                        <div><a href="#" class="text-primary d-block">{{$product->brand}}</a></div>
                                        <div class="vr"></div>
                                        @if(isset($product['badge']['badge_name']) !='')
                                        <div style="color:#45cb85;"> <span class=" fw-medium">{{$product['badge']['badge_name']}}</span></div>
                                        @endif
                                        <div class="vr"></div>
                                        <div class="text-muted">Published : <span class="text-body fw-medium">{{$product->updated_at}}</span></div>
                                    </div>
                                </div>
                                {{-- <div class="flex-shrink-0">
                                    <div>
                                        <a href="{{route('product.edit')}}" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="ri-pencil-fill align-bottom"></i></a>
                                    </div>
                                </div> --}}
                            </div>
                            @if($review_count>0)
                            <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
                                <div class="text-muted fs-16">
                                    <span class="mdi mdi-star text-warning"></span>
                                    <span class="mdi mdi-star text-warning"></span>
                                    <span class="mdi mdi-star text-warning"></span>
                                    <span class="mdi mdi-star text-warning"></span>
                                    <span class="mdi mdi-star text-warning"></span>
                                </div>
                                <div class="text-muted">( {{$review_count}} Customer Review )</div>
                            </div>
                            @endif
                            <div class="row mt-4">
                                @if($product && $product->skuNew)
                                @foreach($product['skuNew'] as $row)
                                <div class="col-lg-3 col-sm-6">
                                    <div class="p-2 border border-dashed rounded">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                    <i class="ri-money-dollar-circle-fill"></i>
                                                </div>
                                            </div>
                                           
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">Price :</p>
                                                <h5 class="mb-0">{{$row->price}}</h5>
                                            </div>
                                            <div class="avatar-sm me-2">
                                                <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                    <i class="ri-stack-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">Available Stocks :</p>
                                                <h5 class="mb-0">{{$row->quantity}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                <!-- end col -->
                                {{-- <div class="col-lg-3 col-sm-6">
                                    <div class="p-2 border border-dashed rounded">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                    <i class="ri-file-copy-2-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">No. of Orders :</p>
                                                <h5 class="mb-0">2,234</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- end col -->
                                {{-- <div class="col-lg-3 col-sm-6">
                                    <div class="p-2 border border-dashed rounded">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                    <i class="ri-stack-fill"></i>
                                                </div>
                                            </div>
                                            @foreach($product['sku'] as $row)
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">Available Stocks :</p>
                                                <h5 class="mb-0">{{$row->quantity}}</h5>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- end col -->
                                {{-- <div class="col-lg-3 col-sm-6">
                                    <div class="p-2 border border-dashed rounded">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                    <i class="ri-inbox-archive-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">Total Revenue :</p>
                                                <h5 class="mb-0">$60,645</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- end col -->
                            </div>

                            {{-- <div class="row">
                                <div class="col-xl-6">
                                    <div class="mt-4">
                                        <h5 class="fs-14">Sizes :</h5>
                                        <div class="d-flex flex-wrap gap-2">
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock">
                                                <input type="radio" class="btn-check" name="productsize-radio" id="productsize-radio1" disabled>
                                                <label class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center" for="productsize-radio1">S</label>
                                            </div>

                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="04 Items Available">
                                                <input type="radio" class="btn-check" name="productsize-radio" id="productsize-radio2">
                                                <label class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center" for="productsize-radio2">M</label>
                                            </div>
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="06 Items Available">
                                                <input type="radio" class="btn-check" name="productsize-radio" id="productsize-radio3">
                                                <label class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center" for="productsize-radio3">L</label>
                                            </div>

                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock">
                                                <input type="radio" class="btn-check" name="productsize-radio" id="productsize-radio4" disabled>
                                                <label class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center" for="productsize-radio4">XL</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->

                                <div class="col-xl-6">
                                    <div class=" mt-4">
                                        <h5 class="fs-14">Colors :</h5>
                                        <div class="d-flex flex-wrap gap-2">
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock">
                                                <button type="button" class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-primary" disabled>
                                                    <i class="ri-checkbox-blank-circle-fill"></i>
                                                </button>
                                            </div>
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="03 Items Available">
                                                <button type="button" class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-secondary">
                                                    <i class="ri-checkbox-blank-circle-fill"></i>
                                                </button>
                                            </div>
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="03 Items Available">
                                                <button type="button" class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-success">
                                                    <i class="ri-checkbox-blank-circle-fill"></i>
                                                </button>
                                            </div>
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="02 Items Available">
                                                <button type="button" class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-info">
                                                    <i class="ri-checkbox-blank-circle-fill"></i>
                                                </button>
                                            </div>
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="01 Items Available">
                                                <button type="button" class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-warning">
                                                    <i class="ri-checkbox-blank-circle-fill"></i>
                                                </button>
                                            </div>
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="04 Items Available">
                                                <button type="button" class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-danger">
                                                    <i class="ri-checkbox-blank-circle-fill"></i>
                                                </button>
                                            </div>
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="03 Items Available">
                                                <button type="button" class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-light">
                                                    <i class="ri-checkbox-blank-circle-fill"></i>
                                                </button>
                                            </div>
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="04 Items Available">
                                                <button type="button" class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-dark">
                                                    <i class="ri-checkbox-blank-circle-fill"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div> --}}
                            <!-- end row -->

                            <div class="mt-4 text-muted">
                                <h5 class="fs-14">Description :</h5>
                                <p>{{ $product->short_description }}</p>
                            </div>

                            <div class="row">
                                {{-- <div class="col-sm-6">
                                    <div class="mt-3">
                                        <h5 class="fs-14">Features :</h5>
                                        <ul class="list-unstyled">
                                            <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Full Sleeve</li>
                                            <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Cotton</li>
                                            <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> All Sizes available</li>
                                            <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> 4 Different Color</li>
                                        </ul>
                                    </div>
                                </div> --}}
                                <div class="col-sm-6">
                                    <div class="mt-3">
                                        <h5 class="fs-14">Services :</h5>
                                        <ul class="list-unstyled product-desc-list">
                                            <li class="py-1">10 Days Replacement</li>
                                            <li class="py-1">Cash on Delivery available</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 text-muted">
                                <h5 class="fs-14">Category :</h5>
                                <p>{{ $product->category->category_name }}</p>
                            </div>

                            <div class="product-content mt-5">
                                <h5 class="fs-14 mb-3">Product Description :</h5>
                                <nav>
                                    <ul class="nav nav-tabs nav-tabs-custom nav-success" id="nav-tab" role="tablist">
                                        {{--
                                        <li class="nav-item">
                                            <a class="nav-link active" id="nav-speci-tab" data-bs-toggle="tab" href="#nav-speci" role="tab" aria-controls="nav-speci" aria-selected="true">Specification</a>
                                        </li>
                                        --}}
                                        <li class="nav-item">
                                            <a class="nav-link active" id="nav-detail-tab" data-bs-toggle="tab" href="#nav-detail" role="tab" aria-controls="nav-detail" aria-selected="true">Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="nav-variants-tab" data-bs-toggle="tab" href="#nav-varia" role="tab" aria-controls="nav-varia" aria-selected="false">Variants</a>
                                        </li>
                                    </ul>
                                </nav>
                                <div class="tab-content border border-top-0 p-4" id="nav-tabContent">
                                    {{--
                                    <div class="tab-pane fade show active" id="nav-speci" role="tabpanel" aria-labelledby="nav-speci-tab">
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" style="width: 200px;">Category</th>
                                                        <td>T-Shirt</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Brand</th>
                                                        <td>Tommy Hilfiger</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Color</th>
                                                        <td>Blue</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Material</th>
                                                        <td>Cotton</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Weight</th>
                                                        <td>140 Gram</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>--}}
                                    
                                    <div class="tab-pane fade show active" id="nav-detail" role="tabpanel" aria-labelledby="nav-detail-tab">
                                        <div>
                                            <h5 class="font-size-16 mb-3">{{ $product->product_name }}</h5>
                                            <p>{!!$product->description !!}</p>
                                            {{-- <div>
                                                <p class="mb-2"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Machine Wash</p>
                                                <p class="mb-2"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Fit Type: Regular</p>
                                                <p class="mb-2"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> 100% Cotton</p>
                                                <p class="mb-0"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Long sleeve</p>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="tab-pane fade " id="nav-varia" role="tabpanel" aria-labelledby="nav-variants-tab">
                                        {{-- <ul class="list-group list-group-flush list-group-custom">
				                                         
                                            @php $c=1;@endphp
                                          @foreach($product['sku'] as $row)
                                           

                                           <li class="list-group-item d-flex px-0">
                                             
                                               <div class="flex-fill ms-3">
                                                   <div class="row">
                                                       <h6 class="mb-0 text primary">{{$c++}} . <strong>{{$row->combination_set}}</strong></h6>
                                                       <div class="col-md-6  mt-2">
                                                           
                                                           <h6>Details</h6>

                                                           @foreach($row['sku_values'] as $val)
                                                       
                                                   
                                                           <h6 class="mb-0"><strong class="d-block">
                                                               {{App\Models\Variants::get_variant_atr_name($val->variant_id) }} :
                                                               {{App\Models\VariantOptions::get_option_names($val->variant_option_id) }}</strong></h6>

                                                       
                                                      
                                                           @endforeach
                                                       </div>
                                                       <div class="col-md-3 mt-2" >
                                                       
                                                           <i class="fa fa-inr text-primary"> <span class="float-left"> Price :{{ $row->price}}</span> </i><br>
                                                           <i class="fa fa-inr text-primary"> <span class="float-left">Special Price :{{ $row->special_price}}</span></i><br>
                                                       
                                                       </div>
                                                        <div class="col-md-3  mt-2">
                                                            <i class="fa fa-star text-primary">
                                                            <span class="float-left">Sku :{{ $row->sku}}</span>
                                                           </i><br>
                                                           <i class="fa fa-cubes text-primary"> <span class="float-left">Quantity :{{ $row->quantity}}</span></i><br>
                                                           <i class="fa fa-file text-primary"> <span class="float-left">{{ $row->stock_status}}</span></i>
                                                        </div>
                                                        <div class="col-md-3  mt-2">
                                                            <i class="fa fa-star text-primary">
                                                            <span class="float-left">Img</span>
                                                        </div>
                                                   </div>
                                                   
                                                   
                                                   
                                               
                                                 
                                               </div>
                                           </li>
                                      
                                           @endforeach
                                       </ul> --}}
                                       <table class="table table-bordered" >
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Combination Set</th>
                                                <th>Details</th>
                                                <th>Price</th>
                                                <th>Special Price</th>
                                                <th>Sku</th>
                                                <th>Quantity</th>
                                                <th>Stock Status</th>
                                                <th>Image</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $c=1; @endphp
                                            @if($product && $product->skuNew)
                                            @foreach($product['skuNew'] as $row)
                                            <tr>
                                                <td>{{ $c++ }}</td>
                                                <td>{{ $row->combination_set }}</td>
                                                <td>
                                                    <ul>
                                                        @foreach($row['sku_values'] as $val)
                                                            <li><strong>{{ App\Models\Variants::get_variant_atr_name($val->variant_id) }}:</strong> {{ App\Models\VariantOptions::get_option_names($val->variant_option_id) }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>{{ $row->price }}</td>
                                                <td>{{ $row->special_price }}</td>
                                                <td>{{ $row->sku }}</td>
                                                <td>{{ $row->quantity }}</td>
                                                <td>{{ $row->stock_status }}</td>
                                                <td>
                                                    <button type="button"
                                                            class="btn btn-outline-primary btn-sm view_image"
                                                            data-bs-toggle="offcanvas"
                                                            data-bs-target="#offcanvasExample"
                                                            aria-controls="offcanvasExample"
                                                            data-id="{{ $row->id }}">
                                                        <i class="fas fa-image fa-lg"></i>
                                                    </button>
                                                </td>

                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    
                                    </div>
                                </div>
                            </div>
                            <!-- product-content -->
                            @if($review_count>0)
                            <div class="mt-5">
                                <div>
                                    <h5 class="fs-14 mb-3">Ratings & Reviews</h5>
                                </div>
                                <div class="row gy-4 gx-0">
                                    <div class="col-lg-4">
                                        <div>
                                           
                                            <div class="pb-3">
                                                <div class="bg-light px-3 py-2 rounded-2 mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1">
                                                            <div class="fs-16 align-middle text-warning">
                                                                
                                                                <i class="ri-star-fill"></i>
                                                                <i class="ri-star-fill"></i>
                                                                <i class="ri-star-fill"></i>
                                                                <i class="ri-star-fill"></i>
                                                                <i class="ri-star-half-fill"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <h6 class="mb-0">4.5 out of 5</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <div class="text-muted">Total <span class="fw-medium">{{$review_count}}</span> reviews
                                                    </div>
                                                </div>
                                            </div>
                                           

                                            <div class="mt-3">
                                                <div class="row align-items-center g-2">
                                                    <div class="col-auto">
                                                        <div class="p-2">
                                                            <h6 class="mb-0">5 star</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="p-2">
                                                            <div class="progress bg-soft-success animated-progress progress-sm">
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: 50.16%" aria-valuenow="50.16" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="p-2">
                                                            <h6 class="mb-0 text-muted">{{$review5}}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end row -->

                                                <div class="row align-items-center g-2">
                                                    <div class="col-auto">
                                                        <div class="p-2">
                                                            <h6 class="mb-0">4 star</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="p-2">
                                                            <div class="progress bg-soft-success animated-progress progress-sm">
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: 19.32%" aria-valuenow="19.32" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="p-2">
                                                            <h6 class="mb-0 text-muted">{{$review4}}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end row -->

                                                <div class="row align-items-center g-2">
                                                    <div class="col-auto">
                                                        <div class="p-2">
                                                            <h6 class="mb-0">3 star</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="p-2">
                                                            <div class="progress bg-soft-success animated-progress progress-sm">
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: 18.12%" aria-valuenow="18.12" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="p-2">
                                                            <h6 class="mb-0 text-muted">{{$review3}}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end row -->

                                                <div class="row align-items-center g-2">
                                                    <div class="col-auto">
                                                        <div class="p-2">
                                                            <h6 class="mb-0">2 star</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="p-2">
                                                            <div class="progress bg-soft-warning animated-progress progress-sm">
                                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 7.42%" aria-valuenow="7.42" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-auto">
                                                        <div class="p-2">
                                                            <h6 class="mb-0 text-muted">{{$review2}}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end row -->

                                                <div class="row align-items-center g-2">
                                                    <div class="col-auto">
                                                        <div class="p-2">
                                                            <h6 class="mb-0">1 star</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="p-2">
                                                            <div class="progress bg-soft-danger animated-progress progress-sm">
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 4.98%" aria-valuenow="4.98" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="p-2">
                                                            <h6 class="mb-0 text-muted">{{$review1}}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end row -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->

                                    <div class="col-lg-8">
                                        <div class="ps-lg-4">
                                            <div class="d-flex flex-wrap align-items-start gap-3">
                                                <h5 class="fs-14">Reviews: </h5>
                                            </div>

                                            <div class="me-lg-n3 pe-lg-4" data-simplebar style="max-height: 225px;">
                                                @if ($review_count > 0)
                                                <ul class="list-unstyled mb-0">
                                                    @foreach ($reviews as $row)
                                                    <li class="py-2">
                                                        <div class="border border-dashed rounded p-3">
                                                            <div class="d-flex align-items-start mb-3">
                                                                <div class="hstack gap-3">
                                                                    <div class="badge rounded-pill bg-success mb-0">
                                                                        <i class="mdi mdi-star"></i> {{$row->rating}}
                                                                    </div>
                                                                    <div class="vr"></div>
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-muted mb-0"> {{ $row->comment }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                    

                                                            <div class="d-flex align-items-end">
                                                                <div class="flex-grow-1">
                                                                    <h5 class="fs-14 mb-0">{{ $row->name }}</h5>
                                                                </div>

                                                                <div class="flex-shrink-0">
                                                                    <p class="text-muted fs-13 mb-0">12 Jul, 21</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                   

                                                </ul>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end Ratings & Reviews -->
                            </div>
                            @endif
                            <!-- end card body -->
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>




<!--this is for the off canvas page -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <h5 id="offcanvasExampleLabel">Variant Image</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body" id="product_images">
    <p>Loading image...</p>
  </div>
</div>
@endsection
@section('scripts')




<script>
$(document).ready(function () {
    $('.view_image').on('click', function () {
        var skuId = $(this).data('id');
        $('#product_images').html('<p>Loading image...</p>');

        $.ajax({
            url: '{{ route("get_product_image") }}',
            type: 'GET',
            data: { id: skuId },
            success: function (response) {
                $('#product_images').html(response.html);
            },
            error: function () {
                $('#product_images').html('<p class="text-danger">Failed to load image.</p>');
            }
        });
    });
});
</script>

@endsection