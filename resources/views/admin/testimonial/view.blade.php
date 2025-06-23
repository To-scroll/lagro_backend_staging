<div class="modal-content">
    <div class="modal-body text-center p-5">
        
        <div class="mt-4 pt-4">
            <h4>Testimonial Info</h4>
           
            <div class="row row-deck" style="padding:10px;">
                @if($data->image !='')
                <div class="col-lg-4 col-md-12">
                    <img src="{{asset('public/images/testimonial')}}/{{ $data->image }}" alt="" class="img-fluid">
                </div>
                @endif
                <div class="col-lg-8 col-md-12">
                    <div>
                        <h4 class="mt-4 mt-lg-0 text-primary" ><strong>{{ucfirst($data->name)}}</strong></h4>
                
                        <p class="my-4">{{$data->description}}</p>
                        
                    </div>
                </div>
            </div>
           
            <!-- Toogle to second dialog -->
            <button class="btn btn-warning" id="close" data-bs-target="#secondmodal" data-bs-toggle="modal" data-bs-dismiss="modal">
               Close
            </button>
        </div>
    </div>
</div>