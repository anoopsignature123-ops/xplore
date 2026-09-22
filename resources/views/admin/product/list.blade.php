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
                     <button class="btn btn-outline-secondary btn-sm" type="button"
                        data-bs-toggle="collapse" data-bs-target="#filterSection">
                        <i class="fas fa-filter"></i> Filters
                     </button>
                     @can('slider-add')
                     <a href="{{ route('admin.product.add') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-plus"></i> Add
                     </a>
                     @endcan
                  </div>
               </div>

               <div class="border-top"></div>

               <!-- Filters -->
               <div class="collapse mb-3" id="filterSection">
                  <div class="card border-0 shadow-sm">
                     <div class="card-body bg-light">
                        <div class="row g-3 align-items-end">

                           <!-- Category -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">Category</label>
                              <select class="form-select  select2" id="filter_category">
                                 <option value="">All Categories</option>
                                 @foreach($product_category_list as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                 @endforeach
                              </select>
                           </div>

                           <!-- Sub Category -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">Sub Category</label>
                              <select class="form-select  select2" id="filter_sub_category">
                                 <option value="">All Sub Categories</option>
                              </select>
                           </div>

                           <!-- Brand -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">Brand</label>
                              <select class="form-select  select2" id="filter_brand">
                                 <option value="">All Brands</option>
                              </select>
                           </div>

                           <!-- Status -->
                           <div class="col-12 col-md-6 col-lg-3">
                              <label class="form-label text-dark fw-semibold mb-1">Status</label>
                              <select class="form-select  select2" id="filter_status">
                                 <option value="">Select Status</option>
                                 <option value="Active">Active</option>
                                 <option value="Inactive">Inactive</option>
                              </select>
                           </div>

                           <!-- Buttons -->
                           <div class="col-12">
                              <div class="d-flex flex-column flex-sm-row gap-2">
                                 <button type="button" class="btn btn-primary btn-sm" id="btnFilter">
                                    <i class="fas fa-search me-1"></i> Apply Filter
                                 </button>
                                 <button type="button" class="btn btn-outline-secondary btn-sm" id="btnResetFilter">
                                    <i class="fas fa-redo-alt me-1"></i> Reset
                                 </button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- Table -->
               <div class="card-body p-4 pt-0">
                  <div class="table-responsive mt-2">
                     <table class="table table-striped table-bordered align-middle mb-0" id="myTable"></table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Variants Modal -->
<div class="modal fade" id="variantsModal" tabindex="-1" aria-labelledby="variantsModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 shadow">
         <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="variantsModalLabel">
               <i class="fas fa-layer-group me-2"></i> Variants
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
         </div>
         <div class="modal-body" id="variantsModalBody">
            <div class="text-center py-4">
               <div class="spinner-border text-primary" role="status"></div>
               <p class="mt-2 text-muted">Loading variants...</p>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>

<!-- Specifications Modal -->
<div class="modal fade" id="specsModal" tabindex="-1" aria-labelledby="specsModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 shadow">
         <div class="modal-header bg-warning text-dark">
            <h5 class="modal-title" id="specsModalLabel">
               <i class="fas fa-list-ul me-2"></i> Specifications
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
         </div>
         <div class="modal-body" id="specsModalBody">
            <div class="text-center py-4">
               <div class="spinner-border text-warning" role="status"></div>
               <p class="mt-2 text-muted">Loading specifications...</p>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {

   // ── DataTable ──────────────────────────────────────────────
   var table = $('#myTable').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ordering: false,
      searching: true,
      ajax: {
         url: "{{ route('admin.product.getRecords') }}",
         data: function (d) {
            d.status              = $('#filter_status').val();
            d.product_category_id = $('#filter_category').val();
            d.product_sub_category_id = $('#filter_sub_category').val();
            d.product_brand_id    = $('#filter_brand').val();
         }
      },
      columns: [
         {
            data: null, title: 'Sr.No.', orderable: false, searchable: false,
            render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
            }
         },
         { data: 'image',            name: 'image',            title: 'Image' },
         { data: 'category_name',    name: 'category_name',    title: 'Category' },
         { data: 'sub_category_name',name: 'sub_category_name',title: 'Sub Category' },
         { data: 'brand_name',       name: 'brand_name',       title: 'Brand' },
         { data: 'product_name',     name: 'product_name',     title: 'Product Name' },
         { data: 'action_specs', name: 'action_specs', title: 'Specifications'},
         { data: 'mrp_price',        name: 'mrp_price',        title: 'MRP Price' },
         { data: 'sale_price',       name: 'sale_price',       title: 'Sale Price' },
         { data: 'stock',            name: 'stock',            title: 'Stock' },
         { data: 'status',           name: 'status',           title: 'Status' },
         { data: 'action',           name: 'action',           title: 'Action' }
      ]
   });

   // ── Filter buttons ─────────────────────────────────────────
   $('#btnFilter').on('click', function () { table.ajax.reload(); });

   $('#btnResetFilter').on('click', function () {
      $('#filter_status').val('').trigger('change');
      $('#filter_category').val('').trigger('change');
      $('#filter_sub_category').html('<option value="">All Sub Categories</option>').trigger('change');
      $('#filter_brand').html('<option value="">All Brands</option>').trigger('change');
      table.ajax.reload();
   });

   // ── Category → load Sub Categories + Brands ───────────────
   $('#filter_category').on('change', function () {
      var catId = $(this).val();

      // Reset dependents
      $('#filter_sub_category').html('<option value="">All Sub Categories</option>');
      $('#filter_brand').html('<option value="">All Brands</option>');

      if (!catId) return;

      // Sub categories
      $.get("{{ route('admin.get-sub-categories') }}", { product_category_id: catId }, function (data) {
         $.each(data, function (i, item) {
            $('#filter_sub_category').append('<option value="' + item.id + '">' + item.sub_category_name + '</option>');
         });
         if ($('#filter_sub_category').hasClass('select2-hidden-accessible')) {
            $('#filter_sub_category').trigger('change');
         }
      });

      // Brands
      $.get("{{ route('admin.get-brands') }}", { product_category_id: catId }, function (data) {
         $.each(data, function (i, item) {
            $('#filter_brand').append('<option value="' + item.id + '">' + item.brand_name + '</option>');
         });
         if ($('#filter_brand').hasClass('select2-hidden-accessible')) {
            $('#filter_brand').trigger('change');
         }
      });
   });

   // ── Status toggle ──────────────────────────────────────────
   $('#myTable').on('change', '.toggleStatus', function () {
      var checkbox = $(this);
      var id       = checkbox.data('id');
      var status   = checkbox.is(':checked') ? 'Active' : 'Inactive';

      $.ajax({
         url: "{{ route('admin.product.changeStatus') }}",
         type: 'POST',
         data: { _token: "{{ csrf_token() }}", id: id, status: status },
         success: function (response) {
            if (response.status) {
               var container   = checkbox.closest('.d-flex');
               var switchState = container.find('.switch-state');
               container.find('.status-label').text(status);
               if (status === 'Active') {
                  switchState.removeClass('bg-danger').addClass('bg-success');
               } else {
                  switchState.removeClass('bg-success').addClass('bg-danger');
               }
               toastr.success(response.message);
            } else {
               toastr.error(response.message);
               checkbox.prop('checked', !checkbox.is(':checked'));
            }
         },
         error: function () {
            toastr.error('Something went wrong.');
            checkbox.prop('checked', !checkbox.is(':checked'));
         }
      });
   });

   // ── View Variants click ────────────────────────────────────
   $('#myTable').on('click', '.btnViewVariants', function () {
      var productId   = $(this).data('id');
      var productName = $(this).data('name');

      $('#variantsModalLabel').html('<i class="fas fa-layer-group me-2"></i> Variants — ' + productName);
      $('#variantsModalBody').html(
         '<div class="text-center py-4">' +
         '<div class="spinner-border text-primary" role="status"></div>' +
         '<p class="mt-2 text-muted">Loading variants...</p>' +
         '</div>'
      );
      $('#variantsModal').modal('show');

      $.ajax({
         url: "{{ route('admin.product.getVariants') }}",
         type: 'POST',
         data: { _token: "{{ csrf_token() }}", product_id: productId },
         success: function (response) {
            if (response.status && response.variants.length > 0) {
               var rows = '';
               $.each(response.variants, function (i, v) {
                  rows +=
                     '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + v.variant_name + '</td>' +
                        '<td>₹' + parseFloat(v.mrp_price).toFixed(2) + '</td>' +
                        '<td>₹' + parseFloat(v.sale_price).toFixed(2) + '</td>' +
                        '<td>' + v.stock + '</td>' +
                     '</tr>';
               });
               $('#variantsModalBody').html(
                  '<div class="table-responsive">' +
                  '<table class="table table-bordered table-striped align-middle mb-0">' +
                     '<thead class="table-dark">' +
                        '<tr>' +
                           '<th>#</th>' +
                           '<th>Variant Name</th>' +
                           '<th>MRP Price</th>' +
                           '<th>Sale Price</th>' +
                           '<th>Stock</th>' +
                        '</tr>' +
                     '</thead>' +
                     '<tbody>' + rows + '</tbody>' +
                  '</table>' +
                  '</div>'
               );
            } else {
               $('#variantsModalBody').html(
                  '<div class="text-center py-4 text-muted">' +
                  '<i class="fas fa-inbox fa-3x mb-3 d-block"></i>No variants found.' +
                  '</div>'
               );
            }
         },
         error: function () {
            $('#variantsModalBody').html(
               '<div class="alert alert-danger m-3">Failed to load variants. Please try again.</div>'
            );
         }
      });
   });
});

// ── View Specifications click ──────────────────────────
$('#myTable').on('click', '.btnViewSpecs', function () {
   var productId   = $(this).data('id');
   var productName = $(this).data('name');

   $('#specsModalLabel').html('<i class="fas fa-list-ul me-2"></i> Specifications — ' + productName);
   $('#specsModalBody').html(
      '<div class="text-center py-4">' +
         '<div class="spinner-border text-warning" role="status"></div>' +
         '<p class="mt-2 text-muted">Loading specifications...</p>' +
      '</div>'
   );
   $('#specsModal').modal('show');

   $.ajax({
      url: "{{ route('admin.product.getSpecifications') }}",
      type: 'POST',
      data: { _token: "{{ csrf_token() }}", product_id: productId },
      success: function (response) {
         if (response.status && response.specifications.length > 0) {
            var rows = '';
            $.each(response.specifications, function (i, s) {
               rows +=
                  '<tr>' +
                     '<td>' + (i + 1) + '</td>' +
                     '<td>' + $('<div>').text(s.name).html() + '</td>' +
                     '<td>' + $('<div>').text(s.value).html() + '</td>' +
                  '</tr>';
            });
            $('#specsModalBody').html(
               '<div class="table-responsive">' +
               '<table class="table table-bordered table-striped align-middle mb-0">' +
                  '<thead class="table-dark">' +
                     '<tr><th>#</th><th>Name</th><th>Value</th></tr>' +
                  '</thead>' +
                  '<tbody>' + rows + '</tbody>' +
               '</table>' +
               '</div>'
            );
         } else {
            $('#specsModalBody').html(
               '<div class="text-center py-4 text-muted">' +
               '<i class="fas fa-inbox fa-3x mb-3 d-block"></i>No specifications found.' +
               '</div>'
            );
         }
      },
      error: function () {
         $('#specsModalBody').html(
            '<div class="alert alert-danger m-3">Failed to load specifications. Please try again.</div>'
         );
      }
   });
});


// ── Delete ─────────────────────────────────────────────────────
function deleteData(id) {
   confirmDelete(function () {
      $.ajax({
         url: "{{ route('admin.product.delete') }}",
         type: 'POST',
         data: { id: id, _token: "{{ csrf_token() }}" },
         success: function (response) {
            if (response.status) {
               showToast('success', response.message);
               $('#myTable').DataTable().ajax.reload(null, false);
            } else {
               showToast('error', response.message);
            }
         },
         error: function () {
            showToast('error', 'Something went wrong!');
         }
      });
   });
}
</script>
@endpush