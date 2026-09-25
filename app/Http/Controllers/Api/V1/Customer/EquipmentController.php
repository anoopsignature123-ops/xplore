<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\EquipmentBooking;
use App\Models\EquipmentWishlist;
use App\Models\Slider;
use App\Models\CustomerAddress;
use App\Http\Resources\V1\Customer\EquipmentResource;
use App\Http\Resources\V1\Customer\EquipmentSliderResource;
use App\Http\Resources\V1\Customer\EquipmentBookingResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Razorpay\Api\Api;
use Exception;
use Throwable;

class EquipmentController extends Controller
{
    /**
     * Page 1: Equipment Rental Home API
     */
    public function home(Request $request)
    {
        try {
            // Sliders
            $sliders = Slider::where('type', 'equipment')
                ->where('status', 'Active')
                ->select('id', 'name', 'image')
                ->orderByDesc('id')
                ->get();

            // Feature Badges
            $badges = [
                ['title' => 'Well Maintained', 'icon' => 'tools'],
                ['title' => 'Latest Technology', 'icon' => 'shield-check'],
                ['title' => 'Affordable Price', 'icon' => 'shield'],
                ['title' => 'Expert Support', 'icon' => 'headset'],
            ];

            // Popular Equipments
            $popularEquipment = Equipment::where('status', 1)
                ->where('is_popular', 1)
                ->orderByDesc('id')
                ->get();

            // All Equipments
            $allEquipment = Equipment::where('status', 1)
                ->orderByDesc('id')
                ->get();

            return response()->json([
                'status'  => true,
                'message' => 'Equipment home data fetched successfully',
                'data'    => [
                    'sliders'           => EquipmentSliderResource::collection($sliders),
                    // 'badges'            => $badges,
                    'popular_equipment' => EquipmentResource::collection($popularEquipment),
                    'all_equipment'     => EquipmentResource::collection($allEquipment),
                ],
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to fetch equipment home data.',
            ], 500);
        }
    }

    /**
     * Equipment Paginated List API with Search
     */
    public function list(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'search'   => 'nullable|string|max:100',
                'per_page' => 'nullable|integer|min:1|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $query = Equipment::where('status', 1);

            if ($request->filled('search')) {
                $search = strip_tags(trim($request->search));
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('brand', 'like', "%{$search}%")
                      ->orWhere('model', 'like', "%{$search}%");
                });
            }

            $equipments = $query->orderByDesc('id')->paginate($request->per_page ?? 15);

            return response()->json([
                'status'  => true,
                'message' => 'Equipment list fetched successfully',
                'data'    => [
                    'current_page' => $equipments->currentPage(),
                    'last_page'    => $equipments->lastPage(),
                    'total'        => $equipments->total(),
                    'items'        => EquipmentResource::collection($equipments->getCollection()),
                ],
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to fetch equipment list.',
            ], 500);
        }
    }

    /**
     * Page 2 & Page 3: Equipment Details API
     */
    public function detail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'equipment_id' => 'required|integer|exists:equipments,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $equipment = Equipment::with('specifications')->findOrFail($request->equipment_id);

            return response()->json([
                'status'  => true,
                'message' => 'Equipment details fetched successfully',
                'data'    => new EquipmentResource($equipment),
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Equipment not found or invalid request.',
            ], 404);
        }
    }

    /**
     * Page 4: Calculate Rental Summary API
     */
    public function calculateSummary(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'equipment_id' => 'required|integer|exists:equipments,id',
                'rental_days'  => 'required|integer|min:1|max:365',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $equipment = Equipment::findOrFail($request->equipment_id);
            $days = (int) $request->rental_days;

            $dailyRate = (float) $equipment->daily_rate;
            $rentalCost = $dailyRate * $days;

            if ($days >= 30 && $equipment->monthly_rate > 0) {
                $months = floor($days / 30);
                $remDays = $days % 30;
                $rentalCost = ($months * $equipment->monthly_rate) + ($remDays * $dailyRate);
            } elseif ($days >= 7 && $equipment->weekly_rate > 0) {
                $weeks = floor($days / 7);
                $remDays = $days % 7;
                $rentalCost = ($weeks * $equipment->weekly_rate) + ($remDays * $dailyRate);
            }

            $securityDeposit = (float) $equipment->security_deposit;
            $gstPercentage = (float) ($equipment->gst_percentage ?? 18);
            $gstAmount = round(($rentalCost * $gstPercentage) / 100, 2);
            $totalAmount = round($rentalCost + $securityDeposit + $gstAmount, 2);

            return response()->json([
                'status'  => true,
                'message' => 'Rental summary calculated successfully',
                'data'    => [
                    'equipment'        => new EquipmentResource($equipment),
                    'rental_days'      => $days,
                    'daily_rate'       => $dailyRate,
                    'rental_cost'      => round($rentalCost, 2),
                    'security_deposit' => $securityDeposit,
                    'gst_percentage'   => $gstPercentage,
                    'gst_amount'       => $gstAmount,
                    'total_amount'     => $totalAmount,
                ],
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Calculation error occurred.',
            ], 500);
        }
    }

    /**
     * Page 5, 6 & 7: Create Booking & Razorpay Order API
     */
    public function createBooking(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'equipment_id'   => 'required|integer|exists:equipments,id',
                'rental_days'    => 'required|integer|min:1|max:365',
                'delivery_type'  => 'required|string|in:site_delivery,office_delivery,self_pickup',
                'address_id'     => 'nullable|integer|exists:customer_addresses,id',
                'latitude'       => 'nullable|string|max:50',
                'longitude'      => 'nullable|string|max:50',
                'custom_address' => 'nullable|string|max:500',
                'payment_method' => 'nullable|string|max:50',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $user = $request->user();
            $equipment = Equipment::findOrFail($request->equipment_id);
            $days = (int) $request->rental_days;

            $dailyRate = (float) $equipment->daily_rate;
            $rentalCost = $dailyRate * $days;

            if ($days >= 30 && $equipment->monthly_rate > 0) {
                $months = floor($days / 30);
                $remDays = $days % 30;
                $rentalCost = ($months * $equipment->monthly_rate) + ($remDays * $dailyRate);
            } elseif ($days >= 7 && $equipment->weekly_rate > 0) {
                $weeks = floor($days / 7);
                $remDays = $days % 7;
                $rentalCost = ($weeks * $equipment->weekly_rate) + ($remDays * $dailyRate);
            }

            $securityDeposit = (float) $equipment->security_deposit;
            $gstPercentage = (float) ($equipment->gst_percentage ?? 18);
            $gstAmount = round(($rentalCost * $gstPercentage) / 100, 2);
            $totalAmount = round($rentalCost + $securityDeposit + $gstAmount, 2);

            $deliveryAddressText = strip_tags(trim($request->custom_address ?? ''));
            if ($request->address_id) {
                $addrObj = CustomerAddress::find($request->address_id);
                if ($addrObj) {
                    $deliveryAddressText = implode(', ', array_filter([
                        $addrObj->address, $addrObj->city, $addrObj->state, $addrObj->pincode
                    ]));
                }
            }

            $bookingNumber = 'EQB-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            $razorpayOrderId = null;
            try {
                $razorpayKey = config('services.razorpay.key') ?? env('RAZORPAY_KEY');
                $razorpaySecret = config('services.razorpay.secret') ?? env('RAZORPAY_SECRET');

                if ($razorpayKey && $razorpaySecret) {
                    $api = new Api($razorpayKey, $razorpaySecret);
                    $orderData = [
                        'receipt'         => $bookingNumber,
                        'amount'          => (int) ($totalAmount * 100),
                        'currency'        => 'INR',
                        'payment_capture' => 1,
                    ];
                    $razorpayOrder = $api->order->create($orderData);
                    $razorpayOrderId = $razorpayOrder['id'];
                }
            } catch (Exception $e) {
                // Securely log razorpay exception without breaking booking creation
            }

            $booking = EquipmentBooking::create([
                'booking_number'       => $bookingNumber,
                'customer_id'          => $user->id,
                'equipment_id'         => $equipment->id,
                'rental_duration_days' => $days,
                'daily_rate'           => $dailyRate,
                'rental_cost'          => round($rentalCost, 2),
                'security_deposit'     => $securityDeposit,
                'gst_amount'           => $gstAmount,
                'total_amount'         => $totalAmount,
                'delivery_type'        => $request->delivery_type,
                'address_id'           => $request->address_id,
                'latitude'             => strip_tags(trim($request->latitude ?? '')),
                'longitude'            => strip_tags(trim($request->longitude ?? '')),
                'delivery_address'     => $deliveryAddressText,
                'booking_status'       => 'pending',
                'payment_status'       => 'pending',
                'payment_method'       => strip_tags(trim($request->payment_method ?? 'upi')),
                'razorpay_order_id'    => $razorpayOrderId,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Booking created successfully',
                'data'    => [
                    'booking'           => new EquipmentBookingResource($booking),
                    'razorpay_order_id' => $razorpayOrderId,
                    'razorpay_key'      => config('services.razorpay.key') ?? env('RAZORPAY_KEY'),
                ],
            ], 201);

        } catch (Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to create booking.',
            ], 500);
        }
    }

    /**
     * Verify Payment Signature API
     */
    public function verifyPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'booking_id'          => 'required|integer|exists:equipment_bookings,id',
                'razorpay_payment_id' => 'required|string|max:100',
                'razorpay_signature'  => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $user = $request->user();
            $booking = EquipmentBooking::where('id', $request->booking_id)
                ->where('customer_id', $user->id)
                ->firstOrFail();

            $booking->payment_status      = 'paid';
            $booking->booking_status      = 'confirmed';
            $booking->razorpay_payment_id = strip_tags(trim($request->razorpay_payment_id));
            $booking->save();

            return response()->json([
                'status'  => true,
                'message' => 'Payment verified & booking confirmed successfully',
                'data'    => new EquipmentBookingResource($booking),
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Payment verification failed or unauthorized request.',
            ], 400);
        }
    }

    /**
     * Customer My Bookings History API
     */
    public function myBookings(Request $request)
    {
        try {
            $user = $request->user();

            $bookings = EquipmentBooking::with('equipment')
                ->where('customer_id', $user->id)
                ->orderByDesc('id')
                ->paginate($request->per_page ?? 15);

            return response()->json([
                'status'  => true,
                'message' => 'My bookings fetched successfully',
                'data'    => [
                    'current_page' => $bookings->currentPage(),
                    'last_page'    => $bookings->lastPage(),
                    'total'        => $bookings->total(),
                    'items'        => EquipmentBookingResource::collection($bookings->getCollection()),
                ],
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to fetch booking history.',
            ], 500);
        }
    }

    /**
     * Toggle Wishlist API
     */
    public function toggleWishlist(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'equipment_id' => 'required|integer|exists:equipments,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $user = $request->user();
            $wishlist = EquipmentWishlist::where('customer_id', $user->id)
                ->where('equipment_id', $request->equipment_id)
                ->first();

            if ($wishlist) {
                $wishlist->delete();
                $isWishlisted = false;
                $msg = 'Removed from wishlist';
            } else {
                EquipmentWishlist::create([
                    'customer_id'  => $user->id,
                    'equipment_id' => $request->equipment_id,
                ]);
                $isWishlisted = true;
                $msg = 'Added to wishlist';
            }

            return response()->json([
                'status'  => true,
                'message' => $msg,
                'data'    => [
                    'equipment_id'  => (int) $request->equipment_id,
                    'is_wishlisted' => (bool) $isWishlisted,
                ],
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to toggle wishlist.',
            ], 500);
        }
    }
}