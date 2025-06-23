@extends('layouts.adminlayout')
@section('styles')


    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3806c3;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Create Product</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('product') }}">Product List</a></li>
                        <li class="breadcrumb-item active">Create Product</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Create New Product</h4>
            </div><!-- end card header -->
            <div class="card-body">

                {{-- <div class="text-center pt-3 pb-4 mb-1">
                        <img src="assets/images/logo-dark.png" alt="" height="17">
                    </div> --}}
                <div class="step-arrow-nav mb-4">
                    <ul class="nav nav-pills custom-nav nav-justified" role="tablist">
                        <li class="nav-item" role="presentation" id="pro_1">
                            <button class="nav-link active" id="steparrow-gen-info-tab" data-bs-toggle="pill" type="button"
                                role="tab" aria-controls="steparrow-gen-info" aria-selected="true">General
                                Information</button>
                        </li>
                        <li class="nav-item" role="presentation" id="pro_1">
                            <button class="nav-link pro_1" id="steparrow-description-info-tab" data-bs-toggle="pill"
                                type="button" role="tab" aria-controls="steparrow-description-info"
                                aria-selected="false">Variants</button>
                        </li>
                        <li class="nav-item" role="presentation" id="pro_1">
                            <button class="nav-link pro_1" id="steparrow-sku-info-tab" data-bs-toggle="pill" type="button"
                                role="tab" aria-controls="steparrow-sku-info" aria-selected="false">Sku</button>
                        </li>
                        <li class="nav-item" role="presentation" id="pro_1">
                            <button class="nav-link pro_1" id="pills-experience-tab" data-bs-toggle="pill" type="button"
                                role="tab" aria-controls="pills-experience" aria-selected="false">Finish</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane show active tab1" id="steparrow-gen-info" role="tabpanel"
                aria-labelledby="steparrow-gen-info-tab">
                <form id="submitGeneralForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label" for="product-title-input">Product Title</label>

                                        <input type="text" class="form-control" id="product-title-input"
                                            name="product_name" value="" placeholder="Enter product name" required>
                                        <div class="invalid-feedback">Please Enter a product title.</div>
                                    </div>
                                    <div>
                                        <label>Product Description</label>

                                        <textarea class="form-control" id="description" name="description" required>
												</textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->
                            

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Product Icon (PNG)</h5>
                                </div>
                                <div class="card-body">
                                    
                                    <div class="col-md-12">
                                        
                                        <input type="file" class="form-control" id="product-title-input"
                                            value="" name="icon" required>

                                    </div>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Product Gallery</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-4">
                                        <h5 class="fs-14 mb-1">Product Image</h5>

                                        <div class="text-center">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label" for="product-title-input">Main Image</label>
                                                    <input type="file" class="form-control" id="product-title-input"
                                                        value="" name="image1" required>

                                                </div>
                                                {{--
                                                <div class="col-md-6">
                                                    <label class="form-label" for="product-title-input"> Image2</label>
                                                    <input type="file" class="form-control" id="product-title-input"
                                                        value="" name="image2" required>

                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="product-title-input"> Image3</label>
                                                    <input type="file" class="form-control" id="product-title-input"
                                                        value="" name="image3" required>

                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="product-title-input"> Image4</label>
                                                    <input type="file" class="form-control" id="product-title-input"
                                                        value="" name="image4" required>

                                                </div>
                                                --}}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- end card -->



                            <div class="card">
                                <div class="card-header">
                                    <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab"
                                                href="#addproduct-Description-info" role="tab">
                                                Short Description
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#addproduct-metaDescription"
                                                role="tab">
                                                Meta Description
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- end card header -->
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="addproduct-Description-info" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="meta-description-input">Short
                                                            Description</label>
                                                        <textarea class="form-control" id="meta-description-input" placeholder="Enter Short Description" name="short_description" rows="3"></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- end row -->


                                            <!-- end row -->
                                        </div>
                                        <!-- end tab-pane -->

                                        <div class="tab-pane" id="addproduct-metaDescription" role="tabpanel">

                                            <!-- end row -->

                                            <div>
                                                <label class="form-label" for="meta-description-input">Meta
                                                    Description</label>
                                                <textarea class="form-control" id="meta-description-input" placeholder="Enter Meta Description" name="meta_description" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <!-- end tab pane -->
                                    </div>
                                    <!-- end tab content -->
                                </div>
                                <!-- end card body -->
                            </div>







                        </div>
                        <!-- end col -->

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Product </h5>
                                </div>
                                <div class="card-body">
                                    {{--<div class="mb-3">
                                        <label for="choices-publish-status-input" class="form-label">Select Product
                                            Groups</label>

                                        <select class="js-example-basic-multiple" id="selected_group"
                                            name="selected_group[]" multiple="multiple"
                                            style="background-color: rgb(2, 2, 179)">
                                            <option value="">Choose Groups</option>
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}"
                                                    style="background-color: rgb(2, 2, 179)">{{ $group->group_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>--}}

                                    <div>
                                        <label for="choices-publish-visibility-input" class="form-label">Brand</label>
                                        <input type="text" id="datepicker-publish-input" class="form-control"
                                            placeholder="Enter Brand" name="brand" data-provider="flatpickr"
                                            data-enable-time>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Badge</h5>
                                </div>
                                <!-- end card body -->
                                <div class="card-body">
                                    <div>
                                        <label for="datepicker-publish-input" class="form-label">Do you want to add Badge
                                            ? </label>
                                        <div class="form-check form-radio-primary ">
                                            <label class="form-check-label" for="flexRadioDefault1">Yes</label>
                                            <input class="form-check-input add_badge" type="radio"
                                                id="flexRadioDefault1" name="add_badge_status" value="yes"
                                                @if (isset($product) && $product->add_badge_status == 'yes') checked @endif>
                                        </div>&nbsp;
                                        <div class="form-check form-radio-primary">
                                            <label class="form-check-label" for="flexRadioDefault2">No</label>
                                            <input class="form-check-input add_badge" type="radio"
                                                id="flexRadioDefault2" name="add_badge_status"
                                                value="no"@if (isset($product) && $product->add_badge_status == 'no') checked @endif>
                                        </div>
                                        <div id="add_badge_status"></div>
                                        <div id="badgeShow" style="padding-top: 10px;">


                                            <select class="form-select" id="choices-publish-visibility-input"
                                                name="badge" data-choices data-choices-search-false>
                                                <option value="">Choose Badge</option>
                                                @foreach ($badge as $row)
                                                    <option value="{{ $row->id }}"
                                                        @if (isset($product) && $product->badge_id == $row->id) selected @endif>
                                                        {{ $row->badge_name }}
                                                    </option>
                                                @endforeach()
                                            </select>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- end card -->

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Product Categories</h5>
                                </div>
                                <div class="card-body">
                                    <select class="form-select" id="choices-publish-status-input1"
                                        name="category"  required>
                                        <option value="">Choose Categories</option>
                                        @foreach ($category as $row)
                                            <option value="{{ $row->id }}"
                                                @if (isset($product->category_id) && $product->category_id == $row->id) selected @endif>
                                                {{ $row->category_name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                                <!-- end card body -->
                            </div>
                            <input type="hidden" name="val_set" value="set1">
							<input type="hidden" name="product_row_id" id="product_row_id">
							
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3 mt-4">
                        <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab"
                            data-nexttab="steparrow-description-info-tab" id="nextbtn1"><i
                                class="ri-arrow-right-line label-icon align-middle fs-16 ms-2" data-step-action="next"
                                value="step_1"></i>Save & Next
                            </button>
                    </div>
                </form>
                <!-- end col -->
            </div>

            <!-- end row -->





            <div class="tab-pane " id="steparrow-description-info" role="tabpanel"
                aria-labelledby="steparrow-description-info-tab" data-step="step2" id="wizard_step_2">
                <div class="card">
                <form id="variantFormSubmission">
                    @csrf
                    <div class="row g-3" style="padding:10px;">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <input type="hidden"name="product_id" id="productId">
                                <input type="hidden"name="variant_Id[]" id="variantId">
                                <input type="hidden"name="type_edit" id="type_edit">
                                <input type="hidden" name="val_set" value="set2">
                                <label class="form-label" for="manufacturer-name-input" style="margin-left:10px;">Type
                                </label>
                                <select style="margin-left:10px;" class="form-select type" id="choices-publish-visibility-input" name="type"
                                    data-choices data-choices-search-false
                                    @if (isset($product) && ($product->type == 'simple' || $product->type == 'variant')) readonly @endif>
                                    <!--<option value="" selected>Select Type</option>-->

                                    <!--<option value="simple" @if (isset($product) && $product->type == 'simple') selected @endif>-->
                                    <!--    Simple Product-->
                                    <!--</option>-->
                                    <option value="variant" @if (isset($product) && $product->type == 'variant') selected @endif>
                                        Variant Product</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3" style="padding-top: 27.2px;">
                                <button type="button" class="btn btn-secondary" id="attributeCreateBtn"> +
                                    New Attribute</button>&nbsp;&nbsp;

                                <button type="button" class="btn btn-info" id="atrOptBtn" style="color:white;">
                                    + New Attribute option</button>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row col-lg-12 mt-3" id="simpleProductDiv">

                        <div class="col-lg-6 mb-3">

                        </div>
                        <div class="col-lg-4 mb-3">

                        </div>
                        <div class="col-lg-2 mb-3">
                            <button type="button" class="btn btn-secondary" id="addSimpleAttributesBtn"
                                style="    width: 200px;
                                 height: 100%;
                                 float: right;">Add
                                Simple Attributes</button>
                        </div>



                        <input type="hidden" name="s_var_count" id="s_var_count" value="{{ $var_count }}">
                        @php $c=0; @endphp
                        @if (isset($variantData))
                            @foreach ($variantData as $variant)
                                @php $c++; @endphp

                                <div class="row" id="s_rows_edit_{{ $c }}" style="padding:22px;">
                                    <input type="hidden" name="simple_variant_row_id[]" value="{{ $variant->id }}">

                                    @php $attribute_id=App\Models\Attributes::getid_attr($variant->attribute_name); @endphp
                                    @php $atr_options=App\Models\AttributeOptions::getAttributeOptions($attribute_id); @endphp

                                    <div class="col-lg-6 mb-3">

                                        <select
                                            class="country form-control form-select select2 attribute_selection s_attr_edit"
                                            name="simple_attributes_edit[]" id="newattributes_{{ $c }}"
                                            required>
                                            <option value="">Select Attributes</option>
                                            @foreach ($attributes as $row)
                                                <option
                                                    value="{{ $row->id }}"{{ $attribute_id == $row->id ? 'selected' : '' }}>
                                                    {{ $row->attribute_name }}</option>
                                            @endforeach
                                        </select>

                                    </div>

                                    <div class="col-lg-5 mb-3" id="displayVariationOptionEdit_{{ $c }}">

                                        <select
                                            class="country form-control form-select select2 attribute_option_selection s_attr_opt_edit"
                                            name="attribute_option_edit[]" required width="100%">
                                            <option value="">Choose Option</option>

                                            @foreach ($variantOptionData as $vOption)
                                                @if ($variant->id == $vOption->variant_id)
                                                    @php $optionsId=App\Models\AttributeOptions::getOptionsId($attribute_id,$vOption->option_name); @endphp

                                                    @foreach ($atr_options as $att)
                                                        <option value="{{ $att->id }}"
                                                            {{ $att->id == $optionsId ? 'selected' : '' }}>
                                                            {{ $att->attribute_option_name }}</option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-1 mb-3">
                                        <button type="button" class="btn btn rounded-4 btn-danger simpleAttributesBtnDel"
                                            id="delsimple_{{ $c }}" value="{{ $variant->id }}">X
                                    </div>
                                </div>
                            @endforeach
                        @endif


                        <div id="showSimpleAttributes" style="padding:10px;"></div>
                        <input type="hidden" name="s_attr_edit_set[]" id="s_attr_edit_set">
                        <input type="hidden" name="s_attr_opt_edit_set[]" id="s_attr_opt_edit_set">
                        <div class="text-end mb-3">
                            {{-- <button type="submit" class="btn btn-success w-sm" id="submitForm">Submit</button> --}}
                        </div>

                    </div>
                    
                    
                    <div class="row col-lg-12" id="variantProductDiv">
                        <div class="col-lg-6 mb-3">

                        </div>
                        <div class="col-lg-3 mb-3">

                        </div>
                        <div class="col-lg-3 mb-3"><br>
                            <button type="button" class="btn btn-secondary" id="addMoreAttributesBtn">Add
                                Variation</button>
                        </div>



                        <!--  <div id="appendNewAttributeListing"></div> -->
                        <input type="hidden" name="v_var_count" id="v_var_count" value="{{ $var_count }}">

                        @php $b=0; @endphp
                        @foreach ($variantData as $variant)
                            @php $b++; @endphp

                            <div class="row col-lg-12" id="rows_edit_{{ $b }}" style="padding:22px;">
                                <input type="hidden" name="var_variant_row_id[]" value="{{ $variant->id }}">

                                @php $attribute_id=App\Models\Attributes::getid_attr($variant->attribute_name); @endphp
                                @php $atr_options=App\Models\AttributeOptions::getAttributeOptions($attribute_id); @endphp

                                <div class="col-lg-6 mb-3">
                                    <select class="form-control form-select select2 variant_first v_attr_edit"
                                        name="attributes_edit[]" id="attributes1_{{ $b }}" required>
                                        <option value="" selected>Select Attributes</option>
                                        @foreach ($attributes as $row)
                                            <option value="{{ $row->id }}"
                                                {{ $attribute_id == $row->id ? 'selected' : '' }}>
                                                {{ $row->attribute_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @php
                                    $uniq_id = [];
                                    $explodeVariation = [];
                                @endphp

                                <div class="col-lg-4 mb-3" id="firstVariantValuesEdit_{{ $b }}">
                                    <select class="form-control form-select select2 displayOptions v_attr_opt_edit"
                                        name="option_value_edit[]" required multiple>
                                        <option value="">Choose Option</option>
                                        @foreach ($atr_options as $att)
                                            @foreach ($variantOptionData as $vOption)
                                                @if ($variant->id == $vOption->variant_id)
                                                    @php$optionsId = App\Models\AttributeOptions::getOptionsId($attribute_id, $vOption->option_name);
                                                        array_push($explodeVariation, $optionsId); 
                                                    @endphp ?>
                                                    @if (!in_array($att->id, $uniq_id))
                                                        <option value="{{ $attribute_id . '_' . $att->id }}"
                                                            {{ in_array($att->id, $explodeVariation ?? []) ? 'selected' : '' }}>
                                                            {{ $att->attribute_option_name }}</option>
                                                        @php array_push($uniq_id,$att->id); @endphp
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endforeach

                                    </select>

                                </div>
                                <div class="col-lg-2 mb-3"><button type="button"
                                        class="btn btn rounded-4 btn-danger variableAttributesBtnDel"
                                        id="delvariant_{{ $b }}" value="{{ $variant->id }}'">X</div>
                            </div>
                        @endforeach



                        <div id="appendNewAttributeListing"></div>
                        <input type="hidden" name="v_attr_edit_set[]" id="v_attr_edit_set">
                        <input type="hidden" name="v_attr_opt_edit_set[]" id="v_attr_opt_edit_set">

                    </div>
                    
                    
                    
                    <div class="d-flex align-items-start gap-3 mt-4" style="margin-bottom:10px;">
                        <button type="button" class="btn btn-light btn-label previestab"
                            data-previous="steparrow-gen-info-tab" id="prev1"><i
                                class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to
                            General</button>
                        <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab"
                            data-nexttab="pills-experience-tab" id="nextBtn2"><i
                                class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Save & Next</button>
                    </div>
                </form>
                </div>
            </div>
            <!-- end tab pane -->
            <div class="tab-pane " id="steparrow-sku-info" role="tabpanel" aria-labelledby="steparrow-sku-info-tab">
                <div class="card">
                <form class="row g-3" id="skuSaveForm" style="padding:10px;">
                    @csrf
                    <div id="simple_sku">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">

                                    <input type="text" class="form-control" name="comb_set" id="comb_set"
                                        style="background: #bfcfd7;">
                                </div>
                            </div>

                        </div>


                        <input type="hidden" name="sku_productId" id="sku_productId">
                        <input type="hidden" name="s_skuid" id="s_skuid">
                        <input type="hidden" name="val_set" value="set3">
                        <input type="hidden" name="pro_type" id="proType">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="mb-2">
                                    <label class="form-label" for="stocks-input">Sku</label>
                                    <input type="text" class="form-control" id="stocks-input" name="product_sku"
                                        placeholder="product_sku" required>
                                    <div class="invalid-feedback">Please Enter a product stocks.</div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6">
                                <div class="mb-2">
                                    <label class="form-label" for="product-price-input">Price</label>
                                    <div class="input-group has-validation mb-3">
                                        <span class="input-group-text" id="product-price-addon">$</span>
                                        <input type="text" class="form-control" id="product-price-input"
                                            placeholder="Enter price" name="product_price" aria-label="Price"
                                            aria-describedby="product-price-addon" required>
                                        <div class="invalid-feedback">Please Enter a product price.</div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6">
                                <div class="mb-2">
                                    <label class="form-label" for="product-discount-input">Special Price</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="product-price-addon">$</span>
                                        <input type="text" class="form-control" id="product-discount-input"
                                            placeholder="Enter Special Price" name="product_sp_price"
                                            aria-label="discount" aria-describedby="product-discount-addon">
                                    </div>
                                </div>
                            </div>
                             <div class="col-lg-2 col-sm-6">
                                <div class="mb-2">
                                    <label class="form-label" for="product-discount-input">Discount</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="product-price-addon">$</span>
                                        <input type="text" class="form-control" id="product-discount-input"
                                             name="product_discount"
                                            aria-label="discount" aria-describedby="product-discount-addon read only">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="mb-2">
                                    <label class="form-label" for="orders-input">Quantity</label>
                                    <input type="text" class="form-control" id="orders-input" name="product_quantity"
                                        placeholder="Quantity" required>
                                    <div class="invalid-feedback">Please Enter a product orders.</div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="mb-2">
                                    <label class="form-label" for="orders-input">Stock</label>
                                    <select class="form-select" id="choices-publish-visibility-input"
                                        name="product_stock_status" data-choices data-choices-search-false>
                                        <option value="">Choose Stock Status</option>
                                        <option value="in-stock">In Stock </option>
                                        <option value="out-of-stock">Out Of Stock</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="mb-2">
                                    <label class="form-label" for="orders-input">Image</label>
                                    <input type="file" class="form-control" name="product_image[]" id="s_image" required multiple>
                                    <div class="invalid-feedback">Please Enter a product images.</div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    
                    <div id="variant_sku">
                        <div class="row" id="cmb_display"></div>

                    </div>
                    <!-- end col -->

                    <div class="d-flex align-items-start gap-3 mt-4">
                        <button type="button" class="btn btn-light btn-label previestab"
                            data-previous="steparrow-description-info-tab" id="prev2"><i
                                class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to
                            Variants</button>
                        <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab"
                            data-nexttab="pills-experience-tab" id="finishBtn"><i
                                class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit</button>
                    </div>
                </form>
                </div>
            </div>
            <!-- end tab pane -->
            <div class="tab-pane " id="pills-experience" role="tabpanel">
                <div class="card" style="padding:10px;">
                <div class="text-center">

                    <div class="avatar-md mt-5 mb-4 mx-auto">
                        <div class="avatar-title bg-light text-success display-4 rounded-circle">
                            <i class="ri-checkbox-circle-fill"></i>
                        </div>
                    </div>
                    <h5>Well Done !</h5>
                    <p class="text-muted">You have Successfully Created Product</p>
                </div>
                </div>
            </div>
            <!-- end tab pane -->
        </div>
        <!-- end tab content -->


        <!-- end card body -->

        <!-- end card -->
    </div>
    <div class="modal fade attributeModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <center>
                        <h6 class="card-title mb-0" style="text-align:center">Add Atrribute</h6>
                    </center>

                </div>
                <div class="modal-body">
                    <div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-1">
                        <div class="container-fluid">
                            <div class="row">

                                <div class="card-body">
                                    <form id="attributeaddForm" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="from-group">
                                            <label class="form-label">Attribute Name</label>
                                            <input type="text" class="form-control" name="attribute_name"
                                                value="" id="attribute_name">

                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="attributeSubBtn">ADD</button>
                    <button type="button" class="btn btn-secondary modalClose" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade bd-example-modal-lg optionModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">
                    <center>
                        <h6 class="card-title mb-0" style="text-align:center">Add Atribute Options</h6>
                    </center>

                </div>
                <div class="modal-body">
                    <div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-3">
                        <div class="container-fluid">
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="card-body">
                                        <form id="attributeOptionAddForm" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label class="form-label">Attribute Name</label>
                                                    <select class="form-control" name="attributes_name"
                                                        id="modalAttribute">
                                                        <option value="">Select Attributes</option>
                                                        @foreach ($attributes as $row)
                                                            <option value="{{ $row->id }}">
                                                                {{ $row->attribute_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="form-label">Attribute Option Name</label>
                                                    <input type="text" class="form-control" name="option_name"
                                                        value="">
                                                </div>
                                                <div class="col-md-2" id="color_set">
                                                    <label class="form-label">Color</label>
                                                    <input type="color" class="form-control form-control-color"
                                                        name="color" title="Choose your color">
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="attributeOptionSubBtn">ADD</button>
                    <button type="button" class="btn btn-secondary modalClose" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')

    <script>
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: 'Description',
                tabsize: 2,
                height: 180,
            });

        });


        // ====================================================================================

        //  Modal show Hide
        // -------------------------------    
        // -----------------------------------------------------------------------

        $(document).on('click', '#attributeCreateBtn', function() {
            $('.attributeModal').modal('show');
        });

        $(document).on('click', '.modalClose', function() {
            $('.attributeModal').modal('hide');
        });

        $(document).on('click', '#atrOptBtn', function() {
            $('.optionModal').modal('show');
            $('#color_set').hide();
            $('#attributeOptionAddForm')[0].reset();
        });

        $(document).on('click', '.modalClose', function() {
            $('.optionModal').modal('hide');
        });
        // -------------------------------------------------------------------------



        //   Attribute and Attriute option store 
        //  -----------------------------   
        // -------------------------------------------------------------------------

        $("#attributeSubBtn").on('click', function() {

            var form = $('#attributeaddForm')[0];

            var formData = new FormData(form);
            $('#preloader').fadeIn(100);
            $.ajax({
                type: "POST",
                url: "{{ route('attributeStore') }}",
                processData: false,
                contentType: false,
                data: formData,
                success: function(res) {
                    //console.log(res);return false;
                    $('#preloader').fadeOut(100);
                    $('#attributeaddForm')[0].reset();
                    $('.attributeModal').modal('hide');
                    Swal.fire(res.data);
                    if (res.success == true) {
                        $('.attribute_selection')
                            .append("<option value=" + res.value + ">" + res.name + "</option>");
                        $('.variant_first')
                            .append("<option value=" + res.value + ">" + res.name + "</option>");
                        $('#modalAttribute')
                            .append("<option value=" + res.value + ">" + res.name + "</option>");

                        showAttribute_list();

                    }


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

        });
        //  -------------------------------------------------------------------------------

        $("#attributeOptionSubBtn").on('click', function() {
            var modal_option_atr_id = $('#modalAttribute').val();

            var form = $('#attributeOptionAddForm')[0];
            var formData = new FormData(form);
            $('#preloader').fadeIn(100);
            $.ajax({
                type: "POST",
                url: "{{ route('attributeOptionSave') }}",
                processData: false,
                contentType: false,
                data: formData,
                success: function(res) {
                    //console.log(res);return false;
                    $('#preloader').fadeOut(100);
                    $('#attributeOptionAddForm')[0].reset();
                    $('.optionModal').modal('hide');
                    Swal.fire(res.data);
                    if (res.success == true) {

                        $('.attribute_option_selection')
                            .append("<option value=" + res.value + ">" + res.name + "</option>");
                        $('.displayOptions')
                            .append("<option value=" + res.atr_id + '_' + res.value + ">" + res.name +
                                "</option>");


                    }


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

        });


        // ==================================================================================
        showAttribute_list();
        var showAtb;
        var page_back = 0;
        $(document).ready(function() {

            var getsession = window.sessionStorage.getItem("pagevalue");
            var gettype = window.sessionStorage.getItem("pro_type");

            if (getsession != null) {

                $('.step-tab-panel').hide();
                $('#wizard_step_' + getsession).show();


                $('.navIcon').removeClass('active');
                $('#pro_' + getsession).addClass('active')
                $('#preloader').fadeOut(100);

                if (gettype != null) {
                    if (gettype == 'simple') {
                        $('#simpleProductDiv').show();
                        $('#variantProductDiv').hide();
                    }
                    if (gettype == 'variant') {
                        $('#variantProductDiv').show();
                        $('#simpleProductDiv').hide();
                    }
                }

                sessionStorage.removeItem('pagevalue');
            }
        });

        // ==================================================================================
        var type_val = $('.type').val();

        if (type_val == 'simple') {
            $('#simpleProductDiv').show();
            $('#variantProductDiv').hide();
        } else if (type_val == 'variant') {
            $('#variantProductDiv').show();
            $('#simpleProductDiv').hide();
        } else {
            $('#variantProductDiv').hide();
            $('#simpleProductDiv').hide();
        }
        $(document).on('change', '.type', function() {
            var type = $(this).val();
            if (type == 'simple') {
                $('#simpleProductDiv').show();
                $('#variantProductDiv').hide();
            }
            if (type == 'variant') {
                $('#simpleProductDiv').hide();
                $('#variantProductDiv').show();
            }

        });

   
       var x = $('#s_var_count').val();

        $(document).on('click', '#addSimpleAttributesBtn', function () {
            x++;
        
            // Get all currently selected attribute values
            var selectedAttributes = [];
            $('select[name="simple_attributes[]"]').each(function () {
                selectedAttributes.push($(this).val());
            });
        
            // Start building the new row template
            var simple_atr_template = '<div class="row" id="s_rows_' + x + '" style="padding:10px;"><div class="col-lg-6 mb-3">' +
                '<select class="country form-control form-select select2 attribute_selection" name="simple_attributes[]" id="newattributes_' +
                x + '" required>' +
                '<option value="">Select Attributes</option>';
        
            // Add only options that are not already selected
            for (var i = 0; i < showAtb.length; i++) {
                if (!selectedAttributes.includes(showAtb[i]['id'].toString())) {
                    simple_atr_template += '<option value="' + showAtb[i]['id'] + '">' + showAtb[i]['attribute_name'] + '</option>';
                }
            }
        
            simple_atr_template += '</select>' +
                '</div>' +
                '<div class="col-lg-5 mb-3" id="displayVariationOption_' + x + '"></div>' +
                '<div class="col-lg-1 mb-3"><button type="button" class="btn btn rounded-4 btn-danger removeSimpleAttributesRowClass" value="' +
                x + '">-</button></div></div>';
        
            $('#showSimpleAttributes').append(simple_atr_template);
            $('.select2').select2();
        });
        
        // Remove row on button click
        $(document).on('click', '.removeSimpleAttributesRowClass', function () {
            var this_id = $(this).val();
            $("#s_rows_" + this_id).remove();
        });



        var s_edit_array = [];
        $(document).on('change', '.s_attr_edit', function() {
            var thisVal = $(this).val();

            s_edit_array.push(thisVal);
            $('#s_attr_edit_set').val(s_edit_array);

        });
        
        var s_opt_edit_array = [];
        $(document).on('change', '.s_attr_opt_edit', function() {
            var thisVal = $(this).val();

            s_opt_edit_array.push(thisVal);

            $('#s_attr_opt_edit_set').val(s_opt_edit_array);

        });

        var v_edit_array = [];
        $(document).on('change', '.v_attr_edit', function() {
            var thisVal = $(this).val();

            v_edit_array.push(thisVal);
            $('#v_attr_edit_set').val(v_edit_array);

        });

        var v_opt_edit_array = [];
        $(document).on('change', '.v_attr_opt_edit', function() {
            var thisVal = $(this).val();
            v_opt_edit_array.push(thisVal);

            $('#v_attr_opt_edit_set').val(v_opt_edit_array);
        });

        $(document).on('click', '.simpleAttributesBtnDel', function() {
            var v_id = $(this).val();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes,  continue!',
            }).then((result) => {
                if (result.isConfirmed) {
                    var r_id = $(this).attr('id').split('_');
                    //s_edit_array.push(v_id);
                    //$('#s_attr_edit_set').val(s_edit_array);

                    $.ajax({
                        url: "{{ route('deleteSimpleAttributes') }}",
                        type: 'POST',
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'v_id': $(this).val()
                        },
                        success: function(res) {
                            $('#s_rows_edit_' + r_id[1]).remove();
                            Swal.fire('Deleted,Please Complete the Following Steps');
                        }
                    });
                }
            })

        });

        $(document).on('click', '.variableAttributesBtnDel', function() {
            var v_id = $(this).val();

            var r_id = $(this).attr('id').split('_');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes,  continue!',
            }).then((result) => {
                if (result.isConfirmed) {
                    v_edit_array.push(v_id);
                    $('#v_attr_edit_set').val(v_edit_array);

                    $.ajax({
                        url: "{{ route('deleteVariableAttributes') }}",
                        type: 'POST',
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'v_id': $(this).val()
                        },
                        success: function(res) {
                            $('#rows_edit_' + r_id[1]).remove();
                            // Swal.fire('Deleted, Please Complete the Following Steps');
                            page_back = 1;
                            $('#nextBtn2').click();
                        }
                    });
                }
            })

        });

        function showAttribute_list() {

            $.ajax({
                url: "{{ route('showAttributes') }}",
                type: 'POST',
                data: {
                    '_token': "{{ csrf_token() }}"
                },
                success: function(res) {

                    const resultatr = JSON.stringify(res.data);
                    var objatr = JSON.parse(resultatr);
                    showAtb = objatr;

                    //console.log(showAtb);
                }
            });
        }
        
        $(document).on('change', '.attribute_selection', function() {
            var attribute_id = $(this).val();
            var r_id = $(this).attr('id').split('_');


            $('#preloader').fadeIn(100);
            $.ajax({
                url: "{{ url('displayVariation') }}",
                type: "post",
                data: {
                    'attribute_id': attribute_id,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('#preloader').fadeOut(100);
                    $('#displayVariationOption_' + r_id[1]).html(data);
                    $('.select2').select2();
                }

            });

        });

        $(document).on('change', '.s_attr_edit', function() {
            var attribute_id = $(this).val();
            var r_id = $(this).attr('id').split('_');
            $('#preloader').fadeIn(100);
            $.ajax({
                url: "{{ url('displayVariationEdit') }}",
                type: "post",
                data: {
                    'attribute_id': attribute_id,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('#preloader').fadeOut(100);
                    $('#displayVariationOptionEdit_' + r_id[1]).html(data);
                    $('.select2').select2();
                }

            });

        });



        var c = $('#v_var_count').val();
        /*
        
        $(document).on('click', '#addMoreAttributesBtn', function () 
        {
            c++;
        
            // Collect already selected attributes
            var selectedAttributes = [];
            $("select[name='attributes[]']").each(function () {
                var val = $(this).val();
                if (val) {
                    selectedAttributes.push(val);
                }
            });
        
            // Build template excluding selected attributes
            var new_template = '<div class="row col-lg-12" id="rows_' + c + '" style="padding:10px;">' +
                '<div class="col-lg-6 mb-3">' +
                '<select class="form-control form-select select2 variant_first" name="attributes[]" id="attributes1_' + c + '" required>' +
                '<option value="" selected>Select Attributes</option>';
        
            for (var i = 0; i < showAtb.length; i++) {
                if (!selectedAttributes.includes(String(showAtb[i]['id']))) {
                    new_template += '<option value="' + showAtb[i]['id'] + '">' + showAtb[i]['attribute_name'] + '</option>';
                }
            }
        
            new_template += '</select>' +
                '</div>' +
                '<div class="col-lg-4 mb-3" id="firstVariantValues_' + c + '"></div>' +
                '<div class="col-lg-2 mb-3"><button type="button" class="btn btn rounded-4 btn-danger removeVariantRowClass" value="' + c + '">-</button></div>' +
                '</div>';
        
            $('#appendNewAttributeListing').append(new_template);
            $('.select2').select2();
        });
        */
        $(document).on('click', '#addMoreAttributesBtn', function () 
        {
            c++;
        
            // Collect already selected attributes
            var selectedAttributes = [];
            $("select[name='attributes[]']").each(function () {
                var val = $(this).val();
                if (val) {
                    selectedAttributes.push(val);
                }
            });
        
            // Build template excluding selected attributes
            var new_template = '<div class="row col-lg-12" id="rows_' + c + '" style="padding:10px;">' +
                '<div class="col-lg-6 mb-3">' +
                '<select class="form-control form-select select2 variant_first" name="attributes[]" id="attributes1_' + c + '" required>' +
                '<option value="" selected>Select Attributes</option>';
        
            for (var i = 0; i < showAtb.length; i++) {
                if (!selectedAttributes.includes(String(showAtb[i]['id']))) {
                    new_template += '<option value="' + showAtb[i]['id'] + '">' + showAtb[i]['attribute_name'] + '</option>';
                }
            }
        
            new_template += '</select>' +
                '</div>' +
                '<div class="col-lg-4 mb-3" id="firstVariantValues_' + c + '"></div>' +
                '<div class="col-lg-2 mb-3"><button type="button" class="btn btn rounded-4 btn-danger removeVariantRowClass" value="' + c + '">-</button></div>' +
                '</div>';
        
            $('#appendNewAttributeListing').append(new_template);
            $('.select2').select2();
        
            // ✅ Hide the button after adding once
            $('#addMoreAttributesBtn').hide();
        });

        $(document).on('click', '.removeVariantRowClass', function () {
            var thisId = $(this).val();
            $('#rows_' + thisId).remove();
        
            // ✅ Show the Add button again when a row is removed
            $('#addMoreAttributesBtn').show();
        
            // Optional: Refresh options
            refreshVariantAttributeOptions();
        });
        
        function refreshVariantAttributeOptions() {
            var selectedAttributes = [];
        
            // Gather currently selected values
            $("select[name='attributes[]']").each(function () {
                var val = $(this).val();
                if (val) selectedAttributes.push(val);
            });
        
            $("select[name='attributes[]']").each(function () {
                var currentVal = $(this).val();
                var options = '<option value="">Select Attributes</option>';
        
                for (var i = 0; i < showAtb.length; i++) {
                    var idStr = String(showAtb[i]['id']);
                    if (idStr === currentVal || !selectedAttributes.includes(idStr)) {
                        var selected = (idStr === currentVal) ? ' selected' : '';
                        options += '<option value="' + idStr + '"' + selected + '>' + showAtb[i]['attribute_name'] + '</option>';
                    }
                }
        
                $(this).html(options).trigger('change.select2');
            });
        }


        $(document).on('change', '.variant_first', function() {
            var attribute_id = $(this).val();
            var row_id = $(this).attr('id').split('_');
            $('#preloader').fadeIn(100);
            $.ajax({
                url: "{{ url('displayFirstVariation') }}",
                type: "post",
                data: {
                    'attribute_id': attribute_id,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('#preloader').fadeOut(100);
                    $('#firstVariantValues_' + row_id[1]).html(data);
                    $('.select2').select2();
                }

            });

        });
        
        $(document).on('change', '.v_attr_edit', function() {
            var attribute_id = $(this).val();
            var row_id = $(this).attr('id').split('_');
            $('#preloader').fadeIn(100);
            $.ajax({
                url: "{{ url('displayFirstVariationEdit') }}",
                type: "post",
                data: {
                    'attribute_id': attribute_id,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('#preloader').fadeOut(100);
                    $('#firstVariantValuesEdit_' + row_id[1]).html(data);
                    $('.select2').select2();
                }

            });

        });

        //  ==============================================================================================       


        $(document).ready(function() {
            // Function to toggle the badgeShow section based on radio button selection
            function toggleBadgeShow() {
                var addBadgeStatus = $("input[name='add_badge_status']:checked").val();

                // Check the value of the radio button
                if (addBadgeStatus === "yes") {
                    $("#badgeShow").show(); // Show the badgeShow section
                } else {
                    $("#badgeShow").hide(); // Hide the badgeShow section
                }
            }

            // Call the function initially on page load
            toggleBadgeShow();

            // Attach an event listener to the radio buttons
            $("input[name='add_badge_status']").on("change", function() {
                toggleBadgeShow();
            });
        });

        // ============================================================================================

        $(document).on('click', '#nextbtn1', function() {
            $('#wizard_step_2').hide();
            console.log("haii");

            var form = $('#submitGeneralForm')[0];
            //generalFormStore
            var formData = new FormData(form);
            $('#preloader').fadeIn(100);
            $(".errors").html('');
            $.ajax({
                type: "POST",
                url: "{{ route('validateData') }}",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    //console.log(response);return false;
                    if (response.result == false) {
                        $('#preloader').fadeOut(100);


                        console.log(response);

                        $.each(response.message, function(field_name, error) {

                           let field;

    // Handle nested fields like selected_group.0, selected_group.1
                            if (field_name.startsWith('selected_group')) {
                                field = $('#selected_group');
                            } else {
                                field = $('[name="' + field_name + '"]');
                            }
                        
                            if (field.length > 0) {
                                field.after(
                                    '<small class="form-control-feedback text-danger errors">' +
                                    error[0] + '</small>'
                                );
                            } else {
                                console.warn("Field not found:", field_name);
                            }
                        })

                        $('#steparrow-gen-info-tab').show();
                        $('#pro_1').addClass('active');
                        $('#steparrow-description-info').hide();

                        $('#steparrow-sku-info').hide();
                        $('#pills-experience').hide();
                    }
                    if (response.result == true) {
                        $.ajax({
                            url: "{{ route('generalFormStore') }}",
                            type: 'POST',
                            data: formData,
                            async: false,
                            processData: false,
                            contentType: false,
                            success: function(res) {
                                //console.log(res);return false;         

                                $('#preloader').fadeOut(100);
                                $('#productId').val(res.productId);
                                $('#product_row_id').val(res.productId);

                                $('.tab-pane').removeClass('active');
                                $('.nav-link').removeClass('active');
                                $('#steparrow-description-info').addClass('active');
                                $('#steparrow-description-info').addClass('show');
                                $('#steparrow-description-info').show();
                                $('#steparrow-description-info-tab').addClass('active');







                            }
                        });
                    }

                }
            });

        });


        // ===============================================================================================
        $(document).on('click', '#nextBtn2', function() {
            var type = $('#type').val();

            if (type == '') {
                Swal.fire('Please Select Type');
                $('#wizard_step_2').show();
                $('#wizard_step_3').hide();
                $('.navIcon').removeClass('active');
                $('#pro_2').addClass('active')
                $('#nextBtn2').show();
                $('#nextBtn2').css('display', 'block');
                $('#prev1').css('display', 'block');
                return false;
            }

            var form = $('#variantFormSubmission')[0];
            var typeCheck = window.sessionStorage.getItem("pro_type");
            //console.log(window.sessionStorage.getItem("pro_type"));

            if (type == 'simple') {


                var simple_variants = $('.attribute_selection').length;

                if (simple_variants == 0) {
                    Swal.fire("Please select attributes from the list and then proceed!");
                    return false;
                }
                var s_val_atr = [];
                $('.attribute_selection option:selected').each(function() {
                    if ($(this).val() != '') {
                        s_val_atr.push($(this).val());
                    }

                });
                if (s_val_atr.length == 0) {
                    Swal.fire("Please select attributes from the list and then proceed!");
                    return false;
                }

                var simple_variants_optlength = $('.attribute_option_selection').length;


                if (simple_variants_optlength == 0) {
                    Swal.fire("Please select options from the list and then proceed!");
                    return false;
                }
                var s_val_opt = [];
                $('.attribute_option_selection option:selected').each(function() {
                    if ($(this).val() != '') {
                        s_val_opt.push($(this).val());
                    }

                });
                if (s_val_opt.length == 0) {
                    Swal.fire("Please select options from the list and then proceed!");
                    return false;

                }


            }

            if (type == 'variant') {
                var variant_setlength = $('.variant_first').length;

                if (variant_setlength == 0) {
                    Swal.fire("Please select attributes from the list and then proceed!");
                    return false;
                }
                var v_val_atr = [];

                $('.variant_first option:selected').each(function() {
                    if ($(this).val() != '') {
                        v_val_atr.push($(this).val());
                    }

                });
                if (v_val_atr.length == 0) {
                    Swal.fire("Please select attributes from the list and then proceed!");
                    return false;
                }
                var variant_optlength = $('.displayOptions').length;

                if (variant_optlength == 0) {
                    Swal.fire("Please select options from the list and then proceed!");
                    return false;
                }

                var v_val_opt = [];
                $('.displayOptions option:selected').each(function() {
                    if ($(this).val() != '') {
                        v_val_opt.push($(this).val());
                    }

                });
                if (v_val_opt.length == 0) {
                    Swal.fire("Please select otions from the list and then proceed!");
                    return false;
                }
            }
            var formData = new FormData(form);
            $('#preloader').fadeIn(100);
            $(".errors").html('');
            $.ajax({
                type: "POST",
                url: "{{ route('validateData') }}",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) 
                {

                    

                    if (response.result == false) 
                    
                    {
                        $('#preloader').fadeOut(100);
                       if (response.message.hasOwnProperty("attributes.1")) {
                            Swal.fire("select a varient or create a new atribute ");
                            return;
                        }
                    
                        // General error display
                        $.each(response.message, function(field_name, error) {
                            $(document).find('[name="' + field_name + '"]').after(
                                '<small class="form-control-feedback text-danger errors"> ' + error + ' </small>'
                            );
                        });

                        $('#wizard_step_2').show();
                        $('#pro_2').addClass('active');
                        $('#wizard_step_1').hide();

                        $('#wizard_step_3').hide();
                    }
                    
                    else if (response.result == true) {
                        $.ajax({
                            url: "{{ route('variantFormSubmit') }}",
                            type: 'POST',
                            data: formData,
                            async: false,
                            processData: false,
                            contentType: false,
                            success: function(res) {
                                console.log(res.product_type);



                                $('.tab-pane').removeClass('active');
                                $('.nav-link').removeClass('active');
                                $('#steparrow-sku-info-tab').addClass('active');
                                $('#steparrow-sku-info').addClass('active');
                                $('#steparrow-sku-info').addClass('show');
                                $('#steparrow-sku-info').show();

                                $('#sku_productId').val(res.productId);
                                $('#variantId').val(res.new_variant_id);
                                //$('#type').prop("disabled", true);
                                $('#type').val(res.product_type);
                                $('select[name^="type"] option[value="' + res.product_type +
                                    '"]').attr("selected", "selected");
                                $('#type_edit').val(res.product_type);
                                $('#proType').val(res.product_type);
                                
                                
                                if (res.product_type == 'simple') 
                                
                                {
                                    $('#simple_sku').show();
                                    $('#variant_sku').hide();
                                    const sku_result = JSON.stringify(res.skus);
                                    var obj_sku = JSON.parse(sku_result);
                                    console.log(obj_sku[0].combination_set);

                                    $('#s_skuid').val(obj_sku[0].id);
                                    $('#s_sku').val(obj_sku[0].sku);
                                    $('#s_price').val(obj_sku[0].price);
                                    $('#s_sp_price').val(obj_sku[0].special_price);
                                    $('#s_discount').val(obj_sku[0].discount);
                                    $('#s_quantity').val(obj_sku[0].quantity);
                                    $('#s_image').val(obj_sku[0].image);
                                    $('#s_stock_status').val(obj_sku[0].stock_status);
                                    $('#comb_set').val(obj_sku[0].combination_set);
                                    $('#s_stock_status').val(obj_sku[0].stock_status)
                                        .trigger('change');
                                } 
                                
                                else 
                                
                                {

                                    $('#simple_sku').hide();
                                    $('#variant_sku').show();
                                    const result = JSON.stringify(res.skus);
                                    var obj = JSON.parse(result);

                                    $('#cmb_display').html('');
                                    for (var i = 0; i < obj.length; i++) {



                                        var status_stock = obj[i]['stock_status'];
                                        var sp_price_variant = obj[i]['special_price'];
                                        var variant_sku = obj[i]['sku'];
                                        var price_variant = obj[i]['price'];
                                        
                                        if (sp_price_variant == null) {
                                            sp_price_variant = '';
                                        }
                                        if (price_variant == null) {
                                            price_variant = '';
                                        }
                                        var c_temp =
                                            '<div class="col-lg-2 mb-3"><input type="text" class="form-control form-control-lg"value="' +
                                            obj[i]['combination_set'] +
                                            '" name="v_cmb_set[]" readonly></div>' +
                                            '<input type="hidden" name="sku_id[]" value="' +
                                            obj[i]['id'] + '" id="sku_id_' + i +
                                            '"><input type="hidden" name="v_cmb_id[]" value="' +
                                            obj[i]['combination_id'] +
                                            '"><div class="col-lg-2 mb-3"><input type="text" class="form-control form-control-lg v_sku" name="v_sku[]" id="v_sku_' +
                                            i + '"placeholder="sku"';
                                            
                                            if (obj[i]["sku"] != null) {
                                                c_temp += 'value="' + obj[i]['sku'] + '"';
    
                                            }
                                            c_temp += '></div>' +
                                                '<div class="col-lg-1 mb-3"><input type="float" class="form-control form-control-lg v_price"name="v_price[]" id="v_price_' +
                                                i + '" placeholder="Price"';
                                            if (obj[i]["price"] != null) {
                                                c_temp += 'value="' + obj[i]['price'] + '"';
    
                                            }
                                            c_temp += '"></div>' +
                                                '<div class="col-lg-1 mb-3"><input type="float" class="form-control form-control-lg v_spprice" name="v_spprice[]" id="v_spprice_' +
                                                i + '" placeholder="Special Price"  value="' +
                                                sp_price_variant + '"></div>' +
                                                
                                                // Add discount input field (read-only)
                                                '<div class="col-lg-1 mb-3"><input type="text" class="form-control form-control-lg v_discount" name="v_discount[]" id="v_discount_' + i + '" placeholder="Discount %" readonly></div>' +
                                                
                                                '<div class="col-lg-1 mb-3"><input type="number"class="form-control form-control-lg" name="v_quantity[]" id="v_quantity_' +
                                                i + '" placeholder="Quantity" value="' + obj[i][
                                                    'quantity'
                                                ] + '"></div>' +
                                                
                                                '<div class="col-lg-2 mb-3"><select class="country form-control form-control-lg form-select" aria-label="example" name="v_stock_status[]" id="v_stock_status_' +
                                                i + '">' +
                                                '<option value="">Choose Stock status</option>' +
                                                '<option value="in-stock" ';
                                            if (obj[i]["stock_status"] == "in-stock") {
                                                c_temp += 'selected';
                                            }
                                            c_temp += '>In Stock</option>';
                                            c_temp += '<option value="out-of-stock"';
                                            if (obj[i]["stock_status"] == "out-of-stock") {
                                                c_temp += 'selected';
                                            }
                                            c_temp += '>Out Of Stock</option>' +
                                                '</select>' +
                                                '</div>';
                                           
                                            // ADD this for image display and upload input
                                            c_temp += '<div class="col-lg-2 mb-3">' + '<input type="file" class="form-control form-control-lg" name="v_image[]" id="v_stock_status_' +
                                                i + '" multiple> ' +
                                            '</div>';
                                        
                                        $('#cmb_display').append(c_temp);
                                    }

                                }
                                if (page_back == 1) {
                                    page_back == 0;
                                    $('#prev2').click();
                                }


                                //Swal.fire(res.data);
                            }
                        });
                    }


                }
                
                
                
            });

        });
        // =========================================================================================
        $(document).on('click', '#finishBtn', function() {
            console.log('hai admin');
            $('.skuerrors').html('');
            var th = $('#sku_productId').val();
            var pr_type = $('#proType').val();
            var form = $('#skuSaveForm')[0];
            var formData = new FormData(form);
            if (pr_type == 'variant') {
                $('.v_sku').each(function() {
                    var this_id = $(this).attr('id').split('_');
                    if ($(this).val() != '') {
                        var sku_rowid = $('#sku_id_' + this_id[2]).val();

                        $.ajax({
                            url: "{{ route('checkSku') }}",
                            type: 'POST',
                            data: {
                                'this_val': $(this).val(),
                                'sku_rowid': sku_rowid,
                                '_token': "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                if (data == 0) {
                                    $("#v_sku_" + this_id[2]).after(
                                        '<small class="form-control-feedback text-danger skuerrors"></small>'
                                    )
                                } else {
                                    $("#v_sku_" + this_id[2]).after(
                                        '<small class="form-control-feedback text-danger skuerrors"> ' +
                                        data + ' </small>')


                                }

                            }
                        });
                    }


                });
            }


            $(".errors").html('');
            $.ajax({
                type: "POST",
                url: "{{ route('validateData') }}",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {

                    if (response.result == false) {



                        console.log(response.message);
                        if (pr_type == 'simple') {
                            $.each(response.message, function(field_name, error) {

                                $(document).find('[name=' + field_name + ']').after(
                                    '<small class="form-control-feedback text-danger errors"> ' +
                                    error + ' </small>')

                            })

                        }
                        if (pr_type == 'variant') {

                            $.each(response.message, function(field_name, error) {
                                var fname = field_name.split('.');

                                $("#" + fname[0] + "_" + fname[1]).after(
                                    '<small class="form-control-feedback text-danger errors">required</small>'
                                )

                            })
                        }


                    }
                    if (response.result == true) {
                        $.ajax({
                            url: "{{ route('skuFormSubmit') }}",
                            type: 'POST',
                            data: formData,
                            async: false,
                            processData: false,
                            contentType: false,
                            success: function(res) {


                                $('.tab-pane').removeClass('active');
                                $('.nav-link').removeClass('active');
                                $('#pills-experience-tab').addClass('active');
                                $('#pills-experience').addClass('active');
                                $('#pills-experience').addClass('show');
                                $('#pills-experience').show();



                                setTimeout(function() {
                                    window.location.href =
                                        "{{ route('product.index') }}";
                                }, 3000);
                                sessionStorage.removeItem('pro_type');


                            }
                        });
                    }

                }


            });


        });



        // ============================================================================================


        // $(document).ready(function() {
        //     var canProceed = true; // Flag to track whether the user can proceed

        //     // Hide all tab panes except the first one
        //     $('.tab-pane').not(':first').hide();

        //     // Add a click event listener to your tab buttons
        //     $('.nav-link').click(function(e) {
        //         e.preventDefault();

        //         if (canProceed) {
        //             // Check if the current tab's form is valid before proceeding
        //             var currentTabId = $(this).attr('data-bs-target');
        //             var currentForm = $(currentTabId).find('form')[0];

        //             if (currentForm.checkValidity()) {
        //                 // Remove the "active" class from all tab buttons
        //                 $('.nav-link').removeClass('active');

        //                 // Hide the current tab and show the next one
        //                 $(currentTabId).hide();
        //                 $(this).tab('show');

        //                 // Disable the click event on the remaining buttons
        //                 $('.nav-link').not(this).off('click');

        //                 // Update the flag to prevent further clicks
        //                 canProceed = false;

        //                 // Display an alert when the second tab is clicked
        //                 if ($(this).attr('id') === 'steparrow-description-info-tab') {
        //                     alert('You clicked the second tab!');
        //                 }
        //             } else {
        //                 alert('Please fill out the form on this tab before proceeding.');
        //             }
        //         }
        //     });
        // });
        $(document).on('click', '.pro_1', function() {
            console.log("haiiiiii");
            return false;


        });

        $(document).on('click', '#prev1', function() {



            $('#steparrow-description-info-tab').removeClass('active');
            $('#steparrow-gen-info-tab').addClass('active');
            $('#steparrow-gen-info').addClass('active');
            $('#steparrow-gen-info').addClass('show');
            $('#steparrow-gen-info').show();

            $('#steparrow-description-info').removeClass('active');
            $('#steparrow-description-info').removeClass('show');

            var setsession = window.sessionStorage.setItem("pagevalue", "1");
        });
        
        $(document).on('click', '#prev2', function() {
            $('#steparrow-sku-info-tab').removeClass('active');
            $('#steparrow-description-info-tab').addClass('active');

            // $('#steparrow-gen-info').removeClass('show');


            $('#steparrow-sku-info').removeClass('active');
            $('#steparrow-sku-info').removeClass('show');
            // $('#steparrow-description-info').addClass('show');
            $('#steparrow-description-info').addClass('active');
            $('#steparrow-description-info').show();

            var s_edit_array = [];
            $('#s_attr_edit_set').val(s_edit_array);

            var s_opt_edit_array = [];
            $('#s_attr_opt_edit_set').val(s_opt_edit_array);

            var setsession = window.sessionStorage.setItem("pagevalue", "2");
            var pro_type = $('#type_edit').val();
            var settype = window.sessionStorage.setItem("pro_type", pro_type);

            // window.location.reload();
        });
        
        /*for the discount*/
       $(document).on('keyup', '.v_spprice', function () {
            let index = $(this).attr('id').split('_').pop(); // Get the index from the ID
            let price = parseFloat($('#v_price_' + index).val());       // Get Price
            let spPrice = parseFloat($(this).val());                    // Get Special Price
        
            if (!isNaN(price) && price > 0 && !isNaN(spPrice)) {
                if (spPrice === 0 || spPrice >= price) {
                    $('#v_discount_' + index).val('0');
                } else {
                    let discount = Math.round(((price - spPrice) / price) * 100); // Round to nearest whole number
                    $('#v_discount_' + index).val(discount);
                }
            } else {
                $('#v_discount_' + index).val('');
            }
        });


        
        
       

    </script>
@endsection
