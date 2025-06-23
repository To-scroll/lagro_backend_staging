<div class="modal fade" id="unavailableProductModal" tabindex="-1" role="dialog"
    aria-labelledby="unavailableProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unavailableProductModalLabel">Product Not Available</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="unavailableProductMessage">The product "<span id="unavailableProductName"></span>" is not
                    available for your area. Please remove it from your cart.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>




@foreach ($addressList as $address)
    <div style="padding: 30px; border: 1px solid #ededed; background-color: #fff; border-radius: 5px;" id="addresshide">

        <span>
            <input type="radio" id="bill{{ $address->id }}" name="radio-group"
                value="{{ $address->pincode }}"checked>
            <label for="bill{{ $address->id }}">
                {{ $address->name }}<br>
                {{ $address->address }}<br>
                {{ $address->pincode }}
            </label>
        </span>
        <button class="btn btn-danger deleteBtn" type="button" value="{{ $address->id }}"
            style=" background-color: #dc3545;
           
            color: white;
           
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 3px;
            float: right;"><i
                class="ecicon eci-trash-o"></i> </button>
        <!-- Display other address details here -->
    </div>
@endforeach


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://www.paypal.com/sdk/js?client-id=AQk8eACBIqqeDHUoL_o-7WWPjSJs5nDShB30j7ahATi5bPzTW3kz_2X2R40k_I1m-jIgOz0pnacxZp8S&currency=INR"></script>
<script>
     
     
  </script>