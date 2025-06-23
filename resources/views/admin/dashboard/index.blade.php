@extends('layouts.adminlayout')
@section('content')



        <div class="row">
            <div class="col">

                <div class="h-100">
                    <div class="row mb-3 pb-1">
                        <div class="col-12">
                            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                <div class="flex-grow-1">
                                    <h4 class="fs-16 mb-1">Good Morning, Anna!</h4>
                                    <p class="text-muted mb-0">Here's what's happening with your store today.</p>
                                </div>
                                <div class="mt-3 mt-lg-0">
                                    <form action="javascript:void(0);">
                                        <div class="row g-3 mb-0 align-items-center">
                                            <div class="col-sm-auto">
                                                <div class="input-group">
                                                    <div class="input-group-text bg-primary border-primary text-white">
                                                        <i class="ri-calendar-2-line"></i>
                                                    </div>
                                                    <input type="text" class="form-control border-0 shadow" value="{{ date('d M, Y') }}" readonly>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-auto">
                                                <a href="{{ route('product.index') }}" class="btn btn-soft-success shadow-none">
                                                    <i class="ri-add-circle-line align-middle me-1"></i> Add Product
                                                </a>
                                            </div>
                                            <!--end col-->
                                            <div class="col-auto">
                                                <button type="button" class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn shadow-none"><i class="ri-pulse-line"></i></button>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>
                            </div><!-- end card header -->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->

                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Total Earnings</p>
                                        </div>
                                        <!--
                                            <div class="flex-shrink-0">
                                                <h5 class="text-success fs-14 mb-0">
                                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +16.24 %
                                                </h5>
                                            </div>
                                        -->
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">₹ <span class="counter-value" data-target="{{$orderearnings}}">0</span>k </h4>
                                            <a href="{{ route('sales-report')}}" class="text-decoration-underline">View net earnings</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success rounded fs-3">
                                                <i class="bx bx-dollar-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Orders</p>
                                        </div>
                                        <!--
                                        <div class="flex-shrink-0">
                                           <h5 class="text-danger fs-14 mb-0">
                                                <i class="ri-arrow-right-down-line fs-13 align-middle"></i> -3.57 %
                                           </h5>
                                        </div>
                                        -->
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{$orderCount}}">0</span></h4>
                                            <a href="{{route('orders.index')}}" class="text-decoration-underline">View all orders</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-info rounded fs-3">
                                                <i class="bx bx-shopping-bag"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Customers</p>
                                        </div>
                                        <!--
                                        <div class="flex-shrink-0">
                                            <h5 class="text-success fs-14 mb-0">
                                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +29.08 %
                                            </h5>
                                        </div>
                                        -->
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{$customerCount}}">0</span></h4>
                                            <a href="{{ route('customers.index')}}" class="text-decoration-underline">See details</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-warning rounded fs-3">
                                                <i class="bx bx-user-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Products</p>
                                        </div>
                                        <!--
                                        <div class="flex-shrink-0">
                                            <h5 class="text-muted fs-14 mb-0">
                                                +0.00 %
                                            </h5>
                                        </div>
                                        -->
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{$productCount}}">0</span></h4>
                                            <a href="{{ url('product')}}" class="text-decoration-underline"> My products</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-danger rounded fs-3">
                                                <i class="bx bx-wallet"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div> <!-- end row-->

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Revenue</h4>
                                    <div>
                                       <button type="button" id="all" class="btn btn-soft-secondary btn-sm shadow-none filter-btn">
                                            ALL
                                        </button>
                                        <button type="button" id="1m" class="btn btn-soft-secondary btn-sm shadow-none filter-btn">
                                            1M
                                        </button>
                                        <button type="button" id="6m" class="btn btn-soft-secondary btn-sm shadow-none filter-btn">
                                            6M
                                        </button>
                                        <button type="button" id="1y" class="btn btn-soft-primary btn-sm shadow-none filter-btn">
                                            1Y
                                        </button>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-header p-0 border-0 bg-soft-light">
                                    <div class="row g-0 text-center">
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1"><span class="counter-value" data-target="{{$successorderCount}}">0</span></h5>
                                                <p class="text-muted mb-0">Successfull Orders</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1">$<span class="counter-value" data-target="{{$orderearnings}}">0</span>k</h5>
                                                <p class="text-muted mb-0">Earnings</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1"><span class="counter-value" data-target="{{$cancelorderCount}}">0</span></h5>
                                                <p class="text-muted mb-0">Canceled</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0 border-end-0">
                                                <h5 class="mb-1 text-success"><span class="counter-value" data-target="{{$transactionRatio}}">0</span>%</h5>
                                                <p class="text-muted mb-0">Conversation Ratio</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body p-0 pb-2">
                                    <div class="w-100">
                                        <div id="customer_charts" class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                    </div>

                </div> <!-- end .h-100-->

            </div> <!-- end col -->

            <div class="col-auto layout-rightside-col">
                <div class="overlay"></div>
                <div class="layout-rightside">
                    <div class="card h-100 rounded-0">
                        <div class="card-body p-0">
                            <div class="p-3">
                                <h6 class="text-muted mb-0 text-uppercase fw-semibold">Top Trending Products</h6>
                            </div>
                            <div data-simplebar style="max-height: 410px;" class="p-3 pt-0">
                                 <ol class="ps-3 text-muted">
                                    @foreach($trendingProducts as $product)
                                        <li class="py-1">
                                            <a href="#" class="text-muted">{{$product->product_name}}</a>
                                            <span class="float-end">({{ $product->order_items_count }})</span>
                                        </li>
                                    @endforeach
                                   
                                </ol>
                            </div>

                            
                            <div class="p-3">
                                <h6 class="text-muted mb-3 text-uppercase fw-semibold">Products Reviews</h6>
                                <!-- Swiper -->
                                <div class="swiper vertical-swiper" style="height: 250px;">
                                    <div class="swiper-wrapper">
                                        
                                        @foreach($reviews as $review)
                                            <div class="swiper-slide">
                                                <div class="card border border-dashed shadow-none">
                                                    <div class="card-body">
                                                        <div class="d-flex">
                                                            <div class="flex-shrink-0 avatar-sm">
                                                                <div class="avatar-title bg-light rounded shadow">
                                                                    <img src="{{ asset('public/logo/user-dummy-img.jpg') }}" alt="" height="30">
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <div>
                                                                    <p class="text-muted mb-1 fst-italic text-truncate-two-lines"> "{{$review->comment}}. "</p>
                                                                    <div class="fs-11 align-middle text-warning">
                                                                         @for ($i = 0; $i < $review->rating; $i++)
                                                                            <i class="ri-star-fill"></i>
                                                                        @endfor
                                                                        @for ($i = $review->rating; $i < 5; $i++)
                                                                            <i class="ri-star-line"></i>
                                                                        @endfor
                                                                    </div>
                                                                </div>
                                                                <div class="text-end mb-0 text-muted">
                                                                    - by <cite title="Source Title">{{$review->name}}</cite>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        
                                      
                                        
                                    </div>
                                </div>
                            </div>

                           

                            

                        </div>
                    </div> <!-- end card-->
                </div> <!-- end .rightbar-->

            </div> <!-- end col -->
        </div>

    
@endsection

@section('scripts')

<script>
    $(document).ready(function() 
    {
        let chart;

        function fetchAndRenderChart(period = 'all') 
        {
            $.ajax
            ({
                url: "{{ route('monthlyStats') }}",
                type: 'GET',
                data: { period: period },
                dataType: 'json',
                success: function(data) 
                {
                    const months = data.map(item => item.month);
                    const totalamountcomes = data.map(item => item.totalamountcomes);
                    const successOrders = data.map(item => item.success_orders);
                    const cancelledOrders = data.map(item => item.cancelled_orders);
    
    
                    let barWidth = '50%'; 
                
                    if (period === '1m') 
                    {
                        barWidth = '10%';                                   
                    }
                    const options = 
                        {
                            chart: 
                            {
                                height: 350,
                                type: 'line',
                                stacked: false,
                                toolbar: { show: false }
                            },
                            
                            stroke: 
                            {
                                width: [0, 3, 3],
                                curve: 'straight',
                                dashArray: [0, 0, 5]
                            },
                            
                            plotOptions: { bar: { columnWidth: barWidth } },
                            colors: ['#6a5acd', '#28a745', '#dc3545'],
                            
                            series: 
                            [
                                { name: 'Total Amount', type: 'bar', data: totalamountcomes },
                                { name: 'Success Amount', type: 'line', data: successOrders },
                                { name: 'Cancelled Amount', type: 'line', data: cancelledOrders }
                            ],
                            
                            fill: { opacity: [0.9, 1, 1] },
                            labels: months,
                            markers: { size: 4 },
                            
                            xaxis: { type: 'category', categories: months },
                            
                            yaxis: 
                            [{
                                title: { text: 'Amount' },
                                min: 0,
                                tickAmount: 6,
                                labels: 
                                {
                                    formatter: val => val >= 1000 ? (val / 1000).toFixed(1) + 'K' : val.toFixed(0)
                                }
                            }],
                            
                            tooltip: 
                            {
                                shared: true,
                                intersect: false,
                                y: {
                                    formatter: val => val >= 1000 ? (val / 1000).toFixed(1) + 'K' : val
                                }
                            },
                            legend: 
                            {
                                show: true,
                                position: 'top',
                                horizontalAlign: 'center'
                            }
                        };
        
                        if (chart) 
                        {
                            chart.updateOptions({
                                series: options.series,
                                labels: options.labels,
                                plotOptions: options.plotOptions
                            });
                        } 
                        
                        else 
                        {
                            chart = new ApexCharts(document.querySelector("#customer_charts"), options);
                            chart.render();
                        }
                },
                error: function(xhr, status, error) 
                {
                console.error('Failed to fetch monthly stats:', error);
                }
            });
        
        }

        fetchAndRenderChart();

        $(document).on('click', '.filter-btn', function() 
        {
            const period = this.id; 
            fetchAndRenderChart(period);
            $('.filter-btn').removeClass('btn-soft-primary').addClass('btn-soft-secondary');
            $(this).removeClass('btn-soft-secondary').addClass('btn-soft-primary');
        });

    });



</script>

@endsection



