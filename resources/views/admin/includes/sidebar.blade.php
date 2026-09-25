@php
$segment_two = request()->segment(2);
$segment_three = request()->segment(3);
@endphp
<style>
   .sidebar-menu .sidebar-list a.active {
   color: #fff !important;
   background-color: #308e87;
   border-radius: 6px;
   }
   .sidebar-menu .sidebar-list h6 {
   margin-bottom: 0;
   font-weight: 600;
   }
</style>
<!-- Page Body Start-->
<div class="page-body-wrapper">
<!-- Page sidebar start-->
<aside class="page-sidebar">
   <div class="left-arrow" id="left-arrow">
      <i class="fas fa-arrow-left"></i>
   </div>
   <div class="main-sidebar" id="main-sidebar">
      <ul class="sidebar-menu" id="simple-bar">

         <!-- 1. Dashboard -->
         <li class="sidebar-list {{ $segment_two == '' ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.index') }}">
               <i class="fas fa-home me-2"></i>
               <h6>Dashboard</h6>
            </a>
         </li>

           <!-- Masters -->
  @canany(['slider-list', 'slider-add', 'survey-list', 'survey-add', 'faq-list', 'faq-add', 'notification-list', 'notification-add', 'cms-list', 'cms-add'])
  <li class="sidebar-list {{ in_array($segment_two, ['slider', 'survey', 'faq', 'notification', 'cms']) ? 'active' : '' }}">
     <a class="sidebar-link" href="javascript:void(0)">
        <i class="fas fa-layer-group me-2"></i>
        <h6>Masters</h6>
        <i class="fas fa-chevron-right ms-auto"></i>
     </a>
     <ul class="sidebar-submenu" style="{{ in_array($segment_two, ['slider', 'survey', 'faq', 'notification', 'cms']) ? 'display:block;' : '' }}">
        @can('slider-list')
        <li><a class="{{ $segment_two == 'slider' ? 'active' : '' }}" href="{{ route('admin.slider.list') }}">Sliders</a></li>
        @endcan
        @can('survey-list')
        <li><a class="{{ $segment_two == 'survey' ? 'active' : '' }}" href="{{ route('admin.survey.list') }}">Surveys</a></li>
        @endcan
        @can('faq-list')
        <li><a class="{{ $segment_two == 'faq' ? 'active' : '' }}" href="{{ route('admin.faq.list') }}">FAQs</a></li>
        @endcan
        @can('notification-list')
        <li><a class="{{ $segment_two == 'notification' ? 'active' : '' }}" href="{{ route('admin.notification.list') }}">Notifications</a></li>
        @endcan
        @can('cms-list')
        <li><a class="{{ $segment_two == 'cms' ? 'active' : '' }}" href="{{ route('admin.cms.list') }}">CMS Pages</a></li>
        @endcan
     </ul>
  </li>
  @endcanany


      <!-- Products Catalog -->
         @canany(['product-category-list', 'product-sub-category-list', 'product-brand-list', 'product-list'])
         <li class="sidebar-list {{ in_array($segment_two, ['product-category', 'product-sub-category', 'product-brand', 'product']) ? 'active' : '' }}">
            <a class="sidebar-link" href="javascript:void(0)">
               <i class="fas fa-box-open me-2"></i>
               <h6>Product Master</h6>
               <i class="fas fa-chevron-right ms-auto"></i>
            </a>
            <ul class="sidebar-submenu" style="{{ in_array($segment_two, ['product-category', 'product-sub-category', 'product-brand', 'product']) ? 'display:block;' : '' }}">
               @can('product-category-list')
               <li><a class="{{ $segment_two == 'product-category' ? 'active' : '' }}" href="{{ route('admin.product-category.list') }}">Product Category</a></li>
               @endcan
               @can('product-sub-category-list')
               <li><a class="{{ $segment_two == 'product-sub-category' ? 'active' : '' }}" href="{{ route('admin.product-sub-category.list') }}">Product Sub Category</a></li>
               @endcan
               @can('product-brand-list')
               <li><a class="{{ $segment_two == 'product-brand' ? 'active' : '' }}" href="{{ route('admin.product-brand.list') }}">Product Brands</a></li>
               @endcan
               @can('product-list')
               <li><a class="{{ $segment_two == 'product' ? 'active' : '' }}" href="{{ route('admin.product.list') }}">Products</a></li>
               @endcan
            </ul>
         </li>
         @endcanany

         <!-- Courses Catalog -->
         @canany(['course-category-list', 'course-list', 'course-lesson-list'])
         <li class="sidebar-list {{ in_array($segment_two, ['course-category', 'course', 'course-lesson']) ? 'active' : '' }}">
            <a class="sidebar-link" href="javascript:void(0)">
               <i class="fas fa-graduation-cap me-2"></i>
               <h6>Course Master</h6>
               <i class="fas fa-chevron-right ms-auto"></i>
            </a>
            <ul class="sidebar-submenu" style="{{ in_array($segment_two, ['course-category', 'course', 'course-lesson']) ? 'display:block;' : '' }}">
               @can('course-category-list')
               <li><a class="{{ $segment_two == 'course-category' ? 'active' : '' }}" href="{{ route('admin.course-category.list') }}">Course Category</a></li>
               @endcan
               @can('course-list')
               <li><a class="{{ $segment_two == 'course' ? 'active' : '' }}" href="{{ route('admin.course.list') }}">Courses</a></li>
               @endcan
               @can('course-lesson-list')
               <li><a class="{{ $segment_two == 'course-lesson' ? 'active' : '' }}" href="{{ route('admin.course-lesson.list') }}">Course Lessons</a></li>
               @endcan
            </ul>
         </li>
         @endcanany

         <!-- Equipment Rental (Xplore Equips) -->
         <li class="sidebar-list {{ in_array($segment_two, ['equipment', 'equipment-booking']) ? 'active' : '' }}">
            <a class="sidebar-link" href="javascript:void(0)">
               <i class="fas fa-tools me-2"></i>
               <h6>Equipment Rental</h6>
               <i class="fas fa-chevron-right ms-auto"></i>
            </a>
            <ul class="sidebar-submenu" style="{{ in_array($segment_two, ['equipment', 'equipment-booking']) ? 'display:block;' : '' }}">
               <li><a class="{{ $segment_two == 'equipment' && $segment_three == 'list' ? 'active' : '' }}" href="{{ route('admin.equipment.list') }}">Equipments List</a></li>
               <li><a class="{{ $segment_two == 'equipment' && $segment_three == 'add' ? 'active' : '' }}" href="{{ route('admin.equipment.add') }}">Add Equipment</a></li>
               <li><a class="{{ $segment_two == 'equipment-booking' ? 'active' : '' }}" href="{{ route('admin.equipment-booking.list') }}">Rental Bookings</a></li>
            </ul>
         </li>

         <!-- Xplore Build -->
         <li class="sidebar-list {{ in_array($segment_two, ['build-category', 'builder', 'build-inquiry']) ? 'active' : '' }}">
            <a class="sidebar-link" href="javascript:void(0)">
               <i class="fas fa-building me-2"></i>
               <h6>Xplore Build</h6>
               <i class="fas fa-chevron-right ms-auto"></i>
            </a>
            <ul class="sidebar-submenu" style="{{ in_array($segment_two, ['build-category', 'builder', 'build-inquiry']) ? 'display:block;' : '' }}">
               <li><a class="{{ $segment_two == 'build-category' ? 'active' : '' }}" href="{{ route('admin.build-category.list') }}">Build Categories</a></li>
               <li><a class="{{ $segment_two == 'builder' && $segment_three == 'list' ? 'active' : '' }}" href="{{ route('admin.builder.list') }}">Builders List</a></li>
               <li><a class="{{ $segment_two == 'builder' && $segment_three == 'add' ? 'active' : '' }}" href="{{ route('admin.builder.add') }}">Add Builder</a></li>
               <li><a class="{{ $segment_two == 'build-inquiry' ? 'active' : '' }}" href="{{ route('admin.build-inquiry.list') }}">Customer Inquiries</a></li>
            </ul>
         </li>






   <!-- Vendors -->
 @canany(['vendor-list', 'vendor-add'])
 <li class="sidebar-list {{ in_array($segment_two, ['vendor']) ? 'active' : '' }}">
    <a class="sidebar-link" href="javascript:void(0)">
       <i class="fas fa-store me-2"></i>  
       <h6>Vendors</h6>
       <i class="fas fa-chevron-right ms-auto"></i>
    </a>
    <ul class="sidebar-submenu" style="{{ in_array($segment_two, ['vendor']) ? 'display:block;' : '' }}">
       @can('vendor-add')
       <li><a class="{{ $segment_two == 'vendor' && $segment_three == 'add' ? 'active' : '' }}" href="{{ route('admin.vendor.add') }}">Add Vendor</a></li>
       @endcan
       @can('vendor-list')
       <li><a class="{{ $segment_two == 'vendor' && $segment_three == 'list' ? 'active' : '' }}" href="{{ route('admin.vendor.list') }}">Vendor List</a></li>
       @endcan
    </ul>
 </li>
 @endcanany


         <!-- 2. Customers Hub -->
         @canany(['customer-list', 'customer-survey-list', 'product-order-list', 'course-enrollment-list'])
         <li class="sidebar-list {{ in_array($segment_two, ['customer', 'customer-survey', 'product-order','course-enrollment']) ? 'active' : '' }}">
            <a class="sidebar-link" href="javascript:void(0)">
               <i class="fas fa-users me-2"></i>
               <h6>Customers</h6>
               <i class="fas fa-chevron-right ms-auto"></i>
            </a>
            <ul class="sidebar-submenu" style="{{ in_array($segment_two, ['customer', 'customer-survey', 'product-order','course-enrollment']) ? 'display:block;' : '' }}">
               @can('customer-list')
               <li><a class="{{ $segment_two == 'customer' && $segment_three == 'list' ? 'active' : '' }}" href="{{ route('admin.customer.list') }}">Customer List</a></li>
               @endcan
               @can('customer-survey-list')
               <li><a class="{{ $segment_two == 'customer-survey' && $segment_three == 'list' ? 'active' : '' }}" href="{{ route('admin.customer-survey.list') }}">Customer Survey</a></li>
               @endcan
               @can('product-order-list')
               <li><a class="{{ $segment_two == 'product-order' && $segment_three == 'list' ? 'active' : '' }}" href="{{ route('admin.product-order.list') }}">Product Orders</a></li>
               @endcan
               @can('course-enrollment-list')
               <li><a class="{{ $segment_two == 'course-enrollment' && $segment_three == 'list' ? 'active' : '' }}" href="{{ route('admin.course-enrollment.list') }}">Course Enrollments</a></li>
               @endcan
            </ul> 
         </li>
         @endcanany

         
         <!-- Help Queries -->
         @can('help-query-list')
         <li class="sidebar-list {{ in_array($segment_two, ['help-query']) ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.help-query.list') }}">
               <i class="fas fa-headset me-2"></i>
               <h6>Help Queries</h6>
            </a>
         </li>
         @endcan
         

         <!-- All Orders -->
         @can('order-list')
         <li class="sidebar-list {{ in_array($segment_two, ['order']) ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.order.list') }}">
               <i class="fas fa-shopping-cart me-2"></i>
               <h6>Orders</h6>
            </a>
         </li>
         @endcan

         <!-- All Transactions -->
         @can('transaction-list')
         <li class="sidebar-list {{ in_array($segment_two, ['transaction']) ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.transaction.list') }}">
               <i class="fas fa-exchange-alt me-2"></i>
               <h6>Transactions</h6>
            </a>
         </li>
         @endcan



     
         <!-- 13. Role Permission -->
         @canany(['user-list', 'role-list', 'permission-list', 'role-add'])
         <li class="sidebar-list {{ in_array($segment_two, ['users', 'roles', 'permissions']) ? 'active' : '' }}">
            <a class="sidebar-link" href="javascript:void(0)">
               <i class="fas fa-users-cog me-2"></i>
               <h6>Role Permission</h6>
               <i class="fas fa-chevron-right ms-auto"></i>
            </a>
            <ul class="sidebar-submenu" style="{{ in_array($segment_two, ['users', 'roles', 'permissions']) ? 'display:block;' : '' }}">
               @can('role-list')
               <li><a class="{{ $segment_two == 'roles' && $segment_three == 'list' ? 'active' : '' }}" href="{{ route('admin.roles.list') }}">Roles</a></li>
               @endcan
               @can('permission-list')
               <li><a class="{{ $segment_two == 'permissions' && $segment_three == 'list' ? 'active' : '' }}" href="{{ route('admin.permissions.list') }}">Permissions</a></li>
               @endcan
               @can('user-list')
               <li><a class="{{ $segment_two == 'users' && $segment_three == 'list' ? 'active' : '' }}" href="{{ route('admin.users.list') }}">System Users</a></li>
               @endcan
               @can('assign-permissions')
               <li><a class="{{ $segment_two == 'roles' && $segment_three == 'assign-permissions' ? 'active' : '' }}" href="{{ route('admin.roles.assign_permissions_page') }}">Assign Permission</a></li>
               @endcan
            </ul>
         </li>
         @endcanany


        

         <!-- 15. Web Settings -->
         @can('web-setting')
         <li class="sidebar-list {{ in_array($segment_two, ['web-settings']) ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.websettings') }}">
               <i class="fas fa-cogs me-2"></i>
               <h6>Web Settings</h6>
            </a>
         </li>
         @endcan

          <!-- 14. Activity Logs -->
         @can('activity-log')
         <li class="sidebar-list {{ in_array($segment_two, ['activity-logs']) ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.activity-logs.list') }}">
               <i class="fas fa-history me-2"></i>
               <h6>Activity Logs</h6>
            </a>
         </li>
         @endcan
         

         <!-- 15. Logout -->
         <li class="sidebar-list">
            <a class="sidebar-link text-danger" href="{{ route('admin.logout') }}">
               <i class="fas fa-sign-out-alt me-2"></i>
               <h6 class="f-w-600 text-danger">Logout</h6>
            </a>
         </li>

      </ul>
   </div>
   <div class="right-arrow" id="right-arrow">
      <i class="fas fa-arrow-right"></i>
   </div>
</aside>