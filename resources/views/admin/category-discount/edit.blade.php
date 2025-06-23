@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Category Discount Edit</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Category Discount</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

   <form id="categoryDiscountEditForm" method="POST"  >
        @csrf
         @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="product-title-input">Discount Name</label>
                                <input type="text" class="form-control" placeholder="Enter Discount Name" value="{{$data->discount_name}}" name="discount_name" required>

                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="product-title-input">Category Name</label>
                                <select name="category_id" id="categorySelect" class="form-select" required>
                                    <option value="" disabled >Choose Category Name </option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $data->category_id == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="product-title-input">From Date</label>
                                <input type="datetime-local" class="form-control" value="{{$data->from_date}}" name="from_date" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="product-title-input">To Date</label>
                                <input type="datetime-local" class="form-control" value="{{$data->to_date}}" name="to_date" required>


                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="product-title-input">Discount Percentage</label>
                                <input type="text" class="form-control" placeholder="Enter Discount %"  name="discount" value="{{$data->discount}}" required>

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
                <a href="{{ url('category-discount') }}" class="btn btn-primary" style="width:95px;">Back</a>
                <button type="submit" class="btn btn-success w-sm">Submit</button>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </form>
@endsection
@section('scripts')
 
    <script>
         var selectedProductIds = @json($selectedProductIds ?? []);
            var initialCategoryId = '{{ $data->category_id }}';
            
            
        $(document).ready(function () {
            var tableX = $('#productTable').DataTable({
                ajax: null,  // No ajax initially
                columns: [
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'icon', name: 'icon' },
                    { data: 'product_name', name: 'product_name' }
                ],
                processing: true,
                serverSide: false,
                paging: false,
                lengthChange: false,
                searching: false,
                ordering: false,
                info: false,
                responsive: true,
                autoWidth: false
            });
        
            function getProducts(categoryId) {
                const ajaxUrl = "{{ url('cat_product_list') }}/" + categoryId;
                tableX.ajax.url(ajaxUrl).load(); // tableX is defined now
                tableX.on('draw', function () {
                    let total = $('.product-checkbox').length;
                    let checked = $('.product-checkbox:checked').length;
                    $('#checkAll').prop('checked', total > 0 && total === checked);
                });
            }
        
            // Now safe to call this
            getProducts(initialCategoryId);  // Make sure initialCategoryId is defined in your view or script
        
            $('#categorySelect').on('change', function () {
                const categoryId = $(this).val();
                getProducts(categoryId);
            });
            $('#checkAll').on('click', function () {
                var isChecked = $(this).is(':checked');
                $('.product-checkbox').prop('checked', isChecked);
            });
            
            $('#productTable').on('change', '.product-checkbox', function () {
                let total = $('.product-checkbox').length;
                let checked = $('.product-checkbox:checked').length;
                $('#checkAll').prop('checked', total === checked);
            });
        });

        


        $(document).ready(function() 
        {
            $("#categoryDiscountEditForm").on('submit', (function(e)
            {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
                var fd = new FormData(this);
                fd.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url:  "{{ route('category-discount.update', $data->id)  }}",
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
                                window.location.href = '{{ url('category-discount') }}';
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

                        $('#categoryDiscountEditForm')[0].reset();
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
