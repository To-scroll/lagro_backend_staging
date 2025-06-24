
<div class="card">
    <div class="card-header" style="text-align:center">
        <img src="{{ asset('public/images/staff/' . $data->image) }}" alt="Blog Image" style="max-width: 50%; height: 50%;">
        <center> <h4> {{$data->name}}</h4></center>
    </div>
    <div class="card-body">
        
        <div class="row">
            <h4 class="col-md-12" style="text-align:center"> {{$data->phone}} </h4><br>
            <h5 class="col-md-12" style="text-align:center"> {{$data->email}} </h4><br>
            <h6 class="col-md-12" style="text-align:center"> {{$data->position}}</h6><br>
            <h6 class="col-md-12" style="text-align:center"> {{$data->place}} </h6><br>
            <h6 class="col-md-12" style="text-align:center"> {{$data->date_of_bith}} </h6><br>
        </div>

        
    </div>
    <div class="card-footer">
        <a href="{{url('staff')}}" class="btn btn-primary" style="float:right">Back</a>
    </div>
</div>
