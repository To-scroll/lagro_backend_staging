@extends('layouts.adminlayout')
@section('styles')
   
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Create Group</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('groups') }}">Group List</a></li>
                        <li class="breadcrumb-item active">Create Group</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <form id="groupCreateForm" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation"
        novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label" for="product-title-input">Group Name</label>

                                <input type="text" class="form-control" id="product-title-input" 
                                    name="group_name" placeholder="Enter Group Name" required>
                              
                            </div>
                           
                           
                            <div class="col-md-12">
                                <label class="form-label" for="product-title-input">Pincode</label>

                                <select class="form-select" id="select2Ajax" name="selected_pincode[]"
                                    multiple>
                                  
                                </select>
                            </div>
                           
                           
                            
                            



                        </div>
                    </div>
                </div>
                <!-- end card -->

                <!-- end card -->

            </div>
           
            <div class="text-end mb-3">
                <a href="{{ url('groups') }}" class="btn btn-primary" style="width:95px;">Back</a>
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
            $("#groupCreateForm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
                $.ajax({
                    url: "{{ route('groups.store') }}",
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
                                window.location.href = '{{ url('groups') }}';
                            });

                        }

                        $('#groupCreateForm')[0].reset();
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


        $(document).ready(function() {
    $('#select2Ajax').select2({
        ajax: {
            url: '{{url('search')}}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                  results: data.map(function(item) {
                    // console.log(item);
                        return {
                          id: item.id ,
                          
                            text: item.officename + ' - ' + item.id
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 3 // Adjust as needed
    });
});

    </script>
@endsection
