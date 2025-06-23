@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Customer</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('customers') }}">Customer List</a></li>
                        <li class="breadcrumb-item active">Edit Customer</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <form id="categoryUpdateForm" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation"
        novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-5">
                            <input type="hidden" name="id" value="{{$data->id }}">
                            <label class="form-label" for="product-title-input">Customer Name</label>
                            
                            <input type="text" class="form-control" id="product-title-input" value="{{ $data->name }}"
                                name="name" required>
                            <div class="invalid-feedback">Please Enter a product title.</div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label" for="product-title-input">Email</label>
                            <input type="text" class="form-control " name="email"
                                value="{{ $data->email }}" title="Choose your color" required>
                        </div>
                        <div class="mb-5">
                            <label class="form-label" for="product-title-input">Phone</label>
                            <input type="text" class="form-control " name="phone"
                                value="{{ $data->phone }}" title="Choose your color" required>
                        </div>
                        

                    </div>
                </div>
                <!-- end card -->

                <!-- end card -->
                <div class="text-end mb-3">
                    <a href="{{ url('customers') }}" class="btn btn-primary" style="width:95px;">Back</a>
                    <button type="submit" class="btn btn-success w-sm">Update</button>
                </div>
            </div>
            <!-- end col -->


            <!-- end col -->
        </div>
        <!-- end row -->

    </form>
@endsection
@section('scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            $("#categoryUpdateForm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
                $.ajax({
                    url: "{{ route('customerUpdate') }}",
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
                                title: 'Updated Successfully',

                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = '{{ url('customers') }}';
                            });

                        }

                        $('#categoryUpdateForm')[0].reset();
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
