@if($type == 'edit')
<form id="address_form">
	<input type="hidden" name="id" value="{{$data->id}}">
	<div class="form-floating mb-4 theme-form-floating">
		<input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="{{$data->name}}">
		<label for="name">Name</label>
	</div>
	<div class="form-floating mb-4 theme-form-floating">
		<textarea class="form-control" placeholder="" id="address" name="address"
			style="height: 100px">{{ $data->address }}</textarea>
		<label for="address">Enter Address</label>
	</div>
	<div class="form-floating mb-4 theme-form-floating">
		<input type="text" class="form-control" id="landmark" name="landmark" placeholder="Enter Landmark" value="{{$data->landmark}}">
		<label for="landmark">Landmark</label>
	</div>
	<div class="form-floating mb-4 theme-form-floating">
		<input type="number" class="form-control" id="pincode" name="pincode" placeholder="Enter Pin Code" value="{{$data->pincode}}">
		<label for="pincode">Pin Code</label>
	</div>
	<div class="form-floating mb-4 theme-form-floating">
		<select class="form-control" name="type" id="type">
			<option selected disabled>Choose</option>
			<option value="home" @if($data->type == 'home') selected @endif>Home</option>
			<option value="office" @if($data->type == 'office') selected @endif>Office</option>
		</select>
		<label for="type">Address Type</label>
	</div>
</form>
@else
<form id="address_form">
	<div class="form-floating mb-4 theme-form-floating">
		<input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
		<label for="name">Name</label>
	</div>
	<div class="form-floating mb-4 theme-form-floating">
		<textarea class="form-control" placeholder="" id="address" name="address"
			style="height: 100px"></textarea>
		<label for="address">Enter Address</label>
	</div>
	<div class="form-floating mb-4 theme-form-floating">
		<input type="text" class="form-control" id="landmark" name="landmark" placeholder="Enter Landmark">
		<label for="landmark">Landmark</label>
	</div>
	<div class="form-floating mb-4 theme-form-floating">
		<input type="number" class="form-control" id="pincode" name="pincode" placeholder="Enter Pin Code">
		<label for="pincode">Pin Code</label>
	</div>
	<div class="form-floating mb-4 theme-form-floating">
		<select class="form-control" name="type" id="type">
			<option selected disabled>Choose</option>
			<option value="home">Home</option>
			<option value="office">Office</option>
		</select>
		<label for="type">Address Type</label>
	</div>
</form>
@endif