@extends('layouts.adminlayout')
@section('styles')
 
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Groups</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Groups</li>
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

                        <h4 class="mb-sm-0">Groups</h4>
                        <div class="col-sm-auto ms-auto">
                            <div class="hstack gap-2">

                                {{-- <button type="button" class="btn btn-info" data-bs-toggle="offcanvas" href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i> Fliters</button> --}}

                                <button type="button" id="importBtn" class="btn btn-danger">Import</button>
                                <a href="{{ route('groups.create') }}" class="btn btn-success"><i
                                        class="ri-add-line align-bottom me-1"></i>Add New Groups</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="groupTable" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10px;">
                                    <div class="form-check">
                                        <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>

                                <th>SR No.</th>
                                <th>Group Name</th>
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


    <div class="modal fade" id="importmodal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Import Excel</h4>
                </div>
                <form id="importForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body ">

                        <input type="file" class="form-control" name="file" placeholder="Upload">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="submitBtn" class="btn btn-primary">Import </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
@section('scripts')

    <script>
        var tableX = $('#groupTable').DataTable({
            ajax: {
                url: "{{ url('filter_group') }}",
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
                    data: 'group_name',
                    name: 'group_name'
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


        $(document).on('click', '.deleteBtn', function() {

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes,  continue!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('groups/delete') }}",
                        type: "post",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'id': $(this).val()
                        },
                        success: function(data) {
                            if (data == '1') {
                                tableX.draw();
                            }
                        }

                    });
                }
            })

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
                        url: "{{ url('groups/delete') }}",
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


        $('#importBtn').on('click', function() {

            $('#importmodal').modal('show');
        });
       

        $('#submitBtn').on('click', function() {
            var formData = new FormData($('#importForm')[0]);
            $('#submitBtn').html('Importing');
            $('#submitBtn').attr('disabled', true);
            $.ajax({
                url: '{{ url('import-data') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#submitBtn').html('Imported');
                    $('#importmodal').modal('hide');
                    $('#importForm')[0].reset();
                    $('#submitBtn').html('Import');
                    location.reload();
                },
                error: function(xhr, status, error) {

                    console.log(error);
                }
            });
        });
    </script>
@endsection
