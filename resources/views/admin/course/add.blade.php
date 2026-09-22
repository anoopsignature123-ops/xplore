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
                  @can('course-list')
                  <a href="{{ route('admin.course.list') }}" class="btn btn-sm btn-sm btn-outline-primary">
                  <i class="fas fa-list"></i> List
                  </a>
                  @endcan
               </div>
               <div class="border-top"></div>
               <div class="card-body p-4">
                  <form id="saveForm" class="theme-form row g-3" enctype="multipart/form-data">
                     <input type="hidden" name="id" id="id" value="{{ $course->id ?? '' }}">
                     @csrf 
                     

                     
                     <div class="col-md-6">
                        <label class="form-label">Course Category</label>
                        <select class="form-select select2" required name="course_category_id" id="course_category_id">
                           <option value="">Select Course Category</option>
                           @if(!empty($course_category_list) && count($course_category_list) > 0)
                                 @foreach($course_category_list as $value)
                                    <option value="{{ $value->id }}"
                                       {{ !empty($course) && $course->course_category_id == $value->id ? 'selected' : '' }}>
                                       {{ $value->name }}
                                    </option>
                                 @endforeach
                           @endif

                        </select>
                     </div>

                     <div class="col-md-6">
                        <label class="form-label">Course Name</label>
                        <input type="text" class="form-control" name="course_name" id="course_name" required value="{{ $course->course_name   ?? '' }}" placeholder="Enter Course Name">
                     </div> 

                      <div class="col-md-6"> 
                        <label class="form-label">Course Duration</label>
                        <input type="text" class="form-control" required name="duration" id="duration" value="{{ $course->duration ?? '' }}" placeholder="Enter  Course Duration">
                     </div> 

                     
                      <div class="col-md-6">
                        <label class="form-label">Course Amount</label>
                        <input type="text" class="form-control numberInput" required name="amount" id="amount" value="{{ isset($course->amount) ? (int) $course->amount : '' }}"  placeholder="Enter  Course Amount">
                     </div> 


                     <div class="col-md-12">
                        <label class="form-label">Short Detail</label>
                        <textarea name="short_detail" id="short_detail" class="form-control" cols="2" rows="2" required  placeholder="Enter Short Detail">{{ $course->short_detail ?? ''}}</textarea>
                     </div> 
               

                    
                     <div class="col-md-4"> 
                        <label class="form-label" for="image">Image</label>
                        <input type="file" class="form-control" id="image" name="image" {{ empty($course->image) ? 'required' : '' }} accept=".jpg,.jpeg,.png"
                           onchange="previewImage(this,'imagePreview')">
                        <div class="mt-2">
                           <div class="mt-3">
                              <a href="{{ !empty($course->image) ? asset($course->image) : '' }}" target="_blank">
                              <img id="imagePreview"
                                 src="{{ !empty($course->image) ? asset($course->image) : '' }}"
                                 alt="Image"
                                 class="img-thumbnail border rounded shadow-sm p-1"
                                 style="max-height: 100px; {{ empty($course->image) ? 'display:none;' : '' }}">
                              </a>
                           </div>
                        </div>
                     </div>

                      <div class="col-md-4">  
                        <label class="form-label">Status</label>
                        <select class="form-select select2" required name="status" id="status">
                        <option value="Active" {{ (!empty($course) && $course->status == 'Active') ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ (!empty($course) && $course->status == 'Inactive') ? 'selected' : '' }}>Inactive</option>
                        </select>
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
               url: '{{ route("admin.course.save") }}',
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