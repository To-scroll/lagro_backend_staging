@extends('layouts.adminlayout')
@section('styles')
   
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Offers</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Offers</li>
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
                        <h4 class="mb-sm-0">Offers</h4>
                        <div class="card-body bg-light-subtle border border-dashed border-start-0 border-end-0">
                            <form>
                                <div class="row g-3">
                                    <div class="col-xxl-4 col-sm-12">
                                        <div class="search-box">
                                            <input type="text" class="form-control search bg-light border-light" placeholder="Search for Offers..." id="Offer">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-5">
                                        <button type="button" class="btn bg-primary btn-xs text-white"
                                            id="filterBtn">Search
                                        </button>
                                        <button type="button" class="btn bg-danger btn-xs text-white "
                                            id="resetfilterBtn">Reset
                                        </button>
                                         <a href="{{ route('offers.create') }}" class="btn btn-success"><i
                                                class="ri-add-line align-bottom me-1"></i>Add New Offer </a>
                                           
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="offerTable" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10px;">
                                    <div class="form-check">
                                        <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>

                                <th>SR No.</th>
                                <th>Offer Name</th>
                                <th>Offer Amount</th>
                                <th>Offer Limit</th>
                                <th>Is Apply</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-3">

            <div class="card" id="offersView">

            </div>
            <!--end card-->

        </div>
    </div>
@endsection
@section('scripts')

    <script>
        var tableX = $('#offerTable').DataTable({
            ajax: {
                url: "{{ route('filter_offers') }}",
                data: function(d) {
                     d.Offer = $('#Offer').val();
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
                    data: 'offer_name',
                    name: 'offer_name'
                },
                 {
                    data: 'offer_amount',
                    name: 'offer_amount'
                },
                {
                    data: 'offer_limit',
                    name: 'offer_limit'
                },
                {
                    data: 'is_apply',
                    name: 'is_apply'
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
        $('.offersViewBtn:first').trigger('click');
       });
        $('#filterBtn').on('click', function() {
            tableX.draw();
        });
        $('#resetfilterBtn').on('click', function() {
             $('#Offer').val('');
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
                        url: "{{ url('offers') }}/" + thisId,
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
            $(document).on("click", ".offersViewBtn", function() {
                var offerId = $(this).data("id");

                $.ajax({
                    url: "{{ route('offers.view', ['id' => '_offersId_']) }}".replace('_offersId_',
                        offerId),
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);

                        $('#offersView').html(response.offersView);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    },
                });
            });
        });
        
        
        
        $(document).on('change', '.apply_status', function () {
            var thisId = $(this).val();
            var checkbox = $(this);
        
            $.ajax({
               url:"changeApply_status",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    thisId: thisId
                },
                success: function (response) {
                    if (response.status === 'warning') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: response.message
                        });
                        checkbox.prop('checked', false);
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        });
                    }
                }
            });
        });

    </script>
@endsection
