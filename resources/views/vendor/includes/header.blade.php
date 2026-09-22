<!DOCTYPE html >
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   	<title>@yield('title', ' Vendor Panel ')</title>    
    <!-- Favicon icon-->
    <link rel="icon" href="{{ !empty($settings->favicon) ? asset($settings->favicon) : '' }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ !empty($settings->favicon) ? asset($settings->favicon) : '' }}" type="image/x-icon">
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
      <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,500;6..12,600;6..12,700;6..12,800;6..12,900;6..12,1000&display=swap" rel="stylesheet">
        <!-- Flag icon css -->
        <link rel="stylesheet" href="{{ asset('assets/admin/css/vendors/flag-icon.css') }}">

        <!-- Themify Icons (CDN) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/themify-icons@0.1.2/css/themify-icons.css">

        <!-- Bulk custom styles -->
        <link rel="stylesheet" href="{{ asset('assets/admin/css/bulk-style.css') }}">

        <!-- Icon libraries -->
        <link rel="stylesheet" href="{{ asset('assets/admin/css/themify.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/css/fontawesome-min.css') }}">

        <!-- Vendor CSS -->
        <link rel="stylesheet" href="{{ asset('assets/admin/css/vendors/weather-icons/weather-icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/css/vendors/scrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/css/vendors/datatables.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/css/vendors/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/css/vendors/slick-theme.css') }}">

        <!-- App Theme & Core CSS -->
        <link id="color" rel="stylesheet" href="{{ asset('assets/admin/css/color-1.css') }}" media="screen">
        <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">


    <!-- Latest Font Awesome 6 Free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-RXf+QSDCUQsY2Hkn3E9sh9c5N2yqG+pG6G+X5M6GkVfF5z1p5aT8GZgN4J2tFJkfn7+N5e6L3aJKD2wT+6iW8g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- select 2 -->

   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
       <!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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


<style>
  /* Select2 ko Bootstrap form-control jaise banane ke liye */
.select2-container {
    width: 100% !important;
    display: block !important;
}

.select2-container--default .select2-selection--single {
    height: 45px !important;   /* Regular Bootstrap input height */
    border: 1px solid #ced4da;
    border-radius: 0.375rem;   /* Bootstrap border radius */
    padding: 10px 12px;
    font-size: 14px;
    display: flex !important;
    align-items: center;
    position: relative;
    background-color: #fff;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #495057;
    padding-left: 0 !important;
    padding-right: 20px !important; /* Space for the arrow */
    width: 100%;
    line-height: normal !important;
    text-align: left;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 100% !important;
    top: 0 !important;
    right: 8px !important;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Small Select2: jab filter ya list view me ho (form-select-sm ke sath) */
select.form-select-sm + .select2-container .select2-selection--single {
    height: 31px !important;   /* Small Bootstrap input height (form-control-sm) */
    padding: 4px 10px;
    font-size: 14px;
    border-radius: 0.25rem;
}

select.form-select-sm + .select2-container .select2-selection--single .select2-selection__rendered {
    padding-right: 15px !important;
}

select.form-select-sm + .select2-container .select2-selection--single .select2-selection__arrow {
    right: 6px !important;
}


span.dropdown-wrapper {
    display: none;
} 
.page-header .logo-wrapper .close-btn {
    background-color: rgba(48, 142, 135, 0.2);
}

.page-header .logo-wrapper .close-btn .svg-color {
    stroke: var(--theme-default) !important;
}

.page-header .logo-wrapper .close-btn:hover {
    background-color: rgba(48, 142, 135, 0.2);
}

.page-header .logo-wrapper .close-btn:hover .svg-color {
    stroke: var(--theme-default) !important;
}

</style>
    @stack('styles') 

<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (window.innerWidth <= 768) {
            document.querySelector("#pageWrapper").classList.add("sidebar-open");
        }
    });
</script>

  </head>
