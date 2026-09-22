<?php
namespace App\Traits;
 
trait SendOtpTrait
{
    public function sendSms(string $mobile, string $name, string $otp)
    {
        // Fetch configuration from .env
        $apiUrl     = getenv('SMS_API_URL');  
        $apiKey     = getenv('SMS_API_KEY');   
        $senderName = getenv('SMS_SENDER_NAME'); 
        $templateId = getenv('SMS_TEMPLATE_ID');

        $postData = [
            'api_key'      => $apiKey,
            'sender_name'  => $senderName, 
            'phone_number' => $mobile,
            'message'      => "Dear {$name}, customer your otp is {$otp}",
            'template_id'  => $templateId
        ]; 

        $curl = curl_init(); 
        curl_setopt_array($curl, [
            CURLOPT_URL            => $apiUrl,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($postData),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT        => 10,
        ]);

        $response = curl_exec($curl);
        $error    = curl_error($curl);
        curl_close($curl);
 
        return [
            'api_url'  => $apiUrl,
            'response' => $response,
            'error'    => $error
        ];
    }
}
