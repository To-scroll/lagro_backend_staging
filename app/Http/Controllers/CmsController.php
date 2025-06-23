<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cms;
// use App\Models\Footer;
// use App\Models\Quickview;
 use App\Models\Meta;
// use App\Models\Services;
use DataTables;
use Illuminate\Validation\Rule;

class CmsController extends Controller
{
    public function index()
    {
        return view('admin.cms.index');
    }


    
    public function create()
    {
        return view('admin.cms.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'page_name'=>'required',
            //'meta_data'=>'required',
            //'meta_title'=>'required',
            'route'=>'required|unique:cms',
            'content'=>'required',
            'is_published'=>'required'
        ]);
        $data= new Cms();
        $data->page_name=$request->page_name;
        
        $data->meta_title=$request->meta_title;
        $data->meta_keyword=$request->meta_keyword;
        $data->meta_description=$request->meta_description;
        
        $data->content=$request->content;
        $data->is_published=$request->is_published;
        $data->route=$request->route;
        $data->created_by=\Auth::user()->id;
        $data->created_at=date('Y-m-d H:i:s');
        $data->updated_by=\Auth::user()->id;
        $data->updated_at=date('Y-m-d H:i:s');
        $data->save();
		$meta=Meta::where('model','cms')->where('model_id',$data->id)->first();
		if(empty($meta))
		{
			$meta=new Meta();
		}
		$meta->model='cms';
		$meta->model_id=$data->id;
		$meta->title=$request->meta_title;
		$meta->keywords=$request->meta_keyword;
		$meta->description=$request->meta_description;
		$meta->save();

        return response()->json(['message' => 'success']);
    }

    public function edit($id)
    {
        $data= Cms::find($id);
		$meta=Meta::where('model','cms')->where('model_id',$id)->first();
        return view('admin.cms.edit',[
            'data'=>$data,
			'meta'=>$meta
        ]);
    }

     public function update(Request $request)
    {
        $request->validate([
            'page_name'=>'required',
            //'meta_data'=>'required',
            //'meta_title'=>'required',
            'route'=>['required',Rule::unique('cms')->ignore($request->row_id)],
            'content'=>'required' 
             
        ]);
        $data=Cms::find($request->row_id);
        $data->page_name=$request->page_name;
        $data->meta_title=$request->meta_title;
        $data->meta_keyword=$request->meta_keyword;
        $data->meta_description=$request->meta_description;
        $data->content=$request->content;
        $data->is_published=$request->is_published;
        
    		if($request->disabled == 'disabled'){
            	$data->is_published='yes';
    		}
    		$oldRoute=$data->route;
            $data->route=$request->route;
            $data->updated_by=\Auth::user()->id;
            $data->updated_at=date('Y-m-d H:i:s');
        
        //meta
		$meta=Meta::where('model','cms')->where('model_id',$data->id)->first();
    		if(empty($meta))
    		{
    		    	$meta=new Meta();
    		}
    		$meta->model='cms';
    		$meta->model_id=$data->id;
    		$meta->title=$request->meta_title;
    		$meta->keywords=$request->meta_keyword;
    		$meta->description=$request->meta_description;
    		$meta->save();
           
            $data->save();
            return response()->json(['message' => 'success']);

            /*
            if ($data->save && $data->route != $oldRoute) {
                return response()->json(['message' => 'success']);
            }

            */
        
    }

    public function cmsView(REquest $request)
    {
        $data=Cms::find($request->id);
		$meta=Meta::where('model','cms')->where('model_id',$request->id)->first();
        $view=view('admin.cms.view',[
            'data'=>$data,
			'meta'=>$meta
        ]);
        echo $view;
    }
    
    public function destroy($id)
    {
        $data=Cms::find($id)->delete();
		$meta=Meta::where('model','cms')->where('model_id',$id)->delete();
        echo 1;
    }
    
    
    public function filter_cms(Request $request)
    {
     
        if($request->ajax()){
          $data = Cms::select('cms.*');
         
          if($request->has('page_name') && !empty($request->page_name))
          {
            $data=$data->where('page_name','like','%'.$request->page_name.'%');
          }
         
         
          $data=$data->orderBy('id', 'DESC')->get();  
          return Datatables::of($data)
                     ->addColumn('checkbox', function ($data) {
                       return '<div class="form-check">
                       <input class="form-check-input" type="checkbox" name="chk_child" value="' . $data->id . '">
                    </div>';
                  })
                ->addIndexColumn()
                ->addColumn('page_name', function($data) { return $data->page_name; })
                ->addColumn('route', function($data) { 
					$dataUrl=env('APP_URL').'/page/'.$data->route;
					return ' <i title="Copy to clipboard" class="bi bi-clipboard copyBtn" dataurl="'.$dataUrl.'"></i>  &nbsp;'.$data->route;
				 })
                ->addColumn('is_published', function($data) { 
					$disabled=' ';
					$class='';
					$staticRouteArray=[];
					if(in_array($data->route,$staticRouteArray))
					{
						 $disabled='disabled';
					}
					else{
						$class='isPublished-status';
					}
                    $checked = ($data->is_published == 'yes') ? 'checked' : '';
					return '<div class="form-check form-switch">
					  <input class="form-check-input published_status" type="checkbox" value="' . $data->id . '" ' . $checked . ' role="switch" id="SwitchCheck' . $data->id . '">
					  <label class="form-check-label" for="SwitchCheck' . $data->id . '">Yes/No</label>
				  </div>
			  ';
                })
              
                ->addColumn('action',function($data){
                    $edit = '<li><a href="' . url('cms') . '/' . $data->id . '/edit' . '" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
                    $view = '<li><a class="dropdown-item cmsView"  data-id="' .$data->id. '"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>';
                    // $addFields='<li><a href="'.url('add-clinic-fields/'.$data->id).'" class="dropdown-item"><i class=" ri-folder-add-fill  align-bottom me-2 text-muted"></i> Add Form Fields</a></li>';
                    return '<div class="dropdown d-inline-block">
                  <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-more-fill align-middle"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
    
                    ' . $edit . '
                    ' . $view . '
                  </ul>
                </div>';
                })
                ->setRowId(function ($data) {
                     return "row_".$data->id;
               })
               ->rawColumns(['page_name','route','is_published','action','checkbox'])
                ->make(true);

            
        }
    }



    public function cmsStatusChange(Request $request)
    {
        $data=Cms::find($request->thisId);
        if($data->is_published=='yes')
        {
            $data->is_published='no';
        }else{
            $data->is_published='yes';
        }
        $data->updated_by=\auth::user()->id;
        $data->updated_at=date('Y-m-d H:i:s');
        $data->save();
        return response()->json(['message'=>'success']);exit;
    }
}
?>