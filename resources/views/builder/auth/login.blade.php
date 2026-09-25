<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Builder & Contractor Portal | Login</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
      <link rel="stylesheet" href="{{ asset('assets/admin/css/fontawesome-min.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
   </head>
   <body class="bg-light d-flex align-items-center justify-content-center min-vh-100 py-5">
      <div class="container" style="max-width: 450px;">
         <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4 p-sm-5">
               <div class="text-center mb-4">
                  <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                     <i class="fas fa-city fa-2x"></i>
                  </div>
                  <h3 class="fw-bold text-primary">Builder Portal</h3>
                  <p class="text-muted">Architects & Construction Professionals</p>
               </div>

               @if(session('error'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                     {{ session('error') }}
                     <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>
               @endif

               @if(session('success'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                     {{ session('success') }}
                     <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>
               @endif

               <form action="{{ route('builder.checkLogin') }}" method="POST">
                  @csrf
                  <div class="mb-3">
                     <label class="form-label fw-bold"><i class="fas fa-envelope text-primary me-1"></i> Email Address</label>
                     <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-user text-muted"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="info@skylinearchitects.com" value="{{ old('email') }}" required autofocus>
                     </div>
                  </div>

                  <div class="mb-3">
                     <label class="form-label fw-bold"><i class="fas fa-lock text-primary me-1"></i> Password</label>
                     <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-key text-muted"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                     </div>
                  </div>

                  <div class="form-check mb-3">
                     <input class="form-check-input" type="checkbox" name="remember" id="remember">
                     <label class="form-check-label" for="remember">Remember Me</label>
                  </div>

                  <button type="submit" class="btn btn-primary w-100 py-2 fw-bold"><i class="fas fa-sign-in-alt me-1"></i> Sign In to Portal</button>
               </form>
            </div>
         </div>
      </div>
   </body>
</html>
