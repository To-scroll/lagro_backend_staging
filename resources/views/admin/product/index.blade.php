@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Products</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Products</p>
                        </div>
                        {{-- <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0">
                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +16.24 %
                            </h5>
                        </div> --}}
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $productCount }}">0</span></h4>
                            {{-- <a href="" class="text-decoration-underline">View net earnings</a> --}}
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
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Is Published</p>
                        </div>
                        {{-- <div class="flex-shrink-0">
                            <h5 class="text-danger fs-14 mb-0">
                                <i class="ri-arrow-right-down-line fs-13 align-middle"></i> -3.57 %
                            </h5>
                        </div> --}}
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $publishedCount }}">0</span></h4>
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


        <!--for new  -->
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Is New</p>
                        </div>
                        {{-- <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0">
                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +29.08 %
                            </h5>
                        </div> --}}
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $newCount }}">0</span></h4>
                            {{-- <a href="" class="text-decoration-underline">See details</a> --}}
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning rounded fs-3">
                                <i class="fa fa-box-open"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
        
         <!--for  trending  -->
         <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Is Trending</p>
                        </div>
                        {{-- <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0">
                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +29.08 %
                            </h5>
                        </div> --}}
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $trendingCount }}">0</span></h4>
                            {{-- <a href="" class="text-decoration-underline">See details</a> --}}
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning rounded fs-3">
                                <i class="fa fa-fire"></i>
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

                        <h4 class="mb-sm-0">Products</h4>
                        <div class="col-sm-auto ms-auto">
                            <div class="hstack gap-2">
                                {{-- <button type="button" class="btn btn-info" data-bs-toggle="offcanvas" href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i> Fliters</button> --}}
                                <a href="{{ route('product.create') }}" class="btn btn-success"><i
                                        class="ri-add-line align-bottom me-1"></i>Add New Product</a>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-2">
                            <input type="text" id="product_name" class="form-control" placeholder="Search product name">
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary w-100" id="filterBtn">Search</button>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-danger w-100" id="resetfilterBtn">Reset</button>
                        </div>
                    </div>
    
    
                </div>
                <div class="card-body">
                    <table id="productTable" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10px;">
                                    <div class="form-check">
                                        <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>

                                <th>SR No.</th>
                                <th>Product Name </th>
                                <th>Image</th>
                                <th>Is Published</th>
                                <th>Is New</th>
                                <th>Is Trending</th>
                               
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>

                            {{--
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample"
                                aria-labelledby="offcanvasExampleLabel">
                                <div class="offcanvas-header bg-light">
                                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Badge Fliters</h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <!--end offcanvas-header-->
                                <form id="filter-form" class="d-flex flex-column justify-content-end h-100">
                                    <div class="offcanvas-body">
                                        <div class="mb-4">
                                            <label for="datepicker-range"
                                                class="form-label text-muted text-uppercase fw-semibold mb-3">Badge Name</label>
                                            <input type="text" class="form-control" name="badge_name" id="badge_name"
                                                data-provider="flatpickr" data-range="true" placeholder="Select date">
                                        </div>
                                    <div class="mb-4">
                                        <label for="country-select" class="form-label text-muted text-uppercase fw-semibold mb-3">Color</label>
                                        <select class="form-control" data-choices data-choices-multiple-remove="true" name="colour" id="color-select" multiple>
                                            
                                            
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
                            --}}
                </div>
            </div>
        </div>
        
    </div>
@endsection
@section('scripts')

    
    <script>
        var tableX = $('#productTable').DataTable({
            ajax: {
                url: "{{ url('filter_product') }}",
                data: function(d) {
                    d.product_name = $('#product_name').val();
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
                    data: 'product_name',
                    name: 'product_name'
                },
                {
                    data: 'image1',
                    name: 'image1'
                },
                {
                    data: 'is_published',
                    name: 'is_published'
                },
                {
                    data: 'is_new',
                    name: 'is_new'
                },
                {
                    data: 'is_trending',
                    name: 'is_trending'
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
        
        tableX.on('draw.dt', function() 
        {
            $('.categoryViewBtn:first').trigger('click');
        });

        $('#filterBtn').on('click', function() {
            tableX.draw();
        });
        $('#resetfilterBtn').on('click', function() {
            $('#product_name').val('');
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
      



        $(document).on("click", '.remove-item-btn', function() 
        {
            let thisId = $(this).attr('data-id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this record!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            })
            .then((result) => 
            {
                if (result.isConfirmed) 
                {
                    $.ajax(
                        {
                            url: "{{ url('product') }}/" + thisId,
                            method: "DELETE",
                            data: 
                            {
                                '_token': "{{ csrf_token() }}",
                            },
                            success: function(res) 
                            {
                                Swal.fire(
                                    {
                                        title: 'Deleted!',
                                        text: 'The record has been deleted.',
                                        icon: 'success',
                                        timer: 1500
                                    });
                                 tableX.ajax.reload(null, false);
                            }
                        });
                } 
                else if (result.dismiss === Swal.DismissReason.cancel) 
                {
                    Swal.fire('Cancelled', 'Your record is safe :)', 'error');
                }
            });
        });

        $(document).on('change','.new_status',function()
        {
         	var thisId=$(this).val();
         	$('#preloader').fadeIn(100); 
         	$.ajax(
         	    {
             		url:"changeNew_status",
             		type:"post",
             		data:
             		{
             		    'thisId':thisId,'_token':'{{ csrf_token() }}'
         		    },
             		success: function(data)
             		{
             			$('#preloader').fadeOut(100); 
         	        	Swal.fire("Status Changed");
         	             tableX.ajax.reload(null, false);
             		}
         	        
         	    });
        });
        $(document).on('change','.trending_status',function()
        {
         	var thisId=$(this).val();
         	$('#preloader').fadeIn(100); 
         	$.ajax(
         	{
         		url:"changeTrending_status",
         		type:"post",
         		data:
         		{
         		    'thisId':thisId,'_token':'{{ csrf_token() }}'
     		    },
         		success: function(data)
         		{
         			$('#preloader').fadeOut(100); 
     	        	Swal.fire("Status Changed");
     	             tableX.ajax.reload(null, false);
    
        		
         		}

            });
     	});
    </script>
@endsection
