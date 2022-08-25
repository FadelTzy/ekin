<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>E - Kinerja</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style>
        .bd-example-modal-lg .modal-dialog {
            display: table;
            position: relative;
            margin: 0 auto;
            top: calc(50% - 24px);
        }

        .bd-example-modal-lg .modal-dialog .modal-content {
            background-color: transparent;
            border: none;
        }
    </style>
    <!-- App css -->
    <link href="{{asset('minton/assets/css/bootstrap-creative.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{asset('minton/assets/css/app-creative.min.css')}}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <!-- icons -->
    @yield('cssadmin')
    <link href="{{asset('minton/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
</head>

<body class="loading" data-layout-mode="detached" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": true}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>

    <div id="wrapper">
        @yield('side')
        <div class="content-page">
            <div class="content">
                @yield('content')
            </div>

            <x-footer></x-footer>

        </div>
    </div>




    <!-- Vendor js -->
    <script src="{{asset('minton/assets/js/vendor.min.js')}}"></script>

    <!-- KNOB JS -->
    <script src="{{asset('minton/assets/libs/jquery-knob/jquery.knob.min.js')}}"></script>


    <!-- Dashboard init-->
    <script src="{{asset('minton/assets/js/pages/dashboard-sales.init.js')}}"></script>

    <!-- App js -->
    <script src="{{asset('minton/assets/js/app.min.js')}}"></script>
    @stack('jss')
</body>

</html>