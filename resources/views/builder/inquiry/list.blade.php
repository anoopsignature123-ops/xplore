@extends('builder.includes.layout')

@section('title', $page_title)
@section('content')
<div class="page-body">
   <div class="container-fluid">
      <div class="page-title">
         <div class="row">
            <div class="col-sm-6 col-12">
               <h4 class="m-0">{{ $page_title }}</h4>
            </div>
            <div class="col-sm-6 col-12 text-end">
               <a href="{{ route('builder.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Dashboard</a>
            </div>
         </div>
      </div>
   </div>
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
            <div class="card shadow-lg border-0 rounded-3">
               <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                  <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-envelope-open-text me-2"></i> {{ $page_title }}</h5>
               </div>
               <div class="card-body">
                  <div class="row g-3 mb-3">
                     <div class="col-md-3">
                        <label class="form-label fw-bold"><i class="fas fa-filter text-primary me-1"></i> Filter Status</label>
                        <select id="filter-status" class="form-select">
                           <option value="">All Statuses</option>
                           <option value="pending">Pending</option>
                           <option value="contacted">Contacted</option>
                           <option value="closed">Closed</option>
                        </select>
                     </div>
                  </div>

                  <div class="table-responsive">
                     <table class="table table-bordered table-striped" id="builder-inquiries-table">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th><i class="fas fa-user me-1 text-primary"></i> Customer Name</th>
                              <th><i class="fas fa-phone-alt me-1 text-success"></i> Phone</th>
                              <th><i class="fas fa-tag me-1 text-info"></i> Inquiry Type</th>
                              <th><i class="fas fa-calendar-alt me-1 text-warning"></i> Date</th>
                              <th><i class="fas fa-tasks me-1 text-secondary"></i> Status</th>
                              <th><i class="fas fa-cogs me-1 text-dark"></i> Action</th>
                           </tr>
                        </thead>
                     </table>
                  </div>
               </div>
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
        ]
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
