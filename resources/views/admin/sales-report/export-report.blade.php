
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
           <td>{{ $order->address }} {{ $order->landmark }}{{ $order->pincode }}</td>
           <td>{{ date('d-m-Y',strtotime($order->date)) }}</td>
           <td>{{ $order->total_amount }}</td>
           <td>{{ $order->reference_no }}</td>
           <td>{{ $order->status }}</td>
           <td>{{ $order->delivery_status }}</td>
           <td>{{ $order->payment_method }}</td>
       
        </tr>       
    @endforeach      
          
  
      </tbody>
    </table>