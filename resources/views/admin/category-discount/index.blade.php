@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Category Discount</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Category Discount</li>
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
                                        <div class="col-md-5 mt-1" style="padding-top:2.5rem;">
                                            <button type="button" class="btn bg-primary btn-xs text-white"
                                                id="filterBtn">Search</button>
                                            <button type="button" class="btn bg-danger btn-xs text-white "
                                                id="resetfilterBtn">Reset</button>
                                                <a href="{{ route('category-discount.create')}}" class="btn btn-success"><i class="ri-add-line align-bottom me-1"></i>Add New Discount </a>
                                        </div>
                                        
                                    </div>
                                </form>
                            
                    </div>
                </div>
                </div>
                <div class="card-body">
                    <table id="categoryDiscountTable" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>

                                <th>SR No.</th>
                                <th>Discount Name</th>
                                <th>Category Name</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-lg-3">

            <div class="card" id="categoryDicsountView">
               
            </div>
            <!--end card-->

        </div>
    </div>
@endsection
@section('scripts')

    <script>
        var tableX = $('#categoryDiscountTable').DataTable({
            ajax: {
                url: "{{ url('filter_categoryDiscount') }}",
                data: function(d) {
                     d.category_name = $('#categoryfilter').val();
                }
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'discount_name',
                    name: 'discount_name'
                },
                 {
                    data: 'category_name',
                    name: 'category_name'
                },
                {
                    data: 'from_date',
                    name: 'from_date'
                },
                {
                    data: 'to_date',
                    name: 'to_date'
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
            "ordering": false,
        });
        
        
        tableX.on('draw.dt', function() 
        {
            $('.discountViewBtn:first').trigger('click');
        });

        $('#filterBtn').on('click', function() {
            tableX.draw();
            
        });
        $('#resetfilterBtn').on('click', function() {
            $('#category-discountfilter').val('');
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
                        url: "{{ url('category-discount') }}/" + thisId,
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
            $(document).on("click", ".discountViewBtn", function() {
                var categoryId = $(this).data("id");

                $.ajax({
                    url: "{{ url('category-discount')}}/" + categoryId,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        $('#categoryDicsountView').html(response.categoryDicsountView);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    },
                });
            });
        });
        
        
        
        
        

       
    </script>
@endsection
