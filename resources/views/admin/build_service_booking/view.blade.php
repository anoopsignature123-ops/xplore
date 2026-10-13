@extends('admin.includes.layout')
@section('title', $page_title)
@section('content')
<div class="page-body">
   <div class="container-fluid">
      <div class="page-title">
         <div class="row">
            <div class="col-sm-6 col-12"><h4 class="m-0">{{ $page_title }}</h4></div>
            <div class="col-sm-6 col-12">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="fa-solid fa-home me-2"></i></a></li>
                  <li class="breadcrumb-item"><a href="{{ route('admin.build-booking.list') }}">Build Bookings</a></li>
                  <li class="breadcrumb-item active">{{ $page_title }}</li>
               </ol>
            </div>
         </div>
      </div>
   </div>

   <div class="container-fluid">
      @if(session('success'))
         <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
         </div>
      @endif

      <div class="row g-4">
         <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
               <div class="card-header bg-primary text-white py-3">
                  <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Booking Details</h5>
               </div>
               <div class="card-body">
                  <table class="table table-borderless mb-0">
                     <tr>
                        <th width="200" class="text-muted">Booking ID</th>
                        <td><strong>#{{ $booking->id }}</strong></td>
                     </tr>
                     <tr>
                        <th class="text-muted">Service</th>
                        <td>
                           @if($booking->service)
                              @if($booking->service->category)
                                 <span class="badge bg-primary-subtle text-primary">{{ $booking->service->category->name }}</span>
                              @endif
                              <strong>{{ $booking->service->title }}</strong>
                           @else — @endif
                        </td>
                     </tr>
                     <tr>
                        <th class="text-muted">Customer Name</th>
                        <td>{{ $booking->customer_name ?? '—' }}</td>
                     </tr>
                     <tr>
                        <th class="text-muted">Contact Mobile</th>
                        <td><strong>{{ $booking->contact_mobile }}</strong></td>
                     </tr>
                     <tr>
                        <th class="text-muted">Site Location</th>
                        <td>{{ $booking->site_location }}</td>
                     </tr>
                     <tr>
                        <th class="text-muted">Target Timeline</th>
                        <td><span class="badge bg-info-subtle text-info">{{ $booking->target_timeline ?? '—' }}</span></td>
                     </tr>
                     <tr>
                        <th class="text-muted">Budget Range</th>
                        <td><span class="badge bg-success-subtle text-success">{{ $booking->budget_range ?? '—' }}</span></td>
                     </tr>
                     <tr>
                        <th class="text-muted">Project Notes</th>
                        <td>{{ $booking->project_notes ?: '—' }}</td>
                     </tr>
                     <tr>
                        <th class="text-muted">Submitted At</th>
                        <td>{{ $booking->created_at->format('d M Y, h:i A') }}</td>
                     </tr>
                  </table>
               </div>
            </div>
         </div>

         <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
               <div class="card-header bg-warning text-dark py-3">
                  <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Update Status</h5>
               </div>
               <div class="card-body">
                  <form id="update-status-form">
                     @csrf
                     <input type="hidden" name="id" value="{{ $booking->id }}">

                     <div class="mb-3">
                        <label class="form-label fw-semibold">Current Status</label>
                        @php
                           $colors = ['pending' => 'warning', 'assigned' => 'info', 'in_progress' => 'primary', 'completed' => 'success', 'cancelled' => 'danger'];
                        @endphp
                        <div>
                           <span class="badge bg-{{ $colors[$booking->status] ?? 'secondary' }} fs-6">
                              {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                           </span>
                        </div>
                     </div>

                     <div class="mb-3">
                        <label class="form-label fw-semibold">Change Status</label>
                        <select name="status" class="form-select">
                           @foreach(['pending', 'assigned', 'in_progress', 'completed', 'cancelled'] as $s)
                              <option value="{{ $s }}" {{ $booking->status == $s ? 'selected' : '' }}>
                                 {{ ucfirst(str_replace('_', ' ', $s)) }}
                              </option>
                           @endforeach
                        </select>
                     </div>

                     <div class="mb-4">
                        <label class="form-label fw-semibold">Admin Notes</label>
                        <textarea name="admin_notes" class="form-control" rows="4"
                           placeholder="Internal notes about this booking...">{{ $booking->admin_notes }}</textarea>
                     </div>

                     <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>Update Status
                     </button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@push('scripts')
<script>
$('#update-status-form').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: "{{ route('admin.build-booking.updateStatus') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function(res) {
            if (res.status) {
                toastr.success(res.message);
                setTimeout(() => location.reload(), 1000);
            } else {
                toastr.error(res.message);
            }
        },
        error: function() { toastr.error('Something went wrong!'); }
    });
});
</script>
@endpush
