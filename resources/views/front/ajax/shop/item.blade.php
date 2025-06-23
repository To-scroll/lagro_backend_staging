@foreach ($items as $item)
<div>
    <div class="product-box-3 h-100 wow fadeInUp" data-wow-daley="0.15s">
        <div class="product-header">
            <div class="product-image">
                <a href="{{url('shop/item')}}/{{$item->productItems->slug}}">
                    <img src="{{asset('public/images/product')}}/{{$item->productItems->image1}}" class="img-fluid blur-up lazyload" alt="">
                </a>
            </div>
        </div>

        <div class="product-footer">
            <div class="product-detail">
				<span class="span-name">{{\App\Models\Category::getNameFromIds($item->productItems->category_ids)}}</span>
                <a href="{{url('shop/item')}}/{{$item->productItems->slug}}">
                    <h5 class="name">{{$item->productItems->product_name}}</h5>
                </a>
                <p class="text-content mt-1 mb-2 product-content">{{$item->productItems->short_description}}</p>
                 
                 
                <h5 class="price"><span class="theme-color">{{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->special_price}}
										</span> <del>{{\App\Models\Settings::getSettingsvalue('currency_symbol')}} {{$item->price}}</del>
                </h5>
                <div class="add-to-cart-box bg-white">
                    <button class="btn btn-add-cart addcart-button addCartBtn">Add
                        <i class="fa-solid fa-plus bg-gray"></i></button>
                    <div class="cart_qty qty-box">
                        <div class="input-group bg-white">
                            <button type="button" class="qty-left-minus bg-gray qtyChangeBtn" data-type="minus" data-field="">
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </button>
                            <input class="form-control input-number qty-input" type="text" name="quantity"
                                value="0" data-product-id="{{$item->productItems->id}}" data-sku-id="{{$item->id}}">
                            <button type="button" class="qty-right-plus bg-gray qtyChangeBtn" data-type="plus" data-field="">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
