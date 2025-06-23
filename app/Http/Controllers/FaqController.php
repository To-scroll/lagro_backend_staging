<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Support\Facades\View;
use DataTables;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        return view('admin.faq.index');
    }
    public function filter_faq(Request $request)
    {

        if ($request->ajax()) {
            $data = FaqCategory::select('*');

            if ($request->has('keyword') && !empty($request->keyword)) {
                $data = $data->where('category', 'like', '%' . $request->keyword . '%');
            };
            return Datatables::of($data)
                ->addColumn('checkbox', function ($data) {
                    return '<div class="form-check">
     <input class="form-check-input" type="checkbox" name="chk_child" value="' . $data->id . '">
  </div>';
                })
                ->addIndexColumn()
            // ->addColumn('action',function($data){
            //     $edit=url('general-faq/'.$data->id.'/edit');
            //     return '<button class="btn bg-secondary btn-sm text-white rounded-circle faqViewBtn" type="button" value="'.$data->id.'" data-toggle="modal" data-target="#exampleModalLive"><i class="fa fa-eye"></i></button>&nbsp;<a href="'.$edit.'" class="btn bg-primary btn-sm text-white rounded-circle"><i class="fa fa-pencil"></i></a>
            //         <button class="btn bg-danger btn-sm text-white rounded-circle deleteBtn" type="button" value="'.$data->id.'"><i class="fa fa-trash"></i></button>';

            // })
                ->addColumn('action', function ($data) {
                  /*$view = '<li><a class="dropdown-item faqViewBtn"  data-id="' .$data->id. '"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>';*/
                   $view = '<li><a class="dropdown-item faqView"  data-id="' .$data->id. '"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>';
                    $edit = '<li><a href="' . url('general-faq') . '/' . $data->id . '/edit' . '" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
                    //$invoice=url('download-invoice/'.$data->id);
                    $delete = '<li>
                  <a class="dropdown-item deleteBtn" data-id="' . $data->id . '">
                  <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                  </a>
                </li>';
                    return '<div class="dropdown d-inline-block">
            <button class="btn btn-soft-secondary btn-sm dropdown " type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="ri-more-fill align-middle"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
            ' . $view . '
            ' . $edit . '
            ' . $delete . '

            </ul>
          </div>';
                })
                ->setRowId(function ($data) {
                    return "row_" . $data->id;
                })
                ->rawColumns([ 'action', 'checkbox'])
                ->make(true);

        }
    }
    public function create()
    {
        return view('admin.faq.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'faq-category' => 'required',
            'questions' => 'required|array',
            'answers' => 'required|array',
            'questions.*' => 'required|string',
            'answers.*' => 'required|string',
        ]);

        $data = new FaqCategory();
        $data->category = $request->input('faq-category');
        $data->created_at = now();
        $data->updated_at = now();
        $data->save();
    
        foreach ($request->input('questions') as $index => $question) {
            $model = new Faq();
            $model->question = $question;
            $model->answer = $request->input('answers')[$index];
            $model->faq_category_id = $data->id;
            $model->created_by = auth()->id();
            $model->updated_by = auth()->id();
            $model->created_at = now();
            $model->updated_at = now();
            $model->save();
        }
    
        return response()->json(['message' => 'success']);
    }

    
    
    
    
    public function edit($id)
    {
        
        $data = FaqCategory::find($id);
       
        $faq = Faq::where('faq_category_id',$id)->get(); 
        return view('admin.faq.edit', [
            'data' => $data,
            'faq'=>$faq,
        ]);

    }
    public function update(Request $request)
    {
     
        $request->validate([
            'faq-category' => 'required',
            'questions' => 'required|array',
            'answers' => 'required|array',
            'questions.*' => 'required|string',
            'answers.*' => 'required|string',
        ]);
       
       
       
       
        $data =FaqCategory::find($request->id);
        $data->category = $request->input('faq-category');
        $data->updated_at = now();
        $data->save();
    
        if ($request->has('question_ids')) {
            foreach ($request->question_ids as $index => $qid) {
                $faq = Faq::find($qid);
                if ($faq) {
                    $faq->question = $request->question[$index];
                    $faq->answer = $request->answer[$index];
                    $faq->updated_by = auth()->id();
                    $faq->updated_at = now();
                    $faq->save();
                }
            }
        }

        if ($request->has('questions')) {
            foreach ($request->questions as $index => $q) {
                $faq = new Faq();
                $faq->question = $q;
                $faq->answer = $request->answers[$index];
                $faq->faq_category_id = $data->id;
                $faq->created_by = auth()->id();
                $faq->updated_by = auth()->id();
                $faq->created_at = now();
                $faq->updated_at = now();
                $faq->save();
            }
        }
           
        return response()->json(['message'=>'success']);

    }
    
    
   /* 
    public function faqView(Request $request)
    {
        $data = Faq::find($request->id);
        $view = view('admin.faq.view', [
            'data' => $data]);
        echo $view;
    }
    
    */
    
    
    public function destroy($id)
    {
        // dd($id);
        // $data=Faq::find($request->id)->delete();
        // echo 1;
        $faqquestions=FaqCategory::find($id); 
        $data = Faq::where('faq_category_id',$id)->get();
        
        $faqquestions->delete();
        $data->delete();

    }
    
    public function faqViewPage(Request $request)
    {
    //   dd($id);
        $faqquestions=FaqCategory::find($request->id); 
        $faqs=Faq::where('faq_category_id',$faqquestions->id)->get();
        $faqView = View::make('admin.faq.view', 
        [
            'faqs' => $faqs,
            'faq_category'=>$faqquestions
            
        ]);
       
        echo $faqView;
    }
    
    
    
   
    public function getQuestion(Request $request)
    {
        $data=FaqCategory::get();
        return view('admin.faq.question',[
            'data'=>$data
        ]);
    }
    
    public function deleteQuestion($id)
    {
        $data=Faq::find($id);
        $data->delete();
        
    }



}
