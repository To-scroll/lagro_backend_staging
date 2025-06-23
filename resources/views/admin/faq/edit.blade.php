@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Faq</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('general-faq') }}">Faq List</a></li>
                        <li class="breadcrumb-item active">Edit Faq</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <form id="faqUpdateForm" method="POST" enctype="multipart/form-data" >
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        
                        
                        
                        
                        <div class="mb-5">
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <label class="form-label" for="product-title-input">Category</label>
                            <input type="text" class="form-control" id="product-title-input" value="{{$data->category}}" name="faq-category" required>
    
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
                        @foreach($faq as $question)
                            <div class="row mb-3" data-row-id="{{ $question->id }}">
                                <input type="hidden" name="question_ids[]" value="{{ $question->id }}">
                                <div class="col-xxl-6 col-md-3" >
                                    <div>
                                        <label>Question</label>
                                        <textarea class="form-control" name="question[]" rows="2" required>{{ $question->question }}</textarea>
                                    </div>
                                
                                    <div>
                                        <label>Answer</label>
                                        <textarea class="form-control" name="answer[]" rows="2" required>{{ $question->answer }}</textarea>
                                    </div>

                                </div>
                                <div class="col-6" style="align-content: flex-end;padding-left: 99px; margin-top: 45px;">
                                    <button class="btn btn-danger delete-row" type="button" data-row-id="{{ $question->id }}" >
                                    <i class="ri-delete-bin-5-fill fs-16 text-white"></i></button>
                                </div>
                            </div>

                        @endforeach
                               
                    </div>
                </div>
                <!-- end card -->

                <!-- end card -->
                <div class="text-end mb-3">
                    <a href="{{ url('general-faq') }}" class="btn btn-primary" style="width:95px;">Back</a>
                    <button type="submit" class="btn btn-success w-sm">Update</button>
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

            $("#faqUpdateForm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
                $.ajax({
                    url: "{{ route('faqUpdate') }}",
                    type: "post",
                    data: new FormData(this),
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
                                window.location.href = '{{ url('general-faq') }}';
                            });

                        }

                        $('#faqUpdateForm')[0].reset();

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
        
        
        $(document).on('click', '.delete-row', function () {
                var rowId = $(this).data('row-id');
                var url = "{{ route('question.delete', ':id') }}".replace(':id', rowId);
            
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((data) => {
                    if (data.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (response) {
                                Swal.fire(
                                    'Deleted!',
                                    'The question has been deleted.',
                                    'success'
                                ).then(() => {
                                    location.reload(); // ✅ Full page reload after confirmation
                                });
            
                                toastr.success('The question was deleted.', 'Deleted!', {
                                    timeOut: 3000,
                                });
                            },
                            error: function (xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong. Please try again.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

    </script>
@endsection
