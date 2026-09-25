<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>{{ $settings->company_name ?? 'Builder Portal' }} | @yield('title')</title>
      <link rel="icon" href="{{ !empty($settings->favicon) ? asset($settings->favicon) : '' }}" type="image/x-icon">
      <link rel="shortcut icon" href="{{ !empty($settings->favicon) ? asset($settings->favicon) : '' }}" type="image/x-icon">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
      <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,500;6..12,600;6..12,700;6..12,800;6..12,900;6..12,1000&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="{{ asset('assets/admin/css/iconly-icon.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/admin/css/themify.css') }}">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
      <link rel="stylesheet" href="{{ asset('assets/admin/css/fontawesome-min.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/admin/css/vendors/datatables.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/admin/css/bulk-style.css') }}">
      <link id="color" rel="stylesheet" href="{{ asset('assets/admin/css/color-1.css') }}" media="screen">
      <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
   </head>
