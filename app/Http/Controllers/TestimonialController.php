<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Testimonial;
use DataTables;
use Illuminate\Validation\Rule;
class TestimonialController extends Controller
{
    public function index()
    {
      return view('admin.testimonial.index');
    }
    
    public function create()
    {
      return view('admin.testimonial.create');
    }
    public function store(Request $request)
    {
      $request->validate([
			'name'=>'required',
			'description'=>'required',
      'image'=>'required'
		]);

		$model= new Testimonial();
		$model->name=$request->input('name');
		$model->description=$request->input('description');	
		$model->created_by=\Auth::user()->id;
		$model->updated_by=\Auth::user()->id;
		$model->created_at=date('Y-m-d H:i:s');
		$model->updated_at=date('Y-m-d H:i:s');

      $path=public_path().'/images/testimonial';

      if($files=$request->file('image'))
      {
          $name=$files->getClientOriginalName();
          $files->move($path,$name);
          $model->image=$name;
      }
		$model->save();
    return response()->json(['message'=>'success']);
	   
    }
     
    public function edit($id)
    {
      $data=Testimonial::find($id);
      return view('admin.testimonial.edit',[
        'data'=>$data
      ]);

    }
    public function update(Request $request)
    {
	    $request->validate([
			'name'=>'required',
			'description'=>'required',
		]);
		$data= Testimonial::find($request->id);
		$data->name=$request->input('name');
		$data->description=$request->input('description');
		$data->updated_by=\Auth::user()->id;
		$data->updated_at=date('Y-m-d H:i:s');
    $path=public_path().'/images/testimonial';

      if($files=$request->file('image'))
      {
          $name=$files->getClientOriginalName();
          $files->move($path,$name);
          $data->image=$name;
      }
		$data->save();
    return response()->json(['message'=>'success']);
       
    }
    public function testimonialView(Request $request)
    {
      $data = Testimonial::find($request->id);
      $view = view('admin.testimonial.view', [
          'data' => $data,
      ]);
      echo $view;
    }
    public function destroy($id)
    {
      $data=Testimonial::find($id)->delete();
      
      
    }
    
    public function filter_testimonial(Request $request)
    {
     
        if($request->ajax()){
          $data = Testimonial::select('testimonial.*');
         
          if($request->has('name') && !empty($request->name))
          {
            $data=$data->where('name','like','%'.$request->name.'%');
          }
         
                   
          $data=$data->get();  
          return Datatables::of($data)
          ->addColumn('checkbox', function ($data) {
            return '<div class="form-check">
               <input class="form-check-input" type="checkbox" name="chk_child" value="' . $data->id . '">
            </div>';
        })
                ->addIndexColumn()
                ->addColumn('image', function($data) { $test='';
                  $test.='<img src="';
                  if($data->image !='')
                  { 
                    $test.=asset('public/images/testimonial').'/'.$data->image;
                    }else{
                      $test.=asset('public/images/img.png');
                    }
                    $test.='" style="width:50px;height:50px;">';
                    return $test;

                   })
                ->addColumn('name', function($data) { return $data->name; })
               
                
                ->rawColumns(['name','image','action','checkbox'])
                ->addColumn('action', function($data){
                  $view = '<li><a class="dropdown-item testimonialView"  data-id="' .$data->id. '"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>';
                  $edit = '<li><a href="' . url('testimonial') . '/' . $data->id . '/edit' . '" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
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
                ->setRowId(function ($data) {
                     return "row_".$data->id;
               })
                ->make(true);

            
        }
    }



}
?>