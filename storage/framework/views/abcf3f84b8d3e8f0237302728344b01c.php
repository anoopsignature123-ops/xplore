<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-body">
   <div class="container-fluid">
      <!-- Page Title -->
      <div class="page-title">
         <div class="row align-items-center">
            <div class="col-sm-6 col-12">
               <h2 class="fw-bold mb-1 text-dark" style="font-family: 'Outfit', sans-serif;">Admin Dashboard</h2>
               <p class="mb-0 text-muted">A comprehensive overview of your platform's performance.</p>
            </div>
         </div>
      </div>
   </div>
   
   <div class="container-fluid default-dashboard">
    <div class="row g-3">

        <?php
        $cards = [
            [
                'title' => $totalCustomer,
                'subtitle' => 'Total Customers',
                'url' => route('admin.customer.list'),
                'icon' => 'fa-users',
                'color' => '#4e73df'
            ],
            [
                'title' => $totalVendor,
                'subtitle' => 'Total Vendors',
                'url' => route('admin.vendor.list'),
                'icon' => 'fa-store',
                'color' => '#1cc88a'
            ],
            [
                'title' => $totalProduct,
                'subtitle' => 'Total Products',
                'url' => route('admin.product.list'),
                'icon' => 'fa-box-open',
                'color' => '#36b9cc'
            ],
            [
                'title' => $pendingOrders,
                'subtitle' => 'Pending Orders',
                'url' => route('admin.product-order.list', ['order_status' => 'pending']),
                'icon' => 'fa-clock',
                'color' => '#f6c23e'
            ],
            [
                'title' => $totalProductSuccessOrder,
                'subtitle' => 'Success Orders',
                'url' => route('admin.product-order.list', ['order_status' => 'delivered']),
                'icon' => 'fa-check-circle',
                'color' => '#1cc88a'
            ],
            [
                'title' => $totalTransaction,
                'subtitle' => 'Total Transactions',
                'url' => route('admin.transaction.list'),
                'icon' => 'fa-money-bill-transfer',
                'color' => '#e74a3b'
            ],
            [
                'title' => '₹' . number_format($transactionSuccessAmount, 2),
                'subtitle' => 'Txn Success Amount',
                'url' => route('admin.transaction.list', ['status' => 'success']),
                'icon' => 'fa-sack-dollar',
                'color' => '#1cc88a'
            ],
            [
                'title' => '₹' . number_format($transactionPendingAmount, 2),
                'subtitle' => 'Txn Pending Amount',
                'url' => route('admin.transaction.list', ['status' => 'pending']),
                'icon' => 'fa-hand-holding-dollar',
                'color' => '#f6c23e'
            ],
            [
                'title' => $totalCustomerSurvey,
                'subtitle' => 'Total Customer Survey',
                'url' => route('admin.customer-survey.list'),
                'icon' => 'fa-poll',
                'color' => '#4e73df'
            ],
            [
                'title' => $totalCourseEnrollments,
                'subtitle' => 'Course Enrollments',
                'url' => route('admin.course-enrollment.list'),
                'icon' => 'fa-graduation-cap',
                'color' => '#6f42c1'
            ],
            [
                'title' => $totalHelpQueries,
                'subtitle' => 'Total Help Queries',
                'url' => route('admin.help-query.list'),
                'icon' => 'fa-headset',
                'color' => '#36b9cc'
            ],
            [
                'title' => $totalSystemUsers,
                'subtitle' => 'System Users',
                'url' => route('admin.users.list'),
                'icon' => 'fa-users-gear',
                'color' => '#1cc88a'
            ],
        ];
        ?>

        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-xl-3 col-lg-4 col-md-6">
            <a href="<?php echo e($card['url']); ?>" class="text-decoration-none">
                <div class="card dash-stats-card border-0 shadow-sm h-100">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="stats-icon-box"
                             style="background: <?php echo e($card['color']); ?>15; color: <?php echo e($card['color']); ?>;">
                            <i class="fa-solid <?php echo e($card['icon']); ?>"></i>
                        </div>

                        <div class="ms-3">
                            <p class="text-muted mb-0 small fw-bold text-uppercase">
                                <?php echo e($card['subtitle']); ?>

                            </p>

                            <h3 class="text-dark mb-0 fw-bold">
                                <?php echo e($card['title']); ?>

                            </h3>
                        </div>
                    </div>
                </div>
            </a> 
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

    <!-- Latest Records Row -->
    <div class="row g-3 mt-3">
        <!-- Latest Course Enrollments -->
        <div class="col-md-6">
            <div class="card dash-stats-card shadow-sm border-0 h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #f0f0f0; border-radius: 12px 12px 0 0;">
                    <h5 class="mb-0 fw-bold" style="font-family: 'Outfit', sans-serif;">Latest Course Enrollments</h5>
                    <a href="<?php echo e(route('admin.course-enrollment.list')); ?>" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <?php if($latestCourseEnrollments->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead style="background: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 px-3 py-2 text-muted">Customer</th>
                                        <th class="border-0 px-3 py-2 text-muted">Course</th>
                                        <th class="border-0 px-3 py-2 text-muted">Amount</th>
                                        <th class="border-0 px-3 py-2 text-muted">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $latestCourseEnrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-3">
                                            <?php if($enrollment->customer): ?>
                                                <div class="d-flex align-items-center">
                                                    <img src="<?php echo e(!empty($enrollment->customer->profile_image) ? asset($enrollment->customer->profile_image) : asset('assets/images/user.png')); ?>" alt="Profile" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:10px;">
                                                    <div>
                                                        <strong><?php echo e($enrollment->customer->name); ?></strong><br>
                                                        <small class="text-muted"><?php echo e($enrollment->customer->phone_no); ?></small>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-3"><?php echo e($enrollment->course_name); ?></td>
                                        <td class="px-3 fw-bold">₹<?php echo e(number_format($enrollment->amount, 2)); ?></td>
                                        <td class="px-3">
                                            <?php
                                                $statusClass = strtolower($enrollment->status) == 'active' ? 'success' : (strtolower($enrollment->status) == 'completed' ? 'primary' : 'warning');
                                            ?>
                                            <span class="badge bg-<?php echo e($statusClass); ?>"><?php echo e($enrollment->status); ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center p-4">
                            <i class="fa-solid fa-graduation-cap fs-1 text-muted mb-2"></i>
                            <h6 class="text-muted mb-0">No records found</h6>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Latest Customer Surveys -->
        <div class="col-md-6">
            <div class="card dash-stats-card shadow-sm border-0 h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #f0f0f0; border-radius: 12px 12px 0 0;">
                    <h5 class="mb-0 fw-bold" style="font-family: 'Outfit', sans-serif;">Latest Customer Surveys</h5>
                    <a href="<?php echo e(route('admin.customer-survey.list')); ?>" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <?php if($latestCustomerSurveys->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead style="background: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 px-3 py-2 text-muted">Customer</th>
                                        <th class="border-0 px-3 py-2 text-muted">Survey</th>
                                        <th class="border-0 px-3 py-2 text-muted">Amount</th>
                                        <th class="border-0 px-3 py-2 text-muted">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $latestCustomerSurveys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $survey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-3">
                                            <?php if($survey->customer): ?>
                                                <div class="d-flex align-items-center">
                                                    <img src="<?php echo e(!empty($survey->customer->profile_image) ? asset($survey->customer->profile_image) : asset('assets/images/user.png')); ?>" alt="Profile" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:10px;">
                                                    <div>
                                                        <strong><?php echo e($survey->customer->name); ?></strong><br>
                                                        <small class="text-muted"><?php echo e($survey->customer->phone_no); ?></small>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-3"><?php echo e($survey->survey_name); ?></td>
                                        <td class="px-3 fw-bold">₹<?php echo e(number_format($survey->amount, 2)); ?></td>
                                        <td class="px-3">
                                            <?php
                                                $statusClass = strtolower($survey->status) == 'completed' ? 'success' : 'warning';
                                            ?>
                                            <span class="badge bg-<?php echo e($statusClass); ?>"><?php echo e($survey->status); ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center p-4">
                            <i class="fa-solid fa-poll fs-1 text-muted mb-2"></i>
                            <h6 class="text-muted mb-0">No records found</h6>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row of Latest Records -->
    <div class="row g-3 mt-3">
        <!-- Latest Product Orders -->
        <div class="col-md-6">
            <div class="card dash-stats-card shadow-sm border-0 h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #f0f0f0; border-radius: 12px 12px 0 0;">
                    <h5 class="mb-0 fw-bold" style="font-family: 'Outfit', sans-serif;">Latest Product Orders</h5>
                    <a href="<?php echo e(route('admin.product-order.list')); ?>" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <?php if($latestProductOrders->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead style="background: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 px-3 py-2 text-muted">Customer</th>
                                        <th class="border-0 px-3 py-2 text-muted">Order ID</th>
                                        <th class="border-0 px-3 py-2 text-muted">Amount</th>
                                        <th class="border-0 px-3 py-2 text-muted">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $latestProductOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-3">
                                            <?php if($order->user): ?>
                                                <div class="d-flex align-items-center">
                                                    <img src="<?php echo e(!empty($order->user->profile_image) ? asset($order->user->profile_image) : asset('assets/images/user.png')); ?>" alt="Profile" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:10px;">
                                                    <div>
                                                        <strong><?php echo e($order->user->name); ?></strong><br>
                                                        <small class="text-muted"><?php echo e($order->user->phone_no); ?></small>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <strong><?php echo e($order->customer_name); ?></strong><br>
                                                        <small class="text-muted"><?php echo e($order->customer_mobile); ?></small>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-3"><?php echo e($order->order_number); ?></td>
                                        <td class="px-3 fw-bold">₹<?php echo e(number_format($order->grand_total, 2)); ?></td>
                                        <td class="px-3">
                                            <?php
                                                $statusClass = strtolower($order->order_status) == 'delivered' ? 'success' : (strtolower($order->order_status) == 'pending' ? 'warning' : 'info');
                                            ?>
                                            <span class="badge bg-<?php echo e($statusClass); ?>"><?php echo e($order->order_status); ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center p-4">
                            <i class="fas fa-box-open fs-1 text-muted mb-2"></i>
                            <h6 class="text-muted mb-0">No records found</h6>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

                <!-- Latest Gateway Orders -->
        <div class="col-md-6">
            <div class="card dash-stats-card shadow-sm border-0 h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #f0f0f0; border-radius: 12px 12px 0 0;">
                    <h5 class="mb-0 fw-bold" style="font-family: 'Outfit', sans-serif;">Latest Gateway Orders</h5>
                    <a href="<?php echo e(route('admin.order.list')); ?>" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <?php if($latestGatewayOrders->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead style="background: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 px-3 py-2 text-muted">Customer</th>
                                        <th class="border-0 px-3 py-2 text-muted">Order Code</th>
                                        <th class="border-0 px-3 py-2 text-muted">Amount</th>
                                        <th class="border-0 px-3 py-2 text-muted">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $latestGatewayOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gatewayOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-3">
                                            <?php if($gatewayOrder->customer): ?>
                                                <div class="d-flex align-items-center">
                                                    <img src="<?php echo e(!empty($gatewayOrder->customer->profile_image) ? asset($gatewayOrder->customer->profile_image) : asset('assets/images/user.png')); ?>" alt="Profile" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:10px;">
                                                    <div>
                                                        <strong><?php echo e($gatewayOrder->customer->name); ?></strong><br>
                                                        <small class="text-muted"><?php echo e($gatewayOrder->customer->phone_no); ?></small>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <strong><?php echo e($gatewayOrder->customer_name); ?></strong><br>
                                                        <small class="text-muted"><?php echo e($gatewayOrder->customer_mobile); ?></small>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-3"><?php echo e($gatewayOrder->order_code); ?></td>
                                        <td class="px-3 fw-bold">₹<?php echo e(number_format($gatewayOrder->amount, 2)); ?></td>
                                        <td class="px-3">
                                            <?php
                                                $statusClass = strtolower($gatewayOrder->status) == 'paid' || strtolower($gatewayOrder->status) == 'success' ? 'success' : (strtolower($gatewayOrder->status) == 'pending' ? 'warning' : 'info');
                                            ?>
                                            <span class="badge bg-<?php echo e($statusClass); ?>"><?php echo e($gatewayOrder->status); ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center p-4">
                            <i class="fas fa-cart-shopping fs-1 text-muted mb-2"></i>
                            <h6 class="text-muted mb-0">No records found</h6>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>


       
    </div>

    <!-- Third Row of Latest Records -->
    <div class="row g-3 mt-3">
 <!-- Latest Transactions -->
        <div class="col-md-6">
            <div class="card dash-stats-card shadow-sm border-0 h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #f0f0f0; border-radius: 12px 12px 0 0;">
                    <h5 class="mb-0 fw-bold" style="font-family: 'Outfit', sans-serif;">Latest Transactions</h5>
                    <a href="<?php echo e(route('admin.transaction.list')); ?>" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <?php if($latestTransactions->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead style="background: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 px-3 py-2 text-muted">Customer</th>
                                        <th class="border-0 px-3 py-2 text-muted">Payment ID</th>
                                        <th class="border-0 px-3 py-2 text-muted">Amount</th>
                                        <th class="border-0 px-3 py-2 text-muted">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $latestTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $txn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-3">
                                            <?php if($txn->customer): ?>
                                                <div class="d-flex align-items-center">
                                                    <img src="<?php echo e(!empty($txn->customer->profile_image) ? asset($txn->customer->profile_image) : asset('assets/images/user.png')); ?>" alt="Profile" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:10px;">
                                                    <div>
                                                        <strong><?php echo e($txn->customer->name); ?></strong><br>
                                                        <small class="text-muted"><?php echo e($txn->customer->phone_no); ?></small>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-3"><?php echo e($txn->transaction_id ?? $txn->razorpay_payment_id ?? 'N/A'); ?></td>
                                        <td class="px-3 fw-bold">₹<?php echo e(number_format($txn->amount, 2)); ?></td>
                                        <td class="px-3">
                                            <?php
                                                $statusClass = strtolower($txn->status) == 'success' ? 'success' : (strtolower($txn->status) == 'pending' ? 'warning' : 'danger');
                                            ?>
                                            <span class="badge bg-<?php echo e($statusClass); ?>"><?php echo e($txn->status); ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center p-4">
                            <i class="fas fa-exchange-alt fs-1 text-muted mb-2"></i>
                            <h6 class="text-muted mb-0">No records found</h6>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

 <?php $__env->stopSection(); ?>
 
 <?php $__env->startPush('styles'); ?>
 <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
 <style>
    .dash-stats-card {
       border-radius: 12px;
       transition: all 0.2s ease-in-out;
       background: #ffffff !important;
       border: 1px solid #f0f0f0 !important;
    }
    
    .dash-stats-card:hover {
       transform: translateY(-3px);
       box-shadow: 0 8px 15px rgba(0,0,0,0.08) !important;
    }
    
    .stats-icon-box {
       width: 50px !important;
       height: 50px !important;
       min-width: 50px !important;
       border-radius: 10px;
       display: flex !important;
       align-items: center !important;
       justify-content: center !important;
       font-size: 22px !important;
    }

    .stats-icon-box i {
       line-height: 1 !important;
       display: block !important;
    }
    
    /* Custom font for numbers */
    .dash-stats-card h3 {
       font-family: 'Outfit', sans-serif;
       font-size: 1.4rem;
       margin-top: 2px;
    }

    .default-dashboard .row {
       margin-top: 10px;
    }
 </style>
 <?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.includes.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\xplore-22-09-26\resources\views/admin/dashboard/dashboard.blade.php ENDPATH**/ ?>