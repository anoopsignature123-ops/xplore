<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuildCategory;
use App\Models\Builder;
use App\Models\BuilderInquiry;
use App\Models\BuilderReview;
use App\Models\Slider;
use App\Http\Resources\V1\Customer\BuildCategoryResource;
use App\Http\Resources\V1\Customer\BuilderResource;
use App\Http\Resources\V1\Customer\BuilderDetailResource;
use App\Http\Resources\V1\Customer\EquipmentSliderResource;
use Illuminate\Support\Facades\Validator;
use Throwable;

class BuildController extends Controller
{
    /**
     * Build Module Home Screen API
     */
    public function home(Request $request)
    {
        try {
            // Sliders for Build
            $sliders = Slider::where('type', 'build')
                ->where('status', 'Active')
                ->select('id', 'name', 'image')
                ->orderByDesc('id')
                ->get();

            // Categories
            $categories = BuildCategory::where('status', 1)->orderBy('id')->get();

            // Featured/Top Rated Builders
            $featuredBuilders = Builder::with(['category', 'services'])
                ->where('status', 1)
                ->orderByDesc('rating')
                ->take(10)
                ->get();

            return response()->json([
                'status'  => true,
                'message' => 'Build home data fetched successfully',
                'data'    => [
                    'sliders'           => EquipmentSliderResource::collection($sliders),
                    'categories'        => BuildCategoryResource::collection($categories),
                    'featured_builders' => BuilderResource::collection($featuredBuilders),
                ],
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to fetch build home data.',
            ], 500);
        }
    }

    /**
     * Categories List API
     */
    public function categories(Request $request)
    {
        try {
            $categories = BuildCategory::where('status', 1)->orderBy('id')->get();

            return response()->json([
                'status'  => true,
                'message' => 'Build categories fetched successfully',
                'data'    => BuildCategoryResource::collection($categories),
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to fetch categories.',
            ], 500);
        }
    }

    /**
     * Builders List API with Filters & Search
     */
    public function builders(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'category_id'   => 'nullable|integer|exists:build_categories,id',
                'category_slug' => 'nullable|string|max:100',
                'location'      => 'nullable|string|max:100',
                'search'        => 'nullable|string|max:100',
                'per_page'      => 'nullable|integer|min:1|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $query = Builder::with(['category', 'services'])->where('status', 1);

            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            if ($request->filled('category_slug')) {
                $slug = trim($request->category_slug);
                $query->whereHas('category', function ($q) use ($slug) {
                    $q->where('slug', $slug);
                });
            }

            if ($request->filled('location')) {
                $location = trim($request->location);
                $query->where('location', 'like', "%{$location}%");
            }

            if ($request->filled('search')) {
                $search = strip_tags(trim($request->search));
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('firm_name', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
                });
            }

            $builders = $query->orderByDesc('id')->paginate($request->per_page ?? 15);

            return response()->json([
                'status'  => true,
                'message' => 'Builders fetched successfully',
                'data'    => [
                    'current_page' => $builders->currentPage(),
                    'last_page'    => $builders->lastPage(),
                    'total'        => $builders->total(),
                    'items'        => BuilderResource::collection($builders->getCollection()),
                ],
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to fetch builders list.',
            ], 500);
        }
    }

    /**
     * Builder Detailed Profile API
     */
    public function detail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'builder_id' => 'required_without:builder_slug|nullable|integer|exists:builders,id',
                'builder_slug' => 'required_without:builder_id|nullable|string|exists:builders,slug',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $query = Builder::with(['category', 'services', 'certifications', 'serviceAreas', 'portfolios', 'completedProjects', 'reviews']);

            if ($request->filled('builder_id')) {
                $builder = $query->findOrFail($request->builder_id);
            } else {
                $builder = $query->where('slug', $request->builder_slug)->firstOrFail();
            }

            return response()->json([
                'status'  => true,
                'message' => 'Builder profile details fetched successfully',
                'data'    => new BuilderDetailResource($builder),
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Builder profile not found.',
            ], 404);
        }
    }

    /**
     * Submit Customer Inquiry (Call / Chat Request) API
     */
    public function submitInquiry(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'builder_id'     => 'required|integer|exists:builders,id',
                'customer_name'  => 'required|string|max:255',
                'customer_phone' => 'required|string|max:20',
                'customer_email' => 'nullable|email|max:255',
                'message'        => 'nullable|string|max:1000',
                'inquiry_type'   => 'nullable|in:call,chat,general',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $user = $request->user();

            $inquiry = BuilderInquiry::create([
                'builder_id'     => $request->builder_id,
                'customer_id'    => $user ? $user->id : null,
                'customer_name'  => strip_tags(trim($request->customer_name)),
                'customer_phone' => strip_tags(trim($request->customer_phone)),
                'customer_email' => strip_tags(trim($request->customer_email ?? '')),
                'message'        => strip_tags(trim($request->message ?? '')),
                'inquiry_type'   => $request->inquiry_type ?? 'call',
                'status'         => 'pending',
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Inquiry submitted successfully! The professional will contact you soon.',
                'data'    => [
                    'inquiry_id' => $inquiry->id,
                    'status'     => $inquiry->status,
                ],
            ], 201);

        } catch (Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to submit inquiry.',
            ], 500);
        }
    }

    /**
     * Add Customer Review API
     */
    public function addReview(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'builder_id'    => 'required|integer|exists:builders,id',
                'customer_name' => 'required|string|max:255',
                'rating'        => 'required|numeric|min:1|max:5',
                'review_text'   => 'required|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $user = $request->user();

            $review = BuilderReview::create([
                'builder_id'     => $request->builder_id,
                'customer_id'    => $user ? $user->id : null,
                'customer_name'  => strip_tags(trim($request->customer_name)),
                'customer_image' => $user ? asset($user->profile_image ?? '') : null,
                'rating'         => $request->rating,
                'review_text'    => strip_tags(trim($request->review_text)),
                'status'         => true,
            ]);

            // Update average rating on Builder profile
            $builder = Builder::find($request->builder_id);
            if ($builder) {
                $avgRating = BuilderReview::where('builder_id', $builder->id)->where('status', 1)->avg('rating');
                $builder->rating = round($avgRating, 1);
                $builder->save();
            }

            return response()->json([
                'status'  => true,
                'message' => 'Review submitted successfully!',
                'data'    => $review,
            ], 201);

        } catch (Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to submit review.',
            ], 500);
        }
    }
}
