<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\ProductBrand;
use App\Models\ProductVariant; 
use App\Models\ProductSpecification;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
{
    $page_title = 'Product List';
    $product_category_list = ProductCategory::orderBy('category_name')->get();
    return view('admin.product.list', compact('page_title', 'product_category_list'));
}

    public function add($id = null)
    {
        $product = !empty($id) ? Product::with(['variants', 'specifications'])->find($id) : null;

        if ($id && !$product) {
            return redirect()->route('admi  n.product.list')->with('error', 'Record Not Found');
        }
        $product_category_list = ProductCategory::where('status', 'Active')->orderBy('category_name')->get();
        $btn_title  = $product ? 'Update' : 'Submit';
        $page_title = $product ? 'Update Product' : 'Add Product';
        return view('admin.product.add', compact('product', 'product_category_list', 'btn_title', 'page_title'));
    }

    public function save(Request $request)
    {
        $input = $request->all();
        $id    = $input['id'] ?? null;

        $rules = [
            'product_name'        => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'product_sub_category_id' => 'nullable|exists:product_sub_categories,id',
            'product_brand_id'    => 'nullable|exists:product_brands,id',
            'description'         => 'required|string', 
            'has_variants'        => 'required|in:Yes,No',
            'status'              => 'required|in:Active,Inactive',
            'image'               => $id ? 'nullable|image|mimes:jpg,jpeg,png' : 'required|image|mimes:jpg,jpeg,png',
        ];

        // No variant rules
        if ($input['has_variants'] === 'No') {
            $rules['mrp_price']  = 'required|numeric|min:0';
            $rules['sale_price'] = 'required|numeric|min:0|lte:mrp_price';
            $rules['stock']      = 'required|integer|min:0';
        }

        // Variant rules
        if ($input['has_variants'] === 'Yes') {
            $rules['variants']                     = 'required|array|min:1';
            $rules['variants.*.variant_name']      = 'required|string|max:255';
            $rules['variants.*.mrp_price']         = 'required|numeric|min:0';
            $rules['variants.*.sale_price']        = 'required|numeric|min:0';
            $rules['variants.*.stock']             = 'required|integer|min:0';
        }

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find or create
        $product = Product::find($id);
        if ($id && !$product) {
            return response()->json(['message' => 'Record Not Found'], 404);
        }
        if (!$product) {
            $product = new Product();
        }

        $product->product_name            = trim($input['product_name']);
        $product->product_category_id     = $input['product_category_id'];
        $product->product_sub_category_id = $input['product_sub_category_id'] ?? null;
        $product->product_brand_id        = $input['product_brand_id'] ?? null;
        $product->description             = $input['description'] ?? null;
        $product->has_variants            = $input['has_variants'];
        $product->status                  = $input['status'];

        // No variant fields
        if ($input['has_variants'] === 'No') {
            $product->mrp_price  = $input['mrp_price'];
            $product->sale_price = $input['sale_price'];
            $product->stock      = $input['stock'];
        } else {
            $product->mrp_price  = null;
            $product->sale_price = null;
            $product->stock      = null;
        }
 
        // Image upload
        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $uploaded = uploadImage($file, 'product', $product->image ?? '');
            $product->image = $uploaded['image'] ?? null;
        }

        $product->save();

        // Handle variants
        if ($input['has_variants'] === 'Yes' && !empty($input['variants'])) {
            $submittedIds = [];

            foreach ($input['variants'] as $variantData) {
                $variantId = !empty($variantData['id']) ? $variantData['id'] : null;

                // Find existing or create new
                $variant = $variantId ? ProductVariant::find($variantId) : null;
                if (!$variant) {
                    $variant = new ProductVariant();
                    $variant->product_id = $product->id;
                }

                $variant->variant_name = trim($variantData['variant_name']);
                $variant->mrp_price    = $variantData['mrp_price'];
                $variant->sale_price   = $variantData['sale_price'];
                $variant->stock        = $variantData['stock'];
                $variant->save();

                $submittedIds[] = $variant->id;
            }
            // Soft delete removed variants
            ProductVariant::where('product_id', $product->id)->whereNotIn('id', $submittedIds)->delete();
        } elseif ($input['has_variants'] === 'No') {
            // Remove all variants if switched to No
            ProductVariant::where('product_id', $product->id)->delete();
        }


            // ── Handle Specifications ──────────────────────────────
            if (!empty($input['specifications']) && is_array($input['specifications'])) {
                $submittedSpecIds = [];

                foreach ($input['specifications'] as $specData) {
                    // skip completely empty rows
                    if (empty(trim($specData['name'] ?? '')) && empty(trim($specData['value'] ?? ''))) {
                        continue;
                    }

                    $specId = !empty($specData['id']) ? $specData['id'] : null;
                    $spec   = $specId ? ProductSpecification::find($specId) : null;

                    if (!$spec) {
                        $spec = new ProductSpecification();
                        $spec->product_id = $product->id;
                    }

                    $spec->name  = trim($specData['name']  ?? '');
                    $spec->value = trim($specData['value'] ?? '');
                    $spec->save();

                    $submittedSpecIds[] = $spec->id;
                }

                // soft-delete removed specs
                ProductSpecification::where('product_id', $product->id)->whereNotIn('id', $submittedSpecIds)->delete();
            } else {
                // all specs removed
                ProductSpecification::where('product_id', $product->id)->delete();
            }


        return response()->json([
            'success' => true,
            'message' => $id ? 'Product updated successfully.' : 'Product added successfully.'
        ]);
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $query = Product::with(['category', 'subCategory', 'brand'])->select(['id', 'product_category_id', 'product_sub_category_id', 'product_brand_id','product_name', 'has_variants', 'mrp_price', 'sale_price', 'stock', 'image', 'status']);

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('product_category_id')) {
                $query->where('product_category_id', $request->product_category_id);
            }

            if ($request->filled('product_sub_category_id')) {
                $query->where('product_sub_category_id', $request->product_sub_category_id);
            }
            if ($request->filled('product_brand_id')) {
                $query->where('product_brand_id', $request->product_brand_id);
            }

            $query->orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('category_name',     fn($row) => $row->category->category_name         ?? 'N/A')
                ->addColumn('sub_category_name', fn($row) => $row->subCategory->sub_category_name  ?? 'N/A')
                ->addColumn('brand_name',        fn($row) => $row->brand->brand_name               ?? 'N/A')


                ->editColumn('image', function ($row) {
                    if (!empty($row->image)) {
                        $imgUrl = asset($row->image);
                        return '<a href="' . $imgUrl . '" target="_blank">
                                    <img src="' . $imgUrl . '" alt="' . e($row->product_name) . '" width="60" height="60" style="object-fit:cover;border-radius:6px;">
                                </a>';
                    }
                    return 'N/A';
                }) 


                
                ->editColumn('mrp_price', fn($row) => $row->has_variants === 'Yes' ? '<button class="btn btn-info btn-sm btnViewVariants" data-id="'.$row->id.'" data-name="'.e($row->product_name).'"><i class="fas fa-layer-group me-1"></i>Variants</button>' : '₹' . number_format($row->mrp_price, 2))
                ->editColumn('sale_price', fn($row) => $row->has_variants === 'Yes' ? '-' : '₹' . number_format($row->sale_price, 2))
                ->editColumn('stock', fn($row) => $row->has_variants === 'Yes' ? '-' : $row->stock)

                ->addColumn('action_specs', fn($row) =>
                    '<button class="btn btn-warning btn-sm btnViewSpecs" data-id="'.$row->id.'" data-name="'.e($row->product_name).'">
                        <i class="fas fa-list-ul me-1"></i>Specs
                    </button>'
                )

                ->editColumn('status', function ($row) {
                    if (!auth()->user()->can('product-add')) {
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
                    $btn = '';
                    if (auth()->user()->can('product-add')) {
                        $btn .= '<a title="Edit" href="' . route('admin.product.add', $row->id) . '" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a>';
                    }
                    if (auth()->user()->can('product-delete')) {
                        $btn .= '<a title="Delete" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')" class="btn btn-sm btn-danger m-1"><i class="fas fa-trash-alt"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['image', 'status', 'action', 'mrp_price', 'sale_price','action_specs'])
                ->make(true);
        }
    }

    public function delete(Request $request)
    {
        if (!auth()->user()->can('product-delete')) {
            return response()->json(['status' => false, 'message' => 'Permission denied'], 403);
        }
        $product = Product::find($request->get('id'));
        if ($product) {
            $product->delete(); // boot() me variants bhi soft delete honge
            return response()->json(['status' => true, 'message' => 'Record Deleted Successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record Not Found']);
    }

    public function changeStatus(Request $request)
    {
        $product = Product::find($request->id);
        if ($product) {
            $product->status = $request->status;
            $product->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record Not Found']);
    }

    public function getSubCategories(Request $request)
    {
        $list = ProductSubCategory::where('product_category_id', $request->product_category_id)
                    ->orderBy('sub_category_name')
                    ->get(['id', 'sub_category_name']);
        return response()->json($list);
    }

    public function getBrands(Request $request)
    {
        $list = ProductBrand::where('product_category_id', $request->product_category_id)
                    ->orderBy('brand_name')
                    ->get(['id', 'brand_name']);
        return response()->json($list);
    }

    public function getVariants(Request $request)
{
    $product = Product::with('variants')->find($request->product_id);
    if (!$product) {
        return response()->json(['status' => false, 'message' => 'Product not found']);
    }
    return response()->json([
        'status'   => true,
        'product'  => $product->product_name,
        'variants' => $product->variants
    ]);
}

public function getSpecifications(Request $request)
{
    $product = Product::with('specifications')->find($request->product_id);
    if (!$product) {
        return response()->json(['status' => false, 'message' => 'Product not found']);
    }
    return response()->json([
        'status'         => true,
        'product'        => $product->product_name,
        'specifications' => $product->specifications
    ]);
}


}