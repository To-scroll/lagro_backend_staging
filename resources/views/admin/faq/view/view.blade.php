{{--
<div class="card-body">
    <h6 class="text-muted text-uppercase fw-semibold mb-3">FAQ</h6>
    <div class="text-muted mb-4">{{$faq_category->category}}</div>
    
    <div class="table-responsive table-card">
        <table class="table table-borderless mb-0">
            <tbody>
                @foreach($faqs as $faq)
                <tr>
                    @if(isset($faq))
                        <td class="fw-medium" scope="row">{{$faq->question}}?</td>
                        <td>{{$faq->answer}}</td>
                    @endif
                </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
</div>--}}


<div class="card-body">
    <h6 class="text-muted text-uppercase fw-semibold mb-3">FAQ</h6>
    <div class="text-muted mb-4">{{ $faq_category->category }}</div>
    
    <div class="table-responsive table-card">
        <table class="table table-borderless mb-0">
            <tbody>
                @foreach($faqs as $faq)
                    @if(isset($faq))
                        <tr>
                            <td class="fw-medium" scope="row">{{ $faq->question }}?</td>
                        </tr>
                        <tr>
                            <td colspan="1">{{ $faq->answer }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
