<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\Auth\LoginController;
use App\Http\Controllers\Vendor\DashboardController;
use App\Http\Controllers\Vendor\ProfileController;
use App\Http\Controllers\Vendor\ChatController;
use App\Http\Controllers\Vendor\MySurveyController;



Route::prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('auth.login');
    Route::post('/login', [LoginController::class, 'checkLogin'])->name('checkLogin');

    Route::middleware(['checkVendorLogin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

        // Profile
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('/profile/save', [ProfileController::class, 'save'])->name('profile.save');
        Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');

        // My Surveys
        Route::prefix('my-survey')->name('my-survey.')->group(function () {
            Route::get('/list', [MySurveyController::class, 'index'])->name('list');
            Route::get('/getRecords', [MySurveyController::class, 'getRecords'])->name('getRecords');
            // Chat
            Route::get('/chat/{id}', [ChatController::class, 'chatPage'])->name('chat');
            Route::post('/chat/{id}/history', [ChatController::class, 'getChatHistory'])->name('chat.history');
            Route::post('/chat/{id}/send', [ChatController::class, 'sendChatMessage'])->name('chat.send');
            Route::post('/chat/{id}/complete', [ChatController::class, 'markAsComplete'])->name('chat.complete');
        });
    }); 
});
