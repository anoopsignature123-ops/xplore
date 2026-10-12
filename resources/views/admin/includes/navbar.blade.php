
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
      <header class="page-header">
        <div class="logo-wrapper">
          <a href="{{ route('admin.index') }}" class="admin-brand-link">	
            <img class="img-fluid" src="{{ !empty($settings->logo) ? asset($settings->logo) : '' }}" alt="{{ $settings->company_name ?? 'Xplore' }}">
          </a>
          <a class="close-btn toggle-sidebar" href="javascript:void(0)" title="Toggle Menu">
            <i class="fa-solid fa-bars-staggered"></i>
          </a>
        </div>

        <div class="page-main-header">
          <div class="header-left d-none d-lg-flex align-items-center gap-2">
            <span class="admin-header-pill">
              <i class="fas fa-shield-halved text-success"></i> Master Admin Console
            </span>
            <a href="{{ url('/') }}" target="_blank" class="admin-header-link" title="Open Public Website">
              <i class="fas fa-arrow-up-right-from-square"></i> Visit Website
            </a>
          </div>

          <div class="nav-right ms-auto">
            <ul class="header-right d-flex align-items-center list-unstyled m-0 gap-2"> 
              <!-- Clear Cache quick button -->
              <li>
                <a href="{{ route('clean.system') }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 d-none d-sm-inline-flex align-items-center gap-1 shadow-sm" title="Clear Application Cache">
                  <i class="fas fa-broom text-primary"></i> <span class="small fw-semibold">Clear Cache</span>
                </a>
              </li>

              <!-- Profile Dropdown -->
              <li class="profile-nav custom-dropdown">
                <div class="user-wrap">
                  <div class="user-img">
                    @if(!empty(auth()->user()->profile_pic))
                      <img src="{{ asset(auth()->user()->profile_pic) }}" alt="{{ auth()->user()->name }}">
                    @else
                      <div class="w-100 h-100 rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="background: linear-gradient(135deg, #0d9488, #0f766e); font-size: 13px;">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                      </div>
                    @endif
                  </div>
                  <div class="user-content text-start">
                    <h6>{{ auth()->user()->name ?? 'Administrator' }}</h6>
                    <span class="ap-role-pill">
                      <i class="fas fa-crown" style="font-size: 8px;"></i> Super Admin
                    </span>
                  </div>
                  <i class="fa-solid fa-chevron-down text-muted ms-1 d-none d-sm-inline-block" style="font-size: 10px;"></i>
                </div>
                <div class="custom-menu overflow-hidden shadow">
                  <ul class="profile-body p-1 m-0 list-unstyled">
                    <li> 
                      <a href="{{ route('admin.profile') }}">
                        <i class="fas fa-user-gear text-primary" style="width: 18px;"></i> My Profile
                      </a>
                    </li>

                    @can('web-setting')
                    <li> 
                      <a href="{{ route('admin.websettings') }}">
                        <i class="fas fa-sliders text-info" style="width: 18px;"></i> Web Settings
                      </a> 
                    </li>
                    @endcan

                    <li> 
                      <a target="_blank" href="{{ route('clean.system') }}">
                        <i class="fas fa-arrows-rotate text-warning" style="width: 18px;"></i> Clear Cache
                      </a>
                    </li>

                    <li class="border-top my-1"></li>

                    <li> 
                      <a href="{{ route('admin.logout') }}" class="text-danger">
                        <i class="fas fa-right-from-bracket text-danger" style="width: 18px;"></i> Log Out
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </header>
