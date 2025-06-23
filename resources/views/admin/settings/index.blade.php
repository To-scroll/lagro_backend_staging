@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Settings</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                {{-- <div class="card-header border-bottom-dashed">

                    <div class="row g-4 align-items-center">

                        <h4 class="mb-sm-0">Settings</h4>
                        <div class="col-sm-auto ms-auto">
                            <div class="hstack gap-2">

                                <button type="button" class="btn btn-info" data-bs-toggle="offcanvas" href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i> Fliters</button>

                                <button type="button" id="importBtn" class="btn btn-danger">Import</button>
                                <a href="{{ url('store-settings') }}" class="btn btn-success"><i
                                        class="ri-add-line align-bottom me-1"></i>Store Settings</a> 
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="card-header border-bottom-dashed">

                    <div class="row g-4 align-items-center">
                        <div class="col-sm">
                            <div>
                                <h5 class="card-title mb-0">Settings</h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                 <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button> 
                                {{-- <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Add Customer</button>
                                <button type="button" class="btn btn-info"><i class="ri-file-download-line align-bottom me-1"></i> Import</button> - --}}
                                 
                                {{-- 
                                <a href="{{ url('store-settings') }}" class="btn btn-success"><i
                                    class="ri-add-line align-bottom me-1"></i>Store Settings
                                </a> 
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-bottom-dashed border-bottom">
                    <form id="filter-form" nctype="multipart/formdata">
                        <div class="row g-3">
                            <div class="col-xl-6">
                                <div class="search-box">
                                    <input type="text" class="form-control search" placeholder="Search Label" name="label" id="label">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xl-6" style="display:grid!important;">
                                <div class="row g-3">
                                    {{-- <div class="col-sm-4">
                                        <div class="">
                                            <input type="text" class="form-control" id="datepicker-range" data-provider="flatpickr" data-date-format="d M, Y" data-range-date="true" placeholder="Select date">
                                        </div>
                                    </div> --}}
                                    <!--end col-->
                                    {{-- <div class="col-sm-4">
                                        <div>
                                            <select class="form-control" data-plugin="choices" data-choices data-choices-search-false name="choices-single-default" id="idStatus">
                                                <option value="">Status</option>
                                                <option value="all" selected>All</option>
                                                <option value="Active">Active</option>
                                                <option value="Block">Block</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                    <!--end col-->

                                    <div class="col-sm-12">
                                        <div>
                                            <div class="row">
                                                <div class="col-md-3" >
                                            <button type="button" class="btn btn-primary w-100" onclick="SearchData();" id="filterBtn"> <i class="ri-equalizer-fill me-2 align-bottom"></i>Filters</button>
                                                </div>
                                                <div class="col-md-3">
                                            <button  type="button" class="btn bg-danger w-100" id="resetfilterBtn"> <i class="ri-equalizer-fill me-2 align-bottom"></i>Reset</button>
                                                </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!--end col-->
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body">
                    <table id="settingsTable" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10px;">
                                    <div class="form-check">
                                        <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>

                                <th>SR No.</th>
                                <th>Label</th>
                                <th style="width:35%;">Value</th>
                                <th >Action</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>


                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample"
                        aria-labelledby="offcanvasExampleLabel">
                        <div class="offcanvas-header bg-light">
                            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Badge Fliters</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <!--end offcanvas-header-->
                        <form id="filter-form" class="d-flex flex-column justify-content-end h-100">
                            <div class="offcanvas-body">
                                <div class="mb-4">
                                    <label for="datepicker-range"
                                        class="form-label text-muted text-uppercase fw-semibold mb-3">Badge Name</label>
                                    <input type="text" class="form-control" name="badge_name" id="badge_name"
                                        data-provider="flatpickr" data-range="true" placeholder="Select date">
                                </div>
                                {{-- <div class="mb-4">
                                <label for="country-select" class="form-label text-muted text-uppercase fw-semibold mb-3">Color</label>
                                <select class="form-control" data-choices data-choices-multiple-remove="true" name="colour" id="color-select" multiple>
                                    
                                    
                                </select>
                            </div> --}}

                            </div>
                            <!--end offcanvas-body-->
                            <div class="offcanvas-footer border-top p-3 text-center hstack gap-2">
                                <button type="button" class="btn btn-light w-100" id="resetBtn">Clear Filter</button>
                                <button type="button" class="btn btn-success w-100" id="filterBtn">Filters</button>
                            </div>
                            <!--end offcanvas-footer-->
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

	
    
@endsection
@section('scripts')

    <script>
        var tableX = $('#settingsTable').DataTable({
            ajax: {
                url: "{{ url('filter_settings') }}",
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
                    data: 'label',
                    name: 'label'
                },
				        {
                    data: 'value',
                    name: 'value'
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
        tableX.on('draw.dt', function() {
            $('.categoryViewBtn:first').trigger('click');
        });

        $('#filterBtn').on('click', function() {
            tableX.draw();
            $('#offcanvasExample').offcanvas('hide');
        });
        $('#resetfilterBtn').on('click', function() {
            $('#filter-form')[0].reset();
            tableX.draw();
        });

        
      

   
    </script>
@endsection
