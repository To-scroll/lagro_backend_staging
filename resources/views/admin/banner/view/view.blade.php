<div class="card-body text-center">
   @if($banner->image)
    <div>
        <img src="{{asset('public/images/banner')}}/{{ $banner->image }}" alt=""
       style="height: 200px;width:300px;">
    <span class="contact-active position-absolute rounded-circle bg-success"><span
            class="visually-hidden"></span>
    </div>
    @else
     <div>
         <h1>hii</h1>
         </div>
    @endif
    <h5 class="mt-4 mb-1">{{$banner->title}}</h5>
    

    
</div>
<div class="card-body">
    <h6 class="text-muted text-uppercase fw-semibold mb-3">Description</h6>
    <div class="text-muted mb-4">{!!$banner->description!!}</div>
    
    <div class="table-responsive table-card">
        <table class="table table-borderless mb-0">
            <tbody>
                <tr>
                    <td class="fw-medium" scope="row">Type:</td>
                    <td>:{{$banner->type}}</td>
                </tr>
                
                <tr>
                    <td class="fw-medium" scope="row">Created At</td>
                    <td>{{ $banner->created_at->toDateString() }}<small class="text-muted" style="padding:5px;">{{ $banner->created_at->format('h:i A') }}</small></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>