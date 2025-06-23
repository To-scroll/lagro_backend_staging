@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Attributes</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Attributes</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-0">

                <div class="row g-4 align-items-center">
                   
                    <h4 class="mb-sm-0">Attributes</h4>
                    <div class="col-sm-auto ms-auto">
                        <div class="hstack gap-2">
                            
                            {{-- <button type="button" class="btn btn-info" data-bs-toggle="offcanvas" href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i> Fliters</button> --}}
                           
                            <button type="button" class="btn btn-success" id="attributeModal" data-toggle="modal"
                            data-target="#badgeCreateModal">
                            <i class="ri-add-line align-bottom me-1"></i> Add New Attribute
                        </button>

                            {{-- <a href="{{ route('attributes.create')}}" class="btn btn-success" ><i class="ri-add-line align-bottom me-1"></i>Add New Attribute </a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="attributeTable" class="table nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 10px;">
                                <div class="form-check">
                                    <input class="form-check-input fs-15" type="checkbox" id="checkAll"  value="option">
                                </div>
                            </th>
                            
                            <th>SR No.</th>
                            <th>Attribute</th>
                            
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        
                    </tbody>
                </table>
                

                
            </div>
        </div>
    </div>
</div>
<div class="modal " id="badgeCreateModal" tabindex="-1" role="dialog" aria-labelledby="badgeCreateModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form id="attributeCreateForm" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation"
        novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-5">
                            <label class="form-label" for="product-title-input">Attribute Name</label>

                            <input type="text" class="form-control" id="product-title-input"
                                value="{{ old('attribute_name') }}" name="attribute_name" placeholder="Enter Attribute Name"
                                required>

                        </div>


                    </div>
                </div>
                <!-- end card -->

                <!-- end card -->
                <div class="text-end mb-3">
                    <a href="{{ url('attributes') }}" class="btn btn-primary" style="width:95px;">Back</a>
                    <button type="submit" class="btn btn-success w-sm">Submit</button>
                </div>
            </div>
            <!-- end col -->


            <!-- end col -->
        </div>
        <!-- end row -->

    </form>
    </div>
</div>
</div>

<div class="modal " id="badgeEditModal" tabindex="-1" role="dialog" aria-labelledby="badgeCreateModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form id="attributeUpdateForm" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation"
        novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-5">
                            <input type="hidden" name="id" id="attributeId" >
                            <label class="form-label" for="product-title-input">Attribute Name</label>
                            
                            <input type="text" class="form-control" id="attibuteName1" 
                                name="attribute_name"  required>
                            
                        </div>
                        

                    </div>
                </div>
                <!-- end card -->

                <!-- end card -->
                <div class="text-end mb-3">
                    <a href="{{ url('attributes') }}" class="btn btn-primary" style="width:95px;">Back</a>
                    <button type="submit" class="btn btn-success w-sm">Update</button>
                </div>
            </div>
            <!-- end col -->


            <!-- end col -->
        </div>
        <!-- end row -->

    </form>
    </div>
</div>
</div>
@endsection
@section('scripts')

<script>
var tableX = $('#attributeTable').DataTable({
    ajax: {
        url: "{{ route('filter_attributes') }}",
        data: function(d) {
            var formData = $('#filter-form').serializeArray();
            var serializedData = {};
            $(formData).each(function(index, obj) {
                serializedData[obj.name] = obj.value;
            });
            $.extend(d, serializedData);
        }
    },
    columns: [
        {
                data: 'checkbox',
                name: 'checkbox',
                
            },
          
        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
        },
       

        {
            data: 'attribute_name',
            name: 'attribute_name'
        },
        
        {
            data: 'action',
            name: 'action'
        },
    ],
    processing: true,
    serverSide: true,
    responsive: true,
    "searching": false,
    "bStateSave": true,
    "bAutoWidth": false,
    "ordering": true,
});
$('#filterBtn').on('click', function() {
            tableX.draw();
            $('#offcanvasExample').offcanvas('hide');
        });
        $('#resetBtn').on('click', function() {
            $('#filter-form')[0].reset();
            tableX.draw();
        });









$(document).on("click", '.remove-item-btn', function() {
    let thisId = $(this).attr('data-id');
    
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this record!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('attributes') }}/" +thisId ,
                method: "DELETE",
                data: {
                    '_token': "{{ csrf_token() }}",
                     
                },
                success: function(res) {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'The record has been deleted.',
                        icon: 'success',
                        timer: 1500
                    });
                    tableX.draw();
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire('Cancelled', 'Your record is safe :)', 'error');
        }
    });
});

$(document).on("click", '#attributeModal', function() {
    console.log("hai");
            $('#badgeCreateModal').modal('show');
        });
        $(document).on("click", '#closeModal', function() {
            $('#badgeCreateModal').modal('hide');
        });


$(document).ready(function() {
            $("#attributeCreateForm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
                $.ajax({
                    url: "{{ route('attributeSave') }}",
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
                                window.location.href = '{{ url('attributes') }}';
                            });

                        }
                        if (response.message == 'error') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                               
                            }).then(function() {
                                window.location.href = '{{ route('attributes.create') }}';
                            });
                        }

                        $('#badgeCreateForm')[0].reset();
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

        $(document).on("click", '#editAttribue', function() {
            const AttributeId = $(this).data("id");

            $.ajax({
                url: '{{ url('fetchAttribute') }}',
                method: 'GET',
                data: {
                    AttributeId: AttributeId
                },
                dataType: 'json',
            success: function(response) {
                console.log(response); // Check if the response object is as expected
                
             $('#attributeId').val(response.id);
             $('#attibuteName1').val(response.attribute_name);
                
                $('#badgeEditModal').modal('show'); 
               
            }
            });
        });


        $(document).ready(function() {
            $("#attributeUpdateForm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();
                $('#preloader').fadeIn(100);
                $.ajax({
                    url: "{{ route('updateAttribute') }}",
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
                                window.location.href = '{{ url('attributes') }}';
                            });

                        }
                        if (response.message == 'error') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                               
                            })
                        }

                        $('#badgeCreateForm')[0].reset();
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