<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Jobs Hunt')</title>
    <meta name="description" content="@yield('description', 'Jobs Hunt')" />
    <meta name="keywords" content="@yield('keywords', 'Jobs Hunt')" />
    
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">
    <!-- ogp -->
    <meta property="og:url" content="@yield('ogurl', url('/'))" />
    <meta property="og:type" content="@yield('ogtype', 'website')" />
    <meta property="og:title" content="@yield('ogtitle', 'Jobs Hunt')" />
    <meta property="og:description" content="@yield('ogdescription', 'Jobs Hunt')" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{asset('custom/css/bootstrap-grid.css')}}" />
    <link rel="stylesheet" href="{{asset('custom/css/icons.css')}}">
    <link rel="stylesheet" href="{{asset('custom/css/animate.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('custom/css/style.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('custom/css/responsive.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('custom/css/chosen.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('custom/css/colors/colors.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('custom/css/bootstrap.css')}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('styles')
</head>
<body>
<div class="theme-layout" id="scrollup">
  @include('layouts.user.header')
<div id="app">
    <div id="page-wrapper">
        @yield('content')
    </div>
</div>


<!-- Scripts -->
{{-- <div class="f-height"> --}}
  @include('layouts.user.footer')
{{-- </div> --}}
</div>

{{-- <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script> --}}
<script src="{{asset('custom/js/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('custom/js/modernizr.js')}}" type="text/javascript"></script>
<script src="{{asset('custom/js/script.js')}}" type="text/javascript"></script>
<script src="{{asset('custom/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('custom/js/wow.min.js')}}" type="text/javascript"></script>
<script src="{{asset('custom/js/slick.min.js')}}" type="text/javascript"></script>
<script src="{{asset('custom/js/parallax.js')}}" type="text/javascript"></script>
<script src="{{asset('custom/js/select-chosen.js')}}" type="text/javascript"></script>
<script>
  var loc = window.location.pathname;
  if (loc == '/') {
    $('.stick-top').removeClass('gradient')
  } else {
    $('.stick-top').addClass('gradient')
  }
</script>
@stack('script')
</body>
</html>
