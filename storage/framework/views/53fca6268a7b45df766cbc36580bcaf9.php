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
                  <li class="breadcrumb-item"><a href="<?php echo e(route('admin.build-category.list')); ?>">Build Categories</a></li>
                  <li class="breadcrumb-item active"><?php echo e($page_title); ?></li>
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
                  <a href="<?php echo e(route('admin.build-category.list')); ?>" class="btn btn-secondary btn-sm">
                     <i class="fas fa-arrow-left me-1"></i> Back
                  </a>
               </div>
               <div class="card-body">
                  <form action="<?php echo e(route('admin.build-category.save')); ?>" method="POST">
                     <?php echo csrf_field(); ?>
                     <input type="hidden" name="id" value="<?php echo e($category->id ?? ''); ?>">

                     <div class="row g-3">
                        <div class="col-md-6">
                           <label class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                           <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $category->name ?? '')); ?>" placeholder="e.g. Architect, Civil Contractor" required>
                        </div>

                        <div class="col-md-6 d-flex align-items-center mt-4">
                           <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" name="status" id="status" value="1" <?php echo e(old('status', $category->status ?? true) ? 'checked' : ''); ?>>
                              <label class="form-check-label fw-bold" for="status">Active Status</label>
                           </div>
                        </div>

                        <div class="col-12 text-end mt-4">
                           <button type="submit" class="btn btn-primary px-4"><?php echo e($btn_title); ?></button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.includes.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\xplore-22-09-26\resources\views/admin/build_category/add.blade.php ENDPATH**/ ?>