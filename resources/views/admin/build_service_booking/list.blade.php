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
                  <li class="breadcrumb-item">Xplore Build</li>
                  <li class="breadcrumb-item active">{{ $page_title }}</li>
               </ol>
            </div>
         </div>
      </div>
   </div>

   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
            <div class="card shadow-lg border-0 rounded-3">
               <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                  <h5 class="mb-0 fw-bold text-primary">
                     <i class="fas fa-calendar-check me-2"></i>{{ $page_title }}
                     <span class="badge bg-primary ms-2" id="total-count">...</span>
                  </h5>
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <table class="table table-bordered table-hover align-middle" id="booking-table">
                        <thead class="table-dark">
                           <tr>
                              <th width="50">#</th>
                              <th>Service</th>
                              <th>Customer</th>
                              <th>Site Location</th>
                              <th width="160">Budget / Timeline</th>
                              <th width="120" class="text-center">Status</th>
                              <th width="100" class="text-center">Action</th>
                           </tr>
                        </thead>
                        <tbody>{{-- AJAX --}}</tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    var table = $('#booking-table').DataTable({
        processing: true, serverSide: true,
        ajax: { url: "{{ route('admin.build-booking.getRecords') }}", type: "GET",
            error: function(xhr) { toastr.error('Failed to load data.'); }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'service',       name: 'build_service_id', orderable: false },
            { data: 'customer_name', name: 'customer_name' },
            { data: 'site_location', name: 'site_location' },
            { data: 'budget_range',  name: 'budget_range', orderable: false },
            { data: 'status',        name: 'status', orderable: false, className: 'text-center' },
            { data: 'action',        name: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],
        order: [[0, 'desc']], pageLength: 25,
        drawCallback: function() { $('#total-count').text(this.api().page.info().recordsTotal); }
    });
});
</script>
@endpush
