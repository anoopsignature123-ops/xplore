@extends('vendor.includes.layout')
@section('title', $page_title)
@section('content')
<div class="page-body">
   <div class="container-fluid">
      <!-- Page Title -->
      <div class="page-title">
         <div class="row align-items-center">
            <div class="col-sm-12 col-12">
               <h2 class="fw-bold mb-1 text-dark" style="font-family: 'Outfit', sans-serif;">Vendor Dashboard</h2>
               <p class="mb-0 text-muted">Welcome, {{ $vendor->name }}</p>
            </div>
            
         </div>
      </div>
   </div>
   
   <div class="container-fluid default-dashboard">
      <div class="row g-3">
         @php
         $cards = [
             [
                 'title' => $totalSurveys,
                 'subtitle' => 'Total Surveys',
                 'url' => route('vendor.my-survey.list'),
                 'icon' => 'fa-poll',
                 'color' => '#4e73df'
             ],
             [
                 'title' => $todaySurveys,
                 'subtitle' => 'Today Surveys',
                 'url' => route('vendor.my-survey.list') . '?date=today',
                 'icon' => 'fa-calendar-day',
                 'color' => '#1cc88a'
             ],
             [
                 'title' => $totalOngoingSurveys,
                 'subtitle' => 'Ongoing Surveys',
                 'url' => route('vendor.my-survey.list') . '?status=Ongoing',
                 'icon' => 'fa-clock',
                 'color' => '#f6c23e'
             ],
             [
                 'title' => $totalCompletedSurveys,
                 'subtitle' => 'Completed Surveys',
                 'url' => route('vendor.my-survey.list') . '?status=Completed',
                 'icon' => 'fa-check-circle',
                 'color' => '#36b9cc'
             ],
             
         ];
         @endphp

         @foreach($cards as $card)
         <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
             <a href="{{ $card['url'] }}" class="text-decoration-none">
                 <div class="card dash-stats-card border-0 shadow-sm h-100">
                     <div class="card-body p-4 d-flex align-items-center">
                         <div class="stats-icon-box"
                              style="background: {{ $card['color'] }}15; color: {{ $card['color'] }};">
                             <i class="fa-solid {{ $card['icon'] }}"></i>
                         </div>
                         <div class="ms-3">
                             <p class="text-muted mb-0 small fw-bold text-uppercase">
                                 {{ $card['subtitle'] }}
                             </p>
                             <h3 class="text-dark mb-0 fw-bold">
                                 {{ $card['title'] }}
                             </h3>
                         </div>
                     </div>
                 </div>
             </a> 
         </div>
         @endforeach
      </div>
      <div class="row mt-4">
         <!-- Latest Ongoing Surveys -->
         <div class="col-lg-6 mb-4">
             <div class="card shadow-sm border-0 rounded-3 h-100">
                 <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                     <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-clock text-warning me-2"></i> Latest Ongoing Surveys</h5>
                     <a href="{{ route('vendor.my-survey.list') }}?status=Ongoing" class="btn btn-sm btn-outline-primary">View All</a>
                 </div>
                 <div class="card-body p-0">
                     @if($latestOngoingSurveys->count() > 0)
                         <div class="table-responsive">
                             <table class="table table-hover align-middle mb-0">
                                 <thead style="background: #f8f9fa;">
                                     <tr>
                                         <th class="border-0 px-3 py-2 text-muted">Customer</th>
                                         <th class="border-0 px-3 py-2 text-muted">Survey</th>
                                         <th class="border-0 px-3 py-2 text-muted text-center">Status / Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach($latestOngoingSurveys as $survey)
                                     <tr>
                                         <td class="px-3">
                                             @if($survey->customer)
                                                 <div class="d-flex align-items-center">
                                                     <img src="{{ !empty($survey->customer->profile_image) ? asset($survey->customer->profile_image) : asset('assets/images/user.png') }}" alt="Profile" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:10px;">
                                                     <div>
                                                         <strong>{{ $survey->customer->name }}</strong><br>
                                                         <small class="text-muted">{{ $survey->customer->phone_no }}</small>
                                                     </div>
                                                 </div>
                                             @else
                                                 N/A
                                             @endif
                                         </td>
                                         <td class="px-3">
                                             <strong>{{ $survey->survey_name }}</strong><br>
                                             <small class="text-muted">{{ \Carbon\Carbon::parse($survey->survey_date)->format('d M Y') }} | {{ \Carbon\Carbon::parse($survey->survey_time)->format('h:i A') }}</small>
                                         </td>
                                         <td class="px-3 text-center">
                                             <div class="d-flex justify-content-center align-items-center gap-2">
                                                 <span class="badge bg-info rounded-pill px-3 py-2">Ongoing</span>
                                                 <strong class="text-muted fs-5">|</strong>
                                                 <a href="{{ route('vendor.my-survey.chat', $survey->id) }}" class="btn btn-sm btn-info text-white rounded-pill px-3">
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
                         <div class="text-center p-4">
                             <i class="fa-solid fa-clock fs-1 text-muted mb-2 opacity-50"></i>
                             <h6 class="text-muted mb-0">No ongoing surveys</h6>
                         </div>
                     @endif
                 </div>
             </div>
         </div>

         <!-- Latest Completed Surveys -->
         <div class="col-lg-6 mb-4">
             <div class="card shadow-sm border-0 rounded-3 h-100">
                 <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                     <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-check-circle text-success me-2"></i> Latest Completed Surveys</h5>
                     <a href="{{ route('vendor.my-survey.list') }}?status=Completed" class="btn btn-sm btn-outline-primary">View All</a>
                 </div>
                 <div class="card-body p-0">
                     @if($latestCompletedSurveys->count() > 0)
                         <div class="table-responsive">
                             <table class="table table-hover align-middle mb-0">
                                 <thead style="background: #f8f9fa;">
                                     <tr>
                                         <th class="border-0 px-3 py-2 text-muted">Customer</th>
                                         <th class="border-0 px-3 py-2 text-muted">Survey</th>
                                         <th class="border-0 px-3 py-2 text-muted text-center">Status / Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach($latestCompletedSurveys as $survey)
                                     <tr>
                                         <td class="px-3">
                                             @if($survey->customer)
                                                 <div class="d-flex align-items-center">
                                                     <img src="{{ !empty($survey->customer->profile_image) ? asset($survey->customer->profile_image) : asset('assets/images/user.png') }}" alt="Profile" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:10px;">
                                                     <div>
                                                         <strong>{{ $survey->customer->name }}</strong><br>
                                                         <small class="text-muted">{{ $survey->customer->phone_no }}</small>
                                                     </div>
                                                 </div>
                                             @else
                                                 N/A
                                             @endif
                                         </td>
                                         <td class="px-3">
                                             <strong>{{ $survey->survey_name }}</strong><br>
                                             <small class="text-muted">{{ \Carbon\Carbon::parse($survey->survey_date)->format('d M Y') }} | {{ \Carbon\Carbon::parse($survey->survey_time)->format('h:i A') }}</small>
                                         </td>
                                         <td class="px-3 text-center">
                                             <div class="d-flex justify-content-center align-items-center gap-2">
                                                 <span class="badge bg-success rounded-pill px-3 py-2">Completed</span>
                                                 <strong class="text-muted fs-5">|</strong>
                                                 <a href="{{ route('vendor.my-survey.chat', $survey->id) }}" class="btn btn-sm btn-info text-white rounded-pill px-3">
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
                         <div class="text-center p-4">
                             <i class="fa-solid fa-check-circle fs-1 text-muted mb-2 opacity-50"></i>
                             <h6 class="text-muted mb-0">No completed surveys</h6>
                         </div>
                     @endif
                 </div>
             </div>
         </div>
      </div>
   </div>
</div>
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
<style>
   .dash-stats-card {
      border-radius: 12px;
      transition: all 0.2s ease-in-out;
      background: #ffffff !important;
      border: 1px solid #f0f0f0 !important;
   }
   
   .dash-stats-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 15px rgba(0,0,0,0.08) !important;
   }
   
   .stats-icon-box {
      width: 50px !important;
      height: 50px !important;
      min-width: 50px !important;
      border-radius: 10px;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      font-size: 22px !important;
   }

   .stats-icon-box i {
      line-height: 1 !important;
      display: block !important;
   }
   
   /* Custom font for numbers */
   .dash-stats-card h3 {
      font-family: 'Outfit', sans-serif;
      font-size: 1.4rem;
      margin-top: 2px;
   }

   .default-dashboard .row {
      margin-top: 10px;
   }
</style>
@endpush
