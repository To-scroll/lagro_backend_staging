<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

use DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class BlogController extends Controller
{
    public function index()
    {
        return view('admin.blog.index');
    }


   

    public function create()
    {
        return view('admin.blog.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'blog_category'=>'required',
            'blog_title'=>'required',
            'blog_date'=>'required',
            'blog_description'=>'required',
            'image'=>'required',
            'is_published'=>'required'
        ]);
        $data= new Blog();
        $data->blog_category=$request->blog_category;
        $data->blog_title=$request->blog_title;
        $data->blog_date=$request->blog_date;
        $data->blog_description=$request->blog_description;
       
        $data->slug = Str::slug($request->blog_title);
        $data->is_published=$request->is_published;
       
        $data->created_by=\Auth::user()->id;
        $data->created_at=now();
        $data->updated_by=\Auth::user()->id;
        $data->updated_at=now();
        
        if ($request->hasFile('image')) {
            $file = ($request->file('image'));
            $name = time() . '.' . str_replace(' ', '', $file->getClientOriginalExtension());
            $path = public_path('/images/blog');
            $file->move($path, $name);
            $data->image = $name;
        }
        $data->save();
        

        return response()->json(['message' => 'success']);
    }
 
       
    public function edit($id)
    {
        $data= Blog::find($id);
        return view('admin.blog.edit',[
            'data'=>$data,
        ]);
    }

     public function update(Request $request,$id)
    {
        $request->validate([
            'blog_category'=>'required',
            'blog_title'=>'required',
            'blog_date'=>'required',
            'blog_description'=>'required',
          
             
        ]);
        $data=Blog::find($id);
         $data->blog_category=$request->blog_category;
        $data->blog_title=$request->blog_title;
        $data->blog_date=$request->blog_date;
        $data->blog_description=$request->blog_description;
       
        $data->slug = Str::slug($request->blog_title);
        $data->is_published=$request->is_published;
        $data->updated_by=\Auth::user()->id;
        $data->updated_at=now();
        
        if ($request->hasFile('image')) {
            $file = ($request->file('image'));
            $name = time() . '.' . str_replace(' ', '', $file->getClientOriginalExtension());
            $path = public_path('images/blog');
            $file->move($path, $name);
            $data->image = $name;
        }
	
        $data->save();
      
        return response()->json(['message' => 'success']);
        
    }

    public function show($id)
    {
        $data=Blog::find($id);
        $view=view('admin.blog.view',[
            'data'=>$data,
        ]);
        echo $view;
    }
    
    public function destroy($id)
    {
        $data=Blog::find($id)->delete();
        echo 1;
    }




 public function filter_blog(Request $request)
    {
     
        if($request->ajax()){
          $data = Blog::select('*');
         
          if($request->has('blog_title') && !empty($request->blog_title))
          {
            $data=$data->where('blog_title','like','%'.$request->blog_title.'%');
          }
         
         
          $data=$data->orderBy('id', 'DESC')->get();  
          return Datatables::of($data)
                     ->addColumn('checkbox', function ($data) {
                       return '<div class="form-check">
                       <input class="form-check-input" type="checkbox" name="chk_child" value="' . $data->id . '">
                    </div>';
                  })
                ->addIndexColumn()
                ->addColumn('blog_title', function($data) { return $data->blog_title; })
               
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
                   
                    $view = '<li><a class="dropdown-item blogView"  data-id="' .$data->id. '"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>';
                    $edit = '<li><a href="'.url('blog/'.$data->id.'/edit').'"  class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
                    $delete = '<li> <a class="dropdown-item remove-item-btn" data-id="' . $data->id . '"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete </a></li>';
                    
                    return '<div class="dropdown d-inline-block">
                  <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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
               ->rawColumns(['blog_title','is_published','action','checkbox'])
                ->make(true);

            
        }
    }


    public function BlogStatusChange(Request $request)
    {
        $data=Blog::find($request->thisId);
        if($data->is_published=='yes')
        {
            $data->is_published='no';
        }else{
            $data->is_published='yes';
        }
        $data->updated_by=\auth::user()->id;
        $data->updated_at=now();
        $data->save();
        return response()->json(['message'=>'success']);exit;
    }
}
?>