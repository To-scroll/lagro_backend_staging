<table style="width:100%">
	<thead>
		<tr style="background: #f3f3f3;">
			<th style="padding: 8px;">Item</th>
			<th style="text-align:right;padding: 8px;">Price</th>
			<th style="text-align:center;padding: 8px;">Qty</th>
			<th style="text-align:right;padding: 8px;">Total</th>
		</tr>
	</thead>
	<tbody>
		@forelse ($orderItems as $item)
			<tr>
				<td style="padding: 8px;">
					<b>{{$item->product_name}} </b>
					<br> 
					@php
						$options=explode('-',$item->combination);
					@endphp
					@foreach ($options as $option)
						<span style="padding: 1px 3px;  background: #e9e9e9; border-radius: 3px;font-size:small;">{{$option}}</span>
					@endforeach
				</td>
				<td style="text-align:right;padding: 8px;">{{$item->special_price != '' ? number_format($item->special_price,2) : number_format($item->price,2)  }}</td>
				<td style="text-align:center;padding: 8px;">{{$item->qty}}</td>
				<td style="text-align:right;padding: 8px;">{{number_format($item->total,2)}}</td>
			</tr>	
		@empty
			<tr>
				<td colspan="4">Nothing found !</td>
			</tr>	
		@endforelse
		
	</tbody>
</table>