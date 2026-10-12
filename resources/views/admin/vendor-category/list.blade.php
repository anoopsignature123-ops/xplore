@extends('admin.includes.layout')
@section('title', $page_title)
@section('content')
<div class="page-body">
   <div class="container-fluid">
      <div class="page-title">
         <div class="row">
            <div class="col-sm-6 col-12">
            </div>
            <div class="col-sm-6 col-12">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"> <i class="fa-solid fa-home me-2"></i></a></li>
                  <li class="breadcrumb-item"><a href="{{ route('admin.vendor.list') }}">Vendors</a></li>
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
               <!-- Card Header -->
               <div class="card-header bg-light border-bottom-0 py-3 d-flex justify-content-between align-items-center rounded-top">
                  <h3 class="mb-0 fw-bold text-primary">
                     {{ $page_title }}
                  </h3>
                  <div class="d-flex gap-2">
                     <a href="{{ route('admin.vendor-category.add') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-plus"></i> Add Vendor Category
                     </a>
                     <a href="{{ route('admin.vendor.list') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-users"></i> Vendor List
                     </a>
                  </div>
               </div>
               <!-- Divider -->
               <div class="border-top"></div>
               <!-- Card Body -->
               <div class="card-body p-4 pt-0">
                  <div class="table-responsive mt-2">
                     <table class="table table-striped table-bordered align-middle mb-0" id="myTable">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Category Name</th>
                              <th>Vendors Count</th>
                              <th>Status</th>
                              <th>Created At</th>
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
<script type="text/javascript">
   $(document).ready(function() {
       var table = $('#myTable').DataTable({
           processing: true,
           serverSide: true,
           ajax: {
               url: "{{ route('admin.vendor-category.getRecords') }}",
               type: "POST",
               data: function(d) {
                   d._token = "{{ csrf_token() }}";
               }
           },
           columns: [
               { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
               { data: 'name', name: 'name' },
               { data: 'vendors_count', name: 'vendors_count', orderable: false, searchable: false },
               { data: 'status', name: 'status', orderable: false, searchable: false },
               { data: 'created_at', name: 'created_at' },
               { data: 'action', name: 'action', orderable: false, searchable: false },
           ]
       });

       $(document).on('change', '.toggleStatus', function() {
           var id = $(this).data('id');
           var status = $(this).is(':checked') ? 'Active' : 'Inactive';
           var checkbox = $(this);

           $.ajax({
               url: "{{ route('admin.vendor-category.changeStatus') }}",
               type: "POST",
               data: {
                   _token: "{{ csrf_token() }}",
                   id: id,
                   status: status
               },
               success: function(response) {
                   if(response.status) {
                       toastr.success(response.message);
                       table.ajax.reload(null, false);
                   } else {
                       toastr.error(response.message);
                       checkbox.prop('checked', !checkbox.is(':checked'));
                   }
               },
               error: function() {
                   toastr.error('Something went wrong!');
                   checkbox.prop('checked', !checkbox.is(':checked'));
               }
           });
       });
   });

   function deleteData(id) {
       Swal.fire({
           title: 'Are you sure?',
           text: "You won't be able to revert this!",
           icon: 'warning',
           showCancelButton: true,
           confirmColor: '#3085d6',
           cancelColor: '#d33',
           confirmButtonText: 'Yes, delete it!'
       }).then((result) => {
           if (result.isConfirmed) {
               $.ajax({
                   url: "{{ route('admin.vendor-category.delete') }}",
                   type: "POST",
                   data: {
                       _token: "{{ csrf_token() }}",
                       id: id
                   },
                   success: function(response) {
                       if (response.status) {
                           toastr.success(response.message);
                           $('#myTable').DataTable().ajax.reload(null, false);
                       } else {
                           toastr.error(response.message);
                       }
                   },
                   error: function() {
                       toastr.error('Something went wrong!');
                   }
               });
           }
       });
   }
</script>
@endpush
