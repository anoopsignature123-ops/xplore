@extends('admin.includes.layout')
@section('title', $page_title)
@section('content')
<!-- Page sidebar end-->
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
   <!-- Container-fluid starts-->
  
   <div class="container-fluid">
  <div class="row">


    <!-- RIGHT FORM -->
    <div class="col-md-6">
      <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-light border-bottom-0 py-3 d-flex justify-content-between align-items-center rounded-top">
          <h3 class="mb-0 fw-bold text-primary">{{ $page_title }}</h3>
        </div>
        <div class="border-top"></div>
        <div class="card-body p-4">
          <form id="saveForm" class="theme-form row g-3" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id" value="{{ $profile->id ?? '' }}">
            <input type="hidden" id="old_profile_pic" name="old_profile_pic" value="{{ $profile->profile_pic ?? '' }}">
            @csrf

            <div class="col-md-6">
              <label class="form-label">Name</label>
              <input type="text" class="form-control" name="name" id="name"  value="{{ $profile->name ?? '' }}" placeholder="Enter name">
            </div>

            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" readonly name="email" id="email" value="{{ $profile->email ?? '' }}" placeholder="Enter email">
            </div>

          

            <div class="col-md-6">
              <label class="form-label">Profile Pic</label>
              <input type="file" class="form-control" name="profile_pic" id="profile_pic" accept=".jpg,.jpeg,.png" onchange="previewImage(this,'profile_picPreview')">
              <div class="mt-2">
                <img id="profile_picPreview" src="{{ !empty($profile->profile_pic) ? asset($profile->profile_pic) : '' }}" style="max-height:60px; border-radius:5px; {{ empty($profile->profile_pic) ? 'display:none;' : '' }}">
              </div>
            </div>

            <div class="col-12 text-start mt-3">
               <button type="reset" id="resetBtn" class="btn btn-sm btn-secondary">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                        </button>

              <button type="submit"  id="submitBtn" class="btn btn-sm btn-primary me-2"><i class="fas fa-save"></i> Save</button>
            </div>
          </form>
        </div>
      </div>
      </div>


    <div class="col-md-6">

      <!-- Change Password Card -->
      <div class="card shadow-lg border-0 rounded-3 mt-4">
        <div class="card-header bg-light border-bottom-0 py-3 d-flex justify-content-between align-items-center rounded-top">
          <h3 class="mb-0 fw-bold text-primary">Change Password</h3>
        </div>
        <div class="border-top"></div>
        <div class="card-body p-4">
          <form id="changePasswordForm" class="theme-form row g-3">
            @csrf
            <div class="col-md-6">
              <label class="form-label">New Password</label>
              <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Enter new password">
            </div>

            <div class="col-md-6">
              <label class="form-label">Confirm New Password</label>
              <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" placeholder="Confirm new password">
            </div>

            <div class="col-12 text-start mt-3">
              <button type="submit" id="cpSubmitBtn" class="btn btn-sm btn-primary me-2"><i class="fas fa-key"></i> Change Password</button>
            </div>
          </form>
        </div>
      </div>
      <!-- End Change Password Card -->

    </div>

  </div>
</div>


</div>
@endsection
@push('scripts')
<script>
   $(document).ready(function() {
       $('#saveForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('id', $('#id').val());
        formData.append('name', $('#name').val());  
        formData.append('email', $('#email').val());
        formData.append('old_profile_pic', $('#old_profile_pic').val());
        // files
        if($('#profile_pic')[0].files.length){
            formData.append('profile_pic', $('#profile_pic')[0].files[0]);
        }
       
   
        $.ajax({
            url: '{{ route("admin.profile.save") }}',
            type: 'POST',
            data: formData,
            processData:false,
            contentType:false,
            beforeSend: ()=> $('#submitBtn').prop('disabled',true).text('Processing...'),
            success: function(res){
                if(res.success){
                    toastr.success(res.message || 'Settings saved!');
                    setTimeout(()=> location.reload(),1000);
                } else {
                    toastr.error(res.message || 'Something went wrong');
                }
            },
            error: function(xhr){
                toastr.error(xhr.responseJSON?.message || 'Error occurred');
                console.log(xhr.responseText);
            },
            complete: ()=> $('#submitBtn').prop('disabled',false).text('Save')
        });
    });

    $('#changePasswordForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
   
        $.ajax({
            url: '{{ route("admin.profile.changePassword") }}',
            type: 'POST',
            data: formData,
            processData:false,
            contentType:false,
            beforeSend: ()=> $('#cpSubmitBtn').prop('disabled',true).text('Processing...'),
            success: function(res){
                if(res.success){
                    toastr.success(res.message || 'Password changed!');
                    $('#changePasswordForm')[0].reset();
                } else {
                    toastr.error(res.message || 'Something went wrong');
                }
            },
            error: function(xhr){
                if(xhr.responseJSON?.errors) {
                    let errors = xhr.responseJSON.errors;
                    for (let key in errors) {
                        toastr.error(errors[key][0]);
                    }
                } else {
                    toastr.error(xhr.responseJSON?.message || 'Error occurred');
                }
            },
            complete: ()=> $('#cpSubmitBtn').prop('disabled',false).text('Change Password')
        });
    });
   });
</script>
@endpush