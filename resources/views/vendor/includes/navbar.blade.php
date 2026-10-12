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
          <a href="{{ route('vendor.index') }}" class="vendor-brand-link">	
            <img src="{{ !empty($settings->logo) ? asset($settings->logo) : '' }}" alt="{{ $settings->company_name ?? 'Xplore' }}" class="vendor-logo-img">
          </a>
          <a class="close-btn toggle-sidebar" href="javascript:void(0)" title="Toggle Menu">
            <i class="fa-solid fa-bars-staggered"></i>
          </a>
        </div>

        <div class="page-main-header">
          <div class="header-left d-none d-lg-flex align-items-center">
            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1 d-inline-flex align-items-center fw-semibold">
              <i class="fas fa-circle text-success me-2" style="font-size: 7px;"></i> Verified Partner Portal
            </span>
          </div>

          <div class="nav-right ms-auto">
            <ul class="header-right d-flex align-items-center m-0 p-0 list-unstyled"> 
              <li class="profile-nav custom-dropdown">
                <div class="user-wrap">
                  <div class="user-img">
                    <img src="{{ !empty(auth('vendor')->user()->profile_image) ? asset(auth('vendor')->user()->profile_image) : asset($settings->favicon ?? '') }}" alt="{{ auth('vendor')->user()->name }}">
                  </div>
                  <div class="user-content text-start">
                    @if(auth('vendor')->check())
                    <h6>{{ auth('vendor')->user()->name }}</h6>
                    @endif
                    <span class="vp-cat-pill">
                      <i class="fas fa-tag" style="font-size: 9px;"></i>
                      {{ (auth('vendor')->check() && auth('vendor')->user()->category) ? auth('vendor')->user()->category->name : 'Vendor' }}
                    </span>
                  </div>
                  <i class="fa-solid fa-chevron-down text-muted ms-1 d-none d-sm-inline-block" style="font-size: 11px;"></i>
                </div>
                <div class="custom-menu overflow-hidden">
                  <ul class="profile-body p-1 m-0 list-unstyled">
                    <li class="d-flex align-items-center mb-1"> 
                      <a class="d-flex align-items-center text-dark" href="{{ route('vendor.profile') }}">
                        <i class="fa-solid fa-user-gear me-2 text-primary" style="width: 18px;"></i> My Profile
                      </a>
                    </li>
                    <li class="d-flex align-items-center mb-1"> 
                      <a class="d-flex align-items-center text-dark" href="{{ route('vendor.my-survey.list') }}">
                        <i class="fa-solid fa-clipboard-list me-2 text-teal" style="color: var(--vp-primary); width: 18px;"></i> My Surveys
                      </a>
                    </li>
                    <li class="border-top my-1"></li>
                    <li class="d-flex align-items-center"> 
                      <a class="d-flex align-items-center text-danger" href="{{ route('vendor.logout') }}">
                        <i class="fa-solid fa-right-from-bracket me-2 text-danger" style="width: 18px;"></i> Log Out
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </header>
