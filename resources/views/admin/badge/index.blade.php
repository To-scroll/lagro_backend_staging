@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Badge</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Badge</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                 <div class="card-header border-0">
                    <div class="row g-3 clearfix row-deck mb-3">
                        <div class="col-lg-12 col-md-12">
                            <form class="row g-3" id="filter_form">
                            @csrf
                                <div class="row">
                                     <div class="col-md-3 mt-3">
                                        <label class="form-label">Badge name</label>
                                        <input type="text" class="form-control" name="badge" id="badgefilter"
                                            placeholder="Enter Badge Name">
                                    </div>
                                    
                                   
                                    <div class="col-md-5 mt-1" style="padding-top:2.5rem;">
                                        <button type="button" class="btn bg-primary btn-xs text-white"
                                            id="filterBtn">Search
                                        </button>
                                        <button type="button" class="btn bg-danger btn-xs text-white "
                                            id="resetfilterBtn">Reset
                                        </button>
                                        <button type="button" class="btn btn-success" id="badgeModal" data-toggle="modal"
                                            data-target="#badgeCreateModal">
                                            <i class="ri-add-line align-bottom me-1"></i> Add New Badge
                                        </button>
                                           
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                
               {{-- 
                <div class="card-header border-0">
                    <div class="row g-4 align-items-center">
                        <h4 class="mb-sm-0">Badge</h4>
                        <div class="col-sm-auto ms-auto">
                            <div class="hstack gap-2">
                                <button type="button" class="btn btn-info" data-bs-toggle="offcanvas"
                                    href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i>
                                    Fliters</button>

                                <button type="button" class="btn btn-success" id="badgeModal" data-toggle="modal"
                                    data-target="#badgeCreateModal">
                                    <i class="ri-add-line align-bottom me-1"></i> Add New Badge
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
                --}}
                
                
                
                
                <div class="card-body">
                    <table id="badgeTable" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10px;">
                                    <div class="form-check">
                                        <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>

                                <th>SR No.</th>
                                <th>Badge Name</th>
                                <th>Color</th>
                                <th>Status</th>
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
                                        data-provider="flatpickr" data-range="true" placeholder="Select Badge Name">
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

    <div class="modal " id="badgeCreateModal" tabindex="-1" role="dialog" aria-labelledby="badgeCreateModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="badgeCreateForm" method="POST" enctype="multipart/form-data" autocomplete="off"
                    class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-header"
                        style="background-image: url('{{ asset('assets/admin/images/brands/backimg.jpg') }}');justify-content:center;border-radius:5px;">
                        <h5 class="modal-title" id="badgeCreateModalLabel" style="color:white;padding-bottom:10px;">Create
                            Badge</h5>
                       
                    </div>
                    <div class="modal-body">
                        <!-- Your form fields go here (same as in your original form) -->
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label" for="badge_name">Badge Name</label>
                                <input type="hidden" class="form-control" id="formAction" name="formAction"
                                    value="add">
                                <input type="text" class="form-control d-none" id="product-id-input">
                                <input type="text" class="form-control" id="badge_name" value=""
                                    name="badge_name" placeholder="Enter Badge Name" required>
                                <div class="invalid-feedback">Please Enter a product title.</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="product-title-input">Color</label>
                                <input type="color" class="form-control form-control-color" name="colour"
                                    value="{{ old('colour','#000000') }}" title="Choose your color" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="product-title-input">Badge Status</label>

                                <select class="form-select" id="choices-publish-visibility-input" name="badge_status"
                                    data-choices data-choices-search-false>
                                    <option value="yes" selected {{ old('badge_status') == 'yes' ? 'selected' : '' }}>
                                        Yes
                                    </option>
                                    <option value="no" {{ old('badge_status') == 'no' ? 'selected' : '' }}>No</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeModal"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal " id="badgeEditModal" tabindex="-1" role="dialog" aria-labelledby="badgeEditModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="badgeUpdateForm" method="POST" enctype="multipart/form-data" autocomplete="off"
                    class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-header"
                        style="background-image: url('{{ asset('assets/admin/images/brands/backimg.jpg') }}');justify-content:center;border-radius:5px;">
                        <h5 class="modal-title" id="badgeEditModalLabel" style="color:white;padding-bottom:10px;">
                            Edit Badge</h5>
                        
                    </div>
                    <div class="modal-body">
                        <!-- Your form fields go here (same as in your original form) -->
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label" for="badge_name">Badge Name</label>
                               
                                <input type="hidden" class="form-control badgeName" id="badgeId" 
                                name="badge_Id" >
                                <input type="text" class="form-control badgeName" id="badge_name1" 
                                    name="badge_name" placeholder="Enter Badge Name" >
                               
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="color">Color</label>
                                <input type="color" class="form-control form-control-color" name="colour"
                                     title="Choose your color" id="color">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="badge_status">Badge Status</label>

                                <select class="form-select status" id="badge_status" name="badge_status"
                                    data-choices data-choices-search-false>
                                    <option value="yes" selected {{ old('badge_status') == 'yes' ? 'selected' : '' }}>
                                        Yes
                                    </option>
                                    <option value="no" {{ old('badge_status') == 'no' ? 'selected' : '' }}>No</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeeditModal"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

    <script>
        var tableX = $('#badgeTable').DataTable({
            ajax: {
                url: "{{ route('filter_badge') }}",
               data: function(d) {
                     d.badge_name = $('#badgefilter').val();
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
                    data: 'badge_name',
                    name: 'badge_name'
                },
                {
                    data: 'colour',
                    name: 'colour'
                },
                {
                    data: 'status',
                    name: 'status'
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
        });
        $('#resetfilterBtn').on('click', function() {
             $('#badgefilter').val('');
            tableX.draw();
        });


        function populateColorOptions(colors) {
            var colorSelect = $('#color-select');
            colorSelect.empty().append('<option value="">Select color</option>');

            $.each(colors, function(index, color) {
                colorSelect.append($('<option>', {
                    value: color,
                    text: color
                }));
            });

            colorSelect.trigger('change');

        }
        $.ajax({
            url: "{{ url('get-colors') }}",
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                // console.log(response);
                var colors = response.colors;
                populateColorOptions(colors);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching colors:', error);
            }
        });


        $(document).on('change', '.badge_status', function() {
            var thisId = $(this).val();
            $('#preloader').fadeIn(100);
            $.ajax({
                url: "changeBadge_status",
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
                        url: "{{ url('badge') }}/" + thisId,
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
                            tableX.draw();
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire('Cancelled', 'Your record is safe :)', 'error');
                }
            });
        });

        $(document).on("click", '#badgeModal', function() {
            $('#badgeCreateModal').modal('show');
        });
        $(document).on("click", '#closeModal', function() {
            $('#badgeCreateModal').modal('hide');
        });

        $(document).on("click", '#editBadge', function() {
            const badgeId = $(this).data("id");

            $.ajax({
                url: '{{ url('fetchBadge') }}',
                method: 'GET',
                data: {
                    badgeId: badgeId
                },
                dataType: 'json',
            success: function(response) {
                console.log(response); // Check if the response object is as expected
                
             $('#badgeId').val(response.id);
             $('#badge_name1').val(response.badge_name);
                
              
                $('#color').val(response.colour); 
                $('.status').val(response.status); 
                
                
                $('#badgeEditModal').modal('show'); 
               
            }
            });
        });
        $(document).on("click", '#closeeditModal', function() {
            $('#badgeEditModal').modal('hide');
        });

        $(document).ready(function() {
            $("#badgeCreateForm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
                $.ajax({
                    url: "{{ route('badgeStore') }}",
                    type: "post",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        console
                        if (response.message == 'success') {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Created Successfully',

                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = '{{ url('badge') }}';
                            });

                        }

                        $('#badgeCreateForm')[0].reset();
                    },
                    error: function(response) {

                        $('#preloader').fadeOut(100);
                        jsonValue = jQuery.parseJSON(response.responseText);
                        $.each(jsonValue.errors, function(field_name, error) {
                            $(document).find('[name=' + field_name + ']').after(
                                '<small class="form-control-feedback text-danger errors"> ' +
                                error + ' </small>')
                        });
                    }
                });
            }));
        });

        $(document).ready(function() {
            $("#badgeUpdateForm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
                $.ajax({
                    url: "{{ route('badgeUpdate') }}",
                    type: "post",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        console
                        if (response.message == 'success') {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Updated Successfully',

                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = '{{ url('badge') }}';
                            });

                        }

                        $('#badgeCreateForm')[0].reset();
                    },
                    error: function(response) {

                        $('#preloader').fadeOut(100);
                        jsonValue = jQuery.parseJSON(response.responseText);
                        $.each(jsonValue.errors, function(field_name, error) {
                            $(document).find('[name=' + field_name + ']').after(
                                '<small class="form-control-feedback text-danger errors"> ' +
                                error + ' </small>')
                        });
                    }
                });
            }));
        });
    </script>
@endsection
