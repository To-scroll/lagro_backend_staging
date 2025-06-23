@extends('layouts.adminlayout')
@section('styles')
 
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Sales Report</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Sales Report</li>
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
                   
                    <h4 class="mb-sm-0">Sales Report</h4>
                    <div class="col-sm-auto ms-auto">
                        <div class="hstack gap-2">
                            
                            <button type="button" class="btn btn-info" data-bs-toggle="offcanvas" href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i> Fliters</button>
							<button  type="button" id="exportSalesReport"class="btn bg-success btn-xs text-white "><i class="ri-download-2-fill align-middle me-1"></i>Full Report</button>
							<button  type="button" id="productwise-exportReport"class="btn bg-primary btn-xs text-white">Product wise <i class="fa fa-upload"></i></button>
                              {{-- <div class="flex-shrink-0">
                            <a href="" class="btn btn-success btn-sm"><i class="ri-download-2-fill align-middle me-1"></i> Invoice</a>
                        </div> --}}
                            {{-- <a href="{{ route('badge.create')}}" class="btn btn-success"><i class="ri-add-line align-bottom me-1"></i>Add New Badge </a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="sales-table" class="table nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 10px;">
                                <div class="form-check">
                                    <input class="form-check-input fs-15" type="checkbox" id="checkAll"  value="option">
                                </div>
                            </th>
                            
                            <th>SR No.</th>
							<th>Order no</th>
							<th>Name</th>
							<th>Address</th>
							<th>Amount</th>
							<th>Status</th>
							<th>Delivery Status</th>
							<th>Cancel Status</th>
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
                                <label for="datepicker-range" class="form-label text-muted text-uppercase fw-semibold mb-3"> Name</label>
                                <input type="text" class="form-control" name="name" id="name" data-provider="flatpickr" data-range="true" placeholder="Select Name">
                            </div>
							<div class="mb-4">
                                <label for="datepicker-range" class="form-label text-muted text-uppercase fw-semibold mb-3"> Order No</label>
                                <input type="text" class="form-control" name="order_no" id="order_no" data-provider="flatpickr" data-range="true" placeholder="Select Order No">
                            </div>
							<div class="mb-4">
                                <label for="datepicker-range" class="form-label text-muted text-uppercase fw-semibold mb-3"> Date From</label>
                                <input type="date" class="form-control" name="date_from" id="date_from" data-provider="flatpickr" data-range="true" placeholder="Select date">
                            </div>
							<div class="mb-4">
                                <label for="datepicker-range" class="form-label text-muted text-uppercase fw-semibold mb-3"> Date To</label>
                                <input type="date" class="form-control" name="date_to" id="date_to" data-provider="flatpickr" data-range="true" placeholder="Select date">
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
var tableX = $('#sales-table').DataTable({
    ajax: {
        url: "{{ route('filter_salesrpt') }}",
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
            data: 'total_amount',
            name: 'total_amount'
        },
		{
            data: 'status',
            name: 'status'
        },
		{
            data: 'delivery_status',
            name: 'delivery_status'
        },
        {
            data: 'cancel_status',
            name: 'cancel_status'
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


		$(document).on('click','.downloadSalesReport',function(){
      
	   let orderid = $(this).attr('data-id');
 
      $.ajax({
            //dataType: 'json',
            type: "POST",
            url: "{{ route('downloadSalesReport') }}",

            data: {'orderid':orderid,'_token': '{{ csrf_token() }}'},
             xhrFields: {
                    responseType: 'blob'
                },
           success: function (response, status, xhr) {
			console.log(response);
           			getExceldata('salesreport',response, status, xhr);


            }
         });
});


//export salereport
$(document).on('click','#exportSalesReport',function(){
    var customer_name=$('#name').val();
    var order_no=$('#order_no').val();
    var date_from=$('#date_from').val();
    var date_to=$('#date_to').val();
    var cancel_status=$('#cancel_status').val();
 
      $.ajax({
            //dataType: 'json',
            type: "POST",
            url: "{{ route('exportSalesReport') }}",

            
             data: {'date_from':date_from,'date_to':date_to,'customer_name':customer_name,'order_no':order_no,'_token': '{{ csrf_token() }}'},
             xhrFields: {
                    responseType: 'blob'
                },
           success: function (response, status, xhr) {
							getExceldata('orders-sales-report',response, status, xhr);

            }
         });
});

//export salereport
$(document).on('click','#productwise-exportReport',function(){
    var customer_name=$('#name').val();
    var order_no=$('#order_no').val();
    var date_from=$('#date_from').val();
    var date_to=$('#date_to').val();
    var cancel_status=$('#cancel_status').val();
 
      $.ajax({
            //dataType: 'json',
            type: "POST",
            url: "{{ route('export-productwise-salesReport') }}",

            
             data: {'date_from':date_from,'date_to':date_to,'customer_name':customer_name,'order_no':order_no,'_token': '{{ csrf_token() }}'},
             xhrFields: {
                    responseType: 'blob'
                },
           success: function (response, status, xhr) {

           				getExceldata('productwise-sales-report',response, status, xhr);
              
            }
         });
});


function getExceldata(name,response, status, xhr)
{
	 //var filename = "productwise-sales-report";             
	 var filename = name;        
                var disposition = xhr.getResponseHeader('Content-Disposition');

                 if (disposition) {
                    var filenameRegex = /filename[^;=\n]=((['"]).?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                } 
                var linkelem = document.createElement('a');
                try {
                    var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });                        
                    if (typeof window.navigator.msSaveBlob !== 'undefined') {
                        //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                        window.navigator.msSaveBlob(blob, filename);
                    } else {
                        var URL = window.URL || window.webkitURL;
                        var downloadUrl = URL.createObjectURL(blob);

                        if (filename) { 
                            // use HTML5 a[download] attribute to specify filename
                            var a = document.createElement("a");

                            // safari doesn't support this yet
                            if (typeof a.download === 'undefined') {
                                window.location = downloadUrl;
                            } else {
                                a.href = downloadUrl;
                                a.download = filename;
                                document.body.appendChild(a);
                                a.target = "_blank";
                                a.click();
                            }
                        } else {
                            window.location = downloadUrl;
                        }
                    }   

                } catch (ex) {
                    console.log(ex);
                } 
            

}
</script>
@endsection