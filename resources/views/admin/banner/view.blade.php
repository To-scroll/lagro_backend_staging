
				<div class="modal-content">
					<div class="modal-header">
						<center> <h6 class="card-title mb-0" style="text-align:center">Bannner Infos</h6></center>
						
					</div>
					<div class="modal-body">
						<div class="row">
							<label  class="col-md-6">Title</label>
							<h6 class="col-md-6"> {{ ucfirst($data->title)}} </h6><br>
						</div>
						@if($data->type!='')
						<div class="row">
							<label  class="col-md-6">Type</label>
							<h6 class="col-md-6"> {{ $data->type}} </h6><br>
						</div>
						@endif
						@if($data->description!='')
						<div class="row">
							<label  class="col-md-6">Description</label>
							<h6 class="col-md-6"> {!! $data->description !!} </h6><br>
						</div>
						@endif
						<div class="row">
							<label  class="col-md-6">Image</label>
							<img src="{{ asset('public/images/banner') }}/{{ $data->image }}" style="width:100px;height:100px;">
						</div>

						
						
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary modalClose" data-dismiss="modal">Close</button>
					</div>
				</div>
