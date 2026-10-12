<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ContactType;
use Illuminate\Support\Facades\Validator;

class ContactTypeController extends Controller
{
    public function index()
    {
        $page_title = 'Contact Types Master';
        return view('admin.contact-type.list', compact('page_title'));
    }

    public function add($id = null)
    {
        $contactType = !empty($id) ? ContactType::find($id) : null;

        if ($id && !$contactType) {
            return redirect()->route('admin.contact-type.list')
                ->with('error', 'Record Not Found');
        }

        $btn_title = $contactType ? 'Update' : 'Submit';
        $page_title = $contactType ? 'Update Contact Type' : 'Add Contact Type';

        return view('admin.contact-type.add', compact('contactType', 'btn_title', 'page_title'));
    }

    public function save(Request $request)
    {
        $id = $request->id;

        $rules = [
            'name'   => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $exists = ContactType::where('name', trim($request->name));

        if ($id) {
            $exists->where('id', '!=', $id);
        }

        if ($exists->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Contact Type already exists'
            ], 422);
        }

        $contactType = $id ? ContactType::find($id) : new ContactType();
        $contactType->name   = trim($request->name);
        $contactType->status = $request->status;
        $contactType->save();

        return response()->json([
            'success' => true,
            'message' => $id ? 'Contact Type Updated Successfully' : 'Contact Type Added Successfully'
        ]);
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $query = ContactType::select(['id', 'name', 'status', 'created_at'])->orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d M Y h:i A') : '';
                })
                ->editColumn('status', function ($row) {
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
                    $editUrl = route('admin.contact-type.add', $row->id);
                    $btn = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a>';
                    $btn .= '<a href="javascript:void(0);" onclick="deleteData(' . $row->id . ')" class="btn btn-sm btn-danger m-1"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }

    public function delete(Request $request)
    {
        $contactType = ContactType::find($request->id);

        if ($contactType) {
            $contactType->delete();
            return response()->json(['status' => true, 'message' => 'Record Deleted Successfully']);
        }

        return response()->json([
            'status' => false,
            'message' => 'Record Not Found'
        ]);
    }

    public function changeStatus(Request $request)
    {
        $contactType = ContactType::find($request->id);
        if ($contactType) {
            $contactType->status = $request->status;
            $contactType->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record Not Found']);
    }
}
