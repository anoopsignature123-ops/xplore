<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\BuildCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BuildCategoryController extends Controller
{
    public function index()
    {
        $page_title = 'Build Categories';
        return view('admin.build_category.list', compact('page_title'));
    }

    public function getRecords(Request $request)
    {
        $query = BuildCategory::query()->orderBy('id', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('name', function ($row) {
                return '<strong><i class="fas fa-th-large text-primary me-2"></i>' . e($row->name) . '</strong>';
            })
            ->editColumn('slug', function ($row) {
                return '<code>' . e($row->slug) . '</code>';
            })
            ->editColumn('status', function ($row) {
                $checked = $row->status ? 'checked' : '';
                return '<label class="custom-switch">
                            <input class="status-toggle" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
                            <span class="slider"></span>
                        </label>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.build-category.add', $row->id);
                $deleteUrl = route('admin.build-category.delete', $row->id);

                return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary me-1"><i class="fas fa-edit me-1"></i> Edit</a>
                    <button data-url="' . $deleteUrl . '" class="btn btn-sm btn-danger delete-btn"><i class="fas fa-trash-alt me-1"></i> Delete</button>
                ';
            })
            ->rawColumns(['name', 'slug', 'status', 'action'])
            ->make(true);
    }

    public function add($id = null)
    {
        $category = !empty($id) ? BuildCategory::find($id) : null;

        if ($id && !$category) {
            return redirect()->route('admin.build-category.list')->with('error', 'Category Not Found');
        }

        $btn_title  = $category ? 'Update' : 'Submit';
        $page_title = $category ? 'Update Build Category' : 'Add Build Category';

        return view('admin.build_category.add', compact('category', 'btn_title', 'page_title'));
    }

    public function save(Request $request)
    {
        $id = $request->input('id');

        $rules = [
            'name'   => 'required|string|max:255',
            'status' => 'required|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'name'   => $request->name,
            'slug'   => Str::slug($request->name),
            'status' => $request->status ? 1 : 0,
        ];

        if ($id) {
            $category = BuildCategory::findOrFail($id);
            $category->update($data);
            $msg = 'Category updated successfully!';
        } else {
            BuildCategory::create($data);
            $msg = 'Category added successfully!';
        }

        return redirect()->route('admin.build-category.list')->with('success', $msg);
    }

    public function toggleStatus(Request $request)
    {
        $category = BuildCategory::find($request->id);
        if ($category) {
            $category->status = !$category->status;
            $category->save();
            return response()->json(['status' => true, 'message' => 'Status updated successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Category not found'], 404);
    }

    public function delete($id)
    {
        $category = BuildCategory::find($id);
        if ($category) {
            $category->delete();
            return response()->json(['status' => true, 'message' => 'Category deleted successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Category not found'], 404);
    }
}
