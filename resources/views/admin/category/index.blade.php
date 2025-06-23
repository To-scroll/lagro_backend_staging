@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Category</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Category</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header border-0">

                    <div class="row g-3 clearfix row-deck mb-3">
                    <div class="col-lg-12 col-md-12">
                        
                                <form class="row g-3" id="filter_form">
                                @csrf
                                    <div class="row">
                                         <div class="col-md-3 mt-3">
                                            <label class="form-label">Category name</label>
                                            <input type="text" class="form-control" name="category" id="categoryfilter"
                                                placeholder="Enter category Name">
                                        </div>
                                        {{--<div class="col-md-2 mt-3">
                                            <label class="form-label">Staff Phone</label>
                                            <input type="text" class="form-control" name="staff_phone" id="staff_phone"
                                                placeholder="Enter Staff Phone">
                                        </div> --}}
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label">Select Main/Sub Category</label>
                                            <select name="parent" id="parent" class="form-select">
                                                <option value="">All</option>
                                                <option value="yes">Main Category</option>
                                                <option value="no">Sub Category</option>
                                            </select>
                                        </div>
                                        <div class="col-md-5 mt-1" style="padding-top:2.5rem;">
                                            <button type="button" class="btn bg-primary btn-xs text-white"
                                                id="filterBtn">Search</button>
                                            <button type="button" class="btn bg-danger btn-xs text-white "
                                                id="resetfilterBtn">Reset</button>
                                                <a href="{{ route('category.create')}}" class="btn btn-success"><i class="ri-add-line align-bottom me-1"></i>Add New Category </a>
                                        </div>
                                        
                                    </div>
                                </form>
                            
                    </div>
                </div>
                </div>
                <div class="card-body">
                    <table id="categoryTable" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10px;">
                                    <div class="form-check">
                                        <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>

                                <th>SR No.</th>
                                <th>Category Name</th>
                                <th>Icon</th>
                                <th>Is Active</th>
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
        <div class="col-lg-3">

            <div class="card" id="categoryView">
               
            </div>
            <!--end card-->

        </div>
    </div>
@endsection
@section('scripts')

    <script>
        var tableX = $('#categoryTable').DataTable({
            ajax: {
                url: "{{ url('filter_category') }}",
                data: function(d) {
                    d.parent = $('#parent').val();
                     d.category_name = $('#categoryfilter').val();
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
                    data: 'category_name',
                    name: 'category_name'
                },
                {
                    data: 'icon',
                    name: 'icon'
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
        tableX.on('draw.dt', function() {
        $('.categoryViewBtn:first').trigger('click');
       });

        $('#filterBtn').on('click', function() {
            tableX.draw();
            
        });
        $('#resetfilterBtn').on('click', function() {
            $('#categoryfilter').val('');
            $('#parent').val('');
            tableX.draw();
        });





        $(document).on('change', '.category_status', function() {
            var thisId = $(this).val();

            $.ajax({
                url: "changeCategory_status",
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
        $(document).on('change', '.is_featured_status', function() {
            var thisId = $(this).val();

            $.ajax({
                url: "changeCategory_status",
                type: "post",
                data: {
                    'thisId': thisId,
                    '_token': '{{ csrf_token() }}',
                    'type': 'is_featured'
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

        $(document).ready(function() {
            $(document).on("click", ".categoryViewBtn", function() {
                var categoryId = $(this).data("id");

                $.ajax({
                    url: "{{ route('category.view',['id' => '_categoryId_']) }}".replace('_categoryId_', categoryId),
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);

                        $('#categoryView').html(response.categoryView);




                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    },
                });
            });
        });
    </script>
@endsection
