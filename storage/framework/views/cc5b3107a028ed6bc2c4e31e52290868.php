
<?php $__env->startSection('title', $page_title); ?>
<?php $__env->startSection('content'); ?>
<div class="page-body">
   <div class="container-fluid">
      <div class="page-title">
         <div class="row">
            <div class="col-sm-6 col-12">
            </div>
            <div class="col-sm-6 col-12">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo e(route('admin.index')); ?>"> <i class="fa-solid fa-home me-2"></i></a></li>
                  <li class="breadcrumb-item"><?php echo e($page_title); ?></li>
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
                     <?php echo e($page_title); ?>

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
                           <!-- Role -->
                               <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">
                              Customer
                              </label>
                              <select class="form-select  select2" id="filter_customer">
                                 <option value="">All Customers</option>
                                    <?php if(!empty($customer_list) && $customer_list->count() > 0): ?>
                                        <?php $__currentLoopData = $customer_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value->id); ?>" <?php echo e((isset($user_id) && $user_id == $value->id) ? 'selected' : ''); ?>> 
                                                <?php echo e(!empty($value->name) ? $value->name : 'N/A'); ?> -
                                                <?php echo e(!empty($value->phone_no) ? $value->phone_no : 'N/A'); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                              </select>
                              <input type="hidden" id="filter_id" value="<?php echo e($id ?? ''); ?>">
                           </div>

                           <!-- Status -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">
                              Status
                              </label>
                              <select class="form-select  select2" id="filter_status">
                                 <option value="">Select Status</option>
                                 <option value="Pending">Pending</option> 
                                 <option value="Ongoing">Ongoing</option>
                                 <option value="Completed">Completed</option>
                                 <option value="Cancelled">Cancelled</option>
                              </select>
                           </div>
                           
                           <!-- Payment Status -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">
                              Payment Status
                              </label>
                              <select class="form-select select2" id="filter_payment_status">
                                 <option value="">Select Status</option>
                                 <option value="pending">Pending</option>
                                 <option value="success">Success</option>
                                 <option value="failed">Failed</option>
                              </select>
                           </div>
                           <!-- Survey Name -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">Survey</label>
                              <select class="form-select select2" id="filter_survey_id">
                                 <option value="">Selecy Survey</option>
                                 <?php if(!empty($survey_list) && $survey_list->count() > 0): ?>
                                     <?php $__currentLoopData = $survey_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <option value="<?php echo e($value->id); ?>"> 
                                             <?php echo e(!empty($value->name) ? $value->name : 'N/A'); ?>

                                         </option>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <?php endif; ?>
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

                           <!-- Latitude -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">Latitude</label>
                              <input type="text" class="form-control" id="filter_latitude" placeholder="Enter Latitude">
                           </div>

                           <!-- Longitude -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">Longitude</label>
                              <input type="text" class="form-control" id="filter_longitude" placeholder="Enter Longitude">
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

<!-- Assign Vendor Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignModalLabel">Assign Vendor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="assignDetails" class="mb-3">
                    <!-- Details will be injected here via JS -->
                </div>
                
                <input type="hidden" id="assign_survey_id">
                
                <div class="form-group">
                    <label class="form-label text-dark fw-semibold mb-1">Select Vendor</label>
                    <select class="form-select select2 w-100" id="assign_vendor_id" style="width: 100%;">
                        <option value="">Choose Vendor</option>
                        <?php if(!empty($vendor_list) && $vendor_list->count() > 0): ?>
                            <?php $__currentLoopData = $vendor_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($v->id); ?>"><?php echo e(!empty($v->name) ? $v->name : 'N/A'); ?> | <?php echo e(!empty($v->email_id) ? $v->email_id : 'N/A'); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="assignVendorBtn">Assign Vendor</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
   $(document).ready(function() {
       // Initialize Flatpickr for date filters
       var toDatePicker = flatpickr("#filter_to_date", {
           dateFormat: "Y-m-d",   
           altInput: true,   
           altFormat: "d-m-Y",    
           allowInput: false,
       });

       var fromDatePicker = flatpickr("#filter_from_date", {
           dateFormat: "Y-m-d",   
           altInput: true,   
           altFormat: "d-m-Y",    
           allowInput: false,
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
               url: "<?php echo e(route('admin.customer-survey.getRecords')); ?>",
               data: function (d) {
                    d.customer_id = $('#filter_customer').val();
                    d.id = $('#filter_id').val();
                    d.status = $('#filter_status').val();
                    d.payment_status = $('#filter_payment_status').val();
                    d.survey_id = $('#filter_survey_id').val();
                    d.from_date = $('#filter_from_date').val();
                    d.to_date = $('#filter_to_date').val();
                    d.latitude = $('#filter_latitude').val();
                    d.longitude = $('#filter_longitude').val();
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
               { data: 'payment_status', name: 'payment_status', title: 'Payment Status' },
               { data: 'status', name: 'status', title: 'Status' },
               { data: 'action', name: 'action', title: 'Action', orderable: false, searchable: false }
           ]
       });
    
       $('#btnFilter').on('click', function() {
           table.ajax.reload();
       });

       $('#btnResetFilter').on('click', function() {
           $('#filter_customer').val('').trigger('change');
           $('#filter_id').val('');
           $('#filter_status').val('').trigger('change');
           $('#filter_payment_status').val('').trigger('change');
           $('#filter_survey_id').val('').trigger('change');
           fromDatePicker.clear();
           toDatePicker.clear();
           $('#filter_latitude').val('');
           $('#filter_longitude').val('');
           window.history.pushState({}, document.title, window.location.pathname);
           table.ajax.reload();
       });

       // Open Assign Modal
       $(document).on('click', '.btn-assign', function() {
           var id = $(this).data('id');
           $('#assign_survey_id').val(id);

           var details = `
               <ul class="list-group list-group-flush">
                   <li class="list-group-item"><strong>Customer:</strong> ${$(this).data('cname')} | ${$(this).data('cphone')}</li>
                   <li class="list-group-item"><strong>Survey Name:</strong> ${$(this).data('sname')}</li>
                   <li class="list-group-item"><strong>Amount:</strong> <i class="fa-solid fa-indian-rupee-sign"></i> ${$(this).data('amt')}</li>
                   <li class="list-group-item"><strong>Date & Time:</strong> ${$(this).data('sdate')} at ${$(this).data('stime')}</li>
                   <li class="list-group-item"><strong>Address:</strong> ${$(this).data('addr')}</li>
                   <li class="list-group-item"><strong>Latitude:</strong> ${$(this).data('lat')}</li>
                   <li class="list-group-item"><strong>Longitude:</strong> ${$(this).data('lng')}</li> 
               </ul>
           `;
           $('#assignDetails').html(details);
           
           $('#assign_vendor_id').val('').trigger('change');

           $('#assignModal').modal('show');
       });

       // Assign Vendor Submit
       $('#assignVendorBtn').on('click', function() {
           var id = $('#assign_survey_id').val();
           var vendor_id = $('#assign_vendor_id').val();

           if (!vendor_id) {
               toastr.error('Please select a vendor');
               return;
           }

           Swal.fire({
               title: 'Are you sure?',
               text: "Do you want to assign this vendor?",
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Yes, Assign Vendor!'
           }).then((result) => {
               if (result.isConfirmed) {
                   $.ajax({
                       url: "<?php echo e(route('admin.customer-survey.assignVendor')); ?>",
                       type: "POST",
                       data: {
                           id: id,
                           vendor_id: vendor_id,
                           _token: '<?php echo e(csrf_token()); ?>'
                       },
                       beforeSend: function() {
                           $('#assignVendorBtn').prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Assigning...');
                       },
                       success: function(response) {
                           if (response.status) {
                               toastr.success(response.message);
                               $('#assignModal').modal('hide');
                               table.ajax.reload(null, false); // reload without resetting pagination
                           } else {
                               toastr.error(response.message || 'Something went wrong');
                           }
                       },
                       error: function(xhr) {
                           if (xhr.status === 422) {
                               $.each(xhr.responseJSON.errors, function(key, value) { toastr.error(value[0]); });
                           } else {
                               toastr.error('An error occurred while assigning vendor');
                           }
                       },
                       complete: function() {
                           $('#assignVendorBtn').prop('disabled', false).html('Assign Vendor');
                       }
                   });
               }
           });
       });
   });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.includes.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\xplore-22-09-26\resources\views/admin/customer-survey/list.blade.php ENDPATH**/ ?>