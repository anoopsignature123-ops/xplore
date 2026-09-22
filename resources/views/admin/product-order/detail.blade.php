@extends('admin.includes.layout')
@section('title', $page_title)
@section('content')
<div class="page-body">
   <div class="container-fluid">
      <div class="page-title">
         <div class="row">
            <div class="col-sm-6 col-12 d-flex align-items-center">
               <button onclick="history.back()" class="btn btn-sm btn-primary me-3 shadow-sm"><i class="fas fa-arrow-left me-1"></i> Back</button>
               <h4 class="mb-0">{{ $page_title }}</h4>
            </div>
            <div class="col-sm-6 col-12">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="fa-solid fa-home me-2"></i></a></li>
                  <li class="breadcrumb-item"><a href="{{ route('admin.product-order.list') }}">Order List</a></li>
                  <li class="breadcrumb-item">{{ $page_title }}</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card shadow-sm border-0 rounded-3 mb-4">
               <div class="card-header bg-primary text-white py-3">
                  <h5 class="mb-0 fw-bold"><i class="fas fa-file-invoice-dollar me-2"></i>Order Information</h5>
               </div>
               <div class="card-body">
                  <div class="row">
                      <!-- Order Info -->
                      <div class="col-md-4 border-end">
                          <h6 class="text-primary fw-bold mb-3">Order Details</h6>
                          <div class="mb-2"><span class="text-muted">Order Number:</span> <strong class="text-dark">{{ $order->order_number }}</strong></div>
                          <div class="mb-2"><span class="text-muted">Order Date:</span> <strong>{{ $order->created_at ? $order->created_at->format('d M Y, h:i A') : 'N/A' }}</strong></div>
                          <div class="mb-2">
                             <span class="text-muted">Payment Status:</span>
                             @php $pClass = $order->payment_status === 'success' ? 'success' : ($order->payment_status === 'pending' ? 'warning' : 'danger'); @endphp
                             <span class="badge bg-{{ $pClass }}">{{ $order->payment_status }}</span>
                          </div>
                          <div class="mb-2">
                             <span class="text-muted">Order Status:</span>
                             <div class="d-flex align-items-center gap-2 mt-1">
                                 <select class="form-select  w-auto" id="changeOrderStatus">
                                     <option value="Pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                     <option value="Processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                                     <option value="Shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                     <option value="Delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                     <option value="Cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                 </select>
                                 <button class="btn btn-sm btn-primary" id="btnUpdateStatus">Update</button>
                             </div>
                          </div> 
                      </div>
  
                      <!-- Customer Info --> 
                      <div class="col-md-4 border-end">
                          <h6 class="text-primary fw-bold mb-3">Customer Details</h6>
                          <div class="mb-2"><span class="text-muted">Name:</span> <strong>{{ $order->user->name ?? '' }}</strong></div>
                          <div class="mb-2"><span class="text-muted">Email:</span> <a href="mailto:{{ $order->user->email_id ?? '' }}">{{ $order->user->email_id ?? '' }}</a></div>
                          <div class="mb-2"><span class="text-muted">Mobile:</span> <a href="tel:{{ $order->user->phone_no }}">{{ $order->user->phone_no }}</a></div>
                         
                      </div>

                      <!-- Pricing Info -->
                      <div class="col-md-4">
                          <h6 class="text-primary fw-bold mb-3">Pricing Summary</h6>
                          <div class="d-flex justify-content-between mb-2">
                              <span class="text-muted">Subtotal:</span>
                              <strong>₹{{ number_format($order->subtotal, 2) }}</strong>
                          </div>
                       
                          <div class="d-flex justify-content-between mb-2">
                              <span class="text-muted">Tax:</span>
                              <strong>₹{{ number_format($order->tax, 2) }}</strong>
                          </div>
                         
                          <hr>
                          <div class="d-flex justify-content-between">
                              <span class="fs-5 fw-bold text-dark">Grand Total:</span>
                              <strong class="fs-5 text-primary">₹{{ number_format($order->grand_total, 2) }}</strong>
                          </div>
                      </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-12">
            <!-- Order Items -->
            <div class="card shadow-sm border-0 rounded-3">
               <div class="card-header bg-light border-bottom-0 py-3">
                  <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-shopping-basket me-2"></i>Order Items</h5>
               </div>
               <div class="card-body p-0">
                  <div class="table-responsive">
                     <table class="table table-striped table-bordered align-middle mb-0">
                         <thead class="table-dark">
                             <tr>
                                 <th>#</th>
                                 <th>Product</th>
                                 <th>MRP</th>
                                 <th>Sale Price</th>
                                 <th>Qty</th>
                                 <th>Total</th>
                             </tr>
                         </thead>
                         <tbody>
                             @forelse($order->items as $index => $item)
                             <tr>
                                 <td>{{ $index + 1 }}</td>
                                 <td>
                                     <strong>{{ $item->product_name }}</strong>
                                     @if($item->variant_name)
                                         <br><span class="badge badge-info text-light border mt-1">Variant: {{ $item->variant_name }}</span>
                                     @endif
                                     <br><small class="text-muted">{{ $item->category_name }} / {{ $item->brand_name }}</small>
                                 </td>
                                 <td><del class="text-muted">₹{{ number_format($item->mrp_price, 2) }}</del></td>
                                 <td class="fw-semibold">₹{{ number_format($item->sale_price, 2) }}</td>
                                 <td>{{ $item->quantity }}</td>
                                 <td><strong class="text-dark">₹{{ number_format($item->line_total, 2) }}</strong></td>
                             </tr>
                             @empty
                             <tr>
                                 <td colspan="6" class="text-center text-muted py-4">No items in this order</td>
                             </tr>
                             @endforelse
                         </tbody>
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
<script>
$(document).ready(function() {
    $('#btnUpdateStatus').on('click', function() {
        var status = $('#changeOrderStatus').val();
        var orderId = "{{ $order->id }}";
        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: "{{ route('admin.product-order.changeStatus') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: orderId,
                order_status: status
            },
            success: function(res) {
                if(res.status) {
                    toastr.success(res.message);
                } else {
                    toastr.error(res.message);
                }
            },
            error: function() {
                toastr.error('Something went wrong!');
            },
            complete: function() {
                btn.prop('disabled', false).html('Update');
            }
        });
    });
});
</script>
@endpush
