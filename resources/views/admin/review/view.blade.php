<div class="card">
	<div class="card-header">
		<center> <h6 class="card-title mb-0" style="text-align:center">Review Details</h6></center>
	</div>
	<div class="card-body">
		<div class="row">
			<label  class="col-md-6"style="float:left">Customer Name</label>
			<h6 class="col-md-6"> {{ $data->name }} </h6><br>
		</div>
		<div class="row">
			<label class="col-md-6" style="float:left">Email</label>
			<h6 class="col-md-6"> {{$data->email}} </h6><br>
		</div>
		<div class="row">
			<label class="col-md-6" style="float:left">Rating</label>
			<h6 class="col-md-6"> {{$data->rating}} </h6><br>
		</div>
		<div class="row">
			<label class="col-md-6" style="float:left">Is Approved</label>
			<h6 class="col-md-6"> {{ucfirst($data->is_approved)}} </h6><br>
		</div>
		{{-- @if($data->country!='')
		<div class="row">
			<label class="col-md-6" style="float:left">Country</label>
			<h6 class="col-md-6"> {{$data->country}} </h6><br>
		</div>
		@endif --}}
		{{-- @if($data->title !='')
		<div class="row">
			<label class="col-md-6" style="float:left">Title</label>
			<h6 class="col-md-6"> {{$data->title}} </h6><br>
		</div>
		@endif --}}
		
		@if($data->comment !='')
		<div class="row">
			<label class="col-md-6" style="float:left">Comment</label>
			<h6 class="col-md-6"> {{$data->comment}} </h6><br>
		</div>
		@endif
		
		
	</div>
	<div class="card-footer">
		<a href="{{url('reviews')}}" class="btn btn-primary" style="float:right">Back</a>
	</div>
</div>