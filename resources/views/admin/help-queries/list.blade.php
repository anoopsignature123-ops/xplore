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
                           
                           <!-- Customer -->
                           <div class="col-12 col-md-4 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">
                              Customer
                              </label>
                              <select class="form-select select2" id="filter_customer_id">
                                 <option value="">Select Customer</option>
                                 @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }} | {{ $customer->phone_no }}</option>
                                 @endforeach
                              </select>
                           </div>

                           <!-- From Date -->
                           <div class="col-12 col-md-4 col-lg-2">
                              <label class="form-label text-dark fw-semibold mb-1">
                              From Date
                              </label>
                              <input type="text" placeholder="Select Date" class="form-control datePicker" id="filter_from_date">
                           </div>

                           <!-- To Date -->
                           <div class="col-12 col-md-4 col-lg-2">
                              <label class="form-label text-dark fw-semibold mb-1">
                              To Date
                              </label>
                              <input type="text"  placeholder="Select Date" class="form-control datePicker" id="filter_to_date">
                           </div>

                           <!-- Buttons -->
                           <div class="col-12 col-lg-5">
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
       // Initialize Select2
       if ($.fn.select2) {
           $('.select2').select2({
               width: '100%'
           });
       }

       // Initialize Flatpickr
       var toPicker = flatpickr("#filter_to_date", {
           dateFormat: "Y-m-d",   
           altInput: true,   
           altFormat: "d-m-Y",    
           allowInput: false,
       });

       var fromPicker = flatpickr("#filter_from_date", {
           dateFormat: "Y-m-d",   
           altInput: true,   
           altFormat: "d-m-Y",    
           allowInput: false,
           onChange: function(selectedDates, dateStr, instance) {
               if (selectedDates.length > 0) {
                   toPicker.set('minDate', selectedDates[0]);
                   toPicker.setDate(selectedDates[0]);
               }
           }
       });

       var table = $('#myTable').DataTable({
           processing: true,
           serverSide: true,
           responsive: true,
           ordering: false,
           searching: true,
           ajax: {
               url: "{{ route('admin.help-query.getRecords') }}",
               data: function (d) {
                   d.customer_id = $('#filter_customer_id').val();
                   d.from_date = $('#filter_from_date').val();
                   d.to_date = $('#filter_to_date').val();
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
               { data: 'customer_info', name: 'customer_info', title: 'Customer Info' }, 
               { data: 'question', name: 'question', title: 'Question' }, 
               { data: 'message', name: 'message', title: 'Message' }, 
               { data: 'remark', name: 'remark', title: 'Remark' },
               { data: 'created_at', name: 'created_at', title: 'Date' },
               { data: 'action', name: 'action', title: 'Action' }
           ]
       });
    
       $('#btnFilter').on('click', function() {
           table.ajax.reload();
       });
   
       $('#btnResetFilter').on('click', function() {
           $('#filter_customer_id').val('').trigger('change');
           fromPicker.clear();
           toPicker.clear();
           toPicker.set('minDate', null);
           table.ajax.reload();
       });

       // Open Review Modal
       $(document).on('click', '.btn-give-review', function() {
           var id = $(this).data('id');
           $('#review_help_query_id').val(id);
           $('#review_remark').val('');
           $('#reviewModal').modal('show');
       });

       // Submit Review
       $('#btnSaveReview').on('click', function() {
           var id = $('#review_help_query_id').val();
           var remark = $('#review_remark').val();

           if (!remark) {
               toastr.error('Please enter a remark');
               return;
           }

           $.ajax({
               url: "{{ route('admin.help-query.updateRemark') }}",
               type: "POST",
               data: {
                   _token: "{{ csrf_token() }}",
                   id: id,
                   remark: remark
               },
               success: function(response) {
                   if (response.status) {
                       $('#reviewModal').modal('hide');
                       toastr.success(response.message);
                       table.ajax.reload(null, false);
                   } else {
                       toastr.error(response.message);
                   }
               },
               error: function() {
                   toastr.error('Something went wrong!');
               }
           });
       });
   });
</script>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reviewModalLabel">Give Review / Remark</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="review_help_query_id">
        <div class="mb-3">
            <label class="form-label">Remark</label>
            <textarea class="form-control" id="review_remark" rows="4" placeholder="Enter your review here..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnSaveReview">Save Review</button>
      </div>
    </div>
  </div>
</div>
 
<script>
   function deleteData(id) {
       confirmDelete(function() {
           $.ajax({
               url: "{{ route('admin.help-query.delete') }}",
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
