<?php $__env->startSection('title', $page_title); ?>
<?php $__env->startSection('content'); ?>
<div class="page-body">
   <div class="container-fluid">
      <div class="page-title">
         <div class="row">
            <div class="col-sm-6 col-12"></div>
            <div class="col-sm-6 col-12">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo e(route('admin.index')); ?>"><i class="fa-solid fa-home me-2"></i></a></li>
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
               <div class="card-header bg-light border-bottom-0 py-3 d-flex justify-content-between align-items-center rounded-top">
                  <h3 class="mb-0 fw-bold text-primary"><?php echo e($page_title); ?></h3>
                  <div class="d-flex gap-2">
                     <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#filterSection">
                        <i class="fas fa-filter"></i> Filters
                     </button>
                  </div>
               </div>

               <div class="border-top"></div>

               <!-- Filters -->
               <div class="collapse mb-3" id="filterSection">
                  <div class="card border-0 shadow-sm">
                     <div class="card-body bg-light">
                        <div class="row g-3 align-items-end">
                           <div class="col-12 col-md-6 col-lg-4">
                              <label class="form-label text-dark fw-semibold mb-1">Customer</label>
                              <select class="form-select select2" id="filter_user_id">
                                 <option value="">All Customers</option>
                                 <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($customer->id); ?>"><?php echo e($customer->name); ?> (<?php echo e($customer->phone_no); ?>)</option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                           </div>
                           <div class="col-12 col-md-6 col-lg-4">
                              <label class="form-label text-dark fw-semibold mb-1">Type</label>
                              <select class="form-select select2" id="filter_txn_for">
                                 <option value="">All Types</option>
                                 <option value="survey">Survey</option>
                                 <option value="product">Product</option>
                                 <option value="rental_product">Rental Product</option>
                                 <option value="course">Course</option>
                              </select>
                           </div>
                           <div class="col-12 col-md-6 col-lg-4">
                              <label class="form-label text-dark fw-semibold mb-1">Status</label>
                              <select class="form-select select2" id="filter_status">
                                 <option value="">All Statuses</option>
                                 <option value="pending">Pending</option>
                                 <option value="success">Success</option>
                                 <option value="failed">Failed</option>
                              </select>
                           </div>
                           <div class="col-12 col-md-6 col-lg-4">
                              <label class="form-label text-dark fw-semibold mb-1">Order Code</label>
                              <input type="text" class="form-control" id="filter_order_id" placeholder="Order Code">
                           </div>
                           <div class="col-12 col-md-6 col-lg-4">
                              <label class="form-label text-dark fw-semibold mb-1">Amount</label>
                              <input type="text" class="form-control" id="filter_amount" placeholder="Amount">
                           </div>
                           <div class="col-12 col-md-6 col-lg-4">
                              <label class="form-label text-dark fw-semibold mb-1">Date From</label>
                              <input type="text" class="form-control datePicker" id="filter_date_from" placeholder="Date From">
                           </div>
                           <div class="col-12 col-md-6 col-lg-4">
                              <label class="form-label text-dark fw-semibold mb-1">Date To</label>
                              <input type="text" class="form-control datePicker" id="filter_date_to" placeholder="Date To">
                           </div>

                           <div class="col-12 col-md-6 col-lg-2">
                              <div class="d-flex gap-2">
                                 <button type="button" class="btn btn-primary btn-sm w-100" id="btnFilter"><i class="fas fa-search me-1"></i> Search</button>
                                 <button type="button" class="btn btn-outline-secondary btn-sm w-100" id="btnResetFilter"><i class="fas fa-redo-alt me-1"></i> Reset</button>
                              </div>
                           </div>
                        </div>
                     </div> 
                  </div>
               </div>

               <div class="card-body p-4 pt-0 mt-3">
                  <div class="table-responsive mt-2">
                     <table class="table table-striped table-bordered align-middle mb-0" id="myTable" style="width:100%"></table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
   var table = $('#myTable').DataTable({
      processing: true,
      serverSide: true,
      responsive: true, 
      ordering: false,
      searching: true, // Using custom filters 
      ajax: {
         url: "<?php echo e(route('admin.order.getRecords')); ?>",
         data: function (d) {
             d.user_id = $('#filter_user_id').val();
             d.txn_for = $('#filter_txn_for').val();
             d.status = $('#filter_status').val();
             d.order_id = $('#filter_order_id').val();
             d.amount = $('#filter_amount').val();
             d.date_from = $('#filter_date_from').val();
             d.date_to = $('#filter_date_to').val();
         }
      },
      columns: [
         {
            data: null, title: 'Sr.No.', orderable: false, searchable: false,
            render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
            } 
         },
         { data: 'order_code', name: 'order_code', title: 'Order Code' },
         { data: 'customer_details', name: 'customer_details', title: 'Customer' },
         { data: 'order_type', name: 'order_type', title: 'Order Type' },
         { data: 'address', name: 'address', title: 'Address' },
         { data: 'amount', name: 'amount', title: 'Amount' },
         { data: 'status', name: 'status', title: 'Status' },
         { data: 'notes', name: 'notes', title: 'Notes' },
         { data: 'created_at', name: 'created_at', title: 'Date' },
         { data: 'action', name: 'action', title: 'Action', orderable: false, searchable: false }
      ]
   });

   $('#btnFilter').on('click', function () { table.ajax.reload(); });
   $('#btnResetFilter').on('click', function () {
      $('#filter_user_id').val('').trigger('change');
      $('#filter_txn_for').val('').trigger('change');
      $('#filter_status').val('').trigger('change');
      $('#filter_order_id').val('');
      $('#filter_amount').val('');
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

   $(document).on('click', '.filter-type', function(e) {
      e.preventDefault();
      let type = $(this).data('type');
      $('#filter_txn_for').val(type).trigger('change');
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.includes.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\xplore-22-09-26\resources\views/admin/order/list.blade.php ENDPATH**/ ?>