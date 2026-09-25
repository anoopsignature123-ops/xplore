@extends('admin.includes.layout')
@section('title', $page_title)
@section('content')
<div class="page-body">
   <div class="container-fluid">
      <div class="page-title">
         <div class="row">
            <div class="col-sm-6 col-12">
               <h4 class="m-0">{{ $page_title }}</h4>
            </div>
            <div class="col-sm-6 col-12">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="fa-solid fa-home me-2"></i></a></li>
                  <li class="breadcrumb-item"><a href="{{ route('admin.equipment.list') }}">Equipment List</a></li>
                  <li class="breadcrumb-item active">{{ $page_title }}</li>
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
                  <h5 class="mb-0 fw-bold text-primary">{{ $page_title }}</h5>
                  <a href="{{ route('admin.equipment.list') }}" class="btn btn-secondary btn-sm">
                     <i class="fas fa-arrow-left me-1"></i> Back
                  </a>
               </div>
               <div class="card-body">
                  <form action="{{ route('admin.equipment.save') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <input type="hidden" name="id" value="{{ $equipment->id ?? '' }}">

                     <div class="row g-3">
                        <div class="col-md-6">
                           <label class="form-label fw-bold">Equipment Name <span class="text-danger">*</span></label>
                           <input type="text" name="name" class="form-control" value="{{ old('name', $equipment->name ?? '') }}" placeholder="e.g. Total Station" required>
                        </div>
                        <div class="col-md-6">
                           <label class="form-label fw-bold">Brand</label>
                           <input type="text" name="brand" class="form-control" value="{{ old('brand', $equipment->brand ?? '') }}" placeholder="e.g. Leica">
                        </div>

                        <div class="col-md-4">
                           <label class="form-label fw-bold">Model</label>
                           <input type="text" name="model" class="form-control" value="{{ old('model', $equipment->model ?? '') }}" placeholder="e.g. TS16">
                        </div>
                        <div class="col-md-4">
                           <label class="form-label fw-bold">Accuracy</label>
                           <input type="text" name="accuracy" class="form-control" value="{{ old('accuracy', $equipment->accuracy ?? '') }}" placeholder="e.g. ± 2 mm">
                        </div>
                        <div class="col-md-4">
                           <label class="form-label fw-bold">Availability Status <span class="text-danger">*</span></label>
                           <select name="availability_status" class="form-select" required>
                              <option value="in_stock" {{ old('availability_status', $equipment->availability_status ?? '') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                              <option value="out_of_stock" {{ old('availability_status', $equipment->availability_status ?? '') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                              <option value="maintenance" {{ old('availability_status', $equipment->availability_status ?? '') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                           </select>
                        </div>

                        <div class="col-md-3">
                           <label class="form-label fw-bold">Daily Rate (₹) <span class="text-danger">*</span></label>
                           <input type="number" step="0.01" name="daily_rate" class="form-control" value="{{ old('daily_rate', $equipment->daily_rate ?? '') }}" placeholder="1500" required>
                        </div>
                        <div class="col-md-3">
                           <label class="form-label fw-bold">Weekly Rate (₹)</label>
                           <input type="number" step="0.01" name="weekly_rate" class="form-control" value="{{ old('weekly_rate', $equipment->weekly_rate ?? '') }}" placeholder="8500">
                        </div>
                        <div class="col-md-3">
                           <label class="form-label fw-bold">Monthly Rate (₹)</label>
                           <input type="number" step="0.01" name="monthly_rate" class="form-control" value="{{ old('monthly_rate', $equipment->monthly_rate ?? '') }}" placeholder="28000">
                        </div>
                        <div class="col-md-3">
                           <label class="form-label fw-bold">Security Deposit (₹) <span class="text-danger">*</span></label>
                           <input type="number" step="0.01" name="security_deposit" class="form-control" value="{{ old('security_deposit', $equipment->security_deposit ?? '') }}" placeholder="5000" required>
                        </div>

                        <div class="col-md-4">
                           <label class="form-label fw-bold">GST (%) <span class="text-danger">*</span></label>
                           <input type="number" step="0.01" name="gst_percentage" class="form-control" value="{{ old('gst_percentage', $equipment->gst_percentage ?? 18) }}" required>
                        </div>

                        <div class="col-md-4">
                           <label class="form-label fw-bold">Equipment Image {{ isset($equipment) ? '' : '*' }}</label>
                           <input type="file" name="image" class="form-control" accept="image/*" {{ isset($equipment) ? '' : 'required' }}>
                           @if(!empty($equipment->image))
                              <div class="mt-2">
                                 <img src="{{ asset($equipment->image) }}" alt="Preview" style="height: 60px; border-radius: 4px;">
                              </div>
                           @endif
                        </div>

                        <div class="col-md-4 d-flex align-items-center gap-4 mt-4">
                           <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" name="is_popular" id="is_popular" value="1" {{ old('is_popular', $equipment->is_popular ?? false) ? 'checked' : '' }}>
                              <label class="form-check-label fw-bold" for="is_popular">Mark as Popular</label>
                           </div>
                           <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ old('status', $equipment->status ?? true) ? 'checked' : '' }}>
                              <label class="form-check-label fw-bold" for="status">Active</label>
                           </div>
                        </div>

                        <div class="col-12">
                           <label class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                           <textarea name="description" class="form-control" rows="4" placeholder="Electronic surveying instrument used for measuring angles and distances..." required>{{ old('description', $equipment->description ?? '') }}</textarea>
                        </div>

                        <!-- Specifications Section -->
                        <div class="col-12 mt-4">
                           <h6 class="fw-bold text-dark border-bottom pb-2">Custom Specifications</h6>
                           <div id="specs-container">
                              @if(isset($equipment) && count($equipment->specifications) > 0)
                                 @foreach($equipment->specifications as $spec)
                                    <div class="row g-2 mb-2 spec-row">
                                       <div class="col-md-5">
                                          <input type="text" name="spec_keys[]" class="form-control" value="{{ $spec->spec_key }}" placeholder="Specification Name (e.g. Weight)">
                                       </div>
                                       <div class="col-md-5">
                                          <input type="text" name="spec_values[]" class="form-control" value="{{ $spec->spec_value }}" placeholder="Specification Value (e.g. 5.2 kg)">
                                       </div>
                                       <div class="col-md-2">
                                          <button type="button" class="btn btn-danger btn-remove-spec"><i class="fas fa-trash"></i></button>
                                       </div>
                                    </div>
                                 @endforeach
                              @else
                                 <div class="row g-2 mb-2 spec-row">
                                    <div class="col-md-5">
                                       <input type="text" name="spec_keys[]" class="form-control" placeholder="Specification Name (e.g. Weight)">
                                    </div>
                                    <div class="col-md-5">
                                       <input type="text" name="spec_values[]" class="form-control" placeholder="Specification Value (e.g. 5.2 kg)">
                                    </div>
                                    <div class="col-md-2">
                                       <button type="button" class="btn btn-danger btn-remove-spec"><i class="fas fa-trash"></i></button>
                                    </div>
                                 </div>
                              @endif
                           </div>
                           <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="btn-add-spec">
                              <i class="fas fa-plus me-1"></i> Add Specification Field
                           </button>
                        </div>

                        <div class="col-12 text-end mt-4">
                           <button type="submit" class="btn btn-primary px-4">{{ $btn_title }}</button>
                        </div>
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
$(document).ready(function() {
    $('#btn-add-spec').click(function() {
        var specHtml = `
            <div class="row g-2 mb-2 spec-row">
               <div class="col-md-5">
                  <input type="text" name="spec_keys[]" class="form-control" placeholder="Specification Name (e.g. Weight)">
               </div>
               <div class="col-md-5">
                  <input type="text" name="spec_values[]" class="form-control" placeholder="Specification Value (e.g. 5.2 kg)">
               </div>
               <div class="col-md-2">
                  <button type="button" class="btn btn-danger btn-remove-spec"><i class="fas fa-trash"></i></button>
               </div>
            </div>
        `;
        $('#specs-container').append(specHtml);
    });

    $(document).on('click', '.btn-remove-spec', function() {
        if ($('.spec-row').length > 1) {
            $(this).closest('.spec-row').remove();
        } else {
            $(this).closest('.spec-row').find('input').val('');
        }
    });
});
</script>
@endpush
