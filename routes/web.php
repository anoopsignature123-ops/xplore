<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\{WebSettingController, ProfileController};
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController; 
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseCategoryController;  
use App\Http\Controllers\Admin\SliderController;  
use App\Http\Controllers\Admin\SurveyController;   
use App\Http\Controllers\Admin\CourseController;  
use App\Http\Controllers\Admin\CourseLessonController;   
use App\Http\Controllers\Admin\CourseEnrollmentController;
use App\Http\Controllers\Admin\CourseTopicController;    
use App\Http\Controllers\Admin\CourseContentController;   
use App\Http\Controllers\Admin\FaqController;   
use App\Http\Controllers\Admin\HelpQueryController;   
use App\Http\Controllers\Admin\NotificationController;     
use App\Http\Controllers\SystemClean;   
use App\Http\Controllers\Admin\CustomerController;    
use App\Http\Controllers\Admin\CustomerSurveyController;  
use App\Http\Controllers\Admin\ProductCategoryController;   
use App\Http\Controllers\Admin\ProductBrandController;      
use App\Http\Controllers\Admin\ProductSubCategoryController;      
use App\Http\Controllers\Admin\ProductController;      
use App\Http\Controllers\Admin\CartController;      
use App\Http\Controllers\Admin\ProductOrderController;      
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\EquipmentController;
use App\Http\Controllers\Admin\EquipmentBookingController;
use App\Http\Controllers\Admin\BuildCategoryController;
use App\Http\Controllers\Admin\BuilderController;
use App\Http\Controllers\Admin\BuilderInquiryController;
use App\Http\Controllers\Builder\Auth\LoginController as BuilderLoginController;
use App\Http\Controllers\Builder\DashboardController as BuilderDashboardController;
use App\Http\Controllers\Builder\ProfileController as BuilderProfileController;
use App\Http\Controllers\Builder\InquiryController as BuilderPortalInquiryController;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Public Web Views for Mobile Apps & Web (CMS Pages)
|--------------------------------------------------------------------------
*/
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-conditions', [PageController::class, 'termsConditions'])->name('terms-conditions');
Route::get('/about-us', [PageController::class, 'aboutUs'])->name('about-us');
Route::get('/contact-us', [PageController::class, 'contactUs'])->name('contact-us');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');

Route::get('/', [LoginController::class, 'login'])->name('auth.login'); 
Route::get('/clean-system', [SystemClean::class, 'index'])->name('clean.system'); 

Route::get('/invoice/{enc_id}', [OrderController::class, 'generateInvoice'])->name('admin.order.invoice');
/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
*/



Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('get-sub-categories', [ProductController::class, 'getSubCategories'])->name('get-sub-categories');
    Route::get('get-brands',         [ProductController::class, 'getBrands'])->name('get-brands');
    Route::post('get-variants', [ProductController::class, 'getVariants'])->name('product.getVariants');
    Route::post('get-specifications', [ProductController::class, 'getSpecifications'])->name('product.getSpecifications');
 
    Route::get('/login', [LoginController::class, 'login'])->name('auth.login');
    Route::post('/login', [LoginController::class, 'checkLogin'])->name('checkLogin');

    /*
    |--------------------------------------------------------------------------
    | Protected Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth'])->group(function () {
 
        // Dashboard + Logout
        Route::get('/', [Dashboard::class, 'index'])->name('index');
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

        /*
        |--------------------------------------------------------------------------
        | Web Settings 
        |--------------------------------------------------------------------------
        */
        Route::middleware(['permission:web-setting'])->group(function () {
            Route::get('/web-settings', [WebSettingController::class, 'index'])->name('websettings');
            Route::post('/web-settings/save', [WebSettingController::class, 'save'])->name('websettings.save');
        });

        /*
        |--------------------------------------------------------------------------
        | Profile (no strict permission assumed)
        |--------------------------------------------------------------------------
        */
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('/profile/save', [ProfileController::class, 'save'])->name('profile.save');
        Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');

        /*
        |--------------------------------------------------------------------------
        | Roles Module 
        |--------------------------------------------------------------------------
        */
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/list', [RoleController::class, 'index'])->middleware('permission:role-list')->name('list');
            Route::get('/getRecords', [RoleController::class, 'getRecords'])->middleware('permission:role-list')->name('getRecords');
            Route::get('/add/{id?}', [RoleController::class, 'add'])->middleware('permission:role-add')->name('add');
            Route::post('/save', [RoleController::class, 'save'])->middleware('permission:role-add')->name('save'); 
            Route::get('/assign-permissions', [RoleController::class, 'assignPermissionsPage'])->middleware('permission:assign-permissions')->name('assign_permissions_page');
            Route::post('/get-role-permissions', [RoleController::class, 'getRolePermissions'])->middleware('permission:assign-permissions')->name('get_role_permissions');
            Route::post('/save-permissions', [RoleController::class, 'savePermissions'])->middleware('permission:assign-permissions')->name('save_permissions');
            Route::post('/delete', [RoleController::class, 'delete'])->middleware('permission:role-delete')->name('delete');
        });

        /*
        |--------------------------------------------------------------------------
        | Permissions Module
        |--------------------------------------------------------------------------
        */
        Route::prefix('permissions')->name('permissions.')->group(function () {
            Route::get('/list', [PermissionController::class, 'index'])->middleware('permission:permission-list')->name('list');
            Route::get('/getRecords', [PermissionController::class, 'getRecords'])->middleware('permission:permission-list')->name('getRecords');
            Route::get('/add/{id?}', [PermissionController::class, 'add'])->middleware('permission:permission-add')->name('add');
            Route::post('/save', [PermissionController::class, 'save'])->middleware('permission:permission-add')->name('save');
            Route::post('/delete', [PermissionController::class, 'delete'])->middleware('permission:permission-delete')->name('delete');
        });

        /*
        |--------------------------------------------------------------------------
        | Users Module
        |--------------------------------------------------------------------------
        */
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/list', [UserController::class, 'index'])->middleware('permission:user-list')->name('list');
            Route::get('/getRecords', [UserController::class, 'getRecords'])->middleware('permission:user-list')->name('getRecords');
            Route::get('/add/{id?}', [UserController::class, 'add'])->middleware('permission:user-add')->name('add');
            Route::post('/save', [UserController::class, 'save'])->middleware('permission:user-add')->name('save');
            Route::post('/change-status', [UserController::class, 'changeStatus'])->middleware('permission:user-add')->name('changeStatus');
            Route::post('/delete', [UserController::class, 'delete'])->middleware('permission:user-delete')->name('delete');
        });

        /*
        |--------------------------------------------------------------------------
        | Activity Logs Module
        |--------------------------------------------------------------------------
        */
        Route::prefix('activity-logs')->name('activity-logs.')->group(function () {
            Route::get('/list', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->middleware('permission:activity-log')->name('list');
            Route::post('/clear', [\App\Http\Controllers\Admin\ActivityLogController::class, 'clear'])->middleware('permission:activity-log')->name('clear');
        });
 

        /*
        |--------------------------------------------------------------------------
        | CMS Module
        |--------------------------------------------------------------------------
        */
        Route::prefix('cms')->name('cms.')->group(function () {
            Route::get('/list', [CmsController::class, 'index'])->middleware('permission:cms-list')->name('list');
            Route::get('/getRecords', [CmsController::class, 'getRecords'])->middleware('permission:cms-list')->name('getRecords');
            Route::get('/add/{id?}', [CmsController::class, 'add'])->middleware('permission:cms-add')->name('add');
            Route::post('/save', [CmsController::class, 'save'])->middleware('permission:cms-add')->name('save');
        });

         /*
        |--------------------------------------------------------------------------
        | Slider Module
        |-------------------------------------------------------------------------- 
        */  
        Route::prefix('slider')->name('slider.')->group(function () {
            Route::get('/list', [SliderController::class, 'index'])->middleware('permission:slider-list')->name('list');
            Route::get('/getRecords', [SliderController::class, 'getRecords'])->middleware('permission:slider-list')->name('getRecords');
            Route::get('/add/{id?}', [SliderController::class, 'add'])->middleware('permission:slider-add')->name('add');
            Route::post('/save', [SliderController::class, 'save'])->middleware('permission:slider-add')->name('save');
            Route::post('/change-status', [SliderController::class, 'changeStatus'])->middleware('permission:slider-add')->name('changeStatus');
            Route::post('/delete', [SliderController::class, 'delete'])->middleware('permission:slider-delete')->name('delete');
        });

         /*
        |--------------------------------------------------------------------------
        | survey Module
        |--------------------------------------------------------------------------
        */   
        Route::prefix('survey')->name('survey.')->group(function () {
            Route::get('/list', [SurveyController::class, 'index'])->middleware('permission:survey-list')->name('list');
            Route::get('/getRecords', [SurveyController::class, 'getRecords'])->middleware('permission:survey-list')->name('getRecords');
            Route::get('/add/{id?}', [SurveyController::class, 'add'])->middleware('permission:survey-add')->name('add');
            Route::post('/save', [SurveyController::class, 'save'])->middleware('permission:survey-add')->name('save');
            Route::post('/change-status', [SurveyController::class, 'changeStatus'])->middleware('permission:survey-add')->name('changeStatus');
            Route::post('/delete', [SurveyController::class, 'delete'])->middleware('permission:survey-delete')->name('delete');
        });


         /*
        |--------------------------------------------------------------------------
        | Course Categories Module
        |-------------------------------------------------------------------------- 
        */  
            Route::prefix('course-category')->name('course-category.')->group(function () {
            Route::get('/list', [CourseCategoryController::class, 'index'])->middleware('permission:course-category-list')->name('list');
            Route::get('/getRecords', [CourseCategoryController::class, 'getRecords'])->middleware('permission:course-category-list')->name('getRecords');
            Route::get('/add/{id?}', [CourseCategoryController::class, 'add'])->middleware('permission:course-category-add')->name('add');
            Route::post('/save', [CourseCategoryController::class, 'save'])->middleware('permission:course-category-add')->name('save');
            Route::post('/change-status', [CourseCategoryController::class, 'changeStatus'])->middleware('permission:course-category-add')->name('changeStatus');
            Route::post('/delete', [CourseCategoryController::class, 'delete'])->middleware('permission:course-category-delete')->name('delete');
        });

         /*
        |--------------------------------------------------------------------------
        | course Module
        |--------------------------------------------------------------------------
        */ 
        Route::prefix('course')->name('course.')->group(function () {
            Route::get('/list', [CourseController::class, 'index'])->middleware('permission:course-list')->name('list');
            Route::get('/getRecords', [CourseController::class, 'getRecords'])->middleware('permission:course-list')->name('getRecords');
            Route::get('/add/{id?}', [CourseController::class, 'add'])->middleware('permission:course-add')->name('add');
            Route::post('/save', [CourseController::class, 'save'])->middleware('permission:course-add')->name('save');
            Route::post('/change-status', [CourseController::class, 'changeStatus'])->middleware('permission:course-add')->name('changeStatus');
            Route::post('/delete', [CourseController::class, 'delete'])->middleware('permission:course-delete')->name('delete');
        });

        /*
        |--------------------------------------------------------------------------
        | Course lesson Module
        |-------------------------------------------------------------------------- 
        */   
            Route::prefix('course-lesson')->name('course-lesson.')->group(function () {
            Route::get('/list', [CourseLessonController::class, 'index'])->middleware('permission:course-lesson-list')->name('list');
            Route::get('/getRecords', [CourseLessonController::class, 'getRecords'])->middleware('permission:course-lesson-list')->name('getRecords');
            Route::get('/add/{id?}', [CourseLessonController::class, 'add'])->middleware('permission:course-lesson-add')->name('add');
            Route::post('/save', [CourseLessonController::class, 'save'])->middleware('permission:course-lesson-add')->name('save');
            Route::post('/change-status', [CourseLessonController::class, 'changeStatus'])->middleware('permission:course-lesson-add')->name('changeStatus');
            Route::post('/delete', [CourseLessonController::class, 'delete'])->middleware('permission:course-lesson-delete')->name('delete');
        });

        /*
        |--------------------------------------------------------------------------
        | Transaction Module
        |-------------------------------------------------------------------------- 
        */  
        Route::prefix('transaction')->name('transaction.')->group(function () {
            Route::get('/list', [TransactionController::class, 'index'])->middleware('permission:transaction-list')->name('list');
            Route::get('/getRecords', [TransactionController::class, 'getRecords'])->middleware('permission:transaction-list')->name('getRecords');
        });

        /*
        |--------------------------------------------------------------------------
        | Order Module
        |-------------------------------------------------------------------------- 
        */  
        Route::prefix('order')->name('order.')->group(function () {
            Route::get('/list', [OrderController::class, 'index'])->middleware('permission:order-list')->name('list');
            Route::get('/getRecords', [OrderController::class, 'getRecords'])->middleware('permission:order-list')->name('getRecords');
        });

        /*
        |--------------------------------------------------------------------------
        | Course Enrollment Module
        |--------------------------------------------------------------------------
        */ 
        Route::prefix('course-enrollment')->name('course-enrollment.')->group(function () {
            Route::get('/list', [CourseEnrollmentController::class, 'index'])->middleware('permission:course-enrollment-list')->name('list');
            Route::get('/getRecords', [CourseEnrollmentController::class, 'getRecords'])->middleware('permission:course-enrollment-list')->name('getRecords');
        });

 
        /* 
        |--------------------------------------------------------------------------
        | Course topic Module
        |--------------------------------------------------------------------------
        */
        Route::prefix('course-topic')->name('course-topic.')->group(function () {
            Route::get('/list/{lesson_id}', [CourseTopicController::class, 'index'])->middleware('permission:course-topic-list')->name('list');
            Route::get('/getRecords', [CourseTopicController::class, 'getRecords'])->middleware('permission:course-topic-list')->name('getRecords');
            Route::get('/add/{lesson_id}/{id?}', [CourseTopicController::class, 'add'])->middleware('permission:course-topic-add')->name('add');
            Route::post('/save', [CourseTopicController::class, 'save'])->middleware('permission:course-topic-add')->name('save');
            Route::post('/change-status', [CourseTopicController::class, 'changeStatus'])->middleware('permission:course-topic-add')->name('changeStatus');
            Route::post('/delete', [CourseTopicController::class, 'delete'])->middleware('permission:course-topic-delete')->name('delete');
        });

 
         /* 
        |--------------------------------------------------------------------------
        | Course content Module 
        |--------------------------------------------------------------------------  
        */
        Route::prefix('course-content')->name('course-content.')->group(function () {
            Route::get('/list/{topic_id}', [CourseContentController::class, 'index'])->middleware('permission:course-content-list')->name('list');
            Route::get('/getRecords', [CourseContentController::class, 'getRecords'])->middleware('permission:course-content-list')->name('getRecords');
            Route::get('/add/{topic_id}/{id?}', [CourseContentController::class, 'add'])->middleware('permission:course-content-add')->name('add');
            Route::post('/save', [CourseContentController::class, 'save'])->middleware('permission:course-content-add')->name('save');
            Route::post('/change-status', [CourseContentController::class, 'changeStatus'])->middleware('permission:course-content-add')->name('changeStatus');
            Route::post('/delete', [CourseContentController::class, 'delete'])->middleware('permission:course-content-delete')->name('delete');
        });


          /*
        |--------------------------------------------------------------------------
        | faq Module
        |--------------------------------------------------------------------------
        */ 
        Route::prefix('faq')->name('faq.')->group(function () {
            Route::get('/list', [FaqController::class, 'index'])->middleware('permission:faq-list')->name('list');
            Route::get('/getRecords', [FaqController::class, 'getRecords'])->middleware('permission:faq-list')->name('getRecords');
            Route::get('/add/{id?}', [FaqController::class, 'add'])->middleware('permission:faq-add')->name('add');
            Route::post('/save', [FaqController::class, 'save'])->middleware('permission:faq-add')->name('save');
            Route::post('/change-status', [FaqController::class, 'changeStatus'])->middleware('permission:faq-add')->name('changeStatus');
            Route::post('/delete', [FaqController::class, 'delete'])->middleware('permission:faq-delete')->name('delete');
        });

        /*
        |--------------------------------------------------------------------------
        | Help Query Module
        |--------------------------------------------------------------------------
        */ 
        Route::prefix('help-query')->name('help-query.')->group(function () {
            Route::get('/list', [HelpQueryController::class, 'index'])->middleware('permission:help-query-list')->name('list');
            Route::get('/getRecords', [HelpQueryController::class, 'getRecords'])->middleware('permission:help-query-list')->name('getRecords');
            Route::post('/update-remark', [HelpQueryController::class, 'updateRemark'])->middleware('permission:help-query-list')->name('updateRemark');
            Route::post('/delete', [HelpQueryController::class, 'delete'])->middleware('permission:help-query-delete')->name('delete');
        });


          /*
        |--------------------------------------------------------------------------
        | notification Module
        |--------------------------------------------------------------------------
        */ 
        Route::prefix('notification')->name('notification.')->group(function () {
            Route::get('/list', [NotificationController::class, 'index'])->middleware('permission:notification-list')->name('list');
            Route::get('/getRecords', [NotificationController::class, 'getRecords'])->middleware('permission:notification-list')->name('getRecords');
            Route::get('/add/{id?}', [NotificationController::class, 'add'])->middleware('permission:notification-add')->name('add');
            Route::post('/save', [NotificationController::class, 'save'])->middleware('permission:notification-add')->name('save');
            Route::post('/change-status', [NotificationController::class, 'changeStatus'])->middleware('permission:notification-add')->name('changeStatus');
            Route::post('/delete', [NotificationController::class, 'delete'])->middleware('permission:notification-delete')->name('delete');
        });

           /*
        |--------------------------------------------------------------------------
        | customer Module
        |--------------------------------------------------------------------------
        */ 
        Route::prefix('customer')->name('customer.')->group(function () {
            Route::get('/list', [CustomerController::class, 'index'])->middleware('permission:customer-list')->name('list');
            Route::get('/getRecords', [CustomerController::class, 'getRecords'])->middleware('permission:customer-list')->name('getRecords');
            Route::get('/add/{id?}', [CustomerController::class, 'add'])->middleware('permission:customer-add')->name('add');
            Route::post('/save', [CustomerController::class, 'save'])->middleware('permission:customer-add')->name('save');
            Route::post('/delete', [CustomerController::class, 'delete'])->middleware('permission:customer-delete')->name('delete');
            Route::post('/address/save', [CustomerController::class, 'saveAddress'])->middleware('permission:customer-add')->name('address.save');
            Route::post('/address/delete', [CustomerController::class, 'deleteAddress'])->middleware('permission:customer-delete')->name('address.delete');
        });

        /*  
        |--------------------------------------------------------------------------
        | vendor Module
        |-------------------------------------------------------------- ------------
        */ 
        Route::prefix('vendor')->name('vendor.')->group(function () {
            Route::get('/list', [VendorController::class, 'index'])->middleware('permission:vendor-list')->name('list');
            Route::get('/getRecords', [VendorController::class, 'getRecords'])->middleware('permission:vendor-list')->name('getRecords');
            Route::get('/add/{id?}', [VendorController::class, 'add'])->middleware('permission:vendor-add')->name('add');
            Route::post('/save', [VendorController::class, 'save'])->middleware('permission:vendor-add')->name('save');
            Route::post('/delete', [VendorController::class, 'delete'])->middleware('permission:vendor-delete')->name('delete');
        });

 

        /*
        |--------------------------------------------------------------------------
        | customer Module
        |--------------------------------------------------------------------------
        */ 
        Route::prefix('customer-survey')->name('customer-survey.')->group(function () {
            Route::get('/list', [CustomerSurveyController::class, 'index'])->middleware('permission:customer-survey-list')->name('list');
            Route::get('/getRecords', [CustomerSurveyController::class, 'getRecords'])->middleware('permission:customer-survey-list')->name('getRecords');
            Route::post('/assign-vendor', [CustomerSurveyController::class, 'assignVendor'])->middleware('permission:customer-survey-list')->name('assignVendor');
        });

         /*
        |--------------------------------------------------------------------------
        | Product Category Module
        |--------------------------------------------------------------------------
        */ 
        Route::prefix('product-category')->name('product-category.')->group(function () {
            Route::get('/list', [ProductCategoryController::class, 'index'])->middleware('permission:product-category-list')->name('list');
            Route::get('/getRecords', [ProductCategoryController::class, 'getRecords'])->middleware('permission:product-category-list')->name('getRecords');
            Route::get('/add/{id?}', [ProductCategoryController::class, 'add'])->middleware('permission:product-category-add')->name('add');
            Route::post('/save', [ProductCategoryController::class, 'save'])->middleware('permission:product-category-add')->name('save');
            Route::post('/change-status', [ProductCategoryController::class, 'changeStatus'])->middleware('permission:product-category-add')->name('changeStatus');
            Route::post('/delete', [ProductCategoryController::class, 'delete'])->middleware('permission:product-category-delete')->name('delete');
        });


          /*
        |--------------------------------------------------------------------------
        | Product brand Module
        |--------------------------------------------------------------------------
        */ 
        Route::prefix('product-brand')->name('product-brand.')->group(function () {
            Route::get('/list', [ProductBrandController::class, 'index'])->middleware('permission:product-brand-list')->name('list');
            Route::get('/getRecords', [ProductBrandController::class, 'getRecords'])->middleware('permission:product-brand-list')->name('getRecords');
            Route::get('/add/{id?}', [ProductBrandController::class, 'add'])->middleware('permission:product-brand-add')->name('add');
            Route::post('/save', [ProductBrandController::class, 'save'])->middleware('permission:product-brand-add')->name('save');
            Route::post('/change-status', [ProductBrandController::class, 'changeStatus'])->middleware('permission:product-brand-add')->name('changeStatus');
            Route::post('/delete', [ProductBrandController::class, 'delete'])->middleware('permission:product-brand-delete')->name('delete');
        });

         /*
        |--------------------------------------------------------------------------
        | Product sub category Module
        |-------------------------------------------------------------------------- 
        */ 
        Route::prefix('product-sub-category')->name('product-sub-category.')->group(function () {
            Route::get('/list', [ProductSubCategoryController::class, 'index'])->middleware('permission:product-sub-category-list')->name('list');
            Route::get('/getRecords', [ProductSubCategoryController::class, 'getRecords'])->middleware('permission:product-sub-category-list')->name('getRecords');
            Route::get('/add/{id?}', [ProductSubCategoryController::class, 'add'])->middleware('permission:product-sub-category-add')->name('add');
            Route::post('/save', [ProductSubCategoryController::class, 'save'])->middleware('permission:product-sub-category-add')->name('save');
            Route::post('/change-status', [ProductSubCategoryController::class, 'changeStatus'])->middleware('permission:product-sub-category-add')->name('changeStatus');
            Route::post('/delete', [ProductSubCategoryController::class, 'delete'])->middleware('permission:product-sub-category-delete')->name('delete');
        });

         /* 
        |--------------------------------------------------------------------------
        | Product Module
        |-------------------------------------------------------------------------- 
        */  
        Route::prefix('product')->name('product.')->group(function () {
            Route::get('/list', [ProductController::class, 'index'])->middleware('permission:product-list')->name('list');
            Route::get('/getRecords', [ProductController::class, 'getRecords'])->middleware('permission:product-list')->name('getRecords');
            Route::get('/add/{id?}', [ProductController::class, 'add'])->middleware('permission:product-add')->name('add');
            Route::post('/save', [ProductController::class, 'save'])->middleware('permission:product-add')->name('save');
            Route::post('/change-status', [ProductController::class, 'changeStatus'])->middleware('permission:product-add')->name('changeStatus');
            Route::post('/delete', [ProductController::class, 'delete'])->middleware('permission:product-delete')->name('delete');
        });

         /*
        |--------------------------------------------------------------------------
        | Cart Module
        |--------------------------------------------------------------------------
        */ 
        Route::prefix('cart')->name('cart.')->middleware('permission:cart-list')->group(function () {
            Route::get('/detail/{id}', [CartController::class, 'detail'])->name('detail');
        });

         /*
        |--------------------------------------------------------------------------
        | Order Module
        |--------------------------------------------------------------------------
        */ 
        Route::prefix('product-order')->name('product-order.')->middleware('permission:product-order-list')->group(function () {
            Route::get('/list', [ProductOrderController::class, 'index'])->name('list');
            Route::get('/getRecords', [ProductOrderController::class, 'getRecords'])->name('getRecords');
            Route::get('/detail/{id}', [ProductOrderController::class, 'detail'])->name('detail');
            Route::post('/change-status', [ProductOrderController::class, 'changeStatus'])->name('changeStatus');
        });

        /*
        |--------------------------------------------------------------------------
        | Equipment Master & Rental Booking Modules
        |--------------------------------------------------------------------------
        */
        Route::prefix('equipment')->name('equipment.')->group(function () {
            Route::get('/list', [EquipmentController::class, 'index'])->name('list');
            Route::get('/getRecords', [EquipmentController::class, 'getRecords'])->name('getRecords');
            Route::get('/add/{id?}', [EquipmentController::class, 'add'])->name('add');
            Route::post('/save', [EquipmentController::class, 'save'])->name('save');
            Route::post('/toggle-status', [EquipmentController::class, 'toggleStatus'])->name('toggleStatus');
            Route::delete('/delete/{id}', [EquipmentController::class, 'delete'])->name('delete');
        });

        Route::prefix('equipment-booking')->name('equipment-booking.')->group(function () {
            Route::get('/list', [EquipmentBookingController::class, 'index'])->name('list');
            Route::get('/getRecords', [EquipmentBookingController::class, 'getRecords'])->name('getRecords');
            Route::get('/detail/{id}', [EquipmentBookingController::class, 'detail'])->name('detail');
            Route::post('/update-status/{id}', [EquipmentBookingController::class, 'updateStatus'])->name('updateStatus');
        });

        /*
        |--------------------------------------------------------------------------
        | Xplore Build Modules (Admin)
        |--------------------------------------------------------------------------
        */
        Route::prefix('build-category')->name('build-category.')->group(function () {
            Route::get('/list', [BuildCategoryController::class, 'index'])->name('list');
            Route::get('/getRecords', [BuildCategoryController::class, 'getRecords'])->name('getRecords');
            Route::get('/add/{id?}', [BuildCategoryController::class, 'add'])->name('add');
            Route::post('/save', [BuildCategoryController::class, 'save'])->name('save');
            Route::post('/toggle-status', [BuildCategoryController::class, 'toggleStatus'])->name('toggleStatus');
            Route::delete('/delete/{id}', [BuildCategoryController::class, 'delete'])->name('delete');
        });

        Route::prefix('builder')->name('builder.')->group(function () {
            Route::get('/list', [BuilderController::class, 'index'])->name('list');
            Route::get('/getRecords', [BuilderController::class, 'getRecords'])->name('getRecords');
            Route::get('/add/{id?}', [BuilderController::class, 'add'])->name('add');
            Route::post('/save', [BuilderController::class, 'save'])->name('save');
            Route::post('/toggle-verify', [BuilderController::class, 'toggleVerify'])->name('toggleVerify');
            Route::post('/toggle-status', [BuilderController::class, 'toggleStatus'])->name('toggleStatus');
            Route::delete('/delete/{id}', [BuilderController::class, 'delete'])->name('delete');
        });

        Route::prefix('build-inquiry')->name('build-inquiry.')->group(function () {
            Route::get('/list', [BuilderInquiryController::class, 'index'])->name('list');
            Route::get('/getRecords', [BuilderInquiryController::class, 'getRecords'])->name('getRecords');
            Route::post('/update-status', [BuilderInquiryController::class, 'updateStatus'])->name('updateStatus');
        });

    });
});

/*
|--------------------------------------------------------------------------
| Dedicated Builder / Contractor Portal Routes (/builder)
|--------------------------------------------------------------------------
*/
Route::prefix('builder')->name('builder.')->group(function () {
    Route::get('/login', [BuilderLoginController::class, 'login'])->name('auth.login');
    Route::post('/login', [BuilderLoginController::class, 'checkLogin'])->name('checkLogin');

    Route::middleware(['auth:builder'])->group(function () {
        Route::get('/', [BuilderDashboardController::class, 'index'])->name('index');
        Route::get('/logout', [BuilderLoginController::class, 'logout'])->name('logout');

        // Profile & Portfolio
        Route::get('/profile', [BuilderProfileController::class, 'index'])->name('profile');
        Route::post('/profile/save', [BuilderProfileController::class, 'save'])->name('profile.save');
        Route::post('/profile/change-password', [BuilderProfileController::class, 'changePassword'])->name('profile.changePassword');
        Route::post('/profile/add-portfolio', [BuilderProfileController::class, 'addPortfolio'])->name('profile.addPortfolio');
        Route::delete('/profile/delete-portfolio/{id}', [BuilderProfileController::class, 'deletePortfolio'])->name('profile.deletePortfolio');
        Route::post('/profile/add-project', [BuilderProfileController::class, 'addProject'])->name('profile.addProject');
        Route::delete('/profile/delete-project/{id}', [BuilderProfileController::class, 'deleteProject'])->name('profile.deleteProject');

        // Inquiries
        Route::prefix('inquiry')->name('inquiry.')->group(function () {
            Route::get('/list', [BuilderPortalInquiryController::class, 'index'])->name('list');
            Route::get('/getRecords', [BuilderPortalInquiryController::class, 'getRecords'])->name('getRecords');
            Route::post('/update-status', [BuilderPortalInquiryController::class, 'updateStatus'])->name('updateStatus');
        });
    });
});