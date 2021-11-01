<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v3.4.0
* @link https://coreui.io
* Copyright (c) 2020 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->

<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>@yield('title', 'Jobs Hunt')</title>
    {{-- <link rel="shortcut icon"  href="https://t3.ftcdn.net/jpg/03/62/56/24/360_F_362562495_Gau0POzcwR8JCfQuikVUTqzMFTo78vkF.jpg"> --}}
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Main styles for this application-->
    <link href="{{ asset('coreui/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome-free.min.css') }}" rel="stylesheet">
    <link href="{{ asset('summernote/dist/summernote-lite.min.css') }}" rel="stylesheet">
    
    @yield('style')
    @stack('style')
</head>
<body class="c-app">
@include('layouts.admin.sidebar')
<div class="c-wrapper c-fixed-components">
    @include('layouts.admin.header')
    <div class="c-body">
        <main class="c-main">
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>
        @include('layouts.admin.footer')
    </div>
</div>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src={{ asset('summernote/dist/summernote-lite.min.js') }}></script>
<script src={{ asset('summernote/dist/lang/summernote-vi-VN.js') }}></script>
@php
    $name = Route::current()->getName();
@endphp
@if ($name == 'admin.blogs.edit' || $name == 'admin.blogs.create' || $name == 'admin.recruitment.create' || $name == 'admin.recruitment.update')
@else
    <script src="{{ asset('coreui/js/coreui.js') }}"></script> 
@endif
@stack('script')
</body>
</html>
