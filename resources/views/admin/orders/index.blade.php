@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Orders</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Orders</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-md-4">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Processing</p>
                        </div>
                        {{-- <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0">
                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +16.24 %
                            </h5>
                        </div> --}}
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ App\Models\Orders::getOrderProcessingCount() }}">0</span></h4>
                            {{-- <a href="" class="text-decoration-underline">View net earnings</a> --}}
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary rounded fs-3">
                                <i class="bx bx-loader-alt"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-4">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">On Transit</p>
                        </div>
                        {{-- <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0">
                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +29.08 %
                            </h5>
                        </div> --}}
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ App\Models\Orders::getOrderCount('on transit') }}">0</span></h4>
                            {{-- <a href="" class="text-decoration-underline">See details</a> --}}
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning rounded fs-3">
                                <i class="ri-truck-line"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-4">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Out For Delivery</p>
                        </div>
                        {{-- <div class="flex-shrink-0">
                            <h5 class="text-danger fs-14 mb-0">
                                <i class="ri-arrow-right-down-line fs-13 align-middle"></i> -3.57 %
                            </h5>
                        </div> --}}
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ App\Models\Orders::getOrderCount('out for delivery') }}">0</span></h4>
                            {{-- <a href="" class="text-decoration-underline">View all orders</a> --}}
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

        <div class="col-xl-3 col-md-4">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Delivered</p>
                        </div>
                        {{-- <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0">
                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +29.08 %
                            </h5>
                        </div> --}}
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ App\Models\Orders::getOrderCount('delivered') }}">0</span></h4>
                            {{-- <a href="" class="text-decoration-underline">See details</a> --}}
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success rounded fs-3">
                                <i class="bx bx-check-circle"></i>
                            </span>
                            
                            
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
        
        <div class="col-xl-3 col-md-4">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Cancelled</p>
                        </div>
                        {{-- <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0">
                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +29.08 %
                            </h5>
                        </div> --}}
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ App\Models\Orders::getOrderCount('cancelled') }}">0</span></h4>
                            {{-- <a href="" class="text-decoration-underline">See details</a> --}}
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-danger rounded fs-3">
                                <i class="bx bx-x-circle"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

       <!-- end col -->
    </div> 
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">

                    <div class="row g-4 align-items-center">
                       
                        <h4 class="mb-sm-0">Orders</h4>
                        <div class="col-sm-auto ms-auto">
                            <div class="hstack gap-2">
                                
                                <button type="button" class="btn btn-info" data-bs-toggle="offcanvas" href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i> Fliters</button>
                               
                                
                                {{-- <a href="{{ route('badge.create')}}" class="btn btn-success"><i class="ri-add-line align-bottom me-1"></i>Add New Badge </a> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="orderTable" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10px;">
                                    <div class="form-check">
                                        <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>

                                <th>SR No.</th>
                                <th>Order</th>
                                <th>Name</th>
                                <th>Shipping Charge</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Delivery Status</th>
                                <th>Cancel Status</th>
                               
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>


                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample"
                        aria-labelledby="offcanvasExampleLabel">
                        <div class="offcanvas-header bg-light">
                            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Order Fliters</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <!--end offcanvas-header-->
                        <form id="filter-form" class="d-flex flex-column justify-content-end h-100">
                            <div class="offcanvas-body">
                                <div class="mb-4">
                                    <label for="datepicker-range"
                                        class="form-label text-muted text-uppercase fw-semibold mb-3"> Name</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        data-provider="flatpickr" data-range="true" placeholder="Name">
                                </div>
                                <div class="mb-4">
                                    <label for="datepicker-range"
                                        class="form-label text-muted text-uppercase fw-semibold mb-3">Order No</label>
                                    <input type="text" class="form-control" name="order_no" id="order_no"
                                        data-provider="flatpickr" data-range="true" >
                                </div>
                            <div class="mb-4">
                                <label for="country-select" class="form-label text-muted text-uppercase fw-semibold mb-3">Status</label>
                                <select class="form-control" data-choices data-choices-multiple-remove="true" name="status" id="status1">
                                    <option value="all" selected>ALL</option>
                                    <option value="pending">pending</option>
                                    <option value="accepted">accepted</option>
                                    <option value="rejected">Rejected</option>
                                    
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="country-select" class="form-label text-muted text-uppercase fw-semibold mb-3">Delivery Status</label>
                                <select class="form-control" data-choices data-choices-multiple-remove="true" name="delivery_status" id="delivery_status" >
                                    <option value="all" selected>ALL</option>
                                    <option value="processing">Processing</option>
                                    <option value="on transit">On transit</option>
                                    <option value="out for delivery">Out for delivery</option>
                                    <option value="delivered">Delivered</option>
                                     <option value="cancelled">cancelled</option>
                                    
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="country-select" class="form-label text-muted text-uppercase fw-semibold mb-3">Cancel Status</label>
                                <select class="form-control" data-choices data-choices-multiple-remove="true" name="cancel_status" id="cancel_status" >
                                    <option value="all" selected>ALL</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                    
                                </select>
                            </div>

                            </div>
                            <!--end offcanvas-body-->
                            <div class="offcanvas-footer border-top p-3 text-center hstack gap-2">
                                <button type="button" class="btn btn-light w-100" id="resetBtn">Clear Filter</button>
                                <button type="button" class="btn btn-success w-100" id="filterBtn">Filters</button>
                            </div>
                            <!--end offcanvas-footer-->
                        </form>
                    </div>
                   
                </div>
            </div>
        </div>
        
    </div>
    
@endsection
@section('scripts')
  
    <script>
        var tableX = $('#orderTable').DataTable({
            ajax: {
                url: "{{ url('filter_order') }}",
                data: function(d) {
                    var formData = $('#filter-form').serializeArray();
                    var serializedData = {};
                    $(formData).each(function(index, obj) {
                        serializedData[obj.name] = obj.value;
                    });
                    $.extend(d, serializedData);
                }
            },
            columns: [{
                    data: 'checkbox',
                    name: 'checkbox',

                },

                {
                     data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },


                {
                    data: 'order_no',
                    name: 'order_no'
                },
                {
                    data: 'customer_name',
                    name: 'customer_name'
                },
                {
                    data: 'shipping_charge',
                    name: 'shipping_charge'
                },
                {
                    data: 'total_amount',
                    name: 'total_amount'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'delivery_status',
                    name: 'delivery_status'
                },
                {
                    data: 'cancel_status',
                    name: 'cancel_status'
                },

                
                {
                    data: 'action',
                    name: 'action'
                },
            ],

            processing: true,
            serverSide: true,
            responsive: true,
            "searching": false,
            "bStateSave": true,
            "bAutoWidth": false,
            "ordering": true,
        });
        tableX.on('draw.dt', function() {
        $('.categoryViewBtn:first').trigger('click');
       });
       $('#filterBtn').on('click', function() {
            tableX.draw();
            $('#offcanvasExample').offcanvas('hide');
        });
        $('#resetBtn').on('click', function() {
            $('#filter-form')[0].reset();
            tableX.draw();
        });






        $(document).on('change', '.published_status', function() {
            var thisId = $(this).val();

            $.ajax({
                url: "changePublished_status",
                type: "post",
                data: {
                    'thisId': thisId,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.message == 'success') {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Status Changed',
                            showConfirmButton: false,
                            timer: 1500
                        });
                         tableX.ajax.reload(null, false);
                    }
                }

            });

        });
      



        $(document).on("click", '.remove-item-btn', function() {
            let thisId = $(this).attr('data-id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this record!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('category') }}/" + thisId,
                        method: "DELETE",
                        data: {
                            '_token': "{{ csrf_token() }}",

                        },
                        success: function(res) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'The record has been deleted.',
                                icon: 'success',
                                timer: 1500
                            });
                            tableX.ajax.reload(null, false);
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire('Cancelled', 'Your record is safe :)', 'error');
                }
            });
        });
       
       
//   ==========================================================================================================  



        $(document).on('click', '.statusBtn', function() 
        {
            var status = $(this).attr('data-status');
            var id = $(this).attr('data-id');
        
            Swal.fire
            ({
                title: 'Are you sure?',
                text: `Do you want to change the status to "${status}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, continue!',
            }).then((data) => 
            {
                if (data.isConfirmed) 
                {
                    $.ajax
                    ({
                        url: "{{ url('orderStatusChange') }}",
                        type: "post",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'id': id,
                            'status': status
                        },
                        success: function(res) {
                             tableX.ajax.reload(null, false);
                        }
                    });
                }
            });
        });

         $(document).on('click','.deliveryBtn',function()
         {
        	var status=$(this).attr('data-status');
        	var id=$(this).attr('data-id');
        	Swal.fire
        	({
                title: 'Are you sure?',
                text: "Do you want to change the delivery status to '" + status + "'?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes,  continue!',
            }).then((data) =>
            {
                if (data.isConfirmed) 
                {
            		$.ajax
            		({
                		url:"{{url('deliveryStatusChange')}}",
                		type:"post",
                		data:{'_token':"{{csrf_token()}}",'id':id,'status':status},
                		success:function(res)
                		{
                			 tableX.ajax.reload(null, false);
                		}
                	});
            	}
        	})
         });

    </script>
@endsection
