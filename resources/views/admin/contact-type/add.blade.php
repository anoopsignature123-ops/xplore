@extends('admin.includes.layout')
@section('title', $page_title)
@section('content')
<div class="page-body">
   <div class="container-fluid">
      <div class="page-title">
         <div class="row">
            <div class="col-sm-6 col-12">
               <h3>{{ $page_title }}</h3>
            </div>
            <div class="col-sm-6 col-12">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"> <i class="fa-solid fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="{{ route('admin.contact-type.list') }}">Contact Types</a></li>
                  <li class="breadcrumb-item active">{{ $page_title }}</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
            <div class="card shadow-sm border-0 rounded-3">
               <div class="card-header bg-light border-bottom-0 py-3">
                  <h4 class="mb-0 text-primary fw-bold">{{ $page_title }}</h4>
               </div>
               <div class="card-body">
                  <form id="contactTypeForm" action="{{ route('admin.contact-type.save') }}" method="POST">
                     @csrf
                     <input type="hidden" name="id" value="{{ $contactType ? $contactType->id : '' }}">
                     
                     <div class="row g-3">
                        <div class="col-md-6">
                           <label for="name" class="form-label fw-semibold">Contact Type Name <span class="text-danger">*</span></label>
                           <input type="text" class="form-control" id="name" name="name" value="{{ $contactType ? $contactType->name : old('name') }}" placeholder="e.g. Technical Support, Billing, General Query" required>
                           <div class="invalid-feedback d-block" id="error-name"></div>
                        </div>

                        <div class="col-md-6">
                           <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                           <select class="form-select" id="status" name="status" required>
                              <option value="Active" {{ ($contactType && $contactType->status == 'Active') ? 'selected' : '' }}>Active</option>
                              <option value="Inactive" {{ ($contactType && $contactType->status == 'Inactive') ? 'selected' : '' }}>Inactive</option>
                           </select>
                           <div class="invalid-feedback d-block" id="error-status"></div>
                        </div>
                     </div>

                     <div class="mt-4 text-end">
                        <a href="{{ route('admin.contact-type.list') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary" id="btnSubmit">{{ $btn_title }}</button>
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
$(document).ready(function() {
   $('#contactTypeForm').on('submit', function(e) {
      e.preventDefault();
      $('.invalid-feedback').html('');
      $('#btnSubmit').prop('disabled', true).text('Saving...');

      $.ajax({
         url: $(this).attr('action'),
         type: 'POST',
         data: $(this).serialize(),
         success: function(response) {
            if(response.success) {
               toastr.success(response.message);
               setTimeout(function() {
                  window.location.href = "{{ route('admin.contact-type.list') }}";
               }, 1000);
            } else {
               toastr.error(response.message || 'Something went wrong');
               $('#btnSubmit').prop('disabled', false).text('{{ $btn_title }}');
            }
         },
         error: function(xhr) {
            $('#btnSubmit').prop('disabled', false).text('{{ $btn_title }}');
            if(xhr.status === 422) {
               var errors = xhr.responseJSON.errors;
               if(errors) {
                  $.each(errors, function(key, val) {
                     $('#error-' + key).text(val[0]);
                  });
               } else if(xhr.responseJSON.message) {
                  toastr.error(xhr.responseJSON.message);
               }
            } else {
               toastr.error('An error occurred. Please try again.');
            }
         }
      });
   });
});
</script>
@endpush
