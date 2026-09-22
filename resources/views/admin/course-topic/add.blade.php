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
            <!-- Summary Card -->
               <div class="card shadow-sm border-0 rounded-3 mb-3">
                  <div class="card-body py-3">

                     <div class="row g-3">

                           <!-- Course -->
                           <div class="col-12 col-md-6">
                              <div class="p-2 rounded bg-light h-100">
                                 <small class="text-muted d-block mb-1">Course Name</small>
                                 <div class="fw-semibold text-dark fs-6">
                                       {{ $lesson_record->course->course_name ?? '-' }}
                                 </div>
                              </div>
                           </div>

                           <!-- Lesson -->
                           <div class="col-12 col-md-6">
                              <div class="p-2 rounded bg-light h-100">
                                 <small class="text-muted d-block mb-1">Lesson Name</small>
                                 <div class="fw-semibold text-dark fs-6">
                                       {{ $lesson_record->lesson_name ?? '-' }}
                                 </div>
                              </div>
                           </div>

                     </div>

                  </div>
               </div> 

            <div class="card shadow-lg border-0 rounded-3">
               <!-- Card Header -->
               <div class="card-header bg-light border-bottom-0 py-3 d-flex justify-content-between align-items-center rounded-top">
                  <h3 class="mb-0 fw-bold text-primary">
                     {{ $page_title }}
                  </h3>
                  @can('course-topic-list')
                     <a href="{{ route('admin.course-topic.list', $lesson_id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-list"></i> List
                     </a>
                  @endcan 
               </div>
               <div class="border-top"></div> 
               <div class="card-body p-4">
                 <form id="saveForm" class="theme-form row g-3" enctype="multipart/form-data">
                     <input type="hidden" name="id" id="id" value="{{ $course_topic->id ?? '' }}">
                     <input type="hidden" name="lesson_id" id="lesson_id" value="{{ $lesson_id }}">
                     @csrf 


                     <div class="col-md-4">
                        <label class="form-label">Topic Name</label>
                        <input type="text" class="form-control" name="topic_name" id="topic_name" required value="{{ $course_topic->topic_name   ?? '' }}" placeholder="Enter Topic Name">
                     </div> 

                       <div class="col-md-4">
                        <label class="form-label">Priority</label>
                        <input type="text" class="form-control numberInput" name="priority" id="priority" required value="{{ $course_topic->priority   ?? '' }}" placeholder="Enter Priority Value">
                     </div>   

                    
                    
                     <div class="col-md-4">  
                        <label class="form-label">Status</label>
                        <select class="form-select select2" required name="status" id="status">
                        <option value="Active" {{ (!empty($course_topic) && $course_topic->status == 'Active') ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ (!empty($course_topic) && $course_topic->status == 'Inactive') ? 'selected' : '' }}>Inactive</option>
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
               url: '{{ route("admin.course-topic.save") }}',
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