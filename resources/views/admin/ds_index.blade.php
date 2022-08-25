@extends('layouts.base')

@section('cssadmin')
@if(Route::current()->getName() != 'admin.ds')
<link href="{{asset('minton/assets/libs/jquery-toast-plugin/jquery.toast.min.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('minton/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@yield('cssc')
@endif

@endsection
@section('side')
<x-sidebar></x-sidebar>
@endsection
@section('content')
<!-- Topbar Start -->
<x-navbar></x-navbar>
<!-- end Topbar -->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box page-title-box-alt">
                @yield('breadcrumb')
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div id="page-main">
        @yield('body')
    </div>
</div>
@endsection

@push('jss')
@if(Route::current()->getName() != 'admin.ds')

<script src="{{asset('minton/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('minton/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('minton/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('minton/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
<!-- Tost-->
<script src="{{asset('minton/assets/libs/jquery-toast-plugin/jquery.toast.min.js')}}"></script>

<script src="{{asset('minton/assets/js/pages/toastr.init.js')}}"></script>
@endif
@stack('js')
@endpush