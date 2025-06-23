<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use \App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('admin.contacts.index');
    }
   
    public function messageView(Request $request)
    {
        $data = Contact::find($request->id);
        $view = view('admin.contacts.view', [
            'data' => $data,
        ]);
        echo $view;
    }
    
     public function filter(Request $request)
    {

        if ($request->ajax()) {
            $data = Contact::select('contact.*');

            if ($request->has('date_from') && !empty($request->date_from)) {
                $data = $data->whereDate('created_at', '>=', $request->date_from);
            }
            if ($request->has('date_to') && !empty($request->date_to)) {
                $data = $data->whereDate('created_at', '<=', $request->date_to);
            }
            if ($request->has('name') && $request->name != '') {
                $data->where('name', 'like', "%{$request->name}%");
            }
            if ($request->has('phone') && $request->phone != '') {
                $data->where('phone', 'like', "%{$request->phone}%");
            }
            if ($request->has('email') && $request->email != '') {
                $data->where('email', 'like', "%{$request->email}%");
            }

            $data = $data->get();
            return Datatables::of($data)
                ->addColumn('checkbox', function ($data) {
                    return '<div class="form-check">
                       <input class="form-check-input" type="checkbox" name="chk_child" value="' . $data->id . '">
                    </div>';
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '<div class="dropdown d-inline-block">
                  <button class="btn btn-sm btn-soft-info  messageView" type="button" value="' . $data->id . '" >
                   Message
                  </button>

                </div>';
                })
                ->rawColumns(['action', 'checkbox'])
                
                ->make(true);

        }
    }
}
