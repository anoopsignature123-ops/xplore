<?php $__env->startSection('title', $page_title); ?>
<?php $__env->startSection('content'); ?>
<div class="page-body">
   <div class="container-fluid">
      <div class="page-title">
         <div class="row">
            <div class="col-sm-6 col-12">
               <h4 class="m-0 fw-bold text-dark">Welcome, <?php echo e($builder->firm_name); ?> <span class="badge text-white ms-2 align-middle px-3 py-2" style="background-color: #308e87 !important; font-size: 13px;"><i class="fas fa-hard-hat me-1"></i> Builder Portal</span></h4>
               <p class="text-muted mb-0">Contact Person: <?php echo e($builder->name); ?> | <?php echo e($builder->category->name ?? 'Professional'); ?></p>
            </div>
            <div class="col-sm-6 col-12 text-end">
               <a href="<?php echo e(route('builder.profile')); ?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-user-edit me-1"></i> Edit Profile & Showcase</a>
               <a href="<?php echo e(route('builder.logout')); ?>" class="btn btn-outline-danger btn-sm ms-2"><i class="fas fa-sign-out-alt me-1"></i> Logout</a>
            </div>
         </div>
      </div>
   </div>
   <div class="container-fluid">
      <div class="row g-3 mb-4">
         <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-3 bg-primary text-white p-3">
               <div class="d-flex justify-content-between align-items-center">
                  <div>
                     <h6 class="mb-0 text-white-50">Total Inquiries</h6>
                     <h2 class="mb-0 fw-bold text-white"><?php echo e($totalInquiries); ?></h2>
                  </div>
                  <i class="fas fa-headset fa-2x text-white-50"></i>
               </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-3 bg-warning text-dark p-3">
               <div class="d-flex justify-content-between align-items-center">
                  <div>
                     <h6 class="mb-0 text-dark">Pending Leads</h6>
                     <h2 class="mb-0 fw-bold"><?php echo e($pendingInquiries); ?></h2>
                  </div>
                  <i class="fas fa-clock fa-2x text-dark"></i>
               </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-3 bg-success text-white p-3">
               <div class="d-flex justify-content-between align-items-center">
                  <div>
                     <h6 class="mb-0 text-white-50">Portfolio Photos</h6>
                     <h2 class="mb-0 fw-bold text-white"><?php echo e($totalPortfolios); ?></h2>
                  </div>
                  <i class="fas fa-images fa-2x text-white-50"></i>
               </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-3 bg-info text-white p-3">
               <div class="d-flex justify-content-between align-items-center">
                  <div>
                     <h6 class="mb-0 text-white-50">Projects Showcase</h6>
                     <h2 class="mb-0 fw-bold text-white"><?php echo e($totalProjects); ?></h2>
                  </div>
                  <i class="fas fa-building fa-2x text-white-50"></i>
               </div>
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-12">
            <div class="card shadow-sm border-0 rounded-3">
               <div class="card-header bg-light py-3">
                  <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-comments me-2"></i> Recent Customer Inquiries</h5>
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <table class="table table-striped table-bordered align-middle">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th><i class="fas fa-user me-1 text-primary"></i> Customer Name</th>
                              <th><i class="fas fa-phone-alt me-1 text-success"></i> Phone</th>
                              <th><i class="fas fa-tag me-1 text-info"></i> Inquiry Type</th>
                              <th><i class="fas fa-calendar-alt me-1 text-warning"></i> Date</th>
                              <th><i class="fas fa-tasks me-1 text-secondary"></i> Status</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $__empty_1 = true; $__currentLoopData = $recentInquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $inq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                              <tr>
                                 <td><?php echo e($idx + 1); ?></td>
                                 <td><strong><i class="fas fa-user me-1 text-primary"></i> <?php echo e($inq->customer_name); ?></strong></td>
                                 <td><i class="fas fa-phone-alt me-1 text-success"></i> <a href="tel:<?php echo e($inq->customer_phone); ?>" class="fw-bold"><?php echo e($inq->customer_phone); ?></a></td>
                                 <td>
                                    <?php if($inq->inquiry_type == 'call'): ?>
                                       <span class="badge bg-success"><i class="fas fa-phone me-1"></i> Call Request</span>
                                    <?php elseif($inq->inquiry_type == 'chat'): ?>
                                       <span class="badge bg-primary"><i class="fas fa-comments me-1"></i> Chat Request</span>
                                    <?php else: ?>
                                       <span class="badge bg-info"><i class="fas fa-info-circle me-1"></i> General</span>
                                    <?php endif; ?>
                                 </td>
                                 <td><?php echo e($inq->created_at ? $inq->created_at->format('d M Y, h:i A') : 'N/A'); ?></td>
                                 <td>
                                    <span class="badge bg-<?php echo e($inq->status == 'closed' ? 'success' : ($inq->status == 'contacted' ? 'info' : 'warning')); ?>">
                                       <?php echo e(ucfirst($inq->status)); ?>

                                    </span>
                                 </td>
                              </tr>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                              <tr>
                                 <td colspan="6" class="text-center text-muted py-4">No recent inquiries found.</td>
                              </tr>
                           <?php endif; ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('builder.includes.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\xplore-22-09-26\resources\views/builder/dashboard.blade.php ENDPATH**/ ?>