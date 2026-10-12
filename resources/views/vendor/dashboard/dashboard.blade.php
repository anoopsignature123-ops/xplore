@extends('vendor.includes.layout')
@section('title', $page_title)
@section('content')
<div class="page-body">
   <div class="container-fluid p-0">
      
      <!-- 1. Hero Welcome Card -->
      <div class="vendor-hero-card">
         <div class="row align-items-center">
            <div class="col-lg-8 col-md-7">
               <div class="hero-tag-pill">
                  <i class="fas fa-sparkles text-warning me-1"></i> Partner Workspace
               </div>
               <h2 class="hero-title">Welcome back, {{ $vendor->name }} 👋</h2>
               <p class="hero-subtitle mb-0">
                  Track your assignments, monitor field survey operations, and connect directly with clients in real-time.
               </p>
               <div class="hero-badges-row">
                  @if(!empty($vendor->category))
                  <span class="hero-meta-badge category-badge">
                     <i class="fas fa-briefcase"></i> {{ $vendor->category->name }}
                  </span>
                  @endif
                  <span class="hero-meta-badge">
                     <i class="fas fa-calendar-day"></i> {{ date('l, d M Y') }}
                  </span>
                  <span class="hero-meta-badge">
                     <i class="fas fa-shield-halved text-success"></i> Verified Partner
                  </span>
               </div>
            </div>
            <div class="col-lg-4 col-md-5 text-md-end mt-3 mt-md-0">
               <a href="{{ route('vendor.my-survey.list') }}" class="hero-btn-action shadow-sm me-2">
                  <i class="fas fa-clipboard-list"></i> My Surveys
               </a>
               <a href="{{ route('vendor.profile') }}" class="hero-btn-outline">
                  <i class="fas fa-user-gear"></i> Profile
               </a>
            </div>
         </div>
      </div>

      <!-- 2. Stat Cards Grid (Fully Responsive: 2x2 on Mobile, 4 in 1 on Desktop) -->
      <div class="row g-3 mb-4">
         <!-- Total Surveys -->
         <div class="col-6 col-md-6 col-xl-3">
            <a href="{{ route('vendor.my-survey.list') }}" class="text-decoration-none">
               <div class="vendor-stat-card stat-total">
                  <div class="stat-header">
                     <div class="stat-icon-wrapper">
                        <i class="fa-solid fa-layer-group"></i>
                     </div>
                     <span class="stat-trend-tag">All-time</span>
                  </div>
                  <div>
                     <div class="stat-label">Total Surveys</div>
                     <div class="stat-number">{{ $totalSurveys }}</div>
                     <div class="stat-footer-text">
                        <i class="fa-regular fa-circle-check text-primary"></i> Assigned tasks
                     </div>
                  </div>
               </div>
            </a>
         </div>

         <!-- Today Surveys -->
         <div class="col-6 col-md-6 col-xl-3">
            <a href="{{ route('vendor.my-survey.list') }}?date=today" class="text-decoration-none">
               <div class="vendor-stat-card stat-today">
                  <div class="stat-header">
                     <div class="stat-icon-wrapper">
                        <i class="fa-solid fa-calendar-day"></i>
                     </div>
                     <span class="stat-trend-tag text-success">Today</span>
                  </div>
                  <div>
                     <div class="stat-label">Today Surveys</div>
                     <div class="stat-number">{{ $todaySurveys }}</div>
                     <div class="stat-footer-text">
                        <i class="fa-regular fa-clock text-success"></i> Scheduled today
                     </div>
                  </div>
               </div>
            </a>
         </div>

         <!-- Ongoing Surveys -->
         <div class="col-6 col-md-6 col-xl-3">
            <a href="{{ route('vendor.my-survey.list') }}?status=Ongoing" class="text-decoration-none">
               <div class="vendor-stat-card stat-ongoing">
                  <div class="stat-header">
                     <div class="stat-icon-wrapper">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                     </div>
                     <span class="stat-trend-tag text-warning">Active</span>
                  </div>
                  <div>
                     <div class="stat-label">Ongoing Surveys</div>
                     <div class="stat-number">{{ $totalOngoingSurveys }}</div>
                     <div class="stat-footer-text">
                        <i class="fa-solid fa-spinner text-warning"></i> In field progress
                     </div>
                  </div>
               </div>
            </a>
         </div>

         <!-- Completed Surveys -->
         <div class="col-6 col-md-6 col-xl-3">
            <a href="{{ route('vendor.my-survey.list') }}?status=Completed" class="text-decoration-none">
               <div class="vendor-stat-card stat-completed">
                  <div class="stat-header">
                     <div class="stat-icon-wrapper">
                        <i class="fa-solid fa-circle-check"></i>
                     </div>
                     <span class="stat-trend-tag text-info">Finished</span>
                  </div>
                  <div>
                     <div class="stat-label">Completed Surveys</div>
                     <div class="stat-number">{{ $totalCompletedSurveys }}</div>
                     <div class="stat-footer-text">
                        <i class="fa-solid fa-award text-info"></i> Successfully done
                     </div>
                  </div>
               </div>
            </a>
         </div>
      </div>

      <!-- 3. Ongoing & Completed Surveys Section -->
      <div class="row g-4">
         <!-- Ongoing Surveys Card -->
         <div class="col-lg-6">
            <div class="vendor-table-card">
               <div class="card-header">
                  <div class="card-title-group">
                     <div class="card-icon-pill ongoing-pill">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                     </div>
                     <div>
                        <h5 class="card-header-title">Latest Ongoing Surveys</h5>
                     </div>
                     <span class="card-count-badge">{{ $latestOngoingSurveys->count() }} active</span>
                  </div>
                  <a href="{{ route('vendor.my-survey.list') }}?status=Ongoing" class="btn-view-all">
                     View All <i class="fas fa-arrow-right ms-1"></i>
                  </a>
               </div>

               <div class="card-body p-0">
                  @if($latestOngoingSurveys->count() > 0)
                     <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                           <thead>
                              <tr>
                                 <th>Customer</th>
                                 <th>Survey</th>
                                 <th class="text-center">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($latestOngoingSurveys as $survey)
                              <tr>
                                 <td>
                                    @if($survey->customer)
                                       <div class="customer-avatar-box">
                                          <img src="{{ !empty($survey->customer->profile_image) ? asset($survey->customer->profile_image) : asset('assets/images/user.png') }}" alt="{{ $survey->customer->name }}">
                                          <div>
                                             <div class="cust-name">{{ $survey->customer->name }}</div>
                                             <div class="cust-phone"><i class="fas fa-phone-alt" style="font-size: 10px;"></i> {{ $survey->customer->phone_no }}</div>
                                          </div>
                                       </div>
                                    @else
                                       <span class="text-muted">N/A</span>
                                    @endif
                                 </td>
                                 <td>
                                    <div class="survey-info-box">
                                       <div class="survey-title">{{ $survey->survey_name }}</div>
                                       <div class="survey-datetime">
                                          <i class="fa-regular fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($survey->survey_date)->format('d M Y') }}
                                          <span class="mx-1">•</span>
                                          <i class="fa-regular fa-clock me-1"></i> {{ \Carbon\Carbon::parse($survey->survey_time)->format('h:i A') }}
                                       </div>
                                    </div>
                                 </td>
                                 <td class="text-center text-nowrap">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                       <span class="vp-status-pill status-ongoing">
                                          <i class="fas fa-circle" style="font-size: 6px;"></i> Ongoing
                                       </span>
                                       <a href="{{ route('vendor.my-survey.chat', $survey->id) }}" class="vp-btn-chat">
                                          <i class="fa-regular fa-comments"></i> Chat
                                       </a>
                                    </div>
                                 </td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  @else
                     <div class="text-center py-5 px-3">
                        <div class="mb-3 text-muted opacity-50">
                           <i class="fa-solid fa-clock-rotate-left fa-3x"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">No Ongoing Surveys</h6>
                        <p class="text-muted small mb-0">All current surveys have been processed.</p>
                     </div>
                  @endif
               </div>
            </div>
         </div>

         <!-- Completed Surveys Card -->
         <div class="col-lg-6">
            <div class="vendor-table-card">
               <div class="card-header">
                  <div class="card-title-group">
                     <div class="card-icon-pill completed-pill">
                        <i class="fa-solid fa-circle-check"></i>
                     </div>
                     <div>
                        <h5 class="card-header-title">Latest Completed Surveys</h5>
                     </div>
                     <span class="card-count-badge">{{ $latestCompletedSurveys->count() }} completed</span>
                  </div>
                  <a href="{{ route('vendor.my-survey.list') }}?status=Completed" class="btn-view-all">
                     View All <i class="fas fa-arrow-right ms-1"></i>
                  </a>
               </div>

               <div class="card-body p-0">
                  @if($latestCompletedSurveys->count() > 0)
                     <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                           <thead>
                              <tr>
                                 <th>Customer</th>
                                 <th>Survey</th>
                                 <th class="text-center">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($latestCompletedSurveys as $survey)
                              <tr>
                                 <td>
                                    @if($survey->customer)
                                       <div class="customer-avatar-box">
                                          <img src="{{ !empty($survey->customer->profile_image) ? asset($survey->customer->profile_image) : asset('assets/images/user.png') }}" alt="{{ $survey->customer->name }}">
                                          <div>
                                             <div class="cust-name">{{ $survey->customer->name }}</div>
                                             <div class="cust-phone"><i class="fas fa-phone-alt" style="font-size: 10px;"></i> {{ $survey->customer->phone_no }}</div>
                                          </div>
                                       </div>
                                    @else
                                       <span class="text-muted">N/A</span>
                                    @endif
                                 </td>
                                 <td>
                                    <div class="survey-info-box">
                                       <div class="survey-title">{{ $survey->survey_name }}</div>
                                       <div class="survey-datetime">
                                          <i class="fa-regular fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($survey->survey_date)->format('d M Y') }}
                                          <span class="mx-1">•</span>
                                          <i class="fa-regular fa-clock me-1"></i> {{ \Carbon\Carbon::parse($survey->survey_time)->format('h:i A') }}
                                       </div>
                                    </div>
                                 </td>
                                 <td class="text-center text-nowrap">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                       <span class="vp-status-pill status-completed">
                                          <i class="fas fa-check" style="font-size: 8px;"></i> Completed
                                       </span>
                                       <a href="{{ route('vendor.my-survey.chat', $survey->id) }}" class="vp-btn-chat">
                                          <i class="fa-regular fa-comments"></i> Chat
                                       </a>
                                    </div>
                                 </td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  @else
                     <div class="text-center py-5 px-3">
                        <div class="mb-3 text-muted opacity-50">
                           <i class="fa-solid fa-circle-check fa-3x"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">No Completed Surveys Yet</h6>
                        <p class="text-muted small mb-0">Completed surveys will appear here for reference.</p>
                     </div>
                  @endif
               </div>
            </div>
         </div>
      </div>

   </div>
</div>
@endsection
