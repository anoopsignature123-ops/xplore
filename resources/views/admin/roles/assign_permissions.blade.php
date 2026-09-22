@extends('admin.includes.layout')
@section('title', $page_title)
@section('content')
<div class="page-body">
   <div class="container-fluid">
      <div class="page-title">
         <div class="row">
            <div class="col-sm-6 col-12"></div>
            <div class="col-sm-6 col-12">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"> <i class="fa-solid fa-home me-2"></i></a></li>
                  <li class="breadcrumb-item"><a href="{{ route('admin.roles.list') }}">Roles</a></li>
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
               <div class="card-header bg-light border-bottom-0 py-3 d-flex justify-content-between align-items-center rounded-top">
                  <h3 class="mb-0 fw-bold text-primary">
                     {{ $page_title }}
                  </h3>
               </div>
               <div class="border-top"></div>
               <div class="card-body p-4">
                  <form id="assignForm" class="theme-form row g-3">
                     @csrf
                     
                     <div class="col-md-3">
                         <label class="form-label fw-bold">Select Role</label>
                         <select name="role_id" id="role_id" class="form-select select2" required>
                             <option value="">-- Select Role --</option>
                             @foreach($roles as $roleObj)
                                 <option value="{{ $roleObj->id }}" {{ $selected_role_id == $roleObj->id ? 'selected' : '' }}>{{ $roleObj->name }}</option>
                             @endforeach
                         </select>
                     </div>

                     <div class="col-12 mb-2">
                         <div class="form-check border-bottom pb-2">
                             <input class="form-check-input" type="checkbox" id="selectAll">
                             <label class="form-check-label fw-bold text-primary" for="selectAll">
                                 Select All / Unselect All
                             </label>
                         </div>
                     </div>

                     <div class="col-12">
                         <div class="row" id="permissionsContainer">
                             @foreach($permissions as $permission)
                             <div class="col-md-3 mb-3">
                                 <div class="form-check">
                                     <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}">
                                     <label class="form-check-label" for="perm_{{ $permission->id }}">
                                         {{ $permission->name }}
                                     </label>
                                 </div>
                             </div>
                             @endforeach
                         </div>
                     </div>

                     <div class="col-12 text-start mt-4 border-top pt-3">
                         <button type="submit" id="submitBtn" class="btn btn-sm btn-primary">
                             <i class="fas fa-save"></i> Save Permissions
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

       function fetchRolePermissions(roleId) {
           $('.permission-checkbox').prop('checked', false);
           $('#selectAll').prop('checked', false);

           if (!roleId) return;

           $.ajax({
               url: '{{ route("admin.roles.get_role_permissions") }}',
               type: 'POST',
               data: {
                   role_id: roleId,
                   _token: '{{ csrf_token() }}'
               },
               success: function(response) {
                   if(response.success && response.data) {
                       let assigned = response.data;
                       $('.permission-checkbox').each(function() {
                           if(assigned.includes($(this).val())) {
                               $(this).prop('checked', true);
                           }
                       });

                       // Update selectAll status
                       if ($('.permission-checkbox:checked').length === $('.permission-checkbox').length) {
                           $('#selectAll').prop('checked', true);
                       }
                   }
               }
           });
       }

       // Initial load if role is pre-selected via query string
       if ($('#role_id').val()) {
           fetchRolePermissions($('#role_id').val());
       }

       // On dropdown change
       $('#role_id').on('change', function() {
           fetchRolePermissions($(this).val());
       });

       // Select All / Unselect All logic
       $('#selectAll').on('change', function() {
           $('.permission-checkbox').prop('checked', $(this).is(':checked'));
       });

       // Update Select All checkbox when individual checkboxes change
       $('.permission-checkbox').on('change', function() {
           if ($('.permission-checkbox:checked').length === $('.permission-checkbox').length) {
               $('#selectAll').prop('checked', true);
           } else {
               $('#selectAll').prop('checked', false);
           }
       });

       // Form Submit
       $('#assignForm').on('submit', function(e){
           e.preventDefault();

           if (!$('#role_id').val()) {
               toastr.error('Please select a role first.');
               return;
           }

           let formData = new FormData(this);
   
           $.ajax({
               url: '{{ route("admin.roles.save_permissions") }}',
               type: 'POST',
               data: formData,
               processData: false,
               contentType: false,
               beforeSend:function(){
                   $('#submitBtn').prop('disabled',true).html('Processing...');
               },
               success:function(response){
                   toastr.success(response.message || 'Permissions assigned successfully!');
                   // Do not redirect, keep them on the page to do more assignments if needed
               },
               error:function(xhr){
                   toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
               },
               complete:function(){
                   $('#submitBtn').prop('disabled',false).html('<i class="fas fa-save"></i> Save Permissions');
               }
           });
       });
   });
</script>
@endpush
