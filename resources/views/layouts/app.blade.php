<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App css -->
    <link href="{{asset('minton/assets/css/bootstrap-creative.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{asset('minton/assets/css/app-creative.min.css')}}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <!-- icons -->
    <link href="{{asset('minton/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    @yield('cssadmin')
</head>

<body class="loading" data-layout-mode="horizontal" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>
    <div id="app">
        <main class="">
            @yield('content')
        </main>
    </div>

    <!-- Vendor js -->
    <script src="{{asset('minton/assets/js/vendor.min.js')}}"></script>

    <!-- KNOB JS -->
    <script src="{{asset('minton/assets/libs/jquery-knob/jquery.knob.min.js')}}"></script>

    <!-- App js -->
    <script src="{{asset('minton/assets/js/app.min.js')}}"></script>
    @stack('jss')
</body>

</html>