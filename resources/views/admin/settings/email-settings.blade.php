@extends('layouts.adminlayout')
@section('styles')
@stop
@section('content')
<div id="preloader"  >

</div>
<!-- start: page toolbar -->
<div class="page-toolbar px-xl-4 px-sm-2 px-0 py-3">
  <div class="container-fluid">
    <div class="row g-3 mb-3 align-items-center">
      <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
          <li class="breadcrumb-item"><a class="text-secondary" href="{{route('dashboard')}}">Dashboard</a></li>
          <!-- <li class="breadcrumb-item"><a class="text-secondary" href="{{route('settings.index')}}">Settings</a></li> -->
          <li class="breadcrumb-item active" aria-current="page">Email SMTP Settings</li>
        </ol>
      </div>
    </div>
  </div>
</div>


<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
  <div class="container-fluid">
    <div class="row g-3 clearfix row-deck">
      <div class="col-lg-12 col-md-12">
        <div class="card">
          <div class="card-header py-3"style="background-color:#3fbb7066;">
            <h6 class="card-title mb-0" style="color:white"> Email SMTP Settings</h6>
            <div class="dropdown morphing scale-left">
              <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="" data-bs-original-title="Card Full-Screen" aria-label="Card Full-Screen"><i class="icon-size-fullscreen"></i></a>
            </div>
          </div>
          <div class="card-body">
            <form id="storeEmailSettingsForm" method="post" enctype="multipart/form-data">
              @csrf  
              <div class="row">
            
                <div class="col-md-6 mb-3">
                  <label  class="form-label">Email</label>
                  <input type="email" class="form-control" name="smtp_email"  value="{{ App\Models\Settings::getSettingsvalue('smtp_email') }}">
                <!--   <span>This is the email address that the contact and report emails will be sent to, as well as being the from address in signup and notification emails.</span> -->
                </div> 
                 <div class="col-md-6 mb-3">
                  <label  class="form-label">Password</label>
                  <input type="text" class="form-control" name="smtp_password"  value="{{ App\Models\Settings::getSettingsvalue('smtp_password') }}">
              <!--     <span>Password of above given email.</span> -->
                </div> 
                <div class="col-md-6 mb-3">
                  <label  class="form-label">SMTP Host</label>
                  <input type="text" class="form-control" name="smtp_host" value="{{ App\Models\Settings::getSettingsvalue('smtp_host') }}">
                 <!--  <span>This is the host address for your smtp server, this is only needed if you are using SMTP as the Email Send Type.</span> -->
                </div>

                 <div class="col-md-6 mb-3">
                  <label  class="form-label">SMTP Port</label>
                  <input type="text" class="form-control" name="smtp_port" value="{{ App\Models\Settings::getSettingsvalue('smtp_port') }}">
                 <!--  <span>SMTP port this will provide your service provider.</span> -->
                </div> 


                <div class="col-md-6 mb-3">
                  <label  class="form-label">Email Content Type</label>
                  <select class="form-control" name="email_content_type">
                    <option value="">Select</option>
                    <option value="text" {{ App\Models\Settings::getSettingsvalue('email_content_type') == 'text' ? 'selected': '' }}>Text</option>
                    <option value="html" {{ App\Models\Settings::getSettingsvalue('email_content_type') == 'html' ? 'selected': '' }}>HTML</option>
                  </select>
               <!--    <span>Text-plain or HTML content chooser.</span> -->
                </div> 
                <div class="col-md-6 mb-3">
                  <label  class="form-label">SMTP Encryption</label>
                  <select class="form-control" name="smtp_encryption">
                    <option value="">Select</option>
                    <option value="off" {{ App\Models\Settings::getSettingsvalue('smtp_encryption') == 'off' ? 'selected': '' }}>Off</option>
                    <option value="ssl" {{ App\Models\Settings::getSettingsvalue('smtp_encryption') == 'ssl' ? 'selected': '' }}>SSL</option>
                    <option value="tls" {{ App\Models\Settings::getSettingsvalue('smtp_encryption') == 'tls' ? 'selected': '' }}>TLS</option>
                  </select>
               <!--    <span>If your e-mail service provider supported secure connections, you can choose security method on list.</span> -->
                </div>  
              
              
               
                
              
               

              </div>
                 
              <div class="col-md-12 mb-3" align="right">
                <div class="col-12">
                  <button  type="submit" class="btn btn rounded-4 btn-primary">Submit</button>
                  <a class="btn btn rounded-4 btn-secondary" href="{{ route('settings.index') }}">Back</a>
                </div>
              </div>
            </form>
            
          </div>
        </div>
      </div>
      
      
    </div>
    
  </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$('#preloader').fadeOut(100); 
$("#storeEmailSettingsForm").on('submit',(function(e) {
$(".errors").html('');
e.preventDefault();
   $('#preloader').fadeIn(100); 
    $.ajax({
        url: "{{ route('settingsUpdate') }}",
        type:"post",
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(data)
        {
          //console.log(data);return false;
           $('#preloader').fadeOut(100); 
           Swal.fire('Updated Successfully');
           //location.reload();
        },
        error:function (response){
        
          $('#preloader').fadeOut(100); 
          jsonValue = jQuery.parseJSON(response.responseText);
          $.each(jsonValue.errors,function(field_name,error){
            $(document).find('[name='+field_name+']').after('<small class="form-control-feedback text-danger errors"> '+error+' </small>')
          });
        }
    });
}));


</script>
@stop