<div class="card-body text-center">
    <div class="position-relative d-inline-block">
        <img src="{{asset('public/images/category')}}/{{ $category->icon }}" alt=""
            class="avatar-lg rounded-circle img-thumbnail shadow">
        <span class="contact-active position-absolute rounded-circle bg-success"><span
                class="visually-hidden"></span>
    </div>
    <h5 class="mt-4 mb-1">{{$category->category_name}}</h5>
    

    
</div>
<div class="card-body">
    <h6 class="text-muted text-uppercase fw-semibold mb-3">Description</h6>
    <div class="text-muted mb-4">{!!$category->description!!}</div>
    
    <div class="table-responsive table-card">
        <table class="table table-borderless mb-0">
            <tbody>
                <tr>
                    <td class="fw-medium" scope="row">Position:</td>
                    <td>:{{$category->position}}</td>
                </tr>
                <tr>
                    <td class="fw-medium" scope="row">Status:</td>
                    <td>:{{$category->status}}</td>
                </tr>
                <tr>
                    <td class="fw-medium" scope="row">Is Parent Category:</td>
                    <td>{{$category->is_parent}}</td>
                </tr>
               
                <tr>
                    <td class="fw-medium" scope="row">Created At</td>
                    <td>{{ $category->created_at->toDateString() }}<small class="text-muted" style="padding:5px;">{{ $category->created_at->format('h:i A') }}</small></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>