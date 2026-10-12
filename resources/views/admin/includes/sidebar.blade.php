@php
$segment_two = request()->segment(2);
$segment_three = request()->segment(3);
$adminUser = auth()->user();
@endphp

<!-- Page Body Start-->
<div class="page-body-wrapper">
<!-- Backdrop for mobile drawer toggle -->
<div class="vp-sidebar-overlay" id="vpSidebarOverlay"></div>

<!-- Page sidebar start-->
<aside class="page-sidebar">
   <div class="left-arrow" id="left-arrow">
      <i class="fas fa-arrow-left"></i>
   </div>
   <div class="main-sidebar" id="main-sidebar">
      <!-- Mini Admin Profile Card -->
      <div class="sidebar-admin-profile-card">
         @if(!empty($adminUser->profile_pic))
            <img src="{{ asset($adminUser->profile_pic) }}" alt="{{ $adminUser->name ?? 'Admin' }}" class="admin-avatar">
         @else
            <div class="admin-avatar d-flex align-items-center justify-content-center text-white fw-bold" style="background: linear-gradient(135deg, #0d9488, #0f766e); font-size: 15px;">
               {{ strtoupper(substr($adminUser->name ?? 'A', 0, 1)) }}
            </div>
         @endif
         <div class="overflow-hidden">
            <div class="admin-name" title="{{ $adminUser->name ?? 'Super Admin' }}">{{ $adminUser->name ?? 'Super Admin' }}</div>
            <span class="admin-badge">
               <i class="fas fa-crown" style="font-size: 8px;"></i> Master Admin
            </span>
         </div>
      </div>

      <ul class="sidebar-menu" id="simple-bar">

         <!-- 1. Dashboard -->
         <li class="sidebar-list {{ $segment_two == '' ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.index') }}">
               <span class="menu-icon-box"><i class="fas fa-tachometer-alt"></i></span>
               <h6>Dashboard</h6>
            </a>
         </li>

         <!-- Masters -->
         <li class="sidebar-list {{ in_array($segment_two, ['slider', 'survey', 'faq', 'notification', 'cms', 'contact-type']) ? 'active' : '' }}">
            <a class="sidebar-link" href="javascript:void(0)">
               <span class="menu-icon-box"><i class="fas fa-layer-group"></i></span>
               <h6>Masters</h6>
               <i class="fas fa-chevron-right ms-auto"></i>
            </a>
            <ul class="sidebar-submenu" style="{{ in_array($segment_two, ['slider', 'survey', 'faq', 'notification', 'cms', 'contact-type']) ? 'display:block;' : '' }}">
               @can('slider-list')
               <li><a class="{{ $segment_two == 'slider' ? 'active' : '' }}" href="{{ route('admin.slider.list') }}">Sliders</a></li>
               @endcan
               @can('survey-list')
               <li><a class="{{ $segment_two == 'survey' ? 'active' : '' }}" href="{{ route('admin.survey.list') }}">Surveys</a></li>
               @endcan
               @can('faq-list')
               <li><a class="{{ $segment_two == 'faq' ? 'active' : '' }}" href="{{ route('admin.faq.list') }}">FAQs</a></li>
               @endcan
               <li><a class="{{ $segment_two == 'contact-type' ? 'active' : '' }}" href="{{ route('admin.contact-type.list') }}">Contact Types</a></li>
               @can('notification-list')
               <li><a class="{{ $segment_two == 'notification' ? 'active' : '' }}" href="{{ route('admin.notification.list') }}">Notifications</a></li>
               @endcan
               @can('cms-list')
               <li><a class="{{ $segment_two == 'cms' ? 'active' : '' }}" href="{{ route('admin.cms.list') }}">CMS Pages</a></li>
               @endcan
            </ul>
         </li>

         <!-- Products Catalog -->
         @canany(['product-category-list', 'product-sub-category-list', 'product-brand-list', 'product-list'])
         <li class="sidebar-list {{ in_array($segment_two, ['product-category', 'product-sub-category', 'product-brand', 'product']) ? 'active' : '' }}">
            <a class="sidebar-link" href="javascript:void(0)">
               <span class="menu-icon-box"><i class="fas fa-box-open"></i></span>
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
               <span class="menu-icon-box"><i class="fas fa-graduation-cap"></i></span>
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

         <!-- Equipment Rental -->
         <li class="sidebar-list {{ in_array($segment_two, ['equipment', 'equipment-booking']) ? 'active' : '' }}">
            <a class="sidebar-link" href="javascript:void(0)">
               <span class="menu-icon-box"><i class="fas fa-tools"></i></span>
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
               <span class="menu-icon-box"><i class="fas fa-city"></i></span>
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
         <li class="sidebar-list {{ in_array($segment_two, ['vendor', 'vendor-category']) ? 'active' : '' }}">
            <a class="sidebar-link" href="javascript:void(0)">
               <span class="menu-icon-box"><i class="fas fa-store"></i></span>
               <h6>Vendors</h6>
               <i class="fas fa-chevron-right ms-auto"></i>
            </a>
            <ul class="sidebar-submenu" style="{{ in_array($segment_two, ['vendor', 'vendor-category']) ? 'display:block;' : '' }}">
               @can('vendor-add')
               <li><a class="{{ $segment_two == 'vendor' && $segment_three == 'add' ? 'active' : '' }}" href="{{ route('admin.vendor.add') }}">Add Vendor</a></li>
               @endcan
               @can('vendor-list')
               <li><a class="{{ $segment_two == 'vendor' && $segment_three == 'list' ? 'active' : '' }}" href="{{ route('admin.vendor.list') }}">Vendor List</a></li>
               @endcan
               <li><a class="{{ $segment_two == 'vendor-category' ? 'active' : '' }}" href="{{ route('admin.vendor-category.list') }}">Vendor Categories</a></li>
            </ul>
         </li>
         @endcanany

         <!-- Customers Hub -->
         @canany(['customer-list', 'customer-survey-list', 'product-order-list', 'course-enrollment-list'])
         <li class="sidebar-list {{ in_array($segment_two, ['customer', 'customer-survey', 'product-order','course-enrollment']) ? 'active' : '' }}">
            <a class="sidebar-link" href="javascript:void(0)">
               <span class="menu-icon-box"><i class="fas fa-users"></i></span>
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
               <span class="menu-icon-box"><i class="fas fa-headset"></i></span>
               <h6>Help Queries</h6>
            </a>
         </li>
         @endcan

         <!-- Contact Us Queries -->
         <li class="sidebar-list {{ in_array($segment_two, ['contact-us']) ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.contact-us.list') }}">
               <span class="menu-icon-box"><i class="fas fa-envelope-open-text"></i></span>
               <h6>Contact Us Queries</h6>
            </a>
         </li>

         <!-- All Orders -->
         @can('order-list')
         <li class="sidebar-list {{ in_array($segment_two, ['order']) ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.order.list') }}">
               <span class="menu-icon-box"><i class="fas fa-shopping-cart"></i></span>
               <h6>Orders</h6>
            </a>
         </li>
         @endcan

         <!-- All Transactions -->
         @can('transaction-list')
         <li class="sidebar-list {{ in_array($segment_two, ['transaction']) ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.transaction.list') }}">
               <span class="menu-icon-box"><i class="fas fa-exchange-alt"></i></span>
               <h6>Transactions</h6>
            </a>
         </li>
         @endcan

         <!-- Role Permission -->
         @canany(['user-list', 'role-list', 'permission-list', 'role-add'])
         <li class="sidebar-list {{ in_array($segment_two, ['users', 'roles', 'permissions']) ? 'active' : '' }}">
            <a class="sidebar-link" href="javascript:void(0)">
               <span class="menu-icon-box"><i class="fas fa-users-cog"></i></span>
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

         <!-- Web Settings -->
         @can('web-setting')
         <li class="sidebar-list {{ in_array($segment_two, ['web-settings']) ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.websettings') }}">
               <span class="menu-icon-box"><i class="fas fa-cogs"></i></span>
               <h6>Web Settings</h6>
            </a>
         </li>
         @endcan

         <!-- Activity Logs -->
         @can('activity-log')
         <li class="sidebar-list {{ in_array($segment_two, ['activity-logs']) ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.activity-logs.list') }}">
               <span class="menu-icon-box"><i class="fas fa-history"></i></span>
               <h6>Activity Logs</h6>
            </a>
         </li>
         @endcan

         <!-- Logout -->
         <li class="sidebar-list mt-3">
            <a class="sidebar-link text-danger" href="{{ route('admin.logout') }}">
               <span class="menu-icon-box"><i class="fas fa-sign-out-alt text-danger"></i></span>
               <h6 class="text-danger">Logout</h6>
            </a>
         </li>

      </ul>
   </div>
   <div class="right-arrow" id="right-arrow">
      <i class="fas fa-arrow-right"></i>
   </div>
</aside>