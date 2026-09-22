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
         <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-3"> 
               <!-- Card Header -->
               <div class="card-header bg-light border-bottom-0 py-3 d-flex justify-content-between align-items-center rounded-top">
                  <h3 class="mb-0 fw-bold text-primary">
                     {{ $page_title }}
                  </h3>
                  
               </div>
               <div class="border-top"></div>
               <div class="card-body p-4">
                  <form id="saveForm" class="theme-form row g-3" enctype="multipart/form-data">
                     <input type="hidden" name="id" id="id" value="{{ $settings->id ?? '' }}">
                     <input type="hidden" name="old_logo" id="old_logo" value="{{ $settings->logo ?? '' }}">
                     <input type="hidden" name="old_favicon" id="old_favicon" value="{{ $settings->favicon ?? '' }}">
                     @csrf
                     <div class="col-12 col-md-4">
                        <label class="form-label" for="company_name">Company Name</label>
                        <input type="text" class="form-control textInput" id="company_name" name="company_name"
                           value="{{ $settings->company_name ?? '' }}" placeholder="Enter company name">
                     </div>
                     <div class="col-12 col-md-4">
                        <label class="form-label" for="email_id">Email</label>
                        <input type="email" class="form-control" id="email_id" name="email_id"
                           value="{{ $settings->email_id ?? '' }}" placeholder="Enter email">
                     </div>
                     <div class="col-12 col-md-4">
                        <label class="form-label" for="phone_no">Phone No</label>
                        <input type="text" class="form-control numberInput" id="phone_no" name="phone_no" minlength="10" maxlength="10"
                           value="{{ $settings->phone_no ?? '' }}" placeholder="Enter phone number">
                     </div>
                     <div class="col-12 col-md-4">
                        <label class="form-label" for="whatsapp_no">WhatsApp No</label>
                        <input type="text" class="form-control numberInput" id="whatsapp_no" name="whatsapp_no" name="phone_no" minlength="10" maxlength="10"
                           value="{{ $settings->whatsapp_no ?? '' }}" placeholder="Enter WhatsApp number">
                     </div>
                     <div class="col-12 col-md-4">
                        <label class="form-label" for="facebook_link">Facebook Link</label>
                        <input type="url" class="form-control" id="facebook_link" name="facebook_link"
                           value="{{ $settings->facebook_link ?? '' }}" placeholder="Facebook link">
                     </div>
                     <div class="col-12 col-md-4">
                        <label class="form-label" for="instagram_link">Instagram Link</label>
                        <input type="url" class="form-control" id="instagram_link" name="instagram_link"
                           value="{{ $settings->instagram_link ?? '' }}" placeholder="Instagram link">
                     </div>
                     <div class="col-12 col-md-4">
                        <label class="form-label" for="twitter_link">Twitter Link</label>
                        <input type="url" class="form-control" id="twitter_link" name="twitter_link"
                           value="{{ $settings->twitter_link ?? '' }}" placeholder="Twitter link">
                     </div>
                     <div class="col-12 col-md-4">
                        <label class="form-label" for="youtube_link">Youtube Link</label>
                        <input type="url" class="form-control" id="youtube_link" name="youtube_link"
                           value="{{ $settings->youtube_link ?? '' }}" placeholder="Youtube link">
                     </div>
                     <div class="col-12">
                        <label class="form-label" for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="1"
                           placeholder="Enter address">{{ $settings->address ?? '' }}</textarea>
                     </div>
                     <div class="col-12"> 
                        <label class="form-label" for="copyright">Copyright</label>
                        <input type="text" class="form-control" id="copyright" name="copyright"
                           value="{{ $settings->copyright ?? '' }}" placeholder="© Your Company">
                     </div>
                     <div class="col-12 col-md-4">
                        <label class="form-label" for="logo">Logo</label>
                        <input type="file" class="form-control" id="logo" name="logo" accept=".jpg,.jpeg,.png"
                           onchange="previewImage(this,'logoPreview')">
                        <div class="mt-2">
                           <div class="mt-3">
                              <a href="{{ !empty($settings->logo) ? asset($settings->logo) : '' }}" target="_blank">
                              <img id="logoPreview"
                                 src="{{ !empty($settings->logo) ? asset($settings->logo) : '' }}"
                                 alt="Image"
                                 class="img-thumbnail border rounded shadow-sm p-1"
                                 style="max-height: 100px; {{ empty($settings->logo) ? 'display:none;' : '' }}">
                              </a>
                           </div>
                        </div>
                     </div>
                     <div class="col-12 col-md-4">
                        <label class="form-label" for="favicon">Favicon</label>
                        <input type="file" class="form-control" id="favicon" name="favicon" accept=".ico,.png"
                           onchange="previewImage(this,'faviconPreview')">
                        <div class="mt-2">
                           <div class="mt-3">
                              <a href="{{ !empty($settings->favicon) ? asset($settings->favicon) : '' }}" target="_blank">
                              <img id="faviconPreview"
                                 src="{{ !empty($settings->favicon) ? asset($settings->favicon) : '' }}"
                                 alt="Image"
                                 class="img-thumbnail border rounded shadow-sm p-1"
                                 style="max-height: 100px; {{ empty($settings->favicon) ? 'display:none;' : '' }}">
                              </a>
                           </div>
                        </div>
                     </div>
               </div>
               <div class="col-12 text-start mt-3 mx-3 mb-3">
                  <button type="reset" class="btn btn-info btn-sm px-4 me-2">
                     <i class="fa-solid fa-rotate-left me-1"></i> Reset
                  </button>
                  <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4">
                     <i class="fas fa-save me-1"></i> Save Settings
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
           syncEditors();
           let form = $('#saveForm')[0];
           let formData = new FormData(form);
   
           $.ajax({
               url: '{{ route("admin.websettings.save") }}',
               type: 'POST',
               data: formData,
               processData: false,
               contentType: false,
   
               beforeSend:function(){
                   $('#submitBtn').prop('disabled',true).html('Processing...');
               },
   
               success:function(response){
   
                   toastr.success(
                       response.message || 'record saved successfully!'
                   );
   
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
                       toastr.error(
                           xhr.responseJSON?.message ||
                           'Something went wrong!'
                       );
                       console.log(xhr.responseText);
                   }
               },
   
               complete:function(){
                   $('#submitBtn').prop('disabled',false).html('<i class="fas fa-save"></i> Save');
               }
   
           });
   
       });
   
   });
</script>
@endpush