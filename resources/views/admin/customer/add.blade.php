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

                   @can('customer-list')
                  <a href="{{ route('admin.customer.list') }}" class="btn btn-sm btn-sm btn-outline-primary">
                  <i class="fas fa-list"></i> List
                  </a>
                   @endcan
                   
               </div>
               <div class="border-top"></div>
               <div class="card-body p-4">
               
               <form id="saveForm" class="theme-form row g-3" enctype="multipart/form-data">
                   <input type="hidden" name="id" id="id" value="{{ $customer->id ?? '' }}">
                   <input type="hidden" id="old_profile_image" name="old_profile_image" value="{{ $customer->profile_image ?? '' }}">
                   @csrf

                   <div class="col-md-6">
                       <label class="form-label">Name <span class="text-danger">*</span></label>
                       <input
                           type="text"
                           class="form-control"
                           name="name"
                           id="name"
                           value="{{ $customer->name ?? '' }}"
                           placeholder="Enter Name" required>
                   </div>

                   <div class="col-md-6">
                       <label class="form-label">Email ID <span class="text-danger">*</span></label>
                       <input
                           type="email"
                           class="form-control"
                           name="email_id"
                           id="email_id"
                           value="{{ $customer->email_id ?? '' }}"
                           placeholder="Enter Email" required>
                   </div>

                   <div class="col-md-6">
                       <label class="form-label">Phone No <span class="text-danger">*</span></label>
                       <input
                           type="text"
                           class="form-control numberInput" minlength="10" maxlength="10"
                           name="phone_no"
                           id="phone_no" 
                           value="{{ $customer->phone_no ?? '' }}"
                           placeholder="Enter Phone No" required>
                   </div>

                   <div class="col-md-6">
                       <label class="form-label">Gender <span class="text-danger">*</span></label>
                       <select class="form-select select2" name="gender" id="gender" required>
                           <option value="">Select Gender</option>
                           <option value="Male" {{ (!empty($customer) && $customer->gender == 'Male') ? 'selected' : '' }}>Male</option>
                           <option value="Female" {{ (!empty($customer) && $customer->gender == 'Female') ? 'selected' : '' }}>Female</option>
                           <option value="Other" {{ (!empty($customer) && $customer->gender == 'Other') ? 'selected' : '' }}>Other</option>
                       </select>
                   </div>

                   <div class="col-md-6">
                       <label class="form-label">Status <span class="text-danger">*</span></label>
                       <select class="form-select select2" name="status" id="status" required>
                           <option value="Pending" {{ (!empty($customer) && $customer->status == 'Pending') ? 'selected' : '' }}>Pending</option>
                           <option value="Active" {{ (!empty($customer) && $customer->status == 'Active') ? 'selected' : '' }}>Active</option>
                           <option value="Inactive" {{ (!empty($customer) && $customer->status == 'Inactive') ? 'selected' : '' }}>Inactive</option>
                           <option value="Blocked" {{ (!empty($customer) && $customer->status == 'Blocked') ? 'selected' : '' }}>Blocked</option>
                       </select>
                   </div>

                   <div class="col-md-6"> 
                       <label class="form-label">Profile Image</label>
                       <input type="file" class="form-control" name="profile_image" id="profile_image" {{ empty($customer->profile_image) ? 'required' : '' }} accept=".jpg,.jpeg,.png" onchange="previewImage(this,'profile_imagePreview')">
                       <div class="mt-2">
                           <img id="profile_imagePreview" src="{{ !empty($customer->profile_image) ? asset($customer->profile_image) : '' }}" style="max-height:60px; border-radius:5px; {{ empty($customer->profile_image) ? 'display:none;' : '' }}">
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

            <!-- Address Section -->
            @if(!empty($customer))
            <div class="card shadow-lg border-0 rounded-3 mt-4">
                <div class="card-header bg-light border-bottom-0 py-3 d-flex justify-content-between align-items-center rounded-top">
                    <h3 class="mb-0 fw-bold text-primary">Addresses</h3>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="openAddressModal()">
                        <i class="fas fa-plus"></i> Add Address
                    </button>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Address</th>
                                    <th>Pincode</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Default</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody> 
                                @forelse($addresses as $addr)
                                    <tr>
                                        <td>{{ ucfirst($addr->address_type) }}</td>
                                        <td>{{ $addr->address }}</td>
                                        <td>{{ $addr->pincode }}</td>
                                        <td>{{ $addr->city_name }}</td>
                                        <td>{{ $addr->state_name }}</td>
                                        <td>
                                            @if($addr->set_as_default == 'yes')
                                                <span class="badge bg-success">Yes</span>
                                            @else
                                                <span class="badge bg-secondary">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="editAddress({{ $addr->id }}, '{{ $addr->address_type }}', '{{ addslashes(str_replace(PHP_EOL, ' ', $addr->address)) }}', '{{ $addr->pincode }}', '{{ $addr->city_name }}', '{{ $addr->state_name }}', '{{ $addr->set_as_default }}')"><i class="fas fa-edit"></i></button>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteAddress({{ $addr->id }})"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No addresses found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Address Modal -->
            <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <form id="addressForm">
                      @csrf 
                      <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                      <input type="hidden" name="address_id" id="address_id" value="">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addressModalLabel">Add Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body row g-3">
                          <div class="col-md-6">
                              <label>Type <span class="text-danger">*</span></label>
                              <select name="address_type" id="address_type" class="form-select" required>
                                  <option value="">Select Type</option>
                                  <option value="home">Home</option>
                                  <option value="office">Office</option>
                                  <option value="other">Other</option> 
                              </select>
                          </div>
                          <div class="col-md-6">
                              <label>Pincode <span class="text-danger">*</span></label>
                              <input type="text" name="pincode" id="addr_pincode" class="form-control numberInput" placeholder="Enter Pincode" required minlength="6" maxlength="6">
                          </div>
                          <div class="col-md-6">
                              <label>City <span class="text-danger">*</span></label>
                              <input type="text" name="city_name" id="addr_city_name" placeholder="Enter City Name" class="form-control" required>
                          </div>
                          <div class="col-md-6">
                              <label>State <span class="text-danger">*</span></label>
                              <input type="text" name="state_name" id="addr_state_name" placeholder="Enter State Name" class="form-control" required>
                          </div>
                          <div class="col-md-12">
                              <label>Address <span class="text-danger">*</span></label>
                              <textarea name="address" id="addr_address" class="form-control" rows="3" placeholder="Enter Address" required></textarea>
                          </div>
                          <div class="col-md-6">
                              <label>Set as Default</label>
                              <select name="set_as_default" id="addr_set_as_default" class="form-select">
                                  <option value="no">No</option>
                                  <option value="yes">Yes</option>
                              </select>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveAddressBtn">Save Address</button>
                      </div>
                  </form>
                </div>
              </div>
            </div>
            @endif
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
   
           $.ajax({
               url: '{{ route("admin.customer.save") }}', 
               type: 'POST',
               data: formData,
               processData: false,
               contentType: false,
   
               beforeSend:function(){
                   $('#submitBtn').prop('disabled',true).html('Processing...');
               },
   
               success:function(response){
                   toastr.success(response.message || 'Customer saved successfully!');
   
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

   // Address Functions
   function openAddressModal() {
       $('#addressForm')[0].reset();
       $('#address_id').val('');
       $('#addressModalLabel').text('Add Address');
       $('#addressModal').modal('show');
   }

   function editAddress(id, type, address, pincode, city, state, isDefault) {
       $('#addressForm')[0].reset();
       $('#address_id').val(id);
       $('#address_type').val(type);
       $('#addr_address').val(address);
       $('#addr_pincode').val(pincode);
       $('#addr_city_name').val(city);
       $('#addr_state_name').val(state);
       $('#addr_set_as_default').val(isDefault);
       $('#addressModalLabel').text('Edit Address');
       $('#addressModal').modal('show');
   }

   $('#addressForm').on('submit', function(e){
       e.preventDefault();
       let formData = new FormData(this);
       
       $.ajax({
           url: '{{ route("admin.customer.address.save") }}',
           type: 'POST',
           data: formData,
           processData: false,
           contentType: false,
           beforeSend: function(){
               $('#saveAddressBtn').prop('disabled', true).html('Processing...');
           },
           success: function(response){
               if(response.success){
                   toastr.success(response.message);
                   $('#addressModal').modal('hide');
                   setTimeout(function(){ location.reload(); }, 1000);
               } else {
                   toastr.error(response.message || 'Error occurred');
               }
           },
           error: function(xhr){
               if(xhr.status === 422){
                   let errors = xhr.responseJSON.errors || {};
                   let messages = [];
                   if (xhr.responseJSON.message && Object.keys(errors).length === 0) {
                       messages.push(xhr.responseJSON.message);
                   } else {
                       $.each(errors, function(key, val){
                           messages.push(val[0]);
                       });
                   }
                   toastr.error(messages.join('<br>'));
               } else {
                   toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
               }
           },
           complete: function(){
               $('#saveAddressBtn').prop('disabled', false).html('Save Address');
           }
       });
   });

   function deleteAddress(id) {
       Swal.fire({
           title: 'Are you sure?',
           text: "You want to delete this address!",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Yes, delete it!'
       }).then((result) => {
           if (result.isConfirmed) {
               $.ajax({
                   url: '{{ route("admin.customer.address.delete") }}',
                   type: 'POST',
                   data: {
                       _token: '{{ csrf_token() }}',
                       id: id
                   },
                   success: function(response){
                       if(response.success){
                           toastr.success(response.message);
                           setTimeout(function(){ location.reload(); }, 1000);
                       } else {
                           toastr.error(response.message || 'Error occurred');
                       }
                   },
                   error: function(xhr){
                       toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                   }
               });
           }
       });
   }
</script>
@endpush
