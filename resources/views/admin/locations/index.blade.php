@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Locations</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Locations</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header border-0">

                    <div class="row g-4 align-items-center">
                        <h4 class="mb-sm-0">Locations</h4>
                        <div class="card-body bg-light-subtle border border-dashed border-start-0 border-end-0">
                            <form>
                                <div class="row g-3">
                                    <div class="col-xxl-4 col-sm-12">
                                        <div class="search-box">
                                            <input type="text" class="form-control search bg-light border-light" placeholder="Search for location..." id="Locations">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </div>
                                    <div class="col-xxl-2 col-sm-4 d-flex">
                                        <button type="button" class="btn btn-primary " id="filterBtn" >
                                            <i class="ri-equalizer-fill me-1 align-bottom"></i> Filters
                                        </button>
                                        <button type="button" class="btn bg-danger  " style="margin-left:5px;"
                                        id="resetfilterBtn"><i class="ri-close-circle-fill me-1 align-bottom"></i>Reset</button>
                                    </div>
                                    <div class="col-xxl-2 col-sm-4 d-flex">
                                        <a href="{{ route('locations.create') }}" class="btn btn-success"><i
                                                class="ri-add-line align-bottom me-1"></i>Add New Locations </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="locationTable" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10px;">
                                    <div class="form-check">
                                        <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>

                                <th>SR No.</th>
                                <th>Location Name</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-3">

            <div class="card" id="locationsView">

            </div>
            <!--end card-->

        </div>
    </div>
@endsection
@section('scripts')

    <script>
        var tableX = $('#locationTable').DataTable({
            ajax: {
                url: "{{ route('filter_locations') }}",
                data: function(d) {
                     d.Locations = $('#Locations').val();
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
                    data: 'location_name',
                    name: 'location_name'
                },
                {
                    data: 'phone1',
                    name: 'phone1'
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
        $('.locationsViewBtn:first').trigger('click');
       });
        $('#filterBtn').on('click', function() {
            tableX.draw();
        });
        $('#resetfilterBtn').on('click', function() {
             $('#Locations').val('');
            tableX.draw();
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
                        url: "{{ url('locations') }}/" + thisId,
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


        $(document).ready(function() {
            $(document).on("click", ".locationsViewBtn", function() {
                var locationId = $(this).data("id");

                $.ajax({
                    url: "{{ route('locations.view', ['id' => '_locationsId_']) }}".replace('_locationsId_',
                        locationId),
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);

                        $('#locationsView').html(response.locationsView);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    },
                });
            });
        });
    </script>
@endsection
