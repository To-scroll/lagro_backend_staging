@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Blog</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('blog') }}">Blog List</a></li>
                        <li class="breadcrumb-item active">Edit Blog</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <form id="blogUpdateForm" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation"  novalidate>
        @csrf
         @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                             <div class="col-md-6 mb-2">
                                <label class="form-label" for="product-title-input">Blog Category</label>
                               
                                <input type="text" class="form-control" id="product-title-input" 
                                    name="blog_category" value="{{ $data->blog_category }}" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="product-title-input">Blog Title</label>
                                <input type="hidden" name="row_id" value="{{ $data->id }}">
                                <input type="text" class="form-control" id="product-title-input" name="blog_title"  value="{{ $data->blog_title }}">
                               
                            </div>
                        
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="product-title-input">Blog Date</label>
                                <input type="date" class="form-control " name="blog_date"value="{{ $data->blog_date }}" required>
                            </div>
                                
                            <div class="col-md-5 mb-2">
                                <label class="form-label" for="product-title-input">Image</label>
                                <input type="file" class="form-control " name="image" required>
                            </div>
                            
                             <div class="col-md-1 mb-2" style="padding:5px;">
                                <label class="form-label" for="product-title-input">Uploaded Image</label>
                                <img src="{{ asset('public/images/blog') }}/{{ $data->image }}" style="width:80px;height:60px;">

                            </div>   
                    
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="product-title-input">Is Published</label>
                                
                                <select class="form-select" id="choices-publish-visibility-input" name="is_published">
                                    <option value="no"  {{ $data->is_published=='no' ? 'selected': ''}}>No</option>
                                    <option value="yes" {{ $data->is_published=='yes' ? 'selected': ''}}>Yes</option>
                                </select>
    
                            </div>
                    
                            <div class="col-md-12 mb-2">
                                <label class="form-label" for="product-title-input">Content</label>
                                <textarea  class="form-control description" id="blog_description" name="blog_description">{{ $data->blog_description}}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- end card -->

                <!-- end card -->
                <div class="text-end mb-3">
                    <a href="{{ url('blog') }}" class="btn btn-primary" style="width:95px;">Back</a>
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
    <style>
        .note-color {
            width: 70px; /* Increase the width of the color picker dropdown */
        }
    </style>
    
    <script>
        $(document).ready(function() {
            $('.description').summernote({
                height: 300,
                fontSizes: ['8', '9', '10', '11', '12', '13', '14', '15', '16', '18', '20', '22', '24', '28', '32', '36', '40', '48'],
                defaultFontSize: '15',
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                ],
                fontNames: [
                    'Source Sans Pro',
                    'Arial',
                    'Helvetica',
                    'Times New Roman',
                    'Georgia',
                    'Verdana'
                ],
                fontNamesIgnoreCheck: [
                    'Source Sans Pro',
                    'Arial',
                    'Helvetica',
                    'Times New Roman',
                    'Georgia',
                    'Verdana'
                ]
            });
    
            // Toggle dropdown visibility manually
            $('.note-editor .note-btn').on('click', function(e) {
                e.stopPropagation();
                $(this).next().toggleClass("show");
            });
    
            // Hide dropdowns when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.note-dropdown-menu').length) {
                    $('.note-editor .note-dropdown-menu').removeClass("show");
                }
            });
        });
    </script>
    
    <script>

        $(document).ready(function() {
            $("#blogUpdateForm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
                var fd = new FormData(this);
                fd.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: "{{ route('blog.update', $data->id)  }}",
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
                                window.location.href = '{{ url('blog') }}';
                            });

                        }

                        $('#blogUpdateForm')[0].reset();
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
