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
                <h4 class="mb-sm-0">Edit Product</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('product') }}">Product List</a></li>
                        <li class="breadcrumb-item active">Edit Product</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Edit Product</h4>
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

                <div class="tab-content">
                    <div class="tab-pane show active tab1" id="steparrow-gen-info" role="tabpanel"
                        aria-labelledby="steparrow-gen-info-tab">
                        <form id="submitGeneralUpdateForm" enctype="multipart/form-data">
                            @csrf
                            <div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="steparrow-gen-info-email-input">Product
                                                Title</label>
                                            {{-- ===================================================================================================================================================================== --}}
                                            <input type="hidden" name="product_row_id" id="product_row_id"
                                                value="{{ $data->id }}">
                                            <input type="hidden" name="val_set" value="set1">
                                            {{-- ===================================================================================================================================================================== --}}

                                            <input type="text" class="form-control" id="steparrow-gen-info-email-input"
                                                name="product_name" value="{{ $data->product_name }}" required>
                                            {{-- <div class="invalid-feedback">Please enter an email address</div> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="steparrow-gen-info-username-input">Brand </label>
                                            <input type="text" class="form-control"
                                                id="steparrow-gen-info-username-input" name="brand"
                                                value="{{ $data->brand }}" placeholder="Enter Brand Name" required>
                                            {{-- <div class="invalid-feedback">Please enter a user name</div> --}}
                                        </div>
                                    </div>

                                    <div class="col-md-6">

                                        <label class="form-label" for="steparrow-gen-info-password-input">Category</label>

                                        <select class="js-example-basic-multiple" id="choices-publish-status-input1"
                                            name="category"  required>
                                            @foreach ($category as $row)
                                                <option value="{{ $row->id }}"
                                                    {{ (isset($data->category_id) && $data->category_id == $row->id) ? 'selected' : '' }}>
                                                    {{ $row->category_name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                   {{-- <div class="col-md-6">

                                        <label class="form-label" for="steparrow-gen-info-password-input">Group</label>

                                        <select class="js-example-basic-multiple" id="choices-publish-status-input2"
                                            name="selected_group[]" multiple="multiple" required>

                                            @foreach ($productgroups as $productgroup)
                                                <option value="{{ $productgroup->id }}"
                                                    @if (in_array($productgroup->id, $selectedProductgroups)) selected @endif>
                                                    {{ $productgroup->group_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>--}}
                                    
                                    <div class="col-md-12">


                                        <label for="datepicker-publish-input" class="form-label">Do you want to add
                                            Badge ? </label>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-check form-radio-primary ">
                                                    <label class="form-check-label" for="flexRadioDefault1">Yes</label>
                                                    <input class="form-check-input add_badge" type="radio"
                                                        id="flexRadioDefault1" name="add_badge_status" value="yes"
                                                        {{ $data->add_badge_status == 'yes' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check form-radio-primary">
                                                    <label class="form-check-label" for="flexRadioDefault2">No</label>
                                                    <input class="form-check-input add_badge" type="radio"
                                                        id="flexRadioDefault2" name="add_badge_status" value="no"
                                                        {{ $data->add_badge_status == 'no' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="add_badge_status"></div>
                                        <div id="badgeShow" style="padding-top: 10px;">


                                            <select class="form-select" id="choices-publish-visibility-input"
                                                name="badge" data-choices data-choices-search-false>
                                                <option value="">Choose Badge</option>
                                                @foreach ($badge as $row)
                                                    <option value="{{ $row->id }}"
                                                        {{ $data->badge_id == $row->id ? 'selected' : '' }}>
                                                        {{ $row->badge_name }}</option>
                                                @endforeach()
                                            </select>

                                        </div>



                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label" for="steparrow-gen-info-confirm-password-input">Icon
                                        </label>
                                        <input type="file" class="form-control"
                                            id="steparrow-gen-info-confirm-password-input" name="icon"
                                            placeholder=" Upload Image" required>
                                        {{-- <div class="invalid-feedback">Please enter a confirm password</div> --}}
                                    </div>
                                    <div class="col-md-4">
                                        <img src="{{ $data->icon != '' ? asset('public/images/product/icon') . '/' . $data->icon : 'https://via.placeholder.com/40' }}"
                                            style="margin-top: 2em;height:40px;">
                                    </div>

                                    {{-- <div class="col-md-12" style="padding-top:5px;">
                                        <label class="form-label" for="steparrow-gen-info-username-input">Product Icon
                                        </label>
                                        

                                        <div class="dropzone" style="border: 2px dashed var(--vz-border-color);">
                                            <div class="fallback">
                                                <input name="file" type="file" multiple="multiple">
                                            </div>
                                            <div class="dz-message needsclick">
                                                <div class="mb-3">
                                                    <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                                </div>

                                                <h5>Drop files here or click to upload.</h5>
                                            </div>
                                        </div>

                                        <ul class="list-unstyled mb-0" id="dropzone-preview">
                                            <li class="mt-2" id="dropzone-preview-list">
                                                <!-- This is used as the file preview template -->
                                                <div class="border rounded">
                                                    <div class="d-flex p-2">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar-sm bg-light rounded">
                                                                <img data-dz-thumbnail class="img-fluid rounded d-block"
                                                                    src="#" alt="Product-Image" />
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div class="pt-1">
                                                                <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                                                <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                                                <strong class="error text-danger"
                                                                    data-dz-errormessage></strong>
                                                            </div>
                                                        </div>
                                                        <div class="flex-shrink-0 ms-3">
                                                            <button data-dz-remove
                                                                class="btn btn-sm btn-danger">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <!-- end dropzon-preview -->
                                    </div> --}}
                                    <div class="col-md-5">
                                        <label class="form-label" for="steparrow-gen-info-confirm-password-input">Main
                                            Image</label>
                                        <input type="file" class="form-control"
                                            id="steparrow-gen-info-confirm-password-input" name="image1"
                                            placeholder=" Upload Image" required>
                                        {{-- <div class="invalid-feedback">Please enter a confirm password</div> --}}
                                    </div>
                                    <div class="col-md-1">
                                        <img src="{{ $data->image1 != '' ? asset('public/images/product/') . '/' . $data->image1 : 'https://via.placeholder.com/40' }}"
                                            style="margin-top: 2em;height:40px;">
                                    </div>
                                   {{-- 
                                   <div class="col-md-5">
                                        <label class="form-label" for="steparrow-gen-info-confirm-password-input">
                                            Image2</label>
                                        <input type="file" class="form-control"
                                            id="steparrow-gen-info-confirm-password-input" name="image2"
                                            placeholder=" Upload Image" required>
                                       
                                    </div>
                                    <div class="col-md-1">
                                        <img src="{{ $data->image2 != '' ? asset('public/images/product/') . '/' . $data->image2 : 'https://via.placeholder.com/40' }}"
                                            style="margin-top: 2em;height:40px;">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label" for="steparrow-gen-info-confirm-password-input">
                                            Image3</label>
                                        <input type="file" class="form-control"
                                            id="steparrow-gen-info-confirm-password-input" name="image3"
                                            placeholder=" Upload Image" required>
                                     
                                    </div>
                                    <div class="col-md-1">
                                        <img src="{{ $data->image3 != '' ? asset('public/images/product/') . '/' . $data->image3 : 'https://via.placeholder.com/40' }}"
                                            style="margin-top: 2em;height:40px;">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label" for="steparrow-gen-info-confirm-password-input">
                                            Image4</label>
                                        <input type="file" class="form-control"
                                            id="steparrow-gen-info-confirm-password-input" name="image4"
                                            placeholder=" Upload Image" required>
                                        
                                    </div>
                                    <div class="col-md-1">
                                        <img src="{{ $data->image4 != '' ? asset('public/images/product/') . '/' . $data->image4 : 'https://via.placeholder.com/40' }}"
                                            style="margin-top: 2em;height:40px;">
                                    </div>
                                    --}}
                                    {{-- <div class="col-md-6">

                                        <label class="form-label">Groups</label>

                                        <select class="js-example-basic-multiple" id="choices-publish-status-input2"
                                            name="selected_group[]" multiple="multiple" required>

                                            <option value="">Choose Groups</option>
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}" selected>{{ $group->group_name }}
                                                </option>
                                            @endforeach
                                    </div> --}}
                                    <div class="col-md-6">
                                        <label class="form-label" for="steparrow-gen-info-confirm-password-input">
                                            Meta Description</label>
                                        <textarea class="form-control" name="meta_description" placeholder="Enter Meta Description" required>{{ $data->meta_description }}</textarea>

                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="steparrow-gen-info-confirm-password-input">
                                            Short Description</label>
                                        <textarea class="form-control" name="short_description" placeholder="Enter Meta Description" required>{{ $data->short_description }}</textarea>

                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="steparrow-gen-info-confirm-password-input">
                                            Description</label>


                                        <textarea class="form-control" id="summernote" name="description" placeholder="Enter  Description" required>{{ $data->description }}</textarea>

                                    </div>
                                </div>

                            </div>

                            <div class="d-flex align-items-start gap-3 mt-4">
                                <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                    data-nexttab="steparrow-description-info-tab" id="nextbtn1"><i
                                        class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"
                                        data-step-action="next" value="step_1"></i>Go to more
                                    info</button>
                            </div>
                        </form>
                    </div>
                    <!-- end tab pane -->

                    <div class="tab-pane " id="steparrow-description-info" role="tabpanel"
                        aria-labelledby="steparrow-description-info-tab" data-step="step2" id="wizard_step_2">
                        <form id="variantFormUpdate">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        {{-- ========================================================================================================================================================== --}}
                                        <input type="hidden"name="product_id" id="productId"
                                            value="{{ $data->id }}">
                                        <!-- <input type="hidden"name="variant_Id[]" id="variantId"> -->
                                        <input type="hidden"name="type_edit" id="type_edit"
                                            value="{{ $data->type }}">
                                        {{-- ========================================================================================================================================================== --}}

                                        <label class="form-label" for="manufacturer-name-input">Type
                                        </label>
                                        <select class="form-select type haii" id="choices-publish-visibility-input"
                                            name="type" id="type" disabled>
                                            <option value="simple" {{ $data->type == 'simple' ? 'selected' : '' }} >Simple
                                                Product</option>
                                            <option value="variant" {{ $data->type == 'variant' ? 'selected' : '' }}>Variant
                                                Product</option>
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

                                        <div class="row" id="s_rows_edit_{{ $c }}">
                                            <input type="hidden" name="simple_variant_row_id[]"
                                                value="{{ $variant->id }}">

                                            @php $attribute_id=App\Models\Attributes::getid_attr($variant->attribute_name); @endphp
                                            @php $atr_options=App\Models\AttributeOptions::getAttributeOptions($attribute_id); @endphp

                                            <div class="col-lg-6 mb-3">

                                                <select
                                                    class="country form-control form-select select2 attribute_selection s_attr_edit"
                                                    name="simple_attributes_edit[]"
                                                    id="newattributes_{{ $c }}" required>
                                                    <option value="">Select Attributes</option>
                                                    @foreach ($attributes as $row)
                                                        <option
                                                            value="{{ $row->id }}"{{ $attribute_id == $row->id ? 'selected' : '' }}>
                                                            {{ $row->attribute_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="col-lg-5 mb-3"
                                                id="displayVariationOptionEdit_{{ $c }}">

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
                                                <button type="button"
                                                    class="btn btn rounded-4 btn-danger simpleAttributesBtnDel"
                                                    id="delsimple_{{ $c }}" value="{{ $variant->id }}">X
                                            </div>
                                        </div>
                                    @endforeach
                                @endif


                                <div id="showSimpleAttributes"></div>
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
                                    <button type="button" class="btn btn-secondary" id="addMoreAttributesBtn"  style="display: none;">Add
                                        Variation</button>
                                </div>



                                <!--  <div id="appendNewAttributeListing"></div> -->
                                <input type="hidden" name="v_var_count" id="v_var_count" value="{{ $var_count }}">

                                @php $b=0; @endphp
                                @foreach ($variantData as $variant)
                                    @php $b++; @endphp

                                    <div class="row col-lg-12" id="rows_edit_{{ $b }}">
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
                                                            @php $optionsId = App\Models\AttributeOptions::getOptionsId($attribute_id, $vOption->option_name);
                                                              array_push($explodeVariation, $optionsId); 
                                                              @endphp 


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
  {{-- =================================================================================================================================================================                               --}}
                                <input type="hidden" name="v_attr_edit_set[]" id="v_attr_edit_set">
                                <input type="hidden" name="v_attr_opt_edit_set[]" id="v_attr_opt_edit_set">
                                <input type="hidden" name="val_set" value="set2">
  {{-- =================================================================================================================================================================                               --}}

                            </div>
                            <div class="d-flex align-items-start gap-3 mt-4">
                                <button type="button" class="btn btn-light btn-label previestab"
                                    data-previous="steparrow-gen-info-tab" id="prev1"><i
                                        class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to
                                    General</button>
                                <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                    data-nexttab="pills-experience-tab" id="nextBtn2"><i
                                        class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- end tab pane -->
                    <div class="tab-pane " id="steparrow-sku-info" role="tabpanel"
                        aria-labelledby="steparrow-sku-info-tab">
                        <form class="row g-3" id="skuUpdateForm">
                            @csrf
                            <div id="simple_sku">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">

                                            <input type="text" class="form-control" name="comb_set" id="comb_set" readonly style="background: #bfcfd7;">
                                        </div>
                                    </div>

                                </div>


                                <input type="hidden" name="sku_productId" id="sku_productId">
                                <input type="hidden" name="product_skuid" id="s_skuid">
                                <input type="hidden" name="val_set" value="set3">
                                <input type="hidden" name="pro_type" id="proType">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="mb-2">
                                            <label class="form-label" for="stocks-input">Sku</label>
                                            <input type="text" class="form-control"
                                                name="product_sku"  id="s_sku" required>
                                            {{-- <div class="invalid-feedback">Please Enter a product stocks.</div> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="mb-2">
                                            <label class="form-label" for="product-price-input">Price</label>
                                            <div class="input-group has-validation mb-3">
                                                <span class="input-group-text" id="product-price-addon">$</span>
                                                <input type="text" class="form-control" id="s_price" name="product_price" aria-label="Price"
                                                    aria-describedby="product-price-addon" required>
                                                {{-- <div class="invalid-feedback">Please Enter a product price.</div> --}}
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="mb-2">
                                            <label class="form-label" for="product-discount-input">Special Price</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="product-price-addon">$</span>
                                                <input type="text" class="form-control" id="s_sp_price" name="product_sp_price"
                                                    aria-label="discount" aria-describedby="product-discount-addon">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="mb-2">
                                            <label class="form-label" for="orders-input">Quantity</label>
                                            <input type="text" class="form-control" 
                                                name="product_quantity" id="s_quantity" required>
                                            <div class="invalid-feedback">Please Enter a product orders.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <div class="mb-2">
                                            <label class="form-label" for="orders-input">Stock</label>
                                            <select class="form-select" id="s_stock_status"
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
                                            <input type="file" class="form-control" 
                                                name="product_image[]" id="s_image" required multiple>
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
                                    data-previous="steparrow-gen-info-tab" id="prev2"><i
                                        class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to
                                    General</button>
                                <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                    data-nexttab="pills-experience-tab" id="finishBtn"><i
                                        class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- end tab pane -->
                    <div class="tab-pane " id="pills-experience" role="tabpanel">
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
                    <!-- end tab pane -->
                </div>
                <!-- end tab content -->

            </div>
            <!-- end card body -->
        </div>
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
            $('#summernote').summernote({
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
        $(document).on('click', '#addSimpleAttributesBtn', function() {
            x++;
            var simple_atr_template = '<div class="row" id="s_rows_' + x + '"><div class="col-lg-6 mb-3">' +
                '<select class="country form-control form-select select2 attribute_selection" name="simple_attributes[]" id="newattributes_' +
                x + '" required>' +
                '<option value="">Select Attributes</option>';
            for (var i = 0; i < showAtb.length; i++) {
                simple_atr_template += '<option value="' + showAtb[i]['id'] + '">' + showAtb[i]['attribute_name'] +
                    '</option>';
            }
            simple_atr_template += '</select>' +
                '</div>' +
                '<div class="col-lg-5 mb-3" id="displayVariationOption_' + x + '"></div>' +
                '<div class="col-lg-1 mb-3"><button type="button" class="btn btn rounded-4 btn-danger removeSimpleAttributesRowClass" value="' +
                x + '">-</div></div>';

            $('#showSimpleAttributes').append(simple_atr_template);
            $('.select2').select2();

        });

        $(document).on('click', '.removeSimpleAttributesRowClass', function() {
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
        $(document).on('click', '#addMoreAttributesBtn', function () {
            c++;
        
            // Collect already selected attributes
            let selectedAttributes = [];
            $('.variant_first').each(function () {
                let selectedVal = $(this).val();
                if (selectedVal) {
                    selectedAttributes.push(selectedVal);
                }
            });
        
            // Build new select options excluding already selected ones
            var new_template = '<div class="row col-lg-12" id="rows_' + c + '"><div class="col-lg-6 mb-3">';
            new_template += '<select class="form-control form-select select2 variant_first" name="attributes[]" id="attributes1_' + c + '" required>';
            new_template += '<option value="" selected>Select Attributes</option>';
        
            for (var i = 0; i < showAtb.length; i++) {
                if (!selectedAttributes.includes(showAtb[i]['id'].toString())) {
                    new_template += '<option value="' + showAtb[i]['id'] + '">' + showAtb[i]['attribute_name'] + '</option>';
                }
            }
        
            new_template += '</select></div>' +
                '<div class="col-lg-4 mb-3" id="firstVariantValues_' + c + '"></div>' +
                '<div class="col-lg-2 mb-3"><button type="button" class="btn btn rounded-4 btn-danger removeVariantRowClass" value="' + c + '">-</button></div></div>';
        
            $('#appendNewAttributeListing').append(new_template);
            $('.select2').select2();
        });
        */
        
        $(document).on('click', '#addMoreAttributesBtn', function () {
            c++;
        
            // Collect already selected attributes
            let selectedAttributes = [];
            $('.variant_first').each(function () {
                let selectedVal = $(this).val();
                if (selectedVal) {
                    selectedAttributes.push(selectedVal);
                }
            });
        
            // Build new select options excluding already selected ones
            var new_template = '<div class="row col-lg-12" id="rows_' + c + '"><div class="col-lg-6 mb-3">';
            new_template += '<select class="form-control form-select select2 variant_first" name="attributes[]" id="attributes1_' + c + '" required>';
            new_template += '<option value="" selected>Select Attributes</option>';
        
            for (var i = 0; i < showAtb.length; i++) {
                if (!selectedAttributes.includes(showAtb[i]['id'].toString())) {
                    new_template += '<option value="' + showAtb[i]['id'] + '">' + showAtb[i]['attribute_name'] + '</option>';
                }
            }
        
            new_template += '</select></div>' +
                '<div class="col-lg-4 mb-3" id="firstVariantValues_' + c + '"></div>' +
                '<div class="col-lg-2 mb-3"><button type="button" class="btn btn rounded-4 btn-danger removeVariantRowClass" value="' + c + '">-</button></div></div>';
        
            $('#appendNewAttributeListing').append(new_template);
            $('.select2').select2();
        
            // ✅ Immediately hide the button
            $('#addMoreAttributesBtn').hide();
        
            
        });
        
          // Remove a row and refresh options
        $(document).on('click', '.removeVariantRowClass', function () {
            var thisId = $(this).val();
            $('#rows_' + thisId).remove();
        
            // ✅ Show the Add button ONLY if no rows remain
            if ($('.variant_first').length === 0) {
                $('#addMoreAttributesBtn').show();
            }
        });
        $(document).ready(function () {
            if ($('.variant_first').length === 0) {
                $('#addMoreAttributesBtn').show();
            }
        });
        
      /*
        $(document).on('click', '.removeVariantRowClass', function () {
            var thisId = $(this).val();
            $('#rows_' + thisId).remove();
        });
        
        */
        
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

            var form = $('#submitGeneralUpdateForm')[0];
            //generalFormStore
            var formData = new FormData(form);
            $('#preloader').fadeIn(100);
            $(".errors").html('');
            $.ajax({
                type: "POST",
                url: "{{ route('validateUpdateData') }}",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    //console.log(response);return false;
                    if (response.result == false) {
                        $('#preloader').fadeOut(100);


                        console.log(response);

                        $.each(response.message, function(field_name, error) {

                            if (field_name == 'category' || field_name == 'delivery_area' ||
                                field_name == 'add_badge_status') {
                                $(document).find('[id=' + field_name + ']').after(
                                    '<small class="form-control-feedback text-danger errors"> ' +
                                    error + ' </small>')
                            } else {
                                $(document).find('[name=' + field_name + ']').after(
                                    '<small class="form-control-feedback text-danger errors"> ' +
                                    error + ' </small>')
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
                            url: "{{ route('generalFormUpdate') }}",
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
            var type = $('.type').val();

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

            var form = $('#variantFormUpdate')[0];
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
            console.log("hai type");
            console.log(type);
            if (type == 'variant') {
                console.log("hai");
            
                // Count how many .variant_first selects are present
                var variant_setlength = $('.variant_first').length;
                console.log("variant_setlength:", variant_setlength);
            
                if (variant_setlength == 0) {
                    Swal.fire("Please select attributes from the list and then proceed!");
                    return false;
                }
            
                // Collect selected values from all .variant_first selects
                var v_val_atr = [];
            
                $('.variant_first').each(function() {
                    var selectedVal = $(this).val(); // for single select
                    if (selectedVal && selectedVal !== '') {
                        v_val_atr.push(selectedVal);
                    }
                });
            
                // Show SweetAlert if none selected
                if (v_val_atr.length == 0) {
                    Swal.fire("Please select attributes from the list and then proceed!");
                    return false;
                }
            
                // Now check options inside .displayOptions
                var variant_optlength = $('.displayOptions').length;
            
                if (variant_optlength == 0) {
                    Swal.fire("Please select options from the list and then proceed!");
                    return false;
                }
            
                var v_val_opt = [];
            
                $('.displayOptions').each(function() {
                    var selectedVal = $(this).val();
                    if (selectedVal && selectedVal !== '') {
                        v_val_opt.push(selectedVal);
                    }
                });
            
                if (v_val_opt.length == 0) {
                    Swal.fire("Please select options from the list and then proceed!");
                    return false;
                }
            }

            var formData = new FormData(form);
            $('#preloader').fadeIn(100);
            $(".errors").html('');
            $.ajax({
                type: "POST",
                url: "{{ route('validateUpdateData') }}",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {

                    console.log(response);

                    if (response.result == false) {
                        $('#preloader').fadeOut(100);
                        $.each(response.message, function(field_name, error) {
                            $(document).find('[name=' + field_name + ']').after(
                                '<small class="form-control-feedback text-danger errors"> ' +
                                error + ' </small>')

                        })

                        $('#wizard_step_2').show();
                        $('#pro_2').addClass('active');
                        $('#wizard_step_1').hide();

                        $('#wizard_step_3').hide();
                    }
                    if (response.result == true) {
                        $.ajax({
                            url: "{{ route('variantFormUpdateSubmit') }}",
                            type: 'POST',
                            data: formData,
                            async: false,
                            processData: false,
                            contentType: false,
                            success: function(res) {
                                console.log(res);



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
                                if(res.product_type=='simple')
                                  {
                                    $('#simple_sku').show();
                                    $('#variant_sku').hide();
            
                                    const sku_result = JSON.stringify(res.skus);
                                    var obj_sku=JSON.parse(sku_result);
                                        // console.log(obj_sku);
                                         $('#s_skuid').val(obj_sku['id']);
                                         $('#s_sku').val(obj_sku['sku']);
                                         $('#s_price').val(obj_sku['price']);
                                         $('#s_sp_price').val(obj_sku['special_price']);
                                         $('#s_quantity').val(obj_sku['quantity']);
                                         $('#s_image').val(obj_sku['image']);
                                         $('#s_stock_status').val(obj_sku['stock_status']).trigger('change');
                                         $('#comb_set').val(obj_sku['combination_set']);
                                  }
                              else{
        
                                $('#simple_sku').hide();
                                $('#variant_sku').show();
                                const result = JSON.stringify(res.skus);
                                var obj=JSON.parse(result);
                                    //console.log(obj);
                                $('#cmb_display').html('');
                                  for (var i=0;i<obj.length;i++){
                                    //console.log(obj[i]['stock_status']);
                                    var status_stock=obj[i]['stock_status'];
                                    var sp_price_variant=obj[i]['special_price'];
                                    var variant_sku=obj[i]['sku'];
                                    var price_variant=obj[i]['price'];
                                    var s_image = obj[i]['image'];
                                    var discount = obj[i]['discount'];
                                    
                                    if(sp_price_variant==null)
                                    {
                                      sp_price_variant='';
                                    }
                                    if(price_variant==null)
                                    {
                                      price_variant='';
                                    }
                                    var c_temp='<div class="col-lg-2 mb-3"><input type="text" class="form-control form-control-lg"value="'+obj[i]['combination_set']+'" name="v_cmb_set[]" readonly></div>'+
                                    '<input type="hidden" name="sku_id[]" value="'+obj[i]['id']+'" id="sku_id_'+i+'"><input type="hidden" name="v_cmb_id[]" value="'+obj[i]['combination_id']+'"><div class="col-lg-2 mb-3"><input type="text" class="form-control form-control-lg v_sku" name="v_sku[]" id="v_sku_'+i+'" placeholder="sku"';
                                    if(obj[i]["sku"]!=null)
                                    {
                                        c_temp+='value="'+obj[i]['sku']+'"';
        
                                    }
                                    c_temp+='></div>'+
                                    '<div class="col-lg-1 mb-3"><input type="float" class="form-control form-control-lg v_price"name="v_price[]"placeholder="Price" id="v_price_'+i+'"';
                                      if(obj[i]["price"]!=null)
                                    {
                                        c_temp+='value="'+obj[i]['price']+'"';
        
                                    } 
                                    c_temp+='"></div>'+
                                    '<div class="col-lg-1 mb-3"><input type="float" class="form-control form-control-lg v_spprice" name="v_spprice[]" id="v_spprice_'+i+'" placeholder="Special Price"  value="'+sp_price_variant+'"></div>'+
                                    
                                    // Add discount input field (read-only)
                                    '<div class="col-lg-1 mb-3"><input type="text" class="form-control form-control-lg v_discount" name="v_discount[]" id="v_discount_' + i + '" placeholder="Discount %" value="'+(obj[i]['discount'] || '')+'" readonly></div>' +
                                    
                                                
                                    '<div class="col-lg-1 mb-3"><input type="number"class="form-control form-control-lg v_quantity" name="v_quantity[]" id="v_quantity_'+i+'" placeholder="Quantity" value="'+obj[i]['quantity']+'"></div>'+
                                    
                                    '<div class="col-lg-2 mb-3"><select class="country form-control form-control-lg form-select" aria-label="example" name="v_stock_status[]" id="v_stock_status_'+i+'">'+
                                        '<option value="">Choose Stock status</option>'+
                                            '<option value="in-stock" ';
                                            if(obj[i]["stock_status"]=="in-stock")
                                            {
                                              c_temp+='selected';
                                            }
                                            c_temp+='>In Stock</option>';
                                            c_temp+='<option value="out-of-stock"';
                                            if(obj[i]["stock_status"]=="out-of-stock")
                                            {
                                              c_temp+='selected';
                                            }
                                            c_temp+='>Out Of Stock</option>'+
                                           '</select>'+
                                           
                                      '</div>'+
                                     '<div class="col-lg-2 mb-3">' +
                                        '<input type="file" class="form-control form-control-lg" name="v_image_'+i+'[]" id="v_image_' + i + '" multiple>' +
                                        '</div>';

                                      $('#cmb_display').append(c_temp);
                                  }
        
                              }
                                if (page_back == 1) {
                                    page_back == 0;
                                    $('#prev2').click();
                                }


                                //Swal.fire(res.data);
                            },
                            error: function(response) {
                                console.log(response);
                                var jsonValue = jQuery.parseJSON(response.responseText);
                            
                                $.each(jsonValue.errors, function(field_name, error) {
                                    // Handle array field names like attributes.0
                                    var nameAttr = field_name.replace(/\.\d+/g, '[]');
                            
                                    // Clear previous errors
                                    $(document).find('[name="' + nameAttr + '"]').next('.errors').remove();
                            
                                    // Append new error message
                                    $(document).find('[name="' + nameAttr + '"]')
                                        .after('<small class="form-control-feedback text-danger errors">' + error[0] + '</small>');
                                });
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
            var form = $('#skuUpdateForm')[0];
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
                url: "{{ route('validateUpdateData') }}",
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
                            url: "{{ route('skuFormUpdate') }}",
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

            $('#steparrow-gen-info').removeClass('show');


            $('#steparrow-sku-info').removeClass('active');
            $('#steparrow-sku-info').removeClass('show');
            $('#steparrow-description-info').addClass('show');
            $('#steparrow-description-info').addClass('active');
            $('#steparrow-description-info').show();

            var s_edit_array = [];
            $('#s_attr_edit_set').val(s_edit_array);

            var s_opt_edit_array = [];
            $('#s_attr_opt_edit_set').val(s_opt_edit_array);

            var setsession = window.sessionStorage.setItem("pagevalue", "2");
            var pro_type = $('#type_edit').val();
            var settype = window.sessionStorage.setItem("pro_type", pro_type);

            window.location.reload();
        });
        
        $(document).ready(function(){
            $('.v_attr_opt_edit').select2();
        });
        
        function updateDiscount(index) {
            let price = parseFloat($('#v_price_' + index).val());
            let spPrice = parseFloat($('#v_spprice_' + index).val());
        
            if (!isNaN(price) && price > 0 && !isNaN(spPrice)) {
                if (spPrice === 0 || spPrice >= price) {
                    $('#v_discount_' + index).val('0');
                } else {
                    let discount = Math.round(((price - spPrice) / price) * 100);
                    $('#v_discount_' + index).val(discount);
                }
            } else {
                $('#v_discount_' + index).val('');
            }
        }

        
        $(document).on('keyup', '.v_spprice', function () {
             console.log('for check1 discount');
            let index = $(this).attr('id').split('_').pop();
            updateDiscount(index);
        });
        
        $(document).on('keyup', '.v_price', function () {
             console.log('for check discount');
            let index = $(this).attr('id').split('_').pop();
            updateDiscount(index);
        });

    </script>
@endsection













