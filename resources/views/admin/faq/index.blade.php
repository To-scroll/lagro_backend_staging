@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">FAQ</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">FAQ</li>
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
                       
                        <h4 class="mb-sm-0">FAQ</h4>
                        <div class="col-sm-auto ms-auto">
                            <div class="hstack gap-2">
                                
                                {{-- <button type="button" class="btn btn-info" data-bs-toggle="offcanvas" href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i> Fliters</button> --}}
                               
                                
                                <a href="{{ route('general-faq.create')}}" class="btn btn-success"><i class="ri-add-line align-bottom me-1"></i>Add New Question </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="faqTable" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10px;">
                                    <div class="form-check">
                                        <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>

                                <th>SR No.</th>
                                <th>Category</th>
                               
                                
                               
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>


                   
                   
                </div>
            </div>
        </div>
        {{--
        <div class="col-lg-3">
			<div class="card" id="faqView">
               
            </div>
		</div>
		--}}
    </div>
    <div class="modal fade" id="faqView" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">

            <div id="faqShow" style="height:379px;width:500px;"></div>
        </div>
    </div>
    
@endsection
@section('scripts')

    <script>
        var tableX = $('#faqTable').DataTable({
            ajax: {
                url: "{{ url('filter_faq') }}",
                data: function(d) {
                    var formData = $('#filter-form').serializeArray();
                    var serializedData = {};
                    $(formData).each(function(index, obj) {
                        serializedData[obj.name] = obj.value;
                    });
                    $.extend(d, serializedData);
                }
            },
            columns: [{
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
                    data: 'category',
                    name: 'category'
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
    //     tableX.on('draw.dt', function() {
    //     $('.faqViewBtn:first').trigger('click');
    //   });
       $('#filterBtn').on('click', function() {
            tableX.draw();
            $('#offcanvasExample').offcanvas('hide');
        });
        $('#resetBtn').on('click', function() {
            $('#filter-form')[0].reset();
            tableX.draw();
        });

	

$(document).on("click", '.deleteBtn', function() {
            let thisId = $(this).attr('data-id');
            console.log(thisId);
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
                        url: "{{ url('general-faq') }}/" + thisId,
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
                             tableX.ajax.reload(null, false);
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire('Cancelled', 'Your record is safe :)', 'error');
                }
            });
        });


        
          $(document).on('click', '.faqView', function() {
            $('#customerShow').html('');
			let thisId = $(this).attr('data-id');
            $.ajax({
                url: "{{ url('faqView') }}",
                type: "get",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': thisId
                },
                success: function(data) {

                    $('#faqShow').html(data);
                    $('#faqView').modal('show');
                }

            });

        });


        $(document).on('click', '#close', function() {
            $('#faqView').modal('hide');
        });


        
      /*		$(document).ready(function() {
            $(document).on("click", ".faqViewBtn", function() {
                var faqId = $(this).data("id");

                $.ajax({
                    url: "{{ route('faq.view',['id' => 'faqId']) }}".replace('faqId', faqId),
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);

                        $('#faqView').html(response.faqView);




                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    },
                });
            });
        });
        
        */
        
         
       
    </script>
@endsection
