<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ProductSubCategory;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Validator;

class ProductSubCategoryController extends Controller
{
    public function index()
    {
        $page_title = 'Product Sub Category List';
        return view('admin.product-sub-category.list', compact('page_title'));
    }

    public function add($id = null)
    {
        $sub_category = !empty($id) ? ProductSubCategory::find($id) : null;
        if ($id && !$sub_category) {
            return redirect()->route('admin.product-sub-category.list')->with('error', 'Record Not Found');
        }
        $product_category_list = ProductCategory::select('id','category_name')->orderBy('category_name')->get();
        $btn_title  = $sub_category ? 'Update' : 'Submit';
        $page_title = $sub_category ? 'Update Product Sub Category' : 'Add Product Sub Category';
        return view('admin.product-sub-category.add', compact('sub_category', 'product_category_list', 'btn_title', 'page_title'));
    }
 
    public function save(Request $request)
    {
        $input = $request->all();
        $id    = $input['id'] ?? null;

        $rules = [
            'product_category_id' => 'required|exists:product_categories,id',
            'sub_category_name'   => 'required|string|max:255',
            'status'              => 'required|in:Active,Inactive',
            'image'               => $id ? 'nullable|image|mimes:jpg,jpeg,png' : 'required|image|mimes:jpg,jpeg,png',
        ];

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Duplicate check (same sub category name in same category)
        $exists = ProductSubCategory::where('sub_category_name', trim($input['sub_category_name']))->where('product_category_id', $input['product_category_id']);
        if ($id) {
            $exists->where('id', '!=', $id);
        }
        if ($exists->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Sub Category already exists in this category'
            ], 422);
        }

        $sub_category = ProductSubCategory::find($id);
        if ($id && !$sub_category) {
            return response()->json(['message' => 'Record Not Found'], 404);
        }
        if (!$sub_category) {
            $sub_category = new ProductSubCategory();
        }

        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $uploaded = uploadImage($file, 'product-sub-cat', $sub_category->image ?? '');
            $sub_category->image = $uploaded['image'] ?? null;
        }


        $sub_category->product_category_id = $input['product_category_id'];
        $sub_category->sub_category_name   = trim($input['sub_category_name']);
        $sub_category->status              = $input['status'];
        $sub_category->save();

        return response()->json([
            'success' => true,
            'message' => $id ? 'Product Sub Category updated successfully.' : 'Product Sub Category added successfully.'
        ]);
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $query = ProductSubCategory::with('category')
                ->select(['id', 'product_category_id', 'image','sub_category_name', 'status']);

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('product_category_id')) {
                $query->where('product_category_id', $request->product_category_id);
            }

            $query->orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('category_name', fn($row) => $row->category->category_name ?? 'N/A')
                ->editColumn('image', function ($row) {
                    if (!empty($row->image)) {
                        $imgUrl = asset($row->image);
                        return '<a href="' . $imgUrl . '" target="_blank">
                                    <img src="' . $imgUrl . '" alt="' . e($row->sub_category_name) . '" width="60" height="60" style="object-fit:cover;border-radius:6px;">
                                </a>';
                    }
                    return 'N/A';
                })
                ->editColumn('status', function ($row) {
                    if (!auth()->user()->can('product-sub-category-add')) {
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
                        </div>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.product-sub-category.add', $row->id);
                    $btn = '';
                    if (auth()->user()->can('product-sub-category-add')) {
                        $btn .= '<a title="Edit Record" href="' . $editUrl . '" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a>';
                    }
                    if (auth()->user()->can('product-sub-category-delete')) {
                        $btn .= '<a title="Delete Record" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')" class="btn btn-sm btn-danger m-1"><i class="fas fa-trash-alt"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['status', 'image','action'])
                ->make(true);
        }
    }
 
    public function delete(Request $request)
    {
        if (!auth()->user()->can('product-sub-category-delete')) {
            return response()->json(['status' => false, 'message' => 'Permission denied'], 403);
        }
        $sub_category = ProductSubCategory::find($request->get('id'));
        if ($sub_category) {
            $sub_category->delete();
            return response()->json(['status' => true, 'message' => 'Record Deleted Successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record Not Found']);
    }

    public function changeStatus(Request $request)
    {
        $sub_category = ProductSubCategory::find($request->id);
        if ($sub_category) {
            $sub_category->status = $request->status;
            $sub_category->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record Not Found']);
    }
}