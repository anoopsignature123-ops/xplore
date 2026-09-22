<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\CustomerSurvey;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
 
Broadcast::routes(['middleware' => ['web', 'auth:web,vendor']]);

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Private channel for a specific survey chat
// This allows both Vendor and Customer to listen to the same channel
Broadcast::channel('survey.chat.{surveyId}', function ($user, $surveyId) {
    $survey = CustomerSurvey::find($surveyId);
    
    if (!$survey) return false;

    // If user is a Vendor
    if (get_class($user) === 'App\Models\Vendor') {
        return (int) $survey->vendor_id === (int) $user->id;
    }
    
    // If user is a Customer
    if (get_class($user) === 'App\Models\Customer' || get_class($user) === 'App\Models\User') {
        return (int) $survey->customer_id === (int) $user->id;
    }

    return false;
}, ['guards' => ['web', 'vendor', 'api', 'sanctum']]);
 