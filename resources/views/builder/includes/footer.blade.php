<footer class="footer">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-6 footer-copyright">
            <p class="mb-0">Copyright {{ date('Y') }} © {{ $settings->company_name ?? 'Xplore Build' }}</p>
         </div>
         <div class="col-md-6">
            <p class="float-end mb-0">Builder & Contractor Portal</p>
         </div> 
      </div>
   </div>
</footer>  
</div> 
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="{{ asset('assets/admin/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}" defer></script>
<script src="{{ asset('assets/admin/js/vendors/font-awesome/fontawesome-min.js') }}" defer></script>
<script src="{{ asset('assets/admin/js/sidebar.js') }}" defer></script>
<script src="{{ asset('assets/admin/js/height-equal.js') }}" defer></script>
<script src="{{ asset('assets/admin/js/config.js') }}" defer></script>
<script src="{{ asset('assets/admin/js/scrollbar/simplebar.js') }}" defer></script>
<script src="{{ asset('assets/admin/js/scrollbar/custom.js') }}" defer></script>
<script src="{{ asset('assets/admin/js/script.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@stack('scripts')
<script>
   $(function() {
      // Toastr configuration (avoid overlapping top-right user menu)
      toastr.options = {
         "closeButton": true,
         "progressBar": true,
         "positionClass": "toast-top-center",
         "showDuration": "300",
         "hideDuration": "1000",
         "timeOut": "3500",
         "extendedTimeOut": "1000",
         "showEasing": "swing",
         "hideEasing": "linear",
         "showMethod": "fadeIn",
         "hideMethod": "fadeOut"
      };

      @if(session('success'))
         setTimeout(function() {
            toastr.success('{{ session('success') }}');
         }, 300);
      @endif
      @if(session('error'))
         setTimeout(function() {
            toastr.error('{{ session('error') }}');
         }, 300);
      @endif

      // Mobile drawer overlay dismiss
      $('#vpSidebarOverlay').on('click', function () {
         $('#pageWrapper').removeClass('sidebar-open');
         $('.page-sidebar').removeClass('open');
      });

      // Sidebar toggle button handler for responsive devices
      $('.toggle-sidebar, .close-btn.toggle-sidebar').on('click', function () {
         $('#pageWrapper').toggleClass('sidebar-open');
      });
   });
</script>
</body>
</html>
