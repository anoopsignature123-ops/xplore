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
                  <a href="{{ route('admin.permissions.list') }}" class="btn btn-sm btn-sm btn-outline-primary">
                  <i class="fas fa-list"></i> List
                  </a>
               </div>
               <div class="border-top"></div>
               <div class="card-body p-4">
               
               <form id="saveForm" class="theme-form row g-3" enctype="multipart/form-data">
                   <input type="hidden" name="id" id="id" value="{{ $permission->id ?? '' }}">
                   @csrf

                   <div class="col-md-6">
                       <label class="form-label">Permission Name</label>
                       <input
                           type="text"
                           class="form-control" required
                           name="name"
                           id="name"
                           value="{{ $permission->name ?? '' }}"
                           placeholder="Enter Permission Name">
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
               url: '{{ route("admin.permissions.save") }}',
               type: 'POST',
               data: formData,
               processData: false,
               contentType: false,
   
               beforeSend:function(){
                   $('#submitBtn').prop('disabled',true).html('Processing...');
               },
   
               success:function(response){
                   toastr.success(response.message || 'Permission saved successfully!');
   
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
