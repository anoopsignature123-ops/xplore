@php
$segment_two = request()->segment(2);
$segment_three = request()->segment(3);
$vendorUser = auth('vendor')->user();
@endphp

<!-- Page Body Start-->
<div class="page-body-wrapper">
<!-- Backdrop for mobile drawer toggle -->
<div class="vp-sidebar-overlay" id="vpSidebarOverlay"></div>

<!-- Page sidebar start-->
<aside class="page-sidebar">
   <div class="left-arrow" id="left-arrow">
      <i class="fa-solid fa-arrow-left"></i>
   </div>

   <div class="main-sidebar" id="main-sidebar">
      <!-- Mini Vendor Profile Card at top of sidebar -->
      @if($vendorUser)
      <div class="sidebar-vendor-profile-card">
         <img src="{{ !empty($vendorUser->profile_image) ? asset($vendorUser->profile_image) : asset($settings->favicon ?? '') }}" alt="{{ $vendorUser->name }}" class="vendor-avatar">
         <div class="vendor-name" title="{{ $vendorUser->name }}">{{ $vendorUser->name }}</div>
         <span class="vendor-badge">
            <i class="fas fa-certificate" style="font-size: 9px;"></i>
            {{ $vendorUser->category ? $vendorUser->category->name : 'Vendor' }}
         </span>
      </div>
      @endif

      <ul class="sidebar-menu" id="simple-bar">
         <!-- 1. Dashboard -->
         <li class="sidebar-list {{ request()->routeIs('vendor.index') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('vendor.index') }}">
               <span class="menu-icon-box"><i class="fa-solid fa-house"></i></span>
               <h6>Dashboard</h6>
            </a>
         </li>

         <!-- 2. My Surveys -->
         <li class="sidebar-list {{ request()->routeIs('vendor.my-survey.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('vendor.my-survey.list') }}">
               <span class="menu-icon-box"><i class="fa-solid fa-clipboard-list"></i></span>
               <h6>My Surveys</h6>
            </a>
         </li>

         <!-- 3. Profile -->
         <li class="sidebar-list {{ request()->routeIs('vendor.profile') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('vendor.profile') }}">
               <span class="menu-icon-box"><i class="fa-solid fa-user-gear"></i></span>
               <h6>Update Profile</h6>
            </a>
         </li>

         <!-- 4. Logout -->
         <li class="sidebar-list mt-3">
            <a class="sidebar-link text-danger" href="{{ route('vendor.logout') }}">
               <span class="menu-icon-box"><i class="fa-solid fa-right-from-bracket text-danger"></i></span>
               <h6 class="text-danger">Logout</h6>
            </a>
         </li>
      </ul>
   </div>
   <div class="right-arrow" id="right-arrow">
      <i class="fa-solid fa-arrow-right"></i>
   </div>
</aside>
