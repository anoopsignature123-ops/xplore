<?php $__env->startSection('title', $page_title); ?>
<?php $__env->startSection('content'); ?>
<div class="page-body">
   <div class="container-fluid">
      <div class="page-title">
         <div class="row">
            <div class="col-sm-6 col-12">
               <h4 class="m-0"><?php echo e($page_title); ?></h4>
            </div>
            <div class="col-sm-6 col-12 text-end">
               <a href="<?php echo e(route('builder.index')); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Dashboard</a>
            </div>
         </div>
      </div>
   </div>
   <div class="container-fluid">
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

      <div class="row g-4">
         <!-- Profile Information -->
         <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-3 mb-4">
               <div class="card-header bg-light py-3">
                  <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-id-card me-2"></i> Profile & Business Details</h5>
               </div>
               <div class="card-body">
                  <form action="<?php echo e(route('builder.profile.save')); ?>" method="POST" enctype="multipart/form-data">
                     <?php echo csrf_field(); ?>
                     <div class="row g-3">
                        <div class="col-md-6">
                           <label class="form-label fw-bold"><i class="fas fa-building text-primary me-1"></i> Firm / Company Name <span class="text-danger">*</span></label>
                           <input type="text" name="firm_name" class="form-control" value="<?php echo e(old('firm_name', $builder->firm_name)); ?>" required>
                        </div>
                        <div class="col-md-6">
                           <label class="form-label fw-bold"><i class="fas fa-user text-primary me-1"></i> Contact Person Name <span class="text-danger">*</span></label>
                           <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $builder->name)); ?>" required>
                        </div>

                        <div class="col-md-6">
                           <label class="form-label fw-bold"><i class="fas fa-phone-alt text-primary me-1"></i> Phone Number <span class="text-danger">*</span></label>
                           <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone', $builder->phone)); ?>" required>
                        </div>
                        <div class="col-md-6">
                           <label class="form-label fw-bold"><i class="fas fa-map-marker-alt text-primary me-1"></i> Location / City <span class="text-danger">*</span></label>
                           <input type="text" name="location" class="form-control" value="<?php echo e(old('location', $builder->location)); ?>" required>
                        </div>

                        <div class="col-md-6">
                           <label class="form-label fw-bold"><i class="fas fa-briefcase text-primary me-1"></i> Experience (Years)</label>
                           <input type="number" name="experience_years" class="form-control" value="<?php echo e(old('experience_years', $builder->experience_years)); ?>">
                        </div>
                        <div class="col-md-6">
                           <label class="form-label fw-bold"><i class="fas fa-trophy text-primary me-1"></i> Completed Projects Count</label>
                           <input type="number" name="projects_count" class="form-control" value="<?php echo e(old('projects_count', $builder->projects_count)); ?>">
                        </div>

                        <div class="col-md-6">
                           <label class="form-label fw-bold"><i class="fas fa-globe text-primary me-1"></i> Website</label>
                           <input type="text" name="website" class="form-control" value="<?php echo e(old('website', $builder->website)); ?>">
                        </div>
                        <div class="col-md-6">
                           <label class="form-label fw-bold"><i class="fas fa-directions text-primary me-1"></i> Full Address</label>
                           <input type="text" name="address" class="form-control" value="<?php echo e(old('address', $builder->address)); ?>">
                        </div>

                        <div class="col-md-6">
                           <label class="form-label fw-bold"><i class="fas fa-camera text-primary me-1"></i> Profile Photo</label>
                           <input type="file" name="profile_image" class="form-control" accept="image/*">
                           <?php if(!empty($builder->profile_image)): ?>
                              <img src="<?php echo e(asset($builder->profile_image)); ?>" class="mt-2 rounded-circle" style="height: 50px; width: 50px; object-fit: cover;">
                           <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                           <label class="form-label fw-bold"><i class="fas fa-image text-primary me-1"></i> Cover Photo</label>
                           <input type="file" name="cover_image" class="form-control" accept="image/*">
                           <?php if(!empty($builder->cover_image)): ?>
                              <img src="<?php echo e(asset($builder->cover_image)); ?>" class="mt-2 rounded" style="height: 50px; width: 100px; object-fit: cover;">
                           <?php endif; ?>
                        </div>

                        <div class="col-12">
                           <label class="form-label fw-bold"><i class="fas fa-align-left text-primary me-1"></i> About Firm / Description</label>
                           <textarea name="about" class="form-control" rows="3"><?php echo e(old('about', $builder->about)); ?></textarea>
                        </div>

                        <div class="col-md-4">
                           <label class="form-label fw-bold"><i class="fas fa-concierge-bell text-primary me-1"></i> Services Offered (Comma Separated)</label>
                           <input type="text" name="services" class="form-control" value="<?php echo e(implode(', ', $builder->services->pluck('service_name')->toArray())); ?>">
                        </div>
                        <div class="col-md-4">
                           <label class="form-label fw-bold"><i class="fas fa-award text-primary me-1"></i> Certifications (Comma Separated)</label>
                           <input type="text" name="certifications" class="form-control" value="<?php echo e(implode(', ', $builder->certifications->pluck('certification_name')->toArray())); ?>">
                        </div>
                        <div class="col-md-4">
                           <label class="form-label fw-bold"><i class="fas fa-map-marked-alt text-primary me-1"></i> Service Areas (Comma Separated)</label>
                           <input type="text" name="service_areas" class="form-control" value="<?php echo e(implode(', ', $builder->serviceAreas->pluck('city_name')->toArray())); ?>">
                        </div>

                        <div class="col-12 text-end mt-4">
                           <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i> Save Changes</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>

            <!-- Completed Projects Showcase -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
               <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                  <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-building me-2"></i> Completed Projects Showcase</h5>
               </div>
               <div class="card-body">
                  <form action="<?php echo e(route('builder.profile.addProject')); ?>" method="POST" enctype="multipart/form-data" class="row g-2 mb-4 bg-light p-3 rounded">
                     <?php echo csrf_field(); ?>
                     <div class="col-md-4">
                        <input type="text" name="project_title" class="form-control" placeholder="Project Title (e.g. Luxury Villa)" required>
                     </div>
                     <div class="col-md-3">
                        <input type="text" name="location" class="form-control" placeholder="Location (e.g. Lucknow)">
                     </div>
                     <div class="col-md-3">
                        <input type="text" name="area_details" class="form-control" placeholder="Area (e.g. 4500 sqft)">
                     </div>
                     <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100"><i class="fas fa-plus"></i> Add</button>
                     </div>
                  </form>

                  <div class="row g-3">
                     <?php $__empty_1 = true; $__currentLoopData = $builder->completedProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col-md-6">
                           <div class="border rounded p-3 d-flex justify-content-between align-items-center">
                              <div>
                                 <h6 class="fw-bold mb-1"><?php echo e($cp->project_title); ?></h6>
                                 <p class="text-muted small mb-0"><i class="fas fa-map-marker-alt text-danger me-1"></i> <?php echo e($cp->location); ?> | <?php echo e($cp->area_details); ?></p>
                              </div>
                              <form action="<?php echo e(route('builder.profile.deleteProject', $cp->id)); ?>" method="POST">
                                 <?php echo csrf_field(); ?>
                                 <?php echo method_field('DELETE'); ?>
                                 <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                              </form>
                           </div>
                        </div>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted col-12">No completed projects added yet.</p>
                     <?php endif; ?>
                  </div>
               </div>
            </div>
         </div>

         <!-- Work Portfolio Gallery & Security -->
         <div class="col-md-4">
            <!-- Portfolio Gallery -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
               <div class="card-header bg-light py-3">
                  <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-images me-2"></i> Work Portfolio Gallery</h5>
               </div>
               <div class="card-body">
                  <form action="<?php echo e(route('builder.profile.addPortfolio')); ?>" method="POST" enctype="multipart/form-data" class="mb-4">
                     <?php echo csrf_field(); ?>
                     <div class="mb-2">
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                     </div>
                     <div class="mb-2">
                        <input type="text" name="title" class="form-control" placeholder="Photo Caption / Title (Optional)">
                     </div>
                     <button type="submit" class="btn btn-success btn-sm w-100"><i class="fas fa-upload me-1"></i> Upload Photo</button>
                  </form>

                  <div class="row g-2">
                     <?php $__empty_1 = true; $__currentLoopData = $builder->portfolios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col-6 position-relative">
                           <img src="<?php echo e(asset($p->image_url)); ?>" class="img-fluid rounded border" style="height: 100px; width: 100%; object-fit: cover;">
                           <form action="<?php echo e(route('builder.profile.deletePortfolio', $p->id)); ?>" method="POST" class="position-absolute top-0 end-0 m-1">
                              <?php echo csrf_field(); ?>
                              <?php echo method_field('DELETE'); ?>
                              <button type="submit" class="btn btn-sm btn-danger py-0 px-1"><i class="fas fa-times"></i></button>
                           </form>
                        </div>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted col-12">No portfolio photos uploaded.</p>
                     <?php endif; ?>
                  </div>
               </div>
            </div>

            <!-- Password Change -->
            <div class="card shadow-sm border-0 rounded-3">
               <div class="card-header bg-light py-3">
                  <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-lock me-2"></i> Change Password</h5>
               </div>
               <div class="card-body">
                  <form action="<?php echo e(route('builder.profile.changePassword')); ?>" method="POST">
                     <?php echo csrf_field(); ?>
                     <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fas fa-key text-primary me-1"></i> Current Password</label>
                        <input type="password" name="old_password" class="form-control" required>
                     </div>
                     <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fas fa-lock text-primary me-1"></i> New Password</label>
                        <input type="password" name="new_password" class="form-control" required>
                     </div>
                     <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fas fa-check-double text-primary me-1"></i> Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                     </div>
                     <button type="submit" class="btn btn-primary w-100"><i class="fas fa-key me-1"></i> Update Password</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('builder.includes.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\xplore-22-09-26\resources\views/builder/profile.blade.php ENDPATH**/ ?>