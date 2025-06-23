@extends('layouts.adminlayout')
@section('styles')

	<style>
		@media (min-width: 992px) {
    
    .offcanvas-footer .btn {
        
    }
}
	</style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Contacts</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Contacts</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-1">

                    <div class="row g-4 align-items-center">

                        <h4 class="mb-sm-0">Contacts</h4>
                        <div class="col-sm-auto ms-auto">
                            <div class="hstack gap-2">

                                <button type="button" class="btn btn-info" data-bs-toggle="offcanvas"
                                    href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i>
                                    Fliters</button>


                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="contactTable" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr >
                                <th class="sorting" scope="col" style="width: 10px;">
                                    <div class="form-check">
                                        <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>

                                <th >SR No.</th>
                                <th > Name</th>
                                <th >Email</th>
                                <th >Phone</th>
                                <th >Message</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>


                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample"
                        aria-labelledby="offcanvasExampleLabel">
                        <div class="offcanvas-header bg-light">
                            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Contacts Fliters</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <!--end offcanvas-header-->
                        <form id="filter-form" class="d-flex flex-column justify-content-end h-100">
                            <div class="offcanvas-body">
                                <div class="mb-4">
                                    <label for="datepicker-range"
                                        class="form-label text-muted text-uppercase fw-semibold mb-3">Date From</label>
                                    <input type="date" class="form-control" id="date_from" data-provider="flatpickr"
                                        data-range="true" placeholder="Select date">
                                </div>
                                <div class="mb-4">
                                    <label for="datepicker-range"
                                        class="form-label text-muted text-uppercase fw-semibold mb-3">Date From</label>
                                    <input type="date" class="form-control" id="date_to" data-provider="flatpickr"
                                        data-range="true" placeholder="Select date">
                                </div>
                                <div class="mb-4">
                                    <label for="datepicker-range"
                                        class="form-label text-muted text-uppercase fw-semibold mb-3">Name</label>
                                    <input type="text" class="form-control" id="name" data-provider="flatpickr"
                                        data-range="true" placeholder="Select Name">
                                </div>
                                <div class="mb-4">
                                    <label for="datepicker-range"
                                        class="form-label text-muted text-uppercase fw-semibold mb-3">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" data-provider="flatpickr"
                                        data-range="true" placeholder="Select Name">
                                </div>
                                <div class="mb-4">
                                    <label for="datepicker-range"
                                        class="form-label text-muted text-uppercase fw-semibold mb-3">Email</label>
                                    <input type="text" class="form-control" id="email" data-provider="flatpickr"
                                        data-range="true" placeholder="Select Name">
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
    <!-- Toggle Between Modals -->
    {{-- <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#firstmodal">Open First Modal</button> --}}
    <!-- First modal dialog -->
    <div class="modal fade" id="messageView" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">

            <div id="messageShow" style="height:379px;width:500px;"></div>
        </div>
    </div>
@endsection
@section('scripts')

    <script>
        var tableX = $('#contactTable').DataTable({
            ajax: {
                url: "{{ route('filter_contact') }}",
                data: function(d) {
                    d.date_from = $("#date_from").val();
                    d.date_to = $("#date_to").val();
                    d.name = $("#name").val();
                    d.phone = $("#phone").val();
                    d.email = $("#email").val();
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
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone',
                    name: 'phone'
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
			$('#date_from').val('');
			$('#date_to').val('');
			$('#name').val('');
			$('#phone').val('');
			$('#email').val('');
            tableX.draw();
            $('#offcanvasExample').offcanvas('hide');
        });





        $(document).on('click', '.messageView', function() {
            $('#messageShow').html('');
            $.ajax({
                url: "{{ url('messageView') }}",
                type: "get",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': $(this).val()
                },
                success: function(data) {

                    $('#messageShow').html(data);
                    $('#messageView').modal('show');
                }

            });

        });


        $(document).on('click', '#close', function() {
            $('#messageView').modal('hide');
        });
    </script>
@endsection
