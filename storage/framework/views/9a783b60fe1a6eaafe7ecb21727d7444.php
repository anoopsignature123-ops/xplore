<body>
    <div class="tap-top"><i class="fas fa-arrow-up"></i></div>
    <div class="loader-wrapper">
      <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
    </div>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">   
      <header class="page-header row">
        <div class="logo-wrapper d-flex align-items-center col-auto">
          <a href="<?php echo e(route('builder.index')); ?>">	
            <img class="light-logo img-fluid" src="<?php echo e(!empty($settings->logo) ? asset($settings->logo) : ''); ?>" alt="<?php echo e($settings->company_name ?? ''); ?>" style="width:auto;height:60px;">
            <img class="dark-logo img-fluid" src="<?php echo e(!empty($settings->logo) ? asset($settings->logo) : ''); ?>" alt="<?php echo e($settings->company_name ?? ''); ?>" style="width:auto;height:60px;">
          </a>
          <a class="close-btn toggle-sidebar" href="javascript:void(0)">
            <svg class="svg-color">
              <use href="<?php echo e(config('app.admin_assets')); ?>svg/iconly-sprite.svg#Category"></use>
            </svg>
          </a>
        </div>
        <div class="page-main-header col">
          <div class="header-left"></div>
          <div class="nav-right">
            <ul class="header-right"> 
              <li class="profile-nav custom-dropdown">
                <div class="user-wrap">
                  <div class="user-img">
                    <img src="<?php echo e(!empty(auth('builder')->user()->profile_image) ? asset(auth('builder')->user()->profile_image) : asset($settings->favicon ?? '')); ?>" alt="<?php echo e(auth('builder')->user()->firm_name ?? 'Builder'); ?>" class="rounded-circle" style="height:40px;width:40px;object-fit:cover;">
                  </div>
                  <div class="user-content">
                    <?php if(auth('builder')->check()): ?>
                      <h6><?php echo e(auth('builder')->user()->firm_name); ?></h6>
                    <?php endif; ?>
                    <p class="mb-0">Builder / Contractor <i class="fa-solid fa-chevron-down"></i></p>
                  </div>
                </div>
                <div class="custom-menu overflow-hidden">
                  <ul class="profile-body">
                    <li class="d-flex mb-2"> 
                      <i class="fas fa-chart-line me-2 text-primary"></i><a class="ms-2" href="<?php echo e(route('builder.index')); ?>">Dashboard</a>
                    </li>
                    <li class="d-flex mb-2"> 
                      <i class="fas fa-user-tie me-2 text-info"></i><a class="ms-2" href="<?php echo e(route('builder.profile')); ?>">Profile & Showcase</a>
                    </li>
                    <li class="d-flex"> 
                      <i class="fas fa-power-off me-2 text-danger"></i><a class="ms-2 text-danger" href="<?php echo e(route('builder.logout')); ?>">Log Out</a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </header>
<?php /**PATH C:\xampp\htdocs\xplore-22-09-26\resources\views/builder/includes/navbar.blade.php ENDPATH**/ ?>