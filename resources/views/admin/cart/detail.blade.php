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
                  <li class="breadcrumb-item">{{ $page_title }}</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
            <!-- Customer Info -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
               <div class="card-header bg-primary text-white py-3">
                  <h5 class="mb-0 fw-bold"><i class="fas fa-user me-2"></i>Customer Details</h5>
               </div>
               <div class="card-body">
                   <div class="row">
                       <div class="col-md-4 mb-2"><strong>Name:</strong> {{ $cart->user->name ?? 'N/A' }}</div>
                       <div class="col-md-4 mb-2"><strong>Email:</strong> {{ $cart->user->email_id ?? 'N/A' }}</div>
                       <div class="col-md-4 mb-2"><strong>Mobile:</strong> {{ $cart->user->phone_no ?? 'N/A' }}</div>
                   </div>
               </div>
            </div>

            <!-- Cart Items -->
            <div class="card shadow-sm border-0 rounded-3">
               <div class="card-header bg-light border-bottom-0 py-3">
                  <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-shopping-cart me-2"></i>Cart Items</h5>
               </div>
               <div class="card-body p-0">
                  <div class="table-responsive">
                     <table class="table table-striped table-bordered align-middle mb-0">
                         <thead class="table-dark">
                             <tr>
                                 <th>#</th>
                                 <th>Product</th>
                                 <th>Category</th>
                                 <th>Brand</th>
                                 <th>MRP</th>
                                 <th>Sale Price</th>
                                 <th>Qty</th>
                                 <th>Total</th>
                             </tr>
                         </thead>
                         <tbody>
                             @forelse($cart->items as $index => $item)
                             <tr>
                                 <td>{{ $index + 1 }}</td>
                                 <td>
                                     <strong>{{ $item->product_name }}</strong>
                                     @if($item->variant_name)
                                         <br><small class="text-muted">Variant: {{ $item->variant_name }}</small>
                                     @endif
                                 </td>
                                 <td>{{ $item->category_name }}<br><small>{{ $item->sub_category_name }}</small></td>
                                 <td>{{ $item->brand_name }}</td>
                                 <td>₹{{ number_format($item->mrp_price, 2) }}</td>
                                 <td>₹{{ number_format($item->sale_price, 2) }}</td>
                                 <td>{{ $item->quantity }}</td>
                                 <td>₹{{ number_format($item->line_total, 2) }}</td>
                             </tr>
                             @empty
                             <tr>
                                 <td colspan="8" class="text-center text-muted py-4">No items in cart</td>
                             </tr>
                             @endforelse
                         </tbody>
                         @if($cart->items->count() > 0)
                         <tfoot class="table-light">
                             <tr>
                                 <th colspan="7" class="text-end">Cart Total:</th>
                                 <th><strong class="text-primary fs-5">₹{{ number_format($cart->items->sum('line_total'), 2) }}</strong></th>
                             </tr>
                         </tfoot>
                         @endif
                     </table>
                  </div>
               </div>
            </div>
            
         </div>
      </div>
   </div>
</div>
@endsection
