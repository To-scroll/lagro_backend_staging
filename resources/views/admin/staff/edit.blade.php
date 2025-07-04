@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Staff</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('staff') }}">Staff List</a></li>
                        <li class="breadcrumb-item active">Edit Staff</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <form id="StaffUpdateForm" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation"  novalidate>
        @csrf
         @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                             <div class="col-md-6 mb-2">
                                <label class="form-label" for="name">Name</label>
                                
                                <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="email">Email</label>
                                
                                <input type="email" class="form-control" id="email" name="email" value="{{ $data->email }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="email">Password</label>
                                
                                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
                            </div>
                            
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="phone">Phone</label>
                                
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ $data->phone }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="date_of_birth">Date of Birth</label>
                                
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $data->date_of_birth }}">
                            </div>
                            
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="place">Place</label>
                                
                                <input type="text" class="form-control" id="place" name="place" value="{{ $data->place }}">
                            </div>
                            
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="position">Position</label>
                                
                                <input type="text" class="form-control" id="position" name="position" value="{{ $data->position }}">
                            </div>
                            
                            <div class="col-md-5 mb-2">
                                <label class="form-label" for="image">Image</label>
                                
                                <input type="file" class="form-control" id="image" name="image" required>
                            </div>

                                
                             <div class="col-md-1 mb-2" style="padding:5px;">
                                <label class="form-label" for="product-title-input">Uploaded Image</label>
                                <img src="{{ asset('public/images/staff') }}/{{ $data->image }}" style="width:80px;height:60px;">

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
            $("#StaffUpdateForm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
                var fd = new FormData(this);
                fd.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: "{{ route('staff.update', $data->id)  }}",
                    type: "post",
                    data: fd,
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
                                window.location.href = '{{ url('staff') }}';
                            });

                        }

                        $('#StaffUpdateForm')[0].reset();
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
