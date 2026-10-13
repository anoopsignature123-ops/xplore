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
                     <i class="fas fa-tools me-2"></i>{{ $page_title }}
                     <span class="badge bg-primary ms-2" id="total-count">...</span>
                  </h5>
                  <a href="{{ route('admin.builder-service-type.add') }}" class="btn btn-primary btn-sm">
                     <i class="fas fa-plus me-1"></i> Add Service Type
                  </a>
               </div>
               <div class="card-body">

                  @if(session('success'))
                     <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                     </div>
                  @endif

                  <div class="table-responsive">
                     <table class="table table-bordered table-hover align-middle" id="service-type-table">
                        <thead class="table-dark">
                           <tr>
                              <th width="60">#</th>
                              <th>Service Name</th>
                              <th width="220">Icon Preview</th>
                              <th width="120" class="text-center">Status</th>
                              <th width="180" class="text-center">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           {{-- Filled via AJAX --}}
                        </tbody>
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

    var table = $('#service-type-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.builder-service-type.getRecords') }}",
            type: "GET",
            error: function(xhr, error, thrown) {
                console.error('DataTable AJAX error:', xhr.responseText);
                toastr.error('Failed to load data. Check console.');
            }
        },
        columns: [
            { data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name',         name: 'name' },
            { data: 'icon',         name: 'icon',   orderable: false, searchable: false },
            { data: 'status',       name: 'status', orderable: false, searchable: false, className: 'text-center' },
            { data: 'action',       name: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],
        order: [[0, 'asc']],
        pageLength: 25,
        language: {
            processing:     '<div class="spinner-border text-primary" role="status"></div>',
            emptyTable:     '<div class="text-center py-4"><i class="fas fa-inbox fa-2x text-muted mb-2"></i><br>No service types added yet.</div>',
            zeroRecords:    'No matching service types found.',
            loadingRecords: 'Loading...'
        },
        drawCallback: function(settings) {
            var api = this.api();
            $('#total-count').text(api.page.info().recordsTotal);
        }
    });

    // ── Status Toggle ──────────────────────────────────────
    $(document).on('change', '.status-toggle', function() {
        var checkbox  = $(this);
        var id        = checkbox.data('id');
        var isChecked = checkbox.is(':checked');

        Swal.fire({
            title: 'Change Status?',
            text: 'Are you sure you want to change the status?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#308e87',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.builder-service-type.toggleStatus') }}",
                    type: "POST",
                    data: { _token: "{{ csrf_token() }}", id: id },
                    success: function(res) {
                        if (res.status) {
                            toastr.success(res.message);
                        } else {
                            toastr.error(res.message);
                            checkbox.prop('checked', !isChecked);
                        }
                    },
                    error: function() {
                        toastr.error('Something went wrong!');
                        checkbox.prop('checked', !isChecked);
                    }
                });
            } else {
                checkbox.prop('checked', !isChecked);
            }
        });
    });

    // ── Delete ─────────────────────────────────────────────
    $(document).on('click', '.delete-btn', function() {
        var url  = $(this).data('url');
        var name = $(this).data('name');

        Swal.fire({
            title: 'Delete "' + name + '"?',
            text: 'Builders using this service type will lose this tag. This cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function(res) {
                        if (res.status) {
                            Swal.fire('Deleted!', res.message, 'success');
                            table.ajax.reload(null, false);
                        } else {
                            toastr.error(res.message);
                        }
                    },
                    error: function() {
                        toastr.error('Something went wrong while deleting!');
                    }
                });
            }
        });
    });

});
</script>
@endpush
