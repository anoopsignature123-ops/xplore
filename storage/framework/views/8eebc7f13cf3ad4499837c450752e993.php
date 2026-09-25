<footer class="footer">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-6 footer-copyright">
            <p class="mb-0">Copyright <?php echo e(date('Y')); ?> © <?php echo e($settings->company_name ?? 'Xplore Build'); ?></p>
         </div>
         <div class="col-md-6">
            <p class="float-end mb-0">Builder & Contractor Portal</p>
         </div> 
      </div>
   </div>
</footer>  
</div> 
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="<?php echo e(asset('assets/admin/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')); ?>" defer></script>
<script src="<?php echo e(asset('assets/admin/js/vendors/font-awesome/fontawesome-min.js')); ?>" defer></script>
<script src="<?php echo e(asset('assets/admin/js/sidebar.js')); ?>" defer></script>
<script src="<?php echo e(asset('assets/admin/js/height-equal.js')); ?>" defer></script>
<script src="<?php echo e(asset('assets/admin/js/config.js')); ?>" defer></script>
<script src="<?php echo e(asset('assets/admin/js/scrollbar/simplebar.js')); ?>" defer></script>
<script src="<?php echo e(asset('assets/admin/js/scrollbar/custom.js')); ?>" defer></script>
<script src="<?php echo e(asset('assets/admin/js/script.js')); ?>" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
<script>
   $(function() {
      <?php if(session('success')): ?>
         setTimeout(function() {
            toastr.success('<?php echo e(session('success')); ?>');
         }, 500);
      <?php endif; ?>
      <?php if(session('error')): ?>
         setTimeout(function() {
            toastr.error('<?php echo e(session('error')); ?>');
         }, 500);
      <?php endif; ?>
   });
</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\xplore-22-09-26\resources\views/builder/includes/footer.blade.php ENDPATH**/ ?>