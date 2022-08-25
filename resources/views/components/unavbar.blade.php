<!-- Topbar Start -->
<div class="navbar-custom">
    <div class="container-fluid">

        <ul class="list-unstyled topnav-menu float-right mb-0 ">
            <li class=" ">
                <a class="nav-link   ">
                    <div class="text-white pro-user-name ml-1 d-flex flex-column">
                        <b> {{ Auth::user()->jabatan }} / {{ Auth::user()->nama }} <small class="mdi mdi-circle text-success"></small> </b>
                    </div>

                </a>

            </li>




        </ul>

        <!-- LOGO -->
        <div class="logo-box">


            <a href="index.html" class="logo logo-light text-center">
                <span class="logo-sm">
                    <img src="{{asset('img/01ekinerja.jpg')}}" alt="" height="24">
                </span>
                <span class="logo-lg">
                    <div class="text-white pro-user-name ml-1 d-flex flex-column">
                        <b style="font-size: x-large;"> E - KINERJA </b>
                    </div>
                </span>
            </a>
        </div>

        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>
            </li>

            <li>
                <!-- Mobile menu toggle (Horizontal Layout)-->
                <a class="navbar-toggle nav-link" data-toggle="collapse" data-target="#topnav-menu-content">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
</div>
<!-- end Topbar -->