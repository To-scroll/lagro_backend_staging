@extends('layouts.adminlayout')
@section('styles')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Invoice</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Invoice</li>
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
                   
                    <h4 class="mb-sm-0">Invoice</h4>
                    <div class="col-sm-auto ms-auto">
                        <div class="hstack gap-2">
                            
                            <button type="button" class="btn btn-info" data-bs-toggle="offcanvas" href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i> Fliters</button>
                           
                            
                            {{-- <a href="{{ route('badge.create')}}" class="btn btn-success"><i class="ri-add-line align-bottom me-1"></i>Add New Badge </a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="invoiceTable" class="table nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 10px;">
                                <div class="form-check">
                                    <input class="form-check-input fs-15" type="checkbox" id="checkAll"  value="option">
                                </div>
                            </th>
                            
                            <th>SR No.</th>
                            <th>Invoice#</th>
                            <th>Order No</th>
                            <th>Name</th>
							<th>Address</th>
							<th>Cancel Status</th>
							<th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        
                    </tbody>
                </table>
                

                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header bg-light">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Invoice Fliters</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <!--end offcanvas-header-->
                    <form id="filter-form" class="d-flex flex-column justify-content-end h-100">
                        <div class="offcanvas-body">
                            <div class="mb-4">
                                <label for="datepicker-range" class="form-label text-muted text-uppercase fw-semibold mb-3"> Name</label>
                                <input type="text" class="form-control" name="name" id="name" data-provider="flatpickr" data-range="true" placeholder="Select Name">
                            </div>
                            <div class="mb-4">
                                <label for="datepicker-range" class="form-label text-muted text-uppercase fw-semibold mb-3"> Invoice No</label>
                                <input type="text" class="form-control" name="invoice_no" id="invoice_no" data-provider="flatpickr" data-range="true" placeholder="Select Invoice No">
                            </div>
							<div class="mb-4">
                                <label for="datepicker-range" class="form-label text-muted text-uppercase fw-semibold mb-3"> Order No</label>
                                <input type="text" class="form-control" name="order_no" id="order_no" data-provider="flatpickr" data-range="true" placeholder="Select Order No">
                            </div>
                            <div class="mb-4">
                                <label for="datepicker-range" class="form-label text-muted text-uppercase fw-semibold mb-3">Cancel Status</label>
                                <select class="form-control"  name="cancel_status" id="cancel_status" >
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
var tableX = $('#invoiceTable').DataTable({
    ajax: {
        url: "{{ route('filter_invoice') }}",
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
            data: 'invoice_no',
            name: 'invoice_no'
        },
        {
            data: 'order_no',
            name: 'order_no'
        },
        {
            data: 'name',
            name: 'name'
        },
		{
            data: 'address',
            name: 'address'
        },
        {
            data: 'cancel_status',
            name: 'cancel_status'
        },
		{
            data: 'total_amount',
            name: 'total_amount'
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


 
</script>
@endsection