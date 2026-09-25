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
                  <a href="{{ route('admin.builder.add') }}" class="btn btn-primary btn-sm">
                     <i class="fas fa-plus me-1"></i> Add New Builder / Contractor
                  </a>
               </div>
               <div class="card-body">
                  @if(session('success'))
                     <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                     </div>
                  @endif

                  <div class="row g-3 mb-3">
                     <div class="col-md-4">
                        <label class="form-label fw-bold">Filter by Category</label>
                        <select id="filter-category" class="form-select">
                           <option value="">All Categories</option>
                           @foreach($categories as $cat)
                              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>

                  <div class="table-responsive">
                     <table class="table table-bordered table-striped" id="builders-table">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Avatar</th>
                              <th>Firm / Name</th>
                              <th>Category</th>
                              <th>Location</th>
                              <th>Rating</th>
                              <th>Verified</th>
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
    var table = $('#builders-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.builder.getRecords') }}",
            data: function(d) {
                d.category_id = $('#filter-category').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'profile_image', name: 'profile_image', orderable: false, searchable: false},
            {data: 'firm_name', name: 'firm_name'},
            {data: 'category', name: 'category'},
            {data: 'location', name: 'location'},
            {data: 'rating', name: 'rating'},
            {data: 'is_verified', name: 'is_verified', orderable: false, searchable: false},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    $('#filter-category').change(function() {
        table.ajax.reload();
    });

    $(document).on('change', '.verify-toggle', function() {
        var checkbox = $(this);
        var id = checkbox.data('id');
        var isChecked = checkbox.is(':checked');

        Swal.fire({
            title: 'Toggle Verification?',
            text: 'Are you sure you want to change verification status for this builder?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#308e87',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.builder.toggleVerify') }}",
                    type: "POST",
                    data: { _token: "{{ csrf_token() }}", id: id },
                    success: function(res) {
                        if(res.status) toastr.success(res.message);
                        else {
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

    $(document).on('change', '.status-toggle', function() {
        var checkbox = $(this);
        var id = checkbox.data('id');
        var isChecked = checkbox.is(':checked');

        Swal.fire({
            title: 'Change Status?',
            text: 'Are you sure you want to change status for this builder?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#308e87',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.builder.toggleStatus') }}",
                    type: "POST",
                    data: { _token: "{{ csrf_token() }}", id: id },
                    success: function(res) {
                        if(res.status) toastr.success(res.message);
                        else {
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

    $(document).on('click', '.delete-btn', function() {
        var url = $(this).data('url');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this builder profile!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function(res) {
                        if(res.status) {
                            Swal.fire('Deleted!', res.message, 'success');
                            table.ajax.reload();
                        } else toastr.error(res.message);
                    }
                });
            }
        });
    });
});
</script>
@endpush
