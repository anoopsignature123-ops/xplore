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
                  <li class="breadcrumb-item"><a href="{{ route('admin.builder-service-type.list') }}">Service Types</a></li>
                  <li class="breadcrumb-item active">{{ $page_title }}</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <div class="container-fluid">
      <div class="row justify-content-center">
         <div class="col-lg-7">
            <div class="card shadow-lg border-0 rounded-3">
               <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                  <h5 class="mb-0 fw-bold text-primary">
                     <i class="fas fa-tools me-2"></i>{{ $page_title }}
                  </h5>
                  <a href="{{ route('admin.builder-service-type.list') }}" class="btn btn-secondary btn-sm">
                     <i class="fas fa-arrow-left me-1"></i> Back
                  </a>
               </div>
               <div class="card-body p-4">
                  @if ($errors->any())
                     <div class="alert alert-danger">
                        <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                     </div>
                  @endif

                  <form action="{{ route('admin.builder-service-type.save') }}" method="POST">
                     @csrf
                     <input type="hidden" name="id" value="{{ $type->id ?? '' }}">

                     <div class="row g-3">
                        <div class="col-md-8">
                           <label class="form-label fw-bold">Service Type Name <span class="text-danger">*</span></label>
                           <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                              value="{{ old('name', $type->name ?? '') }}"
                              placeholder="e.g. Civil Construction, Interior Design, Architecture" required>
                           @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                           <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                           <select name="status" class="form-select @error('status') is-invalid @enderror">
                              <option value="1" {{ old('status', $type->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                              <option value="0" {{ old('status', $type->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
                           </select>
                        </div>

                        <div class="col-12">
                           <label class="form-label fw-bold">Font Awesome Icon Class <span class="text-muted fw-normal small">(Optional)</span></label>
                           <div class="input-group">
                              <span class="input-group-text" id="icon-preview"><i class="fas fa-hammer"></i></span>
                              <input type="text" name="icon" id="icon-input" class="form-control"
                                 value="{{ old('icon', $type->icon ?? '') }}"
                                 placeholder="fa-hard-hat, fa-drafting-compass, fa-paint-roller ...">
                           </div>
                           <div class="form-text text-muted">
                              Use any <a href="https://fontawesome.com/icons" target="_blank">Font Awesome 5</a> icon class name (without "fa fa-" prefix — just the icon name part, e.g. <code>fa-hard-hat</code>).
                           </div>
                        </div>

                        <!-- Icon Quick Picks -->
                        <div class="col-12">
                           <label class="form-label fw-semibold small text-muted">Quick Pick Icons:</label>
                           <div class="d-flex flex-wrap gap-2">
                              @php
                                $quickIcons = [
                                   'fa-hard-hat' => 'Construction', 'fa-drafting-compass' => 'Architecture',
                                   'fa-paint-roller' => 'Interior', 'fa-wrench' => 'Plumbing/Repair',
                                   'fa-bolt' => 'Electrical', 'fa-fire' => 'Fire Safety',
                                   'fa-tree' => 'Landscaping', 'fa-road' => 'Civil Work',
                                   'fa-building' => 'Commercial', 'fa-home' => 'Residential',
                                   'fa-warehouse' => 'Industrial', 'fa-tools' => 'General',
                                ];
                              @endphp
                              @foreach($quickIcons as $iconClass => $iconLabel)
                                 <button type="button" class="btn btn-outline-secondary btn-sm pick-icon"
                                    data-icon="{{ $iconClass }}" title="{{ $iconLabel }}">
                                    <i class="fas {{ $iconClass }} me-1"></i>{{ $iconLabel }}
                                 </button>
                              @endforeach
                           </div>
                        </div>

                        <div class="col-12 text-end mt-2">
                           <a href="{{ route('admin.builder-service-type.list') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                           <button type="submit" class="btn btn-primary px-4">
                              <i class="fas fa-save me-1"></i> {{ $btn_title }}
                           </button>
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
$(document).ready(function () {
    // Live icon preview
    $('#icon-input').on('input', function () {
        var val = $(this).val().trim();
        if (val) {
            $('#icon-preview i').attr('class', 'fas ' + val);
        } else {
            $('#icon-preview i').attr('class', 'fas fa-hammer');
        }
    });

    // Quick pick icons
    $('.pick-icon').on('click', function () {
        var icon = $(this).data('icon');
        $('#icon-input').val(icon).trigger('input');
    });
});
</script>
@endpush
