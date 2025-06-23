@extends('layouts.adminlayout')
@section('styles')
  
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Pages</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pages</li>
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
                   
                    <h4 class="mb-sm-0">Pages</h4>
                    <div class="col-sm-auto ms-auto">
                        <div class="hstack gap-2">
                            
                            {{-- <button type="button" class="btn btn-info" data-bs-toggle="offcanvas" href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i> Fliters</button> --}}
                           
                            
                            <a href="{{ route('cms.create')}}" class="btn btn-success"><i class="ri-add-line align-bottom me-1"></i>Add New Page </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="cmsTable" class="table nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 10px;">
                                <div class="form-check">
                                    <input class="form-check-input fs-15" type="checkbox" id="checkAll"  value="option">
                                </div>
                            </th>
                            
                            <th>SR No.</th>
                            <th>Page Name</th>
                            <th>Route</th>
                            <th>Is published</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        
                    </tbody>
                </table>
                

                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header bg-light">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Badge Fliters</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <!--end offcanvas-header-->
                    <form id="filter-form" class="d-flex flex-column justify-content-end h-100">
                        <div class="offcanvas-body">
                            <div class="mb-4">
                                <label for="datepicker-range" class="form-label text-muted text-uppercase fw-semibold mb-3">Badge Name</label>
                                <input type="text" class="form-control" name="badge_name" id="badge_name" data-provider="flatpickr" data-range="true" placeholder="Select date">
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
	<div class="modal-dialog  modal-lg">

		<div id="cmsShow" ></div>
	</div>
</div>
@endsection
@section('scripts')

<script>
var tableX = $('#cmsTable').DataTable({
    ajax: {
        url: "{{ route('filter_cms') }}",
        data: function(d) {
            var formData = $('#filter-form').serializeArray();
            var serializedData = {};
            $(formData).each(function(index, obj) {
                serializedData[obj.name] = obj.value;
            });
            $.extend(d, serializedData);
        }
    },
    columns: [
        {
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
            data: 'page_name',
            name: 'page_name'
        },
        {
            data: 'route',
            name: 'route'
        },
        {
            data: 'is_published',
            name: 'is_published'
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
$('#filterBtn').on('click', function() {
            tableX.draw();
            $('#offcanvasExample').offcanvas('hide');
        });
        $('#resetBtn').on('click', function() {
            $('#filter-form')[0].reset();
            tableX.draw();
        });




$(document).on('change','.published_status',function(){
    	var thisId=$(this).val();
    	$('#preloader').fadeIn(100); 
    	$.ajax({
    		url:"cmsStatusChange",
    		type:"post",
    		data:{'thisId':thisId,'_token':'{{ csrf_token() }}'},
    		success: function(response)
    		{
                if (response.message == 'success') {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Status Changed',
                    showConfirmButton: false,
                    timer: 1500
                });
                tableX.draw();
            }
            }

    	});

});


$(document).on('click', '.cmsView', function() {
            $('#cmsShow').html('');
			let thisId = $(this).attr('data-id');
            $.ajax({
                url: "{{ url('cmsView') }}",
                type: "get",
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



</script>
@endsection