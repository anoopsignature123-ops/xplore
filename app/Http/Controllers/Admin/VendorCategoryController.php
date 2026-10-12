<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\VendorCategory;
use Illuminate\Support\Facades\Validator;

class VendorCategoryController extends Controller
{
    public function index()
    {
        $page_title = 'Vendor Categories Master';
        return view('admin.vendor-category.list', compact('page_title'));
    }

    public function add($id = null)
    {
        $category = !empty($id) ? VendorCategory::find($id) : null;

        if ($id && !$category) {
            return redirect()->route('admin.vendor-category.list')
                ->with('error', 'Record Not Found');
        }

        $btn_title = $category ? 'Update' : 'Submit';
        $page_title = $category ? 'Update Vendor Category' : 'Add Vendor Category';

        return view('admin.vendor-category.add', compact('category', 'btn_title', 'page_title'));
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

        $exists = VendorCategory::where('name', trim($request->name));

        if ($id) {
            $exists->where('id', '!=', $id);
        }

        if ($exists->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor Category already exists'
            ], 422);
        }

        $category = $id ? VendorCategory::find($id) : new VendorCategory();
        $category->name   = trim($request->name);
        $category->status = $request->status;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => $id ? 'Vendor Category Updated Successfully' : 'Vendor Category Added Successfully'
        ]);
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $query = VendorCategory::withCount('vendors')->select(['id', 'name', 'status', 'created_at'])->orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d M Y h:i A') : '';
                })
                ->addColumn('vendors_count', function ($row) {
                    return '<span class="badge bg-info text-white">' . $row->vendors_count . '</span>';
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
                    $editUrl = route('admin.vendor-category.add', $row->id);
                    $btn = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a>';
                    $btn .= '<a href="javascript:void(0);" onclick="deleteData(' . $row->id . ')" class="btn btn-sm btn-danger m-1"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['vendors_count', 'status', 'action'])
                ->make(true);
        }
    }

    public function delete(Request $request)
    {
        $category = VendorCategory::find($request->id);

        if ($category) {
            $category->delete();
            return response()->json(['status' => true, 'message' => 'Record Deleted Successfully']);
        }

        return response()->json([
            'status' => false,
            'message' => 'Record Not Found'
        ]);
    }

    public function changeStatus(Request $request)
    {
        $category = VendorCategory::find($request->id);
        if ($category) {
            $category->status = $request->status;
            $category->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record Not Found']);
    }
}
