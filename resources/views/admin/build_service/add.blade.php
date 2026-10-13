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
                  <li class="breadcrumb-item"><a href="{{ route('admin.build-service.list') }}">Build Services</a></li>
                  <li class="breadcrumb-item active">{{ $page_title }}</li>
               </ol>
            </div>
         </div>
      </div>
   </div>

   <div class="container-fluid">
      <form method="POST" action="{{ route('admin.build-service.save') }}">
         @csrf
         @if($service) <input type="hidden" name="id" value="{{ $service->id }}"> @endif

         @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
               <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
               <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
         @endif

         <div class="row g-4">

            {{-- ── LEFT COLUMN ─────────────────────────────── --}}
            <div class="col-lg-8">

               {{-- Basic Info --}}
               <div class="card border-0 shadow-sm mb-4">
                  <div class="card-header bg-primary text-white py-3">
                     <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                  </div>
                  <div class="card-body">

                     <div class="row g-3">
                        <div class="col-md-6">
                           <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                           <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                              <option value="">— Select Category —</option>
                              @foreach($categories as $cat)
                                 <option value="{{ $cat->id }}" {{ old('category_id', $service?->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                 </option>
                              @endforeach
                           </select>
                           @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                           <label class="form-label fw-semibold">Duration <small class="text-muted">(e.g. 2-3 Days)</small></label>
                           <input type="text" name="duration" class="form-control" placeholder="6-9 Months"
                              value="{{ old('duration', $service?->duration) }}">
                        </div>

                        <div class="col-12">
                           <label class="form-label fw-semibold">Service Title <span class="text-danger">*</span></label>
                           <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" required
                              placeholder="e.g. Complete 2D House Planning & Layout"
                              value="{{ old('title', $service?->title) }}">
                           @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                           <label class="form-label fw-semibold">Short Description <small class="text-muted">(shown in listing card)</small></label>
                           <textarea name="short_desc" class="form-control" rows="2"
                              placeholder="Custom Vastu-compliant architectural floor plans & working drawings.">{{ old('short_desc', $service?->short_desc) }}</textarea>
                        </div>

                        <div class="col-md-4">
                           <label class="form-label fw-semibold">Price <span class="text-danger">*</span></label>
                           <div class="input-group">
                              <span class="input-group-text">₹</span>
                              <input type="number" name="price" class="form-control" step="0.01" min="0" required
                                 placeholder="2499" value="{{ old('price', $service?->price) }}">
                           </div>
                        </div>

                        <div class="col-md-4">
                           <label class="form-label fw-semibold">Price Type <span class="text-danger">*</span></label>
                           <select name="price_type" class="form-select" required>
                              <option value="fixed" {{ old('price_type', $service?->price_type) == 'fixed' ? 'selected' : '' }}>Fixed</option>
                              <option value="per_sqft" {{ old('price_type', $service?->price_type) == 'per_sqft' ? 'selected' : '' }}>Per Sq.ft</option>
                              <option value="per_unit" {{ old('price_type', $service?->price_type) == 'per_unit' ? 'selected' : '' }}>Per Unit</option>
                           </select>
                        </div>

                        <div class="col-md-4">
                           <label class="form-label fw-semibold">Sort Order</label>
                           <input type="number" name="sort_order" class="form-control" min="0"
                              value="{{ old('sort_order', $service?->sort_order ?? 0) }}">
                        </div>

                        <div class="col-12">
                           <label class="form-label fw-semibold">Feature Tags
                              <small class="text-muted">(comma-separated e.g. Vastu Compliant, 2 Revisions Included)</small>
                           </label>
                           <input type="text" name="tags" class="form-control"
                              placeholder="Vastu Compliant, 2 Revisions Included, CAD DWG File"
                              value="{{ old('tags', $service ? implode(', ', $service->tags ?? []) : '') }}">
                        </div>
                     </div>

                  </div>
               </div>

               {{-- Detail Content --}}
               <div class="card border-0 shadow-sm mb-4">
                  <div class="card-header bg-info text-white py-3">
                     <h5 class="mb-0"><i class="fas fa-align-left me-2"></i>Service Detail Content</h5>
                  </div>
                  <div class="card-body">

                     <div class="mb-3">
                        <label class="form-label fw-semibold">Overview</label>
                        <textarea name="overview" class="form-control" rows="5"
                           placeholder="Detailed description shown on the service detail page...">{{ old('overview', $service?->overview) }}</textarea>
                     </div>

                     <div class="mb-3">
                        <label class="form-label fw-semibold">
                           Deliverables (What You Will Receive)
                           <small class="text-muted">— one item per line</small>
                        </label>
                        <textarea name="deliverables" class="form-control" rows="5"
                           placeholder="Foundation, RCC Framework, Brick Masonry & Plastering&#10;Branded Steel (Fe 550D) & Grade 43/53 Portland Cement&#10;...">{{ old('deliverables', $service ? implode("\n", $service->deliverables ?? []) : '') }}</textarea>
                     </div>

                     <div class="mb-3">
                        <label class="form-label fw-semibold">
                           What You Will Get (⭐ bullets)
                           <small class="text-muted">— one item per line</small>
                        </label>
                        <textarea name="what_you_get" class="form-control" rows="4"
                           placeholder="Dedicated Civil Engineer on-site daily&#10;Weekly progress video & photo updates via app&#10;5-Year warranty against structural defects">{{ old('what_you_get', $service ? implode("\n", $service->what_you_get ?? []) : '') }}</textarea>
                     </div>

                     <div class="mb-0">
                        <label class="form-label fw-semibold">
                           Execution Steps
                           <small class="text-muted">— format: <code>Step Title | Step Description</code> (one per line)</small>
                        </label>
                        <textarea name="execution_steps" class="form-control" rows="4"
                           placeholder="Site Inspection & Soil Check | Admin assigns a vetted civil contractor who visits the plot.&#10;BOQ & Milestone Contract | Receive a transparent Bill of Quantities with zero hidden charges.">{{ old('execution_steps', $service ? collect($service->execution_steps ?? [])->map(fn($s) => ($s['title'] ?? '') . ' | ' . ($s['description'] ?? ''))->implode("\n") : '') }}</textarea>
                     </div>

                  </div>
               </div>

               {{-- FAQs --}}
               <div class="card border-0 shadow-sm mb-4">
                  <div class="card-header bg-warning text-dark py-3 d-flex justify-content-between align-items-center">
                     <h5 class="mb-0"><i class="fas fa-question-circle me-2"></i>FAQs</h5>
                     <button type="button" class="btn btn-dark btn-sm" id="add-faq-btn">
                        <i class="fas fa-plus me-1"></i> Add FAQ
                     </button>
                  </div>
                  <div class="card-body">
                     <div id="faq-container">
                        @if($service && $service->faqs->count())
                           @foreach($service->faqs as $faq)
                              <div class="faq-row border rounded p-3 mb-3 bg-light">
                                 <div class="mb-2">
                                    <label class="form-label fw-semibold small">Question</label>
                                    <input type="text" name="faq_question[]" class="form-control"
                                       value="{{ $faq->question }}" placeholder="How does milestone payment work?">
                                 </div>
                                 <div>
                                    <label class="form-label fw-semibold small">Answer</label>
                                    <textarea name="faq_answer[]" class="form-control" rows="2"
                                       placeholder="Answer...">{{ $faq->answer }}</textarea>
                                 </div>
                                 <div class="mt-2 text-end">
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-faq">
                                       <i class="fas fa-trash-alt me-1"></i>Remove
                                    </button>
                                 </div>
                              </div>
                           @endforeach
                        @else
                           <p class="text-muted text-center py-3 mb-0" id="faq-empty">
                              <i class="fas fa-info-circle me-1"></i>No FAQs added. Click "Add FAQ" to add.
                           </p>
                        @endif
                     </div>
                  </div>
               </div>

            </div>

            {{-- ── RIGHT COLUMN ─────────────────────────────── --}}
            <div class="col-lg-4">

               {{-- Rating & Status --}}
               <div class="card border-0 shadow-sm mb-4">
                  <div class="card-header bg-success text-white py-3">
                     <h5 class="mb-0"><i class="fas fa-star me-2"></i>Rating & Status</h5>
                  </div>
                  <div class="card-body">
                     <div class="mb-3">
                        <label class="form-label fw-semibold">Rating <small class="text-muted">(1.0 – 5.0)</small></label>
                        <input type="number" name="rating" class="form-control" step="0.1" min="1" max="5"
                           value="{{ old('rating', $service?->rating ?? 4.5) }}">
                     </div>
                     <div class="mb-3">
                        <label class="form-label fw-semibold">Total Reviews</label>
                        <input type="number" name="total_reviews" class="form-control" min="0"
                           value="{{ old('total_reviews', $service?->total_reviews ?? 0) }}">
                     </div>
                     <div class="mb-0">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                           <option value="1" {{ old('status', $service?->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                           <option value="0" {{ old('status', $service?->status) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                     </div>
                  </div>
               </div>

               {{-- Help Card --}}
               <div class="card border-0 shadow-sm bg-primary-subtle">
                  <div class="card-body">
                     <h6 class="fw-bold text-primary mb-3"><i class="fas fa-lightbulb me-2"></i>Field Guide</h6>
                     <ul class="list-unstyled small text-muted mb-0">
                        <li class="mb-2"><strong>Tags:</strong> Comma-separated chips shown below service title on listing card.</li>
                        <li class="mb-2"><strong>Deliverables:</strong> ✅ Checkmark list in "What You Will Receive" section.</li>
                        <li class="mb-2"><strong>What You Get:</strong> ⭐ Star bullets in the detail page.</li>
                        <li class="mb-2"><strong>Execution Steps:</strong> Use <code>Title | Description</code> format per line.</li>
                        <li><strong>Sort Order:</strong> Lower number = shown first in the app.</li>
                     </ul>
                  </div>
               </div>

            </div>

         </div>

         {{-- Submit Buttons --}}
         <div class="row mt-2 mb-5">
            <div class="col-12">
               <button type="submit" class="btn btn-primary px-5 me-2">
                  <i class="fas fa-save me-2"></i>{{ $btn_title }} Service
               </button>
               <a href="{{ route('admin.build-service.list') }}" class="btn btn-secondary px-4">
                  <i class="fas fa-times me-2"></i>Cancel
               </a>
            </div>
         </div>

      </form>
   </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {

   var faqTemplate = `
      <div class="faq-row border rounded p-3 mb-3 bg-light">
         <div class="mb-2">
            <label class="form-label fw-semibold small">Question</label>
            <input type="text" name="faq_question[]" class="form-control" placeholder="e.g. How does milestone payment work?">
         </div>
         <div>
            <label class="form-label fw-semibold small">Answer</label>
            <textarea name="faq_answer[]" class="form-control" rows="2" placeholder="Detailed answer..."></textarea>
         </div>
         <div class="mt-2 text-end">
            <button type="button" class="btn btn-outline-danger btn-sm remove-faq">
               <i class="fas fa-trash-alt me-1"></i>Remove
            </button>
         </div>
      </div>`;

   $('#add-faq-btn').on('click', function() {
      $('#faq-empty').hide();
      $('#faq-container').append(faqTemplate);
   });

   $(document).on('click', '.remove-faq', function() {
      $(this).closest('.faq-row').remove();
      if ($('.faq-row').length === 0) $('#faq-empty').show();
   });

});
</script>
@endpush
