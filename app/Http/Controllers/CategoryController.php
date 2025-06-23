<?php
namespace App\Http\Controllers;

use App\Models\Category;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Str;
use App\Models\Product;
use App\Models\CategoryDiscount;
use App\Models\CategoryProductDiscount;


class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.index');
    }

    
    public function create()
    {
        return view('admin.category.create');
    }
    
    public function store(Request $request)
    {

        $request->validate([
            'category_name' => 'required',
            'description' => 'required',
            'is_parent' => 'required',
            //'category_icon'=>'required|dimensions:width=400,height=400'
        ]);

        $model = new Category();
        $model->category_name = $request->input('category_name');
        $model->slug = Str::slug($request->category_name);
        $model->description = $request->input('description');
        $model->position = $request->input('position');
        $model->status = $request->status;
        $model->created_by = \Auth::user()->id;
        $model->updated_by = \Auth::user()->id;
        $model->created_at = date('Y-m-d H:i:s');
        $model->updated_at = date('Y-m-d H:i:s');
        $model->is_parent = $request->input('is_parent');
        if ($request->input('is_parent') == 'yes') {
            $model->parent_category_id = 0;
        } else {
            $model->parent_category_id = $request->parentcategory;
        }

        $path = public_path() . '/images/category';

        if ($files = $request->file('category_icon')) {
            $time = date("Y-m-d") . "-" . time();
            $name = $time . '-' . str_replace(' ', '', $files->getClientOriginalName());
            $files->move($path, $name);
            $model->icon = $name;
        }
        $model->save();
        return response()->json(['message'=>'success']);

    }

    public function edit($id)
    {

        $data = Category::find($id);
        $parent = Category::select('*')->where('is_parent', 'yes')->get();
        return view('admin.category.edit', [
            'data' => $data,
            'categorylist' => $parent,
        ]);
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
            'description' => 'required',
            'is_parent' => 'required',
            //'category_icon'=>'dimensions:width=400,height=400'
        ]);

        $data = Category::find($request->id);

        if ($data->category_name != $request->category_name) {
            $data->slug = Str::slug($request->category_name);
        }

        $data->category_name = $request->input('category_name');
        $data->description = $request->input('description');
        $data->position = $request->input('position');
        $data->status = $request->status;
        $data->updated_by = \Auth::user()->id;
        $data->updated_at = date('Y-m-d H:i:s');

        $data->is_parent = $request->input('is_parent');
        if ($request->input('is_parent') == 'yes') {
            $data->parent_category_id = 0;
        } else {
            $data->parent_category_id = $request->parentcategory;
        }

        $path = public_path() . '/images/category';

        if ($files = $request->file('category_icon')) {
            $time = date("Y-m-d") . "-" . time();

            $name = $time . '-' . str_replace(' ', '', $files->getClientOriginalName());
            $files->move($path, $name);
            $data->icon = $name;
        }
        $data->save();
        return response()->json(['message'=>'success']);
    }
    
    // public function categoryView(Request $request)
    // {
    //     $data = Category::find($request->id);
    //     $view = view('admin.category.view', [
    //         'data' => $data,
    //     ]);
    //     echo $view;

    // }
    public function categoryViewPage(string $id)
    {
        $category=Category::find($id);
       
        $categoryView = View::make('admin.category.view.view', ['category' => $category])->render();
        return response()->json(['categoryView' => $categoryView]);
        
    }
    
    public function destroy(string $id)
    {
        
        $data = Category::find($id);
        $data->delete();
        
    }
    
    
    
    
    public function filter_category(Request $request)
    {

        if ($request->ajax()) {
            $data = Category::select('category.*');

            if ($request->has('category_name') && !empty($request->category_name)) {
                $data = $data->where('category_name', 'like', '%' . $request->category_name . '%');
            }
            if ($request->has('parent') && !empty($request->parent)) {
                $data = $data->where('is_parent',$request->parent);
            }

            $data = $data->get();
            return Datatables::of($data)

                ->addColumn('checkbox', function ($data) {
                    return '<div class="form-check">
					   <input class="form-check-input" type="checkbox" name="chk_child" value="' . $data->id . '">
					</div>';
                })
                ->addIndexColumn()

                // ->addColumn('category_name', function ($data) {return $data->category_name;})
                ->addColumn('category_name', function ($data) {
                    $categoryName = $data->category_name;
                    $parentName = $data->parentCategory ? $data->parentCategory->category_name : null;
                
                    if ($parentName) {
                        $categoryName .= '<br><small class="text-muted">Main Category: ' . $parentName . '</small>';
                    }
                
                    return $categoryName;
                })

                ->addColumn('icon', function ($data) {return '<img src="' . asset('public/images/category') . '/' . $data->icon . '" style="width:50px;height:50px;">';

                })
                
				->addColumn('status', function ($data) {
					$checked = ($data->status == 'yes') ? 'checked' : '';
					return '<div class="form-check form-switch">
					  <input class="form-check-input category_status" type="checkbox" value="' . $data->id . '" ' . $checked . ' role="switch" id="SwitchCheck' . $data->id . '">
					  
				  </div>
			  ';
				})
                
                ->rawColumns(['category_name', 'icon', 'status', 'action', 'is_featured','checkbox'])
                
				->addColumn('action', function ($data) {
					$view = '<li><a class="dropdown-item categoryViewBtn"  data-id="' .$data->id. '"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>';
					$edit = '<li><a href="' . url('category') . '/' . $data->id . '/edit' . '" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
				// 	$applyDiscount = '<li><a href="' . url('categoryDiscount/' . $data->id) . '" class="dropdown-item"> <i class="ri-percent-fill align-bottom me-2 text-muted"></i> Apply Discount</a></li>';
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
                ->make(true);

        }
    }
    
    
    

    public function fetchCategory()
    {

        $data = Category::select('*')->get();
        $test = '';

        if ($data) {

            $test .= '<label class="form-label">Parent Category</label><select name="parentcategory" class="form-control" required=""><option value="">Choose parent Category</option>';

            foreach ($data as $row) {
                $test .= '<option value="' . $row->id . '">' . $row->category_name . '</option>';
            }

            $test .= '</select>';

            echo $test;

        } else {

            echo $test;
        }

        //echo "<pre>";echo $test;exit;

    }

    public function changeCategory_status(Request $request)
    {
    //    dd($request);
        if ($request->has('type') && $request->type == 'is_featured') {
            $data = Category::find($request->thisId);
            if ($data->is_featured == 'yes') {
                $data->is_featured = 'no';
                $data->save();
            } else {
                $data->is_featured = 'yes';
                $data->save();
            }
            return response()->json(['message'=>'success']);exit;
        }
        $data = Category::find($request->thisId);
        if ($data->status == 'yes') {
            $data->status = 'no';
            $data->save();

        } else {
            $data->status = 'yes';
            $data->save();

        }
        return response()->json(['message'=>'success']);exit;
    }
    
    
    
    /*
  
    public function categoryDiscount(string $id)
    {
        $category = Category::find($id);
        $categorydiscount = categoryDiscount::where('category_id', $id)->first();
        $categoryproductdiscount = categoryProductDiscount::where('category_discount_id', optional($categorydiscount)->id)->pluck('product_id')->toArray();
    
        return view('admin.category.category_discount', [
            'category' => $category,
            'categorydiscount' => $categorydiscount,
            'selectedProducts' => $categoryproductdiscount,
        ]);
        
    }
    
    
    
    public function categoryProducts(Request $request,$id)
    {

        if ($request->ajax()) {
            $data = Product::where('is_finished', 'yes')->where('category_ids',$id)->select('*');
            return Datatables::of($data)

                ->addColumn('checkbox', function ($data) {
                    return '<div class="form-check">
                        <input type="checkbox" class="form-check-input product-checkbox" name="product_ids[]" value="'.$data->id.'">
                    </div>';
                })

                ->addIndexColumn()
                
                ->addColumn('icon', function ($data) {return '<img src="' . asset('public/images/product/icon') . '/' . $data->icon . '" style="width:50px;height:50px;">';

                })
                ->rawColumns([ 'icon','checkbox'])
                ->make(true);

        }
    }
    
    
    public function categoryDiscountStore(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'discount' => 'required|numeric|min:0',
            'product_ids' => 'required|array|min:1',
        ]);

        $existingDiscount = CategoryDiscount::where('category_id', $request->category_id)
            ->where('from_date', $request->from_date)
            ->where('to_date', $request->to_date)
            ->first();
   
        if ($existingDiscount) {
            $existingDiscount->discount = $request->discount;
            $existingDiscount->updated_by = \Auth::user()->id;
            $existingDiscount->updated_at = now();
            $existingDiscount->save();
    
            $discount = $existingDiscount;
        } 
        
        else {
            $discount = new CategoryDiscount();
            $discount->category_id = $request->category_id;
            $discount->from_date = $request->from_date;
            $discount->to_date = $request->to_date;
            $discount->discount = $request->discount;
            $discount->created_by = \Auth::user()->id;
            $discount->updated_by = \Auth::user()->id;
            $discount->created_at = now();
            $discount->updated_at = now();
            $discount->save();
        }
    
        foreach ($request->product_ids as $productId) {
            $existingProductDiscount = CategoryProductDiscount::where('category_discount_id', $discount->id)
                ->where('product_id', $productId)
                ->first();
    
            if ($existingProductDiscount) {
                $existingProductDiscount->updated_by = \Auth::user()->id;
                $existingProductDiscount->updated_at = now();
                $existingProductDiscount->save();
            } 
            
            else {
                $productDiscount = new CategoryProductDiscount();
                $productDiscount->category_discount_id = $discount->id;
                $productDiscount->product_id = $productId;
                $productDiscount->created_by = \Auth::user()->id;
                $productDiscount->updated_by = \Auth::user()->id;
                $productDiscount->created_at = now();
                $productDiscount->updated_at = now();
                $productDiscount->save();
            }
        }

        return response()->json(['status' => true, 'message' => 'success']);
    }
    

    */

}
