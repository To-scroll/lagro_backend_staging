<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use Session;
use \Auth;

class FrontendController extends Controller
{
    public function index()
	{
		return view('frontend.index',[
		
		]);
	}

}




