<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuildCategory;
use App\Models\BuilderServiceType;
use App\Models\BuildService;
use App\Models\BuildServiceBooking;
use App\Models\Slider;
use App\Http\Resources\V1\Customer\BuildCategoryResource;
use App\Http\Resources\V1\Customer\EquipmentSliderResource;
use Illuminate\Support\Facades\Validator;
use Throwable;

class BuildController extends Controller
{
    /**
     * Build Module Home Screen API
     * POST api/v1/build-home
     * Returns: sliders, categories, service_types, featured_services
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

            // Categories (main filter tabs in app)
            $categories = BuildCategory::where('status', 1)->orderBy('id')->get();

            // Featured/Top Rated Services (latest 6)
            $featuredServices = BuildService::with('category')
                ->where('status', 1)
                ->orderByDesc('rating')
                ->take(6)
                ->get()
                ->map(fn($s) => [
                    'id' => $s->id,
                    'category_name' => $s->category?->name ?? '',
                    'title' => $s->title,
                    'short_desc' => $s->short_desc ?? '',
                    'price' => (float) $s->price,
                    'price_type' => $s->price_type,
                    'price_label' => $s->price_label,
                    'duration' => $s->duration ?? '',
                    'rating' => (float) $s->rating,
                    'total_reviews' => (int) $s->total_reviews,
                    'tags' => $s->tags ?? [],
                ]);

            return response()->json([
                'status'  => true,
                'message' => 'Build home data fetched successfully',
                'data'    => [
                    'sliders' => EquipmentSliderResource::collection($sliders),
                    'categories' => BuildCategoryResource::collection($categories),
                    'featured_services' => $featuredServices,
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
     * POST api/v1/build-categories
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
     * Service Types List API
     * GET|POST api/v1/build-service-types
     */
    public function serviceTypes(Request $request)
    {
        try {
            $types = BuilderServiceType::where('status', 1)
                ->orderBy('name')
                ->get()
                ->map(fn($t) => [
                    'id' => (int) $t->id,
                    'name' => (string) $t->name,
                    'icon' => (string) ($t->icon ?? ''),
                ]);

            return response()->json([
                'status' => true,
                'message' => 'Service types fetched successfully',
                'data' => $types,
            ], 200);

        } catch (Throwable $e) {
            return response()->json(['status' => false, 'message' => 'Failed to fetch service types.'], 500);
        }
    }

    /**
     * Build Service List API — App Screen 1 (category filter tabs + service cards)
     * POST api/v1/build-service-list
     * Params: category_id (optional), search (optional), per_page (optional)
     */
    public function serviceList(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'category_id' => 'nullable|integer|exists:build_categories,id',
                'search' => 'nullable|string|max:100',
                'per_page' => 'nullable|integer|min:1|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
            }

            $query = BuildService::with('category')->where('status', 1);

            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            if ($request->filled('search')) {
                $search = trim($request->search);
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('short_desc', 'like', "%{$search}%");
                });
            }

            $services = $query->orderBy('sort_order')->orderByDesc('id')
                ->paginate($request->per_page ?? 15);

            $items = $services->getCollection()->map(fn($s) => [
                'id' => $s->id,
                'category_id' => $s->category_id,
                'category_name' => $s->category?->name ?? '',
                'title' => $s->title,
                'short_desc' => $s->short_desc ?? '',
                'price' => (float) $s->price,
                'price_type' => $s->price_type,
                'price_label' => $s->price_label,
                'duration' => $s->duration ?? '',
                'rating' => (float) $s->rating,
                'total_reviews' => (int) $s->total_reviews,
                'tags' => $s->tags ?? [],
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Build services fetched successfully',
                'data'    => [
                    'current_page' => $services->currentPage(),
                    'last_page' => $services->lastPage(),
                    'total' => $services->total(),
                    'items' => $items,
                ],
            ], 200);

        } catch (Throwable $e) {
            return response()->json(['status' => false, 'message' => 'Failed to fetch services.'], 500);
        }
    }

    /**
     * Build Service Detail API — App Screen 3/4/5
     * POST api/v1/build-service-detail
     * Params: service_id (required)
     */
    public function serviceDetail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'service_id' => 'required|integer|exists:build_services,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
            }

            $service = BuildService::with(['category', 'faqs'])->findOrFail($request->service_id);

            $faqs = $service->faqs->map(fn($f) => [
                'question' => $f->question,
                'answer' => $f->answer,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Service detail fetched successfully',
                'data' => [
                    'id' => $service->id,
                    'category_id' => $service->category_id,
                    'category_name' => $service->category?->name ?? '',
                    'title' => $service->title,
                    'short_desc' => $service->short_desc ?? '',
                    'price' => (float) $service->price,
                    'price_type' => $service->price_type,
                    'price_label' => $service->price_label,
                    'duration' => $service->duration ?? '',
                    'rating' => (float) $service->rating,
                    'total_reviews' => (int) $service->total_reviews,
                    'tags' => $service->tags ?? [],
                    'overview' => $service->overview ?? '',
                    'deliverables' => $service->deliverables ?? [],
                    'what_you_get' => $service->what_you_get ?? [],
                    'execution_steps' => $service->execution_steps ?? [],
                    'faqs' => $faqs,
                ],
            ], 200);

        } catch (Throwable $e) {
            return response()->json(['status' => false, 'message' => 'Service not found.'], 404);
        }
    }

    /**
     * Book a Build Service — App Screen 2
     * POST api/v1/build-book-service
     * Body: service_id, site_location, contact_mobile, target_timeline, budget_range, project_notes
     */
    public function bookService(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'service_id' => 'required|integer|exists:build_services,id',
                'site_location' => 'required|string|max:500',
                'contact_mobile' => 'required|string|max:20',
                'target_timeline' => 'nullable|string|max:100',
                'budget_range' => 'nullable|string|max:100',
                'project_notes' => 'nullable|string|max:2000',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
            }

            $user = $request->user();

            $booking = BuildServiceBooking::create([
                'build_service_id' => $request->service_id,
                'customer_id' => $user?->id,
                'customer_name' => $user?->name ?? '',
                'site_location' => strip_tags(trim($request->site_location)),
                'contact_mobile' => strip_tags(trim($request->contact_mobile)),
                'target_timeline' => $request->target_timeline ?? '',
                'budget_range' => $request->budget_range ?? '',
                'project_notes' => strip_tags(trim($request->project_notes ?? '')),
                'status' => 'pending',
            ]);

            $service = BuildService::find($request->service_id);

            return response()->json([
                'status'  => true,
                'message' => 'Service request submitted successfully! Our admin team will verify your project and assign a verified professional.',
                'data'    => [
                    'booking_id' => $booking->id,
                    'service_title' => $service?->title ?? '',
                    'status' => $booking->status,
                    'submitted_at' => $booking->created_at->toISOString(),
                ],
            ], 201);

        } catch (Throwable $e) {
            return response()->json(['status' => false, 'message' => 'Failed to submit booking request.'], 500);
        }
    }

    /**
     * My Build Bookings — Customer's booking history
     * GET|POST api/v1/my-build-bookings
     */
    public function myBuildBookings(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'Unauthorized.'], 401);
            }

            $bookings = BuildServiceBooking::with('service.category')
                ->where('customer_id', $user->id)
                ->orderByDesc('id')
                ->get()
                ->map(fn($b) => [
                    'booking_id' => $b->id,
                    'service_id' => $b->build_service_id,
                    'service_title' => $b->service?->title ?? '',
                    'category_name' => $b->service?->category?->name ?? '',
                    'site_location' => $b->site_location,
                    'contact_mobile' => $b->contact_mobile,
                    'target_timeline' => $b->target_timeline ?? '',
                    'budget_range' => $b->budget_range ?? '',
                    'project_notes' => $b->project_notes ?? '',
                    'status' => $b->status,
                    'admin_notes' => $b->admin_notes ?? '',
                    'submitted_at' => $b->created_at->toISOString(),
                ]);

            return response()->json([
                'status'  => true,
                'message' => 'Your build bookings fetched successfully',
                'data' => $bookings,
            ], 200);

        } catch (Throwable $e) {
            return response()->json(['status' => false, 'message' => 'Failed to fetch bookings.'], 500);
        }
    }
}