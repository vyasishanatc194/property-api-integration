<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title','Home') | {{ config('app.name') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta content='text/html;charset=utf-8' http-equiv='content-type'>
        <meta content='{{ config('app.name') }}' name='description'>
        <link href='{{ asset('favicon.png') }}' rel='shortcut icon' type='image/x-icon'>
        @include('frontend.include.cssfiles')
        @stack('css')
    </head>

    <body class="@yield('body_class','')">
        
        <div class="wrapper nav-collapsed menu-collapsed">
            @include('frontend.include.sidebar')
            @include('frontend.include.topnav')
            <div class="main-panel">
                <div class="main-content">
                    <div class="content-wrapper">
                        @yield('content')
                        @include('frontend.include.footer')
                    </div>
                </div>
            </div>
        </div>
    </body>
    @include('frontend.include.jsfiles')
    @include('frontend.include.page_notification')
    
    
<script>
// Common script for all pages
    $(document).ready(function () {

    });
</script>
@stack('js')


</body>
</html>