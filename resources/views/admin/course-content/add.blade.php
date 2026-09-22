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
                        <div class="col-12 col-md-4">
                           <div class="p-2 rounded bg-light h-100">
                              <small class="text-muted d-block mb-1">Course Name</small>
                              <div class="fw-semibold text-dark fs-6">
                                    {{ $topic_record->lesson->course->course_name ?? '-' }}
                              </div>
                           </div>
                        </div>

                        <!-- Lesson -->
                        <div class="col-12 col-md-4">
                           <div class="p-2 rounded bg-light h-100">
                              <small class="text-muted d-block mb-1">Lesson Name</small>
                              <div class="fw-semibold text-dark fs-6">
                                    {{ $topic_record->lesson->lesson_name ?? '-' }}
                              </div>
                           </div>
                        </div>
 
                         <!-- Topic -->
                        <div class="col-12 col-md-4">
                           <div class="p-2 rounded bg-light h-100">
                              <small class="text-muted d-block mb-1">Topic Name</small>
                              <div class="fw-semibold text-dark fs-6">
                                    {{ $topic_record->topic_name ?? '-' }}
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
                  @can('course-content-list')
                     <a href="{{ route('admin.course-content.list', $topic_id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-list"></i> List
                     </a>
                  @endcan 
               </div>
               <div class="border-top"></div> 
               <div class="card-body p-4"> 
                  <form id="saveForm" class="theme-form row g-3" enctype="multipart/form-data">
                     <input type="hidden" name="id" id="id" value="{{ $course_content->id ?? '' }}">
                     <input type="hidden" name="topic_id" id="topic_id" value="{{ $topic_id }}">
                     @csrf 

                       <!-- TYPE DROPDOWN -->
                     <div class="col-md-4">
                        <label class="form-label">Content Type</label>
                        <select class="form-select select2" name="type" id="type" required>
                              <option value="">Select Type</option>
                              <option value="PDF" {{ (!empty($course_content) && $course_content->type == 'PDF') ? 'selected' : '' }}>PDF</option>
                              <option value="Video" {{ (!empty($course_content) && $course_content->type == 'Video') ? 'selected' : '' }}>Video</option>
                        </select>
                     </div>

                     <div class="col-md-4"> 
                        <label class="form-label">Content Name</label>
                        <input type="text" class="form-control" name="name" id="name" required value="{{ $course_content->name   ?? '' }}" placeholder="Enter Content Name">
                     </div>  
   
                     <!-- PDF FIELD -->
                     <div class="col-md-4" id="pdfBox" style="display:none;">
                        <label class="form-label">Upload PDF</label>
                        <input type="file" class="form-control" name="pdf" id="pdf" accept=".pdf,application/pdf">
                           @if(!empty($course_content->pdf))
                              <div class="mt-2">
                                 <a href="{{ asset($course_content->pdf) }}" target="_blank" class="btn btn-primary">
                                       <i class="fas fa-file-pdf"></i> View PDF
                                 </a>
                              </div>
                           @endif
                     </div>


                     <!-- VIDEO FIELD -->
                     <div class="col-md-4" id="videoBox" style="display:none;">
                        <label class="form-label">Youtube Video ID</label>
                        <input type="text" class="form-control" name="video_id" id="video_id" placeholder="Enter Youtube Video ID" value="{{ $course_content->video_id ?? '' }}">
                     </div>

                     <div class="col-md-4">
                        <label class="form-label">Priority</label>
                        <input type="text" class="form-control numberInput" name="priority" id="priority" required value="{{ $course_content->priority   ?? '' }}" placeholder="Enter Priority Value">
                     </div>   
 
                    
                    
                     <div class="col-md-4">  
                        <label class="form-label">Status</label>
                        <select class="form-select select2" required name="status" id="status">
                        <option value="Active" {{ (!empty($course_content) && $course_content->status == 'Active') ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ (!empty($course_content) && $course_content->status == 'Inactive') ? 'selected' : '' }}>Inactive</option>
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
function toggleFields() {
    let type = $('#type').val();
    if (type === 'PDF') {
        $('#pdfBox').show();
        $('#videoBox').hide();
        $('#video_id').val('');
    } 
    else if (type === 'Video') { 
        $('#videoBox').show();
        $('#pdfBox').hide();
        $('#pdf').val('');
    } 
    else {
        $('#pdfBox, #videoBox').hide();
    }
}

$(document).ready(function () {
    toggleFields(); // on page load

    $('#type').on('change', function () {
        toggleFields();
    });
});
</script>


<script>
   $(document).ready(function () {
       $('#saveForm').on('submit', function(e){
           e.preventDefault();
           let form = $('#saveForm')[0];
           let formData = new FormData(form);
           $.ajax({
               url: '{{ route("admin.course-content.save") }}',
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