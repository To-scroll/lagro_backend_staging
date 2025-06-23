<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Customer;
use App\Models\Address;
use Validator;
class SignupController extends Controller
{

	public function signUpFormStore(Request $request)
	{
		// dd($request);
		$request->validate([
			'fullname'=>'required',
			'email'=>'required|email|unique:users',
			'password'=>'required|min:8',
			'phone'=>'required|max:10',
		]);


		$userdata= new user();
		$userdata->name=$request->input('fullname');
		$userdata->email=$request->input('email');
		$userdata->phone=$request->input('phone');
		$pass=$request->input('password');
		$userdata->password=bcrypt($pass);
		$userdata->user_type='customer';
        
        
        if($userdata->save())
        {
        	$model= new Customer();
			$model->name=$request->input('fullname');
			$model->user_id=$userdata->id;
			$model->email=$request->input('email');
			$model->phone=$request->input('phone');
			$model->created_by=$userdata->id;
			$model->updated_by=$userdata->id;
			$model->created_at=date('Y-m-d H:i:s');
			$model->updated_at=date('Y-m-d H:i:s');
			$model->save();

        }
		session()->flash('registered_email', $request->input('email'));
        \Session::flash('reg_message','Registered Successfully  ');
      	 echo "Registered Successfully  ";
	}
	public function updateUserDetails(Request $request)
	{
		$request->validate([
			'name'=>'required',
			'gender'=>'required',
			'dob'=>'required',
			'email'=>'required|email|unique:users,email,'.auth()->user()->id,
			'phone'=>'required|max:10',
		]);
		if($request->has('password') && $request->password != '')
		{
			$request->validate([ 
			'password'=>'min:8',
			]);
		}
		$userdata=user::find(\Auth::user()->id);
		$userdata->name=$request->input('name');
		$userdata->email=$request->input('email');
		$userdata->phone=$request->input('phone');
		if($request->has('password') && $request->password != '')
		{
			$pass=$request->input('password');
			$userdata->password=bcrypt($pass);
		}
        if($userdata->save())
        {
        	$model= Customer::where('user_id',$userdata->id)->first();
			$model->name=$request->input('name');
			$model->email=$request->input('email');
			$model->phone=$request->input('phone');
			$model->gender=$request->input('gender');
			$model->dob=$request->input('dob');
			$model->updated_by=$userdata->id;
			$model->updated_at=date('Y-m-d H:i:s');
			$model->save();

        }
		echo 1;exit;
	}
	public function getAddressModal(Request $request)
	{
		if($request->has('type') && $request->type == 'edit')
		{
			$data=Address::find($request->id);
			return view('front.ajax.dashboard.address',[
				'data'=>$data,
				'type'=>'edit'
			]);
		}
		return view('front.ajax.dashboard.address',['type'=>'new']);
	}
	public function storeAddress(Request $request)
	{
		$request->validate([
			'name'=>'required',
			'address'=>'required', 
			'landmark'=>'required', 
			'pincode'=>'required', 
			'type'=>'required'
		]);
		if($request->address_type == 'new')
		{
			$data=new Address();
		}
		if($request->address_type == 'edit')
		{
			$data=Address::find($request->id);
		}
		$data->name=$request->name;
		$data->customer_id=auth()->user()->id;
		$data->address=$request->address;
		$data->landmark=$request->landmark;
		$data->pincode=$request->pincode;
		$data->type=$request->type;
		$data->save();
		$count=Address::where('customer_id',auth()->user()->id)->count();
		if($count == 1)
		{
			Address::where('customer_id',auth()->user()->id)->update(['is_defualt'=>'yes']);
		}
		echo 1;exit;
	}
	public function loadAddress(Request $request)
	{
		$data=Address::where('customer_id',auth()->user()->id)->get();
		if($request->has('type') && $request->type == 'dashboard')
		{
			return view('front.ajax.dashboard.address-container',[
				'address'=>$data,
				'type'=>'dashboard'
			]);
		}else{
			return view('front.ajax.dashboard.address-container',[
				'address'=>$data,
				'type'=>'checkout'
			]);
		}
	}
	public function removeAddressModal(Request $request)
	{
		$data=Address::findOrFail($request->id);
		if($data->delete())
		{
			echo 1;exit;
		}
		echo 0;exit;
	}
	public function changeAddressStatus(Request $request)
	{
		$data=Address::find($request->id);
		$data->is_defualt='yes';
		$data->save();
		Address::where('customer_id',\Auth::user()->id)->where('id','!=',$request->id)->update(['is_defualt'=>'no']);
		echo 1;exit;
	}
}
