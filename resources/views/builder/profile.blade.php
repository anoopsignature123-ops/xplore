@extends('builder.includes.layout')

@section('title', $page_title)
@section('content')
<div class="page-body">
   <div class="container-fluid p-0">

      <!-- Top Title Bar -->
      <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
         <div>
            <h3 class="fw-bold text-dark mb-1" style="font-family: 'Outfit', sans-serif;">
               <i class="fas fa-id-card text-primary me-2"></i> {{ $page_title }}
            </h3>
            <p class="text-muted small mb-0">Update your firm details, showcase completed sites, and upload portfolio photos.</p>
         </div>
         <div>
            <a href="{{ route('builder.index') }}" class="btn btn-outline-secondary rounded-pill px-3 py-2 fw-semibold shadow-sm">
               <i class="fas fa-arrow-left me-1"></i> Dashboard
            </a>
         </div>
      </div>

      <div class="row g-4">
         <!-- Left Column: Profile Information & Completed Projects -->
         <div class="col-lg-8">
            
            <!-- 1. Profile & Business Details -->
            <div class="vendor-table-card mb-4">
               <div class="card-header">
                  <div class="card-title-group">
                     <div class="card-icon-pill" style="background: rgba(13, 148, 136, 0.12); color: #0d9488;">
                        <i class="fas fa-building"></i>
                     </div>
                     <div>
                        <h5 class="card-header-title">Firm & Business Details</h5>
                     </div>
                  </div>
               </div>
               <div class="card-body p-4">
                  <form action="{{ route('builder.profile.save') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <div class="row g-3">
                        <div class="col-md-6">
                           <label class="form-label fw-semibold text-dark small"><i class="fas fa-city text-primary me-1"></i> Firm / Company Name <span class="text-danger">*</span></label>
                           <input type="text" name="firm_name" class="form-control rounded-3" value="{{ old('firm_name', $builder->firm_name) }}" required>
                        </div>
                        <div class="col-md-6">
                           <label class="form-label fw-semibold text-dark small"><i class="fas fa-user-tie text-primary me-1"></i> Contact Person Name <span class="text-danger">*</span></label>
                           <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $builder->name) }}" required>
                        </div>

                        <div class="col-md-6">
                           <label class="form-label fw-semibold text-dark small"><i class="fas fa-phone-alt text-primary me-1"></i> Phone Number <span class="text-danger">*</span></label>
                           <input type="text" name="phone" class="form-control rounded-3" value="{{ old('phone', $builder->phone) }}" required>
                        </div>
                        <div class="col-md-6">
                           <label class="form-label fw-semibold text-dark small"><i class="fas fa-location-dot text-primary me-1"></i> Location / City <span class="text-danger">*</span></label>
                           <input type="text" name="location" class="form-control rounded-3" value="{{ old('location', $builder->location) }}" required>
                        </div>

                        <div class="col-md-6">
                           <label class="form-label fw-semibold text-dark small"><i class="fas fa-briefcase text-primary me-1"></i> Experience (Years)</label>
                           <input type="number" name="experience_years" class="form-control rounded-3" value="{{ old('experience_years', $builder->experience_years) }}">
                        </div>
                        <div class="col-md-6">
                           <label class="form-label fw-semibold text-dark small"><i class="fas fa-trophy text-primary me-1"></i> Completed Projects Count</label>
                           <input type="number" name="projects_count" class="form-control rounded-3" value="{{ old('projects_count', $builder->projects_count) }}">
                        </div>

                        <div class="col-md-6">
                           <label class="form-label fw-semibold text-dark small"><i class="fas fa-globe text-primary me-1"></i> Website URL</label>
                           <input type="url" name="website" class="form-control rounded-3" placeholder="https://" value="{{ old('website', $builder->website) }}">
                        </div>
                        <div class="col-md-6">
                           <label class="form-label fw-semibold text-dark small"><i class="fas fa-map-location-dot text-primary me-1"></i> Full Office Address</label>
                           <input type="text" name="address" class="form-control rounded-3" value="{{ old('address', $builder->address) }}">
                        </div>

                        <div class="col-md-6">
                           <label class="form-label fw-semibold text-dark small"><i class="fas fa-camera text-primary me-1"></i> Profile / Logo Photo</label>
                           <input type="file" name="profile_image" class="form-control rounded-3" accept="image/*">
                           @if(!empty($builder->profile_image))
                              <div class="d-flex align-items-center gap-2 mt-2">
                                 <img src="{{ asset($builder->profile_image) }}" class="rounded-circle border shadow-sm" style="height: 48px; width: 48px; object-fit: cover;">
                                 <span class="text-muted small">Current Profile Photo</span>
                              </div>
                           @endif
                        </div>
                        <div class="col-md-6">
                           <label class="form-label fw-semibold text-dark small"><i class="fas fa-image text-primary me-1"></i> Cover Banner Image</label>
                           <input type="file" name="cover_image" class="form-control rounded-3" accept="image/*">
                           @if(!empty($builder->cover_image))
                              <div class="d-flex align-items-center gap-2 mt-2">
                                 <img src="{{ asset($builder->cover_image) }}" class="rounded border shadow-sm" style="height: 48px; width: 90px; object-fit: cover;">
                                 <span class="text-muted small">Current Banner</span>
                              </div>
                           @endif
                        </div>

                        <div class="col-12">
                           <label class="form-label fw-semibold text-dark small"><i class="fas fa-align-left text-primary me-1"></i> About Firm / Company Bio</label>
                           <textarea name="about" class="form-control rounded-3" rows="3" placeholder="Describe your construction specialization, services, team, and key highlights...">{{ old('about', $builder->about) }}</textarea>
                        </div>

                        <div class="col-md-4">
                           <label class="form-label fw-semibold text-dark small"><i class="fas fa-list-check text-primary me-1"></i> Services (Comma Separated)</label>
                           <input type="text" name="services" class="form-control rounded-3" placeholder="e.g. Turnkey, Masonry, Renovation" value="{{ implode(', ', $builder->services->pluck('service_name')->toArray()) }}">
                        </div>
                        <div class="col-md-4">
                           <label class="form-label fw-semibold text-dark small"><i class="fas fa-award text-primary me-1"></i> Certifications (Comma Separated)</label>
                           <input type="text" name="certifications" class="form-control rounded-3" placeholder="e.g. ISO 9001, RERA Registered" value="{{ implode(', ', $builder->certifications->pluck('certification_name')->toArray()) }}">
                        </div>
                        <div class="col-md-4">
                           <label class="form-label fw-semibold text-dark small"><i class="fas fa-map-pin text-primary me-1"></i> Service Areas (Comma Separated)</label>
                           <input type="text" name="service_areas" class="form-control rounded-3" placeholder="e.g. Lucknow, Kanpur, Noida" value="{{ implode(', ', $builder->serviceAreas->pluck('city_name')->toArray()) }}">
                        </div>

                        <div class="col-12 text-end mt-4">
                           <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold shadow-sm">
                              <i class="fas fa-floppy-disk me-1"></i> Save Firm Details
                           </button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>

            <!-- 2. Completed Projects Showcase -->
            <div class="vendor-table-card mb-4">
               <div class="card-header">
                  <div class="card-title-group">
                     <div class="card-icon-pill" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
                        <i class="fas fa-city"></i>
                     </div>
                     <div>
                        <h5 class="card-header-title">Completed Projects Showcase</h5>
                     </div>
                     <span class="card-count-badge">{{ $builder->completedProjects->count() }} projects</span>
                  </div>
               </div>
               <div class="card-body p-4">
                  <!-- Add Project Form -->
                  <div class="p-3 bg-light rounded-3 mb-4 border">
                     <h6 class="fw-bold text-dark mb-3 small"><i class="fas fa-plus-circle text-success me-1"></i> Add New Completed Project</h6>
                     <form action="{{ route('builder.profile.addProject') }}" method="POST" class="row g-2">
                        @csrf
                        <div class="col-md-4">
                           <input type="text" name="project_title" class="form-control form-control-sm rounded-3" placeholder="Project Title (e.g. Luxury Villa)" required>
                        </div>
                        <div class="col-md-3">
                           <input type="text" name="location" class="form-control form-control-sm rounded-3" placeholder="Location (e.g. Gomti Nagar)">
                        </div>
                        <div class="col-md-3">
                           <input type="text" name="area_details" class="form-control form-control-sm rounded-3" placeholder="Area (e.g. 3500 sqft)">
                        </div>
                        <div class="col-md-2">
                           <button type="submit" class="btn btn-success btn-sm w-100 rounded-3 fw-semibold">
                              <i class="fas fa-plus me-1"></i> Add
                           </button>
                        </div>
                     </form>
                  </div>

                  <!-- Existing Projects List -->
                  <div class="row g-3">
                     @forelse($builder->completedProjects as $cp)
                        <div class="col-md-6">
                           <div class="border rounded-3 p-3 d-flex justify-content-between align-items-center bg-white shadow-sm hover-shadow transition">
                              <div>
                                 <h6 class="fw-bold mb-1 text-dark">{{ $cp->project_title }}</h6>
                                 <p class="text-muted small mb-0">
                                    <i class="fas fa-location-dot text-danger me-1"></i> {{ $cp->location ?? 'N/A' }} 
                                    @if(!empty($cp->area_details))
                                       <span class="mx-1">•</span> <i class="fas fa-ruler-combined text-primary me-1"></i> {{ $cp->area_details }}
                                    @endif
                                 </p>
                              </div>
                              <form action="{{ route('builder.profile.deleteProject', $cp->id) }}" method="POST" onsubmit="return confirm('Delete this project?');">
                                 @csrf
                                 @method('DELETE')
                                 <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle p-2" title="Delete Project">
                                    <i class="fas fa-trash-alt"></i>
                                 </button>
                              </form>
                           </div>
                        </div>
                     @empty
                        <div class="text-center py-4 text-muted col-12">
                           <i class="fas fa-building fa-2x mb-2 opacity-50"></i>
                           <p class="mb-0 small">No completed projects added yet. Showcase your past work to impress clients.</p>
                        </div>
                     @endforelse
                  </div>
               </div>
            </div>
         </div>

         <!-- Right Column: Work Portfolio Gallery & Change Password -->
         <div class="col-lg-4">
            
            <!-- 3. Work Portfolio Gallery -->
            <div class="vendor-table-card mb-4">
               <div class="card-header">
                  <div class="card-title-group">
                     <div class="card-icon-pill" style="background: rgba(245, 158, 11, 0.12); color: #d97706;">
                        <i class="fas fa-images"></i>
                     </div>
                     <div>
                        <h5 class="card-header-title">Portfolio Gallery</h5>
                     </div>
                     <span class="card-count-badge">{{ $builder->portfolios->count() }} photos</span>
                  </div>
               </div>
               <div class="card-body p-4">
                  <!-- Upload Form -->
                  <form action="{{ route('builder.profile.addPortfolio') }}" method="POST" enctype="multipart/form-data" class="mb-4 p-3 bg-light rounded-3 border">
                     @csrf
                     <label class="form-label fw-semibold text-dark small"><i class="fas fa-upload text-warning me-1"></i> Upload Site Photo</label>
                     <div class="mb-2">
                        <input type="file" name="image" class="form-control form-control-sm rounded-3" accept="image/*" required>
                     </div>
                     <div class="mb-2">
                        <input type="text" name="title" class="form-control form-control-sm rounded-3" placeholder="Caption / Title (Optional)">
                     </div>
                     <button type="submit" class="btn btn-warning btn-sm w-100 rounded-pill fw-semibold text-dark">
                        <i class="fas fa-cloud-arrow-up me-1"></i> Upload to Gallery
                     </button>
                  </form>

                  <!-- Photo Grid -->
                  <div class="row g-2">
                     @forelse($builder->portfolios as $p)
                        <div class="col-6 position-relative">
                           <div class="overflow-hidden rounded-3 border shadow-sm position-relative group-hover">
                              <img src="{{ asset($p->image_url) }}" class="img-fluid w-100" style="height: 110px; object-fit: cover;">
                              <form action="{{ route('builder.profile.deletePortfolio', $p->id) }}" method="POST" class="position-absolute top-0 end-0 m-1" onsubmit="return confirm('Delete this image?');">
                                 @csrf
                                 @method('DELETE')
                                 <button type="submit" class="btn btn-danger btn-sm rounded-circle py-0 px-2 shadow-sm" style="font-size: 11px; line-height: 22px; height: 22px; width: 22px;">
                                    <i class="fas fa-times"></i>
                                 </button>
                              </form>
                           </div>
                           @if(!empty($p->title))
                              <div class="text-truncate small text-muted mt-1" title="{{ $p->title }}">{{ $p->title }}</div>
                           @endif
                        </div>
                     @empty
                        <div class="text-center py-4 text-muted col-12">
                           <i class="fas fa-photo-film fa-2x mb-2 opacity-50"></i>
                           <p class="mb-0 small">No portfolio photos uploaded yet.</p>
                        </div>
                     @endforelse
                  </div>
               </div>
            </div>

            <!-- 4. Password Security Card -->
            <div class="vendor-table-card">
               <div class="card-header">
                  <div class="card-title-group">
                     <div class="card-icon-pill" style="background: rgba(239, 68, 68, 0.12); color: #dc2626;">
                        <i class="fas fa-shield-halved"></i>
                     </div>
                     <div>
                        <h5 class="card-header-title">Change Password</h5>
                     </div>
                  </div>
               </div>
               <div class="card-body p-4">
                  <form action="{{ route('builder.profile.changePassword') }}" method="POST">
                     @csrf
                     <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small"><i class="fas fa-key text-muted me-1"></i> Current Password</label>
                        <input type="password" name="old_password" class="form-control rounded-3" required>
                     </div>
                     <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small"><i class="fas fa-lock text-muted me-1"></i> New Password</label>
                        <input type="password" name="new_password" class="form-control rounded-3" required>
                     </div>
                     <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small"><i class="fas fa-check-double text-muted me-1"></i> Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control rounded-3" required>
                     </div>
                     <button type="submit" class="btn btn-outline-danger w-100 rounded-pill fw-semibold">
                        <i class="fas fa-lock me-1"></i> Update Password
                     </button>
                  </form>
               </div>
            </div>

         </div>
      </div>

   </div>
</div>
@endsection
