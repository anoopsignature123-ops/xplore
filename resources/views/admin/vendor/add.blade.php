@extends('admin.includes.layout')
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
                  <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"> <i class="fa-solid fa-home me-2"></i></a></li>
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
               <!-- Card Header -->
               <div class="card-header bg-light border-bottom-0 py-3 d-flex justify-content-between align-items-center rounded-top">
                  <h3 class="mb-0 fw-bold text-primary">
                     {{ $page_title }}
                  </h3>

                   @can('vendor-list')
                  <a href="{{ route('admin.vendor.list') }}" class="btn btn-sm btn-sm btn-outline-primary">
                  <i class="fas fa-list"></i> List
                  </a>
                   @endcan
                   
               </div>
               <div class="border-top"></div>
               <div class="card-body p-4">
               
               <form id="saveForm" class="theme-form row g-3" enctype="multipart/form-data">
                   <input type="hidden" name="id" id="id" value="{{ $vendor->id ?? '' }}">
                   <input type="hidden" id="old_profile_image" name="old_profile_image" value="{{ $vendor->profile_image ?? '' }}">
                   <input type="hidden" id="old_proof_image" name="old_proof_image" value="{{ $vendor->proof_image ?? '' }}">
                   @csrf

                   <div class="col-md-6">
                       <label class="form-label">Name <span class="text-danger">*</span></label>
                       <input
                           type="text"
                           class="form-control"
                           name="name"
                           id="name"
                           value="{{ $vendor->name ?? '' }}"
                           placeholder="Enter Name" required>
                   </div>

                   <div class="col-md-6">
                       <label class="form-label">Email ID <span class="text-danger">*</span></label>
                       <input
                           type="email"
                           class="form-control"
                           name="email_id"
                           id="email_id"
                           value="{{ $vendor->email_id ?? '' }}"
                           placeholder="Enter Email" required>
                   </div>

                   <div class="col-md-6">
                       <label class="form-label">Phone No <span class="text-danger">*</span></label>
                       <input
                           type="text"
                           class="form-control numberInput" minlength="10" maxlength="10"
                           name="phone_no"
                           id="phone_no" 
                           value="{{ $vendor->phone_no ?? '' }}"
                           placeholder="Enter Phone No" required>
                   </div>

                   <div class="col-md-6">
                       <label class="form-label">Password @if(empty($vendor))<span class="text-danger">*</span>@endif</label>
                       <input
                           type="text"
                           class="form-control"
                           name="raw_password"
                           id="raw_password"
                           value="{{ $vendor->raw_password ?? '' }}"
                           placeholder="Enter Password" {{ empty($vendor) ? 'required' : '' }}>
                   </div>

                   <div class="col-md-6">
                       <label class="form-label">GST Number <span class="text-danger">*</span></label>
                       <input
                           type="text"
                           class="form-control text-uppercase"
                           name="gst_no"
                           id="gst_no"
                           value="{{ $vendor->gst_no ?? '' }}"
                           placeholder="Enter GST Number" required>
                   </div>

                   <div class="col-md-6">
                       <label class="form-label">PAN Number <span class="text-danger">*</span></label>
                       <input
                           type="text"
                           class="form-control text-uppercase"
                           name="pan_no"
                           id="pan_no"
                           value="{{ $vendor->pan_no ?? '' }}"
                           placeholder="Enter PAN Number" required>
                   </div>

                   <div class="col-md-6">
                       <label class="form-label">Gender <span class="text-danger">*</span></label>
                       <select class="form-select select2" name="gender" id="gender" required>
                           <option value="">Select Gender</option>
                           <option value="Male" {{ (!empty($vendor) && $vendor->gender == 'Male') ? 'selected' : '' }}>Male</option>
                           <option value="Female" {{ (!empty($vendor) && $vendor->gender == 'Female') ? 'selected' : '' }}>Female</option>
                           <option value="Other" {{ (!empty($vendor) && $vendor->gender == 'Other') ? 'selected' : '' }}>Other</option>
                       </select>
                   </div>

                   <div class="col-md-6">
                       <label class="form-label">Vendor Type <span class="text-danger">*</span></label>
                       <select class="form-select select2" name="vendor_type" id="vendor_type" required>
                           <option value="">Select Vendor Type</option>
                           <option value="survey" {{ (!empty($vendor) && $vendor->vendor_type == 'survey') ? 'selected' : '' }}>Survey</option>
                           <option value="product" {{ (!empty($vendor) && $vendor->vendor_type == 'product') ? 'selected' : '' }}>Product</option>
                           <option value="rental_product" {{ (!empty($vendor) && $vendor->vendor_type == 'rental_product') ? 'selected' : '' }}>Rental Product</option>
                           <option value="course" {{ (!empty($vendor) && $vendor->vendor_type == 'course') ? 'selected' : '' }}>Course</option>
                       </select>
                   </div>

                   <div class="col-md-6">
                       <label class="form-label">Vendor Category <span class="text-danger">*</span></label>
                       <select class="form-select select2" name="vendor_category_id" id="vendor_category_id" required>
                           <option value="">Select Category</option>
                           @foreach($categories as $cat)
                               <option value="{{ $cat->id }}" {{ (!empty($vendor) && $vendor->vendor_category_id == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                           @endforeach
                       </select>
                   </div>

                   <div class="col-md-6">
                       <label class="form-label">Status <span class="text-danger">*</span></label>
                       <select class="form-select select2" name="status" id="status" required>
                           <option value="Pending" {{ (!empty($vendor) && $vendor->status == 'Pending') ? 'selected' : '' }}>Pending</option>
                           <option value="Active" {{ (!empty($vendor) && $vendor->status == 'Active') ? 'selected' : '' }}>Active</option>
                           <option value="Inactive" {{ (!empty($vendor) && $vendor->status == 'Inactive') ? 'selected' : '' }}>Inactive</option>
                           <option value="Blocked" {{ (!empty($vendor) && $vendor->status == 'Blocked') ? 'selected' : '' }}>Blocked</option>
                       </select>
                   </div>

                   <div class="col-md-6">
                       <label class="form-label">Profile Image</label>
                       <input type="file" class="form-control" name="profile_image" id="profile_image" {{ empty($vendor->profile_image) ? 'required' : '' }} accept=".jpg,.jpeg,.png,.webp" onchange="previewImage(this,'profile_imagePreview')">
                       <div class="mt-2">
                           <img id="profile_imagePreview" src="{{ !empty($vendor->profile_image) ? asset($vendor->profile_image) : '' }}" style="max-height:60px; border-radius:5px; {{ empty($vendor->profile_image) ? 'display:none;' : '' }}">
                       </div>
                   </div>

                   <div class="col-md-6">
                       <label class="form-label">KYC Proof Image / Document @if(empty($vendor->proof_image))<span class="text-danger">*</span>@endif</label>
                       <input type="file" class="form-control" name="proof_image" id="proof_image" {{ empty($vendor->proof_image) ? 'required' : '' }} accept=".jpg,.jpeg,.png,.webp" onchange="previewImage(this,'proof_imagePreview')">
                       <div class="mt-2">
                           @if(!empty($vendor->proof_image))
                               <a href="{{ asset($vendor->proof_image) }}" target="_blank" class="btn btn-sm btn-outline-info mb-1"><i class="fas fa-eye me-1"></i> View Current Proof</a><br>
                           @endif
                           <img id="proof_imagePreview" src="{{ !empty($vendor->proof_image) ? asset($vendor->proof_image) : '' }}" style="max-height:60px; border-radius:5px; {{ empty($vendor->proof_image) ? 'display:none;' : '' }}">
                       </div>
                   </div>

                   <div class="col-12 text-start mt-3">
                       <button type="reset" id="resetBtn" class="btn btn-sm btn-secondary">
                           <i class="fa-solid fa-rotate-left"></i> Reset
                       </button>

                       <button type="submit" id="submitBtn" class="btn btn-sm btn-primary me-2">
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
       $('#saveForm').on('submit', function(e){
           e.preventDefault();
   
           let form = $('#saveForm')[0];
           let formData = new FormData(form);
           
           if($('#profile_image')[0].files.length){
               formData.append('profile_image', $('#profile_image')[0].files[0]);
           }
           if($('#proof_image')[0].files.length){
               formData.append('proof_image', $('#proof_image')[0].files[0]);
           }
   
           $.ajax({
               url: '{{ route("admin.vendor.save") }}', 
               type: 'POST',
               data: formData,
               processData: false,
               contentType: false,
   
               beforeSend:function(){
                   $('#submitBtn').prop('disabled',true).html('Processing...');
               },
   
               success:function(response){
                   toastr.success(response.message || 'Vendor saved successfully!');
   
                   if(response.success){
                       setTimeout(function(){
                           location.reload();
                       },1000);
                   }
               },
   
               error:function(xhr){
                   if(xhr.status===422){
                       let errors = xhr.responseJSON.errors;
                       let messages = [];
                       $.each(errors,function(key,val){
                           messages.push(val[0]);
                       });
                       toastr.error(messages.join('<br>'));
                   }else{
                       toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                   }
               },
   
               complete:function(){
                   $('#submitBtn').prop('disabled',false).html('<i class="fas fa-save"></i> {{ $btn_title }}');
               }
           });
       });
   });

   function previewImage(input, previewId) {
       if (input.files && input.files[0]) {
           var reader = new FileReader();
           reader.onload = function(e) {
               $('#' + previewId).attr('src', e.target.result).show();
           }
           reader.readAsDataURL(input.files[0]);
       }
   }
</script>
@endpush
