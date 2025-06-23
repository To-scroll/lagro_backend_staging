@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Location</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('locations') }}">Location List</a></li>
                        <li class="breadcrumb-item active">Edit Location </li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <form id="locationsUpdateForm" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation"
        novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                           
                            <div class="col-md-6">
                                 <input type="hidden" name="id" value="{{ $data->id }}">
                                <label class="form-label" for="product-title-input">Location name</label>

                                <input type="text" class="form-control" id="product-title-input" name="location_name"  value="{{ $data->location_name }}" required>
                               
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="product-title-input">Location Address</label>

                                <input type="text" class="form-control" id="product-title-input" name="location_address" value="{{ $data->location_address }}" required>
                               
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="product-title-input">Location Phone1</label>

                                <input type="text" class="form-control" id="product-title-input" name="phone1" value="{{ $data->phone1 }}" required>
                               
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="product-title-input">Location Phone2</label>

                                <input type="text" class="form-control" id="product-title-input" name="phone2" value="{{ $data->phone2 }}" >
                               
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="product-title-input">Location Map</label>

                                <input type="text" class="form-control" id="product-title-input" name="map" value="{{ $data->map }}" required>
                               
                            </div>



                        </div>
                    </div>
                </div>
                <!-- end card -->

                <!-- end card -->

            </div>
            <!-- end col -->

            <div class="text-end mb-3">
                <a href="{{ url('locations') }}" class="btn btn-primary" style="width:95px;">Back</a>
                <button type="submit" class="btn btn-success w-sm">Update</button>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </form>
@endsection
@section('scripts')
   

    <script>
        
        $(document).ready(function() {
            $("#locationsUpdateForm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
                $.ajax({
                    url: "{{ route('locationsUpdate') }}",
                    type: "post",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        $('#locationsUpdateForm')[0].reset();
                        if (response.message == 'success') {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Updated Successfully',

                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = '{{ url('locations') }}';
                            });

                        }

                        $('#locationsUpdateForm')[0].reset();
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
