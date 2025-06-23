
<div class="card">
    <div class="card-header" style="text-align:center">
        <center> <h6 class="card-title mb-0" >Blog Details</h6></center>
        <img src="{{ asset('public/images/blog/' . $data->image) }}" alt="Blog Image" style="max-width: 50%; height: 50%;">
    </div>
    <div class="card-body">
        
        <div class="row">
            <h4 class="col-md-12" style="text-align:center"> {{$data->blog_title}} </h4><br>
            <h5 class="col-md-12" style="text-align:center"> {{$data->blog_category}} </h5><br>
            <h6 class="col-md-12"> {{$data->blog_date}}</h6><br>
            <div class="col-md-12"> {!! $data->blog_description !!} </div><br>
        </div>

        
    </div>
    <div class="card-footer">
        <a href="{{url('blog')}}" class="btn btn-primary" style="float:right">Back</a>
    </div>
</div>
