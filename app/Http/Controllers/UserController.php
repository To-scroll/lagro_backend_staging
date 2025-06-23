<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Address;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userProfile()
    {
        if (\Auth::check()) {
            $customerid = auth()->user()->id;
             $userDetails=User::where('id',$customerid)->first();
             $userAddress=Address::where('customer_id',$customerid)->first();
            // echo "<pre>";
            // print_r($userAddress);
            // exit;

          return view('shopping.user-profile',[
            'userDetails'=>$userDetails,
            'userAddress'=>$userAddress
          ]);
        }else{
            return redirect('signup');
        }
    }
}
