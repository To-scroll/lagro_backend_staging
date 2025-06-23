@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Attribute Options</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('attribute-options') }}">Attribute Options List</a></li>
                        <li class="breadcrumb-item active">Edit Attribute Options</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <form id="attributeOptionsUpdateForm" method="POST" enctype="multipart/form-data" autocomplete="off"
        class="needs-validation" novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-5">
                            <input type="hidden" name="rowId" value="{{ $data->id }}">
                            <label class="form-label" for="product-title-input">Attributes</label>

                            <select class="form-select attribute" id="choices-publish-visibility-input" name="attribute"
                                data-choices data-choices-search-false>
                                <option value="">Choose</option>
                                @foreach($attributes as $row)
                                    <option value="{{ $row->id}}" {{ $data->attribute_id == $row->id ? 'selected':''}}>
                                        {{$row->attribute_name}}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="mb-5">
                            <label class="form-label" for="product-title-input">Attribute Option Name</label>

                            <input type="text" class="form-control" id="product-title-input" value="{{ $data->attribute_option_name }}"
                                name="attribute_option"  required>

                        </div>
                        <div class="mb-5" id="color_div">
                            <label class="form-label" for="product-title-input" >Color</label>
                            <input type="color" class="form-control form-control-color" name="color"
                                value="{{ $data->color}}" title="Choose your color" required>
                        </div>


                    </div>
                </div>
                <!-- end card -->

                <!-- end card -->
                <div class="text-end mb-3">
                    <a href="{{ url('attribute-options') }}" class="btn btn-primary" style="width:95px;">Back</a>
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

    <script type="text/javascript">
     if($('.attribute option:selected').text() != 'color')
 {
    $('#color_div').show(); 
 }
    
     $('.attribute').on('change', function() {
                    var a = $('.attribute option:selected').text();
                    console.log(a.trim());
                    if (a.trim() == 'color') {
                       
                        $('#color_div').show();
                    } else {
                        $('#color_div').hide();
                    }
                });
              
        $(document).ready(function() {
            $("#attributeOptionsUpdateForm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
               
               
                $.ajax({
                    url: "{{ route('attributeOptionUpdate') }}",
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
                                window.location.href = '{{ url('attribute-options') }}';
                            });

                        }

                        $('#attributeOptionsUpdateForm')[0].reset();
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
