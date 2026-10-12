@extends('builder.includes.layout')

@section('title', $page_title)
@section('content')
<div class="page-body">
   <div class="container-fluid p-0">
      
      <!-- Top Title Bar -->
      <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
         <div>
            <h3 class="fw-bold text-dark mb-1" style="font-family: 'Outfit', sans-serif;">
               <i class="fas fa-comments text-primary me-2"></i> {{ $page_title }}
            </h3>
            <p class="text-muted small mb-0">Review client inquiries, phone requests, and manage follow-up statuses.</p>
         </div>
         <div>
            <a href="{{ route('builder.index') }}" class="btn btn-outline-secondary rounded-pill px-3 py-2 fw-semibold shadow-sm">
               <i class="fas fa-arrow-left me-1"></i> Dashboard
            </a>
         </div>
      </div>

      <!-- Inquiries Table Card -->
      <div class="vendor-table-card">
         <div class="card-header flex-wrap gap-3">
            <div class="card-title-group">
               <div class="card-icon-pill ongoing-pill">
                  <i class="fas fa-filter"></i>
               </div>
               <div>
                  <h5 class="card-header-title">All Customer Leads</h5>
               </div>
            </div>

            <!-- Filter Status Dropdown -->
            <div class="d-flex align-items-center gap-2 ms-auto">
               <span class="text-muted small fw-bold text-nowrap"><i class="fas fa-sliders me-1"></i> Filter:</span>
               <select id="filter-status" class="form-select form-select-sm rounded-pill" style="min-width: 150px;">
                  <option value="">All Statuses</option>
                  <option value="pending">Pending Only</option>
                  <option value="contacted">Contacted</option>
                  <option value="closed">Closed</option>
               </select>
            </div>
         </div>

         <div class="card-body p-3">
            <div class="table-responsive">
               <table class="table table-hover align-middle w-100" id="builder-inquiries-table">
                  <thead>
                     <tr>
                        <th style="width: 50px;">#</th>
                        <th><i class="fas fa-user me-1 text-primary"></i> Customer Name</th>
                        <th><i class="fas fa-phone-alt me-1 text-success"></i> Phone</th>
                        <th><i class="fas fa-tag me-1 text-info"></i> Inquiry Type</th>
                        <th><i class="fas fa-calendar-alt me-1 text-warning"></i> Received Date</th>
                        <th><i class="fas fa-tasks me-1 text-secondary"></i> Status</th>
                        <th><i class="fas fa-sliders me-1 text-dark"></i> Update Status</th>
                     </tr>
                  </thead>
               </table>
            </div>
         </div>
      </div>

   </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    var table = $('#builder-inquiries-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('builder.inquiry.getRecords') }}",
            data: function(d) {
                d.status = $('#filter-status').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'customer_phone', name: 'customer_phone'},
            {data: 'inquiry_type', name: 'inquiry_type'},
            {data: 'created_at', name: 'created_at'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search inquiries...",
            paginate: {
               next: '<i class="fas fa-chevron-right"></i>',
               previous: '<i class="fas fa-chevron-left"></i>'
            }
        }
    });

    $('#filter-status').change(function() {
        table.ajax.reload();
    });

    $(document).on('change', '.status-select', function() {
        var id = $(this).data('id');
        var status = $(this).val();
        $.ajax({
            url: "{{ route('builder.inquiry.updateStatus') }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}", id: id, status: status },
            success: function(res) {
                if(res.status) {
                    toastr.success(res.message);
                    table.ajax.reload(null, false);
                } else toastr.error(res.message);
            }
        });
    });
});
</script>
@endpush
