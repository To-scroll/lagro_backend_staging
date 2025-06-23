@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Create Attribute Options</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('attribute-options') }}">Attribute Options List</a></li>
                        <li class="breadcrumb-item active">Create Attribute Options</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <form id="attributeOptionsCreateForm" method="POST" enctype="multipart/form-data" autocomplete="off"
        class="needs-validation" novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-5">
                            <label class="form-label" for="product-title-input">Attributes</label>

                            <select class="form-select attribute" id="choices-publish-visibility-input" name="attribute"
                                data-choices data-choices-search-false>
                                <option value="">Choose</option>
                                @foreach ($data as $row)
                                    <option value="{{ $row->id }}" {{ old('attribute') == $row->id ? 'selected' : '' }}>
                                        {{ $row->attribute_name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="mb-5">
                            <label class="form-label" for="product-title-input">Attribute Option Name</label>

                            <input type="text" class="form-control" id="product-title-input" value=""
                                name="attribute_option" placeholder="Enter attribute_option Name" required>

                        </div>
                        <div class="mb-5" id="color_div">
                            <label class="form-label" for="product-title-input" >Color</label>
                            <input type="color" class="form-control form-control-color" name="color"
                                value="{{ old('color') }}" title="Choose your color" required>
                        </div>


                    </div>
                </div>
                <!-- end card -->

                <!-- end card -->
                <div class="text-end mb-3">
                    <a href="{{ url('badge') }}" class="btn btn-primary" style="width:95px;">Back</a>
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
     $('#color_div').hide();
    
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
            $("#attributeOptionsCreateForm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
               
               
                $.ajax({
                    url: "{{ route('attributeOptionStore') }}",
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
                                window.location.href = '{{ url('attribute-options') }}';
                            });

                        }

                        $('#attributeOptionsCreateForm')[0].reset();
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
