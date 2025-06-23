@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">View Order</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('order') }}">Orders  List</a></li>
                        <li class="breadcrumb-item active">View Order</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">Order #{{ $data->order_no }}</h5>
                        {{-- <div class="flex-shrink-0">
                            <a href="" class="btn btn-success btn-sm"><i class="ri-download-2-fill align-middle me-1"></i> Invoice</a>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap align-middle table-borderless mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col">Product Details</th>
                                    <th scope="col">Item Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Rating</th>
                                    <th scope="col" class="text-end">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['orderItems'] as $row)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                <img src="{{ $row['thumbnail'] ?? ''}}" alt="" class="img-fluid d-block">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="fs-15"><a href="" class="link-primary">{{ $row['product_name'] }}</a></h5>
                                                {{-- <p class="text-muted mb-0">Color: <span class="fw-medium">Pink</span></p>
                                                <p class="text-muted mb-0">Size: <span class="fw-medium">M</span></p> --}}
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $row['special_price'] }}</td>
                                    <td>{{ $row['qty'] }}</td>
                                    <td>
                                        <div class="text-warning fs-15">
                                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-half-fill"></i>
                                        </div>
                                    </td>
                                    <td class="fw-medium text-end">
                                        {{ $row['total'] }}
                                    </td>
                                </tr>
                                @endforeach
                                
                                <!--for shipping charge-->
                                <tr  class="bg-light">
                                    <td>
                                        <div class="d-flex">
                                            
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="fs-15">
                                                    <a href="#" class="link-primary">
                                                        
                                                        Shipping Charge
                                                    </a>
                                                </h5>
                                            </div>
                                        </div>
                                    </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td class="fw-medium text-end">
                                        @if($data->shipping_charge)
                                            {{$data->shipping_charge}}
                                        @endif
                                    </td>
                                </tr>
                                
                                
                                <!--offer product details-->
                                @if ($offer_product)
                                    <tr  class="bg-light">
                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                    <img src="{{ $offer_product->sku_images[0]->image ?? '' }}" alt="" class="img-fluid d-block">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="fs-15">
                                                        <a href="#" class="link-primary">
                                                            
                                                            {{$product->product_name}}({{ $offer_product->sku}})
                                                        </a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $offer_product->special_price ?? $offer_product->price }}</td>
                                        <td>1</td>
                                        <td>
                                            <div class="text-warning fs-15">
                                                <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-half-fill"></i>
                                            </div>
                                        </td>
                                        <td class="fw-medium text-end">
                                            <del>{{ $offer_product->special_price ?? $offer_product->price }}</del>
                                        </td>
                                    </tr>
                                @endif
                                
                                
                                
                                <tr class="border-top border-top-dashed">
                                    <td colspan="3"></td>
                                    <td colspan="2" class="fw-medium p-0">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <td>Sub Total :</td>
                                                    <td class="text-end"> {{ $data->total_amount }}</td>
                                                </tr>
                                                {{-- <tr>
                                                    <td>Discount <span class="text-muted">(VELZON15)</span> : :</td>
                                                    <td class="text-end">-$53.99</td>
                                                </tr>
                                                <tr>
                                                    <td>Shipping Charge :</td>
                                                    <td class="text-end">$65.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Estimated Tax :</td>
                                                    <td class="text-end">$44.99</td>
                                                </tr> --}}
                                                <tr class="border-top border-top-dashed">
                                                    <th scope="row">Total (INR) :</th>
                                                    <th class="text-end"> {{ $data->total_amount }}</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end card-->
            <div class="card">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">Order Status</h5>
                        <div class="flex-shrink-0 mt-2 mt-sm-0">
                            {{-- <a href="javasccript:void(0;)" class="btn btn-soft-info btn-sm mt-2 mt-sm-0 shadow-none"><i class="ri-map-pin-line align-middle me-1"></i> Change Address</a>
                            <a href="javasccript:void(0;)" class="btn btn-soft-danger btn-sm mt-2 mt-sm-0 shadow-none"><i class="mdi mdi-archive-remove-outline align-middle me-1"></i> Cancel Order</a> --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="profile-timeline">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                             @if($data->delivery_status=="processing") 
                            <div class="accordion-item border-0">
                                <div class="accordion-header" id="headingOne">
                                    <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 avatar-xs">
                                                <div class="avatar-title bg-success rounded-circle shadow">
                                                    <i class="ri-shopping-bag-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-15 mb-0 fw-semibold">Order Placed - <span class="fw-normal">{{ date('D, d M Y', strtotime($data->created_at)) }}</span></h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body ms-2 ps-5 pt-0">
                                        <h6 class="mb-1">An order has been placed.</h6>
                                        <p class="text-muted">  {{ date('D, d M Y - h:ia', strtotime($data->updated_at)) }}</p>

                                        {{-- <h6 class="mb-1">Seller has proccessed your order.</h6>
                                        <p class="text-muted mb-0">Thu, 16 Dec 2021 - 5:48AM</p> --}}
                                    </div>
                                </div>
                            </div>
                             @elseif($data->delivery_status=="on transit") 
                            <div class="accordion-item border-0">
                                <div class="accordion-header" id="headingTwo">
                                    <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 avatar-xs">
                                                <div class="avatar-title bg-success rounded-circle shadow">
                                                    <i class="mdi mdi-gift-outline"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-15 mb-1 fw-semibold">Packed </h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body ms-2 ps-5 pt-0">
                                        <h6 class="mb-1">Your Item has been picked up by courier patner</h6>
                                        <p class="text-muted mb-0"> {{ date('D, d M Y - h:ia', strtotime($data->updated_at)) }}</p>
                                    </div>
                                </div>
                            </div>
                            @elseif($data->delivery_status=="out for Delivery") 
                            <div class="accordion-item border-0">
                                <div class="accordion-header" id="headingThree">
                                    <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 avatar-xs">
                                                <div class="avatar-title bg-success rounded-circle shadow">
                                                    <i class="ri-truck-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-15 mb-1 fw-semibold">Shipping</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body ms-2 ps-5 pt-0">
                                        {{-- <h6 class="fs-14">RQK Logistics - MFDS1400457854</h6> --}}
                                        <h6 class="mb-1">Your item has been shipped.</h6>
                                        <p class="text-muted mb-0"> {{ date('D, d M Y - h:ia', strtotime($data->updated_at)) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border-0">
                                <div class="accordion-header" id="headingFour">
                                    <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseFour" aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 avatar-xs">
                                                <div class="avatar-title bg-success  rounded-circle shadow">
                                                    <i class="ri-takeaway-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-14 mb-0 fw-semibold">Out For Delivery</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div id="collapseFour" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body ms-2 ps-5 pt-0">
                                        {{-- <h6 class="fs-14">RQK Logistics - MFDS1400457854</h6> --}}
                                        <h6 class="mb-1">Your item has been Out For Delivery</h6>
                                        <p class="text-muted mb-0"> {{ date('D, d M Y - h:ia', strtotime($data->updated_at)) }}</p>
                                    </div>
                                </div>
                            </div>
                            @elseif($data->delivery_status=="delivered") 
                            <div class="accordion-item border-0">
                                <div class="accordion-header" id="headingFive">
                                    <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseFile" aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 avatar-xs">
                                                <div class="avatar-title bg-success  rounded-circle shadow">
                                                    <i class="mdi mdi-package-variant"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-14 mb-0 fw-semibold">Delivered</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div id="collapseFive" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body ms-2 ps-5 pt-0">
                                        {{-- <h6 class="fs-14">RQK Logistics - MFDS1400457854</h6> --}}
                                        <h6 class="mb-1">Your item has been Delivered</h6>
                                        <p class="text-muted mb-0"> {{ date('D, d M Y - h:ia', strtotime($data->updated_at)) }}</p>
                                    </div>
                                </div>
                            </div>
                            @elseif($data->delivery_status=="cancelled")
                            <div class="accordion-item border-0">
                                <div class="accordion-header" id="headingFive">
                                    <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseFile" aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 avatar-xs">
                                                <div class="avatar-title bg-success  rounded-circle shadow">
                                                    <i class="mdi mdi-package-variant"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-14 mb-0 fw-semibold">Cancelled</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div id="collapseFive" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body ms-2 ps-5 pt-0">
                                        {{-- <h6 class="fs-14">RQK Logistics - MFDS1400457854</h6> --}}
                                        <h6 class="mb-1">Item has been Cancelled</h6>
                                        <p class="text-muted mb-0"> {{ date('D, d M Y - h:ia', strtotime($data->updated_at)) }}</p>
                                    </div>
                                </div>
                                
                            </div>
                            @endif
                        </div>
                        <!--end accordion-->
                    </div>
                </div>
            </div>
            <!--end card-->
            <div class="col-md-12 text-end">
                @php
                    $from = request()->get('from');
                @endphp
            
                @if($from === 'salesreport')
                    <a class="btn btn-secondary" href="{{ route('sales-report') }}">Back</a>
                @else
                    <a class="btn btn-secondary" href="{{ route('orders.index') }}">Back</a>
                @endif
            </div>
        </div>
        <!--end col-->
        
        
        
        <div class="col-xl-3">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <h5 class="card-title flex-grow-1 mb-0"><i class="mdi mdi-truck-fast-outline align-middle me-1 text-muted"></i> Logistics Details</h5>
                        {{-- <div class="flex-shrink-0">
                            <a href="javascript:void(0);" class="badge badge-soft-primary fs-11">Track Order</a>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <lord-icon src="https://cdn.lordicon.com/uetqnvvg.json" trigger="loop" colors="primary:#4b38b3,secondary:#0ab39c" style="width:80px;height:80px"></lord-icon>
                        <h5 class="fs-16 mt-2">Lagro Furniture</h5>
                        <p class="text-muted mb-0">ID: {{$data->order_no}}</p>
                        <p class="text-muted mb-0">Payment Mode : {{ $data->payment_method }}</p>
                    </div>
                </div>
            </div>
            <!--end card-->

            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <h5 class="card-title flex-grow-1 mb-0">Customer Details</h5>
                        <div class="flex-shrink-0">
                            {{-- <a href="javascript:void(0);" class="link-secondary">View Profile</a> --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 vstack gap-3">
                        <li>
                            <div class="d-flex align-items-center">
                                {{-- <div class="flex-shrink-0">
                                    <img src="assets/images/users/avatar-3.jpg" alt="" class="avatar-sm rounded shadow">
                                </div> --}}
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">{{ $data->customer_name }}</h6>
                                    <p class="text-muted mb-0">Customer</p>
                                </div>
                            </div>
                        </li>
                        <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{ $data->customer_email }}</li>
                        <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{ $data->customers->address}}</li>
                        <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{ $data->customer_phone }}</li>
                    </ul>
                </div>
            </div>
            <!--end card-->
            {{-- <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i> Billing Address</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                        <li class="fw-medium fs-14">Joseph Parker</li>
                        <li>+(256) 245451 451</li>
                        <li>2186 Joyce Street Rocky Mount</li>
                        <li>New York - 25645</li>
                        <li>United States</li>
                    </ul>
                </div>
            </div> --}}
            <!--end card-->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i> Shipping Address</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                        <li class="fw-medium fs-14">{{ $data->customer_name }}</li>
                        <li>{{ $data->address}}
                            </li>
                        <li>{{ $data->customer_pincode}}</li>
                        <li>{{ $data->customer_phone }}</li>
                        {{-- <li>United States</li> --}}
                    </ul>
                </div>
            </div>
            <!--end card-->
            {{--
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i> Payment Details</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">Transactions:</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">#VLZ124561278124</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">Payment Method:</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">Debit Card</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">Card Holder Name:</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">Joseph Parker</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">Card Number:</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">xxxx xxxx xxxx 2456</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">Total Amount:</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">$415.96</h6>
                        </div>
                    </div>
                </div>
            </div>
            
            --}}
            <!--end card-->
        </div>
        <!--end col-->
    </div>
   
    @endsection
    @section('scripts')
    <script>
     $(document).ready(function(){
        // Assuming you have a JavaScript variable `deliveryStatus` set to the delivery status
        var deliveryStatus = "{{ $data->delivery_status }}";

        if (deliveryStatus === "delivered") {
            // Show the desired accordion items
            $('#collapseOne').addClass('show');
            $('#collapseTwo').addClass('show');
            $('#collapseThree').addClass('show');
            $('#collapseFour').addClass('show');
        }
    });
    </script>
    @endsection