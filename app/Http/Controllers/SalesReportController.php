<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\Product;
use App\Exports\SalesReport;
use App\Exports\SalesReportExport;
use App\Exports\ProductwiseSalesReportExport; 
use Str;
use DataTables;
use Validator;
use Excel;
class SalesReportController extends Controller
{
	public function index()
	{
		return view('admin.sales-report.index');
	}
	public function filter_salesrpt(Request $request)
	{
		 $data = Orders::select('orders.*')->orderBy('orders.order_no', 'desc');
		
		if($request->has('order_no') && $request->order_no != '')
		{
			$data=$data->where('order_no','like','%'.$request->order_no.'%');
		}
		if($request->has('name') && $request->name != '')
		{
			$data=$data->where('customer_name','like','%'.$request->name.'%');
		}
		if($request->has('date_from') && $request->date_from != '')
		{
			$data=$data->whereDate('date','>=',$request->date_from);
		}
		if($request->has('date_to') && $request->date_to != '')
		{
			$data=$data->whereDate('date','<=',$request->date_to);
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
			->addColumn('status', function($data){
				$html='';
				if($data->status=='pending')
				{
				 $html.= '<span class="badge badge-soft-primary" >PENDING</span>';
				
				}if($data->status=='accepted')
				{
				
					$html.= '<span class="badge badge-soft-success" >ACCEPTED</span>';

				}if($data->status=='rejected')
				{
					
					$html.= '<span class="badge badge-soft-danger" >REJECTED</span>';

				}
				return $html;

			})
			->addColumn('delivery_status', function($data){
				$html='';
				if($data->delivery_status=='processing')
				{
				 $html.= '<span class="badge badge-soft-success" >PROCESSING</span>';
				}if($data->delivery_status=='on transit')
				{
					
					$html.= '<span class="badge badge-soft-warning" >On Transit</span>';

				}if($data->delivery_status=='out for delivery')
				{
					$html.= '<span class="badge badge-soft-primary"">Out For Delivery</span>';

				}
				if($data->delivery_status=='delivered')
				{
					$html.= '<span class="badge  badge-soft-secondary" >Delivered</span>';

				}

				return $html;
			})

			->addColumn('action', function($data){
				 
				//  $view=url('orders/'.$data->id);
				//  $invoice=url('download-invoice/'.$data->id);
				// $sts_btn='';
				// $sts_btn.='<a href="'.$view.'" class="btn bg-secondary btn-sm text-white rounded-circle"><i class="fa fa-eye"></i></a>&nbsp;
				// <button type="button" value="'.$data->id.'" class="btn bg-primary btn-sm text-white rounded-circle downloadSalesReport"><i class="fa fa-file-o"></i></button>';
			
				// return $sts_btn;
				$view='<li><a href="'.url('orders').'/'.$data->id.'?from=salesreport'.'"  class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>';
                $invoice = '<li>
                  <a class="dropdown-item downloadSalesReport" data-id="' . $data->id . '">
                  <i class="ri-download-2-line fs-17 lh-1 align-middle text-muted"></i> Invoice
                  </a>
                </li>';
                return '<div class="dropdown d-inline-block">
				  <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="ri-more-fill align-middle"></i>
				  </button>
				  <ul class="dropdown-menu dropdown-menu-end">
				  ' . $view . '
					' . $invoice . '
					
				  </ul>
				</div>';
			})
			->rawColumns(['action','delivery_status','status','checkbox'])
			->make(true);
	}
	//getting individual report
	public function downloadSalesreport(Request $request)
	{
		// dd($request);
		 $data=Orders::with('orderItems')->find($request->orderid);

		return Excel::download(new SalesReport($data), 'salesreport.xlsx');
     
	}
	//export sales report
	public function exportSalesreport(Request $request)
	{
		 $data=Orders::with('orderItems');
		 if($request->has('order_no') && $request->order_no != '')
		{
			$data=$data->where('order_no','like','%'.$request->order_no.'%');
		}
		if($request->has('customer_name') && $request->customer_name != '')
		{
			$data=$data->where('customer_name','like','%'.$request->customer_name.'%');
		}
		if($request->has('date_from') && $request->date_from != '')
		{
			$data=$data->whereDate('date','>=',$request->date_from);
		}
		if($request->has('date_to') && $request->date_to != '')
		{
			$data=$data->whereDate('date','<=',$request->date_to);
		}
		$data=$data->get();
		//echo"<pre>";print_r($data);exit;

		return Excel::download(new SalesReportExport($data), 'sales-report.xlsx');
     
	}
	public function exportProductwiseSalesReport(Request $request)
	{
		 $data=Orders::with('orderItems');
		 if($request->has('order_no') && $request->order_no != '')
		{
			$data=$data->where('order_no','like','%'.$request->order_no.'%');
		}
		if($request->has('customer_name') && $request->customer_name != '')
		{
			$data=$data->where('customer_name','like','%'.$request->customer_name.'%');
		}
		if($request->has('date_from') && $request->date_from != '')
		{
			$data=$data->whereDate('date','>=',$request->date_from);
		}
		if($request->has('date_to') && $request->date_to != '')
		{
			$data=$data->whereDate('date','<=',$request->date_to);
		}
		$data=$data->get();
		//echo"<pre>";print_r($data);exit;

		return Excel::download(new ProductwiseSalesReportExport($data), 'produtwise-sales-report.xlsx');
     
	}
	
}