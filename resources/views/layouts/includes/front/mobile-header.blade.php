<div class="mobile-menu d-md-none d-block mobile-cart">
	<ul>
		<li class="{{ request()->is('/') ? 'active' : '' }}">
			<a href="{{url('/')}}">
				<i class="iconly-Home icli"></i>
				<span>Home</span>
			</a>
		</li>

		<li class="mobile-category {{ request()->is('shop') ? 'active' : '' }}">
			<a href="{{url('shop')}}">
				<i class="iconly-Category icli js-link"></i>
				<span>Shop</span>
			</a>
		</li>

		{{--  <li>
			<a href="#" class="search-box">
				<i class="iconly-Search icli"></i>
				<span>Search</span>
			</a>
		</li>  --}}

		 

		<li class="{{ request()->is('cart') ? 'active' : '' }}">
			<a href="{{url('cart')}}">
				<i class="iconly-Bag-2 icli fly-cate"></i>
				<span>Cart</span>
			</a>
		</li>
	</ul>
</div>