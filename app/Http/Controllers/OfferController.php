<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Sku;
use Illuminate\Support\Facades\View;
use DataTables;
use Illuminate\Http\Request;

class OfferController extends Controller
{

    public function index()
    {
        return view('admin.offers.index');

    }

    public function filter_offers(Request $request)
    {
        if ($request->ajax()) {
            $data = Offer::select('*');
            if ($request->has('Offer') && !empty($request->Offer)) {
                $data = $data->where('offer_name', 'like', '%' . $request->Offer . '%');
            };
            return Datatables::of($data)
                ->addColumn('checkbox', function ($data) {
                    return '<div class="form-check">
                       <input class="form-check-input" type="checkbox" name="chk_child" value="' . $data->id . '">
                    </div>';
                })
                ->addIndexColumn()
                ->addColumn('is_apply', function($data) { 
					$test= '<div class="form-check form-switch">
						   <input class="form-check-input apply_status" type="checkbox" value="'.$data->id.'"';
						   if($data->is_apply =='yes')
							{ 
							   $test.='checked=""';
							}
							$test.='> </div>';
						   
						   return $test;
			   })
               
                ->rawColumns([ 'action'])
                ->addColumn('action', function ($data) {
                  $view = '<li><a class="dropdown-item offersViewBtn"  data-id="' .$data->id. '"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>';
                    $edit = '<li><a href="' . url('offers') . '/' . $data->id . '/edit' . '" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
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
                 ->rawColumns(['action', 'checkbox','is_apply'])
                ->make(true);

        }
    }

    public function create()
    {
        return view('admin.offers.create');
    }

    public function store(Request $request)
    {
      
        $request->validate([
            'offer_name' => 'required',
            'offer_limit' => 'required',
            'offer_amount' => 'required',
        ]);
        
       $data=new Offer();
        $data->offer_name = $request->offer_name;
        $data->offer_limit = $request->offer_limit;
        $data->offer_amount = $request->offer_amount;
        $data->created_at = now();
        $data->updated_at = now();
        
        $data->save();
        return response()->json(['message' => 'success']);
    }

    public function edit($id)
    {
        $data = Offer::find($id);
        return view('admin.offers.edit', [
            'data' => $data]);
    }

    public function update(Request $request)
    {
         $request->validate([
            'offer_name' => 'required',
            'offer_limit' => 'required',
            'offer_amount' => 'required',
        ]);
        
        $data=Offer::find($request->id);
        
        $data->offer_name = $request->offer_name;
        $data->offer_limit = $request->offer_limit;
        $data->offer_amount = $request->offer_amount;
       
        $data->created_at = date('Y-m-d H:i:s');
        $data->updated_at = date('Y-m-d H:i:s');
        
        $data->save();
        return response()->json(['message' => 'success']);
    }

    public function offersView(Request $request)
    {
        $data = Offer::find($request->id);
        $view = view('admin.offers.view', [
            'data' => $data,
        ]);
        echo $view;
    }
    
    
    public function destroy(string $id)
    {
        $data = Offer::find($id);
        $data->delete();
       
    }
    
    
    public function offersViewPage(string $id)
    {
      $offer=Offer::find($id);
        //   dd($offer);
        $offer_limit = $offer->offer_limit;
        $skus = Sku::with('sku_images')->get();

            $offer_products = [];
            
            foreach ($skus as $sku) {
                if ($sku->special_price < $sku->price) 
                {
                    if ($sku->special_price <= $offer->offer_limit) 
                    {
                        $offer_products[] = $sku;
                    }
                } 
                else 
                {
                    if ($sku->price <= $offer->offer_limit) 
                    {
                        $offer_products[] = $sku;
                    }
                }
            }

      
      $offersView = View::make('admin.offers.view.view', ['offers' => $offer,'offer_products'=>$offer_products])->render();
      return response()->json(['offersView' => $offersView]);
    }
    
    
    
    public function changeApplyStatus(Request $request)
    {
        $data = Offer::find($request->thisId);
    
        if ($data->is_apply == 'yes') {
            $data->is_apply = 'no';
            $data->save();
            return response()->json(['status' => 'success', 'message' => 'Status changed to NO']);
        } 
        
        else {
            $existing = Offer::where('is_apply', 'yes')->where('id', '!=', $data->id)->first();
    
            if ($existing) 
            {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Only one offer can be set to Apply at a time.'
                ]);
            }
            $data->is_apply = 'yes';
            $data->save();
            return response()->json(['status' => 'success', 'message' => 'Status changed to YES']);
        }
    }


}
