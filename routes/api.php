<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Customer\LoginController; 
use App\Http\Controllers\Api\V1\Customer\MasterController;  
use App\Http\Controllers\Api\V1\Customer\NotificationController;  
use App\Http\Controllers\Api\V1\Customer\SurveyController;    
use App\Http\Controllers\Api\V1\Customer\ProductController;     
use App\Http\Controllers\Api\V1\Customer\CartController;     
use App\Http\Controllers\Api\V1\Customer\ProductOrderController;     
use App\Http\Controllers\Api\V1\Customer\ChatController;    
use App\Http\Controllers\Api\V1\Customer\CourseEnrollmentController; 
use App\Http\Controllers\Api\V1\Customer\CustomerAddressController;
use App\Http\Controllers\Api\V1\Customer\PaymentController; 
use App\Http\Controllers\Api\V1\Customer\OrderController;
  
use Illuminate\Support\Facades\Broadcast;

// Register API broadcasting routes for Sanctum token authentication 
Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::prefix('v1')->group(function () {   
    Route::post('/login', [LoginController::class, 'login']); 
    Route::post('/auto-login', [LoginController::class, 'autoLogin']);  
    Route::get('/test-notification', [NotificationController::class, 'testNotification']);  
    Route::post('/cms', [MasterController::class, 'getCms']);


    Route::middleware('auth:sanctum')->group(function () {     
        Route::post('/profile', [LoginController::class, 'profile']); 
        Route::post('/match-otp', [LoginController::class, 'matchOtp']); 
        Route::post('/logout', [LoginController::class, 'logout']); 
        Route::get('/settings', [LoginController::class, 'webSettings']);   
        Route::post('/slider-list', [MasterController::class, 'sliderList']); 
        Route::post('/survey-list', [MasterController::class, 'surveyList']);  
        Route::post('/course-category-list', [MasterController::class, 'courseCategoryList']); 
        Route::post('/course-list', [MasterController::class, 'courseList'])->name('courseList'); 
        Route::post('/course-lesson-list', [MasterController::class, 'courseLessonList']); 
        Route::post('/course-topic-list', [MasterController::class, 'courseTopicList']);    
        Route::post('/course-content-list', [MasterController::class, 'courseContentList']);   
        Route::post('/enroll-course', [CourseEnrollmentController::class, 'enroll']);
        Route::post('/faq-list', [MasterController::class, 'faqList'])->name('faqList');    
        Route::get('/get-help-question', [MasterController::class, 'getHelpQuestion']);
        Route::post('/submit-help-query', [MasterController::class, 'submitHelpQuery']);
        Route::get('/notification-list', [NotificationController::class, 'index']);   
        Route::post('update-profile', [LoginController::class, 'updateProfile']);     
        Route::post('submit-survey', [SurveyController::class, 'submitSurvey']);     
        Route::post('my-survey-list', [SurveyController::class, 'mySurveyList']);     
        Route::get('product-category-list', [ProductController::class, 'productCategoryList']);
        Route::post('product-sub-category-list', [ProductController::class, 'productSubCategoryList']);
        Route::post('product-brand-list', [ProductController::class, 'productBrandList']);
        Route::post('product-list', [ProductController::class, 'productList']);
        Route::post('product-detail', [ProductController::class, 'productDetail']);

        // Customer Address Routes
        Route::post('address-list', [CustomerAddressController::class, 'addressList']);
        Route::post('add-address', [CustomerAddressController::class, 'addUpdate']); 
        Route::post('delete-address', [CustomerAddressController::class, 'destroy']);

        // Cart & Checkout Routes 
        Route::post('cart', [CartController::class, 'viewCart']); 
        Route::post('cart/add', [CartController::class, 'addToCart']); 
        Route::post('cart/reduce', [CartController::class, 'reduceQuantity']);  
        Route::post('cart/remove', [CartController::class, 'removeFromCart']);
        Route::post('checkout', [ProductOrderController::class, 'checkout']);
        
        // Payment Routes
        Route::post('create-order', [PaymentController::class, 'createOrder']);
        Route::post('verify-payment', [PaymentController::class, 'verifyPayment']); 

        // Order & Invoice Routes
        Route::post('invoice', [OrderController::class, 'generateInvoice']);

        // Chat Routes
        Route::post('survey/{id}/chat-history', [ChatController::class, 'getHistory']);
        Route::post('survey/{id}/chats', [ChatController::class, 'sendMessage']);
    });  
   

});


 