<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{

    public function index()
    {
        $page_title = 'Product Category List';
        return view('admin.product-category.list', compact('page_title'));
    }


    public function add($id = null)
    {
        $category = !empty($id) ? ProductCategory::find($id) : null;
        if ($id && !$category) {
            return redirect()->route('admin.product-category.list')->with('error', 'Record Not Found');
        }
        $btn_title  = $category ? 'Update' : 'Submit';
        $page_title = $category ? 'Update Product Category' : 'Add Product Category';
        return view('admin.product-category.add', compact('category', 'btn_title', 'page_title'));
    }

public function save(Request $request)
{
    $input = $request->all();
    $id = $input['id'] ?? null;

    $rules = [
        'category_name' => 'required|string|max:255',
        'status'        => 'required|in:Active,Inactive',
        'image'         => $id ? 'nullable|image|mimes:jpg,jpeg,png' : 'required|image|mimes:jpg,jpeg,png',
    ];

    $validator = Validator::make($input, $rules);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    // Duplicate check
    $exists = ProductCategory::where('category_name', trim($input['category_name']));

    if ($id) {
        $exists->where('id', '!=', $id);
    }

    if ($exists->exists()) {
        return response()->json([
            'success' => false,
            'message' => 'Category already exists'
        ], 422);
    }

    // Find or create
    $category = ProductCategory::find($id);

    if ($id && !$category) {
        return response()->json([
            'message' => 'Record Not Found'
        ], 404);
    }

    if (!$category) {
        $category = new ProductCategory();
    }

    // Assign fields
    $category->category_name = trim($input['category_name']);
    $category->status        = $input['status'];

    // Image upload
    if ($request->hasFile('image')) {
        $file     = $request->file('image');
        $uploaded = uploadImage($file, 'product-category', $category->image ?? '');
        $category->image = $uploaded['image'] ?? null;
    }

    $category->save();

    return response()->json([
        'success' => true,
        'message' => $id ? 'Product Category updated successfully.' : 'Product Category added successfully.'
    ]);
}


    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $query = ProductCategory::select(['id', 'category_name', 'image', 'status']);

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $query->orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    if (!empty($row->image)) {
                        $imgUrl = asset($row->image);
                        return '<a href="' . $imgUrl . '" target="_blank">
                                    <img src="' . $imgUrl . '" alt="' . e($row->category_name) . '" width="60" height="60" style="object-fit:cover;border-radius:6px;">
                                </a>';
                    }
                    return 'N/A';
                })

                ->editColumn('status', function ($row) {
                    if (!auth()->user()->can('product-category-add')) {
                        return '<span class="badge bg-' . ($row->status === 'Active' ? 'success' : 'danger') . '">' . $row->status . '</span>';
                    }

                    $checked     = $row->status === 'Active' ? 'checked' : '';
                    $statusClass = $row->status === 'Active' ? 'bg-success' : 'bg-danger';

                    return '
                        <div class="d-flex align-items-center">
                            <div class="icon-state">
                                <label class="switch mb-0">
                                    <input type="checkbox" class="toggleStatus" data-id="' . $row->id . '" ' . $checked . '>
                                    <span class="switch-state ' . $statusClass . '"></span>
                                </label>
                            </div>
                        </div>
                    ';
                })

                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.product-category.add', $row->id);
                    $btn = '';
                    if (auth()->user()->can('product-category-add')) {
                        $btn .= '<a title="Edit Record" href="' . $editUrl . '" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a> ';
                    }
                    if (auth()->user()->can('product-category-delete')) {
                        $btn .= '<a title="Delete Record" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')" class="btn btn-sm btn-danger m-1"><i class="fas fa-trash-alt"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }
    }


    public function delete(Request $request)
    {
        if (!auth()->user()->can('product-category-delete')) {
            return response()->json([
                'status'  => false,
                'message' => 'Permission denied'
            ], 403);
        }

        $id       = $request->get('id');
        $category = ProductCategory::find($id);

        if ($category) {
            $category->delete(); // soft delete (uses deleted_at)
            return response()->json([
                'status'  => true,
                'message' => 'Record Deleted Successfully'
            ]);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Record Not Found'
        ]);
    }


    public function changeStatus(Request $request)
    {
        $category = ProductCategory::find($request->id);
        if ($category) {
            $category->status = $request->status;
            $category->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record Not Found']);
    }
}