@extends('admin.includes.layout')
@section('title', $page_title)
@section('content')
<div class="page-body">
   <div class="container-fluid">
      <div class="page-title">
         <div class="row">
            <div class="col-sm-6 col-12"></div>
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
            <div class="card shadow-lg border-0 rounded-3">
               <div class="card-header bg-light border-bottom-0 py-3 d-flex justify-content-between align-items-center rounded-top">
                  <h3 class="mb-0 fw-bold text-primary">{{ $page_title }}</h3>
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
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">Customer</label>

                        
                         
                        
                              <select class="form-select  select2" id="filter_user_id">
                                 <option value="">All Customers</option>
                                 @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ (isset($user_id) && $user_id == $customer->id) ? 'selected' : '' }}>{{ $customer->name }} ({{ $customer->phone_no }})</option>
                                 @endforeach
                              </select>
                              <input type="hidden" id="filter_id" value="{{ $id ?? '' }}">
                           </div>
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">Order Number</label>
                              <input type="text" class="form-control form-control-sm" id="filter_order_number" placeholder="ORD-...">
                           </div>
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">Order Status</label>
                              <select class="form-select  select2" id="filter_order_status">
                                 <option value="">Select Status</option>
                                 <option value="Pending" {{ (isset($order_status) && $order_status == 'pending') ? 'selected' : '' }}>Pending</option>
                                 <option value="Processing" {{ (isset($order_status) && $order_status == 'processing') ? 'selected' : '' }}>Processing</option>
                                 <option value="Shipped" {{ (isset($order_status) && $order_status == 'shipped') ? 'selected' : '' }}>Shipped</option>
                                 <option value="Delivered" {{ (isset($order_status) && $order_status == 'delivered') ? 'selected' : '' }}>Delivered</option>
                                 <option value="Cancelled" {{ (isset($order_status) && $order_status == 'cancelled') ? 'selected' : '' }}>Cancelled</option>
                              </select>
                           </div>

                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">Payment Status</label>
                              <select class="form-select  select2" id="filter_payment_status">
                                 <option value="">Select Status</option>
                                 <option value="pending">Pending</option>
                                 <option value="success">Success</option>
                                 <option value="failed">Failed</option>
                              </select>
                           </div>


                           <div class="col-12 col-md-6 col-lg-3">
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
                  @if($user_id)
                     <div class="alert alert-info py-2"><i class="fas fa-filter me-2"></i> Showing orders for specific user. <a href="{{ route('admin.product-order.list') }}" class="alert-link text-light">Clear Filter</a></div>
                  @endif
                  <div class="table-responsive mt-2">
                     <table class="table table-striped table-bordered align-middle mb-0" id="myTable" style="width:100%"></table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
    $('.select2').select2({ width: '100%' });

    @if(isset($order_status) && $order_status != '')
        $('#filterSection').collapse('show');
    @endif

   var table = $('#myTable').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ordering: false,
      searching: false, // Using custom filters
      ajax: {
         url: "{{ route('admin.product-order.getRecords') }}",
         data: function (d) {
             d.user_id = $('#filter_user_id').val();
             d.id = $('#filter_id').val();
             d.order_number = $('#filter_order_number').val();
             d.order_status = $('#filter_order_status').val();
             d.payment_status = $('#filter_payment_status').val();
         }
      },
      columns: [
         {
            data: null, title: 'Sr.No.', orderable: false, searchable: false,
            render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
            }
         },
         { data: 'customer_details', name: 'customer_details', title: 'Customer Details' },
         { data: 'order_number', name: 'order_number', title: 'Order Number' },
         { data: 'grand_total', name: 'grand_total', title: 'Amount' },
         { data: 'payment_status', name: 'payment_status', title: 'Payment' },
         { data: 'order_status', name: 'order_status', title: 'Status' },
         { data: 'created_at', name: 'created_at', title: 'Date' },
         { data: 'action', name: 'action', title: 'Action' }
      ] 
   });

   $('#btnFilter').on('click', function () { table.ajax.reload(); });
   $('#btnResetFilter').on('click', function () {
      $('#filter_user_id').val('').trigger('change');
      $('#filter_id').val('');
      $('#filter_order_number').val('');
      $('#filter_order_status').val('').trigger('change');
      $('#filter_payment_status').val('').trigger('change');
      window.history.pushState({}, document.title, window.location.pathname);
      table.ajax.reload();
   });
});
</script>
@endpush
