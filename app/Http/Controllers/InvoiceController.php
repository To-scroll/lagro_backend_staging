<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Orders;
use \App\Models\OrderItems;
use \App\Models\Customer;
use \App\Models\Address;
use \App\Models\Product;
use \App\Models\Invoice;
use \App\Models\InvoiceItems;
use Session;
use DataTables;
use PDF;
class InvoiceController extends Controller
{
	public function index()
	{
		return view('admin.invoice.index');
	}
	
	
	
	
	public function filter_invoice(Request $request)
	{
		$data = Invoice::select('invoice.*');
		if($request->has('invoice_no') && $request->invoice_no != '')
		{
			$data=$data->where('invoice_no','like','%'.$request->invoice_no.'%');
		}
		if($request->has('order_no') && $request->order_no != '')
		{
			$data=$data->where('order_no','like','%'.$request->order_no.'%');
		}
		if($request->has('name') && $request->name != '')
		{
			$data=$data->where('customer_name','like','%'.$request->name.'%');
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
			->addColumn('invoice_no', function($data){
				 return $data->invoice_no;
			})
			->addColumn('order_no', function($data){
				 return $data->order_no;
			})
			->addColumn('name', function($data){
				 return $data->customer_name;
			})
			->addColumn('address', function($data){
				 return $data->address;
			})
			->addColumn('total_amount', function($data){
				 return $data->total_amount;
			})
			
			->addColumn('action', function($data){
			
			// 	 $invoice=url('download-invoice/'.$data->id);
				
				
			// return '<a href="'.$invoice.'" class="btn btn-sm " "><i class="fa fa-file-pdf-o"></i></a>';
		
			// })
			return '<a href="' . url('download-invoice/' . $data->id) . '" class="btn btn-sm btn-soft-info messageView">
			Download
		</a>';
            })
			->rawColumns(['action', 'invoice_no', 'name', 'address','checkbox','total_amount'])
			->make(true);
	}
	public function downloadInvoice($id)
	{
		$data=Invoice::with('InvoiceItems','customers','customerAddress')->find($id);
		// echo "<pre>";print_r($data->customerAddress);exit;
		//return view('admin.invoice.invoice', compact('data'));
		$pdf = PDF::loadView('admin.invoice.invoice', compact('data'));
		return $pdf->download('invoice'.$data->invoice_no.'.pdf');
	}
	
}
