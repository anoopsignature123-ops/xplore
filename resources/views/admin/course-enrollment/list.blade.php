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
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">
                              Customer
                              </label>
                              <select class="form-select select2" id="filter_customer">
                                 <option value="">Select Customer</option>
                                 @foreach($customers as $c)
                                 <option value="{{ $c->id }}" {{ (isset($user_id) && $user_id == $c->id) ? 'selected' : '' }}>{{ $c->name }} | {{ $c->phone_no }}</option>
                                 @endforeach
                              </select>
                              <input type="hidden" id="filter_id" value="{{ $id ?? '' }}">
                           </div>
                           
                         

                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">
                             Course Category Name
                              </label>
                              <select class="form-select select2" id="filter_course_category_name">
                                 <option value="">Select Category</option>
                                 @foreach($categories as $cat)
                                 <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                                 @endforeach
                              </select>
                           </div>

                             <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">
                              Course Name
                              </label>
                              <select class="form-select select2" id="filter_course_name">
                                 <option value="">Select Course</option>
                                 @foreach($courses as $course)
                                 <option value="{{ $course->course_name }}">{{ $course->course_name }}</option>
                                 @endforeach
                              </select>
                           </div>


                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">
                              Date From
                              </label>
                              <input type="text" class="form-control datePicker" id="filter_date_from" placeholder="Select Date From">
                           </div>

                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">
                              Date To
                              </label>
                              <input type="text" class="form-control datePicker" id="filter_date_to" placeholder="Select Date To">
                           </div>
                           
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">
                              Payment Status
                              </label>
                              <select class="form-select select2" id="filter_payment_status">
                                 <option value="">All Status</option>
                                 <option value="pending">Pending</option>
                                 <option value="success">Success</option>
                                 <option value="failed">Failed</option>
                              </select>
                           </div>

                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">
                              Status
                              </label>
                              <select class="form-select select2" id="filter_status">
                                 <option value="">All Status</option>
                                 <option value="pending">Pending</option>
                                 <option value="active">Active</option>
                                 <option value="completed">Completed</option>
                              </select>
                           </div>

                           <!-- Buttons -->
                           <div class="col-12 col-lg-12 mt-3">
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
               url: "{{ route('admin.course-enrollment.getRecords') }}",
               data: function (d) {
                   d.customer_id = $('#filter_customer').val();
                   d.id = $('#filter_id').val();
                   d.course_name = $('#filter_course_name').val();
                   d.course_category_name = $('#filter_course_category_name').val();
                   d.date_from = $('#filter_date_from').val();
                   d.date_to = $('#filter_date_to').val();
                   d.payment_status = $('#filter_payment_status').val();
                   d.status = $('#filter_status').val();
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
               { data: 'customer_details', name: 'customer_details', title: 'Customer' },
               { data: 'course_name', name: 'course_name', title: 'Course Name' }, 
               { data: 'course_category_name', name: 'course_category_name', title: 'Course Category' }, 
               { data: 'duration', name: 'duration', title: 'Duration' },
               { data: 'amount', name: 'amount', title: 'Amount' },
               { data: 'payment_status', name: 'payment_status', title: 'Payment Status' },
               { data: 'status', name: 'status', title: 'Status' },
               { data: 'created_at', name: 'created_at', title: 'Enrolled At' }
           ]
       });
    
       $('#btnFilter').on('click', function() {
           table.ajax.reload();
       });
   
       $('#btnResetFilter').on('click', function() {
           $('#filter_customer').val('').trigger('change');
           $('#filter_id').val('');
           $('#filter_course_name').val('').trigger('change');
           $('#filter_course_category_name').val('').trigger('change');
           $('#filter_payment_status').val('').trigger('change');
           $('#filter_status').val('').trigger('change');
           $('#filter_date_from').val('');
           $('#filter_date_to').val('');
           
           if (document.getElementById("filter_date_from") && document.getElementById("filter_date_from")._flatpickr) {
               document.getElementById("filter_date_from")._flatpickr.clear();
           }
           if (document.getElementById("filter_date_to") && document.getElementById("filter_date_to")._flatpickr) {
               document.getElementById("filter_date_to")._flatpickr.clear();
           }
           
           window.history.pushState({}, document.title, window.location.pathname);
           table.ajax.reload();
       });

       $('#filter_date_from').on('change', function() {
          let fromDate = $(this).val();
          if (fromDate) {
             let toPicker = document.getElementById("filter_date_to");
             if (toPicker && toPicker._flatpickr) {
                 toPicker._flatpickr.setDate(fromDate);
             } else {
                 $('#filter_date_to').val(fromDate);
             }
          }
       });
   });
</script>
@endpush
