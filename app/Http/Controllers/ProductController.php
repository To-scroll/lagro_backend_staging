<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Badge;
use App\Models\Attributes;
use App\Models\AttributeOptions;
use App\Models\ProductDetails;
use App\Models\ProductVariants;
use App\Models\VariantOptions;
use App\Models\Variants;
use App\Models\Groups;
use App\Models\ProductGroup;
use App\Models\Review;
use App\Models\ProductImages;
use App\Models\Sku;
use App\Models\SkuValues;
use App\Models\Combination;
use App\Models\Wishlist;
use App\Models\WishlistItems;


use Str;
use DataTables;
use Validator;

use Session;
use App\Helper\Helper;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{
	public function index()
    {
       
        $productCount = Product::where('is_finished', 'yes')->count();
        $publishedCount = Product::where('is_finished', 'yes')->where('is_published', 1)->count();
        $newCount = Product::where('is_finished', 'yes')->where('is_new', 1)->count();
        $trendingCount = Product::where('is_finished', 'yes')->where('is_trending', 1)->count();
    
        return view('admin.product.index',[
            'productCount'=>$productCount,
            'publishedCount'=>$publishedCount,
            'newCount'=>$newCount,
            'trendingCount'=>$trendingCount,
        ]);
    }

	public function filter_product(Request $request)
    {
     
        if($request->ajax()){
          $data = Product::select('product.*')->where('is_finished','yes') 
            ->when($request->filled('product_name'), function($query) use ($request) {
                $query->where(function($subQuery) use ($request) {
                    $subQuery->where('product_name', 'like', '%' . $request->product_name . '%');                 
                });
            }); 
          return Datatables::of($data)
        		  ->addColumn('checkbox', function ($data) {
        			return '<div class="form-check">
        			   <input class="form-check-input" type="checkbox" name="chk_child" value="' . $data->id . '">
        			</div>';
        		})
                ->addIndexColumn()                
                ->addColumn('product_name', function($data) { return $data->product_name; })
                ->addColumn('image1', function($data) { 
                	if($data->image1!= '')
                		{
                			return '<img src="'.asset('public/images/product').'/'.$data->image1.'" style="width:50px;height:50px;">';
		                }else{
		                	return '<img src="'.asset('public/images/no-image.png').'" style="width:50px;height:50px;">';

		                }

                    })  
				->addColumn('is_published', function ($data) {
					$checked = ($data->is_published == 'yes') ? 'checked' : '';
					return '<div class="form-check form-switch">
					         <input class="form-check-input published_status" type="checkbox" value="' . $data->id . '" ' . $checked . ' role="switch" id="SwitchCheck' . $data->id . '">
					        
				            </div>
			             ';
				})
				->addColumn('is_new', function($data) { 
			
					$test= '<div class="form-check form-switch">
						   <input class="form-check-input new_status" type="checkbox" value="'.$data->id.'"';
						   if($data->is_new =='yes')
							{ 
							   $test.='checked=""';
							}
							$test.='> </div>';
						   
						   return $test;
			   })
               ->addColumn('is_trending', function($data) { 
			
					$test= '<div class="form-check form-switch">
						   <input class="form-check-input trending_status" type="checkbox" value="'.$data->id.'"';
						   if($data->is_trending =='yes')
							{ 
							   $test.='checked=""';
							}
							$test.='> </div>';
						   
						   return $test;
			   })
               
				->addColumn('action', function ($data) {
					$view = '<li><a href="'. url('product') . '/' . $data->id .'" class="dropdown-item "  data-id="' .$data->id. '"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>';
					$edit = '<li><a href="' . url('product') . '/' . $data->id . '/edit' . '" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
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
				->rawColumns(['product_name','image1','action','is_published','checkbox','is_new','is_trending'])
                ->setRowId(function ($data) {
                     return "row_".$data->id;
               })
                ->make(true);

            
        }
    }
    
    
	public function create(Request $request)
	{
		//session_start();
		if(Session::has('e_product'))
		{
			$request->product_id= Session::get('e_product');
		}
		$category=Category::get();
		$badge=Badge::get();
		$attributes=Attributes::get();
// 		$groups=Groups::get();
		$product=Product::find($request->product_id);
		$variantData=Variants::where('product_id',$request->product_id)->get();
		$var_count=$variantsData=Variants::where('product_id',$request->product_id)->count();
		$variantOptionData=VariantOptions::where('product_id',$request->product_id)->get();
		$var_option_count=VariantOptions::where('product_id',$request->product_id)->count();
		
			return view('admin.product.create',[
			'category'=>$category,
			'badge'=>$badge,
			'attributes'=>$attributes,
			'variantData'=>$variantData,
			'var_count'=>$var_count,
			'variantOptionData'=>$variantOptionData,
			'var_option_count'=>$var_option_count,
			'product'=>$product,
// 			'groups'=>$groups
		]);
	}

	
	public function changePublish_status(Request $request)
	{
		//echo $request->thisId;

		$data=Product::find($request->thisId);
		if($data->is_published=='yes')
		{
			$data->is_published='no';
			$data->save();
			
		}else{
			$data->is_published='yes';
			$data->save();
		
		}
		return response()->json(['message'=>'success']);exit;
	}

    /*
	public function destroy($id)
	{
		$data=Product::find($id);
		$data->delete();
		echo 1;
	}

    */
    public function destroy($id)
    {
         
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        if ($product->image1 && file_exists(public_path('images/product/' . $product->image1))) {
            unlink(public_path('images/product/' . $product->image1));
        }
        if ($product->image2 && file_exists(public_path('images/product/' . $product->image2))) {
            unlink(public_path('images/product/' . $product->image2));
        }
        if ($product->image3 && file_exists(public_path('images/product/' . $product->image3))) {
            unlink(public_path('images/product/' . $product->image3));
        }
        if ($product->image4 && file_exists(public_path('images/product/' . $product->image4))) {
            unlink(public_path('images/product/' . $product->image4));
        }
         if ($product->icon && file_exists(public_path('images/product/' . $product->icon))) {
            unlink(public_path('images/product/icon/' . $product->icon));
        }
    
        $skuImages = ProductImages::where('product_id', $id)->get();
        foreach ($skuImages as $img) {
            if ($img->image && file_exists(public_path('images/products/image/' . $img->image))) {
                unlink(public_path('images/products/image/' . $img->image));
            }
        }
        
        // Delete related records using Eloquent models (not relationships)
        if (Variants::where('product_id', $id)->exists()) {
            Variants::where('product_id', $id)->delete();
        }
        
        if (VariantOptions::where('product_id', $id)->exists()) {
            VariantOptions::where('product_id', $id)->delete();
        }
        
        if (Combination::where('product_id', $id)->exists()) {
            Combination::where('product_id', $id)->delete();
        }
        
        if (Sku::where('product_id', $id)->exists()) {
            Sku::where('product_id', $id)->delete();
        }
        
        if (SkuValues::where('product_id', $id)->exists()) {
            SkuValues::where('product_id', $id)->delete();
        }
        
        if (WishlistItems::where('product_id', $id)->exists()) {
            WishlistItems::where('product_id', $id)->delete();
        }
        
        if (ProductImages::where('product_id', $id)->exists()) {
            ProductImages::where('product_id', $id)->delete();
        }

     \Log::info('Product ' . $id . ' at ' . now());

        
        // Delete the product itself
        Product::where('id', $id)->delete();
    
        return response()->json(['success' => 'Product and related data deleted successfully.'], 200);
    }

	public function displayVariation(Request $request)
	{
		$options=AttributeOptions::where('attribute_id',$request->attribute_id)->get();
		$html='';
		if($options)
		{	$html.='<select class="country form-control form-select select2 attribute_option_selection" name="attribute_option[]"  required width="100%">
                        <option value="">Choose Option</option>';
							foreach($options as $row)
							{
								$html.='<option value="'.$row->id.'">'.$row->attribute_option_name.'</option>';
							}
						$html.='</select>';
					
		}
		echo $html;
	}
	
	
	public function displayVariationEdit(Request $request)
	{
		$options=AttributeOptions::where('attribute_id',$request->attribute_id)->get();
		$html='';
		if($options)
		{	$html.='<select class="country form-control form-select select2 attribute_option_selection s_attr_opt_edit" name="attribute_option_edit[]"  required width="100%">
                        <option value="">Choose Option</option>';
							foreach($options as $row)
							{
								$html.='<option value="'.$row->id.'">'.$row->attribute_option_name.'</option>';
							}
						$html.='</select>';
					
		}
		echo $html;
	}


	public function displayFirstVariation(Request $request)
	{
		$options= AttributeOptions::where('attribute_id',$request->attribute_id)->get();
		$html='';
		if($options)
		{	$html.='<select class="form-control form-select select2 displayOptions" name="option_value[]" required multiple><option value="">Choose Option</option>';
				foreach($options as $row)
				{
					$html.='<option value="'.$request->attribute_id.'_'.$row->id.'">'.$row->attribute_option_name.'</option>';
				}
			$html.='</select>';
		}
		echo $html;
	}
	
	
	public function displayFirstVariationEdit(Request $request)
	{
		$options= AttributeOptions::where('attribute_id',$request->attribute_id)->get();
		$html='';
		if($options)
		{	$html.='<select class="form-control form-select select2 displayOptions v_attr_option_edit" name="option_value_edit[]" required multiple><option value="">Choose Option</option>';
				foreach($options as $row)
				{
					$html.='<option value="'.$request->attribute_id.'_'.$row->id.'">'.$row->attribute_option_name.'</option>';
				}
			$html.='</select>';
		}
		echo $html;
	}


	public function validateData(Request $request)
	{
		
		if($request->val_set=='set1')
		{
			$array=[
			'category'=>'required',
			'product_name'=>'required',
			'brand'=>'required',
			'description'=>'required',
			'short_description'=>'required',
			'add_badge_status'=>'required',
			'image1'=>'required',
			'icon'=>'required',
		    ];
		    $validator = Validator::make($request->all(),$array);
			 if ($validator->fails())
			 {    
				return response()->json(['result'=>false,'message' => $validator->messages()], 200);
			 }else{
			 	return response()->json(['result'=>true], 200);
			 }
		}

		if($request->val_set=='set2')
		{
			
			
			if($request->type_edit!='')
			{
				$type=$request->type_edit;
			}else{
				$type=$request->type;
			}
		
		
				if($type=='simple')
				{
					$array=[
					// 'simple_attributes'=>'required|array|min:1',
					// 'attribute_option'=>'required|array|min:1',
					// 'simple_attributes.*'=>'required',
					// 'attrbute_option.*'=>'required'
				    ];
				}
				if($type=='variant')
				{
					$array=[
					'attributes'=>"required|array|min:1",
	            	'option_value'=>"required|array|min:1",
	            	'attributes.*'=>'required',
	            	'option_value.*'=>'required',
				    ];
				}
			
		    $validator = Validator::make($request->all(),$array);
			 if ($validator->fails())
			 {    
				return response()->json(['result'=>false,'message' => $validator->messages()], 200);
			 }else{
			 	return response()->json(['result'=>true], 200);
			 }
		}

		if($request->val_set=='set3')
		{
			if($request->pro_type=='simple')
			{
				$array=[
				'product_sku'=>'required|unique:sku,sku',
				'product_price'=>'required',
				'product_quantity'=>'required',
				
			    ];

			 
			}
			if($request->pro_type=='variant')
			{
				$array=[
				'v_sku'=>'required|unique:sku,sku|array|min:1',
				'v_price'=>'required|array|min:1',
				'v_quantity'=>'required|array|min:1',
				'v_sku.*'=>'required',
				'v_price.*'=>'required',
				'v_quantity.*'=>'required',
			    ];

			
			}

             $validator = Validator::make($request->all(),$array);
				 if ($validator->fails())
				 {    
					return response()->json(['result'=>false,'message' => $validator->messages()], 200);
				 }else{
				 	return response()->json(['result'=>true], 200);
				 }


             
		}
		

	}
	
	
	public function generalFormStore(Request $request)
	{
		
	
		$request->validate([
			'category'=>'required',
			'product_name'=>'required',
		]);
		/*if(Session::has('e_product'))
		{
			$product_id= Session::get('e_product');

			$model= Product::find($product_id);
			if($model->product_name != $request->product_name)
			{
			$model->slug=Str::slug($request->product_name);
			}
		}else
		{
			$model= new Product();
			$model->created_by=\Auth::user()->id;
			$model->created_at=date('Y-m-d H:i:s');
			$model->slug=Str::slug($request->product_name);
			
		}*/
		
		
		$session_id = session()->get('session_id');  
        /*
        if ($session_id) {
            
            $existingProduct = Product::where('session_id', $session_id)->first();
            if ($existingProduct) {
                $existingProduct->delete();
            }
        }
    	*/
		
		
		
		$model= new Product();
		$model->created_by=\Auth::user()->id;
		$model->created_at=date('Y-m-d H:i:s');
		$model->slug=Str::slug($request->product_name);
		$model->product_name=$request->input('product_name');
		$model->brand=$request->input('brand');
		
		$model->add_badge_status=$request->input('add_badge_status');
		if($request->add_badge_status=='yes')
		{
		$model->badge_id=$request->input('badge');
		}else{
			$model->badge_id=Null;

		}
		$model->category_id=$request->category;
	

		$model->meta_description=$request->input('meta_description');
		$model->description=$request->input('description');
		$model->short_description=$request->input('short_description');

		$model->updated_by=\Auth::user()->id;
		
		$model->updated_at=date('Y-m-d H:i:s');
		$path=public_path().'/images/product';
		$path1=public_path().'/images/product/icon';

        if($files=$request->file('image1'))
        {
        	$time = date("Y-m-d")."-".time() ;
        	$name=$time.'-'.str_replace(' ','',$files->getClientOriginalName());
        	$files->move($path,$name);
        	$model->image1=$name;
        }
		/*
		if($files=$request->file('image2'))
        {
        	$time = date("Y-m-d")."-".time() ;
        	$name=$time.'-'.str_replace(' ','',$files->getClientOriginalName());
        	$files->move($path,$name);
        	$model->image2=$name;
        }
		if($files=$request->file('image3'))
        {
        	$time = date("Y-m-d")."-".time() ;
        	$name=$time.'-'.str_replace(' ','',$files->getClientOriginalName());
        	$files->move($path,$name);
        	$model->image3=$name;
        }
		if($files=$request->file('image4'))
        {
        	$time = date("Y-m-d")."-".time() ;
        	$name=$time.'-'.str_replace(' ','',$files->getClientOriginalName());
        	$files->move($path,$name);
        	$model->image4=$name;
        }
        */
        
		if($files=$request->file('icon'))
        {
        	$time = date("Y-m-d")."-".time() ;
        	$name=$time.'-'.str_replace(' ','',$files->getClientOriginalName());
        	$files->move($path1,$name);
        	$model->icon=$name;
        }
        
		$model->session_id = session()->getId(); 
		$model->save();
		/*
		if($model->id){
			foreach ($request->input('selected_group') as $group) {
                $productGroup = new ProductGroup();
                $productGroup->product_id = $model->id;
                $productGroup->group_id = $group;
                $productGroup->created_at = now();
                $productGroup->updated_at = now();
                $productGroup->save();
            }
		}
        */
		/*session_start();
		//Session::set('e_product', $model->id);
		session()->put('e_product', $model->id);*/
		
		session()->put('session_id', $model->session_id);
		return response()->json(['data'=>'Saved','productId'=>$model->id,'success'=>true]);
		
	}


	public function variantFormSubmit(Request $request)
	{


		if($request->type_edit!='')
		{
			$type=$request->type_edit;
		}else{
			$type=$request->type;
		}
		$type=$request->type;
		/*
		if(Session::has('e_product'))
		{
			$request->product_id= Session::get('e_product');
		}
		*/
		$product=Product::find($request->product_id);
			
		$product->type=$type;
			
			if($product->save())
			{

				//For inserting data to Variants and variants option table
				// if($type=='simple')
				/* {
					
				// 		if(($request['s_attr_edit_set'][0]!='') || ($request['s_attr_opt_edit_set'][0]!=''))
				// 		{
				// 			$new_options=VariantOptions::where('product_id',$product->id)->get();
				// 			$new_s_option_idarray=[];
				// 			if($new_options)
				// 			{	
				// 				foreach($new_options as $row)
				// 				{
				// 					array_push($new_s_option_idarray,$row->id);
				// 				}
				// 				$del_opt=VariantOptions::whereIn('id',$new_s_option_idarray)->delete();
				// 			}
				// 			$new_variant=Variants::where('product_id',$product->id)->get();
				// 			$new_s_variant_idarray=[];
				// 			if($new_variant)
				// 			{
				// 				foreach($new_variant as $row)
				// 				{
				// 					array_push($new_s_variant_idarray,$row->id);
				// 				}
				// 				$del=Variants::whereIn('id',$new_s_variant_idarray)->delete();
				// 			}
				// 			if($request->has('simple_attributes_edit'))
				// 			{
				// 				for($i=0;$i<count($request['simple_attributes_edit']);$i++)
				// 				{ 
				// 				$attribute=Attributes::find($request['simple_attributes_edit'][$i]);

				// 				$variant= new Variants();
				// 				$variant->product_id=$request->product_id;
				// 				$variant->attribute_name=$attribute->attribute_name;
								
				// 					if($variant->save())
				// 					{
				// 						$option_add=new VariantOptions();
				// 						$option_add->product_id=$request->product_id;
				// 						$option_add->variant_id=$variant->id;
				// 						$option_add->option_name=\App\Models\AttributeOptions::getAttributeOptionName($request->attribute_option_edit[$i]);
				// 						$option_add->save();


				// 					}

				// 				}
				// 			}

				// 		}
				// 		if($request->has('simple_attributes'))
				// 		{
				// 			for($i=0;$i<count($request['simple_attributes']);$i++)
				// 			{ 
				// 			$attribute=Attributes::find($request['simple_attributes'][$i]);

				// 			$variant= new Variants();
				// 			$variant->product_id=$request->product_id;
				// 			$variant->attribute_name=$attribute->attribute_name;
							
				// 				if($variant->save())
				// 				{
				// 					$option_add=new VariantOptions();
				// 					$option_add->product_id=$request->product_id;
				// 					$option_add->variant_id=$variant->id;
				// 					$option_add->option_name=\App\Models\AttributeOptions::getAttributeOptionName($request->attribute_option[$i]);
				// 					$option_add->save();


				// 				}

				// 			}

				// 		}

					


				// $v_option=VariantOptions::select('variant_id')->where('product_id',$product->id)->groupby('variant_id')->get();
				// $variant_array=[];
				// $set1=[];$set2=[];$set3=[];$set4=[];$set5=[];$set6=[];
				// $set_id1=[];$set_id2=[];$set_id3=[];$set_id4=[];$set_id5=[];$set_id6=[];

				// foreach($v_option as $row)
				// {
				// 	array_push($variant_array,$row->variant_id);
				// }
				// 	for($i=0;$i<count($variant_array);$i++)
				// 	{
				// 		$set=VariantOptions::where('variant_id',$variant_array[$i])->get();
				// 		foreach($set as $row)
				// 		{
				// 			if($i==0)
				// 			{
				// 				array_push($set1,$row->option_name);
				// 				array_push($set_id1,$row->id);

				// 			}else if($i==1)
				// 			{
				// 				array_push($set2,$row->option_name);
				// 				array_push($set_id2,$row->id);
				// 			}
				// 			else if($i==2)
				// 			{
				// 				array_push($set3,$row->option_name);
				// 				array_push($set_id3,$row->id);
				// 			}
				// 			else if($i==3)
				// 			{
				// 				array_push($set4,$row->option_name);
				// 				array_push($set_id4,$row->id);
				// 			}
				// 			else if($i==4)
				// 			{
				// 				array_push($set5,$row->option_name);
				// 				array_push($set_id5,$row->id);
				// 			}
				// 			else if($i==5)
				// 			{
				// 				array_push($set6,$row->option_name);
				// 				array_push($set_id6,$row->id);
				// 			}
				// 		}

				// 	}

				// 		$input = [$set1,$set2,$set3,$set4,$set5,$set6];
				// 		$input_set_id = [$set_id1,$set_id2,$set_id3,$set_id4,$set_id5,$set_id6];
				// 		$combination_array=\App\Helper\Helper::cartesian($input);
				// 		$comb_id_array=\App\Helper\Helper::cartesian($input_set_id);
						
				// 		if(count($combination_array)>0)
				// 		{
				// 			// if($product->type=='simple')
				// 			// {
				// 				if(($request['s_attr_edit_set'][0] !='') || ($request['s_attr_opt_edit_set'][0] !='') || ($request->has('simple_attributes')))
				// 				{
				// 					$cmb_products=Combination::where('product_id',$product->id)->get();
				// 					$cmb_row_id=[];
				// 					if($cmb_products)
				// 					{	
				// 						foreach($cmb_products as $row)
				// 						{
				// 							array_push($cmb_row_id,$row->id);

				// 						}
				// 						$del_cmbprod=Combination::whereIn('id',$cmb_row_id)->delete();
				// 					}
				// 					for($i=0;$i<count($combination_array);$i++){
				// 						$cmb_set=new Combination();
				// 						$cmb_set->product_id=$product->id;
				// 						$cmb_set->combination=implode('-',$combination_array[$i]);
				// 						$cmb_set->var_option_id=implode('-',$comb_id_array[$i]);
				// 						$cmb_set->save();							

				// 					}

							
						

				// 				$cm_new=Combination::where('product_id',$product->id)->first();

				// 				$sku_new=Sku::where('product_id',$product->id)->first();
				// 				if($sku_new)
				// 				{
				// 					$sku_new->combination_set=$cm_new->combination;
				// 					$sku_new->combination_id=$cm_new->id;
				// 					$sku_new->save();
				// 				}else{
				// 					$sku_new=new Sku();
				// 					$sku_new->product_id=$product->id;
				// 					$sku_new->combination_set=$cm_new->combination;
				// 					$sku_new->combination_id=$cm_new->id;
				// 					$sku_new->save();

				// 				}

							
				// 				$sk_val_id=[];
				// 				$variant_options_new=VariantOptions::where('product_id',$product->id)->get();
										
				

				// 				foreach($variant_options_new as $row)
				// 				{
									
				// 					$sk_val=SkuValues::where('product_id',$product->id)->where('variant_option_id',$row->id)->where('variant_id',$row->variant_id)->where('sku_id',$sku_new->id)->first();
				// 					if($sk_val){
				// 						$sk_val->sku_id=$sku_new->id;
				// 						$sk_val->product_id=$sku_new->product_id;
				// 						$sk_val->variant_id=$row->variant_id;
				// 						$sk_val->variant_option_id=$row->id;
				// 						$sk_val->save();
				// 						array_push($sk_val_id,$sk_val->id);
				// 					}else{
				// 						$sk_new=new SkuValues();
				// 						$sk_new->sku_id=$sku_new->id;
				// 						$sk_new->product_id=$sku_new->product_id;
				// 						$sk_new->variant_id=$row->variant_id;
				// 						$sk_new->variant_option_id=$row->id;
				// 						$sk_new->save();
				// 						array_push($sk_val_id,$sk_new->id);
				// 					}
									
									
				// 				}
				// 				$sk_new_val=SkuValues::where('product_id',$product->id)->whereNotIn('id',$sk_val_id)->delete();


				// 				}
							
				// 			//}
				// 		}
					
					

				// }*/
				
					if ($type == 'simple') {

                        // Delete old data if any edit or new simple attributes exist
                        if (
                            ($request['s_attr_edit_set'][0] != '') ||
                            ($request['s_attr_opt_edit_set'][0] != '') ||
                            $request->has('simple_attributes')
                        ) {
                            // Delete Variant Options
                            VariantOptions::where('product_id', $product->id)->delete();
                    
                            // Delete Variants
                            Variants::where('product_id', $product->id)->delete();
                    
                            // Delete Combinations
                            Combination::where('product_id', $product->id)->delete();
                    
                            // Delete SKU Values
                            SkuValues::where('product_id', $product->id)->delete();
                    
                            // Delete SKU
                            Sku::where('product_id', $product->id)->delete();
                        }
                    
                        // Add edited simple attributes
                        if ($request->has('simple_attributes_edit')) {
                            for ($i = 0; $i < count($request['simple_attributes_edit']); $i++) {
                                $attribute = Attributes::find($request['simple_attributes_edit'][$i]);
                    
                                $variant = new Variants();
                                $variant->product_id = $product->id;
                                $variant->attribute_name = $attribute->attribute_name;
                    
                                if ($variant->save()) {
                                    $option = new VariantOptions();
                                    $option->product_id = $product->id;
                                    $option->variant_id = $variant->id;
                                    $option->option_name = \App\Models\AttributeOptions::getAttributeOptionName($request['attribute_option_edit'][$i]);
                                    $option->save();
                                }
                            }
                        }
                    
                        // Add new simple attributes
                        if ($request->has('simple_attributes')) {
                            for ($i = 0; $i < count($request['simple_attributes']); $i++) {
                                $attribute = Attributes::find($request['simple_attributes'][$i]);
                    
                                $variant = new Variants();
                                $variant->product_id = $product->id;
                                $variant->attribute_name = $attribute->attribute_name;
                    
                                if ($variant->save()) {
                                    $option = new VariantOptions();
                                    $option->product_id = $product->id;
                                    $option->variant_id = $variant->id;
                                    $option->option_name = \App\Models\AttributeOptions::getAttributeOptionName($request['attribute_option'][$i]);
                                    $option->save();
                                }
                            }
                        }
                    
                        // Generate combinations
                        $variantIds = VariantOptions::where('product_id', $product->id)
                            ->groupBy('variant_id')
                            ->pluck('variant_id');
                    
                        $optionNames = [];
                        $optionIds = [];
                    
                        foreach ($variantIds as $index => $variantId) {
                            $options = VariantOptions::where('variant_id', $variantId)->get();
                            $optionNames[$index] = $options->pluck('option_name')->toArray();
                            $optionIds[$index] = $options->pluck('id')->toArray();
                        }
                    
                        $combinations = \App\Helper\Helper::cartesian($optionNames);
                        $combinationIds = \App\Helper\Helper::cartesian($optionIds);
                    
                        if (count($combinations) > 0) {
                            for ($i = 0; $i < count($combinations); $i++) {
                                $comb = new Combination();
                                $comb->product_id = $product->id;
                                $comb->combination = implode('-', $combinations[$i]);
                                $comb->var_option_id = implode('-', $combinationIds[$i]);
                                $comb->save();
                            }
                    
                            // Assign first combination to SKU
                            $firstCombo = Combination::where('product_id', $product->id)->first();
                    
                            $sku = new Sku();
                            $sku->product_id = $product->id;
                            $sku->combination_set = $firstCombo->combination;
                            $sku->combination_id = $firstCombo->id;
                            $sku->save();
                    
                            // Save SkuValues
                            $savedSkuValueIds = [];
                            $variantOptions = VariantOptions::where('product_id', $product->id)->get();
                    
                            foreach ($variantOptions as $vo) {
                                $skuVal = new SkuValues();
                                $skuVal->sku_id = $sku->id;
                                $skuVal->product_id = $product->id;
                                $skuVal->variant_id = $vo->variant_id;
                                $skuVal->variant_option_id = $vo->id;
                                $skuVal->save();
                    
                                $savedSkuValueIds[] = $skuVal->id;
                            }
                    
                            // Remove any extra SkuValues (just in case)
                            SkuValues::where('product_id', $product->id)
                                ->whereNotIn('id', $savedSkuValueIds)
                                ->delete();
                        }
                    }
				
				// if($type=='variant')
				/* {
					
				// 		if(($request['v_attr_edit_set'][0]!='') || ($request['v_attr_opt_edit_set'][0]!=''))
				// 		{
				// 			$new_options=VariantOptions::where('product_id',$product->id)->get();
				// 			$new_option_idarray=[];

				// 			if($new_options)								
				// 			{
				// 				foreach($new_options as $row)
				// 				{
				// 					array_push($new_option_idarray,$row->id);
				// 				}
				// 				$del_opt=VariantOptions::whereIn('id',$new_option_idarray)->delete();
				// 			}
				// 			$new_variant=Variants::where('product_id',$product->id)->get();
				// 			$new_variant_idarray=[];
				// 			if($new_variant)
				// 			{
				// 				foreach($new_variant as $row)
				// 				{
				// 					array_push($new_variant_idarray,$row->id);
				// 				}
				// 				$del_vars=Variants::whereIn('id',$new_variant_idarray)->delete();
				// 			}
				// 			if($request->has('attributes_edit'))
				// 			{
				// 				for($i=0;$i<count($request['attributes_edit']);$i++)
				// 				{ 
			
							
				// 					$attribute=Attributes::find($request['attributes_edit'][$i]);

				// 					$variant= new Variants();
				// 					$variant->product_id=$request->product_id;
				// 					$variant->attribute_name=$attribute->attribute_name;
									
				// 					if($variant->save())
				// 						{
				// 							for($j=0;$j<count($request['option_value_edit']);$j++)
				// 							{
				// 								$explodearray=explode('_',$request->option_value_edit[$j]);
											
				// 								if(($explodearray[0])== $request['attributes_edit'][$i])
				// 								{
												
				// 									$option_add=new VariantOptions();
				// 									$option_add->product_id=$request->product_id;
				// 									$option_add->variant_id=$variant->id;
				// 									$option_add->option_name=\App\Models\AttributeOptions::getAttributeOptionName($explodearray[1]);
				// 									$option_add->save();

				// 								}
								
				// 							}

				// 						}
									
				// 				}
				// 			}
				// 		}
				// 		if($request->has('attributes'))
				// 		{

				// 			for($i=0;$i<count($request['attributes']);$i++)
				// 			{ 
					
						
				// 				$attribute=Attributes::find($request['attributes'][$i]);

				// 				$variant= new Variants();
				// 				$variant->product_id=$request->product_id;
				// 				$variant->attribute_name=$attribute->attribute_name;
								
				// 				if($variant->save())
				// 				{
				// 						for($j=0;$j<count($request['option_value']);$j++)
				// 						{
				// 							$explodearray=explode('_',$request->option_value[$j]);
											
				// 							if(($explodearray[0])== $request['attributes'][$i])
				// 							{
				// 								//echo \App\Models\AttributeOptions::getAttributeOptionName($explodearray[1]);
				// 								$option_add=new VariantOptions();
				// 								$option_add->product_id=$request->product_id;
				// 								$option_add->variant_id=$variant->id;
				// 								$option_add->option_name=\App\Models\AttributeOptions::getAttributeOptionName($explodearray[1]);
				// 								$option_add->save();

				// 							}
								
				// 						}

				// 				}
								
				// 			}
						

				// 		}
					

			
				

				// $v_option=VariantOptions::select('variant_id')->where('product_id',$product->id)->groupby('variant_id')->get();
				// $variant_array=[];
				// $set1=[];$set2=[];$set3=[];$set4=[];$set5=[];$set6=[];
				// $set_id1=[];$set_id2=[];$set_id3=[];$set_id4=[];$set_id5=[];$set_id6=[];

				// foreach($v_option as $row)
				// {
				// 	array_push($variant_array,$row->variant_id);
				// }
				// 	for($i=0;$i<count($variant_array);$i++)
				// 	{
				// 		$set=VariantOptions::where('variant_id',$variant_array[$i])->get();
				// 		foreach($set as $row)
				// 		{
				// 			if($i==0)
				// 			{
				// 				array_push($set1,$row->option_name);
				// 				array_push($set_id1,$row->id);

				// 			}else if($i==1)
				// 			{
				// 				array_push($set2,$row->option_name);
				// 				array_push($set_id2,$row->id);
				// 			}
				// 			else if($i==2)
				// 			{
				// 				array_push($set3,$row->option_name);
				// 				array_push($set_id3,$row->id);
				// 			}
				// 			else if($i==3)
				// 			{
				// 				array_push($set4,$row->option_name);
				// 				array_push($set_id4,$row->id);
				// 			}
				// 			else if($i==4)
				// 			{
				// 				array_push($set5,$row->option_name);
				// 				array_push($set_id5,$row->id);
				// 			}
				// 			else if($i==5)
				// 			{
				// 				array_push($set6,$row->option_name);
				// 				array_push($set_id6,$row->id);
				// 			}
				// 		}

				// 	}

				// 		$input = [$set1,$set2,$set3,$set4,$set5,$set6];
				// 		$input_set_id = [$set_id1,$set_id2,$set_id3,$set_id4,$set_id5,$set_id6];
				// 		$combination_array=\App\Helper\Helper::cartesian($input);
				// 		$comb_id_array=\App\Helper\Helper::cartesian($input_set_id);
				// 		if(count($combination_array)>0)
				// 		{

				// 			if($product->type=='variant')
				// 			{
				// 				if(($request['v_attr_edit_set'][0] !='') || ($request['v_attr_opt_edit_set'][0] !='') || ($request->has('attributes')))
				// 				{
				// 					$cmb_products=Combination::where('product_id',$product->id)->get();
				// 					$cmb_row_id=[];
				// 					if($cmb_products)
				// 					{	
				// 						foreach($cmb_products as $row)
				// 						{
				// 							array_push($cmb_row_id,$row->id);

				// 						}
				// 						$del_cmbprod=Combination::whereIn('id',$cmb_row_id)->delete();
				// 					}
				// 					for($i=0;$i<count($combination_array);$i++){
				// 						$cmb_set=new Combination();
				// 						$cmb_set->product_id=$product->id;
				// 						$cmb_set->combination=implode('-',$combination_array[$i]);
				// 						$cmb_set->var_option_id=implode('-',$comb_id_array[$i]);
				// 						$cmb_set->save();							

				// 					}

								

				// 				$new_cmb=Combination::where('product_id',$product->id)->get();
						
				// 				$sk_new_array=[];
				// 				$var_option_cmb_set=[];
				// 				$v_sk_val_id=[];
    // 								for($i=0;$i<count($new_cmb);$i++)
    // 								{//$var_option_cmb_set=[];
    // 									$sk_newCount=Sku::where('combination_set',$new_cmb[$i]->combination)->where('product_id',$product->id)->count();
    // 									if($sk_newCount>0)
    // 									{
    // 										$sk_new=Sku::where('combination_set',$new_cmb[$i]->combination)->where('product_id',$product->id)->first();
    // 										//print_r($sk_new);
    // 										$sk_new->product_id=$product->id;
    // 										$sk_new->combination_set=$new_cmb[$i]->combination;
    // 										$sk_new->combination_id=$new_cmb[$i]->id;
    // 										$sk_new->save();
    // 										array_push($sk_new_array,$sk_new->id);
    // 										$var_option_cmb_set=explode('-',$new_cmb[$i]->var_option_id);
    								
    // 										if($var_option_cmb_set)
    // 										{
    // 											for($k=0;$k<count($var_option_cmb_set);$k++)
    // 											{//echo $var_option_cmb_set[$k];
    // 												$opt_new_set1=VariantOptions::find($var_option_cmb_set[$k]);
    // 												//print_r($opt_new_set1);
    // 													$sk_val=new SkuValues();
    // 													$sk_val->product_id=$product->id;
    // 													$sk_val->sku_id=$sk_new->id;
    // 													$sk_val->variant_id=$opt_new_set1->variant_id;
    // 													$sk_val->variant_option_id=$opt_new_set1->id;
    // 													$sk_val->save();
    // 													array_push($v_sk_val_id,$sk_val->id);
    												
    // 											}
    
    // 										}
    // 										unset($var_option_cmb_set);
    // 									}
    // 									else
    // 									{
    // 										$sk_new= new Sku();
    // 										$sk_new->product_id=$product->id;
    // 										$sk_new->combination_set=$new_cmb[$i]->combination;
    // 										$sk_new->combination_id=$new_cmb[$i]->id;
    // 										$sk_new->save();
    // 										array_push($sk_new_array,$sk_new->id);
    // 										$var_option_cmb_set=explode('-',$new_cmb[$i]->var_option_id);
    // 										if($var_option_cmb_set)
    // 										{
    // 											for($k=0;$k<count($var_option_cmb_set);$k++)
    // 											{
    // 												$opt_new_set=VariantOptions::find($var_option_cmb_set[$k]);
    											
    												
    // 													$sk_val=new SkuValues();
    // 													$sk_val->product_id=$product->id;
    // 													$sk_val->sku_id=$sk_new->id;
    // 													$sk_val->variant_id=$opt_new_set->variant_id;
    // 													$sk_val->variant_option_id=$opt_new_set->id;
    // 													$sk_val->save();
    // 													array_push($v_sk_val_id,$sk_val->id);
    												
    // 											}
    // 										}
    // 										unset($var_option_cmb_set);
    // 									}
    
    // 								}
    // 							//print_r($sk_new_array);exit;
    // 								$delete_oldsku=Sku::where('product_id',$product->id)->whereNotin('id',$sk_new_array)->delete();
    // 								$sk_new_val=SkuValues::where('product_id',$product->id)->whereNotIn('id',$v_sk_val_id)->delete();


				// 				}
							
				// 			}

				// 		}
										
				// 	}*/
					
					
					if ($type == 'variant') 
					{
                        VariantOptions::where('product_id', $product->id)->delete();
                        Variants::where('product_id', $product->id)->delete();
                        Combination::where('product_id', $product->id)->delete();
                        Sku::where('product_id', $product->id)->delete();
                        SkuValues::where('product_id', $product->id)->delete();
                        if ($request->has('attributes_edit')) {
                            foreach ($request['attributes_edit'] as $i => $attributeId) {
                                $attribute = Attributes::find($attributeId);
                                $variant = new Variants();
                                $variant->product_id = $request->product_id;
                                $variant->attribute_name = $attribute->attribute_name;
                                if ($variant->save()) {
                                    foreach ($request['option_value_edit'] as $optionValue) {
                                        [$attrId, $optId] = explode('_', $optionValue);
                                        if ($attrId == $attributeId) {
                                            $option = new VariantOptions();
                                            $option->product_id = $request->product_id;
                                            $option->variant_id = $variant->id;
                                            $option->option_name = \App\Models\AttributeOptions::getAttributeOptionName($optId);
                                            $option->save();
                                        }
                                    }
                                }
                            }
                        }
                    
                        if ($request->has('attributes')) {
                            foreach ($request['attributes'] as $i => $attributeId) {
                                $attribute = Attributes::find($attributeId);
                                $variant = new Variants();
                                $variant->product_id = $request->product_id;
                                $variant->attribute_name = $attribute->attribute_name;
                                if ($variant->save()) {
                                    foreach ($request['option_value'] as $optionValue) {
                                        [$attrId, $optId] = explode('_', $optionValue);
                                        if ($attrId == $attributeId) {
                                            $option = new VariantOptions();
                                            $option->product_id = $request->product_id;
                                            $option->variant_id = $variant->id;
                                            $option->option_name = \App\Models\AttributeOptions::getAttributeOptionName($optId);
                                            $option->save();
                                        }
                                    }
                                }
                            }
                        }
                    
                        $variant_ids = VariantOptions::select('variant_id')
                            ->where('product_id', $product->id)
                            ->groupBy('variant_id')
                            ->pluck('variant_id')
                            ->toArray();
                    
                        $sets = [];
                        $set_ids = [];
                    
                        foreach ($variant_ids as $variant_id) {
                            $options = VariantOptions::where('variant_id', $variant_id)->get();
                            $option_names = $options->pluck('option_name')->toArray();
                            $option_ids = $options->pluck('id')->toArray();
                            $sets[] = $option_names;
                            $set_ids[] = $option_ids;
                        }
                    
                        $combination_array = \App\Helper\Helper::cartesian($sets);
                        $comb_id_array = \App\Helper\Helper::cartesian($set_ids);
                    
                        $new_sku_ids = [];
                        $new_sku_value_ids = [];
                    
                        foreach ($combination_array as $i => $combo) {
                            $comboStr = implode('-', $combo);
                            $comboIdStr = implode('-', $comb_id_array[$i]);
                    
                            $comb = new Combination();
                            $comb->product_id = $product->id;
                            $comb->combination = $comboStr;
                            $comb->var_option_id = $comboIdStr;
                            $comb->save();
                            
                            
                    
                            // Add or reuse SKU
                            $sku = new Sku();
                            $sku->product_id = $product->id;
                            $sku->combination_set = $comboStr;
                            $sku->combination_id = $comb->id;
                            $sku->save();
                            $new_sku_ids[] = $sku->id;
                    
                            // Insert SKU Values
                            $option_ids = explode('-', $comboIdStr);
                            foreach ($option_ids as $option_id) {
                                $option = VariantOptions::find($option_id);
                                if ($option) {
                                    $skuVal = new SkuValues();
                                    $skuVal->product_id = $product->id;
                                    $skuVal->sku_id = $sku->id;
                                    $skuVal->variant_id = $option->variant_id;
                                    $skuVal->variant_option_id = $option->id;
                                    $skuVal->save();
                                    $new_sku_value_ids[] = $skuVal->id;
                                }
                            }
                    }
                
					    
					}	
					
					
				$variant_options=VariantOptions::where('product_id',$product->id)->get();

				$variantSet=Variants::where('product_id',$product->id)->get();
				$new_variant_id=[];
				foreach($variantSet as $row)
				{
					array_push($new_variant_id,$row->id);
				}

				$combination_set=Combination::where('product_id',$product->id)->get();
				$skus=Sku::where('product_id',$product->id)->get();	
				
				return response()->json(['data'=>'Saved','productId'=>$request->product_id,'variant_options'=>$variant_options,'variantSet'=>$variantSet,'product_type'=>$product->type,'combination_set'=>$combination_set,'new_variant_id'=>$new_variant_id,'skus'=>$skus,'success'=>true]);
			


			}

		
		

	}


	public function skuFormSubmit(Request $request)
	{
        \Log::info('Product sku saves  at', ['time' => now()]);

		$product=Product::find($request->sku_productId);

		if($product)
		{

			if($product->type=='simple')
			{
		
				$cmb_val=Combination::where('product_id',$request->sku_productId)->first();
				$skuData=Sku::where('product_id',$request->sku_productId)->first();
				//echo "<pre>";echo $request->sku_productId;print_r($skuData);exit;
				if((isset($cmb_val) && $cmb_val->combination == $skuData->combination_set) )
				{
				    
				
						$skuData->product_id=$request->sku_productId;
						$skuData->sku=$request->product_sku;
						$skuData->price=$request->product_price;
						$skuData->quantity=$request->product_quantity;
						$skuData->special_price=$request->product_sp_price;
						$skuData->stock_status=$request->product_stock_status;
						$skuData->updated_at=date('Y-m-d H:i:s');
						$skuData->save();
				
    				    if ($request->hasFile('product_image')) {
                            foreach ($request->file('product_image') as $file) {
                                if ($file->isValid()) {
                                    $path = public_path('images/products/image');
                                    if (!file_exists($path)) {
                                        mkdir($path, 0777, true);
                                    }
                        
                                    $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-.]/', '_', $file->getClientOriginalName());
                        
                                    try {
                                        $file->move($path, $filename);
                        
                                        $productimage = new ProductImages();
                                        $productimage->product_id = $product->id;
                                        $productimage->sku_id = $skuData->id;
                                        $productimage->image = $filename;
                                        $productimage->created_at = now();
                                        $productimage->updated_at = now();
                                        $productimage->save();
                                    } catch (\Exception $e) {
                                        // Handle error
                                        return back()->with('error', 'Failed to upload ' . $file->getClientOriginalName() . ': ' . $e->getMessage());
                                    }
                        
                                } else {
                                    return back()->with('error', 'Invalid file: ' . $file->getClientOriginalName());
                                }
                            }
                        }
				}
				else
				{

						$del_sku=SkuValues::where('product_id',$request->sku_productId)->get();
						if($del_sku)
						{
							foreach($del_sku as $row)
							{
								$row->delete();
							}
						}
						$data=Sku::where('product_id',$request->sku_productId)->first();
		
						$data->product_id=$request->sku_productId;
						$data->sku=$request->product_sku;
						$data->price=$request->product_price;
						$data->quantity=$request->product_quantity;
						$data->special_price=$request->product_sp_price;
						$data->stock_status=$request->product_stock_status;
						$data->combination_id=$cmb_val->id;
						$data->combination_set=$cmb_val->combination;
						$data->save();
						$variant_options=VariantOptions::where('product_id',$product->id)->get();
					
 
						foreach($variant_options as $row)
						{
							$sk_val=new SkuValues();
							$sk_val->sku_id=$data->id;
							$sk_val->product_id=$data->product_id;
							$sk_val->variant_id=$row->variant_id;
							$sk_val->variant_option_id=$row->id;
							$sk_val->save();
						}
						
						if ($request->hasFile('product_image')) {
                            foreach ($request->file('product_image') as $file) {
                                if ($file->isValid()) {
                                    $path = public_path('images/products/image');
                                    if (!file_exists($path)) {
                                        mkdir($path, 0777, true);
                                    }
                        
                                    $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-.]/', '_', $file->getClientOriginalName());
                        
                                    try {
                                        $file->move($path, $filename);
                        
                                        $productimage = new ProductImages();
                                        $productimage->product_id = $product->id;
                                        $productimage->sku_id = $data->id;
                                        $productimage->image = $filename;
                                        $productimage->created_at = now();
                                        $productimage->updated_at = now();
                                        $productimage->save();
                                    } catch (\Exception $e) {
                                        // Handle error
                                        return back()->with('error', 'Failed to upload ' . $file->getClientOriginalName() . ': ' . $e->getMessage());
                                    }
                        
                                } else {
                                    return back()->with('error', 'Invalid file: ' . $file->getClientOriginalName());
                                }
                            }
                        }
						
				}
			
		
			}
			
			
			if($product->type=='variant')
			{
			    
			    
				$cmb_val=Combination::where('product_id',$request->sku_productId)->get();
				for($i=0;$i<count($request['sku_id']);$i++)
				{

					$data=Sku::find($request['sku_id'][$i]);
					//if(($data->sku != '') && ($data->price !=''))
					//{
						$data->product_id=$request->sku_productId;
						$data->sku=$request['v_sku'][$i];
						$data->price=$request['v_price'][$i];
						$data->quantity=$request['v_quantity'][$i];
						$data->special_price=$request['v_spprice'][$i];
						$data->discount=$request['v_discount'][$i];
						$data->stock_status=$request['v_stock_status'][$i];
						$data->combination_id=$request['v_cmb_id'][$i];
						$data->combination_set=$request['v_cmb_set'][$i];
						$data->save();

					//}
				       if ($request->hasFile('v_image') && isset($request->file('v_image')[$i])) 
				       {
                            $file = $request->file('v_image')[$i];
                            if ($file->isValid()) 
                            {
                                $path = public_path('images/products/image');
                                if (!file_exists($path)) 
                                {
                                    mkdir($path, 0777, true);
                                }
                        
                                $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-.]/', '_', $file->getClientOriginalName());
                        
                                try 
                                {
                                    $file->move($path, $filename);
                        
                                    $productimage = new ProductImages();
                                    $productimage->product_id = $product->id;
                                    $productimage->sku_id = $data->id;
                                    $productimage->image = $filename;
                                    $productimage->created_at = now();
                                    $productimage->updated_at = now();
                                    $productimage->save();
                                } 
                                catch (\Exception $e) 
                                {
                                    return back()->with('error', 'Failed to upload ' . $file->getClientOriginalName() . ': ' . $e->getMessage());
                                }
                            } 
                            
                            else 
                            {
                                return back()->with('error', 'Invalid file: ' . $file->getClientOriginalName());
                            }
                        }

			    }
		
    			$up_sku=Sku::where('product_id',$request->sku_productId)->get();
    			foreach($up_sku as $row)
    			{
    				$row->is_default='no';
    				$row->save();
    			}
    				$is_default_update=Sku::where('product_id',$product->id)->first();
    				if($is_default_update)
    				{
    					$is_default_update->is_default='yes';
    					$is_default_update->save();
    				}
            	$product->is_finished='yes';
        		$product->save();
    			//session_start();
    			if(Session::has('e_product'))
    			{
    
    				session()->forget('e_product');
    			}
    			
    			session()->forget('session_id');
    			
    			return response()->json(['data'=>'Product Added Successfully','success'=>true]);

		    }


	        
		}
	    
	}
	
	
	public function show($id)
	{
		$product=Product::with('variants','variantsOptions','skuNew','skuNew.sku_values','badge')->find($id);

		// echo "<pre>";
		// print_r($product);
		// exit;
		$category=Category::where('status','yes')->get();
		$reviews=Review::where('product_id',$product->id)->where('is_approved','yes')->orderby('created_at','DESC')->limit(10)->get();
		$review_count=Review::where('product_id',$product->id)->where('is_approved','yes')->count();
		$review5=Review::where('rating','5')->where('is_approved','yes')->where('product_id',$product->id)->count();
		$review4=Review::where('rating','4')->where('is_approved','yes')->where('product_id',$product->id)->count();
		$review3=Review::where('rating','3')->where('is_approved','yes')->where('product_id',$product->id)->count();
		$review2=Review::where('rating','2')->where('is_approved','yes')->where('product_id',$product->id)->count();
		$review1=Review::where('rating','1')->where('is_approved','yes')->where('product_id',$product->id)->count();
        $averageRating = Review::where('product_id', $product->id)
        ->where('is_approved', 'yes')
        ->avg('rating');
		return view('admin.product.view',[
			'product'=>$product,
			'reviews'=>$reviews,
			'review_count'=>$review_count,
            'averageRating' => $averageRating,
			'review4'=>$review4,
			'review5'=>$review5,
			'review3'=>$review3,
			'review2'=>$review2,
			'review1'=>$review1,
		]);
		
       
      
      
	}


	public function productView(Request $request)
	{

		$data=Product::with('variants','variantsOptions','sku','sku.sku_values','badge')->find($request->id);
		$category=Category::where('status','yes')->get();
		
	
		$view=view('admin.product.view',[
			'data'=>$data,
			'category'=>$category
		]);
		echo $view;

	}


	public function edit($id)
	{
		$data=Product::find($id);
		$category=Category::get();
		$badge=Badge::get();
		$attributes=Attributes::get();
		
		/*$selectedProductgroups=ProductGroup::where('product_id',$data->id)->get()->pluck('group_id')->toArray();
		$productgroups=Groups::get();*/
		
		$variantData=Variants::where('product_id',$id)->get();
		$var_count=$variantsData=Variants::where('product_id',$id)->count();
		$variantOptionData=VariantOptions::where('product_id',$id)->get();
		$var_option_count=VariantOptions::where('product_id',$id)->count();
		// echo "<pre>";
		// print_r($productgroups->toArray());
		// exit;
		return view('admin.product.update',[
			'data'=>$data,
			'category'=>$category,
			'badge'=>$badge,
			'attributes'=>$attributes,
			'variantData'=>$variantData,
			'variantOptionData'=>$variantOptionData,
			'var_count'=>$var_count,
			'var_option_count'=>$var_option_count,
			/*'productgroups' =>$productgroups,
			'selectedProductgroups'=>$selectedProductgroups*/
		]);
	}


	//for updating products
	public function validateUpdateData(Request $request)
	{
		// dd($request);
		if($request->val_set=='set1')
		{
			$array=[
			'category'=>'required',
			'product_name'=>'required',
			'brand'=>'required',
			'description'=>'required',
			'short_description'=>'required',
			'add_badge_status'=>'required'
		    ];
		    $validator = Validator::make($request->all(),$array);
			 if ($validator->fails())
			 {    
				return response()->json(['result'=>false,'message' => $validator->messages()], 200);
			 }else{
			 	return response()->json(['result'=>true], 200);
			 }
		}

		if($request->val_set=='set2')
		{
	
			$type=$request->type_edit;
			if($type=='simple')
			{
				$array=[
				/*'simple_attributes'=>'required|array|min:1',
				'attribute_option'=>'required|array|min:1',
				'simple_attributes.*'=>'required',
				'attrbute_option.*'=>'required'*/
			    ];
			}
			if($type=='variant')
			{
				$array=[
				/*'attributes'=>"required|array|min:1",
            	'option_value'=>"required|array|min:1",
            	'attributes.*'=>'required',
            	'option_value.*'=>'required',*/
			    ];
			}
		    $validator = Validator::make($request->all(),$array);
			 if ($validator->fails())
			 {    
				return response()->json(['result'=>false,'message' => $validator->messages()], 200);
			 }else{
			 	return response()->json(['result'=>true], 200);
			 }
		}

		if($request->val_set=='set3')
		{
		 
			if($request->pro_type=='simple')
			{
				// dd($request->product_skuid);
				$array=[
				'product_sku'=>'required|unique:sku,sku,'.$request->product_skuid,
				'product_price'=>'required',
				'product_quantity'=>'required',
			    ];
				

			 
			}
			if($request->pro_type=='variant')
			{
				$array=[
				'v_sku'=>'required|array|min:1',
				'v_price'=>'required|array|min:1',
				'v_quantity'=>'required|array|min:1',
				'v_stock_status'=>'required|array|min:1',
				// 'v_spprice'=>'required|array|min:1',
				'v_sku.*'=>'required',
				'v_price.*'=>'required',
				'v_quantity.*'=>'required',
				'v_stock_status.*'=>'required',
				// 'v_spprice.*'=>'required'
			    ];

			
			}

             $validator = Validator::make($request->all(),$array);
				 if ($validator->fails())
				 {    
					return response()->json(['result'=>false,'message' => $validator->messages()], 200);
				 }else{
				 	return response()->json(['result'=>true], 200);
				 }


             
		}
		

	}


	public function generalFormUpdate(Request $request)
	{
	
					
		$model= Product::find($request->product_row_id);
		if($model->product_name != $request->product_name)
		{
			$model->slug=Str::slug($request->product_name);
		}
		$model->product_name=$request->input('product_name');
		$model->brand=$request->input('brand');
		$model->add_badge_status=$request->input('add_badge_status');
		if($request->add_badge_status=='yes')
		{
			$model->badge_id=$request->input('badge');
		}else{
			$model->badge_id=Null;

		}
		$model->category_id=$request->category;
		$model->meta_description=$request->input('meta_description');
		$model->description=$request->input('description');
		$model->short_description=$request->input('short_description');

		$model->updated_by=\Auth::user()->id;
		
		$model->updated_at=date('Y-m-d H:i:s');
		$path=public_path().'/images/product';

        if($files=$request->file('image1'))
        {
        	$time = date("Y-m-d")."-".time() ;
        	$name=$time.'-'.str_replace(' ','',$files->getClientOriginalName());
        	$files->move($path,$name);
        	$model->image1=$name;
        }
        /*
		if($files=$request->file('image2'))
        {
        	$time = date("Y-m-d")."-".time() ;
        	$name=$time.'-'.str_replace(' ','',$files->getClientOriginalName());
        	$files->move($path,$name);
        	$model->image2=$name;
        }
		if($files=$request->file('image3'))
        {
        	$time = date("Y-m-d")."-".time() ;
        	$name=$time.'-'.str_replace(' ','',$files->getClientOriginalName());
        	$files->move($path,$name);
        	$model->image3=$name;
        }
		if($files=$request->file('image4'))
        {
        	$time = date("Y-m-d")."-".time() ;
        	$name=$time.'-'.str_replace(' ','',$files->getClientOriginalName());
        	$files->move($path,$name);
        	$model->image4=$name;
        }
        */
        
		$model->save();
		/*
		if($model->id){
		    if($request->has('selected_group') && !empty($request->selected_group))
		    {
		       ProductGroup::where('product_id',$model->id)->delete();
    			foreach ($request->input('selected_group') as $group) {
                    $productGroup = new ProductGroup();
                    $productGroup->product_id = $model->id;
                    $productGroup->group_id = $group;
                    $productGroup->created_at = now();
                    $productGroup->updated_at = now();
                    $productGroup->save();
                } 
		    }
			

		}
		*/
		$variantData=Variants::where('product_id',$model->id)->get();
		$var_count=$variantsData=Variants::where('product_id',$model->id)->count();
		$variantOptionData=VariantOptions::where('product_id',$model->id)->get();
		$var_option_count=VariantOptions::where('product_id',$model->id)->count();

		return response()->json(['data'=>'Saved','productId'=>$model->id,'variantData'=>$variantData,'var_count'=>$var_count,'variantOptionData'=>$variantOptionData,'var_option_count'=>$var_option_count,'success'=>true]);
		
	}


	
	//new 
	public function variantFormUpdateSubmit(Request $request)
	{
	
		$type=$request->type_edit;
		$product=Product::find($request->product_id);
			
		$product->type=$type;
			
			if($product->save())
			{

				//For inserting data to Variants table
				if($type=='simple')
				{
			
						if(($request['s_attr_edit_set'][0]!='') || ($request['s_attr_opt_edit_set'][0]!=''))
						{
							$new_options=VariantOptions::where('product_id',$product->id)->get();
							$new_s_option_idarray=[];
							if($new_options)
							{	
								foreach($new_options as $row)
								{
									array_push($new_s_option_idarray,$row->id);
								}
								$del_opt=VariantOptions::whereIn('id',$new_s_option_idarray)->delete();
							}
							$new_variant=Variants::where('product_id',$product->id)->get();
							$new_s_variant_idarray=[];
							if($new_variant)
							{
								foreach($new_variant as $row)
								{
									array_push($new_s_variant_idarray,$row->id);
								}
								$del=Variants::whereIn('id',$new_s_variant_idarray)->delete();
							}

							for($i=0;$i<count($request['simple_attributes_edit']);$i++)
							{ 
							$attribute=Attributes::find($request['simple_attributes_edit'][$i]);

							$variant= new Variants();
							$variant->product_id=$request->product_id;
							$variant->attribute_name=$attribute->attribute_name;
							
								if($variant->save())
								{
									$option_add=new VariantOptions();
									$option_add->product_id=$request->product_id;
									$option_add->variant_id=$variant->id;
									$option_add->option_name=\App\Models\AttributeOptions::getAttributeOptionName($request->attribute_option_edit[$i]);
									$option_add->save();


								}

							}
							

						}
							if($request->has('simple_attributes'))
							{

								for($i=0;$i<count($request['simple_attributes']);$i++)
								{ 
								$attribute=Attributes::find($request['simple_attributes'][$i]);

								$variant= new Variants();
								$variant->product_id=$request->product_id;
								$variant->attribute_name=$attribute->attribute_name;
								
									if($variant->save())
									{
										$option_add=new VariantOptions();
										$option_add->product_id=$request->product_id;
										$option_add->variant_id=$variant->id;
										$option_add->option_name=\App\Models\AttributeOptions::getAttributeOptionName($request->attribute_option[$i]);
										$option_add->save();


									}

								}
							}



				$v_option=VariantOptions::select('variant_id')->where('product_id',$product->id)->groupby('variant_id')->get();
				$variant_array=[];
				$set1=[];$set2=[];$set3=[];$set4=[];$set5=[];$set6=[];
				$set_id1=[];$set_id2=[];$set_id3=[];$set_id4=[];$set_id5=[];$set_id6=[];

				foreach($v_option as $row)
				{
					array_push($variant_array,$row->variant_id);
				}
					for($i=0;$i<count($variant_array);$i++)
					{
						$set=VariantOptions::where('variant_id',$variant_array[$i])->get();
						foreach($set as $row)
						{
							if($i==0)
							{
								array_push($set1,$row->option_name);
								array_push($set_id1,$row->id);

							}else if($i==1)
							{
								array_push($set2,$row->option_name);
								array_push($set_id2,$row->id);
							}
							else if($i==2)
							{
								array_push($set3,$row->option_name);
								array_push($set_id3,$row->id);
							}
							else if($i==3)
							{
								array_push($set4,$row->option_name);
								array_push($set_id4,$row->id);
							}
							else if($i==4)
							{
								array_push($set5,$row->option_name);
								array_push($set_id5,$row->id);
							}
							else if($i==5)
							{
								array_push($set6,$row->option_name);
								array_push($set_id6,$row->id);
							}
						}

					}

						$input = [$set1,$set2,$set3,$set4,$set5,$set6];
						$input_set_id = [$set_id1,$set_id2,$set_id3,$set_id4,$set_id5,$set_id6];
						$combination_array=\App\Helper\Helper::cartesian($input);
						$comb_id_array=\App\Helper\Helper::cartesian($input_set_id);
				
						if(count($combination_array)>0)
						{	
							if(($request['s_attr_edit_set'][0]!='') || ($request['s_attr_opt_edit_set'][0]!='') || $request->has('simple_attributes'))
							{

								$cmb_products=Combination::where('product_id',$product->id)->get();
								$cmb_row_id=[];
								if($cmb_products)
								{	
									foreach($cmb_products as $row)
									{
										array_push($cmb_row_id,$row->id);

									}
									$del_cmbprod=Combination::whereIn('id',$cmb_row_id)->delete();
								}
								for($i=0;$i<count($combination_array);$i++){
									$cmb_set=new Combination();
									$cmb_set->product_id=$product->id;
									$cmb_set->product_id=$product->id;
									$cmb_set->combination=implode('-',$combination_array[$i]);
									$cmb_set->var_option_id=implode('-',$comb_id_array[$i]);
									$cmb_set->save();							

								}
							
								$cm_new=Combination::where('product_id',$product->id)->first();
								$sku_new=Sku::where('product_id',$product->id)->first();
								if($sku_new)
								{
									$sku_new->combination_set=$cm_new->combination;
									$sku_new->combination_id=$cm_new->id;
									$sku_new->save();
								}else{
									$sku_new=new Sku();
									$sku_new->product_id=$product->id;
									$sku_new->combination_set=$cm_new->combination;
									$sku_new->combination_id=$cm_new->id;
									$sku_new->save();

								}

							
								$sk_val_id=[];
								$variant_options_new=VariantOptions::where('product_id',$product->id)->get();
										
				

								foreach($variant_options_new as $row)
								{
									
									$sk_val=SkuValues::where('product_id',$product->id)->where('variant_option_id',$row->id)->where('variant_id',$row->variant_id)->where('sku_id',$sku_new->id)->first();
									if($sk_val){
										$sk_val->sku_id=$sku_new->id;
										$sk_val->product_id=$sku_new->product_id;
										$sk_val->variant_id=$row->variant_id;
										$sk_val->variant_option_id=$row->id;
										$sk_val->save();
										array_push($sk_val_id,$sk_val->id);
									}else{
										$sk_new=new SkuValues();
										$sk_new->sku_id=$sku_new->id;
										$sk_new->product_id=$sku_new->product_id;
										$sk_new->variant_id=$row->variant_id;
										$sk_new->variant_option_id=$row->id;
										$sk_new->save();
										array_push($sk_val_id,$sk_new->id);
									}
									
									
								}
								$sk_new_val=SkuValues::where('product_id',$product->id)->whereNotIn('id',$sk_val_id)->delete();

							}
							//else{

								$combination_set=Combination::where('product_id',$request->product_id)->get();
								$skus=Sku::where('product_id',$product->id)->first();
						
							//}
						}
					

				}
				if($type=='variant')
				{
					
						if(($request['v_attr_edit_set'][0]!='') || ($request['v_attr_opt_edit_set'][0]!=''))
						{
							$new_options=VariantOptions::where('product_id',$product->id)->get();
							$new_option_idarray=[];

							if($new_options)								
							{
								foreach($new_options as $row)
								{
									array_push($new_option_idarray,$row->id);
								}
								$del_opt=VariantOptions::whereIn('id',$new_option_idarray)->delete();
							}
							$new_variant=Variants::where('product_id',$product->id)->get();
							$new_variant_idarray=[];
							if($new_variant)
							{
								foreach($new_variant as $row)
								{
									array_push($new_variant_idarray,$row->id);
								}
								$del_vars=Variants::whereIn('id',$new_variant_idarray)->delete();
							}
							if($request->has('attributes_edit'))
							{
								for($i=0;$i<count($request['attributes_edit']);$i++)
								{ 
							
							
									$attribute=Attributes::find($request['attributes_edit'][$i]);

									$variant= new Variants();
									$variant->product_id=$request->product_id;
									$variant->attribute_name=$attribute->attribute_name;
									
									if($variant->save())
										{
											for($j=0;$j<count($request['option_value_edit']);$j++)
											{
												$explodearray=explode('_',$request->option_value_edit[$j]);
											
												if(($explodearray[0])== $request['attributes_edit'][$i])
												{
												
													$option_add=new VariantOptions();
													$option_add->product_id=$request->product_id;
													$option_add->variant_id=$variant->id;
													$option_add->option_name=\App\Models\AttributeOptions::getAttributeOptionName($explodearray[1]);
													$option_add->save();

												}
								
											}

										}
									
								}
							}
						}
						if($request->has('attributes'))
						{
						     $request->validate([
                                'attributes' => 'required|array|min:1',
                                'attributes.*' => 'required',
                                'option_value' => 'required|array|min:1',
                                'option_value.*' => 'required',
                            ], [
                                'attributes.required' => 'Please select at least one attribute.',
                                'attributes.*.required' => 'new attribute must be selected.if not remove  ',
                                
                                'option_value.required' => 'Please select at least one option.',
                                'option_value.*.required' => 'new attribute must be selected.if not remove.',
                            ]);

                           
							for($i=0;$i<count($request['attributes']);$i++)
							{ 
			
						
								$attribute=Attributes::find($request['attributes'][$i]);

								$variant= new Variants();
								$variant->product_id=$request->product_id;
								$variant->attribute_name=$attribute->attribute_name;
								
								if($variant->save())
								{
										for($j=0;$j<count($request['option_value']);$j++)
										{
											$explodearray=explode('_',$request->option_value[$j]);
									
											if(($explodearray[0])== $request['attributes'][$i])
											{
											
												$option_add=new VariantOptions();
												$option_add->product_id=$request->product_id;
												$option_add->variant_id=$variant->id;
												$option_add->option_name=\App\Models\AttributeOptions::getAttributeOptionName($explodearray[1]);
												$option_add->save();

											}
								
										}

								}
								
							}
						}
						

				


    				$v_option=VariantOptions::select('variant_id')->where('product_id',$product->id)->groupby('variant_id')->get();
    				$variant_array=[];
    				$set1=[];$set2=[];$set3=[];$set4=[];$set5=[];$set6=[];
    				$set_id1=[];$set_id2=[];$set_id3=[];$set_id4=[];$set_id5=[];$set_id6=[];
    
        				foreach($v_option as $row)
        				{
        					array_push($variant_array,$row->variant_id);
        				}
        				
    					for($i=0;$i<count($variant_array);$i++)
    					{
    						$set=VariantOptions::where('variant_id',$variant_array[$i])->get();
    						foreach($set as $row)
    						{
    							if($i==0)
    							{
    								array_push($set1,$row->option_name);
    								array_push($set_id1,$row->id);
    
    							}else if($i==1)
    							{
    								array_push($set2,$row->option_name);
    								array_push($set_id2,$row->id);
    							}
    							else if($i==2)
    							{
    								array_push($set3,$row->option_name);
    								array_push($set_id3,$row->id);
    							}
    							else if($i==3)
    							{
    								array_push($set4,$row->option_name);
    								array_push($set_id4,$row->id);
    							}
    							else if($i==4)
    							{
    								array_push($set5,$row->option_name);
    								array_push($set_id5,$row->id);
    							}
    							else if($i==5)
    							{
    								array_push($set6,$row->option_name);
    								array_push($set_id6,$row->id);
    							}
    						}
    
    					}
    
    					$input = [$set1,$set2,$set3,$set4,$set5,$set6];
    					$input_set_id = [$set_id1,$set_id2,$set_id3,$set_id4,$set_id5,$set_id6];
    					$combination_array=\App\Helper\Helper::cartesian($input);
    					$comb_id_array=\App\Helper\Helper::cartesian($input_set_id);
    					if(count($combination_array)>0)
    					{	
    						if(($request['v_attr_edit_set'][0] !='') || ($request['v_attr_opt_edit_set'][0] !='') || ($request->has('attributes')))
    						{
    							$cmb_products=Combination::where('product_id',$product->id)->get();
    							$cmb_row_id=[];
    							if($cmb_products)
    							{	
    								foreach($cmb_products as $row)
    								{
    									array_push($cmb_row_id,$row->id);
    
    								}
    								$del_cmbprod=Combination::whereIn('id',$cmb_row_id)->delete();
    							}
    							for($i=0;$i<count($combination_array);$i++){
    								$cmb_set=new Combination();
    								$cmb_set->product_id=$product->id;
    								$cmb_set->combination=implode('-',$combination_array[$i]);
    								$cmb_set->var_option_id=implode('-',$comb_id_array[$i]);
    								$cmb_set->save();							
    
    							}
    
    						
    					
    							$new_cmb=Combination::where('product_id',$product->id)->get();
    						
    							$sk_new_array=[];
    							$var_option_cmb_set=[];
    							$v_sk_val_id=[];
    							for($i=0;$i<count($new_cmb);$i++)
    							{
    								$sk_newCount=Sku::where('combination_set',$new_cmb[$i]->combination)->where('product_id',$product->id)->count();
    								if($sk_newCount>0)
    								{
    									$sk_new=Sku::where('combination_set',$new_cmb[$i]->combination)->where('product_id',$product->id)->first();
    									//print_r($sk_new);
    									$sk_new->product_id=$product->id;
    									$sk_new->combination_set=$new_cmb[$i]->combination;
    									$sk_new->combination_id=$new_cmb[$i]->id;
    									$sk_new->save();
    									array_push($sk_new_array,$sk_new->id);
    									$var_option_cmb_set=explode('-',$new_cmb[$i]->var_option_id);
    							
    									if($var_option_cmb_set)
    									{
    										for($k=0;$k<count($var_option_cmb_set);$k++)
    										{//echo $var_option_cmb_set[$k];
    											$opt_new_set1=VariantOptions::find($var_option_cmb_set[$k]);
    											//print_r($opt_new_set1);
    												$sk_val=new SkuValues();
    												$sk_val->product_id=$product->id;
    												$sk_val->sku_id=$sk_new->id;
    												$sk_val->variant_id=$opt_new_set1->variant_id;
    												$sk_val->variant_option_id=$opt_new_set1->id;
    												$sk_val->save();
    												array_push($v_sk_val_id,$sk_val->id);
    											
    										}
    
    									}
    									unset($var_option_cmb_set);
    								}else{
    									$sk_new= new Sku();
    									$sk_new->product_id=$product->id;
    									$sk_new->combination_set=$new_cmb[$i]->combination;
    									$sk_new->combination_id=$new_cmb[$i]->id;
    									$sk_new->save();
    									array_push($sk_new_array,$sk_new->id);
    									$var_option_cmb_set=explode('-',$new_cmb[$i]->var_option_id);
    									if($var_option_cmb_set)
    									{
    										for($k=0;$k<count($var_option_cmb_set);$k++)
    										{
    											$opt_new_set=VariantOptions::find($var_option_cmb_set[$k]);
    										
    											
    												$sk_val=new SkuValues();
    												$sk_val->product_id=$product->id;
    												$sk_val->sku_id=$sk_new->id;
    												$sk_val->variant_id=$opt_new_set->variant_id;
    												$sk_val->variant_option_id=$opt_new_set->id;
    												$sk_val->save();
    												array_push($v_sk_val_id,$sk_val->id);
    											
    										}
    									}
    									unset($var_option_cmb_set);
    								}
    
    							}
    						//print_r($sk_new_array);exit;
    							$delete_oldsku=Sku::where('product_id',$product->id)->whereNotin('id',$sk_new_array)->delete();
    							$sk_new_val=SkuValues::where('product_id',$product->id)->whereNotIn('id',$v_sk_val_id)->delete();
    							// $v_sku_new=Sku::where('product_id',$product->id)->get();
    							// $sk_val_id=[];
    							// $variant_options_new=VariantOptions::where('product_id',$product->id)->get();
    									
    							
    
    
    						}
    						//else{
    							$combination_set=Combination::where('product_id',$product->id)->get();
    							$skus=Sku::where('product_id',$product->id)->get();
    
    						//}
    					}

				}
				

				

					
				$variant_options=VariantOptions::where('product_id',$request->product_id)->get();

				$variantSet=Variants::where('product_id',$request->product_id)->get();
				$new_variant_id=[];
				foreach($variantSet as $row)
				{
					array_push($new_variant_id,$row->id);
				}

				$combination_set=Combination::where('product_id',$request->product_id)->get();
					
				$up_sku=Sku::where('product_id',$product->id)->get();
				foreach($up_sku as $row)
				{
					$row->is_default='no';
					$row->save();
				}
				$is_default_update=Sku::where('product_id',$product->id)->first();
				if($is_default_update)
				{
					$is_default_update->is_default='yes';
					$is_default_update->save();
				}
		
				return response()->json(['data'=>'Variants Saved','productId'=>$request->product_id,'variant_options'=>$variant_options,'variantSet'=>$variantSet,'product_type'=>$product->type,'combination_set'=>$combination_set,'new_variant_id'=>$new_variant_id,'skus'=>$skus,'success'=>true]);
			

			}


		
		

	}



	public function skuFormUpdate(Request $request)
	{
		// dd($request->all());
		$product=Product::find($request->sku_productId);
		if($product)
		{
			if($product->type=='simple')
			{
				$cmb_val=Combination::where('product_id',$request->sku_productId)->first();
				$skuData=Sku::where('product_id',$request->sku_productId)->first();

				if(($cmb_val->combination == $skuData->combination_set) && $skuData->sku !='')
				{
		
						$skuData->product_id=$request->sku_productId;
						$skuData->sku=$request->product_sku;
						$skuData->price=$request->product_price;
						$skuData->quantity=$request->product_quantity;
						$skuData->special_price=$request->product_sp_price;
						$skuData->discount=$request->discount;
						$skuData->stock_status=$request->product_stock_status;
						$skuData->updated_at=date('Y-m-d H:i:s');
						$skuData->save();
						
						// Delete old images first
                        $oldImages = ProductImages::where('product_id', $skuData->product_id)->where('sku_id', $skuData->id)->get();
                        
                        foreach ($oldImages as $oldImage) {
                            $oldImagePath = public_path('images/products/image/' . $oldImage->image);
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath); // delete file from folder
                            }
                            $oldImage->delete(); // delete record from database
                        }
                        
                        // Now upload new images
                        if ($request->hasFile('product_image')) {
                            foreach ($request->file('product_image') as $file) {
                                if ($file->isValid()) {
                                    $path = public_path('images/products/image');
                                    if (!file_exists($path)) {
                                        mkdir($path, 0777, true);
                                    }
                        
                                    $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-.]/', '_', $file->getClientOriginalName());
                        
                                    try {
                                        $file->move($path, $filename);
                        
                                        $productimage = new ProductImages();
                                        $productimage->product_id =$skuData->product_id;
                                        $productimage->sku_id = $skuData->id;
                                        $productimage->image = $filename;
                                        $productimage->updated_at = now();
                                        $productimage->save();
                                    } catch (\Exception $e) {
                                        return back()->with('error', 'Failed to upload ' . $file->getClientOriginalName() . ': ' . $e->getMessage());
                                    }
                        
                                } else {
                                    return back()->with('error', 'Invalid file: ' . $file->getClientOriginalName());
                                }
                            }
                        }

				}
				else
				{

						$del_sku=SkuValues::where('product_id',$request->sku_productId)->get();
						if($del_sku)
						{
							foreach($del_sku as $row)
							{
								$row->delete();
							}
						}
						$data=Sku::where('product_id',$request->sku_productId)->first();
					
						$data->product_id=$request->sku_productId;
						$data->sku=$request->product_sku;
						$data->price=$request->product_price;
						$data->quantity=$request->product_quantity;
						$data->special_price=$request->product_sp_price;
						$data->discount=$request->discount;
						$data->stock_status=$request->product_stock_status;
						$data->combination_id=$cmb_val->id;
						$data->combination_set=$cmb_val->combination;
						$data->save();
						
						$variant_options=VariantOptions::where('product_id',$product->id)->get();
				

						foreach($variant_options as $row)
						{
							$sk_val=new SkuValues();
							$sk_val->sku_id=$data->id;
							$sk_val->product_id=$data->product_id;
							$sk_val->variant_id=$row->variant_id;
							$sk_val->variant_option_id=$row->id;
							$sk_val->save();
						}
						
						
					    $oldImages = ProductImages::where('product_id',$data->product_id)->where('sku_id',$data->id)->get();
                        
                        foreach ($oldImages as $oldImage) {
                            $oldImagePath = public_path('images/products/image/' . $oldImage->image);
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath); // delete file from folder
                            }
                            $oldImage->delete(); // delete record from database
                        }
                        
                        // Now upload new images
                        if ($request->hasFile('product_image')) {
                            foreach ($request->file('product_image') as $file) {
                                if ($file->isValid()) {
                                    $path = public_path('images/products/image');
                                    if (!file_exists($path)) {
                                        mkdir($path, 0777, true);
                                    }
                        
                                    $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-.]/', '_', $file->getClientOriginalName());
                        
                                    try {
                                        $file->move($path, $filename);
                        
                                        $productimage = new ProductImages();
                                        $productimage->product_id = $data->product_id;
                                        $productimage->sku_id = $data->id;
                                        $productimage->image = $filename;
                                        $productimage->save();
                                    } catch (\Exception $e) {
                                        return back()->with('error', 'Failed to upload ' . $file->getClientOriginalName() . ': ' . $e->getMessage());
                                    }
                        
                                } else {
                                    return back()->with('error', 'Invalid file: ' . $file->getClientOriginalName());
                                }
                            }
                        }
				}
				
			
			}
			
			if($product->type=='variant')
			{
				$cmb_val=Combination::where('product_id',$request->sku_productId)->get();
				for($i=0;$i<count($request['sku_id']);$i++)
				{

					$data=Sku::find($request['sku_id'][$i]);
					//if(($data->sku != '') && ($data->price !=''))
					//{
						$data->product_id=$request->sku_productId;
						$data->sku=$request['v_sku'][$i];
						$data->price=$request['v_price'][$i];
						$data->quantity=$request['v_quantity'][$i];
						$data->special_price=$request['v_spprice'][$i];
						$data->discount=$request['v_discount'][$i];
						$data->stock_status=$request['v_stock_status'][$i];
						$data->combination_id=$request['v_cmb_id'][$i];
						$data->combination_set=$request['v_cmb_set'][$i];
						$data->save();

					//}
					
					    
                        // Now upload new images
                        /*if ($request->hasFile('v_image')) {
                            
                                $oldImages = ProductImages::where('product_id', $data->product_id)->where('sku_id',$data->id)->get();
                        
                                foreach ($oldImages as $oldImage) {
                                    $oldImagePath = public_path('images/products/image/' . $oldImage->image);
                                    if (file_exists($oldImagePath)) {
                                        unlink($oldImagePath); // delete file from folder
                                    }
                                    $oldImage->delete(); // delete record from database
                                }
                        
                            foreach ($request->file('v_image') as $file) {
                                if ($file->isValid()) {
                                    $path = public_path('images/products/image');
                                    if (!file_exists($path)) {
                                        mkdir($path, 0777, true);
                                    }
                        
                                    $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-.]/', '_', $file->getClientOriginalName());
                        
                                    try {
                                        $file->move($path, $filename);
                        
                                        $productimage = new ProductImages();
                                        $productimage->product_id = $data->product_id;
                                        $productimage->sku_id = $data->id;
                                        $productimage->image = $filename;
                                        $productimage->save();
                                    } catch (\Exception $e) {
                                        return back()->with('error', 'Failed to upload ' . $file->getClientOriginalName() . ': ' . $e->getMessage());
                                    }
                        
                                } else {
                                    return back()->with('error', 'Invalid file: ' . $file->getClientOriginalName());
                                }
                            }
                        }*/
                        $imageKey = 'v_image_' . $i;
                        if ($request->hasFile($imageKey)) {
                            // Delete old images
                            $oldImages = ProductImages::where('product_id', $data->product_id)
                                                      ->where('sku_id', $data->id)
                                                      ->get();
                        
                            foreach ($oldImages as $oldImage) {
                                $oldImagePath = public_path('images/products/image/' . $oldImage->image);
                                if (file_exists($oldImagePath)) {
                                    unlink($oldImagePath);
                                }
                                $oldImage->delete();
                            }
                        
                            // Save new images
                            foreach ($request->file($imageKey) as $file) {
                                if ($file->isValid()) {
                                    $path = public_path('images/products/image');
                                    if (!file_exists($path)) {
                                        mkdir($path, 0777, true);
                                    }
                        
                                    $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-.]/', '_', $file->getClientOriginalName());
                        
                                    try {
                                        $file->move($path, $filename);
                        
                                        $productimage = new ProductImages();
                                        $productimage->product_id = $data->product_id;
                                        $productimage->sku_id = $data->id;
                                        $productimage->image = $filename;
                                        $productimage->save();
                                    } catch (\Exception $e) {
                                        return back()->with('error', 'Failed to upload ' . $file->getClientOriginalName() . ': ' . $e->getMessage());
                                    }
                                }
                            }
                        }
				}
				

				
			
			}
		
    			$up_sku=Sku::where('product_id',$request->sku_productId)->get();
    			
    			foreach($up_sku as $row)
    			{
    				$row->is_default='no';
    				$row->save();
    			}
    			
				$is_default_update=Sku::where('product_id',$product->id)->first();
				
				if($is_default_update)
				{
					$is_default_update->is_default='yes';
					$is_default_update->save();
				}

			return response()->json(['data'=>'Product Updated Successfully','success'=>true]);

		}


	}


	public function deleteSimpleAttributes(Request $request)
	{
	    
		$var=Variants::find($request->v_id);
		$product_id=$var->product_id;
		$varopt=VariantOptions::where('product_id',$var->product_id)->where('variant_id',$request->v_id)->first();
		if($varopt)
		{
			$varopt->delete();
			$var->delete();
		}
		$var_cmb=[];
		$var_optid=[];
		$new_varopt=VariantOptions::where('product_id',$product_id)->get();
		if($new_varopt)
		{
			$cmb=Combination::where('product_id',$product_id)->first();
			foreach($new_varopt as $row)
			{
				array_push($var_cmb,$row->option_name);
				array_push($var_optid,$row->id);
			}
			$cmb->var_option_id=implode('-',$var_optid);
			$cmb->combination=implode('-',$var_cmb);
			$cmb->save();
			
		}
		$sku=Sku::where('product_id',$product_id)->where('combination_id',$cmb->id)->first();
		if($sku)
		{
		$sku->combination_set=$cmb->combination;
		$sku->is_default='yes';
		$sku->save();
		}
		$sk_val=SkuValues::where('variant_id',$request->v_id)->get();
		foreach($sk_val as $row)
		{
			$row->delete();
		}
		$variant_options=VariantOptions::where('product_id',$product_id)->get();
				

						foreach($variant_options as $row)
						{
							$sk_val=SkuValues::where('product_id',$product_id)->where('variant_option_id',$row->id)->where('variant_id',$row->variant_id)->where('sku_id',$sku->id)->first();
							if($sk_val){
								$sk_val->sku_id=$sku->id;
							$sk_val->product_id=$sku->product_id;
							$sk_val->variant_id=$row->variant_id;
							$sk_val->variant_option_id=$row->id;
							$sk_val->save();
							}else{
								$sk_new=new SkuValues();
								$sk_new->sku_id=$sku->id;
								$sk_new->product_id=$sku->product_id;
								$sk_new->variant_id=$row->variant_id;
								$sk_new->variant_option_id=$row->id;
								$sk_new->save();
							}
							
							
						}


		echo "deleted";



	}


	public function deleteVariableAttributes(Request $request)
	{
	
		$var=Variants::find($request->v_id);
		$proId=$var->product_id;
		$var_options=VariantOptions::where('variant_id',$var->id)->get();
		$var_opt_id=[];
		foreach($var_options as $row)
		{
			array_push($var_opt_id,$row->id);
		}
		$cmb=Combination::where('product_id',$var->product_id)->get();
		$ex_cmb=[];
		$cmbid=[];
		foreach($cmb as $row){
			$ex_cmb=explode('-',$row->var_option_id);
			for($i=0;$i<count($ex_cmb);$i++)
			{
				
					if(in_array($ex_cmb[$i],$var_opt_id))
					{
						array_push($cmbid,$row->id);
					}
				
			}
		}

		$sku_set=Sku::where('product_id',$var->product_id)->whereIn('combination_id',$cmbid)->get();
		$sk_val=[];
		foreach($sku_set as $row)
		{
			array_push($sk_val,$row->id);
			$row->delete();
		}
		$sku_val=SkuValues::whereIn('sku_id',$sk_val)->delete();
		$cmbn=Combination::whereIn('id',$cmbid)->delete();
		$var_op=VariantOptions::whereIn('id',$var_opt_id)->delete();
		$var=Variants::find($request->v_id)->delete();
	
		echo "deleted";

		$up_sku=Sku::where('product_id',$proId)->get();
		if($up_sku)
		{
				foreach($up_sku as $row)
				{
					$row->is_default='no';
					$row->save();
				}
				$is_default_update=Sku::where('product_id',$proId)->first();
				if($is_default_update)
				{
					$is_default_update->is_default='yes';
					$is_default_update->save();
				}
		}



	}
	
	
	public function checkSku(Request $request)
	{
		$count=Sku::where('sku',$request->this_val)->where('id','!=',$request->sku_rowid)->count();
		if($count==0)
		{
			echo 0;
		}else{
			echo "Sku Exists";
		}
	}



	public function showAttributes(Request $request)
	{
		$data=Attributes::get();
		return response()->json(['data'=>$data]);
	}
	
	
	public function changeNewStatus(Request $request)
	{
		//echo $request->thisId;

		$data=Product::find($request->thisId);
		if($data->is_new=='yes')
		{
			$data->is_new='no';
			$data->save();
			
		}else{
			$data->is_new='yes';
			$data->save();
		
		}
		echo "status changed";exit;
	}
	
	
	public function changeTrendingStatus(Request $request)
	{
		//echo $request->thisId;

		$data=Product::find($request->thisId);
		if($data->is_trending=='yes')
		{
			$data->is_trending='no';
			$data->save();
			
		}else{
			$data->is_trending='yes';
			$data->save();
		
		}
		echo "status changed";exit;
	}


    public function getProductImage(Request $request)
    
    {
        $images = ProductImages::where('sku_id',$request->id)->get();
        return response()->json([
            'html' => view('admin.product.product_images', compact('images'))->render()
        ]);
    }

	
}
?>