@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Page</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('cms') }}">Page List</a></li>
                        <li class="breadcrumb-item active">Edit Page</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <form id="cmsUpdateForm" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation"
        novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-6">
                            <label class="form-label" for="product-title-input">Page Name</label>
                            <input type="hidden" name="row_id" value="{{ $data->id }}">
                            <input type="text" class="form-control" id="product-title-input" 
                                name="page_name"  value="{{ $data->page_name }}">
                           
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="product-title-input">Meta Title</label>
                            <input type="text" class="form-control " name="meta_title"
                            value="{{ !isset($meta) ?  '' :$meta->title }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="product-title-input">Meta Keyword</label>
                            <input type="text" class="form-control " name="meta_keyword"
                            value="{{ !isset($meta) ?  '' :$meta->keywords }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="product-title-input">Meta Description</label>
                            <input type="text" class="form-control " name="meta_description"
                            value="{{ !isset($meta) ?  '' :$meta->description }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="product-title-input">Route</label>
                            <input type="text" class="form-control " name="route"
                            value="{{ $data->route }}" readonly>
                        </div>
                        @php
                        $disabled='';
                        $staticRouteArray=[];
                        if(in_array($data->route,$staticRouteArray))
                        {
                            $disabled='disabled';
                        }
                    @endphp	
                        <div class="col-md-6">
                            <label class="form-label" for="product-title-input">Is Published</label>
                            
                            <select class="form-select" id="choices-publish-visibility-input" name="is_published"
                                data-choices data-choices-search-false {{$disabled}}>
                                <option value="no"  {{ $data->is_published=='no' ? 'selected': ''}}>No</option>
                    <option value="yes" {{ $data->is_published=='yes' ? 'selected': ''}}>Yes</option>
                            </select>

                        </div>
                        <input type="hidden" name="disabled" value="{{$disabled}}">
                        <div class="col-md-12">
                            <label class="form-label" for="product-title-input">Content</label>
                            <textarea  class="form-control description" id="description" name="content" >{{ $data->content}}</textarea>
                        </div>
                    </div>

                    </div>
                </div>
                <!-- end card -->

                <!-- end card -->
                <div class="text-end mb-3">
                    <a href="{{ url('cms') }}" class="btn btn-primary" style="width:95px;">Back</a>
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
            $("#cmsUpdateForm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
                $.ajax({
                    url: "{{ route('cmsUpdate') }}",
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
                                window.location.href = '{{ url('cms') }}';
                            });

                        }

                        $('#cmsUpdateForm')[0].reset();
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
