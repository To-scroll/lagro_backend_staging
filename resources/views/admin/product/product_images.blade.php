@if($images->count()>0)
    @foreach($images as $image)
        @if($image->image)
            <img src="{{ asset('public/images/products/image/' . $image->image) }}" class="img-fluid mb-2" alt="Variant Image">
        @else
            <p class="text-muted">Image entry found, but no file name provided.</p>
        @endif
    @endforeach
@else
    <p class="text-muted">No images available for this variant.</p>
@endif
