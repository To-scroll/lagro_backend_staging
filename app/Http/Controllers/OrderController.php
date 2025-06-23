<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use \App\Models\Address;
use \App\Models\Invoice;
use \App\Models\OrderItems;
use \App\Models\Orders;
use \App\Models\Settings;
use \App\Models\User;
use \App\Models\Groups;
use \App\Models\Sku;
use \App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index');

    }
   
    public function orderStatusChange(Request $request)
    {
        $data=Orders::find($request->id);
        
        if($request->status=='rejected')
        {
            $data->status=$request->status;
            $data->cancel_status='yes';
		    $data->save();
        }
		$data->status=$request->status;
		$data->save();
		echo 1;
    }
    public function deliveryStatusChange(Request $request)
    {
        $data=Orders::find($request->id);
		$data->delivery_status=$request->status;
		$data->save();
		echo 1;
    }
    
    
    public function show( string $id)
    {
        $data = Orders::with('orderItems', 'customers', 'customer_address', 'orderItems.productData', 'orderItems.productSku')->find($id);
        $offer_productsku=$data->offer_productsku;
        
        $offer_product=Sku::where('id',$offer_productsku)->with(['sku_images'])->first();
    // dd($offer_product);
        $product = ' ';
        if($offer_product)
        {
            $product=Product::where('id',$offer_product->product_id)->first();
        }
        // dd($product);
            
        // dd($offer_product);
        // dd($data);
        // echo "<pre>";
        // print_r($data->customer_address);
        // exit;
        return view('admin.orders.view', [
            'data' => $data,
            'offer_product' => $offer_product,
            'product' => $product,
        ]);
    }
    public function edit($id)
    {
        $data = Orders::with('orderItems', 'customers', 'customer_address', 'orderItems.productData', 'orderItems.productSku')->find($id);
        $groups=Groups::get();
        // dd($data);
        // echo "<pre>";
        // print_r($groups->toArray());
        // exit;
        return view('admin.orders.edit', [
            'data' => $data,
            'groups'=>$groups
        ]);
    }
    public function orderUpdate(Request $request)
    {
   

        $request->validate([
            'address' => 'required',
            'pincode' => 'required',
            'status' => 'required',
            'delivery_status' => 'required',
        ]);

        $address = Address::find($request->address_id);
        $address->address = $request->address;
        $address->landmark = $request->landmark;
        $address->pincode = $request->pincode;
        $address->save();
        if ($request->has('orderitems_rowId')) {
            for ($i = 0; $i < count($request->orderitems_rowId); $i++) {
                $orderitems = OrderItems::find($request->orderitems_rowId[$i]);
                $orderitems->price = $request->product_price[$i];
                $orderitems->special_price = $request->product_sp_price[$i];
                $orderitems->qty = $request->product_quantity[$i];

                $orderitems->total = $request->total[$i];
                $orderitems->save();

            }

            $order_sum = OrderItems::where('order_id', $request->order_rowId)->sum('total');
            $order = Orders::find($request->order_rowId);
            $order->total_amount = $order_sum;
            $order->status = $request->status;
            $order->delivery_status = $request->delivery_status;
            $order->address = $address->address;
            $order->landmark = $address->landmark;
            $order->pincode = $address->pincode;
           
            $order->updated_by = \Auth::user()->id;
            $order->updated_at = date('Y-m-d H:i:s');
            $order->save();
            if ($order->save()) {
                $invoice = Invoice::where('order_id', $order->id)->first();
                // dd($order->address);
                if(!isset($invoice)){
                    $invoice=new Invoice();
                }
                $invoice->order_id = $order->id;
                $invoice->address = $order->address;
                $invoice->landmark = $order->landmark;
                $invoice->pincode = $order->pincode;
                $invoice->updated_by = \Auth::user()->id;
                $invoice->created_by = \Auth::user()->id;
                $invoice->updated_at = date('Y-m-d H:i:s');
                $invoice->save();
            }

        }
        echo "updated";
    }




 public function filter_order(Request $request)
    {
        $data = Orders::select('orders.*')->orderBy('orders.order_no', 'desc');
        
        if ($request->has('status') && $request->status != 'all') {
            $data = $data->where('status', $request->status);
        }
        if ($request->has('delivery_status') && $request->delivery_status != 'all') {
            $data = $data->where('delivery_status', $request->delivery_status);
        }
        if ($request->has('order_no') && $request->order_no != '') {
            $data = $data->where('order_no', 'like', '%' . $request->order_no . '%');
        }
        if ($request->has('name') && $request->name != '') {
            $data = $data->where('customer_name', 'like', '%' . $request->name . '%');
        }
        
         if ($request->has('cancel_status') && $request->cancel_status != 'all') {
            $data = $data->where('cancel_status', $request->cancel_status);
        }

        return DataTables::of($data)
        ->addColumn('checkbox', function ($data) {
            return '<div class="form-check">
               <input class="form-check-input" type="checkbox" name="chk_child" value="' . $data->id . '">
            </div>';
        })
            ->addIndexColumn()
            
            ->addColumn('address', function ($data) {
                return $data->address;
            })
            ->addColumn('status', function ($data) {
                return '<span  >' . ucfirst($data->status) . '</span>';
            })
            ->addColumn('delivery_status', function ($data) {
                return '<span  >' . ucfirst($data->delivery_status) . '</span>';
            })
            
            ->addColumn('action', function ($data) {
                $view='<li><a href="'.url('orders').'/'.$data->id.'?from=orders'.'" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>';
                $edit = '<li><a href="' . url('orders') . '/' . $data->id . '/edit' . '" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
                //$invoice=url('download-invoice/'.$data->id);
                

                $sts_btn = '';
                
               
                if ($data->status == 'pending') {
                    $sts_btn .= '<a href="#" class="btn btn-sm btn-primary statusBtn" data-status="accepted" data-id="' . $data->id . '">Accept</a>&nbsp;';
                    $sts_btn .= '<a href="#" class="btn btn-sm btn-danger statusBtn" data-status="rejected" data-id="' . $data->id . '">Reject</a>';
                }
                if ($data->status == 'accepted' && $data->delivery_status == 'processing') {
                    $sts_btn .= '<a href="#" class="btn btn-sm btn-warning deliveryBtn " data-status="on transit" data-id="' . $data->id . '">On transit</a>';

                }
                if ($data->status == 'accepted' && $data->delivery_status == 'on transit') {
                    $sts_btn .= '<a href="#" class="btn btn-sm btn-primary deliveryBtn " data-status="out for delivery" data-id="' . $data->id . '">Out for delivery</a>';

                }
                if ($data->status == 'accepted' && $data->delivery_status == 'out for delivery') {
                    $sts_btn .= '<a href="#" class="btn btn-sm btn-success deliveryBtn" data-status="delivered" data-id="' . $data->id . '">Delivered</a>';

                }
                if ($data->status == 'rejected' && $data->delivery_status == 'cancelled') {
                    $sts_btn .= '<a href="#" class="btn btn-sm btn-danger" data-status="cancelled" data-id="' . $data->id . '">Cancelled</a>';

                }
                // $sts_btn.='&nbsp;<a href="'.$invoice.'" class="btn btn-sm text-white rounded-circle" style="background-color:#1218d9;"><i class="fa fa-file"></i></a>';
                return ' <div class="dropdown d-inline-block" style="margin-right:10px;">
				  <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="ri-more-fill align-middle"></i>
				  </button>
				  <ul class="dropdown-menu dropdown-menu-end">
				  ' . $view . '
					' . $edit . '
					
				  </ul>
				</div>'.$sts_btn;
            })
            ->rawColumns(['action', 'delivery_status', 'status','checkbox'])
            ->make(true);
    }
    // public function downloadInvoice($id)
    // {
    //     $data=Orders::with('orderItems','customers','customer_address','orderItems.productData','orderItems.productSku')->find($id);
    //     //return view('admin.orders.invoice', compact('data'));
    //     $pdf = PDF::loadView('admin.orders.invoice', compact('data'));
    //     return $pdf->download('invoice'.$data->order_no.'.pdf');
    // }

    /*public function createInvoice()
{
$order=Orders::find(3);
$invoice=new Invoice();
$invoice->order_id=$order->id;
$invoice->order_no=$order->order_no;
$invoice->customer_id=$order->customer_id;
$invoice->customer_name=$order->customer_name;
$invoice->customer_phone=$order->customer_phone;
$invoice->customer_email=$order->customer_email;
$invoice->date=date('Y-m-d H:i:s');
$invoice->payment_method=$order->payment_method;
$invoice->total_amount=$order->total_amount;
$invoice->reference_no=$order->reference_no;
$invoice->created_by=\Auth::user()->id;
$invoice->updated_by=\Auth::user()->id;
$invoice->created_at=date('Y-m-d H:i:s');
$invoice->updated_at=date('Y-m-d H:i:s');
$invoice->save();
$orderItems=OrderItems::where('order_id',$order->id)->get();
foreach($orderItems as $row)
{
$invoiceItem=new InvoiceItems();
$invoiceItem->order_id=$order->id;
$invoiceItem->order_no=$order->order_no;
$invoiceItem->invoice_no=$invoice->invoice_no;
$invoiceItem->invoice_id=$invoice->id;
$invoiceItem->order_item_id=$row->id;
$invoiceItem->product_id=$row->product_id;
$invoiceItem->product_name=$row->product_name;
$invoiceItem->sku_id=$row->sku_id;
$invoiceItem->sku_title=$row->sku_title;
$invoiceItem->combination=$row->combination;
$invoiceItem->qty=$row->qty;
$invoiceItem->price=$row->price;
$invoiceItem->special_price=$row->special_price;
$invoiceItem->total=$row->total;
$invoiceItem->save();

}
}*/

}
