<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style type="text/css">
      font-face {
  font-family: SourceSansPro;
  src: url({{asset('assets/print-page/SourceSansPro-Regular.ttf') }});
}


.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #0087C3;
  text-decoration: none;
}

body {
  position: relative;
  width: 100%;  
  /*height: 29.7cm; */
  margin: 0 auto; 
  color: #555555;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 14px; 
  font-family: SourceSansPro;

}

header {
  padding: 10px 0;
  margin-bottom: 20px;
  border-bottom: 1px solid #AAAAAA;
}

#logo {
  float: left;
  margin-top: 8px;
}

#logo img {
  height: 70px;
}

#company {
  float: right;
  text-align: right;
}


#details {
  margin-bottom: 50px;
}

#client {
  padding-left: 6px;
  border-left: 6px solid #0087C3;
  float: left;
}

#client .to {
  color: #777777;
}

h2.name {
  font-size: 1.4em;
  font-weight: normal;
  margin: 0;
}

#invoice {
  float: right;
  text-align: right;
}

#invoice h1 {
  color: #0087C3;
  font-size: 2.4em;
  line-height: 1em;
  font-weight: normal;
  margin: 0  0 10px 0;
}

#invoice .date {
  font-size: 1.1em;
  color: #777777;
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table th,
table td {
  padding: 10px;
 
  text-align: center;
  border-bottom: 1px solid #FFFFFF;
}

table th {
  white-space: nowrap;        
  font-weight: normal;
  font-weight: 500;
   background: #EEEEEE;
}

table td {
  text-align: center;
}

table td h3{
  color: #57B223;
  font-size: 1.2em;
  font-weight: normal;
  margin: 0 0 0.2em 0;
}

table .no {
  color: #FFFFFF;
  font-size: 1.6em;
  background: #57B223;
}

table .desc {
  text-align: left;
  width:200px;
}

table .unit {
  background: #DDDDDD;
}

table .qty {
}

table .total {
  background: #57B223;
  color: #FFFFFF;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table tbody tr:last-child td {
  border: none;
}

table tfoot td {
  padding: 10px 20px;
  background: #FFFFFF;
  border-bottom: none;
  font-size: 1.2em;
  white-space: nowrap; 
  border-top: 1px solid #AAAAAA; 
}

table tfoot tr:first-child td {
  border-top: 1px solid  #ddd; 
   /*color: #57B223;*/
   color: #0087C3;
   font-size: 1.4em;
}

table tfoot tr:last-child td {
  /*color: #57B223;*/
  color: #0087C3;
  font-size: 1.4em;
  border-top: 1px solid  #ddd; 

}

table tfoot tr td {
  border: none;
}

#thanks{
  font-size: 2em;
  margin-bottom: 50px;
}

#notices{
  padding-left: 6px;
  border-left: 6px solid #0087C3;  
}

#notices .notice {
  font-size: 1.2em;
}

footer {
  color: #777777;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #AAAAAA;
  padding: 8px 0;
  text-align: center;
}

    </style>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
     		@if(\App\Models\Settings::getSettingsvalue('site_name') != '')
			 <img src="{{ asset('public/images/settings/logo')}}/{{\App\Models\Settings::getSettingsvalue('logo') }}" alt="logo" width="200px">
			@endif
      </div>
      <div id="company">
        <h2 class="name">{{\App\Models\Settings::getSettingsvalue('site_name') }}</h2>
        <div></div>
        <div>{{\App\Models\Settings::getSettingsvalue('support_no') }}</div>
        <div><a href="#">{{\App\Models\Settings::getSettingsvalue('support_email') }}</a></div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">Customer Info</div>
           <h2 class="name">{{ ucfirst($data->customer_name)}}</h2>
         
          <div class="address">{{ ucfirst(ucfirst($data['customerAddress']->address)) }}<br>{{$data['customerAddress']->landmark.'-'. $data['customerAddress']->pincode }}</div>
       
          <div class="email">{{ $data->customer_phone }}</div>
          <div class="email"><a href="">{{$data->customer_email}}</a></div>
        </div>
        <div id="invoice">
          <h3>Invoice No : {{$data->invoice_no}}</h3>
          <h3>Order No : {{$data->order_no}}</h3>
        
          <div class="date">Date of Order:{{date('d M Y h:i A',strtotime($data->date))}}</div>
        
         
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="qty">#</th>           
            <th class="qty">Product Name</th>
            <th class="qty" width=150px;>Variant/Details</th>
            <th class="qty">Sku</th>
            <th class="qty">Price</th>
            <th class="qty">Sale Price</th>
            <th class="qty">Quantity</th>
            <th class="qty">Total</th>
          </tr>
        </thead>
        <tbody>
           @php $c=0; @endphp
          @foreach($data['invoiceItems'] as $row)
          @php $c++; @endphp
          <tr>
            <td class="qty">{{$c}}</td>
            <td class="qty">{{$row->product_name}}</td>
            <td class="qty">{{$row->combination}}</td>
            <td class="qty">{{$row->sku_title}}</td>
            
            <td class="qty"><span style="font-family: DejaVu Sans, sans-serif;">&#8377;</span> {{$row->price}}</td>
            <td class="qty"><span style="font-family: DejaVu Sans, sans-serif;">&#8377;</span> {{$row->special_price}}</td>
            <td class="qty">{{$row->qty}}</td>
            <td class="qty"><span style="font-family: DejaVu Sans, sans-serif;">&#8377;</span> {{$row->total}}</td>
          </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
            <td colspan="2"></td>
            <td colspan="2"></td>
            <td></td>
          </tr>
          <tr>
        
            <td colspan="5"></td>
            <td>Grand Total</td>
            <td  colspan="2"><span style="font-family: DejaVu Sans, sans-serif;">&#8377;</span>{{$data->total_amount}}</td>
          </tr>
        
      
        </tfoot>
       
      </table>

     
     
    </main>
      <footer>
    
    </footer>

  </body>
</html>