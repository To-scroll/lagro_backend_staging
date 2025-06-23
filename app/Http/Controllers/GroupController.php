<?php

namespace App\Http\Controllers;
use App\Models\Groups;
use App\Models\Orders;
use App\Models\GroupDetails;
use App\Models\Pincodes;
use DataTables;
use Excel;
use App\Imports\PincodeImports;

use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    return view ('admin.groups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pincodes=Pincodes::get();
       return view('admin.groups.create',[
       'pincodes'=> $pincodes
       ]);
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
            'group_name' => 'required',
          
        ]);

        $group = new Groups();
        $group->group_name = $request->input('group_name');
        $group->save();

        if ($group->id) {
            foreach ($request->input('selected_pincode') as $pincode) {
                $groupDetail = new GroupDetails();
                $groupDetail->group_id = $group->id;
                $groupDetail->pincode = $pincode;
                $groupDetail->save();
            }
        }
        return response()->json(['message'=>'success']);
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
        
        $group=Groups::find($id);
        $selectedpincodes=GroupDetails::where('group_id',$id)->get();
        // $pincodes=Pincodes::get();
    //    echo"<pre>";
    //    print_r($selectedpincodes->toArray());
    //    exit;
        return view ('admin.groups.edit',[
            'group'=>$group,
           
            'selectedpincodes'=>$selectedpincodes
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
            'group_name' => 'required',
          
        ]);

        $group = Groups::find($request->id);
        $group->group_name = $request->input('group_name');
        $group->save();

        if ($group->id) {
            GroupDetails::where('group_id', $group->id)->delete();
            foreach ($request->input('selected_pincode') as $pincode) {
                $groupDetail = new GroupDetails();
                $groupDetail->group_id = $group->id;
                $groupDetail->pincode = $pincode;
                $groupDetail->save();
            }
        }
        
        return response()->json(['message'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data=Groups::find($request->id)->delete();
        return response()->json(['message'=>'success']);
      
    }
    public function filter_group(Request $request)
    {
     
        if($request->ajax()){
          $data = Groups::select('*');
         
          if($request->has('group_name') && !empty($request->group_name))
          {
            $data=$data->where('group_name','like','%'.$request->group_name.'%');
          }
         
                   
          $data=$data->get();  
          return Datatables::of($data)
          ->addColumn('checkbox', function ($data) {
            return '<div class="form-check">
               <input class="form-check-input" type="checkbox" name="chk_child" value="' . $data->id . '">
            </div>';
        })
                ->addIndexColumn()
                ->addColumn('group_name', function($data) { return $data->group_name; })
                
                ->rawColumns(['group_name','action','checkbox'])
                ->addColumn('action',function($data){
                    $edit = '<li><a href="' . url('groups') . '/' . $data->id . '/edit' . '" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
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
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);
		$import =Excel::import(new PincodeImports, $request->file('file'));

		return response()->json(['message' => 'Import successful']);

    }
    public function search(Request $request)
    {
        $searchTerm = $request->input('q');

        $pincodes = Pincodes::where('pincode', 'LIKE', "%{$searchTerm}%")->get();
    
        $data = [];
    
        foreach ($pincodes as $pincode) {
            $data[] = [
               
                'id' => $pincode->pincode,
                'officename' => $pincode->office_name,
            ];
        }
        //  dd($data);
        return response()->json($data);
    }
}
