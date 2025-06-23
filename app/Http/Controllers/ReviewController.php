<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Review;
use DataTables;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    public function index()
    {

        return view('admin.review.index');
    }


   
    public function reviewShow(Request $request)
    {
      $data=Review::with('productName')->find($request->id);
      $view=view('admin.review.view',[
        'data'=>$data
      ]);

     echo $view;
    }
    public function destroy(Request $request)
    {
      $data=Review::find($request->id)->delete();
      echo 1;
    }

    public function changeApproveStatus(Request $request)
    {
      $data=Review::find($request->id);
      
      if($data->is_approved=='yes')
      {
        $data->is_approved='no';
        $data->updated_by=\Auth::user()->id;
        $data->updated_at=date('Y-m-d H:i:s');
        $data->save();
        
      }else{
        $data->is_approved='yes';
         $data->updated_by=\Auth::user()->id;
          $data->updated_at=date('Y-m-d H:i:s');
        $data->save();
      
      }
      echo "Status Changed";
  
    }
    
     public function filter(Request $request)
    {
     
        if($request->ajax()){
          $data = Review::with('productName');
      //  dd($data->products);
          if($request->has('customer_name') && !empty($request->customer_name))
          {
            $data=$data->where('name','like','%'.$request->customer_name.'%');
          }
          if($request->has('product_name') && !empty($request->product_name))
          {
            $data=$data->whereHas('productName',function($q)use($request){
                    return $q->where('product_name','like','%'.$request->product_name.'%');
                });
          }
         if($request->has('rating') && ($request->rating !='all'))
          {
            $data=$data->where('rating',$request->rating);
          }
          if($request->has('is_approved') && ($request->is_approved !='all'))
          {
            $data=$data->where('is_approved',$request->is_approved);
          }
         
          $data=$data->orderBy('created_at', 'DESC')->get();  
          return Datatables::of($data)
          ->addColumn('checkbox', function ($data) {
            return '<div class="form-check">
               <input class="form-check-input" type="checkbox" name="chk_child" value="' . $data->id . '">
            </div>';
        })
                ->addIndexColumn()
                ->addColumn('product_name', function ($data) 
                {
                    return $data->productName->product_name ?? ''; 
                })
                ->addColumn('product_image', function ($data) 
                {
                    if (!empty($data->productName->icon)) {
                        $imgPath = asset('public/images/product/' . $data->productName->icon); // Adjust path if needed
                        return '<img src="' . $imgPath . '" width="50" height="50" class="rounded">';
                    }
                    return '';
                })
                
                
                ->addColumn('rating', function($data) { return $data->rating; })
                //  ->addColumn('is_approved', function($data) { 
                //   if($data->is_approved =='yes')
                //     {
                //       return '<span class="btn bg-primary btn-sm text-white">YES</span>';
                //     }else{
                //       return '<span class="btn bg-secondary btn-sm text-white">No</span>';
                //     }
                // })
                
               
                
                ->addColumn('is_approved', function($data) { 
      
                     $test= '<div class="form-check form-switch">
                            <input class="form-check-input publish_status" type="checkbox" value="'.$data->id.'"';
                            if($data->is_approved =='yes')
                             { 
                                $test.='checked=""';
                             }
                             $test.='> </div>';
              
                            return $test;
                })
                
                ->addColumn('name', function($data) { 
                 
                    return $data->name;

                 })
                 ->rawColumns(['product_name','product_image','is_approved','action','checkbox'])
                ->addColumn('action',function($data){

                 
                  $view = '<li><a class="dropdown-item reviewView"  data-id="' .$data->id. '"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>';
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
  
                  ' . $delete . '
                  ' . $view . '
                </ul>
              </div>';
                         
                })
                ->setRowId(function ($data) {
                     return "row_".$data->id;
               })
                ->make(true);

            
        }
    }

}
