@php
    $settings= settingData();
@endphp
@include('vendor.includes.header')
@include('vendor.includes.navbar')
@include('vendor.includes.sidebar')
@yield('content')
@include('vendor.includes.footer')
