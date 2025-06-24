@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Create Staff</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('staff') }}">Staff List</a></li>
                        <li class="breadcrumb-item active">Create Staff</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <form id="StaffCreateForm" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation"
        novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="name">Name</label>
                                
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                            </div>
                            
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="email">Email</label>
                                
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                            </div>
                            
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="phone">Phone</label>
                                
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
                            </div>
                            
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="date_of_birth">Date of Birth</label>
                                
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="Select date of birth">
                            </div>
                            
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="place">Place</label>
                                
                                <input type="text" class="form-control" id="place" name="place" placeholder="Enter place">
                            </div>
                            
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="position">Position</label>
                                
                                <input type="text" class="form-control" id="position" name="position" placeholder="Enter position">
                            </div>
                            
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="image">Image</label>
                                
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" placeholder="Choose image">
                            </div>

                    
                        </div>
                    </div>
                </div>
                <!-- end card -->

                <!-- end card -->
                <div class="text-end mb-3">
                    <a href="{{ url('staff') }}" class="btn btn-primary" style="width:95px;">Back</a>
                    <button type="submit" class="btn btn-success w-sm">Submit</button>
                </div>
            </div>
            <!-- end col -->


            <!-- end col -->
        </div>
        <!-- end row -->

    </form>
@endsection
@section('scripts')
  <script>
        $(document).ready(function() {
            $("#StaffCreateForm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
                $.ajax({
                    url: "{{ route('staff.store') }}",
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
                                title: 'Created Successfully',

                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = '{{ url('staff') }}';
                            });

                        }

                        $('#StaffCreateForm')[0].reset();
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
