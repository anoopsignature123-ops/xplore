<?php

namespace App\Http\Controllers\Api\V1\Customer;
use App\Http\Controllers\Controller;
use App\Models\Notification; 
use App\Models\Customer; 
use App\Models\WebSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\FirebaseService;
 
class NotificationController extends Controller
{ 

    protected $firebaseService; 

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    } 
 
 

    public function index()
    {
        $notificationList = Notification::query() 
            ->select('title', 'short_detail', 'image','created_at')
            ->where('status', 'Active')
            ->where('created_at', '>=', now()->subDays(7))
            ->orderByDesc('id')
            ->get()
            ->map(function ($notification) { 
                return [
                    'title'        => $notification->title ?? '',
                    'short_detail' => $notification->short_detail ?? '',
                    'image'        => !empty($notification->image) ? asset($notification->image) : '',
                    'created_at'   => !empty($notification->created_at)  ? Carbon::parse($notification->created_at)->format('d-m-Y h:i A')  : '',
                ];
            });

        return response()->json([
            'status'  => true,
            'message' => 'Notification list fetched successfully',
            'data'    => $notificationList 
        ]); 
    } 

    public function testNotification(Request $request)
    {
        $tokens = \App\Models\Customer::where('status', 'Active')
            ->whereNotNull('fcm_token')
            ->where('fcm_token', '!=', '')
            ->whereNotNull('device_id')
            ->where('device_id', '!=', '') 
            ->pluck('fcm_token')
            ->toArray();

        if (empty($tokens)) {
            return response()->json([
                'status' => false,
                'message' => 'No valid tokens found for active customers.'
            ]);
        }

        $successCount = 0;
        $failureCount = 0;
 

          $settings = WebSettings::select('logo')->first();
          $imageUrl = $settings->logo ? asset($settings->logo)  :  null;
                    

        try {
            $tokenChunks = array_chunk($tokens, 100);

            foreach ($tokenChunks as $chunk) {
                $response = $this->firebaseService->sendNotificationToMultiple(
                    $chunk,
                    'Test Notification',
                    'This is a test notification', 
                    $imageUrl, 
                    ['type' => 'test_notification']
                );
                
                if (isset($response['success_count'])) {
                    $successCount += $response['success_count'];
                }
                if (isset($response['failure_count'])) {
                    $failureCount += $response['failure_count']; 
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Test notifications processed successfully.',
                'total_targeted' => count($tokens),
                'success_count' => $successCount,
                'failure_count' => $failureCount,
                'chunks_processed' => count($tokenChunks)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error sending notification: ' . $e->getMessage()
            ], 500);
        }
    }
}