
<table>
    <thead>
    <tr>
        <th>Order No</th>
        <th>Customer Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Order Date</th>
        <th>Total Amount</th>
        <th>Reference No</th>
        <th>Status</th>
        <th>Delivery Status</th>
        <th>Payment Method</th>  
    </tr>
    </thead>
    <tbody>

  
    @foreach($order_data as $order)
        <tr>
           <td>{{ $order->order_no }}</td>
           <td>{{ $order->customer_name }}</td>
           <td>{{ $order->customer_email }}</td>
           <td>{{ $order->customer_phone }}</td>
           <td>{{ $order->address }} {{ $order->landmark }} {{ $order->pincode }}</td>
           <td>{{ date('d-m-Y',strtotime($order->date)) }}</td>
           <td>{{ $order->total_amount }}</td>
           <td>{{ $order->reference_no }}</td>
           <td>{{ $order->status }}</td>
           <td>{{ $order->delivery_status }}</td>
           <td>{{ $order->payment_method }}</td>
           <td></td>
           <td>
              <table>
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

               @php $c=0; @endphp
               @foreach($order['orderItems'] as $row)
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
             </table>
          </td>
        </tr>
 
        
    @endforeach      
          
  
      </tbody>
    </table>