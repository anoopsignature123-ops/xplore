@extends('builder.includes.layout')

@section('title', $page_title)
@section('content')
<div class="page-body">
   <div class="container-fluid p-0">
      
      <!-- 1. Hero Welcome Card -->
      <div class="vendor-hero-card">
         <div class="row align-items-center">
            <div class="col-lg-8 col-md-7">
               <div class="hero-tag-pill">
                  <i class="fas fa-crown text-warning me-1"></i> Builder & Contractor Portal
               </div>
               <h2 class="hero-title">Welcome, {{ $builder->firm_name }} 🏗️</h2>
               <p class="hero-subtitle mb-0">
                  Manage your portfolio, showcase completed projects, and turn incoming client inquiries into business opportunities.
               </p>
               <div class="hero-badges-row">
                  <span class="hero-meta-badge category-badge">
                     <i class="fas fa-hammer"></i> {{ $builder->category->name ?? 'Civil Contractor / Builder' }}
                  </span>
                  <span class="hero-meta-badge">
                     <i class="fas fa-user-tie text-info"></i> {{ $builder->name }}
                  </span>
                  <span class="hero-meta-badge">
                     <i class="fas fa-calendar-day"></i> {{ date('l, d M Y') }}
                  </span>
                  <span class="hero-meta-badge">
                     <i class="fas fa-shield-halved text-success"></i> Verified Partner
                  </span>
               </div>
            </div>
            <div class="col-lg-4 col-md-5 text-md-end mt-3 mt-md-0">
               <a href="{{ route('builder.inquiry.list') }}" class="hero-btn-action shadow-sm me-2">
                  <i class="fas fa-comments"></i> Inquiries
               </a>
               <a href="{{ route('builder.profile') }}" class="hero-btn-outline">
                  <i class="fas fa-user-pen"></i> Edit Showcase
               </a>
            </div>
         </div>
      </div>

      <!-- 2. Stat Cards Grid (Fully Responsive: 2x2 on Mobile, 4 in 1 on Desktop) -->
      <div class="row g-3 mb-4">
         <!-- Total Inquiries -->
         <div class="col-6 col-md-6 col-xl-3">
            <a href="{{ route('builder.inquiry.list') }}" class="text-decoration-none">
               <div class="vendor-stat-card stat-total">
                  <div class="stat-header">
                     <div class="stat-icon-wrapper">
                        <i class="fas fa-headset"></i>
                     </div>
                     <span class="stat-trend-tag">All-time</span>
                  </div>
                  <div>
                     <div class="stat-label">Total Inquiries</div>
                     <div class="stat-number">{{ $totalInquiries }}</div>
                     <div class="stat-footer-text">
                        <i class="fa-regular fa-circle-check text-primary"></i> Customer leads
                     </div>
                  </div>
               </div>
            </a>
         </div>

         <!-- Pending Leads -->
         <div class="col-6 col-md-6 col-xl-3">
            <a href="{{ route('builder.inquiry.list') }}" class="text-decoration-none">
               <div class="vendor-stat-card stat-ongoing">
                  <div class="stat-header">
                     <div class="stat-icon-wrapper">
                        <i class="fas fa-clock-rotate-left"></i>
                     </div>
                     <span class="stat-trend-tag text-warning">Pending</span>
                  </div>
                  <div>
                     <div class="stat-label">Pending Leads</div>
                     <div class="stat-number">{{ $pendingInquiries }}</div>
                     <div class="stat-footer-text">
                        <i class="fa-solid fa-spinner text-warning"></i> Needs attention
                     </div>
                  </div>
               </div>
            </a>
         </div>

         <!-- Portfolio Photos -->
         <div class="col-6 col-md-6 col-xl-3">
            <a href="{{ route('builder.profile') }}" class="text-decoration-none">
               <div class="vendor-stat-card stat-today">
                  <div class="stat-header">
                     <div class="stat-icon-wrapper">
                        <i class="fas fa-images"></i>
                     </div>
                     <span class="stat-trend-tag text-success">Gallery</span>
                  </div>
                  <div>
                     <div class="stat-label">Portfolio Photos</div>
                     <div class="stat-number">{{ $totalPortfolios }}</div>
                     <div class="stat-footer-text">
                        <i class="fa-regular fa-image text-success"></i> Work gallery
                     </div>
                  </div>
               </div>
            </a>
         </div>

         <!-- Projects Showcase -->
         <div class="col-6 col-md-6 col-xl-3">
            <a href="{{ route('builder.profile') }}" class="text-decoration-none">
               <div class="vendor-stat-card stat-completed">
                  <div class="stat-header">
                     <div class="stat-icon-wrapper">
                        <i class="fas fa-building"></i>
                     </div>
                     <span class="stat-trend-tag text-info">Showcase</span>
                  </div>
                  <div>
                     <div class="stat-label">Projects Showcase</div>
                     <div class="stat-number">{{ $totalProjects }}</div>
                     <div class="stat-footer-text">
                        <i class="fa-solid fa-award text-info"></i> Completed projects
                     </div>
                  </div>
               </div>
            </a>
         </div>
      </div>

      <!-- 3. Recent Customer Inquiries Table Card -->
      <div class="row">
         <div class="col-12">
            <div class="vendor-table-card">
               <div class="card-header">
                  <div class="card-title-group">
                     <div class="card-icon-pill ongoing-pill">
                        <i class="fas fa-comments"></i>
                     </div>
                     <div>
                        <h5 class="card-header-title">Recent Customer Inquiries</h5>
                     </div>
                     <span class="card-count-badge">{{ $recentInquiries->count() }} latest</span>
                  </div>
                  <a href="{{ route('builder.inquiry.list') }}" class="btn-view-all">
                     View All Inquiries <i class="fas fa-arrow-right ms-1"></i>
                  </a>
               </div>

               <div class="card-body p-0">
                  @if($recentInquiries->count() > 0)
                     <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                           <thead>
                              <tr>
                                 <th style="width: 50px;">#</th>
                                 <th>Customer</th>
                                 <th>Contact</th>
                                 <th>Inquiry Type</th>
                                 <th>Received On</th>
                                 <th class="text-center">Status</th>
                                 <th class="text-end pe-4">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($recentInquiries as $idx => $inq)
                              <tr>
                                 <td class="text-muted fw-semibold">{{ $idx + 1 }}</td>
                                 <td>
                                    <div class="customer-avatar-box">
                                       <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-sm" style="width: 40px; height: 40px; min-width: 40px; background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%); font-size: 14px;">
                                          {{ strtoupper(substr($inq->customer_name ?? 'C', 0, 1)) }}
                                       </div>
                                       <div>
                                          <div class="cust-name fw-bold text-dark">{{ $inq->customer_name ?? 'Anonymous Client' }}</div>
                                          <div class="text-muted small">Lead #{{ $inq->id }}</div>
                                       </div>
                                    </div>
                                 </td>
                                 <td>
                                    <a href="tel:{{ $inq->customer_phone }}" class="d-inline-flex align-items-center gap-2 text-decoration-none text-dark fw-semibold px-2 py-1 bg-light rounded border">
                                       <i class="fas fa-phone-alt text-success" style="font-size: 11px;"></i>
                                       <span>{{ $inq->customer_phone }}</span>
                                    </a>
                                 </td>
                                 <td>
                                    @if($inq->inquiry_type == 'call')
                                       <span class="badge rounded-pill px-3 py-2 bg-success-subtle text-success border border-success-subtle fw-semibold">
                                          <i class="fas fa-phone-volume me-1"></i> Call Request
                                       </span>
                                    @elseif($inq->inquiry_type == 'chat')
                                       <span class="badge rounded-pill px-3 py-2 bg-primary-subtle text-primary border border-primary-subtle fw-semibold">
                                          <i class="fas fa-comment-dots me-1"></i> Chat Request
                                       </span>
                                    @else
                                       <span class="badge rounded-pill px-3 py-2 bg-info-subtle text-info border border-info-subtle fw-semibold">
                                          <i class="fas fa-envelope-open-text me-1"></i> General Lead
                                       </span>
                                    @endif
                                 </td>
                                 <td>
                                    <div class="text-dark fw-medium small">
                                       <i class="fa-regular fa-calendar text-muted me-1"></i> {{ $inq->created_at ? $inq->created_at->format('d M Y') : 'N/A' }}
                                    </div>
                                    <div class="text-muted small">
                                       <i class="fa-regular fa-clock text-muted me-1"></i> {{ $inq->created_at ? $inq->created_at->format('h:i A') : '' }}
                                    </div>
                                 </td>
                                 <td class="text-center">
                                    @if($inq->status == 'closed')
                                       <span class="vp-status-pill status-completed">
                                          <i class="fas fa-check" style="font-size: 8px;"></i> Closed
                                       </span>
                                    @elseif($inq->status == 'contacted')
                                       <span class="vp-status-pill" style="background: rgba(14, 165, 233, 0.12); color: #0284c7; border: 1px solid rgba(14, 165, 233, 0.25);">
                                          <i class="fas fa-phone me-1" style="font-size: 8px;"></i> Contacted
                                       </span>
                                    @else
                                       <span class="vp-status-pill status-ongoing">
                                          <i class="fas fa-clock" style="font-size: 8px;"></i> Pending
                                       </span>
                                    @endif
                                 </td>
                                 <td class="text-end pe-4">
                                    <a href="{{ route('builder.inquiry.list') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold">
                                       Manage <i class="fas fa-arrow-right ms-1" style="font-size: 11px;"></i>
                                    </a>
                                 </td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  @else
                     <div class="text-center py-5 px-3">
                        <div class="mb-3 text-muted opacity-50">
                           <i class="fas fa-comments fa-3x"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">No Inquiries Found</h6>
                        <p class="text-muted small mb-0">When potential customers reach out regarding construction or architectural works, they will appear here.</p>
                     </div>
                  @endif
               </div>
            </div>
         </div>
      </div>

   </div>
</div>
@endsection
