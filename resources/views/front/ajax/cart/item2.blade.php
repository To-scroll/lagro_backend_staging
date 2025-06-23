



@foreach ($cartItems as $cartItem)
    {{-- {{$cartItems}} --}}
    <li>
        <a href="{{ url('single-product', $cartItem->productItems->slug) }}" class="sidekka_pro_img">
            <img src="{{asset('public/images/product/'.$cartItem->productItems->image1)}}" alt="product">
        </a>
        <div class="ec-pro-content">
            <a href="{{ url('single-product', $cartItem->productItems->slug) }}" class="cart_pro_title">
                {{ $cartItem->product_name }}
            </a>
            <span class="cart-price"><span>{{ $cartItem->price }}</span> x {{ $cartItem->quantity }}</span>
            <div class="qty-plus-minus">
                <button class="qty-btn minus">-</button>
                {{-- <input class="qty-input" type="text" name="ec_qtybtn" value="{{ $cartItem->quantity }}" data-value="{{$cartItem->id}}"/> --}}
                <input class="qty-input" type="text" name="ec_qtybtn" value="{{ $cartItem->quantity }}" data-id="{{ $cartItem->id }}" />

                <button class="qty-btn plus">+</button>
            </div>
            <a href="#" class="remove" onclick="removeCartItem('{{ $cartItem->id }}')">×</a>
        </div>
    </li>
    
@endforeach


