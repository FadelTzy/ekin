@extends('layouts.app')

@section('cssadmin')

@yield('cssc')
@endsection

@section('content')
<div id="wrapper">


    <x-unavbar></x-unavbar>

    <x-topbar>
    </x-topbar>

    <div class="content-page">@yield('body')
        <x-footer></x-footer>
    </div>

</div>
@endsection


@push('jss')
<script src="{{asset('minton/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('minton/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('minton/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('minton/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('minton/assets/libs/jquery-toast-plugin/jquery.toast.min.js')}}"></script>
<script src="{{asset('minton/assets/js/pages/toastr.init.js')}}"></script>
@stack('js')
@endpush