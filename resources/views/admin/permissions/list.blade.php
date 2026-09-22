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
                  <div>
                     <a href="{{ route('admin.permissions.add') }}" class="btn btn-sm btn-sm btn-outline-primary">
                     <i class="fas fa-plus"></i> Add
                     </a>
                  </div>
               </div>
               <!-- Divider -->
               <div class="border-top"></div>
              
               <!-- Card Body -->
               <div class="card-body p-4">
                  <div class="table-responsive">
                     <table class="table table-striped table-bordered align-middle mb-0" id="myTable">
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
        responsive: true,
         ordering: false,
            searching: true,

        ajax: {
            url: "{{ route('admin.permissions.getRecords') }}",
        },
        columns: [
            {
                data: null,
                title: 'Sr.No.',
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            }, 
            { data: 'name', name: 'name', title: 'Permission Name' },
            { data: 'action', name: 'action', title: 'Action' }
        ]
    });
});
</script>

<script>
   function deleteData(id) {
       confirmDelete(function() {
           $.ajax({
               url: "{{ route('admin.permissions.delete') }}",
               type: "POST",
               data: {
                   id: id,
                   _token: "{{ csrf_token() }}"
               },
               success: function(response) {
                   if (response.status) {
                       showToast('success', response.message);
                       $('#myTable').DataTable().ajax.reload(null, false);
                   } else {
                       showToast('error', response.message);
                   }
               },
               error: function() {
                   showToast('error', "Something went wrong!");
               }
           });
       });
   }
</script>
@endpush
