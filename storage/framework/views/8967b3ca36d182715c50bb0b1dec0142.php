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
               <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center rounded-top">
                  <h5 class="mb-0 fw-bold text-primary"><?php echo e($page_title); ?></h5>
                  <a href="<?php echo e(route('admin.equipment.add')); ?>" class="btn btn-primary btn-sm">
                     <i class="fas fa-plus me-1"></i> Add Equipment
                  </a>
               </div>
               <div class="card-body">
                  <?php if(session('success')): ?>
                     <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                     </div>
                  <?php endif; ?>
                  <?php if(session('error')): ?>
                     <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo e(session('error')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                     </div>
                  <?php endif; ?>

                  <div class="table-responsive">
                     <table class="table table-bordered table-striped" id="equipment-table">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Image</th>
                              <th>Name</th>
                              <th>Brand / Model</th>
                              <th>Daily Rate</th>
                              <th>Availability</th>
                              <th>Popular</th>
                              <th>Status</th>
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

    var table = $('#equipment-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?php echo e(route('admin.equipment.getRecords')); ?>",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'image', name: 'image', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'brand', name: 'brand', render: function(data, type, row) {
                return (row.brand || '') + ' ' + (row.model ? '(' + row.model + ')' : '');
            }},
            {data: 'daily_rate', name: 'daily_rate'},
            {data: 'availability_status', name: 'availability_status'},
            {data: 'is_popular', name: 'is_popular'},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    $(document).on('change', '.status-toggle', function() {
        var checkbox = $(this);
        var id = checkbox.data('id');
        var isChecked = checkbox.is(':checked');

        Swal.fire({
            title: 'Change Status?',
            text: 'Are you sure you want to change status for this equipment?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#308e87',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo e(route('admin.equipment.toggleStatus')); ?>",
                    type: "POST",
                    data: { _token: "<?php echo e(csrf_token()); ?>", id: id },
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                            checkbox.prop('checked', !isChecked);
                        }
                    },
                    error: function() {
                        toastr.error('Something went wrong!');
                        checkbox.prop('checked', !isChecked);
                    }
                });
            } else {
                checkbox.prop('checked', !isChecked);
            }
        });
    });

    $(document).on('click', '.delete-btn', function() {
        var url = $(this).data('url');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this equipment!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: { _token: "<?php echo e(csrf_token()); ?>" },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire('Deleted!', response.message, 'success');
                            table.ajax.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    }
                });
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.includes.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\xplore-22-09-26\resources\views/admin/equipment/list.blade.php ENDPATH**/ ?>