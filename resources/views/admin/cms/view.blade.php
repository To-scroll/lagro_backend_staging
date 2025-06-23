
<div class="card">
    <div class="card-header">
        <center> <h6 class="card-title mb-0" style="text-align:center">Page Details</h6></center>
        
    </div>
    <div class="card-body">
        <div class="row">
            <label  class="col-md-6"style="float:left">Page Name</label>
            <h6 class="col-md-6"> {{$data->page_name}} </h6><br>
        </div>
        
        <div class="row">
            <label class="col-md-6" style="float:left">Meta Title</label>
            <h6 class="col-md-6"> {{ !isset($meta) ? '' : $meta->title}} </h6><br>
        </div>
        <div class="row">
            <label class="col-md-6" style="float:left">Meta Description</label>
            <h6 class="col-md-6"> {{ !isset($meta) ? '' : $meta->description}} </h6><br>
        </div>
        <div class="row">
            <label class="col-md-6" style="float:left">Meta Keywords</label>
            <h6 class="col-md-6"> {{ !isset($meta) ? '' : $meta->keywords}} </h6><br>
        </div>
        <div class="row">
            <label class="col-md-6" style="float:left">Route</label>
            <h6 class="col-md-6"> {{$data->route}} </h6><br>
        </div>
        <div class="row">
            <label class="col-md-12" style="float:left">Content</label>
            <div class="col-md-12" style="border: 1px solid #d9d5d5;"> {!! $data->content !!} </div><br>
        </div>
        
        
        
        
    </div>
    <div class="card-footer">
        <a href="{{url('cms')}}" class="btn btn-primary" style="float:right">Back</a>
    </div>
</div>
