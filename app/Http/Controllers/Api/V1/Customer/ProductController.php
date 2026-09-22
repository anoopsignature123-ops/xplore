<?php
namespace App\Http\Controllers\Api\V1\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\ProductBrand;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller {


 
public function productCategoryList()
{
    $categories = ProductCategory::select('id', 'category_name', 'image')->where('status', 'Active')->orderBy('category_name', 'asc')->get();

    $data = $categories->map(function ($item) {
        $item->image = !empty($item->image) ? asset($item->image) : null;
        return $item;
    });
 
    return response()->json([
        'status' => true,
        'message' => 'Product Category List fetched successfully',
        'data' => $data,
    ]);
}

 
 


public function productSubCategoryList(Request $request)
{
    $validator = Validator::make($request->all(), [
        'product_category_id' => 'required|exists:product_categories,id',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => $validator->errors()->first(),
        ], 422);
    }

    $query = ProductSubCategory::select('id','sub_category_name','image')->where('status', 'Active');

    if (!empty($request->product_category_id)) {
        $query->where('product_category_id', $request->product_category_id);
    }

    $subCategories = $query->orderBy('sub_category_name', 'asc')->get();

      $data = $subCategories->map(function ($item) {
        $item->image = !empty($item->image) ? asset($item->image) : null;
        return $item;
    });

 
    return response()->json([
        'status' => true,
        'message' => 'Product Sub Category List fetched successfully',
        'data' => $data,
    ]);
}


 

public function productBrandList(Request $request)
{
    $validator = Validator::make($request->all(), [
        'product_category_id' => 'required|exists:product_categories,id',
    ]);

    if ($validator->fails()) { 
        return response()->json([
            'status' => false, 
            'message' => $validator->errors()->first(),
        ], 422);
    } 

    $query = ProductBrand::select('id','brand_name','image')->where('status', 'Active');

    if (!empty($request->product_category_id)) {
        $query->where('product_category_id', $request->product_category_id);
    }

    $brands = $query->orderBy('brand_name', 'asc')->get();

    $data = $brands->map(function ($item) {
        $item->image = !empty($item->image) ? asset($item->image) : null;
        return $item;
    });

    return response()->json([
        'status' => true,
        'message' => 'Product Brand List fetched successfully',
        'data' => $data,
    ]);
}


public function productList(Request $request)
{
    $validator = Validator::make($request->all(), [
        'category_id'      => 'nullable|string|exists:product_categories,id',
        'sub_category_id'  => 'nullable|string|exists:product_sub_categories,id',
        'brand_id'         => 'nullable|string|exists:product_brands,id',
        'keyword'          => 'nullable|string',
        'page_no'          => 'nullable|string|min:1',
        'per_page_record'  => 'nullable|string|min:1',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status'  => false,
            'message' => $validator->errors()->first(),
        ], 422);
    }

    $page = $request->page_no ?? 1;
    $perPage = $request->per_page_record ?? 10;

    $query = Product::with(['variants' => function ($q) {$q->select('id','product_id','mrp_price','sale_price','stock');}])
        ->select('id','product_name','has_variants','mrp_price','sale_price','stock','image')
        ->where('status', 'Active');

    if (!empty($request->category_id)) {
        $query->where('product_category_id', $request->category_id);
    }

    if (!empty($request->sub_category_id)) {
        $query->where('product_sub_category_id', $request->sub_category_id);
    }

    if (!empty($request->brand_id)) { 
        $query->where('product_brand_id', $request->brand_id);
    }

    if (!empty($request->keyword)) {
        $query->where('product_name', 'LIKE', '%' . $request->keyword . '%');
    }

    $products = $query->orderBy('product_name', 'asc')->paginate($perPage, ['*'], 'page', $page);

    $data = collect($products->items())->map(function ($product) {

        $image = !empty($product->image) ? asset($product->image) : null;

        if ($product->has_variants == 'Yes' && $product->variants->count() > 0) {

            $variant = $product->variants->first();

            return [
                'id'            => $product->id,
                'product_name'  => $product->product_name,
                'has_variants'  => $product->has_variants,
                'mrp_price'     => $variant->mrp_price,
                'sale_price'    => $variant->sale_price,
                'stock'         => $variant->stock,
                'image'         => $image,
            ];
        }

        return [
            'id'            => $product->id, 
            'product_name'  => $product->product_name,
            'has_variants'  => $product->has_variants,
            'mrp_price'     => $product->mrp_price,
            'sale_price'    => $product->sale_price,
            'stock'         => $product->stock,
            'image'         => $image,
        ];
    });

    return response()->json([
        'status'  => true,
        'message' => 'Product List fetched successfully',
        'data'    => $data,
    ]);
}
 



public function productDetail(Request $request)
{ 
    $validator = Validator::make($request->all(), [
        'product_id' => 'required|exists:products,id',
    ]);

    if ($validator->fails()) { 
        return response()->json([
            'status' => false,
            'message' => $validator->errors()->first(),
        ], 422);
    }

    $product = Product::with(['category:id,category_name','subCategory:id,sub_category_name','brand:id,brand_name','specifications','variants'])->find($request->product_id);

    if (!$product) {
        return response()->json([
            'status' => false,
            'message' => 'Product not found',
        ], 404);
    }

    $data = [
        'id' => $product->id,
        'product_name' => $product->product_name,
        'description' => $product->description,
        'has_variants' => $product->has_variants,
        'mrp_price' => $product->mrp_price,
        'sale_price' => $product->sale_price,
        'stock' => $product->stock,
        'image' => !empty($product->image) ? asset($product->image) : null,
        'status' => $product->status,

        'category' => [
            'id' => $product->category?->id,
            'category_name' => $product->category?->category_name,
        ],

        'sub_category' => [
            'id' => $product->subCategory?->id,
            'sub_category_name' => $product->subCategory?->sub_category_name,
        ],

        'brand' => [
            'id' => $product->brand?->id,
            'brand_name' => $product->brand?->brand_name,
        ],

        'specifications' => $product->specifications->map(function ($spec) {
            return [
                'name' => $spec->name,
                'value' => $spec->value,
            ];
        }),

        'variants' => $product->variants->map(function ($variant) {
            return [ 
                'id' => $variant->id,
                'variant_name' => $variant->variant_name ?? null,
                'mrp_price' => $variant->mrp_price ?? null,
                'sale_price' => $variant->sale_price ?? null,
                'stock' => $variant->stock ?? null
            ];
        }),
    ];

    return response()->json([
        'status' => true,
        'message' => 'Product details fetched successfully',
        'data' => $data,
    ]);
}





}