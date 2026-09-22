<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{ $settings->company_name ?? 'Admin' }} |  Admin Register</title>
    <!-- Favicon icon-->
    <link rel="icon" href="{{ !empty($settings->favicon) ? asset($settings->favicon) : '' }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ !empty($settings->favicon) ? asset($settings->favicon) : '' }}" type="image/x-icon">
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
      <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,500;6..12,600;6..12,700;6..12,800;6..12,900;6..12,1000&display=swap" rel="stylesheet">
    <!-- Flag icon css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendors/flag-icon.css') }}">

    <!-- Icon libraries -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/iconly-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/themify.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/fontawesome-min.css') }}">

    <!-- Bulk / custom styles -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bulk-style.css') }}">

    <!-- Weather Icons -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendors/weather-icons/weather-icons.min.css') }}">

    <!-- App Theme & Core CSS -->
    <link id="color" rel="stylesheet" href="{{ asset('assets/admin/css/color-1.css') }}" media="screen">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">


    <!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
.toast-info {
    color: #fff !important;
}
.toast-success {
    color: #fff !important;
}
.toast-error {
    color: #fff !important;
}
</style>

  </head>
  <body>
    <!-- tap on top starts-->
    <div class="tap-top"><i class="iconly-Arrow-Up icli"></i></div>
    <!-- tap on tap ends-->
    <!-- loader-->
    <div class="loader-wrapper">
      <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
    </div>
    <!-- login page start-->
    <div class="container-fluid">
      <div class="row">
            <div class="col-xl-7 login_one_image"><img class="bg-img-cover bg-center" src="{{ config('app.admin_assets') }}images/login/login-bg.jpeg" alt="{{ $settings->company_name ?? 'Admin' }}"></div>
        <div class="col-xl-5 p-0">
          <div class="login-card login-dark login-bg">
            <div>
              <div><a class="logo" href=""><img style="height: 100px;width:auto;" class="img-fluid for-light m-auto" src="{{ !empty($settings->logo) ? asset($settings->logo) : '' }}" alt="{{ $settings->company_name ?? 'Admin' }}">
              <img class="for-dark" style="height: 100px;width:auto;" src="{{ !empty($settings->logo) ? asset($settings->logo) : '' }}" alt="{{ $settings->company_name ?? 'Admin' }}"></a></div>
              <div class="login-main"> 
                <form class="theme-form" id="registerForm">
                  <h2 class="text-center">Sign in to account</h2>
                  <p class="text-center">Enter your email &amp; password to login</p>
                  <div class="form-group">
                    <label class="col-form-label">Name</label>
                    <input class="form-control" type="name" name="name" id="name"  placeholder="Please Enter Your Name">
                  </div>

                   <div class="form-group">
                    <label class="col-form-label">Email Address</label>
                    <input class="form-control" type="email"  name="email" id="email"  placeholder="Please Enter Email Address">
                  </div>

                  <div class="form-group">
                    <label class="col-form-label">Password</label>
                    <div class="form-input position-relative">
                      <input class="form-control" type="password"  id="password"   name="login[password]"  placeholder="*********">
                      <div class="show-hide"><span class="show"></span></div>
                    </div>
                  </div>
                  <div class="form-group mb-0 checkbox-checked">
                    <div class="text-end mt-3">
                      <button class="btn btn-primary btn-block w-100" type="submit">Sign in</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- jquery-->
      
      <!-- jQuery (must load first) -->
<script src="{{ asset('assets/admin/js/vendors/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap JS (bundle includes Popper, so no extra popper needed) -->
<script src="{{ asset('assets/admin/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}" defer></script>

<!-- Font Awesome -->
<script src="{{ asset('assets/admin/js/vendors/font-awesome/fontawesome-min.js') }}" defer></script>

<!-- Password show/hide -->
<script src="{{ asset('assets/admin/js/password.js') }}" defer></script>

<!-- Custom Script -->
<script src="{{ asset('assets/admin/js/script.js') }}" defer></script>


      <!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
$(document).ready(function() {
    $("#registerForm").on("submit", function(e) {
        e.preventDefault();

        // Collect values using IDs
        let name = $("#name").val();
        let email = $("#email").val();
        let password = $("#password").val();

        $.ajax({
            url: "{{ route('registerUser') }}",
            type: "POST",
            data: {
                name: name,
                email: email,
                password: password,
                _token: "{{ csrf_token() }}" // important for Laravel
            },
            beforeSend: function() {
                toastr.info("Processing request...");
            },
            success: function(response) {
                toastr.success(response.message);

                // redirect after 1.5 sec
                setTimeout(function() {
                    window.location.href = "{{ route('admin.auth.login') }}";
                }, 1500);
            },
             error: function(xhr) {
                           if (xhr.status === 422) {
                              $.each(xhr.responseJSON.errors, function(key, value) {
                                    toastr.error(value[0]);
                              });
                           } else if (xhr.status === 401) {
                              toastr.error(xhr.responseJSON.message); // show your controller message
                           } else {
                              toastr.error("Something went wrong!");
                           }
                        }
        });
    });
});

</script>


    </div>
  </body>
</html>