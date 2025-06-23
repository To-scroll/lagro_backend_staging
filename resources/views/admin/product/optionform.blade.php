<div class="modal-header">
            <center> <h6 class="card-title mb-0" style="text-align:center">Add Atrribute Options</h6></center>
            
          </div>
          <div class="modal-body">
            <div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-3">
              <div class="container-fluid">
                <div class="row g-4">
                  <div class="col-12">
                     <div class="card-body">
                      <form id="attributeOptionAddForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                          <div class="col-md-6">
                            <label  class="form-label">Attribute Name</label>
                            <select class="form-control" name="attribute_name">
                               <option value="">Select Attributes</option>
                                @foreach($attributes as $row)
                                <option value="{{$row->id}}">{{$row->attribute_name}}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="col-md-6">
                            <label  class="form-label">Attribute Option Name</label>
                            <input type="text" class="form-control" name="option_name" value="">
                          </div>
                          
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="attributeOptionSubBtn">ADD</button>
            <button type="button" class="btn btn-secondary modalClose" data-dismiss="modal">Close</button>
          </div>