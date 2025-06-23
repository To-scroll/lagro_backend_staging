<?php

namespace App\Http\Controllers;

use App\Models\Coupons;
use DataTables;


use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required',
          
        ]);

        $coupon = new Coupons();
        $coupon->coupon_code = $request->input('coupon_code');
        $coupon->valid_upto = $request->input('valid_upto');
        $coupon->offer_percent = $request->input('offer_percent');
        $coupon->is_applied = $request->input('is_applied');
        $coupon->is_expired = $request->input('is_expired');
        $coupon->created_at=date('Y-m-d H:i:s');
        $coupon->created_by=\Auth::user()->id;
        $coupon->save();

        return response()->json(['message' => 'success']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon=Coupons::find($id);
        return view('admin.coupon.edit',[
            'coupon'=>$coupon
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required',
          
        ]);

        $coupon = Coupons::find($request->id);
        $coupon->coupon_code = $request->input('coupon_code');
        $coupon->valid_upto = $request->input('valid_upto');
        $coupon->offer_percent = $request->input('offer_percent');
        $coupon->is_applied = $request->input('is_applied');
        $coupon->is_expired = $request->input('is_expired');
        $coupon->updated_by=\Auth::user()->id;
        $coupon->updated_at=date('Y-m-d H:i:s');

        $coupon->save();

        return response()->json(['message' => 'success']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        
        $data=Coupons::find($id)->delete();
      
        echo 1;
    }
    public function filter_coupon(Request $request)
    {
     
        if($request->ajax()){
          $data = Coupons::select('*');
         
          if($request->has('coupon_code') && !empty($request->coupon_code))
          {
            $data=$data->where('coupon_code','like','%'.$request->coupon_code.'%');
          }
         
                   
          $data=$data->get();  
          return Datatables::of($data)
          ->addColumn('checkbox', function ($data) {
            return '<div class="form-check">
               <input class="form-check-input" type="checkbox" name="chk_child" value="' . $data->id . '">
            </div>';
        })
                ->addIndexColumn()
                ->addColumn('coupon_code', function($data) { return $data->coupon_code; })
                ->addColumn('offer_percent', function($data) { return $data->offer_percent; })
                ->addColumn('valid_upto', function($data) { return $data->valid_upto; })
                
                ->addColumn('is_applied', function($data) { 
			
                    $test= '<div class="form-check form-switch">
                           <input class="form-check-input is_applied" type="checkbox" value="'.$data->id.'"';
                           if($data->is_applied =='yes')
                            { 
                               $test.='checked=""';
                            }
                            $test.='> </div>';
                           
                           return $test;
               })
               ->addColumn('is_expired', function($data) { 
			
                $test= '<div class="form-check form-switch">
                       <input class="form-check-input " type="checkbox" id="is_expired" value="'.$data->id.'"';
                       if($data->is_expired =='yes')
                        { 
                           $test.='checked=""';
                        }
                        $test.='> </div>';
                       
                       return $test;
           })
                ->rawColumns(['coupon_code','offer_percent','is_applied','is_expired','action','checkbox'])
                ->addColumn('action',function($data){
                    // $view = '<li><a class="dropdown-item "  id="openCoupon" data-id="' .$data->id. '"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>';
					$edit = '<li><a href="' . url('coupons') . '/' . $data->id . '/edit' . '" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
					$delete = '<li>
				  <a class="dropdown-item deleteBtn" data-id="' . $data->id . '">
					<i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
				  </a>
				</li>';
					// $addFields='<li><a href="'.url('add-clinic-fields/'.$data->id).'" class="dropdown-item"><i class=" ri-folder-add-fill  align-bottom me-2 text-muted"></i> Add Form Fields</a></li>';
					return '<div class="dropdown d-inline-block">
				  <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="ri-more-fill align-middle"></i>
				  </button>
				  <ul class="dropdown-menu dropdown-menu-end">
				     
					' . $edit . '
					' . $delete . '
				  </ul>
				</div>';
                })
                ->setRowId(function ($data) {
                     return "row_".$data->id;
               })
                ->make(true);

            
        }
    }
    public function changeis_applied(Request $request)
	{
		//echo $request->thisId;

		$data=Coupons::find($request->thisId);
		if($data->is_applied=='yes')
		{
			$data->is_applied='no';
			$data->save();
			
		}else{
			$data->is_applied='yes';
			$data->save();
		
		}
		echo " Changed";exit;
	}
    public function changepublish_status(Request $request)
	{
		//echo $request->thisId;

		$data=Coupons::find($request->thisId);
		if($data->is_expired=='yes')
		{
			$data->is_expired='no';
			$data->save();
			
		}else{
			$data->is_expired='yes';
			$data->save();
		
		}
		echo " Changed";exit;
	}
    // public function fetchCoupon(Request $request)
    // {
    //     $coupon=Coupons::find($request->couponId);
    //     // dd($coupon);
    //     return response()->json($coupon);
    // }
}
