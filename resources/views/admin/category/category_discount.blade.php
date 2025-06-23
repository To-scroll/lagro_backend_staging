@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{$category->category_name}}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Category Discount</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <form id="categoryDiscountForm" method="POST"  >
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            
                            
                              <input type="hidden" name="category_id" value="{{ $category->id }}">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="product-title-input">From Date</label>
                                <input type="datetime-local" class="form-control" name="from_date" value="{{ isset($categorydiscount) ? \Carbon\Carbon::parse($categorydiscount->from_date)->format('Y-m-d\TH:i') : '' }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="product-title-input">To Date</label>
                                <input type="datetime-local" class="form-control" name="to_date" value="{{ isset($categorydiscount) ? \Carbon\Carbon::parse($categorydiscount->to_date)->format('Y-m-d\TH:i') : '' }}" required>


                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="product-title-input">Discount</label>
                                <input type="text" class="form-control" placeholder="Enter Discount %" name="discount" value="{{ isset($categorydiscount) ? $categorydiscount->discount : '' }}" required>

                            </div>
                            
                        </div>
                        
                        <table id="productTable" class="table nowrap align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 10px;">
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" id="checkAll">
                                        </div>
                                    </th>
    
                                    <th>SR No.</th>
                                    <th>Icon</th>
                                    <th>Product Name</th>
                                </tr>
                            </thead>
                            <tbody>
    
    
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end card -->

                <!-- end card -->

            </div>
            <!-- end col -->
           
            <div class="text-end mb-3">
                <a href="{{ url('category') }}" class="btn btn-primary" style="width:95px;">Back</a>
                <button type="submit" class="btn btn-success w-sm">Submit</button>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </form>
@endsection
@section('scripts')
   
    <script>
        var selectedProducts = {!! isset($selectedProducts) ? json_encode($selectedProducts) : '[]' !!};
    </script>
    <script>

    var cat_id="{{$category->id}}";
    var tableX = $('#productTable').DataTable({
            ajax: {
                url: "{{ url('cat_product_list')}}/" + cat_id,
                data: function(d) {}
            },
            columns: [
                {
                    data: 'checkbox',
                    name: 'checkbox'
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },
                {
                    data: 'icon',
                    name: 'icon'
                },
                {
                    data: 'product_name',
                    name: 'product_name'
                }
            ],
            processing: true,
            serverSide: false,   
            paging: false,       
            lengthChange: false, 
            searching: false,    
            ordering: false,     
            info: false,         
            responsive: true,
            autoWidth: false,
        
            drawCallback: function () {
                $('.product-checkbox').each(function () {
                    if (selectedProducts.includes(parseInt($(this).val()))) {
                        $(this).prop('checked', true);
                    }
                });
            
                $('#checkAll').prop('checked', $('.product-checkbox:checked').length === $('.product-checkbox').length);
            
                $('#checkAll').on('change', function () {
                    $('.product-checkbox').prop('checked', this.checked);
                });
            
                $('.product-checkbox').on('change', function () {
                    $('#checkAll').prop('checked', $('.product-checkbox:checked').length === $('.product-checkbox').length);
                });
            }

        });


        $(document).ready(function() 
        {
            $("#categoryDiscountForm").on('submit', (function(e)
            {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
                $.ajax({
                    url: "{{ route('categoryDiscountStore') }}",
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
                                title: ' Success',
                                text: 'Successfully done.',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = '{{ url('category') }}';
                            });

                        }
                        else {
                            // Handle case where success is returned but message is not 'success'
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            });
                        }

                        $('#categoryDiscountForm')[0].reset();
                    },
                    error: function(response) {
                        $('#preloader').fadeOut(100);
                    
                        // Show Swal error alert
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: 'Please check the form for required fields and try again.',
                        });
                    
                        // Show Laravel validation errors
                        var jsonValue = jQuery.parseJSON(response.responseText);
                        $.each(jsonValue.errors, function(field_name, error) {
                            $(document).find('[name="' + field_name + '"]').after(
                                '<small class="form-control-feedback text-danger errors"> ' +
                                error + ' </small>'
                            );
                        });
                    }
                });
            }));

        });
        
        

    </script>
@endsection
