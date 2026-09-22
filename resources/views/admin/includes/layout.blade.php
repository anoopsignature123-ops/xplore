@php
    $settings= settingData();
@endphp
@include('admin.includes.header')
@include('admin.includes.navbar')
@include('admin.includes.sidebar')
@yield('content')
@include('admin.includes.footer')

