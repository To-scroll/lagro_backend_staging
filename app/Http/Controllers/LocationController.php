<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Support\Facades\View;
use DataTables;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    public function index()
    {
        return view('admin.locations.index');

    }

    public function filter_locations(Request $request)
    {
        if ($request->ajax()) {
            $data = Location::select('*');
            if ($request->has('Locations') && !empty($request->Locations)) {
                $data = $data->where('location_name', 'like', '%' . $request->Locations . '%');
            };
            return Datatables::of($data)
                ->addColumn('checkbox', function ($data) {
                    return '<div class="form-check">
                       <input class="form-check-input" type="checkbox" name="chk_child" value="' . $data->id . '">
                    </div>';
                })
                ->addIndexColumn()

                ->rawColumns([ 'action'])
                ->addColumn('action', function ($data) {
                  $view = '<li><a class="dropdown-item locationsViewBtn"  data-id="' .$data->id. '"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>';
                    $edit = '<li><a href="' . url('locations') . '/' . $data->id . '/edit' . '" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
                    $delete = '<li>
                <a class="dropdown-item remove-item-btn" data-id="' . $data->id . '">
                  <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                </a>
              </li>';
                   
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
                 ->rawColumns(['action', 'checkbox'])
                ->make(true);

        }
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function store(Request $request)
    {
      
        $request->validate([
            'location_name' => 'required',
            'location_address' => 'required',
            'phone1' => 'required',
            'map' => 'required',
        ]);
        
       $data=new Location();
        $data->location_name = $request->location_name;
        $data->location_address = $request->location_address;
        $data->phone1 = $request->phone1;
        $data->phone2 = $request->phone2;
        $data->map = $request->map;
       
        $data->created_at = date('Y-m-d H:i:s');
        $data->updated_at = date('Y-m-d H:i:s');
        
        $data->save();
        return response()->json(['message' => 'success']);
    }

    public function edit($id)
    {
        $data = Location::find($id);
        return view('admin.locations.edit', [
            'data' => $data]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'location_name' => 'required',
            'location_address' => 'required',
            'phone1' => 'required',
            'map' => 'required',
           
        ]);
        $data=Location::find($request->id);
        
        $data->location_name = $request->location_name;
        $data->location_address = $request->location_address;
        $data->phone1 = $request->phone1;
        $data->phone2 = $request->phone2;
        $data->map = $request->map;
       
        $data->created_at = date('Y-m-d H:i:s');
        $data->updated_at = date('Y-m-d H:i:s');
        
        $data->save();
        return response()->json(['message' => 'success']);
    }

    public function locationsView(Request $request)
    {
        $data = Location::find($request->id);
        $view = view('admin.locations.view', [
            'data' => $data,
        ]);
        echo $view;
    }
    public function destroy(string $id)
    {
        $data = Location::find($id);
        $data->delete();
       
    }
    public function locationsViewPage(string $id)
    {
      $locations=Location::find($id);
       
      $locationsView = View::make('admin.locations.view.view', ['locations' => $locations])->render();
      return response()->json(['locationsView' => $locationsView]);
    }

}
