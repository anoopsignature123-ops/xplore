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
      @if(session('success'))
         setTimeout(function() {
            toastr.success('{{ session('success') }}');
         }, 500);
      @endif
      @if(session('error'))
         setTimeout(function() {
            toastr.error('{{ session('error') }}');
         }, 500);
      @endif
   });
</script>
</body>
</html>
