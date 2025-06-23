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


class CategoryDiscountController extends Controller
{
    public function index()
    {
        return view('admin.category-discount.index');
    }

    
    public function create()
    {
        $categories=Category::where('is_parent','no')->get();
        return view('admin.category-discount.create',[
            'categories'=>$categories,
        ]);
    }
    
    
    /*
    public function categoryProducts(Request $request,$id)
    {

        if ($request->ajax()) {
            $data = Product::where('is_finished', 'yes')->where('category_ids',$id)->select('*');
            \Log::info('hiii=============================================================================');
            $cateDiscount=CategoryDiscount::where('category_id',$id)->first();
             $assignedProductIds = CategoryProductDiscount::where('category_discount_id',$cateDiscount->id)
            ->pluck('product_id')
            ->toArray();
            
            return Datatables::of($data)

                //->addColumn('checkbox', function ($data) {
                    
                //    return '<div class="form-check">
                //        <input type="checkbox" class="form-check-input product-checkbox" name="product_ids[]" value="'.$data->id.'">
                //    </div>';
                //})
                 ->addColumn('checkbox', function ($data) use ($assignedProductIds) {
                $checked = in_array($data->id, $assignedProductIds) ? 'checked' : '';

                return '<div class="form-check">
                    <input type="checkbox" class="form-check-input product-checkbox" name="product_ids[]" value="'.$data->id.'" '.$checked.'>
                </div>';
            })

                ->addIndexColumn()
                
                ->addColumn('icon', function ($data) {return '<img src="' . asset('public/images/product/icon') . '/' . $data->icon . '" style="width:50px;height:50px;">';

                })
                ->rawColumns([ 'icon','checkbox'])
                ->make(true);

        }
    }*/
    
    public function categoryProducts(Request $request,$id)
    {    
        if ($request->ajax()) {
            $data = Product::where('is_finished', 'yes')
                ->where('category_id', $id)
                ->select('*');
        
            // \Log::info('Fetching category discount for category ID: ' . $id);
        
            $assignedProductIds = [];
        
            $cateDiscount = CategoryDiscount::where('category_id', $id)->first();
            if ($cateDiscount) {
                $assignedProductIds = CategoryProductDiscount::where('category_discount_id', $cateDiscount->id)
                    ->pluck('product_id')
                    ->toArray();
            }
        
            return Datatables::of($data)
                ->addColumn('checkbox', function ($data) use ($assignedProductIds) {
                    $checked = in_array($data->id, $assignedProductIds) ? 'checked' : '';
                    return '<div class="form-check">
                        <input type="checkbox" class="form-check-input product-checkbox" name="product_ids[]" value="' . $data->id . '" ' . $checked . '>
                    </div>';
                })
                ->addIndexColumn()
                ->addColumn('icon', function ($data) {
                    return '<img src="' . asset('public/images/product/icon') . '/' . $data->icon . '" style="width:50px;height:50px;">';
                })
                ->rawColumns(['icon', 'checkbox'])
                ->make(true);
        }

    }
    
    public function Store(Request $request)
    {
        $request->validate([
            'discount_name' => 'required',
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
            return response()->json(['status' => true, 'message' => 'there is a discount in same period with category']);
        } 
        
        else {
            $discount = new CategoryDiscount();
            $discount->discount_name = $request->discount_name;
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
                
                $productDiscount = new CategoryProductDiscount();
                $productDiscount->category_discount_id = $discount->id;
                $productDiscount->product_id = $productId;
                $productDiscount->created_by = \Auth::user()->id;
                $productDiscount->updated_by = \Auth::user()->id;
                $productDiscount->created_at = now();
                $productDiscount->updated_at = now();
                $productDiscount->save();
        }

        return response()->json(['status' => true, 'message' => 'success']);
    }
    
    
    
    
    
    
    

    public function edit($id)
    {

        $data = CategoryDiscount::find($id);
        $categoryproducts=CategoryProductDiscount::where('category_discount_id',$data->id);
         $categories=Category::get();
        return view('admin.category-discount.edit', [
            'data' => $data,
            'categoryproducts' => $categoryproducts,
            'categories'=>$categories,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'discount' => 'required|numeric|min:0',
            'product_ids' => 'required|array|min:1',
        ]);

            $discount = CategoryDiscount::findOrFail($id);
            
            $discount->discount_name = $request->discount_name;
            $discount->category_id = $request->category_id;
            $discount->from_date = $request->from_date;
            $discount->to_date = $request->to_date;
            $discount->discount = $request->discount;
            $discount->created_by = \Auth::user()->id;
            $discount->updated_by = \Auth::user()->id;
            $discount->created_at = now();
            $discount->updated_at = now();
            $discount->save();
        CategoryProductDiscount::where('category_discount_id', $discount->id)->delete();

            // Insert new product discounts
            foreach ($request->product_ids as $productId) 
            {
                
                $productDiscount = new CategoryProductDiscount();
                $productDiscount->category_discount_id = $discount->id;
                $productDiscount->product_id = $productId;
                $productDiscount->created_by = \Auth::user()->id;
                $productDiscount->updated_by = \Auth::user()->id;
                $productDiscount->created_at = now();
                $productDiscount->updated_at = now();
                $productDiscount->save();
            }
        return response()->json(['message' => 'success']);
    }

    public function show(string $id)
    {
        $categorydiscount=CategoryDiscount::find($id);
        $categoryproducts=CategoryProductDiscount::with('product')->where('category_discount_id',$categorydiscount->id);
        $categoryDicsountView = View::make('admin.category-discount.view.view', ['categorydiscount' => $categorydiscount,'categoryproducts' => $categoryproducts])->render();
        return response()->json(['categoryDicsountView' => $categoryDicsountView]);
        
    }
    
    public function destroy(string $id)
    {
        
       $data = CategoryDiscount::find($id);
       {
            $categoryproducts=CategoryProductDiscount::where('category_discount_id',$data->id);
            $categoryproducts->delete();
       }
        $data->delete();
        
    }
    
    
    
    
    public function filter_categoryDiscount(Request $request)
    {

        if ($request->ajax()) {
            $data = CategoryDiscount::select('*');

            if ($request->has('category_name') && !empty($request->category_name)) {
                $data = $data->where('category_name', 'like', '%' . $request->category_name . '%');
            }
            return Datatables::of($data)

                ->addIndexColumn()

                // ->addColumn('category_name', function ($data) {return $data->category_name;})
                ->addColumn('category_name', function ($data) {
                    $categoryName = $data->category_id;
                    $parentName = $data->parentCategory ? $data->parentCategory->category_id : null;
                
                    if ($parentName) {
                        $categoryName .= '<br><small class="text-muted">Main Category: ' . $parentName . '</small>';
                    }
                
                    return $categoryName;
                })
                
                ->rawColumns(['category_name', 'action'])
                
				->addColumn('action', function ($data) {
					$view = '<li><a class="dropdown-item discountViewBtn"  data-id="' .$data->id. '"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>';
					$edit = '<li><a href="' . url('category-discount') . '/' . $data->id . '/edit' . '" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
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
    
    
    
    
    
    
    
    
    
    
    
    
    

    

}
