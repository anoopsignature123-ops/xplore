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
                  <li class="breadcrumb-item"><a href="{{ route('admin.builder.list') }}">Builders</a></li>
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
                  <a href="{{ route('admin.builder.list') }}" class="btn btn-secondary btn-sm">
                     <i class="fas fa-arrow-left me-1"></i> Back
                  </a>
               </div>
               <div class="card-body">
                  <form action="{{ route('admin.builder.save') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <input type="hidden" name="id" value="{{ $builder->id ?? '' }}">

                     <div class="row g-3">
                        <div class="col-md-6">
                           <label class="form-label fw-bold">Firm / Company Name <span class="text-danger">*</span></label>
                           <input type="text" name="firm_name" class="form-control" value="{{ old('firm_name', $builder->firm_name ?? '') }}" placeholder="e.g. Skyline Architects" required>
                        </div>
                        <div class="col-md-6">
                           <label class="form-label fw-bold">Contact Person Name <span class="text-danger">*</span></label>
                           <input type="text" name="name" class="form-control" value="{{ old('name', $builder->name ?? '') }}" placeholder="e.g. Rahul Mehta" required>
                        </div>

                        <div class="col-md-4">
                           <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                           <select name="category_id" class="form-select" required>
                              <option value="">Select Category</option>
                              @foreach($categories as $cat)
                                 <option value="{{ $cat->id }}" {{ old('category_id', $builder->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                              @endforeach
                           </select>
                        </div>
                        <div class="col-md-4">
                           <label class="form-label fw-bold">Email (Portal Login) <span class="text-danger">*</span></label>
                           <input type="email" name="email" class="form-control" value="{{ old('email', $builder->email ?? '') }}" placeholder="info@skylinearchitects.com" required>
                        </div>
                        <div class="col-md-4">
                           <label class="form-label fw-bold">Phone Number <span class="text-danger">*</span></label>
                           <input type="text" name="phone" class="form-control" value="{{ old('phone', $builder->phone ?? '') }}" placeholder="+91 9876543210" required>
                        </div>

                        <div class="col-md-4">
                           <label class="form-label fw-bold">Password {{ isset($builder) ? '(Leave blank to keep unchanged)' : '*' }}</label>
                           <input type="password" name="password" class="form-control" placeholder="••••••••" {{ isset($builder) ? '' : 'required' }}>
                        </div>
                        <div class="col-md-4">
                           <label class="form-label fw-bold">Location / City <span class="text-danger">*</span></label>
                           <input type="text" name="location" class="form-control" value="{{ old('location', $builder->location ?? '') }}" placeholder="e.g. Lucknow, Delhi" required>
                        </div>
                        <div class="col-md-4">
                           <label class="form-label fw-bold">Website</label>
                           <input type="text" name="website" class="form-control" value="{{ old('website', $builder->website ?? '') }}" placeholder="www.skylinearchitects.com">
                        </div>

                        <div class="col-md-4">
                           <label class="form-label fw-bold">Experience (Years)</label>
                           <input type="number" name="experience_years" class="form-control" value="{{ old('experience_years', $builder->experience_years ?? 0) }}" placeholder="12">
                        </div>
                        <div class="col-md-4">
                           <label class="form-label fw-bold">Completed Projects Count</label>
                           <input type="number" name="projects_count" class="form-control" value="{{ old('projects_count', $builder->projects_count ?? 0) }}" placeholder="120">
                        </div>
                        <div class="col-md-4">
                           <label class="form-label fw-bold">Rating (⭐ 1-5)</label>
                           <input type="number" step="0.1" name="rating" class="form-control" value="{{ old('rating', $builder->rating ?? 4.8) }}" placeholder="4.8">
                        </div>

                        <div class="col-md-6">
                           <label class="form-label fw-bold">Profile Photo / Avatar</label>
                           <input type="file" name="profile_image" class="form-control" accept="image/*">
                           @if(!empty($builder->profile_image))
                              <img src="{{ asset($builder->profile_image) }}" class="mt-2 rounded-circle" style="height: 50px; width: 50px; object-fit: cover;">
                           @endif
                        </div>
                        <div class="col-md-6">
                           <label class="form-label fw-bold">Cover Photo / Banner</label>
                           <input type="file" name="cover_image" class="form-control" accept="image/*">
                           @if(!empty($builder->cover_image))
                              <img src="{{ asset($builder->cover_image) }}" class="mt-2 rounded" style="height: 50px; width: 100px; object-fit: cover;">
                           @endif
                        </div>

                        <div class="col-md-6 d-flex align-items-center gap-4 mt-4">
                           <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" name="is_verified" id="is_verified" value="1" {{ old('is_verified', $builder->is_verified ?? true) ? 'checked' : '' }}>
                              <label class="form-check-label fw-bold text-primary" for="is_verified"><i class="fas fa-check-circle me-1"></i> Verified Checkmark</label>
                           </div>
                           <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ old('status', $builder->status ?? true) ? 'checked' : '' }}>
                              <label class="form-check-label fw-bold" for="status">Active Status</label>
                           </div>
                        </div>

                        <div class="col-12">
                           <label class="form-label fw-bold">Full Office Address</label>
                           <input type="text" name="address" class="form-control" value="{{ old('address', $builder->address ?? '') }}" placeholder="Hazratganj, Lucknow">
                        </div>

                        <div class="col-12">
                           <label class="form-label fw-bold">About / Description</label>
                           <textarea name="about" class="form-control" rows="3" placeholder="Leading architecture firm specializing in residential, commercial, and 3D visualization projects.">{{ old('about', $builder->about ?? '') }}</textarea>
                        </div>

                        <div class="col-md-4">
                           <label class="form-label fw-bold">Services Offered (Comma Separated)</label>
                           <input type="text" name="services" class="form-control" value="{{ isset($builder) ? implode(', ', $builder->services->pluck('service_name')->toArray()) : 'Residential Design, Commercial Design, 3D Elevation, Site Planning' }}" placeholder="Residential Design, Commercial Design, 3D Elevation">
                        </div>
                        <div class="col-md-4">
                           <label class="form-label fw-bold">Certifications (Comma Separated)</label>
                           <input type="text" name="certifications" class="form-control" value="{{ isset($builder) ? implode(', ', $builder->certifications->pluck('certification_name')->toArray()) : 'COA Registered, GST Registered, ISO Certified' }}" placeholder="COA Registered, GST Registered">
                        </div>
                        <div class="col-md-4">
                           <label class="form-label fw-bold">Service Areas (Comma Separated)</label>
                           <input type="text" name="service_areas" class="form-control" value="{{ isset($builder) ? implode(', ', $builder->serviceAreas->pluck('city_name')->toArray()) : 'Lucknow, Kanpur, Ayodhya' }}" placeholder="Lucknow, Kanpur, Ayodhya">
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
