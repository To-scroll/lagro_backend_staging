@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Create Banner</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('banner') }}">Banner List</a></li>
                        <li class="breadcrumb-item active">Banner Category</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <form id="bannerCreateForm" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation"
        novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label" for="product-title-input">Banner Title</label>

                                <input type="text" class="form-control" id="product-title-input" value=""
                                    name="title" placeholder="Enter Banner Title" required>
                               
                            </div>
                           
                            <div class="col-md-4">
                                <label class="form-label" for="product-title-input">Type</label>

                                <select class="form-select type" id="choices-publish-visibility-input" name="type"
                                    data-choices data-choices-search-false>
                                    <option value="">Choose</option>
                                    <option value="banner" {{ old('type')=='banner' ? 'selected':''}}>Banner
                                    </option>
                                    <option value="small-banner"{{ old('type')=='small-banner' ? 'selected':''}}>Small Banner</option>
                                </select>
                            </div>
                            
                            <div class="col-md-12">
                                <label class="form-label" for="product-title-input">Image<span id="img-size"></span></label>
                                <input type="file" class="form-control" id="product-title-input" value=""
                                    name="image" placeholder=" Upload Image"  required>

                            </div>
                            <div class="mb-5">
                                <label for="courseDescription" class="form-label">Description</label>
                                <textarea class="form-control description" id="description" name="description" required>
                            </textarea>
                            </div>
                            



                        </div>
                    </div>
                </div>
                <!-- end card -->

                <!-- end card -->

            </div>
            <!-- end col -->
           
            <div class="text-end mb-3">
                <a href="{{ url('banner') }}" class="btn btn-primary" style="width:95px;">Back</a>
                <button type="submit" class="btn btn-success w-sm">Submit</button>
            </div>
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
            $("#bannerCreateForm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
                $.ajax({
                    url: "{{ route('bannerStore') }}",
                    type: "post",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        $('#bannerCreateForm')[0].reset();
           $('#type option:first').prop('selected',true).trigger("change");
                        if (response.message == 'success') {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Created Successfully',

                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = '{{ url('banner') }}';
                            });

                        }

                        $('#bannerCreateForm')[0].reset();
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
