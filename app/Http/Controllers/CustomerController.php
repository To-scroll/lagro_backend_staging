<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;

class CustomerController extends Controller
{
     
    public function index()
    {
	  
       return view('admin.customers.index');
    }

     
    public function create()
    {
        return view('admin.customers.index');
    }

     
    public function store(Request $request)
    {
         
    }

     
    public function show($id)
    {
        $data = Customer::select('customer.*','users.email')
		->leftJoin('users','users.id','customer.user_id')
		->where('customer.id',$id)
		->first(); 
        return view('admin.customers.view',compact('data'));
    }

     
    public function edit($id)
    {
		$data = Customer::select('customer.*','users.email')
		->leftJoin('users','users.id','customer.user_id')
		->where('customer.id',$id)
		->first(); 
        return view('admin.customers.edit',compact('data'));
    }

     
    public function update(Request $request)
    {
		// dd($request);
         $data=Customer::find($request->id);
    	 $request->validate([
    	 	'name'=>"required",
    	 	'email'=>"required|unique:users,email,".$data->user_id,
    	 	'phone'=>"required"
    	 ]);

		 $user=User::find($data->user_id);
		//  dd($user);
		 $data->name=$request->name;
		 $data->email=$request->email;
		 $data->phone=$request->phone;
		 $data->updated_at=date('Y-m-d H:i:s');
		 if($data->save())
		 {
			 $user->email=$request->email;
			 $user->name=$request->name;
			 $user->user_type='customer';
			 $user->save();
		 }
		 return response()->json(['message'=>'success']);

    }

     
    public function destroy($id)
    {
        $data=Customer::findOrFail($id);
		$user=User::findOrFail($data->user_id)->delete();
		if($data->delete())
		{
            // dd($data);
			echo 1;exit;
		}
		echo 0;exit;
    }
	public function filter_customer(Request $request)
	{
		$data = Customer::select('customer.*','users.email')
		->leftJoin('users','users.id','customer.user_id'); 
		if($request->has('name') && $request->name != '')
		{
			$data=$data->where('customer.name','like','%'.$request->name.'%');
		}
		if($request->has('phone') && $request->phone != '')
		{
			$data=$data->where('customer.phone','like','%'.$request->phone.'%');
		}
		return DataTables::of($data)
		->addColumn('checkbox', function ($data) {
			return '<div class="form-check">
			   <input class="form-check-input" type="checkbox" name="chk_child" value="' . $data->id . '">
			</div>';
		})
			->addIndexColumn()
			->addColumn('created_at', function($data){
				 return date('Y-m-d h:i A',strtotime($data->created_at));
			}) 
			->addColumn('action', function($data){
				$view = '<li><a class="dropdown-item customerView"  data-id="' .$data->id. '"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>';
				$edit = '<li><a href="' . url('customers') . '/' . $data->id . '/edit' . '" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
				//$invoice=url('download-invoice/'.$data->id);
				$delete = '<li>
			  <a class="dropdown-item deleteBtn" data-id="' . $data->id . '">
			  <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
			  </a>
			</li>';
				return '<div class="dropdown d-inline-block">
		<button class="btn btn-soft-secondary btn-sm dropdown " type="button" data-bs-toggle="dropdown" aria-expanded="false">
		<i class="ri-more-fill align-middle"></i>
		</button>
		<ul class="dropdown-menu dropdown-menu-end">
		' . $view . '
		' . $edit . '
		' . $delete . '

		</ul>
	  </div>';
			})
			->rawColumns(['action','created_at','checkbox'])
			->make(true);
	}
	public function customerView(Request $request)
    {
        // $data = Customer::find($request->id);
		$data = Customer::select('customer.*','users.email')
		->leftJoin('users','users.id','customer.user_id')
		->where('customer.id',$request->id)
		->first(); 
        $view = view('admin.customers.view', [
            'data' => $data,
        ]);
        echo $view;
    }
}
