<div class="card-body text-center">
   
    <h5 class="mt-4 mb-1">{{$locations->location_name}}</h5>
</div>
<div class="card-body">
    <div class="table-responsive table-card">
        <table class="table table-borderless mb-0">
            <tbody>
                <tr>
                    <td class="fw-medium" scope="row">Address:</td>
                    <td>{{$locations->location_address}}</td>
                </tr>
                
                <tr>
                    <td class="fw-medium" scope="row">Phone1:</td>
                    <td>{{$locations->phone1}}</td>
                </tr>
                <tr>
                    <td class="fw-medium" scope="row">Phone2:</td>
                    <td>{{$locations->phone2}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>