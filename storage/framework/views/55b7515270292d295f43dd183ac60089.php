
  <body>
    <!-- page-wrapper Start-->
    <!-- tap on top starts-->
    <div class="tap-top"><i class="fas fa-arrow-up"></i></div>
    <!-- tap on tap ends-->
    <!-- loader-->
    <div class="loader-wrapper">
      <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
    </div>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">   
      <header class="page-header row">
        <div class="logo-wrapper d-flex align-items-center col-auto">
          
        <a href="<?php echo e(route('admin.index')); ?>">	
          <img class="light-logo img-fluid" src="<?php echo e(!empty($settings->logo) ? asset($settings->logo) : ''); ?>" alt="<?php echo e($settings -> company_name ?? ''); ?>" style="width:auto;height:60px;">
          <img class="dark-logo img-fluid" src="<?php echo e(!empty($settings->logo) ? asset($settings->logo) : ''); ?>" alt="<?php echo e($settings -> company_name  ?? ''); ?>" style="width:auto;height:60px;">
        </a>
     
     
          <a class="close-btn toggle-sidebar" href="javascript:void(0)">
            <svg class="svg-color">
              <use href="<?php echo e(config('app.admin_assets')); ?>svg/iconly-sprite.svg#Category"></use>
            </svg></a></div>
        <div class="page-main-header col">
          <div class="header-left">
          </div>


          <div class="nav-right">
            <ul class="header-right"> 
             <li class="custom-dropdown">
            </li>


              <li class="profile-nav custom-dropdown">
                <div class="user-wrap">
                  <div class="user-img"><img src="<?php echo e(!empty(auth()->user()->profile_pic) ? asset(auth()->user()->profile_pic) : asset($settings->favicon ?? '')); ?>" alt="<?php echo e(auth()->user()->name); ?>"></div>
                  <div class="user-content">
                    <?php if(auth()->check()): ?>
                    <h6><?php echo e(auth()->user()->name); ?></h6>
                    <?php endif; ?>
                    <p class="mb-0">Admin<i class="fa-solid fa-chevron-down"></i></p>
                  </div>
                </div>
                <div class="custom-menu overflow-hidden">
                  <ul class="profile-body">
                    <li class="d-flex"> 
                      <svg class="svg-color">
                        <use href="<?php echo e(config('app.admin_assets')); ?>svg/iconly-sprite.svg#Message"></use>
                      </svg><a class="ms-2" href="<?php echo e(route('admin.profile')); ?>">Profile</a>
                    </li>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('web-setting')): ?>
                    <li class="d-flex"> 
                      <svg class="svg-color">
                        <use href="<?php echo e(config('app.admin_assets')); ?>svg/iconly-sprite.svg#Document"></use>
                      </svg><a class="ms-2" href="<?php echo e(route('admin.websettings')); ?>">Settings</a> 
                    </li>
                     <?php endif; ?>



                      <li class="d-flex"> 
                        <svg class="svg-color">
                        <use href="<?php echo e(config('app.admin_assets')); ?>svg/iconly-sprite.svg#Document"></use>
                        </svg>
                        <a class="ms-2" target="_blank" href="<?php echo e(route('clean.system')); ?>">Clear Cache</a>
                    </li>

                    
                    <li class="d-flex"> 
                      <svg class="svg-color">
                        <use href="<?php echo e(config('app.admin_assets')); ?>svg/iconly-sprite.svg#Login"></use>
                      </svg><a class="ms-2" href="<?php echo e(route('admin.logout')); ?>">Log Out</a>
                    </li>

                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </header>
<?php /**PATH C:\xampp\htdocs\xplore-22-09-26\resources\views/admin/includes/navbar.blade.php ENDPATH**/ ?>