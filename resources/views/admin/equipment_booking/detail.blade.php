@extends('admin.includes.layout')
@section('title', $page_title)
@section('content')
<div class="page-body">
   <div class="container-fluid">
      <div class="page-title">
         <div class="row">
            <div class="col-sm-6 col-12">
               <h4 class="m-0">{{ $page_title }}</h4>
            </div>
            <div class="col-sm-6 col-12">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="fa-solid fa-home me-2"></i></a></li>
                  <li class="breadcrumb-item"><a href="{{ route('admin.equipment-booking.list') }}">Bookings</a></li>
                  <li class="breadcrumb-item active">Details</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-8">
            <!-- Booking Details Card -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
               <div class="card-header bg-light py-3">
                  <h5 class="mb-0 fw-bold text-primary">Booking #{{ $booking->booking_number }}</h5>
               </div>
               <div class="card-body">
                  <div class="row g-3">
                     <div class="col-md-6">
                        <label class="text-muted fs-7">Equipment Name</label>
                        <p class="fw-bold fs-6 mb-0">{{ $booking->equipment->name ?? 'N/A' }}</p>
                     </div>
                     <div class="col-md-6">
                        <label class="text-muted fs-7">Rental Duration</label>
                        <p class="fw-bold fs-6 mb-0">{{ $booking->rental_duration_days }} Days</p>
                     </div>

                     <div class="col-md-6">
                        <label class="text-muted fs-7">Delivery Type</label>
                        <p class="fw-bold mb-0">
                           <span class="badge bg-info text-capitalize">{{ str_replace('_', ' ', $booking->delivery_type) }}</span>
                        </p>
                     </div>
                     <div class="col-md-6">
                        <label class="text-muted fs-7">Payment Method</label>
                        <p class="fw-bold text-uppercase mb-0">{{ $booking->payment_method ?? 'N/A' }}</p>
                     </div>

                     <div class="col-12"><hr class="my-2"></div>

                     <!-- Pricing Breakdown -->
                     <div class="col-md-6">
                        <label class="text-muted fs-7">Daily Rate</label>
                        <p class="fw-bold mb-1">₹{{ number_format($booking->daily_rate, 2) }}</p>
                     </div>
                     <div class="col-md-6">
                        <label class="text-muted fs-7">Rental Cost</label>
                        <p class="fw-bold mb-1">₹{{ number_format($booking->rental_cost, 2) }}</p>
                     </div>

                     <div class="col-md-6">
                        <label class="text-muted fs-7">Security Deposit</label>
                        <p class="fw-bold mb-1">₹{{ number_format($booking->security_deposit, 2) }}</p>
                     </div>
                     <div class="col-md-6">
                        <label class="text-muted fs-7">GST Amount</label>
                        <p class="fw-bold mb-1">₹{{ number_format($booking->gst_amount, 2) }}</p>
                     </div>

                     <div class="col-12 bg-light p-3 rounded mt-2">
                        <div class="d-flex justify-content-between align-items-center">
                           <h5 class="mb-0 fw-bold">Total Amount</h5>
                           <h4 class="mb-0 fw-bold text-success">₹{{ number_format($booking->total_amount, 2) }}</h4>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <!-- Delivery Location Card -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
               <div class="card-header bg-light py-3">
                  <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-map-marker-alt me-2"></i> Delivery Location</h5>
               </div>
               <div class="card-body">
                  <p class="mb-2"><strong>Address:</strong> {{ $booking->delivery_address ?? $booking->address->address ?? 'N/A' }}</p>
                  @if($booking->latitude && $booking->longitude)
                     <p class="mb-0 text-muted"><strong>Coordinates:</strong> Lat: {{ $booking->latitude }}, Long: {{ $booking->longitude }}</p>
                     <a href="https://maps.google.com/?q={{ $booking->latitude }},{{ $booking->longitude }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                        <i class="fas fa-external-link-alt me-1"></i> Open in Google Maps
                     </a>
                  @endif
               </div>
            </div>
         </div>

         <div class="col-md-4">
            <!-- Status Update Form -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
               <div class="card-header bg-light py-3">
                  <h5 class="mb-0 fw-bold text-primary">Manage Status</h5>
               </div>
               <div class="card-body">
                  @if(session('success'))
                     <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                     </div>
                  @endif

                  <form action="{{ route('admin.equipment-booking.updateStatus', $booking->id) }}" method="POST">
                     @csrf
                     <div class="mb-3">
                        <label class="form-label fw-bold">Booking Status</label>
                        <select name="booking_status" class="form-select">
                           <option value="pending" {{ $booking->booking_status == 'pending' ? 'selected' : '' }}>Pending</option>
                           <option value="confirmed" {{ $booking->booking_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                           <option value="dispatched" {{ $booking->booking_status == 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                           <option value="delivered" {{ $booking->booking_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                           <option value="returned" {{ $booking->booking_status == 'returned' ? 'selected' : '' }}>Returned</option>
                           <option value="cancelled" {{ $booking->booking_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                     </div>

                     <div class="mb-3">
                        <label class="form-label fw-bold">Payment Status</label>
                        <select name="payment_status" class="form-select">
                           <option value="pending" {{ $booking->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                           <option value="paid" {{ $booking->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                           <option value="failed" {{ $booking->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                           <option value="refunded" {{ $booking->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                     </div>

                     <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save me-1"></i> Update Status</button>
                  </form>
               </div>
            </div>

            <!-- Customer Details Card -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
               <div class="card-header bg-light py-3">
                  <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-user me-2"></i> Customer Info</h5>
               </div>
               <div class="card-body">
                  <p class="mb-1"><strong>Name:</strong> {{ $booking->customer->name ?? 'N/A' }}</p>
                  <p class="mb-1"><strong>Phone:</strong> {{ $booking->customer->phone_no ?? 'N/A' }}</p>
                  <p class="mb-0"><strong>Email:</strong> {{ $booking->customer->email_id ?? $booking->customer->email ?? 'N/A' }}</p>
               </div>

            </div>
         </div>
      </div>
   </div>
</div>
@endsection
