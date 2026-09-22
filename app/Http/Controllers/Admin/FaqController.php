<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Faq;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    public function index()
    {
        $page_title = 'FAQ List';
        return view('admin.faq.list', compact('page_title'));
    }

    public function add($id = null)
    {
        $faq = !empty($id) ? Faq::find($id) : null;

        if ($id && !$faq) {
            return redirect()->route('admin.faq.list')
                ->with('error', 'Record Not Found'); 
        }

        $btn_title = $faq ? 'Update' : 'Submit';
        $page_title = $faq ? 'Update FAQ' : 'Add FAQ';

        return view('admin.faq.add', compact('faq', 'btn_title', 'page_title'));
    }

    public function save(Request $request)
    {
        $id = $request->id;

        $rules = [
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
            'priority' => 'required|integer',
            'status'   => 'required|in:Active,Inactive',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $exists = Faq::where('question', trim($request->question));

    if ($id) {
        $exists->where('id', '!=', $id);
    }

    if ($exists->exists()) { 
        return response()->json([
            'success' => false,
            'message' => 'Faq already exists'
        ], 422);
    } 
 

        $faq = $id ? Faq::find($id) : new Faq();

        $faq->question = trim($request->question);
        $faq->answer   = trim($request->answer);
        $faq->priority = $request->priority;
        $faq->status   = $request->status;

        $faq->save();

        return response()->json(['success' => true,'message' => $id ? 'FAQ Updated Successfully' : 'FAQ Added Successfully']);
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {

            $query = Faq::select(['id', 'question', 'answer', 'priority', 'status'])->orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()

                ->editColumn('answer', function ($row) {
                    return \Str::limit(strip_tags($row->answer), 60);
                })

           

                 // STATUS
            ->editColumn('status', function ($row) {
                if (!auth()->user()->can('faq-add')) {
                    return '<span class="badge bg-' . ($row->status === 'Active' ? 'success' : 'danger') . '">' . $row->status . '</span>';
                }

                $checked = $row->status === 'Active' ? 'checked' : '';
                $statusClass = $row->status === 'Active' ? 'bg-success' : 'bg-danger';

                return '
                    <label class="switch mb-0">
                        <input type="checkbox" class="toggleStatus" data-id="' . $row->id . '" ' . $checked . '>
                        <span class="switch-state ' . $statusClass . '"></span>
                    </label>
                ';
            })


                ->addColumn('action', function ($row) {

                    $editUrl = route('admin.faq.add', $row->id);
                    $btn = '';

                    if (auth()->user()->can('faq-add')) {
                        $btn .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a>';
                    }

                    if (auth()->user()->can('faq-delete')) {
                        $btn .= '<a href="javascript:void(0);" onclick="deleteData(' . $row->id . ')" class="btn btn-sm btn-danger m-1"><i class="fas fa-trash"></i></a>';
                    }

                    return $btn;
                })

                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }

    public function delete(Request $request)
    {
        $faq = Faq::find($request->id);

        if ($faq) {
            $faq->delete();
            return response()->json(['status' => true,'message' => 'Record Deleted Successfully']);
        }

        return response()->json([
            'status' => false,
            'message' => 'Record Not Found'
        ]);
    }

    public function changeStatus(Request $request)
    {
        $faq = Faq::find($request->id);
        if ($faq) {
            $faq->status = $request->status;
            $faq->save();
            return response()->json(['status' => true,'message' => 'Status Updated Successfully']);
        }
        return response()->json(['status' => false,'message' => 'Record Not Found']);
    }
}