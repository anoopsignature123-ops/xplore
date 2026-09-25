@php
    $settings = settingData();
@endphp
@include('builder.includes.header')
@include('builder.includes.navbar')
@include('builder.includes.sidebar')
@yield('content')
@include('builder.includes.footer')
