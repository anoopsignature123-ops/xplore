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
                  <div class="d-flex gap-2">
                     <button class="btn btn-outline-secondary btn-sm"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#filterSection">
                     <i class="fas fa-filter"></i> Filters
                     </button> 
                  </div>
               </div>
               <!-- Divider -->
               <div class="border-top"></div>
               <!-- Filters -->
               <div class="collapse mb-3" id="filterSection">
                  <div class="card border-0 shadow-sm">
                     <div class="card-body bg-light">
                        <div class="row g-3 align-items-end">
                           
                           <!-- Contact Type -->
                           <div class="col-12 col-md-3">
                              <label class="form-label text-dark fw-semibold mb-1">Contact Type</label>
                              <select class="form-select select2" id="filter_contact_type_id">
                                 <option value="">All Contact Types</option>
                                 @foreach($contactTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                 @endforeach
                              </select>
                           </div>

                           <!-- Status -->
                           <div class="col-12 col-md-3">
                              <label class="form-label text-dark fw-semibold mb-1">Status</label>
                              <select class="form-select select2" id="filter_status">
                                 <option value="">All Statuses</option>
                                 <option value="Pending">Pending</option>
                                 <option value="In-Progress">In-Progress</option>
                                 <option value="Resolved">Resolved</option>
                                 <option value="Closed">Closed</option>
                              </select>
                           </div>

                           <!-- From Date -->
                           <div class="col-12 col-md-2">
                              <label class="form-label text-dark fw-semibold mb-1">From Date</label>
                              <input type="text" placeholder="Select Date" class="form-control datePicker" id="filter_from_date">
                           </div>

                           <!-- To Date -->
                           <div class="col-12 col-md-2">
                              <label class="form-label text-dark fw-semibold mb-1">To Date</label>
                              <input type="text" placeholder="Select Date" class="form-control datePicker" id="filter_to_date">
                           </div>

                           <!-- Buttons -->
                           <div class="col-12 col-md-2">
                              <div class="d-flex gap-2">
                                 <button type="button" class="btn btn-primary btn-sm w-100" id="btnFilter">
                                    <i class="fas fa-search me-1"></i> Filter
                                 </button>
                                 <button type="button" class="btn btn-outline-secondary btn-sm w-100" id="btnResetFilter">
                                    <i class="fas fa-redo-alt me-1"></i> Reset
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
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Customer Info</th>
                              <th>Type</th>
                              <th>Title</th>
                              <th>Message</th>
                              <th>Admin Reply</th>
                              <th>Status</th>
                              <th>Date</th>
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

<!-- Modal for View & Reply -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="replyModalLabel"><i class="fas fa-envelope-open-text me-2"></i>Contact Query Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="replyForm">
        @csrf
        <input type="hidden" id="query_id" name="id">
        <div class="modal-body">
            <div class="row g-3">
               <div class="col-md-6">
                  <label class="fw-bold text-muted small">Customer Name:</label>
                  <div class="fw-bold text-dark fs-6" id="modal_name"></div>
               </div>
               <div class="col-md-6">
                  <label class="fw-bold text-muted small">Contact Type:</label>
                  <div class="fw-semibold text-primary" id="modal_type"></div>
               </div>
               <div class="col-12">
                  <label class="fw-bold text-muted small">Title / Subject:</label>
                  <div class="fw-bold text-dark border p-2 rounded bg-light" id="modal_title"></div>
               </div>
               <div class="col-12">
                  <label class="fw-bold text-muted small">Customer Message:</label>
                  <div class="p-3 border rounded bg-white text-dark" id="modal_message" style="white-space: pre-wrap; max-height: 150px; overflow-y: auto;"></div>
               </div>
               <hr>
               <div class="col-md-6">
                  <label for="modal_status" class="form-label fw-bold">Update Status <span class="text-danger">*</span></label>
                  <select class="form-select" id="modal_status" name="status" required>
                     <option value="Pending">Pending</option>
                     <option value="In-Progress">In-Progress</option>
                     <option value="Resolved">Resolved</option>
                     <option value="Closed">Closed</option>
                  </select>
               </div>
               <div class="col-12">
                  <label for="modal_reply" class="form-label fw-bold">Admin Reply / Note</label>
                  <textarea class="form-control" id="modal_reply" name="reply" rows="4" placeholder="Enter reply message for customer..."></textarea>
               </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btnSaveReply">Save Response</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
   $(document).ready(function() {
       if ($.fn.select2) {
           $('.select2').select2({ width: '100%' });
       }

       var table = $('#myTable').DataTable({
           processing: true,
           serverSide: true,
           ajax: {
               url: "{{ route('admin.contact-us.getRecords') }}",
               type: "POST",
               data: function(d) {
                   d._token = "{{ csrf_token() }}";
                   d.contact_type_id = $('#filter_contact_type_id').val();
                   d.status = $('#filter_status').val();
                   d.from_date = $('#filter_from_date').val();
                   d.to_date = $('#filter_to_date').val();
               }
           },
           columns: [
               { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
               { data: 'user_info', name: 'user_info', orderable: false },
               { data: 'contact_type_name', name: 'contact_type_name' },
               { data: 'title', name: 'title' },
               { data: 'message', name: 'message' },
               { data: 'reply', name: 'reply' },
               { data: 'status', name: 'status' },
               { data: 'created_at', name: 'created_at' },
               { data: 'action', name: 'action', orderable: false, searchable: false },
           ]
       });

       $('#btnFilter').click(function() {
           table.draw();
       });

       $('#btnResetFilter').click(function() {
           $('#filter_contact_type_id').val('').trigger('change');
           $('#filter_status').val('').trigger('change');
           $('#filter_from_date').val('');
           $('#filter_to_date').val('');
           table.draw();
       });

       // Open Reply Modal
       $(document).on('click', '.btn-view-reply', function() {
           var id = $(this).data('id');
           var name = $(this).data('name');
           var type = $(this).data('type');
           var title = $(this).data('title');
           var message = $(this).data('message');
           var reply = $(this).data('reply');
           var status = $(this).data('status');

           $('#query_id').val(id);
           $('#modal_name').text(name);
           $('#modal_type').text(type);
           $('#modal_title').text(title);
           $('#modal_message').text(message);
           $('#modal_reply').val(reply);
           $('#modal_status').val(status);

           $('#replyModal').modal('show');
       });

       // Submit Reply
       $('#replyForm').on('submit', function(e) {
           e.preventDefault();
           $('#btnSaveReply').prop('disabled', true).text('Saving...');

           $.ajax({
               url: "{{ route('admin.contact-us.updateReplyStatus') }}",
               type: "POST",
               data: $(this).serialize(),
               success: function(response) {
                   $('#btnSaveReply').prop('disabled', false).text('Save Response');
                   if(response.status) {
                       toastr.success(response.message);
                       $('#replyModal').modal('hide');
                       table.ajax.reload(null, false);
                   } else {
                       toastr.error(response.message);
                   }
               },
               error: function(xhr) {
                   $('#btnSaveReply').prop('disabled', false).text('Save Response');
                   toastr.error('Failed to update query response.');
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
                   url: "{{ route('admin.contact-us.delete') }}",
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
