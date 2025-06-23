@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Create Faq</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('general-faq') }}">Faq List</a></li>
                        <li class="breadcrumb-item active">Create Faq</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    
    <form id="faqCreateForm" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="mb-5">
                            <label class="form-label" for="product-title-input">Category</label>
                            <input type="text" class="form-control" id="product-title-input" value="" name="faq-category" required>
    
                        </div>
                        
                        <div class="row gy-4">  
                            <div class="col-xxl-4 col-md-4">
                                Add Questions
                            </div>
                            <div class="col-md-4" style="align-content: flex-end;margin-left:43px">
                                <button class="btn btn-secondary" type="button" id="addQuestion" style="font-weight: bold;">+</button> 
                            </div>
                            
                        </div>
                        <div id="appendQuestion"></div>
                        <input type="hidden" name="hiddenVal" id="hiddenVal">
                           
         

                    </div>
                </div>
                <!-- end card -->

                <!-- end card -->
                <div class="text-end mb-3">
                    <a href="{{ url('general-faq') }}" class="btn btn-primary" style="width:95px;">Back</a>
                    <button type="submit" class="btn btn-success w-sm">Create</button>
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

        $(document).ready(function() {
            $("#faqCreateForm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
                $.ajax({
                    url: "{{ route('faqStore')}}",
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
                                window.location.href = '{{ url('general-faq') }}';
                            });

                        }

                        $('#faqCreateForm')[0].reset();
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
    
    <script>
        $('#addQuestion').click(function(){
            $.ajax({
                url:"{{url('get-faq-question')}}",
                type:'get',
                success:function(response){
                    $('#appendQuestion').append(response);
                }
            });
            counter ++;
        });

        $(document).on('click','#removeQuestion',function(){
            $(this).closest('.row').remove();
        });
    </script>
@endsection

