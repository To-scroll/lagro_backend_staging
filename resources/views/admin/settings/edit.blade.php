@extends('layouts.adminlayout')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Edit Setting</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Setting</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <form id="updatesettings-form">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Label</label>
                                    <input type="text" value="{{ $data->label }}" class="form-control" name="label" id="label" readonly style="background-color: #f0f0f0; border: 1px solid #ccc;">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Select Input Type</label>
                                    <select id="inputType" name="input_type" class="form-control">
                                        <option value="text" {{ $data->type === 'text' ? 'selected' : '' }}>Text</option>
                                      @if ($data->label === 'logo' || $data->label === 'favicon')  <!-- Only show file input option if label is '' -->
                                            <option value="file" {{ $data->type === 'file' ? 'selected' : '' }}>File</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3" id="fileUploadContainer" style="display: none;">
                                    <label>Image</label>
                                    <input type="file" class="form-control" name="image" id="image_id" placeholder="Enter the Image">
                                    @if($data->type === 'file' && $data->value)
                                        <img src="{{ asset('public/images/settings/' . $data->value) }}" alt="Uploaded Image" style="max-height: 100px; margin-top: 10px;">
                                    @endif
                                </div>
                                
                                <div class="col-md-6 mb-3" id="textInputContainer" style="display: none;">
                                    <label>Value</label>
                                    <textarea class="form-control" name="value" id="value_id1">{{ $data->value }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-end mb-3">
                        <a href="{{url('settings')}}" class="btn btn-info">Back</a>
                        <button type="submit" class="btn btn-success w-sm">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')

<script>
     $(document).ready(function() {
        $("#updatesettings-form").on('submit', function(e) {
            e.preventDefault();
            $(".errors").html('');
            var fd = new FormData(this);
            fd.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url:  "{{ route('settings.update', $data->id)  }}",
                type: "post",
                data: fd,
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if (response.status === true) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Updated Successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $(".errors").html('');
                    }   
                },
                error: function(response) {
                    jsonValue = jQuery.parseJSON(response.responseText);
                    $.each(jsonValue.errors, function(field_name, error) {
                        $(document).find('[name=' + field_name + ']')
                            .after(
                                '<small class="form-control-feedback text-danger errors"> ' +
                            error + ' </small>')
                    });
                }
            });
        });
    });
    $(document).ready(function() {
        function toggleInputContainers() {
            var label = $('#label').val();  // Get the current label value

            if (label === 'logo' || label === 'favicon') {
                $('#fileUploadContainer').show(); // Show file input container
                $('#textInputContainer').show(); // Show text input container
                var inputType = $('#inputType').val(); // Check the current selected input type
                
                // Based on selected input type, show the corresponding container
                if (inputType === 'file') {
                    $('#fileUploadContainer').show();
                    $('#textInputContainer').hide();
                } else {
                    $('#fileUploadContainer').hide();
                    $('#textInputContainer').show();
                }

                // When input type changes, toggle the appropriate input container
                $('#inputType').change(function() {
                    if ($(this).val() === 'file') {
                        $('#fileUploadContainer').show();
                        $('#textInputContainer').hide();
                    } else {
                        $('#fileUploadContainer').hide();
                        $('#textInputContainer').show();
                    }
                });
            } else {
                // If label is not 'contact_image', only show the text input container
                $('#fileUploadContainer').hide();
                $('#textInputContainer').show();
            }
        }

        toggleInputContainers(); // Run the function on page load
    });

   
</script>
@endsection

