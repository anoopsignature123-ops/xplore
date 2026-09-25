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
                  <li class="breadcrumb-item">{{ $page_title }}</li>
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
                  <h5 class="mb-0 fw-bold text-primary">{{ $page_title }}</h5>
               </div>
               <div class="card-body">
                  @if(session('success'))
                     <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                     </div>
                  @endif

                  <div class="row g-3 mb-3">
                     <div class="col-md-3">
                        <label class="form-label fw-bold">Filter Status</label>
                        <select id="filter-status" class="form-select">
                           <option value="">All Statuses</option>
                           <option value="pending">Pending</option>
                           <option value="contacted">Contacted</option>
                           <option value="closed">Closed</option>
                        </select>
                     </div>
                  </div>

                  <div class="table-responsive">
                     <table class="table table-bordered table-striped" id="inquiries-table">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Customer</th>
                              <th>Builder / Contractor</th>
                              <th>Inquiry Type</th>
                              <th>Date</th>
                              <th>Status</th>
                              <th>Action</th>
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
    var table = $('#inquiries-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.build-inquiry.getRecords') }}",
            data: function(d) {
                d.status = $('#filter-status').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'builder', name: 'builder'},
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
            url: "{{ route('admin.build-inquiry.updateStatus') }}",
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
