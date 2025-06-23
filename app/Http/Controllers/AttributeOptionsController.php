<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attributes;
use App\Models\AttributeOptions;
use DataTables;
class AttributeOptionsController extends Controller
{
	public function index()
	{
		return view('admin.attributes-option.index');
	}
	
	public function create()
	{
		 $data=Attributes::get();
		 return view('admin.attributes-option.create',[
		 	'data'=>$data
		 ]);

	}
	public function store(Request $request)
	{
		$request->validate([
			'attribute'=>'required',
			'attribute_option'=>'required'
		]);

		$model= new AttributeOptions();
		$model->attribute_id=$request->input('attribute');
		$model->attribute_option_name=$request->input('attribute_option');
		if(\App\Models\Attributes::getColorId()  == $request->attribute) 
		{
		$model->color=$request->input('color');
		}else{
			$model->color=Null;
		}
		$model->created_at=date('Y-m-d H:i:s');
		$model->updated_at=date('Y-m-d H:i:s');
		$model->save();
		return response()->json(['message'=>'success']);
	}
	public function edit($id)
	{
		$data=AttributeOptions::find($id);
		$attributes=Attributes::get();
		return view('admin.attributes-option.edit',[
			'data'=>$data,
			'attributes'=>$attributes
		]);
	}
	public function update(Request $request)
	{
		$request->validate([
			'attribute'=>'required',
			'attribute_option'=>'required'
		]);
		
		$model= AttributeOptions::find($request->rowId);
		$model->attribute_id=$request->input('attribute');
		$model->attribute_option_name=$request->input('attribute_option');
		if(\App\Models\Attributes::getColorId()  == $request->attribute) 
		{
		$model->color=$request->input('color');
		}else{
			$model->color=Null;
		}
		//$model->color=$request->input('color');
		$model->updated_at=date('Y-m-d H:i:s');
		$model->save();
		return response()->json(['message'=>'success']);
	}
	
	public function destroy(string $id)
	{
		$data= AttributeOptions::find($id);
		$data->delete();
		
	}


public function filter_attributesOption(Request $request)
    {
     
        if($request->ajax()){
        	
          $data=AttributeOptions::select('attribute_options.*','attributes.attribute_name')
		   ->leftjoin('attributes','attributes.id','attribute_options.attribute_id');
         
          if($request->has('attribute') && !empty($request->attribute))
          {
            $data=$data->where('attribute_name','like','%'.$request->attribute.'%');
          }
           if($request->has('option') && !empty($request->option))
          {
            $data=$data->where('attribute_option_name','like','%'.$request->option.'%');
          }
         
                   
          $data=$data->get();  
          return Datatables::of($data)
		  ->addColumn('checkbox', function ($data) {
			return '<div class="form-check">
					   <input class="form-check-input" type="checkbox" name="chk_child" value="' . $data->id . '">
					</div>';
		})
                ->addIndexColumn()
                ->addColumn('attribute_name', function($data) { return $data->attribute_name; })
                ->addColumn('attribute_option_name', function($data) { return $data->attribute_option_name; })
                ->addColumn('color', function($data) { 
                	if(\App\Models\Attributes::getColorId()  == $data->attribute_id) 
                	{
                			return '<span  style="padding:10px 20px;;background-color:'.$data->color.'" class=" badge"><span>'; 
                	}else{
                		return '';
                		
                	}
                })
                ->addColumn('action', function ($data) {

					$edit = '<li><a href="' . url('attribute-options') . '/' . $data->id . '/edit' . '" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
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
				->rawColumns(['action', 'attribute_name', 'color','checkbox'])
				->make(true);
            
        }
    }


	public function OptionList(Request $request)
	{
		//echo $request->attri_id;exit;
		$data=AttributeOptions::where('attribute_id',$request->attri_id)->get();
		$c=$request->row_id[0];

		$test='';
		$test.='<div class="input-field col s12 m3"><select class="select2 browser-default" name="attrioptions_'.$c.'"><option value="">choose Attribute options</option>';
		if($data)
		{
			
			foreach($data as $row)
			{
				$test.='<option value="'.$row->id.'">'.$row->attribute_option_name.'</option>';
			}
		}
		$test.='</select></div>';
		echo $test;exit;
		
	}
	

}