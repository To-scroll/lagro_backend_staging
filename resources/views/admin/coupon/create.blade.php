@extends('layouts.adminlayout')
@section('styles')
  
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Create Coupon</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('coupons') }}">Coupon List</a></li>
                        <li class="breadcrumb-item active">Create Coupon</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <form id="couponCreateForm" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation"
        novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label" for="product-title-input">Coupon Code</label>

                                <input type="text" class="form-control" 
                                    name="coupon_code" placeholder="Enter Coupon Code" required>
                               
                            </div>
                           
                            
                           
                           
                            <div class="col-md-4">
                                <label class="form-label" for="product-title-input">Valid upto</label>
                                <input type="text" class="form-control" id="product-title-input" value=""
                                    name="valid_upto" required>

                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="product-title-input">Offer(%)</label>
                                <input type="text" class="form-control" id="product-title-input" value=""
                                    name="offer_percent" required>

                            </div>
                            <div class="mb-5">
                                <label for="courseDescription" class="form-label">Is applied</label>
                                <select class="form-control" id="is_applied" name="is_applied">
                                    <option value="yes">Yes</option>
                                    <option value="no" selected>No</option>
                                  </select>
                            </textarea>
                            </div>
                            <div class="mb-5">
                                <label for="courseDescription" class="form-label">Is expired</label>
                                <select class="form-control" id="is_expired" name="is_expired">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                  </select>
                            </textarea>
                            </div>
                            



                        </div>
                    </div>
                </div>
                <!-- end card -->

                <!-- end card -->

            </div>
          
            <div class="text-end mb-3">
                <a href="{{ url('coupons') }}" class="btn btn-primary" style="width:95px;">Back</a>
                <button type="submit" class="btn btn-success w-sm">Submit</button>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </form>
@endsection
@section('scripts')

    <script>
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: 'Description',
                tabsize: 2,
                height: 180,
            });

        });


        $(document).ready(function() {
            $("#couponCreateForm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
                $.ajax({
                    url: "{{ route('coupons.store') }}",
                    type: "post",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                      
                        if (response.message == 'success') {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Created Successfully',

                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = '{{ url('coupons') }}';
                            });

                        }

                        $('#couponCreateForm')[0].reset();
                    },
                    error: function(response) {

                        $('#preloader').fadeOut(100);
                        jsonValue = jQuery.parseJSON(response.responseText);
                        $.each(jsonValue.errors, function(field_name, error) {
                            $(document).find('[name=' + field_name + ']').after(
                                '<small class="form-control-feedback text-danger errors"> ' +
                                error + ' </small>')
                        });
                    }
                });
            }));
        });
    </script>
@endsection
