<?php
namespace App\Http\Controllers;

use App\Models\AttributeOptions;
use App\Models\Attributes;
use DataTables;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        return view('admin.attributes.index');
    }
    
    public function create()
    {
        return view('admin.attributes.create');
    }
    public function attributeSave(Request $request)
    {
        $request->validate([
            'attribute_name' => 'required',
        ]);
        $atb = Attributes::where('attribute_name', strtolower($request->attribute_name))->count();
        if ($atb == 0) {
            $attribute = new Attributes();
            $attribute->attribute_name = strtolower($request->attribute_name);
            $attribute->save();
			return response()->json(['message'=>'success']);

        } else {
			return response()->json(['message'=>'error']);


        }

    }
    public function edit($id)
    {
        $data = Attributes::find($id);
        return view('admin.attributes.edit', [
            'data' => $data,
        ]);
    }

    public function updateAttribute(Request $request)
    {
        $request->validate([
            'attribute_name' => 'required',
        ]);
        $atb = Attributes::where('attribute_name', strtolower($request->attribute_name))->where('id', '!=', $request->id)->count();
        if ($atb == 0) {
            $attribute = Attributes::find($request->id);
            $attribute->attribute_name = strtolower($request->attribute_name);
            $attribute->save();
			return response()->json(['message'=>'success']);
        } else {
			return response()->json(['message'=>'error']);

        }

    }

    public function destroy(string $id)
    {
        $data = Attributes::find($id);
		$data->delete();
        

    }
    
    public function filter_attributes(Request $request)
    {

        if ($request->ajax()) {
            $data = Attributes::select('attributes.*');

            if ($request->has('attribute') && !empty($request->attribute)) {
                $data = $data->where('attribute_name', 'like', '%' . $request->attribute . '%');
            }

            $data = $data->get();
            return Datatables::of($data)
                ->addColumn('checkbox', function ($data) {
                    return '<div class="form-check">
					   <input class="form-check-input" type="checkbox" name="chk_child" value="' . $data->id . '">
					</div>';
                })
                ->addIndexColumn()
                ->addColumn('attribute_name', function ($data) {return $data->attribute_name;})
                ->addColumn('action', function ($data) {

                    $edit = '<li><a  class="dropdown-item edit-item-btn "  id="editAttribue"  data-id="' .$data->id. '" ><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
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
                ->rawColumns(['action', 'attribute_name', 'checkbox'])
                ->make(true);

        }
    }
    

    //storing attributes during product creation
    public function attributeStore(Request $request)
    {
        $request->validate([
            'attribute_name' => 'required',
        ]);
        $atb = Attributes::where('attribute_name', strtolower($request->attribute_name))->count();
        if ($atb == 0) {
            $attribute = new Attributes();
            $attribute->attribute_name = strtolower($request->attribute_name);
            $attribute->save();
            return response()->json(['data' => 'Added', 'value' => $attribute->id, 'name' => $attribute->attribute_name, 'success' => true]);
        } else {
            return response()->json(['data' => 'Attributes Exists', 'success' => false]);

        }
    }

    //storing attribute options during product creation
    public function attributeOptionSave(Request $request)
    {
        $request->validate([
            'attributes_name' => 'required',
            'option_name' => 'required',
        ]);
        $atb = AttributeOptions::where('attribute_id', $request->attributes_name)->where('attribute_option_name', strtolower($request->option_name))->count();
        if ($atb == 0) {
            $option = new AttributeOptions();
            $option->attribute_id = $request->attributes_name;
            $option->attribute_option_name = strtolower($request->option_name);
            if (\App\Models\Attributes::getColorId() == $request->attributes_name) {
                $option->color = $request->input('color');
            } else {
                $option->color = null;
            }

            $option->created_at = date('Y-m-d H:i:s');
            $option->updated_at = date('Y-m-d H:i:s');
            $option->save();

            return response()->json(['data' => 'Option Created Successfully', 'value' => $option->id, 'name' => $option->attribute_option_name, 'atr_id' => $option->attribute_id, 'success' => true]);
        } else {

            return response()->json(['data' => 'Option Exists', 'success' => false]);
        }
    }
    public function fetchAttribute(Request $request)
    {
        $Attribute=Attributes::find($request->AttributeId);
        // dd($coupon);
        return response()->json($Attribute);
    }

}
