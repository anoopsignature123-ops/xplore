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
      <i class="fa-solid fa-arrow-left"></i>
   </div>
   <div class="main-sidebar" id="main-sidebar">
      <ul class="sidebar-menu" id="simple-bar">

         <!-- 1. Dashboard -->
         <li class="sidebar-list {{ request()->routeIs('vendor.index') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('vendor.index') }}">
               <i class="fa-solid fa-house me-2"></i>
               <h6>Dashboard</h6>
            </a>
         </li>


           <!-- 3. My Surveys -->
         <li class="sidebar-list {{ request()->routeIs('vendor.my-survey.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('vendor.my-survey.list') }}">
               <i class="fa-solid fa-clipboard-list me-2"></i>
               <h6>My Surveys</h6>
            </a>
         </li>
         

         <!-- 2. Profile -->
         <li class="sidebar-list {{ request()->routeIs('vendor.profile') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('vendor.profile') }}">
               <i class="fa-solid fa-user me-2"></i>
               <h6>Update Profile</h6>
            </a>
         </li>

       

         <!-- Logout -->
         <li class="sidebar-list">
            <a class="sidebar-link text-danger" href="{{ route('vendor.logout') }}">
               <i class="fa-solid fa-right-from-bracket me-2"></i>
               <h6 class="f-w-600 text-danger">Logout</h6>
            </a>
         </li>

      </ul>
   </div>
   <div class="right-arrow" id="right-arrow">
      <i class="fa-solid fa-arrow-right"></i>
   </div>
</aside>
