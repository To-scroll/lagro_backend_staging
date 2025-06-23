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
          <li class="breadcrumb-item"><a class="text-secondary" href="{{route('badge.index')}}">Badge</a></li>
          <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
      </div>
    </div>
  </div>
</div>



@endsection
@section('scripts')
<script type="text/javascript">
 $('#preloader').fadeOut(100); 
$("#badgeCreateForm").on('submit',(function(e) {
$(".errors").html('');
e.preventDefault();
   $('#preloader').fadeIn(100); 
    $.ajax({
        url: "{{ route('badgeStore') }}",
        type:"post",
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(data)
        {
           $('#preloader').fadeOut(100); 
           Swal.fire(data);


          $('#badgeCreateForm')[0].reset();
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