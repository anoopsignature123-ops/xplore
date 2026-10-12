@php
$segment_two = request()->segment(2);
$segment_three = request()->segment(3);
$builderUser = auth('builder')->user();
@endphp

<!-- Page Body Start-->
<div class="page-body-wrapper">
<!-- Backdrop for mobile drawer toggle -->
<div class="vp-sidebar-overlay" id="vpSidebarOverlay"></div>

<aside class="page-sidebar">
   <div class="left-arrow" id="left-arrow">
      <i class="fa-solid fa-arrow-left"></i>
   </div>

   <div class="main-sidebar" id="main-sidebar">
      <!-- Mini Builder Profile Card at top of sidebar -->
      @if($builderUser)
      <div class="sidebar-vendor-profile-card">
         <img src="{{ !empty($builderUser->profile_image) ? asset($builderUser->profile_image) : asset($settings->favicon ?? '') }}" alt="{{ $builderUser->firm_name }}" class="vendor-avatar">
         <div class="vendor-name" title="{{ $builderUser->firm_name }}">{{ $builderUser->firm_name }}</div>
         <span class="vendor-badge">
            <i class="fas fa-hammer" style="font-size: 9px;"></i>
            {{ $builderUser->category ? $builderUser->category->name : 'Builder / Contractor' }}
         </span>
      </div>
      @endif

      <ul class="sidebar-menu" id="simple-bar">
         <!-- 1. Dashboard -->
         <li class="sidebar-list {{ request()->routeIs('builder.index') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('builder.index') }}">
               <span class="menu-icon-box"><i class="fas fa-tachometer-alt"></i></span>
               <h6>Dashboard</h6>
            </a>
         </li>

         <!-- 2. Customer Inquiries -->
         <li class="sidebar-list {{ request()->routeIs('builder.inquiry.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('builder.inquiry.list') }}">
               <span class="menu-icon-box"><i class="fas fa-comments"></i></span>
               <h6>Customer Inquiries</h6>
            </a>
         </li>

         <!-- 3. Profile & Portfolio Showcase -->
         <li class="sidebar-list {{ request()->routeIs('builder.profile') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('builder.profile') }}">
               <span class="menu-icon-box"><i class="fas fa-user-tie"></i></span>
               <h6>Profile & Portfolio</h6>
            </a>
         </li>

         <!-- 4. Logout -->
         <li class="sidebar-list mt-3">
            <a class="sidebar-link text-danger" href="{{ route('builder.logout') }}">
               <span class="menu-icon-box"><i class="fas fa-right-from-bracket text-danger"></i></span>
               <h6 class="text-danger">Logout</h6>
            </a>
         </li>
      </ul>
   </div>
   <div class="right-arrow" id="right-arrow">
      <i class="fa-solid fa-arrow-right"></i>
   </div>
</aside>
