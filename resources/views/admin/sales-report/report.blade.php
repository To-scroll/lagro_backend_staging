    <h3>Order Details</h3>
    <table>

      <tr>
        <th><b>Order No</b></th>
        <td>{{ $order_data->order_no }}</td>
      </tr>
      <tr>
        <th ><b>Customer Name</b></th>
        <td>{{ ucfirst($order_data->customer_name) }}</td>
      </tr>
      <tr>
        <th><b>Email</b></th>
        <td>{{ $order_data->customer_email }}</td>
      </tr>
      <tr>
        <th><b>Phone</b></th>
        <td align="left">{{ $order_data->customer_phone }}</td>
      </tr>
      <tr>
        <th><b>Address</b></th>
        <td>{{ ucfirst($order_data->address) }} {{ $order_data->landmark }} {{ $order_data->pincode }}</td>
      </tr>
      <tr>
        <th><b>Order Date</b></th>
         <td>{{ date('d-m-Y H:i',strtotime($order_data->date)) }}</td>
       </tr>
       <tr>
        <th><b>Total Amount</b></th>
        <td align="left">{{ $order_data->total_amount }}</td>
      </tr>
      <tr>
        <th><b>Reference No</b></th>
        <td>{{ $order_data->reference_no }}</td>
      </tr>
      <tr>
        <th><b>Status</b></th>
         <td>{{ ucfirst($order_data->status) }}</td>
      </tr>
      <tr>
        <th><b>Delivery Status</b></th>
        <td>{{ ucfirst($order_data->delivery_status) }}</td>
      
      </tr> 
       <tr>
        <th><b>Payment Method</b></th>
        <td>{{ ucfirst($order_data->payment_method) }}</td>
      
      </tr>        
 
    </table>


    <h3>Product Details</h3>
    <table>
      <thead>
        <tr>
        <th>Sl No</th>
        <th>Product Name</th>
        <th>Sku</th>
        <th>Variant/Details</th>
        <th>price</th>
        <th>Special Price</th>
        <th>Quantity</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
        @php $c=0;@endphp
        @foreach($order_data['orderItems'] as $row)
        @php $c++; @endphp
        <tr>
           <td>{{ $c}}</td>
           <td>{{ $row->product_name }}</td>
           <td>{{ $row->sku_title }}</td>
           <td>{{ $row->combination }}</td>
           <td>{{ $row->price }}</td>
           <td>{{ $row->special_price }}</td>
           <td>{{ $row->qty }}</td>
           <td>{{ $row->total }}</td>
       
        </tr>
        @endforeach()
        <tr></tr>
        <tr></tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <th><b>Total Amount</b></th>
          <td></td>
          <td></td>
          <td><b>{{$order_data->total_amount}}</b></td>
        </tr>
    </tbody>
</table>