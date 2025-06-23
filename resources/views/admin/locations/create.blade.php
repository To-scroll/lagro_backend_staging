@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Create Location</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('locations') }}">Location List</a></li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <form id="locationsCreateForm" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation"
        novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <label class="form-label" for="product-title-input">Location name</label>

                                <input type="text" class="form-control" id="product-title-input" name="location_name" placeholder="Enter Location Name" required>
                               
                            </div>
                            <div class="col-md-6 mt-2">
                                <label class="form-label" for="product-title-input">Address</label>

                                <input type="text" class="form-control" id="product-title-input" name="location_address" placeholder="Enter Location Address" required>
                               
                            </div>
                            <div class="col-md-6 mt-2">
                                <label class="form-label" for="product-title-input">Phone1</label>

                                <input type="text" class="form-control" id="product-title-input" name="phone1" placeholder="Enter Location Phone1" required>
                               
                            </div>
                            <div class="col-md-6 mt-2">
                                <label class="form-label" for="product-title-input">Phone2</label>

                                <input type="text" class="form-control" id="product-title-input" name="phone2" placeholder="Enter Location Phone2" >
                               
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="form-label" for="product-title-input">Map (google-map link)</label>

                                <input type="text" class="form-control" id="product-title-input" name="map" placeholder="Enter Location Map" required>
                               
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
            $("#locationsCreateForm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
                $.ajax({
                    url: "{{ route('locationsStore') }}",
                    type: "post",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        $('#locationsCreateForm')[0].reset();
                        if (response.message == 'success') {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Created Successfully',

                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = '{{ url('locations') }}';
                            });

                        }

                        $('#locationsCreateForm')[0].reset();
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
