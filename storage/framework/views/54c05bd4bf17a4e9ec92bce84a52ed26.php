<?php $__env->startSection('title', $page_title); ?>
<?php $__env->startSection('content'); ?>
<div class="page-body">
   <div class="container-fluid">
      <div class="page-title">
         <div class="row">
            <div class="col-sm-6 col-12">
               <h4 class="m-0"><?php echo e($page_title); ?></h4>
            </div>
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
               <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                  <h5 class="mb-0 fw-bold text-primary"><?php echo e($page_title); ?></h5>
               </div>
               <div class="card-body">
                  <?php if(session('success')): ?>
                     <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                     </div>
                  <?php endif; ?>

                  <div class="row g-3 mb-3">
                     <div class="col-md-3">
                        <label class="form-label fw-bold">Booking Status</label>
                        <select id="filter-booking-status" class="form-select">
                           <option value="">All Booking Statuses</option>
                           <option value="pending">Pending</option>
                           <option value="confirmed">Confirmed</option>
                           <option value="dispatched">Dispatched</option>
                           <option value="delivered">Delivered</option>
                           <option value="returned">Returned</option>
                           <option value="cancelled">Cancelled</option>
                        </select>
                     </div>
                     <div class="col-md-3">
                        <label class="form-label fw-bold">Payment Status</label>
                        <select id="filter-payment-status" class="form-select">
                           <option value="">All Payment Statuses</option>
                           <option value="pending">Pending</option>
                           <option value="paid">Paid</option>
                           <option value="failed">Failed</option>
                           <option value="refunded">Refunded</option>
                        </select>
                     </div>
                  </div>

                  <div class="table-responsive">
                     <table class="table table-bordered table-striped" id="bookings-table">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Booking No</th>
                              <th>Customer</th>
                              <th>Equipment</th>
                              <th>Duration</th>
                              <th>Total Amount</th>
                              <th>Delivery Type</th>
                              <th>Booking Status</th>
                              <th>Payment Status</th>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {

    var table = $('#bookings-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo e(route('admin.equipment-booking.getRecords')); ?>",
            data: function(d) {
                d.booking_status = $('#filter-booking-status').val();
                d.payment_status = $('#filter-payment-status').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'booking_number', name: 'booking_number'},
            {data: 'customer', name: 'customer'},
            {data: 'equipment', name: 'equipment'},
            {data: 'rental_duration_days', name: 'rental_duration_days'},
            {data: 'total_amount', name: 'total_amount'},
            {data: 'delivery_type', name: 'delivery_type'},
            {data: 'booking_status', name: 'booking_status'},
            {data: 'payment_status', name: 'payment_status'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    $('#filter-booking-status, #filter-payment-status').change(function() {
        table.ajax.reload();
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.includes.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\xplore-22-09-26\resources\views/admin/equipment_booking/list.blade.php ENDPATH**/ ?>