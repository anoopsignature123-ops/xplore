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
                       @can('vendor-add')
                     <a href="{{ route('admin.vendor.add') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add Vendor
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
                           <!-- Name -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">Name</label>
                              <input type="text" class="form-control" id="filter_name" placeholder="Search by Name">
                           </div>
                           
                           <!-- Phone No -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">Phone No</label>
                              <input type="text" class="form-control" id="filter_phone" placeholder="Search by Phone">
                           </div>

                           <!-- Vendor Type -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">Vendor Type</label>
                              <select class="form-select select2" id="filter_vendor_type">
                                 <option value="">All Types</option>
                                 <option value="survey">Survey</option>
                                 <option value="product">Product</option>
                                 <option value="rental_product">Rental Product</option>
                                 <option value="course">Course</option>
                              </select>
                           </div>

                           <!-- Gender -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">Gender</label>
                              <select class="form-select select2" id="filter_gender">
                                 <option value="">All Genders</option>
                                 <option value="Male">Male</option>
                                 <option value="Female">Female</option>
                                 <option value="Other">Other</option>
                              </select>
                           </div>

                           <!-- Status -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">Status</label>
                              <select class="form-select select2" id="filter_status">
                                 <option value="">All Statuses</option>
                                 <option value="Pending">Pending</option>
                                 <option value="Active">Active</option>
                                 <option value="Inactive">Inactive</option> 
                                 <option value="Blocked">Blocked</option>
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
                           <div class="col-12 col-md-6 col-lg-3">
                               <label class="form-label d-none d-lg-block">&nbsp;</label>
                               <div>
                                   <button type="button" class="btn btn-primary btn-sm me-1" id="btnFilter"> <i class="fas fa-search"></i> Search</button>
                                   <button type="button" class="btn btn-outline-secondary btn-sm" id="btnResetFilter"> <i class="fas fa-redo-alt"></i> Reset</button>
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
       let toDatePicker = flatpickr("#filter_to_date", {
           dateFormat: "Y-m-d",
       });

       let fromDatePicker = flatpickr("#filter_from_date", {
           dateFormat: "Y-m-d",
           onChange: function(selectedDates, dateStr, instance) {
               toDatePicker.set('minDate', dateStr);
               toDatePicker.setDate(dateStr);
           }
       });

       var table = $('#myTable').DataTable({
           processing: true,
           serverSide: true,
           responsive: true,
           ordering: false,
           searching: true,
           ajax: {
               url: "{{ route('admin.vendor.getRecords') }}",
               data: function (d) {
                   d.status = $('#filter_status').val();
                   d.name = $('#filter_name').val();
                   d.phone_no = $('#filter_phone').val();
                   d.vendor_type = $('#filter_vendor_type').val();
                   d.gender = $('#filter_gender').val();
                   d.from_date = $('#filter_from_date').val();
                   d.to_date = $('#filter_to_date').val();
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
    { data: 'vendor_type', name: 'vendor_type', title: 'Vendor Type' },
    { data: 'profile_image', name: 'profile_image', title: 'Profile Image' },
    { data: 'name', name: 'name', title: 'Name' },
    { data: 'phone_no', name: 'phone_no', title: 'Phone No.' },
    { data: 'email_id', name: 'email_id', title: 'Email ID' },
    { data: 'raw_password', name: 'raw_password', title: 'Password' },
    { data: 'gender', name: 'gender', title: 'Gender' },
    { data: 'status', name: 'status', title: 'Status' },
    { data: 'created_at', name: 'created_at', title: 'Registered On' },
    { data: 'action', name: 'action', title: 'Action', orderable: false, searchable: false }
]
       });
    
       $('#btnFilter').on('click', function() {
           table.ajax.reload();
       });
   
       $('#btnResetFilter').on('click', function() {
           $('#filter_status').val('');
           $('#filter_name').val('');
           $('#filter_phone').val('');
           $('#filter_vendor_type').val('');
           $('#filter_gender').val('');
           
           // Clear flatpickr date inputs
           $('#filter_from_date').val('');
           if ($('#filter_from_date')[0]._flatpickr) {
               $('#filter_from_date')[0]._flatpickr.clear();
           }
           
           $('#filter_to_date').val('');
           if ($('#filter_to_date')[0]._flatpickr) {
               $('#filter_to_date')[0]._flatpickr.clear();
           }
           
           // If using select2, re-trigger change so it visually updates
           $('.select2').val('').trigger('change');
           
           table.ajax.reload();
       });
   });


   function deleteData(id) {
confirmDelete(function() {
    $.ajax({
        url: "{{ route('admin.vendor.delete') }}",
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
