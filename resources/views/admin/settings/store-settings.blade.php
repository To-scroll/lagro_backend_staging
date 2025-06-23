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
                <h4 class="mb-sm-0">Strore Settings</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('settings') }}">settings List</a></li>
                        <li class="breadcrumb-item active">Strore Settings</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    <form id="settingsUpdateFrm" autocomplete="off" class="needs-validation" novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label" for="product-title-input">Site Name</label>

                                <input type="text" class="form-control" id="product-title-input" name="site_name"
                                    value="{{ App\Models\Settings::getSettingsvalue('site_name') }}"
                                    placeholder="Enter Site Name" required>

                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="product-title-input">Support Number</label>

                                <input type="text" class="form-control" id="product-title-input" name="support_no"
                                    value="{{ App\Models\Settings::getSettingsvalue('support_no') }}"
                                    placeholder="Enter Support Number" required>

                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="product-title-input">Support Email</label>

                                <input type="text" class="form-control" id="product-title-input" name="support_email"
                                    value="{{ App\Models\Settings::getSettingsvalue('support_email') }}"
                                    placeholder="Enter Support Email" required>

                            </div>
                        </div>
                        <div>
                            <label>Address</label>
                            <input type="hidden" name="address_id">
                            <textarea class="form-control" id="description" name="address" required>
                        {{ App\Models\Settings::getSettingsvalue('address') }}</textarea>
                        </div>
                    </div>
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"> Images</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <label class="form-label">Logo</label>
                                <input type="file" class="form-control" name="logo"
                                    value="{{ App\Models\Settings::getSettingsvalue('logo') }}">
                            </div>
                            <div class="col-md-3" style="padding-top: 5px;">
                                <img src="{{ asset('public/images/settings/logo') }}/{{ App\Models\Settings::getSettingsvalue('logo') }}"
                                    style="width:50px;height:50px;">
                            </div>
                            <div class="col-md-9">
                                <label class="form-label">FavIcon</label>
                                <input type="file" class="form-control" name="favicon"
                                    value="{{ App\Models\Settings::getSettingsvalue('favicon') }}">
                            </div>
                            <div class="col-md-3" style="padding-top: 5px;">
                                <img src="{{ asset('public/images/settings/favicon') }}/{{ App\Models\Settings::getSettingsvalue('favicon') }}"
                                    style="width:50px;height:50px;">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#addproduct-general-info"
                                    role="tab">
                                    App / System
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#addproduct-metadata" role="tab">
                                    Social Links
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#addproduct-metadata1" role="tab">
                                    Stock & Cart
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- end card header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="addproduct-general-info" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="manufacturer-name-input">Tax Name</label>
                                            <input type="text" class="form-control" id="manufacturer-name-input"
                                                name="tax_name"
                                                value="{{ App\Models\Settings::getSettingsvalue('tax_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="manufacturer-brand-input">Tax Number</label>
                                            <input type="text" class="form-control" id="manufacturer-brand-input"
                                                name="tax_number"
                                                value="{{ App\Models\Settings::getSettingsvalue('tax_number') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="manufacturer-brand-input">Header
                                                Description</label>
                                            <input type="text" class="form-control" id="manufacturer-brand-input"
                                                name="header_description"
                                                value="{{ App\Models\Settings::getSettingsvalue('header_description') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="manufacturer-brand-input">Footer
                                                Description</label>
                                            <input type="text" class="form-control" id="manufacturer-brand-input"
                                                name="footer_description"
                                                value="{{ App\Models\Settings::getSettingsvalue('footer_description') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3 form-check form-switch">
                                            <label class="form-label" for="manufacturer-brand-input">Enable Local / Store
                                                Pickup ?</label><br>
                                            <input type="checkbox" class="form-check-input changeEnableLocalStorePickUp"
                                                name="enable_local_store_pickup" style="margin-left:2.8px;"
                                                value="yes"{{ App\Models\Settings::getSettingsvalue('enable_local_store_pickup') == 'yes' ? 'checked' : '' }}
                                                id="setpickup_{{ App\Models\Settings::getSettingsId('enable_local_store_pickup') }}">
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->


                                <!-- end row -->
                            </div>
                            <!-- end tab-pane -->

                            <div class="tab-pane" id="addproduct-metadata" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta-title-input">Facebook</label>
                                            <input type="text" class="form-control" name="facebook"
                                                placeholder="https://facebook.com/shopname" id="meta-title-input"
                                                value="{{ App\Models\Settings::getSettingsvalue('facebook') }}">
                                        </div>
                                    </div>
                                    <!-- end col -->

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta-keywords-input">Instagram Twitter</label>
                                            <input type="text" class="form-control" name="instagram"
                                                placeholder="https://instagram.com/username" id="meta-keywords-input"
                                                value="{{ App\Models\Settings::getSettingsvalue('instagram') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta-keywords-input">Twitter</label>
                                            <input type="text" class="form-control" name="twitter"
                                                placeholder="https://twitter.com/useranme" id="meta-keywords-input"
                                                value="{{ App\Models\Settings::getSettingsvalue('twitter') }}">
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->

                                {{-- <div>
                              <label class="form-label" for="meta-description-input">Meta Description</label>
                              <textarea class="form-control" id="meta-description-input" placeholder="Enter meta description" rows="3"></textarea>
                          </div> --}}
                            </div>
                            <div class="tab-pane" id="addproduct-metadata1" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta-title-input">Min Cart Amount</label>
                                            <input type="float" class="form-control" name="min_cart_amount"
                                                id="meta-title-input"
                                                value="{{ App\Models\Settings::getSettingsvalue('min_cart_amount') }}">
                                        </div>
                                    </div>
                                    <!-- end col -->

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta-keywords-input">Maximum Items Allowed In
                                                Cart</label>
                                            <input type="number" class="form-control" name="max_cart_items"
                                                id="meta-keywords-input"
                                                value="{{ App\Models\Settings::getSettingsvalue('max_cart_items') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta-keywords-input">Low stock limit
                                                <br>(Product will be considered as low stock)</label>
                                            <input type="number" class="form-control" name="low_stock_limit"
                                                id="meta-keywords-input"
                                                value="{{ App\Models\Settings::getSettingsvalue('low_stock_limit') }}">
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->


                            </div>
                            <!-- end tab pane -->
                        </div>
                        <!-- end tab content -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
                <div class="text-end mb-3">
                  <a href="{{ url('settings') }}" class="btn btn-primary" style="width:95px;">Back</a>
                    <button type="submit" class="btn btn-success w-sm">Submit</button>
                </div>
            </div>
            <!-- end col -->

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Country Currency</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label">Country Currency Code</label>

                            {{-- <select class="form-select" id="choices-publish-status-input" name="country_currency_code" data-choices data-choices-search-false>
                         
                      </select> --}}
                            <select class="form-control form-select select2" name="country_currency_code">
                                <!--  <option value="">--Select--</option> -->
                                <option value="AED"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'AED' ? 'selected' : '' }}>
                                    AED - United Arab Emirates Dirham</option>
                                <option value="AFN"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'AFN' ? 'selected' : '' }}>
                                    AFN - Afghanistan Afghani</option>
                                <option value="ALL"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'ALL' ? 'selected' : '' }}>
                                    ALL - Albania Lek</option>
                                <option value="AMD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'AMD' ? 'selected' : '' }}>
                                    AMD - Armenia Dram</option>
                                <option value="ANG"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'ANG' ? 'selected' : '' }}>
                                    ANG - Netherlands Antilles Guilder</option>
                                <option value="AOA"
                                    {{ App\Models\Settings::getSettingsvalue('country-currency-code') == 'AOA' ? 'selected' : '' }}>
                                    AOA - Angola Kwanza</option>
                                <option value="ARS"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'ARS' ? 'selected' : '' }}>
                                    ARS - Argentina Peso</option>
                                <option value="AUD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'AUD' ? 'selected' : '' }}>
                                    AUD - Australia Dollar</option>
                                <option value="AWG"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'AWG' ? 'selected' : '' }}>
                                    AWG - Aruba Guilder</option>
                                <option value="AZN"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'AZN' ? 'selected' : '' }}>
                                    AZN - Azerbaijan Manat</option>
                                <option value="BAM"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'BAM' ? 'selected' : '' }}>
                                    BAM - Bosnia and Herzegovina Convertible Mark</option>
                                <option value="BBD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'BBD' ? 'selected' : '' }}>
                                    BBD - Barbados Dollar</option>
                                <option value="BDT"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'BDT' ? 'selected' : '' }}>
                                    BDT - Bangladesh Taka</option>
                                <option value="BGN"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'BGN' ? 'selected' : '' }}>
                                    BGN - Bulgaria Lev</option>
                                <option value="BHD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'BHD' ? 'selected' : '' }}>
                                    BHD - Bahrain Dinar</option>
                                <option value="BIF"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'BIF' ? 'selected' : '' }}>
                                    BIF - Burundi Franc</option>
                                <option value="BMD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'BMD' ? 'selected' : '' }}>
                                    BMD - Bermuda Dollar</option>
                                <option value="BND"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'BND' ? 'selected' : '' }}>
                                    BND - Brunei Darussalam Dollar</option>
                                <option value="BOB"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'BOB' ? 'selected' : '' }}>
                                    BOB - Bolivia Bolíviano</option>
                                <option value="BRL"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'BRL' ? 'selected' : '' }}>
                                    BRL - Brazil Real</option>
                                <option value="BSD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'BSD' ? 'selected' : '' }}>
                                    BSD - Bahamas Dollar</option>
                                <option value="BTN"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'BTN' ? 'selected' : '' }}>
                                    BTN - Bhutan Ngultrum</option>
                                <option value="BWP"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'BWP' ? 'selected' : '' }}>
                                    BWP - Botswana Pula</option>
                                <option value="BYN"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'BYN' ? 'selected' : '' }}>
                                    BYN - Belarus Ruble</option>
                                <option value="BZD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'BZD' ? 'selected' : '' }}>
                                    BZD - Belize Dollar</option>
                                <option value="CAD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'CAD' ? 'selected' : '' }}>
                                    CAD - Canada Dollar</option>
                                <option value="CDF"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'CDF' ? 'selected' : '' }}>
                                    CDF - Congo/Kinshasa Franc</option>
                                <option value="CHF"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'CHF' ? 'selected' : '' }}>
                                    CHF - Switzerland Franc</option>
                                <option value="CLP"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'CLP' ? 'selected' : '' }}>
                                    CLP - Chile Peso</option>
                                <option value="CNY"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'CNY' ? 'selected' : '' }}>
                                    CNY - China Yuan Renminbi</option>
                                <option value="COP"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'COP' ? 'selected' : '' }}>
                                    COP - Colombia Peso</option>
                                <option value="CRC"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'CRC' ? 'selected' : '' }}>
                                    CRC - Costa Rica Colon</option>
                                <option value="CUC"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'CUC' ? 'selected' : '' }}>
                                    CUC - Cuba Convertible Peso</option>
                                <option value="CUP"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'CUP' ? 'selected' : '' }}>
                                    CUP - Cuba Peso</option>
                                <option value="CVE"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'CVE' ? 'selected' : '' }}>
                                    CVE - Cape Verde Escudo</option>
                                <option value="CZK"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'CZK' ? 'selected' : '' }}>
                                    CZK - Czech Republic Koruna</option>
                                <option value="DJF"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'DJF' ? 'selected' : '' }}>
                                    DJF - Djibouti Franc</option>
                                <option value="DKK"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'DKK' ? 'selected' : '' }}>
                                    DKK - Denmark Krone</option>
                                <option value="DOP"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'DOP' ? 'selected' : '' }}>
                                    DOP - Dominican Republic Peso</option>
                                <option value="DZD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'DZD' ? 'selected' : '' }}>
                                    DZD - Algeria Dinar</option>
                                <option value="EGP"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'EGP' ? 'selected' : '' }}>
                                    EGP - Egypt Pound</option>
                                <option value="ERN"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'ERN' ? 'selected' : '' }}>
                                    ERN - Eritrea Nakfa</option>
                                <option value="ETB"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'ETB' ? 'selected' : '' }}>
                                    ETB - Ethiopia Birr</option>
                                <option value="EUR"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'EUR' ? 'selected' : '' }}>
                                    EUR - Euro Member Countries</option>
                                <option value="FJD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'FJD' ? 'selected' : '' }}>
                                    FJD - Fiji Dollar</option>
                                <option value="FKP"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'FKP' ? 'selected' : '' }}>
                                    FKP - Falkland Islands (Malvinas) Pound</option>
                                <option value="GBP"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'GBP' ? 'selected' : '' }}>
                                    GBP - United Kingdom Pound</option>
                                <option value="GEL"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'GEL' ? 'selected' : '' }}>
                                    GEL - Georgia Lari</option>
                                <option value="GGP"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'GGP' ? 'selected' : '' }}>
                                    GGP - Guernsey Pound</option>
                                <option value="GHS"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'GHS' ? 'selected' : '' }}>
                                    GHS - Ghana Cedi</option>
                                <option value="GIP"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'GIP' ? 'selected' : '' }}>
                                    GIP - Gibraltar Pound</option>
                                <option value="GMD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'GMD' ? 'selected' : '' }}>
                                    GMD - Gambia Dalasi</option>
                                <option value="GNF"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'GNF' ? 'selected' : '' }}>
                                    GNF - Guinea Franc</option>
                                <option value="GTQ"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'GTQ' ? 'selected' : '' }}>
                                    GTQ - Guatemala Quetzal</option>
                                <option value="GYD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'GYD' ? 'selected' : '' }}>
                                    GYD - Guyana Dollar</option>
                                <option value="HKD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'HKD' ? 'selected' : '' }}>
                                    HKD - Hong Kong Dollar</option>
                                <option value="HNL"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'HNL' ? 'selected' : '' }}>
                                    HNL - Honduras Lempira</option>
                                <option value="HRK"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'HRK' ? 'selected' : '' }}>
                                    HRK - Croatia Kuna</option>
                                <option value="HTG"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'HTG' ? 'selected' : '' }}>
                                    HTG - Haiti Gourde</option>
                                <option value="HUF"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'HUF' ? 'selected' : '' }}>
                                    HUF - Hungary Forint</option>
                                <option value="IDR"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'IDR' ? 'selected' : '' }}>
                                    IDR - Indonesia Rupiah</option>
                                <option value="ILS"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'ILS' ? 'selected' : '' }}>
                                    ILS - Israel Shekel</option>
                                <option value="IMP"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'IMP' ? 'selected' : '' }}>
                                    IMP - Isle of Man Pound</option>
                                <option value="INR"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'INR' ? 'selected' : '' }}>
                                    INR - India Rupee</option>
                                <option value="IQD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'IQD' ? 'selected' : '' }}>
                                    IQD - Iraq Dinar</option>
                                <option value="IRR"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'IRR' ? 'selected' : '' }}>
                                    IRR - Iran Rial</option>
                                <option value="ISK"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'ISK' ? 'selected' : '' }}>
                                    ISK - Iceland Krona</option>
                                <option value="JEP"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'JEP' ? 'selected' : '' }}>
                                    JEP - Jersey Pound</option>
                                <option value="JMD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'JMD' ? 'selected' : '' }}>
                                    JMD - Jamaica Dollar</option>
                                <option value="JOD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'JOD' ? 'selected' : '' }}>
                                    JOD - Jordan Dinar</option>
                                <option value="JPY"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'JPY' ? 'selected' : '' }}>
                                    JPY - Japan Yen</option>
                                <option value="KES"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'KES' ? 'selected' : '' }}>
                                    KES - Kenya Shilling</option>
                                <option value="KGS"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'KGS' ? 'selected' : '' }}>
                                    KGS - Kyrgyzstan Som</option>
                                <option value="KHR"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'KHR' ? 'selected' : '' }}>
                                    KHR - Cambodia Riel</option>
                                <option value="KMF"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'KMF' ? 'selected' : '' }}>
                                    KMF - Comorian Franc</option>
                                <option value="KPW"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'KPW' ? 'selected' : '' }}>
                                    KPW - Korea (North) Won</option>
                                <option value="KRW"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'KRW' ? 'selected' : '' }}>
                                    KRW - Korea (South) Won</option>
                                <option value="KWD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'KWD' ? 'selected' : '' }}>
                                    KWD - Kuwait Dinar</option>
                                <option value="KYD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'KYD' ? 'selected' : '' }}>
                                    KYD - Cayman Islands Dollar</option>
                                <option value="KZT"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'KZT' ? 'selected' : '' }}>
                                    KZT - Kazakhstan Tenge</option>
                                <option value="LAK"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'LAK' ? 'selected' : '' }}>
                                    LAK - Laos Kip</option>
                                <option value="LBP"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'LBP' ? 'selected' : '' }}>
                                    LBP - Lebanon Pound</option>
                                <option value="LKR"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'LKR' ? 'selected' : '' }}>
                                    LKR - Sri Lanka Rupee</option>
                                <option value="LRD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'LRD' ? 'selected' : '' }}>
                                    LRD - Liberia Dollar</option>
                                <option value="LSL"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'LSL' ? 'selected' : '' }}>
                                    LSL - Lesotho Loti</option>
                                <option value="LYD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'LYD' ? 'selected' : '' }}>
                                    LYD - Libya Dinar</option>
                                <option value="MAD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'MAD' ? 'selected' : '' }}>
                                    MAD - Morocco Dirham</option>
                                <option value="MDL"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'MDL' ? 'selected' : '' }}>
                                    MDL - Moldova Leu</option>
                                <option value="MGA"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'MGA' ? 'selected' : '' }}>
                                    MGA - Madagascar Ariary</option>
                                <option value="MKD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'MKD' ? 'selected' : '' }}>
                                    MKD - Macedonia Denar</option>
                                <option value="MMK"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'MMK' ? 'selected' : '' }}>
                                    MMK - Myanmar (Burma) Kyat</option>
                                <option value="MNT"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'MNT' ? 'selected' : '' }}>
                                    MNT - Mongolia Tughrik</option>
                                <option value="MOP"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'MOP' ? 'selected' : '' }}>
                                    MOP - Macau Pataca</option>
                                <option value="MRU"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'MRU' ? 'selected' : '' }}>
                                    MRU - Mauritania Ouguiya</option>
                                <option value="MUR"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'MUR' ? 'selected' : '' }}>
                                    MUR - Mauritius Rupee</option>
                                <option value="MVR"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'MVR' ? 'selected' : '' }}>
                                    MVR - Maldives (Maldive Islands) Rufiyaa</option>
                                <option value="MWK"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'MWK' ? 'selected' : '' }}>
                                    MWK - Malawi Kwacha</option>
                                <option value="MXN"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'MXN' ? 'selected' : '' }}>
                                    MXN - Mexico Peso</option>
                                <option value="MYR"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'MYR' ? 'selected' : '' }}>
                                    MYR - Malaysia Ringgit</option>
                                <option value="MZN"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'MZN' ? 'selected' : '' }}>
                                    MZN - Mozambique Metical</option>
                                <option value="NAD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'NAD' ? 'selected' : '' }}>
                                    NAD - Namibia Dollar</option>
                                <option value="NGN"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'NGN' ? 'selected' : '' }}>
                                    NGN - Nigeria Naira</option>
                                <option value="NIO"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'NIO' ? 'selected' : '' }}>
                                    NIO - Nicaragua Cordoba</option>
                                <option value="NOK"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'AFN' ? 'selected' : '' }}>
                                    NOK - Norway Krone</option>
                                <option value="NPR"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'NPR' ? 'selected' : '' }}>
                                    NPR - Nepal Rupee</option>
                                <option value="NZD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'NZD' ? 'selected' : '' }}>
                                    NZD - New Zealand Dollar</option>
                                <option value="OMR"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'OMR' ? 'selected' : '' }}>
                                    OMR - Oman Rial</option>
                                <option value="PAB"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'PAB' ? 'selected' : '' }}>
                                    PAB - Panama Balboa</option>
                                <option value="PEN"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'PEN' ? 'selected' : '' }}>
                                    PEN - Peru Sol</option>
                                <option value="PGK"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'PGK' ? 'selected' : '' }}>
                                    PGK - Papua New Guinea Kina</option>
                                <option value="PHP"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'PHP' ? 'selected' : '' }}>
                                    PHP - Philippines Peso</option>
                                <option value="PKR"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'PKR' ? 'selected' : '' }}>
                                    PKR - Pakistan Rupee</option>
                                <option value="PLN"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'PLN' ? 'selected' : '' }}>
                                    PLN - Poland Zloty</option>
                                <option value="PYG"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'PYG' ? 'selected' : '' }}>
                                    PYG - Paraguay Guarani</option>
                                <option value="QAR"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'QAR' ? 'selected' : '' }}>
                                    QAR - Qatar Riyal</option>
                                <option value="RON"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'RON' ? 'selected' : '' }}>
                                    RON - Romania Leu</option>
                                <option value="RSD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'RSD' ? 'selected' : '' }}>
                                    RSD - Serbia Dinar</option>
                                <option value="RUB"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'RUB' ? 'selected' : '' }}>
                                    RUB - Russia Ruble</option>
                                <option value="RWF"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'RWF' ? 'selected' : '' }}>
                                    RWF - Rwanda Franc</option>
                                <option value="SAR"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'SAR' ? 'selected' : '' }}>
                                    SAR - Saudi Arabia Riyal</option>
                                <option value="SBD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'SBD' ? 'selected' : '' }}>
                                    SBD - Solomon Islands Dollar</option>
                                <option value="SCR"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'SCR' ? 'selected' : '' }}>
                                    SCR - Seychelles Rupee</option>
                                <option value="SDG"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'SDG' ? 'selected' : '' }}>
                                    SDG - Sudan Pound</option>
                                <option value="SEK"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'SEK' ? 'selected' : '' }}>
                                    SEK - Sweden Krona</option>
                                <option value="SGD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'SGD' ? 'selected' : '' }}>
                                    SGD - Singapore Dollar</option>
                                <option value="SHP"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'SHP' ? 'selected' : '' }}>
                                    SHP - Saint Helena Pound</option>
                                <option value="SLL"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'SLL' ? 'selected' : '' }}>
                                    SLL - Sierra Leone Leone</option>
                                <option value="SOS"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'SOS' ? 'selected' : '' }}>
                                    SOS - Somalia Shilling</option>
                                <option value="SPL*"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'SPL*' ? 'selected' : '' }}>
                                    SPL* - Seborga Luigino</option>
                                <option value="SRD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'SRD' ? 'selected' : '' }}>
                                    SRD - Suriname Dollar</option>
                                <option value="STN"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'STN' ? 'selected' : '' }}>
                                    STN - São Tomé and Príncipe Dobra</option>
                                <option value="SVC"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'SVC' ? 'selected' : '' }}>
                                    SVC - El Salvador Colon</option>
                                <option value="SYP"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'SYP' ? 'selected' : '' }}>
                                    SYP - Syria Pound</option>
                                <option value="SZL"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'SZL' ? 'selected' : '' }}>
                                    SZL - eSwatini Lilangeni</option>
                                <option value="THB"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'THB' ? 'selected' : '' }}>
                                    THB - Thailand Baht</option>
                                <option value="TJS"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'TJS' ? 'selected' : '' }}>
                                    TJS - Tajikistan Somoni</option>
                                <option value="TMT"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'TMT' ? 'selected' : '' }}>
                                    TMT - Turkmenistan Manat</option>
                                <option value="TND"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'TND' ? 'selected' : '' }}>
                                    TND - Tunisia Dinar</option>
                                <option value="TOP"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'TOP' ? 'selected' : '' }}>
                                    TOP - Tonga Pa'anga</option>
                                <option value="TRY"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'TRY' ? 'selected' : '' }}>
                                    TRY - Turkey Lira</option>
                                <option value="TTD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'TTD' ? 'selected' : '' }}>
                                    TTD - Trinidad and Tobago Dollar</option>
                                <option value="TVD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'TVD' ? 'selected' : '' }}>
                                    TVD - Tuvalu Dollar</option>
                                <option value="TWD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'TWD' ? 'selected' : '' }}>
                                    TWD - Taiwan New Dollar</option>
                                <option value="TZS"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'TZS' ? 'selected' : '' }}>
                                    TZS - Tanzania Shilling</option>
                                <option value="UAH"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'UAH' ? 'selected' : '' }}>
                                    UAH - Ukraine Hryvnia</option>
                                <option value="UGX"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'UGX' ? 'selected' : '' }}>
                                    UGX - Uganda Shilling</option>
                                <option value="USD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'USD' ? 'selected' : '' }}>
                                    USD - United States Dollar</option>
                                <option value="UYU"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'UYU' ? 'selected' : '' }}>
                                    UYU - Uruguay Peso</option>
                                <option value="UZS"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'UZS' ? 'selected' : '' }}>
                                    UZS - Uzbekistan Som</option>
                                <option value="VEF"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'VEF' ? 'selected' : '' }}>
                                    VEF - Venezuela Bolívar</option>
                                <option value="VND"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'VND' ? 'selected' : '' }}>
                                    VND - Viet Nam Dong</option>
                                <option value="VUV"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'VUV' ? 'selected' : '' }}>
                                    VUV - Vanuatu Vatu</option>
                                <option value="WST"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'WST' ? 'selected' : '' }}>
                                    WST - Samoa Tala</option>
                                <option value="XAF"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'XAF' ? 'selected' : '' }}>
                                    XAF - Communauté Financière Africaine (BEAC) CFA Franc BEAC</option>
                                <option value="XCD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'XCD' ? 'selected' : '' }}>
                                    XCD - East Caribbean Dollar</option>
                                <option value="XDR"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'XDR' ? 'selected' : '' }}>
                                    XDR - International Monetary Fund (IMF) Special Drawing Rights</option>
                                <option value="XOF"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'XOF' ? 'selected' : '' }}>
                                    XOF - Communauté Financière Africaine (BCEAO) Franc</option>
                                <option value="XPF"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'XPF' ? 'selected' : '' }}>
                                    XPF - Comptoirs Français du Pacifique (CFP) Franc</option>
                                <option value="YER"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'YER' ? 'selected' : '' }}>
                                    YER - Yemen Rial</option>
                                <option value="ZAR"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'ZAR' ? 'selected' : '' }}>
                                    ZAR - South Africa Rand</option>
                                <option value="ZMW"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'ZMW' ? 'selected' : '' }}>
                                    ZMW - Zambia Kwacha</option>
                                <option value="ZWD"
                                    {{ App\Models\Settings::getSettingsvalue('country_currency_code') == 'ZWD' ? 'selected' : '' }}>
                                    ZWD - Zimbabwe Dollar</option>
                            </select>
                        </div>

                        <div>
                            <label for="choices-publish-visibility-input" class="form-label">Store Currency ( Symbol or
                                Code - $ or USD - Anyone )</label>
                            <input type="text" class="form-control" name="currency_symbol"
                                value="{{ App\Models\Settings::getSettingsvalue('currency_symbol') }}">
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Time Zone</h5>
                    </div>
                    <!-- end card body -->
                    <div class="card-body">
                        <div>
                            <label for="datepicker-publish-input" class="form-label"> Select Time Zone</label>
                            <select class="form-control form-select select2" name="time_zone">
                                <option value=" ">--Select Timezones--</option>
                                <option value="Pacific/Midway"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Pacific/Midway' ? 'selected' : '' }}
                                    data-gmt="-11:00">23:25 pm - GMT -11:00 - Pacific/Midway</option>
                                <option value="Pacific/Pago_Pago"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Pacific/Pago_Pago' ? 'selected' : '' }}
                                    data-gmt="-11:00">23:25 pm - GMT -11:00 - Pacific/Pago_Pago</option>
                                <option value="Pacific/Honolulu"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Pacific/Honolulu' ? 'selected' : '' }}
                                    data-gmt="-10:00">00:25 am - GMT -10:00 - Pacific/Honolulu</option>
                                <option value="America/Adak"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Adak' ? 'selected' : '' }}
                                    data-gmt="-09:00">01:25 am - GMT -09:00 - America/Adak</option>
                                <option value="America/Anchorage"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Anchorage' ? 'selected' : '' }}
                                    data-gmt="-08:00">02:25 am - GMT -08:00 - America/Anchorage</option>
                                <option value="America/Juneau"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Juneau' ? 'selected' : '' }}
                                    data-gmt="-08:00">02:25 am - GMT -08:00 - America/Juneau</option>
                                <option value="America/Metlakatla"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Metlakatla' ? 'selected' : '' }}
                                    data-gmt="-08:00">02:25 am - GMT -08:00 - America/Metlakatla</option>
                                <option value="America/Nome"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Nome' ? 'selected' : '' }}
                                    data-gmt="-08:00">02:25 am - GMT -08:00 - America/Nome</option>
                                <option value="America/Sitka"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Sitka' ? 'selected' : '' }}
                                    data-gmt="-08:00">02:25 am - GMT -08:00 - America/Sitka</option>
                                <option value="America/Yakutat"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Yakutat' ? 'selected' : '' }}
                                    data-gmt="-08:00">02:25 am - GMT -08:00 - America/Yakutat</option>
                                <option value="America/Creston"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Creston' ? 'selected' : '' }}
                                    data-gmt="-07:00">03:25 am - GMT -07:00 - America/Creston</option>
                                <option value="America/Dawson_Creek"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Dawson_Creek' ? 'selected' : '' }}
                                    data-gmt="-07:00">03:25 am - GMT -07:00 - America/Dawson_Creek</option>
                                <option value="America/Fort_Nelson"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Fort_Nelson' ? 'selected' : '' }}
                                    data-gmt="-07:00">03:25 am - GMT -07:00 - America/Fort_Nelson</option>
                                <option value="America/Hermosillo"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Hermosillo' ? 'selected' : '' }}
                                    data-gmt="-07:00">03:25 am - GMT -07:00 - America/Hermosillo</option>
                                <option value="America/Tijuana"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Tijuana' ? 'selected' : '' }}
                                    data-gmt="-07:00">03:25 am - GMT -07:00 - America/Tijuana</option>
                                <option value="America/Dawson"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Dawson' ? 'selected' : '' }}
                                    data-gmt="-07:00">03:25 am - GMT -07:00 - America/Dawson</option>
                                <option value="America/Los_Angeles"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Los_Angeles' ? 'selected' : '' }}
                                    data-gmt="-07:00">03:25 am - GMT -07:00 - America/Los_Angeles</option>
                                <option value="America/Phoenix"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Phoenix' ? 'selected' : '' }}
                                    data-gmt="-07:00">03:25 am - GMT -07:00 - America/Phoenix</option>
                                <option value="America/Vancouver"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Vancouver' ? 'selected' : '' }}
                                    data-gmt="-07:00">03:25 am - GMT -07:00 - America/Vancouver</option>
                                <option value="America/Whitehorse"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Whitehorse' ? 'selected' : '' }}
                                    data-gmt="-07:00">03:25 am - GMT -07:00 - America/Whitehorse</option>
                                <option value="America/Mazatlan"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Mazatlan' ? 'selected' : '' }}
                                    data-gmt="-06:00">04:25 am - GMT -06:00 - America/Mazatlan</option>
                                <option value="America/Regina"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Regina' ? 'selected' : '' }}
                                    data-gmt="-06:00">04:25 am - GMT -06:00 - America/Regina</option>
                                <option value="America/Swift_Current"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Swift_Current' ? 'selected' : '' }}
                                    data-gmt="-06:00">04:25 am - GMT -06:00 - America/Swift_Current</option>
                                <option value="America/Belize"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Belize' ? 'selected' : '' }}
                                    data-gmt="-06:00">04:25 am - GMT -06:00 - America/Belize</option>
                                <option value="America/Boise"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Boise' ? 'selected' : '' }}
                                    data-gmt="-06:00">04:25 am - GMT -06:00 - America/Boise</option>
                                <option value="America/Cambridge_Bay"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Cambridge_Bay' ? 'selected' : '' }}
                                    data-gmt="-06:00">04:25 am - GMT -06:00 - America/Cambridge_Bay</option>
                                <option value="America/Chihuahua"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Chihuahua' ? 'selected' : '' }}
                                    data-gmt="-06:00">04:25 am - GMT -06:00 - America/Chihuahua</option>
                                <option value="America/Costa_Rica"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Costa_Rica' ? 'selected' : '' }}
                                    data-gmt="-06:00">04:25 am - GMT -06:00 - America/Costa_Rica</option>
                                <option value="America/Denver"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Denver' ? 'selected' : '' }}
                                    data-gmt="-06:00">04:25 am - GMT -06:00 - America/Denver</option>
                                <option value="America/Edmonton"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Edmonton' ? 'selected' : '' }}
                                    data-gmt="-06:00">04:25 am - GMT -06:00 - America/Edmonton</option>
                                <option value="America/El_Salvador"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/El_Salvador' ? 'selected' : '' }}
                                    data-gmt="-06:00">04:25 am - GMT -06:00 - America/El_Salvador</option>
                                <option value="America/Guatemala"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Guatemala' ? 'selected' : '' }}
                                    data-gmt="-06:00">04:25 am - GMT -06:00 - America/Guatemala</option>
                                <option value="America/Inuvik"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Inuvik' ? 'selected' : '' }}
                                    data-gmt="-06:00">04:25 am - GMT -06:00 - America/Inuvik</option>
                                <option value="America/Managua"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Managua' ? 'selected' : '' }}
                                    data-gmt="-06:00">04:25 am - GMT -06:00 - America/Managua</option>
                                <option value="America/Ojinaga"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Ojinaga' ? 'selected' : '' }}
                                    data-gmt="-06:00">04:25 am - GMT -06:00 - America/Ojinaga</option>
                                <option value="America/Tegucigalpa"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Tegucigalpa' ? 'selected' : '' }}
                                    data-gmt="-06:00">04:25 am - GMT -06:00 - America/Tegucigalpa</option>
                                <option value="America/Yellowknife"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Yellowknife' ? 'selected' : '' }}
                                    data-gmt="-06:00">04:25 am - GMT -06:00 - America/Yellowknife</option>
                                <option value="America/Bogota"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Bogota' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Bogota</option>
                                <option value="America/Cayman"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Cayman' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Cayman</option>
                                <option value="America/Guayaquil"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Guayaquil' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Guayaquil</option>
                                <option value="America/Panama"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Panama' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Panama</option>
                                <option value="Pacific/Easter"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Pacific/Easter' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - Pacific/Easter</option>
                                <option value="America/Atikokan"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Atikokan' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Atikokan</option>
                                <option value="America/Bahia_Banderas"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Bahia_Banderas' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Bahia_Banderas</option>
                                <option value="America/Cancun"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Cancun' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Cancun</option>
                                <option value="America/Chicago"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Chicago' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Chicago</option>
                                <option value="America/Indiana/Knox"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Indiana/Knox' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Indiana/Knox</option>
                                <option value="America/Indiana/Tell_City"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Indiana/Tell_City' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Indiana/Tell_City</option>
                                <option value="America/Jamaica"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Jamaica' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Jamaica</option>
                                <option value="America/Matamoros"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Matamoros' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Matamoros</option>
                                <option value="America/Menominee"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Menominee' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Menominee</option>
                                <option value="America/Merida"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Merida' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Merida</option>
                                <option value="America/Mexico_City"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Mexico_City' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Mexico_City</option>
                                <option value="America/Monterrey"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Monterrey' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Monterrey</option>
                                <option value="America/North_Dakota/Beulah"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/North_Dakota/Beulah' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/North_Dakota/Beulah</option>
                                <option value="America/North_Dakota/Center"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/North_Dakota/Center' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/North_Dakota/Center</option>
                                <option value="America/North_Dakota/New_Salem"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/North_Dakota/New_Salem' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/North_Dakota/New_Salem</option>
                                <option value="America/Rainy_River"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Rainy_River' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Rainy_River</option>
                                <option value="America/Rankin_Inlet"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Rankin_Inlet' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Rankin_Inlet</option>
                                <option value="America/Resolute"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Resolute' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Resolute</option>
                                <option value="America/Winnipeg"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Winnipeg' ? 'selected' : '' }}
                                    data-gmt="-05:00">05:25 am - GMT -05:00 - America/Winnipeg</option>
                                <option value="America/Anguilla"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Anguilla' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Anguilla</option>
                                <option value="America/Antigua"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Antigua' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Antigua</option>
                                <option value="America/Aruba"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Aruba' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Aruba</option>
                                <option value="America/Asuncion"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Asuncion' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Asuncion</option>
                                <option value="America/Caracas"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Caracas' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Caracas</option>
                                <option value="America/Curacao"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Curacao' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Curacao</option>
                                <option value="America/Detroit"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Detroit' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Detroit</option>
                                <option value="America/Dominica"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Dominica' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Dominica</option>
                                <option value="America/Grand_Turk"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Grand_Turk' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Grand_Turk</option>
                                <option value="America/Grenada"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Grenada' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Grenada</option>
                                <option value="America/Guadeloupe"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Guadeloupe' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Guadeloupe</option>
                                <option value="America/Kralendijk"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Kralendijk' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Kralendijk</option>
                                <option value="America/Lower_Princes"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Lower_Princes' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Lower_Princes</option>
                                <option value="America/Marigot"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Marigot' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Marigot</option>
                                <option value="America/Montserrat"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Montserrat' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Montserrat</option>
                                <option value="America/Port_of_Spain"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Port_of_Spain' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Port_of_Spain</option>
                                <option value="America/Santo_Domingo"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Santo_Domingo' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Santo_Domingo</option>
                                <option value="America/St_Barthelemy"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/St_Barthelemy' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/St_Barthelemy</option>
                                <option value="America/St_Kitts"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/St_Kitts' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/St_Kitts</option>
                                <option value="America/St_Lucia"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/St_Lucia' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/St_Lucia</option>
                                <option value="America/St_Thomas"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/St_Thomas' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/St_Thomas</option>
                                <option value="America/St_Vincent"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/St_Vincent' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/St_Vincent</option>
                                <option value="America/Thunder_Bay"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Thunder_Bay' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Thunder_Bay</option>
                                <option value="America/Tortola"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Tortola' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Tortola</option>
                                <option value="America/Barbados"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Barbados' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Barbados</option>
                                <option value="America/Blanc-Sablon"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Blanc-Sablon' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Blanc-Sablon</option>
                                <option value="America/Havana"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Havana' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Havana</option>
                                <option value="America/Indiana/Indianapolis"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Indiana/Indianapolis' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Indiana/Indianapolis</option>
                                <option value="America/Indiana/Marengo"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Indiana/Marengo' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Indiana/Marengo</option>
                                <option value="America/Indiana/Petersburg"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Indiana/Petersburg' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Indiana/Petersburg</option>
                                <option value="America/Indiana/Vevay"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Indiana/Vevay' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Indiana/Vevay</option>
                                <option value="America/Indiana/Vincennes"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Indiana/Vincennes' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Indiana/Vincennes</option>
                                <option value="America/Indiana/Winamac"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Indiana/Winamac' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Indiana/Winamac</option>
                                <option value="America/Iqaluit"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Iqaluit' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Iqaluit</option>
                                <option value="America/Kentucky/Louisville"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Kentucky/Louisville' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Kentucky/Louisville</option>
                                <option value="America/Kentucky/Monticello"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Kentucky/Monticello' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Kentucky/Monticello</option>
                                <option value="America/La_Paz"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/La_Paz' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/La_Paz</option>
                                <option value="America/Martinique"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Martinique' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Martinique</option>
                                <option value="America/Nassau"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Nassau' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Nassau</option>
                                <option value="America/New_York"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/New_York' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/New_York</option>
                                <option value="America/Nipigon"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Nipigon' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Nipigon</option>
                                <option value="America/Pangnirtung"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Pangnirtung' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Pangnirtung</option>
                                <option value="America/Port-au-Prince"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Port-au-Prince' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Port-au-Prince</option>
                                <option value="America/Puerto_Rico"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Puerto_Rico' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Puerto_Rico</option>
                                <option value="America/Toronto"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Toronto' ? 'selected' : '' }}
                                    data-gmt="-04:00">06:25 am - GMT -04:00 - America/Toronto</option>
                                <option value="America/Argentina/Buenos_Aires"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Argentina/Buenos_Aires' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Argentina/Buenos_Aires</option>
                                <option value="America/Argentina/Catamarca"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Argentina/Catamarca' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Argentina/Catamarca</option>
                                <option value="America/Argentina/Cordoba"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Argentina/Cordoba' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Argentina/Cordoba</option>
                                <option value="America/Argentina/Jujuy"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Argentina/Jujuy' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Argentina/Jujuy</option>
                                <option value="America/Argentina/La_Rioja"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Argentina/La_Rioja' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Argentina/La_Rioja</option>
                                <option value="America/Argentina/Mendoza"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Argentina/Mendoza' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Argentina/Mendoza</option>
                                <option value="America/Argentina/Rio_Gallegos"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Argentina/Rio_Gallegos' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Argentina/Rio_Gallegos</option>
                                <option value="America/Argentina/Salta"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Argentina/Salta' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Argentina/Salta</option>
                                <option value="America/Argentina/San_Juan"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Argentina/San_Juan' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Argentina/San_Juan</option>
                                <option value="America/Argentina/San_Luis"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Argentina/San_Luis' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Argentina/San_Luis</option>
                                <option value="America/Argentina/Tucuman"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Argentina/Tucuman' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Argentina/Tucuman</option>
                                <option value="America/Argentina/Ushuaia"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Argentina/Ushuaia' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Argentina/Ushuaia</option>
                                <option value="America/Montevideo"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Montevideo' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Montevideo</option>
                                <option value="America/Paramaribo"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Paramaribo' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Paramaribo</option>
                                <option value="America/Punta_Arenas"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Punta_Arenas' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Punta_Arenas</option>
                                <option value="America/Santiago"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Santiago' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Santiago</option>
                                <option value="Atlantic/Stanley"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Atlantic/Stanley' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - Atlantic/Stanley</option>
                                <option value="America/Glace_Bay"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Glace_Bay' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Glace_Bay</option>
                                <option value="America/Goose_Bay"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Goose_Bay' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Goose_Bay</option>
                                <option value="America/Halifax"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Halifax' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Halifax</option>
                                <option value="America/Moncton"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Moncton' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Moncton</option>
                                <option value="America/Thule"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Thule' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - America/Thule</option>
                                <option value="Atlantic/Bermuda"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Atlantic/Bermuda' ? 'selected' : '' }}
                                    data-gmt="-03:00">07:25 am - GMT -03:00 - Atlantic/Bermuda</option>
                                <option value="America/St_Johns"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/St_Johns' ? 'selected' : '' }}
                                    data-gmt="-02:30">07:55 am - GMT -02:30 - America/St_Johns</option>
                                <option value="America/Miquelon"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Miquelon' ? 'selected' : '' }}
                                    data-gmt="-02:00">08:25 am - GMT -02:00 - America/Miquelon</option>
                                <option value="Africa/Abidjan"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Abidjan' ? 'selected' : '' }}
                                    data-gmt=" 00:00">10:25 am - GMT 00:00 - Africa/Abidjan</option>
                                <option value="Africa/Accra"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Accra' ? 'selected' : '' }}
                                    data-gmt=" 00:00">10:25 am - GMT 00:00 - Africa/Accra</option>
                                <option value="Africa/Bamako"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Bamako' ? 'selected' : '' }}
                                    data-gmt=" 00:00">10:25 am - GMT 00:00 - Africa/Bamako</option>
                                <option value="Africa/Banjul"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Banjul' ? 'selected' : '' }}
                                    data-gmt=" 00:00">10:25 am - GMT 00:00 - Africa/Banjul</option>
                                <option value="Africa/Bissau"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Bissau' ? 'selected' : '' }}
                                    data-gmt=" 00:00">10:25 am - GMT 00:00 - Africa/Bissau</option>
                                <option value="Africa/Conakry"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Conakry' ? 'selected' : '' }}
                                    data-gmt=" 00:00">10:25 am - GMT 00:00 - Africa/Conakry</option>
                                <option value="Africa/Dakar"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Dakar' ? 'selected' : '' }}
                                    data-gmt=" 00:00">10:25 am - GMT 00:00 - Africa/Dakar</option>
                                <option value="Africa/Freetown"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Freetown' ? 'selected' : '' }}
                                    data-gmt=" 00:00">10:25 am - GMT 00:00 - Africa/Freetown</option>
                                <option value="Africa/Lome"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Lome' ? 'selected' : '' }}
                                    data-gmt=" 00:00">10:25 am - GMT 00:00 - Africa/Lome</option>
                                <option value="Africa/Monrovia"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Monrovia' ? 'selected' : '' }}
                                    data-gmt=" 00:00">10:25 am - GMT 00:00 - Africa/Monrovia</option>
                                <option value="Africa/Nouakchott"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Nouakchott' ? 'selected' : '' }}
                                    data-gmt=" 00:00">10:25 am - GMT 00:00 - Africa/Nouakchott</option>
                                <option value="Africa/Ouagadougou"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Ouagadougou' ? 'selected' : '' }}
                                    data-gmt=" 00:00">10:25 am - GMT 00:00 - Africa/Ouagadougou</option>
                                <option value="Africa/Sao_Tome"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Sao_Tome' ? 'selected' : '' }}
                                    data-gmt=" 00:00">10:25 am - GMT 00:00 - Africa/Sao_Tome</option>
                                <option value="America/Danmarkshavn"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'America/Danmarkshavn' ? 'selected' : '' }}
                                    data-gmt=" 00:00">10:25 am - GMT 00:00 - America/Danmarkshavn</option>
                                <option value="Atlantic/Azores"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Atlantic/Azores' ? 'selected' : '' }}
                                    data-gmt=" 00:00">10:25 am - GMT 00:00 - Atlantic/Azores</option>
                                <option value="Atlantic/Reykjavik"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Atlantic/Reykjavik' ? 'selected' : '' }}
                                    data-gmt=" 00:00">10:25 am - GMT 00:00 - Atlantic/Reykjavik</option>
                                <option value="Atlantic/St_Helena"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Atlantic/St_Helena' ? 'selected' : '' }}
                                    data-gmt=" 00:00">10:25 am - GMT 00:00 - Atlantic/St_Helena</option>
                                <option value="UTC"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'UTC' ? 'selected' : '' }}
                                    data-gmt=" 00:00">10:25 am - GMT 00:00 - UTC</option>
                                <option value="Africa/Bangui"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Bangui' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Africa/Bangui</option>
                                <option value="Africa/Brazzaville"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Brazzaville' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Africa/Brazzaville</option>
                                <option value="Africa/Douala"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Douala' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Africa/Douala</option>
                                <option value="Africa/Kinshasa"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Kinshasa' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Africa/Kinshasa</option>
                                <option value="Africa/Lagos"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Lagos' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Africa/Lagos</option>
                                <option value="Africa/Libreville"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Libreville' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Africa/Libreville</option>
                                <option value="Africa/Luanda"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Luanda' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Africa/Luanda</option>
                                <option value="Africa/Malabo"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Malabo' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Africa/Malabo</option>
                                <option value="Africa/Niamey"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Niamey' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Africa/Niamey</option>
                                <option value="Africa/Porto-Novo"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Porto-Novo' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Africa/Porto-Novo</option>
                                <option value="Atlantic/Madeira"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Atlantic/Madeira' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Atlantic/Madeira</option>
                                <option value="Africa/Algiers"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Algiers' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Africa/Algiers</option>
                                <option value="Africa/Ndjamena"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Ndjamena' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Africa/Ndjamena</option>
                                <option value="Africa/Tunis"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Tunis' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Africa/Tunis</option>
                                <option value="Atlantic/Canary"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Atlantic/Canary' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Atlantic/Canary</option>
                                <option value="Atlantic/Faroe"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Atlantic/Faroe' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Atlantic/Faroe</option>
                                <option value="Europe/Dublin"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Dublin' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Europe/Dublin</option>
                                <option value="Europe/Guernsey"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Guernsey' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Europe/Guernsey</option>
                                <option value="Europe/Isle_of_Man"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Isle_of_Man' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Europe/Isle_of_Man</option>
                                <option value="Europe/Jersey"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Jersey' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Europe/Jersey</option>
                                <option value="Europe/Lisbon"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Lisbon' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Europe/Lisbon</option>
                                <option value="Europe/London"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/London' ? 'selected' : '' }}
                                    data-gmt="+01:00">11:25 am - GMT +01:00 - Europe/London</option>
                                <option value="Africa/Blantyre"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Blantyre' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Africa/Blantyre</option>
                                <option value="Africa/Bujumbura"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Bujumbura' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Africa/Bujumbura</option>
                                <option value="Africa/Gaborone"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Gaborone' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Africa/Gaborone</option>
                                <option value="Africa/Harare"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Harare' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Africa/Harare</option>
                                <option value="Africa/Johannesburg"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Johannesburg' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Africa/Johannesburg</option>
                                <option value="Africa/Kigali"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Kigali' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Africa/Kigali</option>
                                <option value="Africa/Lubumbashi"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Lubumbashi' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Africa/Lubumbashi</option>
                                <option value="Africa/Lusaka"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Lusaka' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Africa/Lusaka</option>
                                <option value="Africa/Maputo"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Maputo' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Africa/Maputo</option>
                                <option value="Africa/Windhoek"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Windhoek' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Africa/Windhoek</option>
                                <option value="Europe/Amsterdam"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Amsterdam' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Amsterdam</option>
                                <option value="Africa/Cairo"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Cairo' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Africa/Cairo</option>
                                <option value="Africa/Ceuta"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Ceuta' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Africa/Ceuta</option>
                                <option value="Africa/Juba"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Juba' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Africa/Juba</option>
                                <option value="Africa/Khartoum"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Khartoum' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Africa/Khartoum</option>
                                <option value="Africa/Maseru"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Maseru' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Africa/Maseru</option>
                                <option value="Africa/Mbabane"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Mbabane' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Africa/Mbabane</option>
                                <option value="Africa/Tripoli"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Tripoli' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Africa/Tripoli</option>
                                <option value="Arctic/Longyearbyen"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Arctic/Longyearbyen' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Arctic/Longyearbyen</option>
                                <option value="Europe/Andorra"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Andorra' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Andorra</option>
                                <option value="Europe/Belgrade"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Belgrade' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Belgrade</option>
                                <option value="Europe/Berlin"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Berlin' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Berlin</option>
                                <option value="Europe/Bratislava"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Bratislava' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Bratislava</option>
                                <option value="Europe/Brussels"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Brussels' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Brussels</option>
                                <option value="Europe/Budapest"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Budapest' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Budapest</option>
                                <option value="Europe/Busingen"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Busingen' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Busingen</option>
                                <option value="Europe/Copenhagen"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Copenhagen' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Copenhagen</option>
                                <option value="Europe/Gibraltar"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Gibraltar' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Gibraltar</option>
                                <option value="Europe/Kaliningrad"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Kaliningrad' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Kaliningrad</option>
                                <option value="Europe/Ljubljana"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Ljubljana' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Ljubljana</option>
                                <option value="Europe/Luxembourg"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Luxembourg' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Luxembourg</option>
                                <option value="Europe/Madrid"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Madrid' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Madrid</option>
                                <option value="Europe/Malta"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Malta' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Malta</option>
                                <option value="Europe/Monaco"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Monaco' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Monaco</option>
                                <option value="Europe/Oslo"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Oslo' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Oslo</option>
                                <option value="Europe/Paris"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Paris' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Paris</option>
                                <option value="Europe/Podgorica"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Podgorica' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Podgorica</option>
                                <option value="Europe/Prague"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Prague' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Prague</option>
                                <option value="Europe/Rome"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Rome' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Rome</option>
                                <option value="Europe/San_Marino"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/San_Marino' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/San_Marino</option>
                                <option value="Europe/Sarajevo"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Sarajevo' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Sarajevo</option>
                                <option value="Europe/Skopje"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Skopje' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Skopje</option>
                                <option value="Europe/Stockholm"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Stockholm' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Stockholm</option>
                                <option value="Europe/Tirane"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Tirane' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Tirane</option>
                                <option value="Europe/Vaduz"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Vaduz' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Vaduz</option>
                                <option value="Europe/Vatican"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Vatican' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Vatican</option>
                                <option value="Europe/Vienna"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Vienna' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Vienna</option>
                                <option value="Europe/Warsaw"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Warsaw' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Warsaw</option>
                                <option value="Europe/Zagreb"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Zagreb' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Zagreb</option>
                                <option value="Europe/Zurich"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Zurich' ? 'selected' : '' }}
                                    data-gmt="+02:00">12:25 pm - GMT +02:00 - Europe/Zurich</option>
                                <option value="Africa/Addis_Ababa"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Addis_Ababa' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Africa/Addis_Ababa</option>
                                <option value="Africa/Asmara"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Asmara' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Africa/Asmara</option>
                                <option value="Africa/Dar_es_Salaam"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Dar_es_Salaam' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Africa/Dar_es_Salaam</option>
                                <option value="Africa/Djibouti"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Djibouti' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Africa/Djibouti</option>
                                <option value="Africa/Kampala"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Kampala' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Africa/Kampala</option>
                                <option value="Africa/Mogadishu"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Mogadishu' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Africa/Mogadishu</option>
                                <option value="Africa/Nairobi"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Africa/Nairobi' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Africa/Nairobi</option>
                                <option value="Asia/Baghdad"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Baghdad' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Asia/Baghdad</option>
                                <option value="Europe/Athens"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Athens' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Europe/Athens</option>
                                <option value="Europe/Bucharest"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Bucharest' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Europe/Bucharest</option>
                                <option value="Europe/Chisinau"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Chisinau' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Europe/Chisinau</option>
                                <option value="Indian/Antananarivo"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Indian/Antananarivo' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Indian/Antananarivo</option>
                                <option value="Indian/Comoro"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Indian/Comoro' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Indian/Comoro</option>
                                <option value="Indian/Mayotte"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Indian/Mayotte' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Indian/Mayotte</option>
                                <option value="Asia/Amman"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Amman' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Asia/Amman</option>
                                <option value="Asia/Beirut"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Beirut' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Asia/Beirut</option>
                                <option value="Asia/Damascus"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Damascus' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Asia/Damascus</option>
                                <option value="Asia/Famagusta"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Famagusta' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Asia/Famagusta</option>
                                <option value="Asia/Gaza"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Gaza' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Asia/Gaza</option>
                                <option value="Asia/Hebron"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Hebron' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Asia/Hebron</option>
                                <option value="Asia/Jerusalem"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Jerusalem' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Asia/Jerusalem</option>
                                <option value="Asia/Nicosia"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Nicosia' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Asia/Nicosia</option>
                                <option value="Europe/Helsinki"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Helsinki' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Europe/Helsinki</option>
                                <option value="Europe/Istanbul"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Istanbul' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Europe/Istanbul</option>
                                <option value="Europe/Kiev"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Kiev' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Europe/Kiev</option>
                                <option value="Europe/Mariehamn"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Mariehamn' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Europe/Mariehamn</option>
                                <option value="Europe/Minsk"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Minsk' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Europe/Minsk</option>
                                <option value="Europe/Moscow"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Moscow' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Europe/Moscow</option>
                                <option value="Europe/Riga"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Riga' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Europe/Riga</option>
                                <option value="Europe/Simferopol"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Simferopol' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Europe/Simferopol</option>
                                <option value="Europe/Sofia"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Sofia' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Europe/Sofia</option>
                                <option value="Europe/Tallinn"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Tallinn' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Europe/Tallinn</option>
                                <option value="Europe/Uzhgorod"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Uzhgorod' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Europe/Uzhgorod</option>
                                <option value="Europe/Vilnius"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Vilnius' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Europe/Vilnius</option>
                                <option value="Europe/Zaporozhye"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Europe/Zaporozhye' ? 'selected' : '' }}
                                    data-gmt="+03:00">13:25 pm - GMT +03:00 - Europe/Zaporozhye</option>
                                <option value="Asia/Tbilisi"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Tbilisi' ? 'selected' : '' }}
                                    data-gmt="+04:00">14:25 pm - GMT +04:00 - Asia/Tbilisi</option>
                                <option value="Asia/Tehran"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Tehran' ? 'selected' : '' }}
                                    data-gmt="+04:30">14:55 pm - GMT +04:30 - Asia/Tehran</option>
                                <option value="Asia/Yekaterinburg"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Yekaterinburg' ? 'selected' : '' }}
                                    data-gmt="+05:00">15:25 pm - GMT +05:00 - Asia/Yekaterinburg</option>
                                <option value="Indian/Maldives"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Indian/Maldives' ? 'selected' : '' }}
                                    data-gmt="+05:00">15:25 pm - GMT +05:00 - Indian/Maldives</option>
                                <option value="Asia/Karachi"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Karachi' ? 'selected' : '' }}
                                    data-gmt="+05:00">15:25 pm - GMT +05:00 - Asia/Karachi</option>
                                <option value="Asia/Colombo"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Colombo' ? 'selected' : '' }}
                                    data-gmt="+05:30">15:55 pm - GMT +05:30 - Asia/Colombo</option>
                                <option value="Asia/Kolkata"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Kolkata' ? 'selected' : '' }}
                                    data-gmt="+05:30">15:55 pm - GMT +05:30 - Asia/Kolkata</option>
                                <option value="Asia/Dhaka"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Dhaka' ? 'selected' : '' }}
                                    data-gmt="+06:00">16:25 pm - GMT +06:00 - Asia/Dhaka</option>
                                <option value="Asia/Yangon"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Yangon' ? 'selected' : '' }}
                                    data-gmt="+06:30">16:55 pm - GMT +06:30 - Asia/Yangon</option>
                                <option value="Asia/Bangkok"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Bangkok' ? 'selected' : '' }}
                                    data-gmt="+07:00">17:25 pm - GMT +07:00 - Asia/Bangkok</option>
                                <option value="Asia/Ho_Chi_Minh"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Ho_Chi_Minh' ? 'selected' : '' }}
                                    data-gmt="+07:00">17:25 pm - GMT +07:00 - Asia/Ho_Chi_Minh</option>
                                <option value="Asia/Jakarta"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Jakarta' ? 'selected' : '' }}
                                    data-gmt="+07:00">17:25 pm - GMT +07:00 - Asia/Jakarta</option>
                                <option value="Asia/Phnom_Penh"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Phnom_Penh' ? 'selected' : '' }}
                                    data-gmt="+07:00">17:25 pm - GMT +07:00 - Asia/Phnom_Penh</option>
                                <option value="Asia/Pontianak"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Pontianak' ? 'selected' : '' }}
                                    data-gmt="+07:00">17:25 pm - GMT +07:00 - Asia/Pontianak</option>
                                <option value="Asia/Vientiane"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Vientiane' ? 'selected' : '' }}
                                    data-gmt="+07:00">17:25 pm - GMT +07:00 - Asia/Vientiane</option>
                                <option value="Asia/Irkutsk"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Irkutsk' ? 'selected' : '' }}
                                    data-gmt="+08:00">18:25 pm - GMT +08:00 - Asia/Irkutsk</option>
                                <option value="Asia/Kuala_Lumpur"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Kuala_Lumpur' ? 'selected' : '' }}
                                    data-gmt="+08:00">18:25 pm - GMT +08:00 - Asia/Kuala_Lumpur</option>
                                <option value="Asia/Makassar"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Makassar' ? 'selected' : '' }}
                                    data-gmt="+08:00">18:25 pm - GMT +08:00 - Asia/Makassar</option>
                                <option value="Asia/Manila"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Manila' ? 'selected' : '' }}
                                    data-gmt="+08:00">18:25 pm - GMT +08:00 - Asia/Manila</option>
                                <option value="Asia/Singapore"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Singapore' ? 'selected' : '' }}
                                    data-gmt="+08:00">18:25 pm - GMT +08:00 - Asia/Singapore</option>
                                <option value="Asia/Hong_Kong"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Hong_Kong' ? 'selected' : '' }}
                                    data-gmt="+08:00">18:25 pm - GMT +08:00 - Asia/Hong_Kong</option>
                                <option value="Asia/Macau"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Macau' ? 'selected' : '' }}
                                    data-gmt="+08:00">18:25 pm - GMT +08:00 - Asia/Macau</option>
                                <option value="Asia/Shanghai"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Shanghai' ? 'selected' : '' }}
                                    data-gmt="+08:00">18:25 pm - GMT +08:00 - Asia/Shanghai</option>
                                <option value="Asia/Taipei"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Taipei' ? 'selected' : '' }}
                                    data-gmt="+08:00">18:25 pm - GMT +08:00 - Asia/Taipei</option>
                                <option value="Australia/Perth"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Australia/Perth' ? 'selected' : '' }}
                                    data-gmt="+08:00">18:25 pm - GMT +08:00 - Australia/Perth</option>
                                <option value="Asia/Jayapura"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Jayapura' ? 'selected' : '' }}
                                    data-gmt="+09:00">19:25 pm - GMT +09:00 - Asia/Jayapura</option>
                                <option value="Asia/Pyongyang"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Pyongyang' ? 'selected' : '' }}
                                    data-gmt="+09:00">19:25 pm - GMT +09:00 - Asia/Pyongyang</option>
                                <option value="Asia/Seoul"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Seoul' ? 'selected' : '' }}
                                    data-gmt="+09:00">19:25 pm - GMT +09:00 - Asia/Seoul</option>
                                <option value="Asia/Tokyo"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Asia/Tokyo' ? 'selected' : '' }}
                                    data-gmt="+09:00">19:25 pm - GMT +09:00 - Asia/Tokyo</option>
                                <option value="Australia/Adelaide"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Australia/Adelaide' ? 'selected' : '' }}
                                    data-gmt="+09:30">19:55 pm - GMT +09:30 - Australia/Adelaide</option>
                                <option value="Australia/Broken_Hill"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Australia/Broken_Hill' ? 'selected' : '' }}
                                    data-gmt="+09:30">19:55 pm - GMT +09:30 - Australia/Broken_Hill</option>
                                <option value="Australia/Darwin"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Australia/Darwin' ? 'selected' : '' }}
                                    data-gmt="+09:30">19:55 pm - GMT +09:30 - Australia/Darwin</option>
                                <option value="Pacific/Guam"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Pacific/Guam' ? 'selected' : '' }}
                                    data-gmt="+10:00">20:25 pm - GMT +10:00 - Pacific/Guam</option>
                                <option value="Pacific/Saipan"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Pacific/Saipan' ? 'selected' : '' }}
                                    data-gmt="+10:00">20:25 pm - GMT +10:00 - Pacific/Saipan</option>
                                <option value="Antarctica/Macquarie"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Antarctica/Macquarie' ? 'selected' : '' }}
                                    data-gmt="+10:00">20:25 pm - GMT +10:00 - Antarctica/Macquarie</option>
                                <option value="Australia/Brisbane"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Australia/Brisbane' ? 'selected' : '' }}
                                    data-gmt="+10:00">20:25 pm - GMT +10:00 - Australia/Brisbane</option>
                                <option value="Australia/Hobart"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Australia/Hobart' ? 'selected' : '' }}
                                    data-gmt="+10:00">20:25 pm - GMT +10:00 - Australia/Hobart</option>
                                <option value="Australia/Lindeman"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Australia/Lindeman' ? 'selected' : '' }}
                                    data-gmt="+10:00">20:25 pm - GMT +10:00 - Australia/Lindeman</option>
                                <option value="Australia/Melbourne"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Australia/Melbourne' ? 'selected' : '' }}
                                    data-gmt="+10:00">20:25 pm - GMT +10:00 - Australia/Melbourne</option>
                                <option value="Australia/Sydney"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Australia/Sydney' ? 'selected' : '' }}
                                    data-gmt="+10:00">20:25 pm - GMT +10:00 - Australia/Sydney</option>
                                <option value="Australia/Lord_Howe"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Australia/Lord_Howe' ? 'selected' : '' }}
                                    data-gmt="+10:30">20:55 pm - GMT +10:30 - Australia/Lord_Howe</option>
                                <option value="Antarctica/McMurdo"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Antarctica/McMurdo' ? 'selected' : '' }}
                                    data-gmt="+12:00">22:25 pm - GMT +12:00 - Antarctica/McMurdo</option>
                                <option value="Pacific/Auckland"
                                    {{ App\Models\Settings::getSettingsvalue('time_zone') == 'Pacific/Auckland' ? 'selected' : '' }}
                                    data-gmt="+12:00">22:25 pm - GMT +12:00 - Pacific/Auckland</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- end card -->


                <!-- end card -->

            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </form>
@endsection
@section('scripts')


    <script>
        $('.select2').select2();




        $(document).ready(function() {
            $("#settingsUpdateFrm").on('submit', (function(e) {
                $(".errors").html('');
                e.preventDefault();

                $.ajax({
                     url: "{{ route('settingsUpdate') }}",
                    type: "post",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        if (response.message == 'success') {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Updated Successfully',

                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = '{{ url('settings') }}';
                            });

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
            }));
        });




        $(document).on('change', '.changeEnableLocalStorePickUp', function() {
            var thisId = $(this).attr('id').split('_');

            $('#preloader').fadeIn(100);
            $.ajax({
                url: "changeEnableLocalPickup",
                type: "post",
                data: {
                    'thisId': thisId[1],
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#preloader').fadeOut(100);
                    Swal.fire("Status Changed");



                }

            });

        });
    </script>
@endsection
