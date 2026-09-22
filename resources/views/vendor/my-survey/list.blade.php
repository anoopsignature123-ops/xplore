@extends('vendor.includes.layout')
@section('content')
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
   /* Custom Select2 Height */
   .select2-container .select2-selection--single {
       height: 38px !important; 
   }
   .select2-container--default .select2-selection--single .select2-selection__rendered {
       line-height: 38px !important;
   }
   .select2-container--default .select2-selection--single .select2-selection__arrow {
       height: 36px !important;
   }
</style>
@endpush
<div class="page-body">
   <div class="container-fluid">
      <div class="page-title">
         <div class="row">
            <div class="col-sm-6 col-12">
            </div>
            <div class="col-sm-6 col-12">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('vendor.index') }}"> <i class="fa-solid fa-home me-2"></i></a></li>
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

                           <!-- Customer Filter -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">Customer</label>
                              <select class="form-select select2" id="filter_customer_id">
                                 <option value="">All Customers</option>
                                 @foreach($customers as $cust)
                                    <option value="{{ $cust->id }}">{{ $cust->name }} | {{ $cust->phone_no }}</option>
                                 @endforeach
                              </select>
                           </div>

                           <!-- Survey Name Filter -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">Survey Name</label>
                              <select class="form-select select2" id="filter_survey_name">
                                 <option value="">All Surveys</option>
                                 @foreach($surveys as $surv)
                                    <option value="{{ $surv }}">{{ $surv }}</option>
                                 @endforeach
                              </select>
                           </div>

                           <!-- Status Filter -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">Status</label>
                              <select class="form-select select2" id="filter_status">
                                 <option value="">All Statuses</option>
                                 @foreach($statuses as $stat)
                                    <option value="{{ $stat }}" {{ $status_filter == $stat ? 'selected' : '' }}>{{ $stat }}</option>
                                 @endforeach
                              </select>
                           </div>

                           <!-- From Date -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">From Date</label>
                              <input type="text" class="form-control" id="filter_from_date" placeholder="Select From Date">
                           </div>
                           
                           <!-- To Date -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">To Date</label>
                              <input type="text" class="form-control" id="filter_to_date" placeholder="Select To Date">
                           </div>

                           <!-- Buttons -->
                           <div class="col-12 col-lg-3">
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
   $(document).ready(function() {
       // Initialize Select2
       $('.select2').select2({ width: '100%' });

       // If filters are passed from dashboard, auto-expand filters
       @if($status_filter || $date_filter == 'today')
           $('#filterSection').collapse('show');
       @endif
 
       @php
           $todayDate = \Carbon\Carbon::today()->format('Y-m-d');
       @endphp

       // Initialize Flatpickr for date filters
       var toDatePicker = flatpickr("#filter_to_date", {
           dateFormat: "Y-m-d",   
           altInput: true,   
           altFormat: "d-m-Y",    
           allowInput: false,
           defaultDate: "{{ $date_filter == 'today' ? $todayDate : '' }}"
       });

       var fromDatePicker = flatpickr("#filter_from_date", {
           dateFormat: "Y-m-d",   
           altInput: true,   
           altFormat: "d-m-Y",    
           allowInput: false,
           defaultDate: "{{ $date_filter == 'today' ? $todayDate : '' }}",
           onChange: function(selectedDates, dateStr, instance) {
               if (dateStr) {
                   toDatePicker.setDate(dateStr);
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
               url: "{{ route('vendor.my-survey.getRecords') }}",
               data: function (d) {
                    d.from_date = $('#filter_from_date').val();
                    d.to_date = $('#filter_to_date').val();
                    d.customer_id = $('#filter_customer_id').val();
                    d.survey_name = $('#filter_survey_name').val();
                    d.status = $('#filter_status').val();
               }
           }, 
           columns: [
               {
                   data: null,
                   title: 'Sr. No.',
                   orderable: false,
                   searchable: false,
                   render: function (data, type, row, meta) {
                       return meta.row + meta.settings._iDisplayStart + 1;
                   }
               },
               { data: 'customer_details', name: 'customer.name', title: 'Customer Details' },
               { data: 'survey_details', name: 'survey_name', title: 'Survey Details' },
               { data: 'amount', name: 'amount', title: 'Amount' },
               { data: 'location_details', name: 'address', title: 'Location Details' },
               { data: 'status', name: 'status', title: 'Status' },
               { data: 'assigned_date', name: 'assigned_at', title: 'Assigned At' },
               { data: 'action', name: 'action', title: 'Action', orderable: false, searchable: false }
           ]
       });
    
       $('#btnFilter').on('click', function() {
           table.ajax.reload();
       });

       $('#btnResetFilter').on('click', function() {
           fromDatePicker.clear();
           toDatePicker.clear();
           $('#filter_customer_id').val('').trigger('change');
           $('#filter_survey_name').val('').trigger('change');
           $('#filter_status').val('').trigger('change');
           table.ajax.reload();
       });
   });
</script>
@endpush
