<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Settings;
use DataTables;

class SettingsController extends Controller
{
  	public function index()
  	{
  		  return view('admin.settings.index');
  	}
  
    public function edit($id)
    {
        $data=Settings::find($id);
        return view('admin.settings.edit',[
            'data'=>$data
        ]);
    }
    
//   	public function update(Request $request)
//   	{
// // dd($request);
//         foreach($request->all() as $key=>$row)
//         {
//             if($key != '_token')
//             {
//                 $data= Settings::where('label',$key)->first();
//                 if($data)
//                 {
//                     if($key=='logo' || $key=='favicon')
//                     {
    
//                           if($key=='logo')
//                           {   
//                             if($request->hasFile('logo'))
//                             {
//                                 $file = ($request->file('logo'));
//                                 $name = time().$file->getClientOriginalName();
//                                 $path = public_path('/images/settings/logo');
//                                 $file->move($path,$name);
//                                 $data->value=$name;
//                             }
//                           }
//                           if($key=='favicon')
//                           {
//                             if($request->hasFile('favicon'))
//                             {
//                                 $file = ($request->file('favicon'));
//                                 $name = time().$file->getClientOriginalName();
//                                 $path = public_path('/images/settings/favicon');
//                                 $file->move($path,$name);
//                                 $data->value=$name;
//                             }
//                           }
    
//                     }
//                     else
//                     {
//                     $data->value=$request->value;   
                         
//                     }
//                 $data->save();
                
//                 }
//             }
//         return response()->json(['status'=>true]);   
//         }
        
//   	}

        public function update(Request $request,$id)
        {
            $request->validate([
                'label'=>'required',          
            ],[
                'label.required'=>'Please enter label.',
    		]);
             
             
            $data = Settings::findOrFail($id);
            $data->label = $request->label;
            $path = public_path('images/settings');
            if ($request->input_type === 'file' && $request->hasFile('image')) {
                if ($data->image && file_exists($path . '/' . $data->image)) {
                    unlink($path . '/' . $data->image);
                }
                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $file->move($path, $name);
                $data->value = $name;
                $data->type=$request->input_type;
            } 
            
            else {
                $data->value = $request->value;
                $data->type=$request->input_type;
            }
        
            $data->save();
            return response()->json(['status'=>true]);
        }
        

  	public function filter_settings(Request $request)
      {
        
          if($request->ajax()){
            $data = Settings::select('settings.*');
            if($request->has('label') && !empty($request->label))
            {
              $data=$data->where('label','like','%'.$request->label.'%');
            }
           
            $data=$data->get();  
            return Datatables::of($data)
            ->addColumn('checkbox', function ($data) 
            {
              return '<div class="form-check">
                 <input class="form-check-input" type="checkbox" name="chk_child" value="' . $data->id . '">
              </div>';
            })
            ->addIndexColumn()
            ->addColumn('label', function($data) { return $data->label; })
            ->addColumn('value', function($data) { return $data->value; })
            ->addColumn('action', function ($data) {
                    $edit = '<li><a href="' . url('settings') . '/' . $data->id . '/edit' . '" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';

                    return '<div class="dropdown d-inline-block">
                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="ri-more-fill align-middle"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                  ' . $edit . '
                </ul>
              </div>';
                })
          ->setRowId(function ($data) 
                {
                   return "row_".$data->id;
                })
         ->rawColumns(['label','value','checkbox','action'])
          ->make(true);

              
          }
      }


      public function storeSettings()
      {
        $data=Settings::get();
        return view('admin.settings.store-settings',[
          'data'=>$data]);
      }
      
      
      public function emailSettings()
      {
        return view('admin.settings.email-settings');
      }

      public function changeEnableCart(Request $request)
      {
        $data=Settings::find($request->thisId);
        if($data->value=='no')
        {
          $data->value='yes';
        }else{
          $data->value='no';
        }
        $data->save();
        echo "Status Changed";
      }

      public function changeEnableLocalPickup(Request $request)
      {
        $data=Settings::find($request->thisId);
        if($data->value=='yes')
        {
          $data->value='no';
        }else{
          $data->value='yes';
        }
        $data->save();
        echo "Status Changed";
      }
      
      
   

}
?>