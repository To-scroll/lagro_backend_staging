@if($type == 'dashboard')
	@foreach ($address as $item)
	<div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
		<div class="address-box">
			<div>
				<div class="form-check">
					<input class="form-check-input defualtBtn" type="radio" data-value="{{$item->id}}" name="flexRadioDefault" @if($item->is_defualt == 'yes') checked @endif>
				</div>

				<div class="label">
					<label>{{ucfirst($item->type)}}</label>
				</div>

				<div class="table-responsive address-table">
					<table class="table">
						<tbody>
							<tr>
								<td colspan="2">{{$item->name}}</td>
							</tr>

							<tr>
								<td>Address :</td>
								<td>
									<p>{{$item->address}}
									</p>
								</td>
							</tr>

							<tr>
								<td>Pin Code :</td>
								<td>{{$item->pincode}}</td>
							</tr>

							<tr>
								<td>Landmark :</td>
								<td>{{$item->landmark}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<input type="hidden" id="address_avlbl" value="1">
			<div class="button-group">
				<button type="button" class="btn btn-sm add-button w-100 editAddresBtn"  value="{{$item->id}}"><i
						data-feather="edit" ></i>
					Edit</button>
				<button type="button" class="btn btn-sm add-button w-100 removeAddresBtn"  value="{{$item->id}}" ><i
						data-feather="trash-2"></i>
					Remove</button>
			</div>
		</div>
	</div>
	@endforeach

@else
	@foreach ($address as $item)
	<div class="col-xxl-6 col-lg-12 col-md-6">
		<div class="delivery-address-box">
			<div>
				<div class="form-check">
					<input class="form-check-input defualtBtn" type="radio" data-value="{{$item->id}}" name="flexRadioDefault" @if($item->is_defualt == 'yes') checked @endif>
				</div>
				<input type="hidden" id="address_avlbl" value="1">
				<div class="label">
					<label>{{ucfirst($item->type)}}</label>
				</div>

				<ul class="delivery-address-detail">
					<li>
						<h4 class="fw-500">{{$item->name}}</h4>
					</li>

					<li>
						<p class="text-content"><span class="text-title">Address
								: </span>{{$item->address}}</p>
					</li>

					<li>
						<h6 class="text-content"><span class="text-title">Pin Code
								:</span>{{$item->pincode}}</h6>
					</li>

					<li>
						<h6 class="text-content mb-0"><span class="text-title">Landmark
								:</span>{{$item->landmark}}</h6>
					</li>
				</ul>
			</div>
		</div>
	</div>	
	@endforeach
@endif


@if(count($address) == 0)
<div class="col-xxl-12 col-lg-12 col-md-12">
	<input type="hidden" id="address_avlbl" value="0">
	<div class="text-center pt-5 pb-5">
		Address not found ! 
	</div>
</div>	
@endif
