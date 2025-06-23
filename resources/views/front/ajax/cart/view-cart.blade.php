@foreach ($cartItems as $cartItem)
    <tr data-cartitemid="{{ $cartItem->id }}">
        <td data-label="Product" class="ec-cart-pro-name"><a href="{{ url('single-product', $cartItem->productItems->slug) }}"><img
                    class="ec-cart-pro-img mr-4"
                    src="{{ asset('public/images/product/' . $cartItem->productItems->image1) }}"
                    alt="" />{{ $cartItem->productItems->product_name }}</a>
        </td>
        <td data-label="Price" class="ec-cart-pro-price"><span class="amount">{{ $cartItem->price }}</span></td>
        <td data-label="Quantity" class="ec-cart-pro-qty" style="text-align: center;">
            <div class="cart-qty-plus-minus">
                
                <input class="qty-input" type="text" name="ec_qtybtn" value="{{ $cartItem->quantity }}"
                    data-id="{{ $cartItem->id }}" />
                <div class="ec_cart_qtybtn">
                                                            <div class="inc ec_qtybtn">+</div>
                                                            <div class="dec ec_qtybtn">-</div>
                                                        </div>
            </div>
        </td>

        <td data-label="Total" class="ec-cart-pro-subtotal">
            {{ $cartItem->total }}</td>
        <td data-label="Remove" class="ec-cart-pro-remove">
            <a href="#" onclick="removeCartItem('{{ $cartItem->id }}')"><i class="ecicon eci-trash-o"></i></a>
        </td>
       
    </tr>
@endforeach
