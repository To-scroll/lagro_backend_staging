<div class="modal-content">
    <div class="modal-body text-center p-5">
        
        <div class="mt-4 pt-4">
            <h4>Customer Info</h4>
           
            <p >  Name : {{ $data->name }}</p>
            <p >   Email : {{ $data->email }}</p>
            <p >  Phone : {{ $data->phone }}</p>
           
            <!-- Toogle to second dialog -->
            <button class="btn btn-warning" id="close" data-bs-target="#secondmodal" data-bs-toggle="modal" data-bs-dismiss="modal">
               Close
            </button>
        </div>
    </div>
</div>