@extends('admin.includes.layout')
@section('title', 'Admin Dashboard')
@section('content')
<div class="page-body">
   <div class="container-fluid p-0">
      
      <!-- 1. Hero Welcome Card -->
      <div class="admin-hero-card">
         <div class="row align-items-center">
            <div class="col-lg-8 col-md-7">
               <div class="hero-tag-pill">
                  <i class="fas fa-shield-halved text-warning me-1"></i> Platform Control Center
               </div>
               <h2 class="hero-title">Welcome back, {{ auth()->user()->name ?? 'Super Admin' }} 👋</h2>
               <p class="hero-subtitle mb-0">
                  Comprehensive performance overview across customers, vendors, transactions, e-commerce orders, and live field operations.
               </p>
               <div class="hero-badges-row">
                  <span class="hero-meta-badge" style="background: rgba(13, 148, 136, 0.35); border-color: rgba(13, 148, 136, 0.6); color: #5eead4;">
                     <i class="fas fa-crown"></i> Master Admin
                  </span>
                  <span class="hero-meta-badge">
                     <i class="fas fa-calendar-day"></i> {{ date('l, d M Y') }}
                  </span>
                  <span class="hero-meta-badge">
                     <i class="fas fa-circle-check text-success"></i> All Systems Operational
                  </span>
               </div>
            </div>
            <div class="col-lg-4 col-md-5 text-md-end mt-3 mt-md-0">
               <a href="{{ route('admin.order.list') }}" class="hero-btn-action shadow-sm me-2">
                  <i class="fas fa-shopping-cart"></i> Orders
               </a>
               <a href="{{ route('admin.transaction.list') }}" class="hero-btn-outline me-2">
                  <i class="fas fa-exchange-alt"></i> Transactions
               </a>
               @can('web-setting')
               <a href="{{ route('admin.websettings') }}" class="hero-btn-outline">
                  <i class="fas fa-sliders"></i> Settings
               </a>
               @endcan
            </div>
         </div>
      </div>

      <!-- 2. Stat Cards Grid (12 Modern Metric Cards in Responsive 4-Col Grid) -->
      @php
      $cards = [
          [
              'title' => $totalCustomer,
              'subtitle' => 'Total Customers',
              'url' => route('admin.customer.list'),
              'icon' => 'fa-users',
              'grad' => 'linear-gradient(135deg, #4f46e5 0%, #3730a3 100%)',
              'tag' => 'Platform',
              'tag_class' => 'text-primary',
              'footer' => 'Registered users',
              'footer_icon' => 'fa-regular fa-circle-check text-primary'
          ],
          [
              'title' => $totalVendor,
              'subtitle' => 'Total Vendors',
              'url' => route('admin.vendor.list'),
              'icon' => 'fa-store',
              'grad' => 'linear-gradient(135deg, #10b981 0%, #047857 100%)',
              'tag' => 'Partners',
              'tag_class' => 'text-success',
              'footer' => 'Verified partners',
              'footer_icon' => 'fa-regular fa-handshake text-success'
          ],
          [
              'title' => $totalProduct,
              'subtitle' => 'Total Products',
              'url' => route('admin.product.list'),
              'icon' => 'fa-box-open',
              'grad' => 'linear-gradient(135deg, #06b6d4 0%, #0e7490 100%)',
              'tag' => 'Catalog',
              'tag_class' => 'text-info',
              'footer' => 'Active store items',
              'footer_icon' => 'fa-solid fa-boxes-stacked text-info'
          ],
          [
              'title' => $pendingOrders,
              'subtitle' => 'Pending Orders',
              'url' => route('admin.product-order.list', ['order_status' => 'pending']),
              'icon' => 'fa-clock-rotate-left',
              'grad' => 'linear-gradient(135deg, #f59e0b 0%, #b45309 100%)',
              'tag' => 'Action Req.',
              'tag_class' => 'text-warning',
              'footer' => 'Awaiting processing',
              'footer_icon' => 'fa-solid fa-spinner text-warning'
          ],
          [
              'title' => $totalProductSuccessOrder,
              'subtitle' => 'Success Orders',
              'url' => route('admin.product-order.list', ['order_status' => 'delivered']),
              'icon' => 'fa-circle-check',
              'grad' => 'linear-gradient(135deg, #16a34a 0%, #15803d 100%)',
              'tag' => 'Delivered',
              'tag_class' => 'text-success',
              'footer' => 'Completed orders',
              'footer_icon' => 'fa-solid fa-truck-ramp-box text-success'
          ],
          [
              'title' => $totalTransaction,
              'subtitle' => 'Total Transactions',
              'url' => route('admin.transaction.list'),
              'icon' => 'fa-money-bill-transfer',
              'grad' => 'linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%)',
              'tag' => 'All-time',
              'tag_class' => 'text-secondary',
              'footer' => 'Payment attempts',
              'footer_icon' => 'fa-solid fa-receipt text-secondary'
          ],
          [
              'title' => '₹' . number_format($transactionSuccessAmount, 2),
              'subtitle' => 'Txn Success Amount',
              'url' => route('admin.transaction.list', ['status' => 'success']),
              'icon' => 'fa-sack-dollar',
              'grad' => 'linear-gradient(135deg, #0d9488 0%, #0f766e 100%)',
              'tag' => 'Revenue',
              'tag_class' => 'text-success',
              'footer' => 'Successfully settled',
              'footer_icon' => 'fa-solid fa-wallet text-success'
          ],
          [
              'title' => '₹' . number_format($transactionPendingAmount, 2),
              'subtitle' => 'Txn Pending Amount',
              'url' => route('admin.transaction.list', ['status' => 'pending']),
              'icon' => 'fa-hand-holding-dollar',
              'grad' => 'linear-gradient(135deg, #ea580c 0%, #c2410c 100%)',
              'tag' => 'Pending',
              'tag_class' => 'text-danger',
              'footer' => 'In clearance',
              'footer_icon' => 'fa-solid fa-hourglass-half text-danger'
          ],
          [
              'title' => $totalCustomerSurvey,
              'subtitle' => 'Customer Surveys',
              'url' => route('admin.customer-survey.list'),
              'icon' => 'fa-square-poll-vertical',
              'grad' => 'linear-gradient(135deg, #0284c7 0%, #0369a1 100%)',
              'tag' => 'Field Ops',
              'tag_class' => 'text-info',
              'footer' => 'Site survey jobs',
              'footer_icon' => 'fa-solid fa-map-location-dot text-info'
          ],
          [
              'title' => $totalCourseEnrollments,
              'subtitle' => 'Course Enrollments',
              'url' => route('admin.course-enrollment.list'),
              'icon' => 'fa-graduation-cap',
              'grad' => 'linear-gradient(135deg, #9333ea 0%, #7e22ce 100%)',
              'tag' => 'Academy',
              'tag_class' => 'text-purple',
              'footer' => 'Learning students',
              'footer_icon' => 'fa-solid fa-award text-purple'
          ],
          [
              'title' => $totalHelpQueries,
              'subtitle' => 'Help Queries',
              'url' => route('admin.help-query.list'),
              'icon' => 'fa-headset',
              'grad' => 'linear-gradient(135deg, #f43f5e 0%, #be123c 100%)',
              'tag' => 'Support',
              'tag_class' => 'text-danger',
              'footer' => 'Customer tickets',
              'footer_icon' => 'fa-solid fa-circle-question text-danger'
          ],
          [
              'title' => $totalSystemUsers,
              'subtitle' => 'System Users',
              'url' => route('admin.users.list'),
              'icon' => 'fa-users-gear',
              'grad' => 'linear-gradient(135deg, #475569 0%, #1e293b 100%)',
              'tag' => 'Admin Team',
              'tag_class' => 'text-muted',
              'footer' => 'Staff accounts',
              'footer_icon' => 'fa-solid fa-id-badge text-muted'
          ],
      ];
      @endphp

      <div class="row g-3 mb-4">
         @foreach($cards as $card)
         <div class="col-6 col-md-4 col-xl-3">
            <a href="{{ $card['url'] }}" class="text-decoration-none">
               <div class="admin-stat-card">
                  <div class="stat-header">
                     <div class="stat-icon-wrapper" style="background: {{ $card['grad'] }}; color: #ffffff; box-shadow: 0 4px 14px rgba(0,0,0,0.15);">
                        <i class="fa-solid {{ $card['icon'] }}"></i>
                     </div>
                     <span class="stat-trend-tag {{ $card['tag_class'] }}">{{ $card['tag'] }}</span>
                  </div>
                  <div>
                     <div class="stat-label">{{ $card['subtitle'] }}</div>
                     <div class="stat-number">{{ $card['title'] }}</div>
                     <div class="stat-footer-text">
                        <i class="{{ $card['footer_icon'] }}"></i> {{ $card['footer'] }}
                     </div>
                  </div>
               </div>
            </a>
         </div>
         @endforeach
      </div>

      <!-- 3. Latest Activity Row 1: Course Enrollments & Customer Surveys -->
      <div class="row g-4 mb-4">
         <!-- Latest Course Enrollments -->
         <div class="col-lg-6">
            <div class="admin-table-card">
               <div class="card-header">
                  <div class="card-title-group">
                     <div class="card-icon-pill" style="background: rgba(147, 51, 234, 0.12); color: #9333ea;">
                        <i class="fa-solid fa-graduation-cap"></i>
                     </div>
                     <div>
                        <h5 class="card-header-title">Latest Course Enrollments</h5>
                     </div>
                  </div>
                  <a href="{{ route('admin.course-enrollment.list') }}" class="btn-view-all">
                     View All <i class="fas fa-arrow-right ms-1"></i>
                  </a>
               </div>
               <div class="card-body p-0">
                  @if($latestCourseEnrollments->count() > 0)
                     <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                           <thead>
                              <tr>
                                 <th>Customer</th>
                                 <th>Course</th>
                                 <th>Amount</th>
                                 <th class="text-center">Status</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($latestCourseEnrollments as $enrollment)
                              @php
                                 $cust = $enrollment->customer;
                                 $cName = $cust ? $cust->name : 'Customer';
                                 $cPhone = $cust ? $cust->phone_no : '';
                                 $cImg = $cust ? $cust->profile_image : null;
                                 $cInit = strtoupper(substr($cName, 0, 1));
                                 $st = strtolower($enrollment->status);
                              @endphp
                              <tr>
                                 <td>
                                    <div class="admin-user-avatar-box">
                                       @if(!empty($cImg) && file_exists(public_path($cImg)))
                                          <img src="{{ asset($cImg) }}" alt="{{ $cName }}" class="admin-avatar-circle" style="object-fit: cover;">
                                       @else
                                          <div class="admin-avatar-circle" style="background: linear-gradient(135deg, #9333ea, #7e22ce);">
                                             {{ $cInit }}
                                          </div>
                                       @endif
                                       <div>
                                          <div class="user-info-name">{{ $cName }}</div>
                                          @if($cPhone)<div class="user-info-sub"><i class="fas fa-phone-alt me-1"></i>{{ $cPhone }}</div>@endif
                                       </div>
                                    </div>
                                 </td>
                                 <td class="fw-semibold text-dark small">{{ $enrollment->course_name }}</td>
                                 <td class="fw-bold text-dark">₹{{ number_format($enrollment->amount, 2) }}</td>
                                 <td class="text-center">
                                    <span class="ap-status-pill {{ $st == 'active' || $st == 'completed' ? 'status-success' : 'status-warning' }}">
                                       <i class="fas fa-circle" style="font-size: 6px;"></i> {{ ucfirst($enrollment->status) }}
                                    </span>
                                 </td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  @else
                     <div class="text-center py-5 px-3">
                        <i class="fa-solid fa-graduation-cap fa-3x text-muted opacity-50 mb-2"></i>
                        <h6 class="fw-bold text-dark mb-1">No Enrollments Yet</h6>
                        <p class="text-muted small mb-0">New student purchases will appear here.</p>
                     </div>
                  @endif
               </div>
            </div>
         </div>

         <!-- Latest Customer Surveys -->
         <div class="col-lg-6">
            <div class="admin-table-card">
               <div class="card-header">
                  <div class="card-title-group">
                     <div class="card-icon-pill" style="background: rgba(2, 132, 199, 0.12); color: #0284c7;">
                        <i class="fa-solid fa-map-location-dot"></i>
                     </div>
                     <div>
                        <h5 class="card-header-title">Latest Customer Surveys</h5>
                     </div>
                  </div>
                  <a href="{{ route('admin.customer-survey.list') }}" class="btn-view-all">
                     View All <i class="fas fa-arrow-right ms-1"></i>
                  </a>
               </div>
               <div class="card-body p-0">
                  @if($latestCustomerSurveys->count() > 0)
                     <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                           <thead>
                              <tr>
                                 <th>Customer</th>
                                 <th>Survey Type</th>
                                 <th>Amount</th>
                                 <th class="text-center">Status</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($latestCustomerSurveys as $survey)
                              @php
                                 $cust = $survey->customer;
                                 $cName = $cust ? $cust->name : 'Customer';
                                 $cPhone = $cust ? $cust->phone_no : '';
                                 $cImg = $cust ? $cust->profile_image : null;
                                 $cInit = strtoupper(substr($cName, 0, 1));
                                 $st = strtolower($survey->status);
                              @endphp
                              <tr>
                                 <td>
                                    <div class="admin-user-avatar-box">
                                       @if(!empty($cImg) && file_exists(public_path($cImg)))
                                          <img src="{{ asset($cImg) }}" alt="{{ $cName }}" class="admin-avatar-circle" style="object-fit: cover;">
                                       @else
                                          <div class="admin-avatar-circle" style="background: linear-gradient(135deg, #0284c7, #0369a1);">
                                             {{ $cInit }}
                                          </div>
                                       @endif
                                       <div>
                                          <div class="user-info-name">{{ $cName }}</div>
                                          @if($cPhone)<div class="user-info-sub"><i class="fas fa-phone-alt me-1"></i>{{ $cPhone }}</div>@endif
                                       </div>
                                    </div>
                                 </td>
                                 <td class="fw-semibold text-dark small">{{ $survey->survey_name }}</td>
                                 <td class="fw-bold text-dark">₹{{ number_format($survey->amount, 2) }}</td>
                                 <td class="text-center">
                                    <span class="ap-status-pill {{ $st == 'completed' ? 'status-success' : ($st == 'ongoing' ? 'status-info' : 'status-warning') }}">
                                       <i class="fas fa-circle" style="font-size: 6px;"></i> {{ ucfirst($survey->status) }}
                                    </span>
                                 </td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  @else
                     <div class="text-center py-5 px-3">
                        <i class="fa-solid fa-map-location-dot fa-3x text-muted opacity-50 mb-2"></i>
                        <h6 class="fw-bold text-dark mb-1">No Surveys Booked</h6>
                        <p class="text-muted small mb-0">Customer field survey requests will appear here.</p>
                     </div>
                  @endif
               </div>
            </div>
         </div>
      </div>

      <!-- 4. Latest Activity Row 2: Product Orders & Gateway Orders -->
      <div class="row g-4 mb-4">
         <!-- Latest Product Orders -->
         <div class="col-lg-6">
            <div class="admin-table-card">
               <div class="card-header">
                  <div class="card-title-group">
                     <div class="card-icon-pill" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
                        <i class="fa-solid fa-box-open"></i>
                     </div>
                     <div>
                        <h5 class="card-header-title">Latest Product Orders</h5>
                     </div>
                  </div>
                  <a href="{{ route('admin.product-order.list') }}" class="btn-view-all">
                     View All <i class="fas fa-arrow-right ms-1"></i>
                  </a>
               </div>
               <div class="card-body p-0">
                  @if($latestProductOrders->count() > 0)
                     <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                           <thead>
                              <tr>
                                 <th>Customer</th>
                                 <th>Order Number</th>
                                 <th>Amount</th>
                                 <th class="text-center">Status</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($latestProductOrders as $order)
                              @php
                                 $u = $order->user;
                                 $cName = $u ? $u->name : ($order->customer_name ?? 'Customer');
                                 $cPhone = $u ? $u->phone_no : ($order->customer_mobile ?? '');
                                 $cImg = $u ? $u->profile_image : null;
                                 $cInit = strtoupper(substr($cName, 0, 1));
                                 $st = strtolower($order->order_status);
                              @endphp
                              <tr>
                                 <td>
                                    <div class="admin-user-avatar-box">
                                       @if(!empty($cImg) && file_exists(public_path($cImg)))
                                          <img src="{{ asset($cImg) }}" alt="{{ $cName }}" class="admin-avatar-circle" style="object-fit: cover;">
                                       @else
                                          <div class="admin-avatar-circle" style="background: linear-gradient(135deg, #10b981, #047857);">
                                             {{ $cInit }}
                                          </div>
                                       @endif
                                       <div>
                                          <div class="user-info-name">{{ $cName }}</div>
                                          @if($cPhone)<div class="user-info-sub"><i class="fas fa-phone-alt me-1"></i>{{ $cPhone }}</div>@endif
                                       </div>
                                    </div>
                                 </td>
                                 <td class="fw-semibold text-dark small"><span class="badge bg-light text-dark border">{{ $order->order_number }}</span></td>
                                 <td class="fw-bold text-dark">₹{{ number_format($order->grand_total, 2) }}</td>
                                 <td class="text-center">
                                    <span class="ap-status-pill {{ $st == 'delivered' ? 'status-success' : ($st == 'pending' ? 'status-warning' : 'status-info') }}">
                                       <i class="fas fa-circle" style="font-size: 6px;"></i> {{ ucfirst($order->order_status) }}
                                    </span>
                                 </td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  @else
                     <div class="text-center py-5 px-3">
                        <i class="fa-solid fa-box-open fa-3x text-muted opacity-50 mb-2"></i>
                        <h6 class="fw-bold text-dark mb-1">No Orders Found</h6>
                        <p class="text-muted small mb-0">Store customer product orders will appear here.</p>
                     </div>
                  @endif
               </div>
            </div>
         </div>

         <!-- Latest Gateway Orders -->
         <div class="col-lg-6">
            <div class="admin-table-card">
               <div class="card-header">
                  <div class="card-title-group">
                     <div class="card-icon-pill" style="background: rgba(245, 158, 11, 0.12); color: #d97706;">
                        <i class="fa-solid fa-cart-shopping"></i>
                     </div>
                     <div>
                        <h5 class="card-header-title">Latest Gateway Orders</h5>
                     </div>
                  </div>
                  <a href="{{ route('admin.order.list') }}" class="btn-view-all">
                     View All <i class="fas fa-arrow-right ms-1"></i>
                  </a>
               </div>
               <div class="card-body p-0">
                  @if($latestGatewayOrders->count() > 0)
                     <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                           <thead>
                              <tr>
                                 <th>Customer</th>
                                 <th>Order Code</th>
                                 <th>Amount</th>
                                 <th class="text-center">Status</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($latestGatewayOrders as $gatewayOrder)
                              @php
                                 $cust = $gatewayOrder->customer;
                                 $cName = $cust ? $cust->name : ($gatewayOrder->customer_name ?? 'Customer');
                                 $cPhone = $cust ? $cust->phone_no : ($gatewayOrder->customer_mobile ?? '');
                                 $cImg = $cust ? $cust->profile_image : null;
                                 $cInit = strtoupper(substr($cName, 0, 1));
                                 $st = strtolower($gatewayOrder->status);
                              @endphp
                              <tr>
                                 <td>
                                    <div class="admin-user-avatar-box">
                                       @if(!empty($cImg) && file_exists(public_path($cImg)))
                                          <img src="{{ asset($cImg) }}" alt="{{ $cName }}" class="admin-avatar-circle" style="object-fit: cover;">
                                       @else
                                          <div class="admin-avatar-circle" style="background: linear-gradient(135deg, #d97706, #b45309);">
                                             {{ $cInit }}
                                          </div>
                                       @endif
                                       <div>
                                          <div class="user-info-name">{{ $cName }}</div>
                                          @if($cPhone)<div class="user-info-sub"><i class="fas fa-phone-alt me-1"></i>{{ $cPhone }}</div>@endif
                                       </div>
                                    </div>
                                 </td>
                                 <td class="fw-semibold text-dark small"><span class="badge bg-light text-dark border">{{ $gatewayOrder->order_code }}</span></td>
                                 <td class="fw-bold text-dark">₹{{ number_format($gatewayOrder->amount, 2) }}</td>
                                 <td class="text-center">
                                    <span class="ap-status-pill {{ $st == 'paid' || $st == 'success' ? 'status-success' : ($st == 'pending' ? 'status-warning' : 'status-danger') }}">
                                       <i class="fas fa-circle" style="font-size: 6px;"></i> {{ ucfirst($gatewayOrder->status) }}
                                    </span>
                                 </td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  @else
                     <div class="text-center py-5 px-3">
                        <i class="fa-solid fa-cart-shopping fa-3x text-muted opacity-50 mb-2"></i>
                        <h6 class="fw-bold text-dark mb-1">No Orders Found</h6>
                        <p class="text-muted small mb-0">Platform checkout orders will appear here.</p>
                     </div>
                  @endif
               </div>
            </div>
         </div>
      </div>

      <!-- 5. Latest Transactions -->
      <div class="row g-4 mb-4">
         <div class="col-12">
            <div class="admin-table-card">
               <div class="card-header">
                  <div class="card-title-group">
                     <div class="card-icon-pill" style="background: rgba(13, 148, 136, 0.12); color: #0d9488;">
                        <i class="fa-solid fa-receipt"></i>
                     </div>
                     <div>
                        <h5 class="card-header-title">Latest Transactions & Settlement Logs</h5>
                     </div>
                  </div>
                  <a href="{{ route('admin.transaction.list') }}" class="btn-view-all">
                     View All Transactions <i class="fas fa-arrow-right ms-1"></i>
                  </a>
               </div>
               <div class="card-body p-0">
                  @if($latestTransactions->count() > 0)
                     <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                           <thead>
                              <tr>
                                 <th>Customer</th>
                                 <th>Payment / Transaction ID</th>
                                 <th>Amount</th>
                                 <th>Date & Time</th>
                                 <th class="text-center">Status</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($latestTransactions as $txn)
                              @php
                                 $cust = $txn->customer;
                                 $cName = $cust ? $cust->name : 'Customer';
                                 $cPhone = $cust ? $cust->phone_no : '';
                                 $cImg = $cust ? $cust->profile_image : null;
                                 $cInit = strtoupper(substr($cName, 0, 1));
                                 $st = strtolower($txn->status);
                              @endphp
                              <tr>
                                 <td>
                                    <div class="admin-user-avatar-box">
                                       @if(!empty($cImg) && file_exists(public_path($cImg)))
                                          <img src="{{ asset($cImg) }}" alt="{{ $cName }}" class="admin-avatar-circle" style="object-fit: cover;">
                                       @else
                                          <div class="admin-avatar-circle" style="background: linear-gradient(135deg, #0d9488, #0f766e);">
                                             {{ $cInit }}
                                          </div>
                                       @endif
                                       <div>
                                          <div class="user-info-name">{{ $cName }}</div>
                                          @if($cPhone)<div class="user-info-sub"><i class="fas fa-phone-alt me-1"></i>{{ $cPhone }}</div>@endif
                                       </div>
                                    </div>
                                 </td>
                                 <td class="fw-semibold text-dark small">
                                    <code class="text-primary">{{ $txn->transaction_id ?? $txn->razorpay_payment_id ?? 'N/A' }}</code>
                                 </td>
                                 <td class="fw-bold text-dark">₹{{ number_format($txn->amount, 2) }}</td>
                                 <td>
                                    <div class="text-dark small fw-medium">
                                       <i class="fa-regular fa-calendar text-muted me-1"></i> {{ $txn->created_at ? $txn->created_at->format('d M Y') : 'N/A' }}
                                    </div>
                                    <div class="text-muted small">
                                       <i class="fa-regular fa-clock text-muted me-1"></i> {{ $txn->created_at ? $txn->created_at->format('h:i A') : '' }}
                                    </div>
                                 </td>
                                 <td class="text-center">
                                    <span class="ap-status-pill {{ $st == 'success' ? 'status-success' : ($st == 'pending' ? 'status-warning' : 'status-danger') }}">
                                       <i class="fas fa-circle" style="font-size: 6px;"></i> {{ ucfirst($txn->status) }}
                                    </span>
                                 </td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  @else
                     <div class="text-center py-5 px-3">
                        <i class="fa-solid fa-receipt fa-3x text-muted opacity-50 mb-2"></i>
                        <h6 class="fw-bold text-dark mb-1">No Transactions Recorded</h6>
                        <p class="text-muted small mb-0">Payment logs will appear here once orders are processed.</p>
                     </div>
                  @endif
               </div>
            </div>
         </div>
      </div>

   </div>
</div>
@endsection