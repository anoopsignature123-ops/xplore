
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
          
        <a href="{{ route('admin.index') }}">	
          <img class="light-logo img-fluid" src="{{ !empty($settings->logo) ? asset($settings->logo) : '' }}" alt="{{ $settings -> company_name ?? '' }}" style="width:auto;height:60px;">
          <img class="dark-logo img-fluid" src="{{ !empty($settings->logo) ? asset($settings->logo) : '' }}" alt="{{ $settings -> company_name  ?? '' }}" style="width:auto;height:60px;">
        </a>
     
     
          <a class="close-btn toggle-sidebar" href="javascript:void(0)">
            <svg class="svg-color">
              <use href="{{ config('app.admin_assets') }}svg/iconly-sprite.svg#Category"></use>
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
                  <div class="user-img"><img src="{{ !empty(auth()->user()->profile_pic) ? asset(auth()->user()->profile_pic) : asset($settings->favicon ?? '') }}" alt="{{ auth()->user()->name }}"></div>
                  <div class="user-content">
                    @if(auth()->check())
                    <h6>{{ auth()->user()->name }}</h6>
                    @endif
                    <p class="mb-0">Admin<i class="fa-solid fa-chevron-down"></i></p>
                  </div>
                </div>
                <div class="custom-menu overflow-hidden">
                  <ul class="profile-body">
                    <li class="d-flex"> 
                      <svg class="svg-color">
                        <use href="{{ config('app.admin_assets') }}svg/iconly-sprite.svg#Message"></use>
                      </svg><a class="ms-2" href="{{ route('admin.profile') }}">Profile</a>
                    </li>

                    @can('web-setting')
                    <li class="d-flex"> 
                      <svg class="svg-color">
                        <use href="{{ config('app.admin_assets') }}svg/iconly-sprite.svg#Document"></use>
                      </svg><a class="ms-2" href="{{ route('admin.websettings') }}">Settings</a> 
                    </li>
                     @endcan



                      <li class="d-flex"> 
                        <svg class="svg-color">
                        <use href="{{ config('app.admin_assets') }}svg/iconly-sprite.svg#Document"></use>
                        </svg>
                        <a class="ms-2" target="_blank" href="{{ route('clean.system') }}">Clear Cache</a>
                    </li>

                    
                    <li class="d-flex"> 
                      <svg class="svg-color">
                        <use href="{{ config('app.admin_assets') }}svg/iconly-sprite.svg#Login"></use>
                      </svg><a class="ms-2" href="{{ route('admin.logout') }}">Log Out</a>
                    </li>

                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </header>
