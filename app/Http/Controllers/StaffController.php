<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class StaffController extends Controller
{
    public function index()
    {
        return view('admin.staff.index');
    }


    public function create()
    {
        return view('admin.staff.create');
    }


    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email|unique:staff,email',
        'phone' => 'required',
        'password' => 'required',
        'image' => 'required|image',
        ], 
        [
            'email.unique' => 'The email has already been taken.',
        ]);
        
        $imageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '.' . str_replace(' ', '', $file->getClientOriginalExtension());
            $path = public_path('/images/staff');
            $file->move($path, $imageName);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->user_type = 'staff';
        $user->profile_image = $imageName;
        
        $user->created_at = now();
        $user->updated_at = now();
        $user->save();
    

        $staff = new Staff();
        $staff->user_id = $user->id;
        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->phone = $request->phone;
        $staff->date_of_birth = $request->date_of_birth;
        $staff->place = $request->place;
        $staff->position = $request->position;
        $staff->image = $imageName;
        
        $staff->created_by = auth()->user()->id;
        $staff->updated_by = auth()->user()->id;
        $staff->created_at = now();
        $staff->updated_at = now();
    
        
    
        $staff->save();
    
        return response()->json(['message' => 'success']);
    }
 
       
    public function edit($id)
    {
        $data= Staff::find($id);
        return view('admin.staff.edit',[
            'data'=>$data,
        ]);
    }

     public function update(Request $request,$id)
    {
        $staff = Staff::findOrFail($id);
        $user = User::findOrFail($staff->user_id);
    
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id . '|unique:staff,email,' . $staff->id,
            'phone' => 'required',
            'image' => 'nullable|image',
        ]);
    
        // Handle image upload (optional)
        $imageName = $staff->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '.' . str_replace(' ', '', $file->getClientOriginalExtension());
            $path = public_path('/images/staff');
            $file->move($path, $imageName);
        }
    
        // Update User table
        $user->name = $request->name;
        $user->email = $request->email;
        
        if (!empty($request->password)) 
        {
            $user->password = Hash::make($request->password);
        }
        $user->phone = $request->phone;
        $user->profile_image = $imageName;
        $user->updated_at = now();
        $user->save();
    
        // Update Staff table
        $staff->name = $request->name;
        $staff->email = $request->email; 
        $staff->phone = $request->phone;
        $staff->date_of_birth = $request->date_of_birth;
        $staff->place = $request->place;
        $staff->position = $request->position;
        $staff->image = $imageName;
        $staff->updated_by = auth()->user()->id;
        $staff->updated_at = now();
        $staff->save();
    
        return response()->json(['message' => 'success']);
    }

    public function show($id)
    {
        $data=Staff::find($id);
        $view=view('admin.staff.view',[
            'data'=>$data,
        ]);
        echo $view;
    }
    
    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        if ($staff->image) {
            $imagePath = public_path('images/staff/' . $staff->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        if ($staff->user_id) {
            User::where('id', $staff->user_id)->delete();
        }
        $staff->delete();
    
        echo 1;
    }




    
    public function filter_staff(Request $request)
    {
     
        if($request->ajax()){
          $data = Staff::select('*');
         
          if($request->has('name') && !empty($request->name))
          {
            $data=$data->where('name','like','%'.$request->name.'%');
          }
          $data=$data->orderBy('id', 'DESC')->get();  
          return Datatables::of($data)
                     
                ->addIndexColumn()

                ->addColumn('action', function($data){
                    $user = auth()->user();
                
                    $view = '<li><a class="dropdown-item staffView" data-id="' .$data->id. '">
                        <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>';
                
                    $edit = '';
                    $delete = '';
                
                    if ($user->user_type !== 'staff') {
                        $edit = '<li><a href="'.url('staff/'.$data->id.'/edit').'" class="dropdown-item edit-item-btn">
                            <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
                
                        $delete = '<li><a class="dropdown-item remove-item-btn" data-id="' . $data->id . '">
                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete </a></li>';
                    }
                
                    return '<div class="dropdown d-inline-block">
                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-fill align-middle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">'
                            . $view .
                            $edit .
                            $delete .
                        '</ul>
                    </div>';
                })

                ->setRowId(function ($data) {
                     return "row_".$data->id;
               })
               ->rawColumns(['action'])
                ->make(true);

            
        }
    }


   
}
?>