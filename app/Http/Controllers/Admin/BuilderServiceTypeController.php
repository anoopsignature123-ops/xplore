<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\BuilderServiceType;
use Illuminate\Support\Facades\Validator;

class BuilderServiceTypeController extends Controller
{
    public function index()
    {
        $page_title = 'Builder Service Types';
        return view('admin.builder_service_type.list', compact('page_title'));
    }

    public function getRecords(Request $request)
    {
        $types = BuilderServiceType::query()->orderBy('id', 'desc');

        return DataTables::of($types)
            ->addIndexColumn()
            ->editColumn('name', function ($row) {
                return '<strong style="color:#1e293b !important;">' . e($row->name) . '</strong>';
            })
            ->editColumn('icon', function ($row) {
                if ($row->icon) {
                    return '<span class="badge bg-light text-dark border px-3 py-2" style="font-size:13px;">'
                         . '<i class="fas ' . e($row->icon) . ' me-2" style="color:#308e87;"></i>'
                         . '<code style="color:#64748b;">' . e($row->icon) . '</code>'
                         . '</span>';
                }
                return '<span class="text-muted small fst-italic">— No icon —</span>';
            })
            ->editColumn('status', function ($row) {
                $checked = $row->status ? 'checked' : '';
                return '<label class="custom-switch">
                            <input class="status-toggle" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
                            <span class="slider"></span>
                        </label>';
            })
            ->addColumn('action', function ($row) {
                $editUrl   = route('admin.builder-service-type.add', $row->id);
                $deleteUrl = route('admin.builder-service-type.delete', $row->id);
                return '<a href="' . $editUrl . '" class="btn btn-sm btn-primary me-1">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <button data-url="' . $deleteUrl . '" data-name="' . e($row->name) . '" class="btn btn-sm btn-danger delete-btn">
                            <i class="fas fa-trash-alt me-1"></i>Delete
                        </button>';
            })
            ->rawColumns(['name', 'icon', 'status', 'action'])
            ->make(true);
    }

    public function add($id = null)
    {
        $type       = $id ? BuilderServiceType::findOrFail($id) : null;
        $btn_title  = $type ? 'Update' : 'Add';
        $page_title = $type ? 'Edit Builder Service Type' : 'Add Builder Service Type';

        return view('admin.builder_service_type.add', compact('type', 'btn_title', 'page_title'));
    }

    public function save(Request $request)
    {
        $id = $request->input('id');

        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:255',
            'icon'   => 'nullable|string|max:100',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'name'   => trim($request->name),
            'icon'   => trim($request->icon ?? ''),
            'status' => (int) $request->status,
        ];

        if ($id) {
            BuilderServiceType::findOrFail($id)->update($data);
            $msg = 'Service type updated successfully!';
        } else {
            BuilderServiceType::create($data);
            $msg = 'Service type created successfully!';
        }

        return redirect()->route('admin.builder-service-type.list')->with('success', $msg);
    }

    public function toggleStatus(Request $request)
    {
        $type = BuilderServiceType::find($request->id);
        if ($type) {
            $type->status = $type->status ? 0 : 1;
            $type->save();
            return response()->json(['status' => true, 'message' => 'Status updated successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record not found'], 404);
    }

    public function delete($id)
    {
        $type = BuilderServiceType::find($id);
        if ($type) {
            $type->delete();
            return response()->json(['status' => true, 'message' => 'Service type deleted successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record not found'], 404);
    }
}
