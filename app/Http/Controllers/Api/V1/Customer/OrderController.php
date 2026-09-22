<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\CourseEnrollment;
use App\Models\CustomerSurvey;
use App\Models\ProductOrder;

class OrderController extends Controller
{
    public function  generateInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'order_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $order = Order::where('id', $request->order_id)->where('customer_id', $request->customer_id)->first();

            if (!$order) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Order ID or Customer ID'
                ], 404);
            }

            $items = [];
            $subtotal = 0;

            if ($order->order_type == 'course') {
                $enrollment = CourseEnrollment::where('id', $order->rel_id)->first();
                if ($enrollment) {
                    $name = $enrollment->course_name;
                    if (!empty($enrollment->course_category_name)) {
                        $name .= ' | Category: ' . $enrollment->course_category_name;
                    }
                    $items[] = [
                        'name' => $name,
                        'quantity' => 1,
                        'unit_price' => $enrollment->amount,
                        'total' => $enrollment->amount,
                    ];
                    $subtotal += $enrollment->amount;
                }
            } elseif ($order->order_type == 'survey') {
                $survey = CustomerSurvey::where('id', $order->rel_id)->first();
                if ($survey) {
                    $items[] = [
                        'name' => $survey->survey_name,
                        'quantity' => 1,
                        'unit_price' => $survey->amount, 
                        'total' => $survey->amount,
                    ];
                    $subtotal += $survey->amount;
                }
            } elseif ($order->order_type == 'product' || $order->order_type == 'rental_product') {
                $productOrder = ProductOrder::where('id', $order->rel_id)->first();
                if ($productOrder) {
                    foreach ($productOrder->items as $item) {
                        $name = $item->product_name;
                        $details = [];
                        if (!empty($item->variant_name)) $details[] = 'Variant: ' . $item->variant_name;
                        if (!empty($item->category_name)) $details[] = 'Category: ' . $item->category_name;
                        if (!empty($item->sub_category_name)) $details[] = 'Sub Category: ' . $item->sub_category_name;
                        if (!empty($item->brand_name)) $details[] = 'Brand: ' . $item->brand_name;
                        
                        if (count($details) > 0) {
                            $name .= ' | ' . implode(' | ', $details);
                        }

                        $items[] = [
                            'name' => $name,
                            'quantity' => $item->quantity,
                            'unit_price' => $item->sale_price,
                            'total' => $item->line_total,
                        ];
                    }
                    $subtotal = $productOrder->subtotal;
                }
            }

            if (empty($subtotal)) {
                $subtotal = $order->amount;
            }

            $enc_id = base64_encode('XPL-' . ($order->id * 8888));
            $downloadLink = route('admin.order.invoice', $enc_id) . '?type=download';
            $date = $order->created_at->format('d / m / Y');

            $order->makeHidden(['created_at', 'updated_at', 'deleted_at']);

            $data = [
                'order' => $order,
                'items' => $items,
                'subtotal' => $subtotal,
                'total' => $order->amount,
                'date' => $date,
                'invoice_download_link' => $downloadLink
            ];

            return response()->json([
                'status' => true,
                'message' => 'Invoice data retrieved successfully',
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
