
@if($total_count != 0)
<ul class="pagination justify-content-center">
	<li class="page-item {{ $current_page == 1 ? 'disabled' : '' }}">
		<a class="page-link loadBtn" href="#" data-page="{{$current_page-1}}"  data-total-page="{{$total_page}}" data-current-page="{{$current_page}}" tabindex="-1" aria-disabled="true">
			<i class="fa fa-solid fa-angles-left"></i>
		</a>
	</li>
	@if($current_page-1 > 0)
	<li class="page-item" aria-current="page"> 
		<a class="page-link loadBtn" href="#" data-page="{{$current_page-1}}" data-total-page="{{$total_page}}" data-current-page="{{$current_page}}" >{{$current_page-1}}</a>
	</li>
	@endif
	<li class="page-item  active">
		<a class="page-link" href="#">{{$current_page}}</a>
	</li>
	@if($current_page+1 <= $total_page  )
	<li class="page-item " aria-current="page">
		<a class="page-link loadBtn" href="#" data-page="{{$current_page+1}}" data-total-page="{{$total_page}}" data-current-page="{{$current_page}}" >{{$current_page+1}}</a>
	</li>
	@endif
	<li class="page-item {{ $current_page+1 == $total_page ? 'disabled' : '' }}">
		<a class="page-link loadBtn" href="#" data-page="{{$current_page+1}}" data-total-page="{{$total_page}}" data-current-page="{{$current_page}}" >
			<i class="fa fa-solid fa-angles-right"></i>
		</a>
	</li>
</ul>
@endif
