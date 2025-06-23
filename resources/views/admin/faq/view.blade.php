<div class="modal-content">
    <div class="modal-body text-center p-5">
        
        <div class="mt-4 pt-4">
             <h4>{{ $faq_category->category }}</h4>
           
            <div class="row row-deck" style="padding:10px;">
                <table class="table table-borderless w-100">
                    <tbody>
                        @foreach($faqs as $faq)
                            <tr>
                                <td class="text-start fw-semibold">{{ $faq->question }}?</td>
                            </tr>
                            <tr>
                                <td class="text-start">{{ $faq->answer }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
           
            <!-- Toogle to second dialog -->
            <button class="btn btn-warning" id="close" data-bs-target="#secondmodal" data-bs-toggle="modal" data-bs-dismiss="modal">
               Close
            </button>
        </div>
    </div>
</div>