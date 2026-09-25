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
                  <a href="{{ route('admin.build-category.add') }}" class="btn btn-primary btn-sm">
                     <i class="fas fa-plus me-1"></i> Add Build Category
                  </a>
               </div>
               <div class="card-body">
                  @if(session('success'))
                     <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                     </div>
                  @endif

                  <div class="table-responsive">
                     <table class="table table-bordered table-striped" id="build-category-table">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Category Name</th>
                              <th>Slug</th>
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
    var table = $('#build-category-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.build-category.getRecords') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'slug', name: 'slug'},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    $(document).on('change', '.status-toggle', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "{{ route('admin.build-category.toggleStatus') }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}", id: id },
            success: function(res) {
                if(res.status) toastr.success(res.message);
                else toastr.error(res.message);
            }
        });
    });

    $(document).on('click', '.delete-btn', function() {
        var url = $(this).data('url');
        if(confirm('Are you sure you want to delete this category?')) {
            $.ajax({
                url: url,
                type: "DELETE",
                data: { _token: "{{ csrf_token() }}" },
                success: function(res) {
                    if(res.status) {
                        toastr.success(res.message);
                        table.ajax.reload();
                    } else toastr.error(res.message);
                }
            });
        }
    });
});
</script>
@endpush
