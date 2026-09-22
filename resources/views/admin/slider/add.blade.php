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
                  @can('slider-list')
                  <a href="{{ route('admin.slider.list') }}" class="btn btn-sm btn-sm btn-outline-primary">
                  <i class="fas fa-list"></i> List
                  </a>
                  @endcan
               </div>
               <div class="border-top"></div>
               <div class="card-body p-4">
                  <form id="saveForm" class="theme-form row g-3" enctype="multipart/form-data">
                     <input type="hidden" name="id" id="id" value="{{ $slider->id ?? '' }}">
                     @csrf 
                     <div class="col-md-4">
                        <label class="form-label">Slider Type</label> 
                        <select class="form-select select2" required name="type" id="type">
                           <option value="">Select Slider Category</option> 
                           <option value="home" {{ (!empty($slider) && $slider->type == 'home') ? 'selected' : '' }}>Home</option>
                           <option value="survey" {{ (!empty($slider) && $slider->type == 'survey') ? 'selected' : '' }}>Survey</option>
                           <option value="build" {{ (!empty($slider) && $slider->type == 'build') ? 'selected' : '' }}>Build</option>
                           <option value="mart" {{ (!empty($slider) && $slider->type == 'mart') ? 'selected' : '' }}>Mart</option>
                           <option value="academy" {{ (!empty($slider) && $slider->type == 'academy') ? 'selected' : '' }}>Academy</option>
                           <option value="equipment" {{ (!empty($slider) && $slider->type == 'equipment') ? 'selected' : '' }}>Equipment</option>
                        </select>
                     </div>
                     <div class="col-md-4">
                        <label class="form-label">Name</label>
                        <input
                           type="text" required
                           class="form-control"
                           name="name"
                           id="name"
                           value="{{ $slider->name ?? '' }}"
                           placeholder="Enter Name">
                     </div>
                     <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select class="form-select select2" required name="status" id="status">
                        <option value="Active" {{ (!empty($slider) && $slider->status == 'Active') ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ (!empty($slider) && $slider->status == 'Inactive') ? 'selected' : '' }}>Inactive</option>
                        </select>
                     </div>
                     <div class="col-md-4">
                        <label class="form-label" for="image">Image</label>
                        <input type="file" class="form-control" id="image" {{ empty($slider->image) ? 'required' : '' }} name="image" accept=".jpg,.jpeg,.png"
                           onchange="previewImage(this,'imagePreview')">
                        <div class="mt-2">
                           <div class="mt-3">
                              <a href="{{ !empty($slider->image) ? asset($slider->image) : '' }}" target="_blank">
                              <img id="imagePreview"
                                 src="{{ !empty($slider->image) ? asset($slider->image) : '' }}"
                                 alt="Image"
                                 class="img-thumbnail border rounded shadow-sm p-1"
                                 style="max-height: 100px; {{ empty($slider->image) ? 'display:none;' : '' }}">
                              </a>
                           </div>
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
           $.ajax({
               url: '{{ route("admin.slider.save") }}',
               type: 'POST',
               data: formData,
               processData: false,
               contentType: false,
   
               beforeSend:function(){
                   $('#submitBtn').prop('disabled',true).html('Processing...');
               },
   
               success:function(response){
                   toastr.success(response.message || 'Record Saved Successfully!');
   
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
</script>
@endpush