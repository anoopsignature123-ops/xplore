<body>
    <div class="tap-top"><i class="fas fa-arrow-up"></i></div>
    <div class="loader-wrapper">
      <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
    </div>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">   
      <header class="page-header">
        <div class="logo-wrapper">
          <a href="{{ route('builder.index') }}" class="vendor-brand-link">	
            <img src="{{ !empty($settings->logo) ? asset($settings->logo) : '' }}" alt="{{ $settings->company_name ?? 'Xplore' }}" class="vendor-logo-img">
          </a>
          <a class="close-btn toggle-sidebar" href="javascript:void(0)" title="Toggle Menu">
            <i class="fa-solid fa-bars-staggered"></i>
          </a>
        </div>

        <div class="page-main-header">
          <div class="header-left d-none d-lg-flex align-items-center">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 d-inline-flex align-items-center fw-semibold">
              <i class="fas fa-city me-2"></i> Verified Builder & Contractor Portal
            </span>
          </div>

          <div class="nav-right ms-auto">
            <ul class="header-right d-flex align-items-center m-0 p-0 list-unstyled"> 
              <li class="profile-nav custom-dropdown">
                <div class="user-wrap">
                  <div class="user-img">
                    <img src="{{ !empty(auth('builder')->user()->profile_image) ? asset(auth('builder')->user()->profile_image) : asset($settings->favicon ?? '') }}" alt="{{ auth('builder')->user()->firm_name ?? 'Builder' }}">
                  </div>
                  <div class="user-content text-start">
                    @if(auth('builder')->check())
                    <h6>{{ auth('builder')->user()->firm_name }}</h6>
                    @endif
                    <span class="vp-cat-pill">
                      <i class="fas fa-hammer" style="font-size: 9px;"></i>
                      {{ (auth('builder')->check() && auth('builder')->user()->category) ? auth('builder')->user()->category->name : 'Builder / Contractor' }}
                    </span>
                  </div>
                  <i class="fa-solid fa-chevron-down text-muted ms-1 d-none d-sm-inline-block" style="font-size: 11px;"></i>
                </div>
                <div class="custom-menu overflow-hidden">
                  <ul class="profile-body p-1 m-0 list-unstyled">
                    <li class="d-flex align-items-center mb-1"> 
                      <a class="d-flex align-items-center text-dark" href="{{ route('builder.index') }}">
                        <i class="fas fa-tachometer-alt me-2 text-primary" style="width: 18px;"></i> Dashboard
                      </a>
                    </li>
                    <li class="d-flex align-items-center mb-1"> 
                      <a class="d-flex align-items-center text-dark" href="{{ route('builder.inquiry.list') }}">
                        <i class="fas fa-comments me-2 text-info" style="width: 18px;"></i> Customer Inquiries
                      </a>
                    </li>
                    <li class="d-flex align-items-center mb-1"> 
                      <a class="d-flex align-items-center text-dark" href="{{ route('builder.profile') }}">
                        <i class="fas fa-user-gear me-2 text-success" style="width: 18px;"></i> Profile & Showcase
                      </a>
                    </li>
                    <li class="border-top my-1"></li>
                    <li class="d-flex align-items-center"> 
                      <a class="d-flex align-items-center text-danger" href="{{ route('builder.logout') }}">
                        <i class="fas fa-right-from-bracket me-2 text-danger" style="width: 18px;"></i> Log Out
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </header>
