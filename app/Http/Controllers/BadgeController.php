<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use DataTables;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    public function index()
    {
        $data = Badge::get();
        return view('admin.badge.index', [
            'data' => $data,
        ]);
    }
   
    public function create()
    {
        return view('admin.badge.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'badge_name' => 'required',
            'colour' => 'required',
        ]);

        $model = new Badge();
        $model->badge_name = $request->input('badge_name');
        $model->colour = $request->input('colour');

        $model->status = $request->badge_status;

        $model->created_by = \Auth::user()->id;
        $model->updated_by = \Auth::user()->id;
        $model->created_at = date('Y-m-d H:i:s');
        $model->updated_at = date('Y-m-d H:i:s');
        $model->save();
        return response()->json(['message'=>'success']);
        
    }
    public function edit($id)
    {
        $data = Badge::find($id);
        return view('admin.badge.edit', [
            'data' => $data,
        ]);

    }
    public function update(Request $request)
    {
       
        $request->validate([
            'badge_name' => 'required',
            'colour' => 'required',
        ]);
        
        $data = Badge::find($request->badge_Id);
        $data->badge_name = $request->input('badge_name');
        $data->colour = $request->input('colour');
        $data->status = $request->badge_status;
        $data->updated_by = \Auth::user()->id;
        $data->updated_at = date('Y-m-d H:i:s');
        $data->save();
        return response()->json(['message'=>'success']);
        

    }
    
    /*public function badgeView(Request $request)
    {
        $data = Badge::find($request->id);
        $view = view('admin.badge.view', [
            'data' => $data]);
        echo $view;
    }*/
    
    public function destroy(string $id)
    {
      
        $data = Badge::find($id);
      $data->delete();
       
    }
    
    
     public function filter_badge(Request $request)
    {
        //  dd($request);
        $data = Badge::select('*');

        return DataTables::of($data)
            ->filter(function ($data) use ($request) {
                if ($request->has('badge_name') && $request->badge_name != '') {
                    $data->where('badge_name', 'like', "%{$request->badge_name}%");
                }

            })

            
            ->addColumn('checkbox', function ($data) {
              return '<div class="form-check">
                         <input class="form-check-input" type="checkbox" name="chk_child" value="' . $data->id . '">
                      </div>';
          })
            ->addIndexColumn()
            ->addColumn('badge_name', function ($data) {return $data->badge_name;})
            ->addColumn('colour', function ($data) {return '<span  style="padding:10px 20px;;background-color:' . $data->colour . '" ><span>';})
            ->addColumn('status', function ($data) {
                $checked = ($data->status == 'yes') ? 'checked' : '';
                return '<div class="form-check form-switch">
                  <input class="form-check-input badge_status" type="checkbox" value="' . $data->id . '" ' . $checked . ' role="switch" id="SwitchCheck' . $data->id . '">
                  <label class="form-check-label" for="SwitchCheck' . $data->id . '">Yes/No</label>
              </div>
          ';
            })

            ->addColumn('action', function ($data) {
                    $edit = '<li><a class="dropdown-item "  id="editBadge" data-id="' .$data->id. '"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Edit</a></li>';

                // $edit = '<li><a href="' . url('badge') . '/' . $data->id . '/edit' . '" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
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

                ' . $edit . '
                ' . $delete . '
              </ul>
            </div>';
            })
            ->rawColumns(['action', 'badge_name', 'colour', 'status','checkbox'])
            ->make(true);

    }

    public function changeBadge_status(Request $request)
    {
        //echo $request->thisId;

        $data = Badge::find($request->thisId);
        if ($data->status == 'yes') {
            $data->status = 'no';
            $data->save();

        } else {
            $data->status = 'yes';
            $data->save();

        }
        return response()->json(['message'=>'success']);
        exit;
    }

    /*    public function inslug()
{
$data=Badge::get();
$set=[];
foreach($data as $row)
{
$set=[
['slug'=>$row->badge_name],
];

}

foreach($data as $row)
{
$row->slug=Str::slug($row->badge_name);
$row->save();
}

}*/
   public function getColor()
   {
    $colors=Badge::pluck('colour');
    return response()->json(['colors'=>$colors]);
   }
   
    public function fetchBadge(Request $request)
    {
        $badge=Badge::find($request->badgeId);
        // dd($coupon);
        return response()->json($badge);
    }

}
