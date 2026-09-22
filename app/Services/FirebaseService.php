<?php

namespace App\Services;

use Kreait\Firebase\Factory; 
use Kreait\Firebase\Messaging\CloudMessage;
 
class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $credentials = config('firebase.projects.app.credentials');
        
        // Ensure path is absolute or resolve relative to base path
        $credentialPath = file_exists($credentials) ? $credentials : base_path($credentials);

        if (empty($credentials) || !file_exists($credentialPath)) {
            throw new \Exception('Firebase credentials file not found at: ' . $credentialPath);
        }

        $factory = (new Factory)->withServiceAccount($credentialPath);
        $this->messaging = $factory->createMessaging();
    }

    public function sendNotificationToMultiple(
        array $fcmTokens,string $title,string $body,?string $imageUrl = null,array $data = []): array {
        try {
            if (empty($fcmTokens)) {
                throw new \Exception('FCM tokens are empty.');
            }

            
            $fcmTokens = array_values(array_unique($fcmTokens));
            $payloadData = array_map('strval', array_merge($data, [
                'title' => $title,
                'body'  => $body,
                'image' => (string)($imageUrl ?? ''),
            ]));

            $message = CloudMessage::new()->withData($payloadData);
            $report = $this->messaging->sendMulticast($message, $fcmTokens);

            return [
                'success'        => true,
                'total'          => count($fcmTokens),
                'success_count'  => $report->successes()->count(),
                'failure_count'  => $report->failures()->count(),
            ];
        } catch (\Throwable $e) {
            \Log::error('FCM Multicast Error', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }
}
