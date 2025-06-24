@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Staff</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Staff List</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-0">
                    <div class="row g-3 clearfix row-deck mb-3">
                        <div class="col-lg-12 col-md-12">
                            <form class="row g-3" id="filter_form">
                            @csrf
                                <div class="row">
                                     <div class="col-md-3 mt-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" id="name_filter" placeholder="Enter Staff Name">
                                    </div>
                                    
                                   
                                    <div class="col-md-5 mt-1" style="padding-top:2.5rem;">
                                        <button type="button" class="btn bg-primary btn-xs text-white"
                                            id="filterBtn">Search
                                        </button>
                                        <button type="button" class="btn bg-danger btn-xs text-white "
                                            id="resetBtn">Reset
                                        </button>
                                        @if(auth()->user()->user_type !== 'staff')
                                            <a href="{{ route('staff.create')}}" class="btn btn-success"><i class="ri-add-line align-bottom me-1"></i>Add New Staff</a>
                                        @endif
                                           
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <div class="card-body">
                <table id="staffTable" class="table nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>SR No.</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
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
<div class="modal fade" id="staffView" aria-hidden="true" tabindex="-1">
	<div class="modal-dialog  modal-lg">

		<div id="staffShow" ></div>
	</div>
</div>
@endsection
@section('scripts')



<script>
var tableX = $('#staffTable').DataTable(
    {
    ajax: 
    {
        url: "{{ route('filter_staff') }}",
        data: function(d)
        {
            d.name = $('#name_filter').val();
        }
    },
    columns: [
        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
        },
       {
            data: 'name',
            name: 'name'
        },

        {
            data: 'phone',
            name: 'phone'
        },
        {
            data: 'email',
            name: 'email'
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


$('#filterBtn').on('click', function() 
{
    tableX.draw();
   
});

$('#resetBtn').on('click', function() 
{
    $('#filter_form')[0].reset();
    tableX.draw();
});


$(document).on('click', '.staffView', function() 
{
    $('#staffShow').html('');
	let thisId = $(this).attr('data-id');
	
    $.ajax({
        url: "{{ url('staff') }}/"+ thisId,
        type: "GET",
        success: function(data) {
            $('#staffShow').html(data);
            $('#staffView').modal('show');
        }

    });

});


$(document).on('click', '#close', function() {
    $('#staffView').modal('hide');
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
                url: "{{ url('staff') }}/" + thisId,
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

</script>
@endsection