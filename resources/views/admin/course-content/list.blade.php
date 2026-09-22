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

            <!-- Summary Card -->
            <div class="card shadow-sm border-0 rounded-3 mb-3">
               <div class="card-body py-3">

                  <div class="row g-3">
                        <!-- Course -->
                        <div class="col-12 col-md-4">
                           <div class="p-2 rounded bg-light h-100">
                              <small class="text-muted d-block mb-1">Course Name</small>
                              <div class="fw-semibold text-dark fs-6">
                                    {{ $topic_record->lesson->course->course_name ?? '-' }}
                              </div>
                           </div>
                        </div>

                        <!-- Lesson -->
                        <div class="col-12 col-md-4">
                           <div class="p-2 rounded bg-light h-100">
                              <small class="text-muted d-block mb-1">Lesson Name</small>
                              <div class="fw-semibold text-dark fs-6">
                                    {{ $topic_record->lesson->lesson_name ?? '-' }}
                              </div>
                           </div>
                        </div>
 
                         <!-- Topic -->
                        <div class="col-12 col-md-4">
                           <div class="p-2 rounded bg-light h-100">
                              <small class="text-muted d-block mb-1">Topic Name</small>
                              <div class="fw-semibold text-dark fs-6">
                                    {{ $topic_record->topic_name ?? '-' }}
                              </div>
                           </div>
                        </div>

                  </div>

               </div>
            </div>
            <div class="card shadow-lg border-0 rounded-3">
               <!-- Card Header -->
               <div class="card-header bg-light border-bottom-0 py-3 d-flex justify-content-between align-items-center rounded-top">
                  <h3 class="mb-0 fw-bold text-primary">
                     {{ $page_title }}
                  </h3>
                  <div class="d-flex gap-2">
                     <button class="btn btn-outline-secondary btn-sm"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#filterSection">
                     <i class="fas fa-filter"></i> Filters
                     </button>  
                     @can('course-content-add')
                        <a href="{{ route('admin.course-content.add', $topic_id) }}" class="btn btn-outline-primary btn-sm">
                           <i class="fas fa-plus"></i> Add
                        </a>
                     @endcan 
                  </div>
               </div>
               <!-- Divider -->
               <div class="border-top"></div>
               <!-- Filters --> 
               <div class="collapse mb-3" id="filterSection">
                  <div class="card border-0 shadow-sm">
                     <div class="card-body bg-light">
                        <div class="row g-3 align-items-end">
                           <!-- Role -->
                           <!-- Status -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">
                              Status
                              </label>
                              <select class="form-select  select2" id="filter_status">
                                 <option value="">Select Status</option>
                                 <option value="Active">Active</option>
                                 <option value="Inactive">Inactive</option>
                              </select>
                           </div>
                           <!-- Buttons -->
                           <div class="col-12 col-lg-6">
                              <div class="d-flex flex-column flex-sm-row gap-2 justify-content-lg-start">
                                 <button type="button"
                                    class="btn btn-primary btn-sm"
                                    id="btnFilter">
                                 <i class="fas fa-search me-1"></i>
                                 Apply Filter
                                 </button>
                                 <button type="button"
                                    class="btn btn-outline-secondary btn-sm"
                                    id="btnResetFilter">
                                 <i class="fas fa-redo-alt me-1"></i>
                                 Reset
                                 </button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Card Body -->
               <div class="card-body p-4 pt-0">
                  <div class="table-responsive mt-2">
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
               url: "{{ route('admin.course-content.getRecords') }}",
               data: function (d) {
                   d.status = $('#filter_status').val();
                   d.topic_id = "{{ $topic_id }}";
               }
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
               { data: 'name', name: 'name', title: 'Content Name' }, 
               { data: 'type', name: 'type', title: 'Content Type' }, 
               { data: 'content_link', name: 'content_link', title: 'Content Link' }, 
               { data: 'priority', name: 'priority', title: 'Priority' },
               { data: 'status', name: 'status', title: 'Status' },
               { data: 'action', name: 'action', title: 'Action' }
           ]
       });
    
       $('#btnFilter').on('click', function() {
           table.ajax.reload();
       });
   
       $('#btnResetFilter').on('click', function() {
           $('#filter_status').val('');
           table.ajax.reload();
       });
   });
</script>
<script>
   // Status toggle event (AJAX)
   $('#myTable').on('change', '.toggleStatus', function() {
      var checkbox = $(this);
      var id = checkbox.data('id');
      var status = checkbox.is(':checked') ? 'Active' : 'Inactive';
   
      $.ajax({
          url: "{{ route('admin.course-content.changeStatus') }}",
          type: "POST",
          data: {
              _token: "{{ csrf_token() }}",
              id: id,
              status: status
          },
          success: function(response) {
              if (response.status) {
                  // Update label text
                  var container = checkbox.closest('.d-flex');
                  container.find('.status-label').text(status);
   
                  // Update switch color
                  var switchState = container.find('.switch-state');
                  if (status === 'Active') {
                      switchState.removeClass('bg-danger').addClass('bg-success');
                  } else {
                      switchState.removeClass('bg-success').addClass('bg-danger');
                  }
   
                  toastr.success(response.message);
              } else {
                  toastr.error(response.message);
                  // rollback toggle if failed
                  checkbox.prop('checked', !checkbox.is(':checked'));
              }
          },
          error: function() {
              toastr.error('Something went wrong.');
              // rollback toggle if error
              checkbox.prop('checked', !checkbox.is(':checked'));
          }
      });
   });
   
   function deleteData(id) {
   confirmDelete(function() {
       $.ajax({
           url: "{{ route('admin.course-content.delete') }}",
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