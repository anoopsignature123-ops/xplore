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
            <div class="col-md-12">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-light border-bottom-0 py-3 d-flex justify-content-between align-items-center rounded-top">
                        <h3 class="mb-0 fw-bold text-primary">{{ $page_title }}</h3>
                        @can('product-list')
                        <a href="{{ route('admin.product.list') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-list"></i> List
                        </a>
                        @endcan
                    </div>
                    <div class="border-top"></div>
                    <div class="card-body p-4">
                        <form id="saveForm" class="theme-form row g-3" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id" value="{{ !empty($product) ? $product->id : '' }}">
                            @csrf

                            {{-- Product Name --}}
                            <div class="col-md-4">
                                <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="product_name" id="product_name"
                                    value="{{ !empty($product) ? $product->product_name : '' }}" required
                                    placeholder="Enter Product Name">
                                <span class="text-danger error-text" id="product_name-error"></span>
                            </div>

                            {{-- Category --}}
                            <div class="col-md-4">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select select2" name="product_category_id" required id="product_category_id">
                                    <option value="">-- Select Category --</option>
                                    @foreach($product_category_list as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ (!empty($product) && $product->product_category_id == $cat->id) ? 'selected' : '' }}>
                                            {{ $cat->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text" id="product_category_id-error"></span>
                            </div>

                            {{-- Sub Category (AJAX load) --}}
                            <div class="col-md-4">
                                <label class="form-label">Sub Category</label>
                                <select class="form-select select2" name="product_sub_category_id" required id="product_sub_category_id">
                                    <option value="">-- Select Sub Category --</option>
                                    @if(!empty($product) && !empty($product->product_sub_category_id))
                                        <option value="{{ $product->product_sub_category_id }}" selected>
                                            {{ $product->subCategory->sub_category_name ?? '' }}
                                        </option>
                                    @endif
                                </select>
                                <span class="text-danger error-text" id="product_sub_category_id-error"></span>
                            </div>

                            {{-- Brand (AJAX load) --}}
                            <div class="col-md-4">
                                <label class="form-label">Brand</label>
                                <select class="form-select select2" name="product_brand_id" id="product_brand_id">
                                    <option value="">-- Select Brand --</option>
                                    @if(!empty($product) && !empty($product->product_brand_id))
                                        <option value="{{ $product->product_brand_id }}" selected>
                                            {{ $product->brand->brand_name ?? '' }}
                                        </option>
                                    @endif
                                </select>
                                <span class="text-danger error-text" id="product_brand_id-error"></span>
                            </div>

                               {{-- Has Variants --}}
                            <div class="col-md-4">
                                <label class="form-label">Has Variants <span class="text-danger">*</span></label>
                                <select class="form-select select2" name="has_variants" id="has_variants">
                                    <option value="No"  {{ (!empty($product) && $product->has_variants == 'No')  ? 'selected' : '' }}>No</option>
                                    <option value="Yes" {{ (!empty($product) && $product->has_variants == 'Yes') ? 'selected' : '' }}>Yes</option>
                                </select>
                                <span class="text-danger error-text" id="has_variants-error"></span>
                            </div>
                            

                            {{-- Description --}}
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="3"
                                    placeholder="Enter Description">{{ !empty($product) ? $product->description : '' }}</textarea>
                                <span class="text-danger error-text" id="description-error"></span>
                            </div>

                         

                            {{-- No Variant Fields --}}
                            <div id="no_variant_section" class="col-md-12 row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">MRP Price <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" name="mrp_price" id="mrp_price"
                                        value="{{ !empty($product) ? $product->mrp_price : '' }}"
                                        placeholder="0.00">
                                    <span class="text-danger error-text" id="mrp_price-error"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Sale Price <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" name="sale_price" id="sale_price"
                                        value="{{ !empty($product) ? $product->sale_price : '' }}"
                                        placeholder="0.00">
                                    <span class="text-danger error-text" id="sale_price-error"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Stock <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="stock" id="stock"
                                        value="{{ !empty($product) ? $product->stock : '' }}"
                                        placeholder="0">
                                    <span class="text-danger error-text" id="stock-error"></span>
                                </div>
                            </div>

                            {{-- Variant Section --}}
                            <div id="variant_section" class="col-md-12" style="display:none;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label fw-bold mb-0">Variants</label>
                                    <button type="button" class="btn btn-sm btn-success" id="addVariantBtn">
                                        <i class="fas fa-plus"></i> Add Variant
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle" id="variantTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Variant Name <span class="text-danger">*</span></th>
                                                <th>MRP Price <span class="text-danger">*</span></th>
                                                <th>Sale Price <span class="text-danger">*</span></th>
                                                <th>Stock <span class="text-danger">*</span></th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="variantBody">
                                            {{-- Existing variants on edit --}}
                                            @if(!empty($product) && $product->has_variants == 'Yes' && $product->variants->count())
                                                @foreach($product->variants as $i => $variant)
                                                <tr>
                                                    <td>{{ $i + 1 }}</td>
                                                    <td>
                                                        <input type="hidden" name="variants[{{ $i }}][id]" value="{{ $variant->id }}">
                                                        <input type="text" class="form-control form-control-sm" name="variants[{{ $i }}][variant_name]" value="{{ $variant->variant_name }}" placeholder="Enter Variant Name">
                                                    </td>
                                                    <td><input type="number" step="0.01" class="form-control form-control-sm" name="variants[{{ $i }}][mrp_price]" value="{{ $variant->mrp_price }}" placeholder="Enter MRP Price "></td>
                                                    <td><input type="number" step="0.01" class="form-control form-control-sm" name="variants[{{ $i }}][sale_price]" value="{{ $variant->sale_price }}" placeholder="Enter Sale Price"></td>
                                                    <td><input type="number" class="form-control form-control-sm" name="variants[{{ $i }}][stock]" value="{{ $variant->stock }}" placeholder="Enter Stock"></td>
                                                    <td><button type="button" class="btn btn-sm btn-danger removeVariant"><i class="fas fa-trash-alt"></i></button></td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <span class="text-danger error-text" id="variants-error"></span>
                            </div>

                           {{-- Product Specifications --}}
                           <div class="col-md-12">
                              <div class="d-flex justify-content-between align-items-center mb-2">
                                 <label class="form-label fw-bold mb-0">Product Specifications</label>
                                 <button type="button" class="btn btn-sm btn-success" id="addSpecBtn">
                                       <i class="fas fa-plus"></i> Add Specification
                                 </button>
                              </div>
                              <div class="table-responsive">
                                 <table class="table table-bordered align-middle" id="specTable">
                                       <thead class="table-light">
                                          <tr>
                                             <th width="40">#</th>
                                             <th>Name <span class="text-danger">*</span></th>
                                             <th>Value <span class="text-danger">*</span></th>
                                             <th width="80">Action</th>
                                          </tr>
                                       </thead>
                                       <tbody id="specBody">
                                          {{-- Existing specs on edit --}}
                                          @if(!empty($product) && $product->specifications->count())
                                             @foreach($product->specifications as $si => $spec)
                                             <tr>
                                                   <td class="spec-num">{{ $si + 1 }}</td>
                                                   <td>
                                                      <input type="hidden" name="specifications[{{ $si }}][id]" value="{{ $spec->id }}">
                                                      <input type="text" class="form-control form-control-sm"
                                                         name="specifications[{{ $si }}][name]"
                                                         value="{{ $spec->name }}" placeholder="Enter Name">
                                                   </td>
                                                   <td>
                                                      <input type="text" class="form-control form-control-sm"
                                                         name="specifications[{{ $si }}][value]"
                                                         value="{{ $spec->value }}" placeholder="Enter Value">
                                                   </td>
                                                   <td>
                                                      <button type="button" class="btn btn-sm btn-danger removeSpec">
                                                         <i class="fas fa-trash-alt"></i>
                                                      </button>
                                                   </td>
                                             </tr>
                                             @endforeach
                                          @else
                                             {{-- default one empty row --}}
                                             <tr>
                                                   <td class="spec-num">1</td>
                                                   <td>
                                                      <input type="hidden" name="specifications[0][id]" value="">
                                                      <input type="text" class="form-control form-control-sm"
                                                         name="specifications[0][name]" placeholder="Enter Name">
                                                   </td>
                                                   <td>
                                                      <input type="text" class="form-control form-control-sm"
                                                         name="specifications[0][value]" placeholder="Enter Value">
                                                   </td>
                                                   <td>
                                                      <button type="button" class="btn btn-sm btn-danger removeSpec">
                                                         <i class="fas fa-trash-alt"></i>
                                                      </button>
                                                   </td>
                                             </tr>
                                          @endif
                                       </tbody>
                                 </table>
                              </div>
                              <span class="text-danger error-text" id="specifications-error"></span>
                           </div>


                            {{-- Image --}}
                            <div class="col-md-4">
                                <label class="form-label">Image {{ empty($product) ? '<span class="text-danger">*</span>' : '' }}</label>
                                <input type="file" class="form-control" id="image" name="image"
                                    {{ empty($product) ? 'required' : '' }}
                                    accept=".jpg,.jpeg,.png"
                                    onchange="previewImage(this,'imagePreview')">
                                <div class="mt-2">
                                    <a href="{{ !empty($product) && !empty($product->image) ? asset($product->image) : '#' }}" target="_blank">
                                        <img id="imagePreview"
                                            src="{{ !empty($product) && !empty($product->image) ? asset($product->image) : '' }}"
                                            class="img-thumbnail border rounded shadow-sm p-1"
                                            style="max-height:100px; {{ (empty($product) || empty($product->image)) ? 'display:none;' : '' }}">
                                    </a>
                                </div>
                                <span class="text-danger error-text" id="image-error"></span>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-4">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select select2" name="status" id="status">
                                    <option value="Active"   {{ (!empty($product) && $product->status == 'Active')   ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ (!empty($product) && $product->status == 'Inactive') ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <span class="text-danger error-text" id="status-error"></span>
                            </div>

                            {{-- Buttons --}}
                            <div class="col-12 text-start mt-3">
                                <button type="reset" id="resetBtn" class="btn btn-sm btn-secondary">
                                    <i class="fa-solid fa-rotate-left"></i> Reset
                                </button>
                                <button type="submit" id="submitBtn" class="btn btn-sm btn-primary ms-2">
                                    <i class="fas fa-save"></i> {{ $btn_title }}
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {

   // ── Specifications ─────────────────────────────────────
let specIndex = $('#specBody tr').length;   // start after existing rows

$('#addSpecBtn').on('click', function () {
    addSpecRow();
});

$(document).on('click', '.removeSpec', function () {
    // keep at least one row
    if ($('#specBody tr').length === 1) {
        // just clear the fields instead of removing
        $(this).closest('tr').find('input[type="text"]').val('');
        $(this).closest('tr').find('input[type="hidden"]').val('');
        return;
    }
    $(this).closest('tr').remove();
    reIndexSpecs();
});

function addSpecRow() {
    let i = specIndex++;
    let row = `
        <tr>
            <td class="spec-num">${$('#specBody tr').length + 1}</td>
            <td>
                <input type="hidden" name="specifications[${i}][id]" value="">
                <input type="text" class="form-control form-control-sm"
                    name="specifications[${i}][name]" placeholder="Enter Name">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm"
                    name="specifications[${i}][value]" placeholder="Enter Value">
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger removeSpec">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>
        </tr>`;
    $('#specBody').append(row);
}

function reIndexSpecs() {
    $('#specBody tr').each(function (i, row) {
        $(row).find('.spec-num').text(i + 1);
        $(row).find('input').each(function () {
            let name = $(this).attr('name');
            if (name) {
                $(this).attr('name', name.replace(/specifications\[\d+\]/, 'specifications[' + i + ']'));
            }
        });
    });
    specIndex = $('#specBody tr').length;
}


    // ── On page load: show/hide sections ──────────────────
    toggleVariantSection($('#has_variants').val());

    // ── On page load edit case: load sub cat & brand ──────
    let initialCatId = $('#product_category_id').val();
    if (initialCatId) {
        loadSubCategories(initialCatId, "{{ !empty($product) ? $product->product_sub_category_id : '' }}");
        loadBrands(initialCatId, "{{ !empty($product) ? $product->product_brand_id : '' }}");
    }

    // ── Category change → load sub cat & brand ────────────
    $('#product_category_id').on('change', function () {
        let catId = $(this).val();
        loadSubCategories(catId, null);
        loadBrands(catId, null);
    });

    // ── Has Variants toggle ────────────────────────────────
    $('#has_variants').on('change', function () {
        toggleVariantSection($(this).val());
    });

    // ── Add Variant Row ────────────────────────────────────
    $('#addVariantBtn').on('click', function () {
        addVariantRow();
    });

    // ── Remove Variant Row ─────────────────────────────────
    $(document).on('click', '.removeVariant', function () {
        $(this).closest('tr').remove();
        reIndexVariants();
    });

    // ── Form Submit ────────────────────────────────────────
    $('#saveForm').on('submit', function (e) {
        e.preventDefault();
        $('.error-text').text('');
        syncEditors();
        let form    = $('#saveForm')[0];
        let formData = new FormData(form);

        $.ajax({
            url: '{{ route("admin.product.save") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,

            beforeSend: function () {
                $('#submitBtn').prop('disabled', true).html('Processing...');
            },

            success: function (response) {
                toastr.success(response.message || 'Record Saved Successfully!');
                if (response.success) {
                    setTimeout(function () { location.reload(); }, 1000);
                }
            },

            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function (key, val) {
                            $('#' + key.replace(/\./g, '_').replace(/\[|\]/g, '_') + '-error').text(val[0]);
                        });
                    }
                    let message = xhr.responseJSON?.message;
                    if (message) toastr.error(message);
                } else {
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                }
            },

            complete: function () {
                $('#submitBtn').prop('disabled', false).html('<i class="fas fa-save"></i> {{ $btn_title }}');
            }
        });
    });

    // ── Functions ──────────────────────────────────────────

    function toggleVariantSection(val) {
        if (val === 'Yes') {
            $('#variant_section').show();
            $('#no_variant_section').hide();
            // Add one row if table is empty
            if ($('#variantBody tr').length === 0) {
                addVariantRow();
            }
        } else {
            $('#variant_section').hide();
            $('#no_variant_section').show();
        }
    }

    let variantIndex = $('#variantBody tr').length;

    function addVariantRow() {
        let i = variantIndex++;
        let row = `
            <tr>
                <td class="row-num">${$('#variantBody tr').length + 1}</td>
                <td>
                    <input type="hidden" name="variants[${i}][id]" value="">
                    <input type="text" class="form-control form-control-sm" name="variants[${i}][variant_name]" placeholder="Enter Variant Name">
                </td>
                <td><input type="number" step="0.01" class="form-control form-control-sm" name="variants[${i}][mrp_price]" placeholder="Enter MRP Price"></td>
                <td><input type="number" step="0.01" class="form-control form-control-sm" name="variants[${i}][sale_price]" placeholder="Enter Sale Price"></td>
                <td><input type="number" class="form-control form-control-sm" name="variants[${i}][stock]" placeholder="Enter Stock"></td>
                <td><button type="button" class="btn btn-sm btn-danger removeVariant"><i class="fas fa-trash-alt"></i></button></td>
            </tr>`;
        $('#variantBody').append(row);
    }

    function reIndexVariants() {
        $('#variantBody tr').each(function (i, row) {
            $(row).find('.row-num').text(i + 1);
            $(row).find('input, select').each(function () {
                let name = $(this).attr('name');
                if (name) {
                    $(this).attr('name', name.replace(/variants\[\d+\]/, 'variants[' + i + ']'));
                }
            });
        });
        variantIndex = $('#variantBody tr').length;
    }

    function loadSubCategories(catId, selectedId) {
        $('#product_sub_category_id').html('<option value="">-- Select Sub Category --</option>');
        if (!catId) return;
        $.ajax({
            url: '{{ route("admin.get-sub-categories") }}',
            type: 'GET',
            data: { product_category_id: catId },
            success: function (data) {
                $.each(data, function (i, item) {
                    let selected = selectedId && selectedId == item.id ? 'selected' : '';
                    $('#product_sub_category_id').append(`<option value="${item.id}" ${selected}>${item.sub_category_name}</option>`);
                });
                $('#product_sub_category_id').trigger('change.select2');
            }
        });
    }

    function loadBrands(catId, selectedId) {
        $('#product_brand_id').html('<option value="">-- Select Brand --</option>');
        if (!catId) return;
        $.ajax({
            url: '{{ route("admin.get-brands") }}',
            type: 'GET',
            data: { product_category_id: catId },
            success: function (data) {
                $.each(data, function (i, item) {
                    let selected = selectedId && selectedId == item.id ? 'selected' : '';
                    $('#product_brand_id').append(`<option value="${item.id}" ${selected}>${item.brand_name}</option>`);
                });
                $('#product_brand_id').trigger('change.select2');
            }
        });
    }

});
</script>
@endpush