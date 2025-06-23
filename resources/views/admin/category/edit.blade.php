@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Category</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('category') }}">Category List</a></li>
                        <li class="breadcrumb-item active">Edit Category</li>
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
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <label class="form-label" for="product-title-input">Category Name</label>

                                <input type="text" class="form-control" id="product-title-input"
                                    value="{{ $data->category_name }}" name="category_name"
                                    placeholder="Enter Category Name" required>
                                <div class="invalid-feedback">Please Enter a product title.</div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label" for="product-title-input">Status</label>

                                <select class="form-select" id="choices-publish-visibility-input" name="status"
                                    data-choices data-choices-search-false>
                                    <option value="yes" selected {{ $data->status == 'yes' ? 'selected' : '' }}>Yes
                                    </option>
                                    <option value="no" {{ $data->status == 'no' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="product-title-input">Is Parent Category</label>

                                <select class="form-select is_parent" id="choices-publish-visibility-input "  name="is_parent"
                                    data-choices data-choices-search-false>
                                    <option value="yes" selected {{ $data->is_parent == 'yes' ? 'selected' : '' }}>Yes
                                    </option>
                                    <option value="no" {{ $data->is_parent == 'no' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                            <div class="col-md-4" id="subcategory">
                                @if ($data->is_parent == 'no')
                                    <label class="form-label" for="product-title-input">Parent Category</label>

                                    <select class="form-select" id="choices-publish-visibility-input" name="parentcategory"
                                        data-choices data-choices-search-false>
                                        <option value="">Choose parent Category</option>
                                        @foreach ($categorylist as $list)
                                            <option value="{{ $list->id }}"
                                                {{ $list->id == $data->parent_category_id ? 'selected' : '' }}>
                                                {{ $list->category_name }}</option>
                                        @endforeach()
                                    </select>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <label class="form-label" for="product-title-input">Priority</label>
                                <input type="text" class="form-control" id="product-title-input"
                                    value="{{ $data->position }}" name="position" required>

                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="product-title-input"> Upload New Category Icon</label>
                                <input type="file" class="form-control" id="product-title-input" value=""
                                    name="category_icon" required>

                            </div>
                            <div class="mb-5">
                                <label for="courseDescription" class="form-label">Description</label>
                                <textarea class="form-control description" id="description" name="description" required>{{ $data->description }}
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
                <a href="{{ url('category') }}" class="btn btn-primary" style="width:95px;">Back</a>
                <button type="submit" class="btn btn-success w-sm">Submit</button>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </form>
@endsection
@section('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css" rel="stylesheet">
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
            $("#categoryUpdateForm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
                $.ajax({
                    url: "{{ route('categoryUpdate') }}",
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
                                title: 'Updated Successfully',

                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = '{{ url('category') }}';
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


        $(document).on('change', '.is_parent', function() {

            var id = $(".is_parent").val();
            if (id == 'no') {
                $.ajax({
                    type: "POST",
                    url: "{{ route('fetchCategory') }}",
                    data: {
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#subcategory').html(data);

                    }
                });
            } else {
                $('#subcategory').html('');
            }



        });
    </script>
@endsection
