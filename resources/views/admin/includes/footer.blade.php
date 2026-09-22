<footer class="footer">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-6 footer-copyright">
            <p class="mb-0">Copyright {{ date('Y') }} © {{ $settings->company_name ?? ''}}</p>
         </div>
         <div class="col-md-6">
            <p class="float-end mb-0">
               Designed And Developed By <a title="Signature IT Software Designers" href="https://signaturesoftware.in/">Signature IT Software Designers</a>
            </p>
         </div> 
      </div>
   </div>
</footer>  
</div> 
</div>
<!-- jquery-->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<!-- Bootstrap JS (bundle already includes Popper) -->
<script src="{{ asset('assets/admin/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}" defer></script>
<!-- Font Awesome -->
<script src="{{ asset('assets/admin/js/vendors/font-awesome/fontawesome-min.js') }}" defer></script>
<!-- Feather Icons -->
<script src="{{ asset('assets/admin/js/vendors/feather-icon/feather.min.js') }}" defer></script>
<script src="{{ asset('assets/admin/js/vendors/feather-icon/custom-script.js') }}" defer></script>
<!-- Sidebar -->
<script src="{{ asset('assets/admin/js/sidebar.js') }}" defer></script>
<!-- Height Equal -->
<script src="{{ asset('assets/admin/js/height-equal.js') }}" defer></script>
<!-- Config -->
<script src="{{ asset('assets/admin/js/config.js') }}" defer></script>
<!-- Scrollbar -->
<script src="{{ asset('assets/admin/js/scrollbar/simplebar.js') }}" defer></script>
<script src="{{ asset('assets/admin/js/scrollbar/custom.js') }}" defer></script>
<!-- Slick Slider (keep only one) -->
<script src="{{ asset('assets/admin/js/slick/slick.min.js') }}" defer></script>
<!-- Tilt Animation -->
<script src="{{ asset('assets/admin/js/animation/tilt/tilt.jquery.js') }}" defer></script>
<script src="{{ asset('assets/admin/js/animation/tilt/tilt-custom.js') }}" defer></script>
<!-- Custom Script -->
<script src="{{ asset('assets/admin/js/script.js') }}" defer></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- select 2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
   $(document).ready(function () { 
     $('.select2').select2();
    
     $('.facility_category_select').select2({
    placeholder: "Select Facility Category",
    allowClear: true,
    width: '100%'
});

   });
</script>
@stack('scripts')
<!-- Flatpickr JS --> 
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
   flatpickr(".datePicker", {
       dateFormat: "Y-m-d",   
       altInput: true,   
       altFormat: "d-m-Y",    
       allowInput: false,
   });
</script>
<script>
   function confirmDelete(callback) {
       Swal.fire({
           title: "Are you sure?",
           text: "You won't be able to revert this!",
           icon: "warning",
           showCancelButton: true,
           confirmButtonColor: "#3085d6",
           cancelButtonColor: "#d33",
           confirmButtonText: "Yes, delete it!",
           cancelButtonText: "Cancel",
           reverseButtons: true
       }).then((result) => {
           if (result.isConfirmed) {
               callback();
           }
       });
   }
   
   function showToast(type, message) {
       Swal.fire({
           toast: true,
           position: 'top-end',
           icon: type,  // 'success' | 'error' | 'warning' | 'info'
           title: message,
           showConfirmButton: false,
           timer: 2000,
           timerProgressBar: true
       });
   }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.18.0/ckeditor.js"></script>
<script>
   $(document).ready(function () { 
    // CKEDITOR.replace('description');  
   });
   function syncEditors() {
   // CKEditor
   if (typeof CKEDITOR !== 'undefined') {
       for (let instance in CKEDITOR.instances) {
           CKEDITOR.instances[instance].updateElement();
       }
   }
   // TinyMCE
   if (typeof tinymce !== 'undefined') {
       tinymce.triggerSave();
   }
   // Summernote
   if (typeof $ !== 'undefined' && typeof $.fn.summernote !== 'undefined') {
       $('.summernote').each(function () {
           let code = $(this).summernote('code');
           $(this).val(code);
       });
   }
   }
</script>

<script>
   $(function() {
     var Toast = Swal.mixin({
       toast: true,
       position: 'top-end',
       showConfirmButton: false,
       timer: 2000
     });
   
     @if(session('success'))
       setTimeout(function() {
         toastr.success('{{ session('success') }}', '', {
           "progressBar": true,
           "timeOut": 2000,
           "closeButton": true,
           "style": {
             "color": "white",
           }
         });
       }, 1000);
     @endif
   
     @if(session('error'))
       setTimeout(function() {
         toastr.error('{{ session('error') }}', '', {
           "progressBar": true,
           "timeOut": 2000,
           "closeButton": true,
           "style": {
             "color": "white",
           }
         });
       }, 1000);
     @endif
   });
</script>

<script>
   function previewImage(input, previewId) {
     const preview = document.getElementById(previewId);
     const file = input.files[0];
   
     if (file) {
       const reader = new FileReader();
       reader.onload = function (e) {
         preview.src = e.target.result;
         preview.style.display = 'block';
       };
       reader.readAsDataURL(file);
     } else {
       // If user clears the file input
       preview.src = '{{ !empty($cms->image) ? asset($cms->image) : '' }}';
       preview.style.display = preview.src ? 'block' : 'none';
     }
   }

    $(document).on('input', '.textInput', function () {
       const regex = /^[a-zA-Z ]*$/;
       if (!regex.test(this.value)) {
           this.value = this.value.replace(/[^a-zA-Z ]/g, '');
       }
   });
   
   $(document).on('input', '.numberInput', function () {
       const regex = /^\d*$/;
       if (!regex.test(this.value)) {
           this.value = this.value.replace(/[^0-9]/g, '');
       }
   });
</script>
</body>
</html>