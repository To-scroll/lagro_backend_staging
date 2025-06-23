@extends('layouts.adminlayout')
@section('styles')
 
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Order</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('orders') }}">Order List</a></li>
                        <li class="breadcrumb-item active">Edit Order</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <form id="orderUpdateForm" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation"
        novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" data-select2-id="select2-data-8-j1wn">
                        <h4>Customer Info</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label" for="product-title-input">Name</label>
                                <input type="hidden" name="order_rowId" value="{{ $data->id }}">
                                <input type="hidden" class="form-control" id="formAction" name="formAction" value="add">
                                <input type="text" class="form-control d-none" id="product-id-input">
                                @if (isset($data['customers']['id']))
                                    <input type="hidden" name="customer_rowId" value="{{ $data['customers']['id'] }}">
                                @endif
                                <input type="text" class="form-control" id="product-title-input" name="name"
                                    value="{{ $data->customer_name }}" readonly>


                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="product-title-input">Email</label>
                                <input type="text" class="form-control" name="email"
                                    value="{{ $data->customer_email }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="product-title-input">Phone</label>
                                <input type="text" class="form-control" name="email"
                                    value="{{ $data->customer_phone }}" readonly>

                                {{-- <select class="form-select" id="choices-publish-visibility-input" name="badge_status"
                            data-choices data-choices-search-false>
                            <option value="yes" selected {{ old('badge_status') == 'yes' ? 'selected' : '' }}>Yes
                            </option>
                            <option value="no" {{ old('badge_status') == 'no' ? 'selected' : '' }}>No</option>
                        </select> --}}

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="address_id" value="{{ $data['customer_address']['id'] }}">
                                <label class="form-label" for="product-title-input">Address</label>
                                <textarea type="text" class="form-control" name="address" >{{$data['customer_address']['address']}}</textarea>
                            </div>
                            <div class="col-md-6">

                                <label class="form-label" for="product-title-input">Landmark</label>
                                <input type="text" class="form-control" name="landmark"
                                    value="{{ $data['customer_address']['landmark'] }}">
                            </div>
                            <div class="col-md-6">

                                <label class="form-label" for="product-title-input">Pincode</label>
                                <input type="text" class="form-control" name="pincode"
                                    value="{{ $data['customer_address']['pincode'] }}">
                            </div>
                          
                            {{-- <div class="col-md-6">

                              
                                    <label for="choices-publish-status-input" class="form-label">Select Product Groups</label>
        
                                    <select class="js-example-basic-multiple" id="choices-publish-status-input"
                                        name="selected_group[]" multiple="multiple" style="background-color: rgb(2, 2, 179)">
                                        <option value="">Choose Groups</option>
                                        @foreach ($groups as $group)
                                            <option value="{{ $group->id }}" selected style="background-color: rgb(2, 2, 179)">{{ $group->group_name }}</option>
                                        @endforeach
                                    </select>
                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 style="padding-bottom: 2px;padding-top:15px;">Order Info - {{ $data->order_no }}</h4>
                                <table id="orderTable" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>


                                            <th>SR No.</th>
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>Sku</th>
                                            <th>Combination</th>
                                            <th>Price</th>
                                            <th>Special Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $c=0;@endphp
                                        @foreach ($data->orderItems as $row)
                                            @php $c++; @endphp
                                            <tr>
                                                <td>{{ $c }}</td>
                                                <td>
                                                    @if (isset($row['productData']['image1']))
                                                        <img src="{{ asset('public/images/product') }}/{{ $row['productData']['image1'] ?? '' }}"
                                                            class="img-fluid rounded-circle" alt="" width="80">
                                                    @endif
                                                </td>
                                                <td>

                                                    <input type="hidden" name="orderitems_rowId[]"
                                                        value="{{ $row['id'] }}">
                                                    @if (isset($row['productData']['product_name']))
                                                        <input type="text" class="form-control" name="product_name[]"
                                                            value="{{ $row['productData']['product_name'] }}" readonly>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="product_sku[]"
                                                        value="{{ $row['sku_title'] }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="combination_set[]"
                                                        value="{{ $row['combination'] }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control productPrice"
                                                        name="product_price[]" value="{{ $row['price'] }}"
                                                        id="productPrice_{{ $c }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control productsplPrice"
                                                        name="product_sp_price[]" value="{{ $row['special_price'] }}"
                                                        id="productsplPrice_{{ $c }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control productQty"
                                                        name="product_quantity[]" value="{{ $row['qty'] }}"
                                                        id="productQty_{{ $c }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control productTotal"
                                                        name="total[]" value="{{ $row['total'] }}" readonly
                                                        id="productTotal_{{ $c }}">
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status">
                                    <option value="pending" {{ $data->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="accepted" {{ $data->status == 'accepted' ? 'selected' : '' }}> Accepted
                                    </option>
                                    <option value="rejected" {{ $data->status == 'rejected' ? 'selected' : '' }}>Rejected
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Delivery Status</label>
                                <select class="form-control" name="delivery_status">
                                    <option value="processing" {{ $data->delivery_status == 'processing' ? 'selected' : '' }}>
                                        Processing</option>
                                    <option value="on transit" {{ $data->delivery_status == 'on transit' ? 'selected' : '' }}>
                                        On Transit</option>
                                    <option value="out for delivery"
                                        {{ $data->delivery_status == 'out for delivery' ? 'selected' : '' }}>Out for Delivery
                                    </option>
                                    <option value="delivered" {{ $data->delivery_status == 'delivered' ? 'selected' : '' }}>
                                        Delivered
                                    </option>
                                    <option value="cancelled" {{ $data->delivery_status == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- end card -->

                <!-- end card -->
                <div class="text-end mb-3">
                    <a href="{{ url('orders') }}" class="btn btn-primary" style="width:95px;">Back</a>
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

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Select Groups',
            multiple: true,
            closeOnSelect: false
        });
    });



    $("#orderUpdateForm").on('submit',(function(e) {

           e.preventDefault();
  
    $.ajax({
        url: "{{ route('orderUpdate') }}",
        type:"POST",
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(data)
        {
          //console.log(data);return false;
           $('#preloader').fadeOut(100); 
           Swal.fire('Updated Successfully');
           location.reload();
        },
        error:function (response){
        
          $('#preloader').fadeOut(100); 
        //   jsonValue = jQuery.parseJSON(response.responseText);
        //   $.each(jsonValue.errors,function(field_name,error){
        //     $(document).find('[name='+field_name+']').after('<small class="form-control-feedback text-danger errors"> '+error+' </small>')
        //   });
        }
    });
}));

</script>
@endsection
