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
<div class="page-body-wrapper">
<aside class="page-sidebar">
   <div class="left-arrow" id="left-arrow">
      <i class="fa-solid fa-arrow-left"></i>
   </div>
   <div class="main-sidebar" id="main-sidebar">
      <ul class="sidebar-menu" id="simple-bar">

         

         <!-- 1. Dashboard -->
         <li class="sidebar-list {{ request()->routeIs('builder.index') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('builder.index') }}">
               <i class="fas fa-tachometer-alt me-2"></i>
               <h6>Dashboard</h6>
            </a>
         </li>

         <!-- 2. Customer Inquiries -->
         <li class="sidebar-list {{ request()->routeIs('builder.inquiry.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('builder.inquiry.list') }}">
               <i class="fas fa-comments me-2"></i>
               <h6>Customer Inquiries</h6>
            </a>
         </li>

         <!-- 3. Profile & Portfolio Showcase -->
         <li class="sidebar-list {{ request()->routeIs('builder.profile') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('builder.profile') }}">
               <i class="fas fa-user-tie me-2"></i>
               <h6>Profile & Portfolio</h6>
            </a>
         </li>

         <!-- Logout -->
         <li class="sidebar-list">
            <a class="sidebar-link text-danger" href="{{ route('builder.logout') }}">
               <i class="fas fa-power-off me-2"></i>
               <h6 class="f-w-600 text-danger">Logout</h6>
            </a>
         </li>

      </ul>
   </div>
   <div class="right-arrow" id="right-arrow">
      <i class="fa-solid fa-arrow-right"></i>
   </div>
</aside>
