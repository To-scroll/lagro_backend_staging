@extends('layouts.adminlayout')
@section('styles')

@endsection
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Configuration</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('configuration') }}">Configuration</a></li>
                   
                </ol>
            </div>

        </div>
    </div>
</div>

    <!-- start: page body -->
    <div class="page-body  mt-3">
        <div class="container-fluid">
            {{-- <form action="{{configuration.store}}" method="POST"> --}}

            <div class="row" style="padding: 15px;">
                <div class="card">
                    <div class="row">


                        <h4 class="card-title m-0" style="padding: 10px;align-text:center">Payments</h4>
                        <div class="row" style="padding: 15px;">
                            <div class="col-md-6">
                                <h6>RazorPay</h6>
                            </div>
                            <div class="col-md-6">

                                <div class="form-check form-switch">

                                    <input class="form-check-input is_enables" type="checkbox" id="razorpayCheckbox" value="2"
                                        @if (App\Models\Config::getAll('RAZORPAY', 'is_enabled') == 'yes') checked @endif>
                                </div>

                            </div>
                            {{-- @if (App\Models\Config::getAll('PAYMENT', 'Razorpay', 'is_enabled') == 'yes') --}}
                            <div class="col-md-12" id="razorpayFields"
                                @if (App\Models\Config::getAll('RAZORPAY', 'is_enabled') != 'yes') style="display: none" @endif style="padding:10px;">
                                <form action="{{ route('configuration.store') }}" method="POST">
                                    @csrf
                                    <div class="row" style="padding: 10px;">
                                        <div class="col-md-2">

                                            <h6>Sandbox</h6>
                                        </div>
                                        <div class="col-md-5">


                                            <label>RAZORPAY_SANDBOX_KEY</label>
                                            <input type="text" name="RAZORPAY_SANDBOX_KEY" class="form-control"
                                                placeholder="key"
                                                value="{{ App\Models\ConfigValue::getvalue('RAZORPAY_SANDBOX_KEY') }}">
                                        </div>
                                        <div class="col-md-5">
                                            <label>RAZORPAY_SANDBOX_SECRET</label>
                                            <input type="text" name="RAZORPAY_SANDBOX_SECRET" class="form-control"
                                                placeholder="Secret"
                                                value="{{ App\Models\ConfigValue::getvalue('RAZORPAY_SANDBOX_SECRET') }}">
                                        </div>
                                    </div>
                                    <div class="row" style="padding: 10px;">
                                        <div class="col-md-2">
                                            <h6>Live</h6>
                                        </div>
                                        <div class="col-md-5">
                                            <label>RAZORPAY_LIVE_KEY</label>
                                            <input type="text" name="RAZORPAY_LIVE_KEY" class="form-control"
                                                placeholder="key"
                                                value="{{ App\Models\ConfigValue::getvalue('RAZORPAY_LIVE_KEY') }}">
                                        </div>
                                        <div class="col-md-5">
                                            <label>RAZORPAY_LIVE_SECRET</label>
                                            {{-- <p>Value</p> --}}
                                            <input type="text" name="RAZORPAY_LIVE_SECRET" class="form-control"
                                                placeholder="Secret"
                                                value="{{ App\Models\ConfigValue::getvalue('RAZORPAY_LIVE_SECRET') }}">
                                        </div>
                                    </div>
                                    <div class="row" style="padding: 10px;">
                                        <div class="col-md-2">
                                            <h6
                                                style="    position: relative;
                                            padding-right: 5px;
                                            padding-left: 66.1px;    padding-top: 10px;">
                                                Select Live or Sandbox</h6>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="hidden" name="module_name" value="{{App\Models\Config::getModuleName('RAZORPAY')}}">
                                            <select name="type" id="selectOption" class="form-control">


                                                <option value="sandbox"
                                                    {{ App\Models\Config::getAll('RAZORPAY', 'type') == 'sandbox' ? 'selected' : '' }}>
                                                    Sandbox</option>
                                                <option value="live"
                                                    {{ App\Models\Config::getAll('RAZORPAY', 'type') == 'live' ? 'selected' : '' }}>
                                                    Live</option>

                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <button type="submit" class="btn btn-primary" id="submitbtn"
                                                style="float: right;    width:100%;height: 36.5px;">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- @endif --}}
                        </div>
                        <div class="row" style="padding: 15px;">
                            <div class="col-md-6">

                                <h6>Paypal</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input is_enables" type="checkbox" id="paypalCheckbox" value="11"
                                        @if (App\Models\Config::getAll('PAYPAL', 'is_enabled') == 'yes') checked @endif>
                                </div>
                            </div>
                            {{-- @if (App\Models\Config::getAll('PAYMENT', 'Paypal', 'is_enabled') == 'yes') --}}
                            <div class="col-md-12" id="paypalFields"
                                @if (App\Models\Config::getAll('PAYPAL', 'is_enabled') != 'yes') style="display: none" @endif style="padding:10px;">
                                <form action="{{ route('configuration.store') }}" method="POST">
                                    @csrf
                                    <div class="row" style="padding: 10px;">
                                        <div class="col-md-2">
                                            <h6>Sandbox</h6>
                                        </div>
                                        <div class="col-md-5">
                                            <label>PAYPAL_SANDBOX_KEY</label>

                                            {{-- <p>Key</p> --}}
                                            <input type="text" name="PAYPAL_SANDBOX_KEY" class="form-control"
                                                placeholder="key"
                                                value="{{ App\Models\ConfigValue::getvalue('PAYPAL_SANDBOX_KEY') }}">
                                        </div>
                                        <div class="col-md-5">
                                            <label>PAYPAL_SANDBOX_SECRET</label>

                                            {{-- <p>Value</p> --}}
                                            <input type="text" name="PAYPAL_SANDBOX_SECRET" class="form-control"
                                                placeholder="Secret"
                                                value="{{ App\Models\ConfigValue::getvalue('PAYPAL_SANDBOX_SECRET') }}">
                                        </div>
                                    </div>
                                    <div class="row" style="padding: 10px;">
                                        <div class="col-md-2">
                                            <h6>Live</h6>
                                        </div>
                                        <div class="col-md-5">
                                            <label>PAYPAL_LIVE_KEY</label>

                                            {{-- <p>Key</p> --}}
                                            <input type="text" name="PAYPAL_LIVE_KEY" class="form-control"
                                                placeholder="key"
                                                value="{{ App\Models\ConfigValue::getvalue('PAYPAL_LIVE_KEY') }}">
                                        </div>
                                        <div class="col-md-5">
                                            <label>PAYPAL_LIVE_SECRET</label>

                                            {{-- <p>Value</p> --}}
                                            <input type="text" name="PAYPAL_LIVE_SECRET" class="form-control"
                                                placeholder="Secret"
                                                value="{{ App\Models\ConfigValue::getvalue('PAYPAL_LIVE_SECRET') }}">
                                        </div>
                                    </div>
                                    <div class="row" style="padding: 10px;">
                                        <div class="col-md-2">
                                            <h6
                                                style="    position: relative;
                                            padding-right: 5px;
                                            padding-left: 66.1px;    padding-top: 10px;">
                                                Select Live or Sandbox</h6>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="hidden" name="module_name" value="{{App\Models\Config::getModuleName('PAYPAL')}}">

                                            <select name="type" id="selectOption" class="form-control">


                                                <option value="sandbox"
                                                    {{ App\Models\Config::getAll('PAYPAL', 'type') == 'sandbox' ? 'selected' : '' }}>
                                                    Sandbox</option>
                                                <option value="live"
                                                    {{ App\Models\Config::getAll('PAYPAL', 'type') == 'live' ? 'selected' : '' }}>
                                                    Live</option>

                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <button type="submit" class="btn btn-primary" id="submitbtn"
                                                style="float: right;    width:100%;height: 36.5px;">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            {{-- @endif --}}
                        </div>
                        <div class="row" style="padding: 15px;">
                            <div class="col-md-6">
                                <h6>Stripe</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input is_enables" type="checkbox" id="stripeCheckbox" value="13"
                                        @if (App\Models\Config::getAll('STRIPE', 'is_enabled') == 'yes') checked @endif>
                                </div>
                            </div>
                            {{-- @if (App\Models\Config::getAll('PAYMENT', 'Stripe', 'is_enabled') == 'yes') --}}
                            <div class="col-md-12" id="stripeFields"
                                @if (App\Models\Config::getAll('STRIPE', 'is_enabled') != 'yes') style="display: none" @endif style="padding:10px;">
                                <form action="{{ route('configuration.store') }}" method="POST">
                                    @csrf
                                    <div class="row" style="padding: 10px;">
                                        <div class="col-md-2">
                                            <h6>Sandbox</h6>
                                        </div>
                                        <div class="col-md-5">
                                            <label>STRIPE_SANDBOX_KEY</label>

                                            {{-- <p>Key</p> --}}
                                            <input type="text" name="STRIPE_SANDBOX_KEY" class="form-control"
                                                placeholder="key"
                                                value="{{ App\Models\ConfigValue::getvalue('STRIPE_SANDBOX_KEY') }}">
                                        </div>
                                        <div class="col-md-5">
                                            <label>STRIPE_SANDBOX_SECRET</label>

                                            {{-- <p>Value</p> --}}
                                            <input type="text" name="STRIPE_SANDBOX_SECRET" class="form-control"
                                                placeholder="Secret"
                                                value="{{ App\Models\ConfigValue::getvalue('STRIPE_SANDBOX_SECRET') }}">
                                        </div>
                                    </div>
                                    <div class="row" style="padding: 10px;">
                                        <div class="col-md-2">
                                            <h6>Live</h6>
                                        </div>
                                        <div class="col-md-5">
                                            <label>STRIPE_LIVE_KEY</label>

                                            <input type="text" name="STRIPE_LIVE_KEY" class="form-control"
                                                placeholder="key"
                                                value="{{ App\Models\ConfigValue::getvalue('STRIPE_LIVE_KEY') }}">
                                        </div>
                                        <div class="col-md-5">
                                            <label>STRIPE_LIVE_SECRET</label>

                                            {{-- <p>Value</p> --}}
                                            <input type="text" name="STRIPE_LIVE_SECRET" class="form-control"
                                                placeholder="Secret"
                                                value="{{ App\Models\ConfigValue::getvalue('STRIPE_LIVE_SECRET') }}">
                                        </div>
                                    </div>
                                    <div class="row" style="padding: 10px;">
                                        <div class="col-md-2">
                                            <h6
                                                style="    position: relative;
                                            padding-right: 5px;
                                            padding-left: 66.1px;    padding-top: 10px;">
                                                Select Live or Sandbox</h6>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="hidden" name="module_name" value="{{App\Models\Config::getModuleName('STRIPE')}}">

                                            <select name="type" id="selectOption" class="form-control">


                                                <option value="sandbox"
                                                    {{ App\Models\Config::getAll('STRIPE', 'type') == 'sandbox' ? 'selected' : '' }}>
                                                    Sandbox</option>
                                                <option value="live"
                                                    {{ App\Models\Config::getAll('STRIPE', 'type') == 'live' ? 'selected' : '' }}>
                                                    Live</option>

                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <button type="submit" class="btn btn-primary" id="submitbtn"
                                                style="float: right;    width:100%;height: 36.5px;">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            {{-- @endif --}}
                        </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="row" style="padding: 15px;">
                <div class="card">
                    <div class="row">
                        <h4 class="card-title m-0" style="padding: 10px;">Email</h4>
                        <div class="row" style="padding: 15px;">
                            <div class="col-md-6">
                                <h6>Email</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input is_enables" type="checkbox" id="emailCheckbox" value="1"
                                        @if (App\Models\Config::getAll('EMAIL', 'is_enabled') == 'yes') checked @endif>
                                </div>
                            </div>
                            {{-- @if (App\Models\Config::getAll('EMAIL', 'EMAIL', 'is_enabled') == 'yes') --}}
                            <div class="col-md-12" id="emailFields"
                                @if (App\Models\Config::getAll('EMAIL', 'is_enabled') != 'yes') style="display: none" @endif style="padding:10px;">
                                <form action="{{ route('configuration.store') }}" method="POST">
                                    @csrf
                                    <div class="row" style="padding: 10px;">
                                        {{-- <div class="col-md-2">
                                        <h6>Sandbox</h6>
                                    </div> --}}
                                        <div class="col-md-3">
                                            <label>MAIL_MAILER</label>

                                            {{-- <p>Key</p> --}}
                                            <input type="text" name="MAIL_MAILER" class="form-control"
                                                placeholder="key"
                                                value="{{ App\Models\ConfigValue::getvalue('MAIL_MAILER') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label>MAIL_HOST</label>

                                            {{-- <p>Value</p> --}}
                                            <input type="text" name="MAIL_HOST" class="form-control"
                                                placeholder="Secret"
                                                value="{{ App\Models\ConfigValue::getvalue('MAIL_HOST') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label>MAIL_PORT</label>

                                            {{-- <p>Value</p> --}}
                                            <input type="text" name="MAIL_PORT" class="form-control"
                                                placeholder="Secret"
                                                value="{{ App\Models\ConfigValue::getvalue('MAIL_PORT') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label>MAIL_USERNAME</label>

                                            {{-- <p>Value</p> --}}
                                            <input type="text" name="MAIL_USERNAME" class="form-control"
                                                placeholder="Secret"
                                                value="{{ App\Models\ConfigValue::getvalue('MAIL_USERNAME') }}">
                                        </div>
                                    </div>
                                    <div class="row" style="padding: 10px;">
                                        {{-- <div class="col-md-2">
                                        <h6>Live</h6>
                                    </div> --}}
                                        <div class="col-md-3">
                                            <label>MAIL_PASSWORD</label>

                                            {{-- <p>Key</p> --}}
                                            <input type="text" name="MAIL_PASSWORD" class="form-control"
                                                placeholder="key"
                                                value="{{ App\Models\ConfigValue::getvalue('MAIL_PASSWORD') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label>MAIL_ENCRYPTION</label>

                                            {{-- <p>Value</p> --}}
                                            <input type="text" name="MAIL_ENCRYPTION" class="form-control"
                                                placeholder="Secret"
                                                value="{{ App\Models\ConfigValue::getvalue('MAIL_ENCRYPTION') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label>MAIL_FROM_ADDRESS</label>

                                            {{-- <p>Value</p> --}}
                                            <input type="text" name="MAIL_FROM_ADDRESS" class="form-control"
                                                placeholder="Secret"
                                                value="{{ App\Models\ConfigValue::getvalue('MAIL_FROM_ADDRESS') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label>MAIL_FROM_NAME</label>

                                            {{-- <p>Value</p> --}}
                                            <input type="text" name="MAIL_FROM_NAME" class="form-control"
                                                placeholder="Secret"
                                                value="{{ App\Models\ConfigValue::getvalue('MAIL_FROM_NAME') }}">
                                        </div>
                                    </div>
                                    <div class="row" style="padding: 10px;">
                                        <div class="col-md-2">
                                            <h6
                                                style="    position: relative;
                                            padding-right: 5px;
                                            padding-left: 60px;    padding-top: 10px;">
                                                Select Live or Sandbox</h6>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="hidden" name="module_name" value="EMAIL">

                                            <select name="type" id="selectOption" class="form-control">


                                                <option value="sandbox"
                                                    {{ App\Models\Config::getAll('STRIPE', 'type') == 'sandbox' ? 'selected' : '' }}>
                                                    Sandbox</option>
                                                <option value="live"
                                                    {{ App\Models\Config::getAll('STRIPE', 'type') == 'live' ? 'selected' : '' }}>
                                                    Live</option>

                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <button type="submit" class="btn btn-primary" id="submitbtn"
                                                style="float: right;    width:100%;height: 36.5px;">Save</button>
                                        </div>
                                    </div>
                            </div>

                            </form>
                            {{-- @endif --}}
                        </div>


                    </div>
                </div>
            </div>

            {{-- <button type="submit" class="btn btn-primary" style="float: right;    width: 300px;height: 50px;">Submit</button> --}}
            </form>
        </div>






        {{-- <div class="modal fade bd-example-modal-lg viewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">

            <div id="badgeShow"></div>

        </div>
    </div> --}}
    @endsection
    @section('scripts')
   
        <script type="text/javascript">
          
            

            $(document).on('change', '.is_enables', function() {
                var thisId = $(this).val();
                $('#preloader').fadeIn(100);
                $.ajax({
                    url: "config_status",
                    type: "post",
                    data: {
                        'thisId': thisId,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#preloader').fadeOut(100);
                        Swal.fire("Status Changed");
                        tableX.draw();


                    }

                });

            });
           
            $(document).ready(function() {
                $('#razorpayCheckbox').change(function() {
                    if (this.checked) {
                        $('#razorpayFields').show();
                    } else {
                        $('#razorpayFields').hide();
                    }
                });

                $('#paypalCheckbox').change(function() {
                    if (this.checked) {
                        $('#paypalFields').show();
                    } else {
                        $('#paypalFields').hide();
                    }
                });
                $('#stripeCheckbox').change(function() {
                    if (this.checked) {
                        $('#stripeFields').show();
                    } else {
                        $('#stripeFields').hide();
                    }
                });
                $('#emailCheckbox').change(function() {
                    if (this.checked) {
                        $('#emailFields').show();
                    } else {
                        $('#emailFields').hide();
                    }
                });
                $('#emailCheckbox').change(function() {
                    if (this.checked) {
                        $('#emailFields').show();
                    } else {
                        $('#emailFields').hide();
                    }
                });
            });
        </script>
    @endsection()
