@extends('vendor.includes.layout')
@section('title', $page_title)
@section('content')
<div class="page-body">
   <div class="container-fluid">
      <div class="page-title">
         <div class="row">
            <div class="col-sm-6 col-12">
            </div>
            <div class="col-sm-6 col-12">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('vendor.index') }}"> <i class="fa-solid fa-home me-2"></i></a></li>
                  <li class="breadcrumb-item">{{ $page_title }}</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-6">
            <div class="card shadow-lg border-0 rounded-3">
               <div class="card-header bg-light border-bottom-0 py-3 d-flex justify-content-between align-items-center rounded-top">
                  <h3 class="mb-0 fw-bold text-primary">Update Profile</h3>
               </div>
               <div class="border-top"></div>
               <div class="card-body p-4">
                  <form id="profileForm" enctype="multipart/form-data">
                     @csrf
                     <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $vendor->name) }}" required>
                     </div>
                     <div class="mb-3">
                        <label class="form-label">Phone No</label>
                        <input type="text" class="form-control" name="phone_no" value="{{ old('phone_no', $vendor->phone_no) }}" required>
                     </div>
                     <div class="mb-3">
                        <label class="form-label">GST Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control text-uppercase" name="gst_no" value="{{ old('gst_no', $vendor->gst_no) }}" placeholder="Enter GST Number" required>
                     </div>
                     <div class="mb-3">
                        <label class="form-label">PAN Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control text-uppercase" name="pan_no" value="{{ old('pan_no', $vendor->pan_no) }}" placeholder="Enter PAN Number" required>
                     </div>
                     <div class="mb-3">
                        <label class="form-label">Email (Readonly)</label>
                        <input type="email" class="form-control" value="{{ $vendor->email_id }}" readonly>
                     </div>
                     <div class="mb-3">
                        <label class="form-label">Vendor Category</label>
                        <div class="input-group">
                           <input type="text" class="form-control" value="{{ $vendor->category ? $vendor->category->name : 'Not Assigned' }}" readonly>
                           @if($vendor->category)
                              <span class="input-group-text bg-primary text-white"><i class="fas fa-tag me-1"></i> Assigned</span>
                           @endif
                        </div>
                     </div>
                     <div class="mb-3">
                        <label class="form-label">Profile Image</label>
                        <input type="file" class="form-control" name="profile_image" accept="image/*" onchange="previewImage(this, 'profile_imagePreview')">
                        <input type="hidden" name="old_profile_image" value="{{ $vendor->profile_image }}">
                        <img id="profile_imagePreview" src="{{ !empty($vendor->profile_image) ? asset($vendor->profile_image) : '' }}" style="max-height:60px; margin-top:10px; {{ empty($vendor->profile_image) ? 'display:none;' : '' }}">
                     </div>
                     <div class="mb-3">
                        <label class="form-label">KYC Proof Image / Document</label>
                        <input type="file" class="form-control" name="proof_image" accept=".jpg,.jpeg,.png,.webp" onchange="previewImage(this, 'proof_imagePreview')">
                        <input type="hidden" name="old_proof_image" value="{{ $vendor->proof_image }}">
                        @if(!empty($vendor->proof_image))
                           <div class="mt-2">
                              <a href="{{ asset($vendor->proof_image) }}" target="_blank" class="btn btn-sm btn-outline-info"><i class="fas fa-file-image me-1"></i> View KYC Document</a>
                           </div>
                        @endif
                        <img id="proof_imagePreview" src="{{ !empty($vendor->proof_image) ? asset($vendor->proof_image) : '' }}" style="max-height:60px; margin-top:10px; {{ empty($vendor->proof_image) ? 'display:none;' : '' }}">
                     </div>
                     <button type="submit" class="btn btn-primary">Save Changes</button>
                  </form>
               </div>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="card shadow-lg border-0 rounded-3">
               <div class="card-header bg-light border-bottom-0 py-3 d-flex justify-content-between align-items-center rounded-top">
                  <h3 class="mb-0 fw-bold text-primary">Change Password</h3>
               </div>
               <div class="border-top"></div>
               <div class="card-body p-4">
                  <form id="passwordForm">
                     @csrf
                     <div class="mb-3">
                        <label class="form-label">Old Password</label>
                        <input type="text" class="form-control" minlength="6" placeholder="Enter Old Password" name="old_password" required>
                     </div>
                     <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="text" class="form-control" minlength="6" placeholder="Enter New Password" name="new_password" required>
                     </div>
                     <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="text" class="form-control" minlength="6" placeholder="Enter Confirm Password" name="confirm_password" required>
                     </div>
                     <button type="submit" class="btn btn-primary">Change Password</button>
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
    // Profile Form Submit
    $("#profileForm").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('vendor.profile.save') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                toastr.info("Updating profile...");
            },
            success: function(response) {
                if (response.status) {
                    toastr.success(response.message);
                    setTimeout(function() { location.reload(); }, 1500);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function(key, value) { toastr.error(value[0]); });
                } else {
                    toastr.error("Something went wrong!");
                }
            }
        });
    });

    // Password Form Submit
    $("#passwordForm").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('vendor.profile.changePassword') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                toastr.info("Changing password...");
            },
            success: function(response) {
                if (response.status) {
                    toastr.success(response.message);
                    $("#passwordForm")[0].reset();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function(key, value) { toastr.error(value[0]); });
                } else {
                    toastr.error("Something went wrong!");
                }
            }
        });
    });
});
</script>
@endpush
