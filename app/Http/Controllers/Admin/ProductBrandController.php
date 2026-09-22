<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Validator;

class ProductBrandController extends Controller
{
    public function index()
    {
        $page_title = 'Product Brand List';
        return view('admin.product-brand.list', compact('page_title')); 
    }

    public function add($id = null)
    {
        $brand = !empty($id) ? ProductBrand::find($id) : null;
        if ($id && !$brand) {
            return redirect()->route('admin.product-brand.list')->with('error', 'Record Not Found');
        }
        $product_category_list = ProductCategory::select('id','category_name')->orderBy('category_name')->get();
        $btn_title  = $brand ? 'Update' : 'Submit';
        $page_title = $brand ? 'Update Product Brand' : 'Add Product Brand';
        return view('admin.product-brand.add', compact('brand', 'product_category_list', 'btn_title', 'page_title'));
    }

    public function save(Request $request)
    {
        $input = $request->all();
        $id    = $input['id'] ?? null;

        $rules = [
            'product_category_id' => 'required|exists:product_categories,id',
            'brand_name'          => 'required|string|max:255',
            'status'              => 'required|in:Active,Inactive',
            'image'               => $id ? 'nullable|image|mimes:jpg,jpeg,png' : 'required|image|mimes:jpg,jpeg,png',
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Duplicate check (same brand name in same category)
        $exists = ProductBrand::where('brand_name', trim($input['brand_name']))->where('product_category_id', $input['product_category_id']);

        if ($id) {
            $exists->where('id', '!=', $id);
        }


        if ($exists->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Brand already exists in this category'
            ], 422);
        }

        $brand = ProductBrand::find($id);
        if ($id && !$brand) {
            return response()->json(['message' => 'Record Not Found'], 404);
        }
        if (!$brand) {
            $brand = new ProductBrand();
        }

        $brand->product_category_id = $input['product_category_id'];
        $brand->brand_name          = trim($input['brand_name']);
        $brand->status              = $input['status'];

        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $uploaded = uploadImage($file, 'product-brand', $brand->image ?? '');
            $brand->image = $uploaded['image'] ?? null;
        }

        $brand->save();

        return response()->json([
            'success' => true,
            'message' => $id ? 'Product Brand updated successfully.' : 'Product Brand added successfully.'
        ]);
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $query = ProductBrand::with('category')
                ->select(['id', 'product_category_id', 'brand_name', 'image', 'status']);

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
                                    <img src="' . $imgUrl . '" alt="' . e($row->brand_name) . '" width="60" height="60" style="object-fit:cover;border-radius:6px;">
                                </a>';
                    }
                    return 'N/A';
                })
                ->editColumn('status', function ($row) {
                    if (!auth()->user()->can('product-brand-add')) {
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
                    $editUrl = route('admin.product-brand.add', $row->id);
                    $btn = '';
                    if (auth()->user()->can('product-brand-add')) {
                        $btn .= '<a title="Edit Record" href="' . $editUrl . '" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a>';
                    }
                    if (auth()->user()->can('product-brand-delete')) {
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
        if (!auth()->user()->can('product-brand-delete')) {
            return response()->json(['status' => false, 'message' => 'Permission denied'], 403);
        }
        $brand = ProductBrand::find($request->get('id'));
        if ($brand) {
            $brand->delete();
            return response()->json(['status' => true, 'message' => 'Record Deleted Successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record Not Found']);
    }

    public function changeStatus(Request $request)
    {
        $brand = ProductBrand::find($request->id);
        if ($brand) {
            $brand->status = $request->status;
            $brand->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record Not Found']);
    }
}