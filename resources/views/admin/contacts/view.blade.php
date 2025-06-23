<div class="modal-content">
    <div class="modal-body text-center p-5">
        
        <div class="mt-4 pt-4">
            <h4>Message </h4>
            <p class="text-muted"> {{$data->message}}</p>
            <!-- Toogle to second dialog -->
            <button class="btn btn-warning" id="close" data-bs-target="#secondmodal" data-bs-toggle="modal" data-bs-dismiss="modal">
               Close
            </button>
        </div>
    </div>
</div>