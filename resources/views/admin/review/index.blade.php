@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Reviews</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Reviews</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">

                    <div class="row g-4 align-items-center">

                        <h4 class="mb-sm-0">Reviews</h4>
                        <div class="col-sm-auto ms-auto">
                            <div class="hstack gap-2">

                                {{-- <button type="button" class="btn btn-info" data-bs-toggle="offcanvas" href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i> Fliters</button> --}}
                                {{-- 
                                <button type="button" id="importBtn" class="btn btn-danger">Import</button>
                                <a href="{{ route('reviews.create') }}" class="btn btn-success"><i
                                        class="ri-add-line align-bottom me-1"></i>Add New Groups</a> 
                                --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="reviewTable" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10px;">
                                    <div class="form-check">
                                        <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>

                                <th>SR No.</th>
								<th>Customer Name</th>
								<th>Product Name</th>
								<th>Product Image</th>
								
								<th>Rating</th>
								<th>Is Approved</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>


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
                                {{-- <div class="mb-4">
                                <label for="country-select" class="form-label text-muted text-uppercase fw-semibold mb-3">Color</label>
                                <select class="form-control" data-choices data-choices-multiple-remove="true" name="colour" id="color-select" multiple>
                                    
                                    
                                </select>
                            </div> --}}

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

	<div class="modal fade" id="cmsView" aria-hidden="true" tabindex="-1">
		<div class="modal-dialog modal-lg">
	
			<div id="cmsShow" ></div>
		</div>
	</div>
    
@endsection
@section('scripts')

    <script>
        var tableX = $('#reviewTable').DataTable({
            ajax: {
                url: "{{ url('filter_reviews') }}",
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
                    data: 'name',
                    name: 'name'
                },
				{
                    data: 'product_name',
                    name: 'product_name'
                },
                {
                    data: 'product_image',
                    name: 'product_image'
                },
				{
                    data: 'rating',
                    name: 'rating'
                },
				{
                    data: 'is_approved',
                    name: 'is_approved'
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


      

        $(document).on("click", '.deleteBtn', function() {

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
                        url: "{{ url('review_delete') }}",
                        method: "post",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'id': thisId,


                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'The record has been deleted.',
                                icon: 'success',
                                timer: 1500
                            });
                            tableX.draw();
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire('Cancelled', 'Your record is safe :)', 'error');
                }
            });
        });


		$(document).on('click', '.reviewView', function() {
            $('#cmsShow').html('');
			let thisId = $(this).attr('data-id');
            $.ajax({
                url: "{{ url('reviewShow') }}",
                type: "post",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': thisId
                },
                success: function(data) {

                    $('#cmsShow').html(data);
                    $('#cmsView').modal('show');
                }

            });

        });


        $(document).on('click', '#close', function() {
            $('#cmsView').modal('hide');
        });

      
		$(document).on('change','.publish_status',function(){
     	var thisId=$(this).val();

     	$('#preloader').fadeIn(100); 
     	$.ajax({
     		url:"changeApproveStatus",
     		type:"post",
     		data:{'id':thisId,'_token':'{{ csrf_token() }}'},
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
