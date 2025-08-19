<?php
namespace App\Http\Controllers;

use App\Models\Category;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Str;
use App\Models\Product;
use App\Models\Sku;
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
    
    
 
    
    public function categoryProducts(Request $request,$id)
    {    
       

        if ($request->ajax()) {
            $data = Product::where('is_finished', 'yes')
                ->where('category_id', $id)
                ->select('*');
        
            // \Log::info('Fetching category discount for category ID: ' . $id);
        

        
            $assignedProductIds = [];

            if ($request->has('discount_id')) {
                $cateDiscount = CategoryDiscount::find($request->discount_id);
            
                if ($cateDiscount) {
                    $assignedProductIds = CategoryProductDiscount::where('category_discount_id', $cateDiscount->id)
                        ->pluck('product_id')
                        ->toArray();
                }
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

        $existingDiscounts = CategoryDiscount::where('category_id', $request->category_id)
            ->where(function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('from_date', '<=', $request->to_date)
                      ->where('to_date', '>=', $request->from_date);
                });
            })
            ->with('categoryproducts')
            ->get();

        // echo "<pre>";
        // print_r($existingDiscounts->toArray());
        // echo exit;
        $duplicate = false;
        
        // Loop through existing discounts and check if any product matches
        foreach ($existingDiscounts as $existing) {
            $existingProductIds = $existing->categoryproducts->pluck('product_id')->toArray();
        
            foreach ($request->product_ids as $productId) {
                if (in_array($productId, $existingProductIds)) {
                    $duplicate = true;
                    break 2; // exit both loops
                }
            }
        }
        
        if ($duplicate) {
            return response()->json(['status' => false, 'message' => 'A discount already exists for this product in the same category and date range.']);
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
        $categoryproducts=CategoryProductDiscount::where('category_discount_id',$data->id)->get();
        $categories = Category::where('is_parent', 'no')->get();
        
        return view('admin.category-discount.edit', [
            'data' => $data,
            'categoryproducts' => $categoryproducts,
            'categories'=>$categories,
        ]);
    }
 
    public function update(Request $request, $id)
    {
        $request->validate([
            'discount_name' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'discount' => 'required|numeric|min:0',
            'product_ids' => 'required|array|min:1',
            'completed' => 'required|in:yes,no',
            'category_id' => 'required',
        ]);
    
        // Check for overlapping discounts
        $existingDiscounts = CategoryDiscount::where('category_id', $request->category_id)
            ->where('id', '!=', $id) 
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('from_date', '<=', $request->to_date)
                      ->where('to_date', '>=', $request->from_date);
                });
            })
            ->with('categoryproducts')
            ->get();
    
        $duplicate = false;
    
        foreach ($existingDiscounts as $existing) {
            $existingProductIds = $existing->categoryproducts->pluck('product_id')->toArray();
    
            foreach ($request->product_ids as $productId) {
                if (in_array($productId, $existingProductIds)) {
                    $duplicate = true;
                    break 2; // exit both loops
                }
            }
        }
    
        if ($duplicate) {
            return response()->json([
                'status' => false,
                'message' => 'A discount already exists for one of the selected products in this category and date range.',
            ]);
        }
    
        // Proceed to update
        $discount = CategoryDiscount::findOrFail($id);
    
        $discount->discount_name = $request->discount_name;
        $discount->category_id = $request->category_id;
        $discount->from_date = $request->from_date;
        $discount->to_date = $request->to_date;
        $discount->discount = $request->discount;
        $discount->completed = $request->completed;
        $discount->updated_by = \Auth::user()->id;
        $discount->updated_at = now();
        $discount->save();
    
        // Delete and re-insert associated products
        CategoryProductDiscount::where('category_discount_id', $discount->id)->delete();
    
        foreach ($request->product_ids as $productId) {
            $productDiscount = new CategoryProductDiscount();
            $productDiscount->category_discount_id = $discount->id;
            $productDiscount->product_id = $productId;
            $productDiscount->created_by = \Auth::user()->id;
            $productDiscount->updated_by = \Auth::user()->id;
            $productDiscount->created_at = now();
            $productDiscount->updated_at = now();
            $productDiscount->save();
        }
    
        return response()->json(['status' => true,'message' => 'success']);
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
        $discount = CategoryDiscount::find($id);
    
        if ($discount) {
            // Reset SKUs before deleting the discount
            $productDiscounts = CategoryProductDiscount::where('category_discount_id', $discount->id)->get();
    
            foreach ($productDiscounts as $productDiscount) {
                $product = Product::find($productDiscount->product_id);
    
                if ($product) {
                    $productSkus = Sku::where('product_id', $product->id)->get();
    
                    foreach ($productSkus as $sku) {
                        $sku->discount = $sku->old_discount ?? 0;
                        $sku->special_price = $sku->price - ($sku->price * ($sku->discount / 100));
                        $sku->discount_applied = 'no';
                        $sku->save();
                    }
                }
            }
    
            // Delete the product-discount mapping
            CategoryProductDiscount::where('category_discount_id', $discount->id)->delete();
    
            // Now delete the discount itself
            $discount->delete();
        }
    
        return response()->json(['message' => 'Discount deleted and SKUs restored successfully.']);
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
                
                
                ->rawColumns(['category_name','is_completed', 'action'])
                
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
