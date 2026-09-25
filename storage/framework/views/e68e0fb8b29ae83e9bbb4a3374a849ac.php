<?php
$segment_two = request()->segment(2);
$segment_three = request()->segment(3);
?>
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
         <li class="sidebar-list <?php echo e($segment_two == '' ? 'active' : ''); ?>">
            <a class="sidebar-link" href="<?php echo e(route('admin.index')); ?>">
               <i class="fas fa-home me-2"></i>
               <h6>Dashboard</h6>
            </a>
         </li>

           <!-- Masters -->
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['slider-list', 'slider-add', 'survey-list', 'survey-add', 'faq-list', 'faq-add', 'notification-list', 'notification-add', 'cms-list', 'cms-add'])): ?>
  <li class="sidebar-list <?php echo e(in_array($segment_two, ['slider', 'survey', 'faq', 'notification', 'cms']) ? 'active' : ''); ?>">
     <a class="sidebar-link" href="javascript:void(0)">
        <i class="fas fa-layer-group me-2"></i>
        <h6>Masters</h6>
        <i class="fas fa-chevron-right ms-auto"></i>
     </a>
     <ul class="sidebar-submenu" style="<?php echo e(in_array($segment_two, ['slider', 'survey', 'faq', 'notification', 'cms']) ? 'display:block;' : ''); ?>">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('slider-list')): ?>
        <li><a class="<?php echo e($segment_two == 'slider' ? 'active' : ''); ?>" href="<?php echo e(route('admin.slider.list')); ?>">Sliders</a></li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('survey-list')): ?>
        <li><a class="<?php echo e($segment_two == 'survey' ? 'active' : ''); ?>" href="<?php echo e(route('admin.survey.list')); ?>">Surveys</a></li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('faq-list')): ?>
        <li><a class="<?php echo e($segment_two == 'faq' ? 'active' : ''); ?>" href="<?php echo e(route('admin.faq.list')); ?>">FAQs</a></li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('notification-list')): ?>
        <li><a class="<?php echo e($segment_two == 'notification' ? 'active' : ''); ?>" href="<?php echo e(route('admin.notification.list')); ?>">Notifications</a></li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cms-list')): ?>
        <li><a class="<?php echo e($segment_two == 'cms' ? 'active' : ''); ?>" href="<?php echo e(route('admin.cms.list')); ?>">CMS Pages</a></li>
        <?php endif; ?>
     </ul>
  </li>
  <?php endif; ?>


      <!-- Products Catalog -->
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['product-category-list', 'product-sub-category-list', 'product-brand-list', 'product-list'])): ?>
         <li class="sidebar-list <?php echo e(in_array($segment_two, ['product-category', 'product-sub-category', 'product-brand', 'product']) ? 'active' : ''); ?>">
            <a class="sidebar-link" href="javascript:void(0)">
               <i class="fas fa-box-open me-2"></i>
               <h6>Product Master</h6>
               <i class="fas fa-chevron-right ms-auto"></i>
            </a>
            <ul class="sidebar-submenu" style="<?php echo e(in_array($segment_two, ['product-category', 'product-sub-category', 'product-brand', 'product']) ? 'display:block;' : ''); ?>">
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-category-list')): ?>
               <li><a class="<?php echo e($segment_two == 'product-category' ? 'active' : ''); ?>" href="<?php echo e(route('admin.product-category.list')); ?>">Product Category</a></li>
               <?php endif; ?>
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-sub-category-list')): ?>
               <li><a class="<?php echo e($segment_two == 'product-sub-category' ? 'active' : ''); ?>" href="<?php echo e(route('admin.product-sub-category.list')); ?>">Product Sub Category</a></li>
               <?php endif; ?>
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-brand-list')): ?>
               <li><a class="<?php echo e($segment_two == 'product-brand' ? 'active' : ''); ?>" href="<?php echo e(route('admin.product-brand.list')); ?>">Product Brands</a></li>
               <?php endif; ?>
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-list')): ?>
               <li><a class="<?php echo e($segment_two == 'product' ? 'active' : ''); ?>" href="<?php echo e(route('admin.product.list')); ?>">Products</a></li>
               <?php endif; ?>
            </ul>
         </li>
         <?php endif; ?>

         <!-- Courses Catalog -->
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['course-category-list', 'course-list', 'course-lesson-list'])): ?>
         <li class="sidebar-list <?php echo e(in_array($segment_two, ['course-category', 'course', 'course-lesson']) ? 'active' : ''); ?>">
            <a class="sidebar-link" href="javascript:void(0)">
               <i class="fas fa-graduation-cap me-2"></i>
               <h6>Course Master</h6>
               <i class="fas fa-chevron-right ms-auto"></i>
            </a>
            <ul class="sidebar-submenu" style="<?php echo e(in_array($segment_two, ['course-category', 'course', 'course-lesson']) ? 'display:block;' : ''); ?>">
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('course-category-list')): ?>
               <li><a class="<?php echo e($segment_two == 'course-category' ? 'active' : ''); ?>" href="<?php echo e(route('admin.course-category.list')); ?>">Course Category</a></li>
               <?php endif; ?>
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('course-list')): ?>
               <li><a class="<?php echo e($segment_two == 'course' ? 'active' : ''); ?>" href="<?php echo e(route('admin.course.list')); ?>">Courses</a></li>
               <?php endif; ?>
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('course-lesson-list')): ?>
               <li><a class="<?php echo e($segment_two == 'course-lesson' ? 'active' : ''); ?>" href="<?php echo e(route('admin.course-lesson.list')); ?>">Course Lessons</a></li>
               <?php endif; ?>
            </ul>
         </li>
         <?php endif; ?>

         <!-- Equipment Rental (Xplore Equips) -->
         <li class="sidebar-list <?php echo e(in_array($segment_two, ['equipment', 'equipment-booking']) ? 'active' : ''); ?>">
            <a class="sidebar-link" href="javascript:void(0)">
               <i class="fas fa-tools me-2"></i>
               <h6>Equipment Rental</h6>
               <i class="fas fa-chevron-right ms-auto"></i>
            </a>
            <ul class="sidebar-submenu" style="<?php echo e(in_array($segment_two, ['equipment', 'equipment-booking']) ? 'display:block;' : ''); ?>">
               <li><a class="<?php echo e($segment_two == 'equipment' && $segment_three == 'list' ? 'active' : ''); ?>" href="<?php echo e(route('admin.equipment.list')); ?>"><i class="fas fa-list me-2"></i> Equipments List</a></li>
               <li><a class="<?php echo e($segment_two == 'equipment' && $segment_three == 'add' ? 'active' : ''); ?>" href="<?php echo e(route('admin.equipment.add')); ?>"><i class="fas fa-plus-circle me-2"></i> Add Equipment</a></li>
               <li><a class="<?php echo e($segment_two == 'equipment-booking' ? 'active' : ''); ?>" href="<?php echo e(route('admin.equipment-booking.list')); ?>"><i class="fas fa-calendar-check me-2"></i> Rental Bookings</a></li>
            </ul>
         </li>

         <!-- Xplore Build -->
         <li class="sidebar-list <?php echo e(in_array($segment_two, ['build-category', 'builder', 'build-inquiry']) ? 'active' : ''); ?>">
            <a class="sidebar-link" href="javascript:void(0)">
               <i class="fas fa-building me-2"></i>
               <h6>Xplore Build</h6>
               <i class="fas fa-chevron-right ms-auto"></i>
            </a>
            <ul class="sidebar-submenu" style="<?php echo e(in_array($segment_two, ['build-category', 'builder', 'build-inquiry']) ? 'display:block;' : ''); ?>">
               <li><a class="<?php echo e($segment_two == 'build-category' ? 'active' : ''); ?>" href="<?php echo e(route('admin.build-category.list')); ?>"><i class="fas fa-th-large me-2"></i> Build Categories</a></li>
               <li><a class="<?php echo e($segment_two == 'builder' && $segment_three == 'list' ? 'active' : ''); ?>" href="<?php echo e(route('admin.builder.list')); ?>"><i class="fas fa-user-tie me-2"></i> Builders List</a></li>
               <li><a class="<?php echo e($segment_two == 'builder' && $segment_three == 'add' ? 'active' : ''); ?>" href="<?php echo e(route('admin.builder.add')); ?>"><i class="fas fa-user-plus me-2"></i> Add Builder</a></li>
               <li><a class="<?php echo e($segment_two == 'build-inquiry' ? 'active' : ''); ?>" href="<?php echo e(route('admin.build-inquiry.list')); ?>"><i class="fas fa-headset me-2"></i> Customer Inquiries</a></li>
            </ul>
         </li>






   <!-- Vendors -->
 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['vendor-list', 'vendor-add'])): ?>
 <li class="sidebar-list <?php echo e(in_array($segment_two, ['vendor']) ? 'active' : ''); ?>">
    <a class="sidebar-link" href="javascript:void(0)">
       <i class="fas fa-store me-2"></i>  
       <h6>Vendors</h6>
       <i class="fas fa-chevron-right ms-auto"></i>
    </a>
    <ul class="sidebar-submenu" style="<?php echo e(in_array($segment_two, ['vendor']) ? 'display:block;' : ''); ?>">
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vendor-add')): ?>
       <li><a class="<?php echo e($segment_two == 'vendor' && $segment_three == 'add' ? 'active' : ''); ?>" href="<?php echo e(route('admin.vendor.add')); ?>">Add Vendor</a></li>
       <?php endif; ?>
       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vendor-list')): ?>
       <li><a class="<?php echo e($segment_two == 'vendor' && $segment_three == 'list' ? 'active' : ''); ?>" href="<?php echo e(route('admin.vendor.list')); ?>">Vendor List</a></li>
       <?php endif; ?>
    </ul>
 </li>
 <?php endif; ?>


         <!-- 2. Customers Hub -->
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['customer-list', 'customer-survey-list', 'product-order-list', 'course-enrollment-list'])): ?>
         <li class="sidebar-list <?php echo e(in_array($segment_two, ['customer', 'customer-survey', 'product-order','course-enrollment']) ? 'active' : ''); ?>">
            <a class="sidebar-link" href="javascript:void(0)">
               <i class="fas fa-users me-2"></i>
               <h6>Customers</h6>
               <i class="fas fa-chevron-right ms-auto"></i>
            </a>
            <ul class="sidebar-submenu" style="<?php echo e(in_array($segment_two, ['customer', 'customer-survey', 'product-order','course-enrollment']) ? 'display:block;' : ''); ?>">
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer-list')): ?>
               <li><a class="<?php echo e($segment_two == 'customer' && $segment_three == 'list' ? 'active' : ''); ?>" href="<?php echo e(route('admin.customer.list')); ?>">Customer List</a></li>
               <?php endif; ?>
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer-survey-list')): ?>
               <li><a class="<?php echo e($segment_two == 'customer-survey' && $segment_three == 'list' ? 'active' : ''); ?>" href="<?php echo e(route('admin.customer-survey.list')); ?>">Customer Survey</a></li>
               <?php endif; ?>
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-order-list')): ?>
               <li><a class="<?php echo e($segment_two == 'product-order' && $segment_three == 'list' ? 'active' : ''); ?>" href="<?php echo e(route('admin.product-order.list')); ?>">Product Orders</a></li>
               <?php endif; ?>
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('course-enrollment-list')): ?>
               <li><a class="<?php echo e($segment_two == 'course-enrollment' && $segment_three == 'list' ? 'active' : ''); ?>" href="<?php echo e(route('admin.course-enrollment.list')); ?>">Course Enrollments</a></li>
               <?php endif; ?>
            </ul> 
         </li>
         <?php endif; ?>

         
         <!-- Help Queries -->
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('help-query-list')): ?>
         <li class="sidebar-list <?php echo e(in_array($segment_two, ['help-query']) ? 'active' : ''); ?>">
            <a class="sidebar-link" href="<?php echo e(route('admin.help-query.list')); ?>">
               <i class="fas fa-headset me-2"></i>
               <h6>Help Queries</h6>
            </a>
         </li>
         <?php endif; ?>
         

         <!-- All Orders -->
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('order-list')): ?>
         <li class="sidebar-list <?php echo e(in_array($segment_two, ['order']) ? 'active' : ''); ?>">
            <a class="sidebar-link" href="<?php echo e(route('admin.order.list')); ?>">
               <i class="fas fa-shopping-cart me-2"></i>
               <h6>Orders</h6>
            </a>
         </li>
         <?php endif; ?>

         <!-- All Transactions -->
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transaction-list')): ?>
         <li class="sidebar-list <?php echo e(in_array($segment_two, ['transaction']) ? 'active' : ''); ?>">
            <a class="sidebar-link" href="<?php echo e(route('admin.transaction.list')); ?>">
               <i class="fas fa-exchange-alt me-2"></i>
               <h6>Transactions</h6>
            </a>
         </li>
         <?php endif; ?>



     
         <!-- 13. Role Permission -->
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['user-list', 'role-list', 'permission-list', 'role-add'])): ?>
         <li class="sidebar-list <?php echo e(in_array($segment_two, ['users', 'roles', 'permissions']) ? 'active' : ''); ?>">
            <a class="sidebar-link" href="javascript:void(0)">
               <i class="fas fa-users-cog me-2"></i>
               <h6>Role Permission</h6>
               <i class="fas fa-chevron-right ms-auto"></i>
            </a>
            <ul class="sidebar-submenu" style="<?php echo e(in_array($segment_two, ['users', 'roles', 'permissions']) ? 'display:block;' : ''); ?>">
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-list')): ?>
               <li><a class="<?php echo e($segment_two == 'roles' && $segment_three == 'list' ? 'active' : ''); ?>" href="<?php echo e(route('admin.roles.list')); ?>">Roles</a></li>
               <?php endif; ?>
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission-list')): ?>
               <li><a class="<?php echo e($segment_two == 'permissions' && $segment_three == 'list' ? 'active' : ''); ?>" href="<?php echo e(route('admin.permissions.list')); ?>">Permissions</a></li>
               <?php endif; ?>
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-list')): ?>
               <li><a class="<?php echo e($segment_two == 'users' && $segment_three == 'list' ? 'active' : ''); ?>" href="<?php echo e(route('admin.users.list')); ?>">System Users</a></li>
               <?php endif; ?>
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assign-permissions')): ?>
               <li><a class="<?php echo e($segment_two == 'roles' && $segment_three == 'assign-permissions' ? 'active' : ''); ?>" href="<?php echo e(route('admin.roles.assign_permissions_page')); ?>">Assign Permission</a></li>
               <?php endif; ?>
            </ul>
         </li>
         <?php endif; ?>


        

         <!-- 15. Web Settings -->
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('web-setting')): ?>
         <li class="sidebar-list <?php echo e(in_array($segment_two, ['web-settings']) ? 'active' : ''); ?>">
            <a class="sidebar-link" href="<?php echo e(route('admin.websettings')); ?>">
               <i class="fas fa-cogs me-2"></i>
               <h6>Web Settings</h6>
            </a>
         </li>
         <?php endif; ?>

          <!-- 14. Activity Logs -->
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('activity-log')): ?>
         <li class="sidebar-list <?php echo e(in_array($segment_two, ['activity-logs']) ? 'active' : ''); ?>">
            <a class="sidebar-link" href="<?php echo e(route('admin.activity-logs.list')); ?>">
               <i class="fas fa-history me-2"></i>
               <h6>Activity Logs</h6>
            </a>
         </li>
         <?php endif; ?>
         

         <!-- 15. Logout -->
         <li class="sidebar-list">
            <a class="sidebar-link text-danger" href="<?php echo e(route('admin.logout')); ?>">
               <i class="fas fa-sign-out-alt me-2"></i>
               <h6 class="f-w-600 text-danger">Logout</h6>
            </a>
         </li>

      </ul>
   </div>
   <div class="right-arrow" id="right-arrow">
      <i class="fas fa-arrow-right"></i>
   </div>
</aside><?php /**PATH C:\xampp\htdocs\xplore-22-09-26\resources\views/admin/includes/sidebar.blade.php ENDPATH**/ ?>