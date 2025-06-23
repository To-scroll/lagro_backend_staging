<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Support\Facades\View;
use DataTables;
use Illuminate\Http\Request;

class BannerController extends Controller
{

    public function index()
    {
        return view('admin.banner.index');

    }



    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
      
        $request->validate([
            'title' => 'required',
            'image' => 'required',
        ]);
        
       $data=new Banner();
        $data->title = $request->title;
        $data->description = $request->description;
        $data->created_by = \Auth::user()->id;
        $data->created_at = date('Y-m-d H:i:s');
        $data->updated_by = \Auth::user()->id;
        $data->updated_at = date('Y-m-d H:i:s');
        if ($request->hasFile('image')) {
            $file = ($request->file('image'));
            $name = time() . '.' . str_replace(' ', '', $file->getClientOriginalExtension());
            $path = public_path('/images/banner');
            $file->move($path, $name);
            $data->image = $name;
        }
        $data->save();
        return response()->json(['message' => 'success']);
    }

    public function edit($id)
    {
        $data = Banner::find($id);
        return view('admin.banner.edit', [
            'data' => $data]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
           
        ]);
        // dd($request);
        $data = Banner::find($request->id);
        $data->title = $request->title;
        $data->description = $request->description;
        $data->updated_by = \Auth::user()->id;
        $data->updated_at = date('Y-m-d H:i:s');
        if ($request->hasFile('image')) {
            $file = ($request->file('image'));
            $name = time() . '.' . str_replace(' ', '', $file->getClientOriginalExtension());
            $path = public_path('images/banner');
            $file->move($path, $name);
            $data->image = $name;
        }
        $data->save();
        return response()->json(['message' => 'success']);
    }
    
    public function bannerViewPage(string $id)
    {
      $banner=Banner::find($id);
       
      $bannerView = View::make('admin.banner.view.view', ['banner' => $banner])->render();
      return response()->json(['bannerView' => $bannerView]);
    }
    
    
    /*public function bannerView(Request $request)
    {
        $data = Banner::find($request->id);
        $view = view('admin.banner.view', [
            'data' => $data,
        ]);
        echo $view;
     }*/
     
     
    public function destroy(string $id)
    {
        $data = Banner::find($id);
        $data->delete();
       
    }
        public function filter_banner(Request $request)
    {
        if ($request->ajax()) {
            $data = Banner::select('banner.*');
            if ($request->has('title') && !empty($request->title)) {
                $data = $data->where('title', 'like', '%' . $request->title . '%');
            }

            $data = $data->get();
            return Datatables::of($data)
                ->addColumn('checkbox', function ($data) {
                    return '<div class="form-check">
                       <input class="form-check-input" type="checkbox" name="chk_child" value="' . $data->id . '">
                    </div>';
                })
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    return '<img  src="' . asset('/public/images/banner') . '/' . $data->image . '" style="width:50px;height:50px">';

                })
                ->addColumn('title', function ($data) {return ucfirst($data->title);})

                ->rawColumns(['image', 'title', 'action'])
                ->addColumn('action', function ($data) {
                  $view = '<li><a class="dropdown-item bannerViewBtn"  data-id="' .$data->id. '"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>';
                    $edit = '<li><a href="' . url('banner') . '/' . $data->id . '/edit' . '" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
                    $delete = '<li>
                <a class="dropdown-item remove-item-btn" data-id="' . $data->id . '">
                  <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                </a>
              </li>';
                    // $addFields='<li><a href="'.url('add-clinic-fields/'.$data->id).'" class="dropdown-item"><i class=" ri-folder-add-fill  align-bottom me-2 text-muted"></i> Add Form Fields</a></li>';
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
                ->rawColumns(['action', 'image', 'title', 'checkbox'])
                ->make(true);

        }
    }
    

}
