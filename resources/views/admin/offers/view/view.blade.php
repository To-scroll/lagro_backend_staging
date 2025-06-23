<div class="card-body text-center">
   
    <h5 class="mt-4 mb-1">{{$offers->offer_name}}</h5>
</div>
<div class="card-body">
    <div class="table-responsive table-card">
        <table class="table table-borderless mb-0">
            <tbody>
                <tr>
                    <td class="fw-medium" scope="row">Offer Amount:</td>
                    <td>{{$offers->offer_amount}}</td>
                </tr>
                
                <tr>
                    <td class="fw-medium" scope="row">Offer Limit:</td>
                    <td>{{$offers->offer_limit}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <h5 class="mt-4 mb-3 text-center">Products</h5>
    <div class="table-responsive table-card ">
        <table class="table table-borderless mb-0">
            <tbody>
               @if(empty($offer_products))
                    <tr>
                        <td colspan="3" class="text-center">No products available for offer</td>
                    </tr>
                @else
                    @foreach($offer_products as $product)
                        <tr>
                            <td>{{ $product->order_product_name }}</td>
                            <td>
                                @if(isset($product->sku_images[0]))
                                    <img src="{{ $product->sku_images[0]->image }}" alt="Image" width="60">
                                @else
                                    <span>No Image</span>
                                @endif
                            </td>
                            <td>
                                @if($product->special_price)
                                    <span>{{ $product->special_price }}</span>
                                @else
                                    <span>{{$product->price}}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>