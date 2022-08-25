    <!-- ========== Left Sidebar Start ========== -->
    <div class="left-side-menu">



        <div class="h-100" data-simplebar>
            <!-- User box -->
            <div class="user-box text-center">
                <img src="{{asset('img/none.jpg')}}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
                <div class="dropdown">
                    <a href="javascript: void(0);" class="text-reset dropdown-toggle h5 mt-2 mb-1 d-block" data-toggle="dropdown">{{Auth::guard('admin')->user()->name}}</a>

                </div>
                <p class="text-reset">{{Auth::guard('admin')->user()->username}}</p>
            </div>

            <!--- Sidemenu -->
            <div id="sidebar-menu">

                <ul id="side-menu">

                    <li class="menu-title">Menu</li>
                    <li class="active">
                        <a href="{{route('admin.ds')}}">
                            <i class="ri-dashboard-line"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>


                    <li>
                        <a href="#sidebarLayouts" data-toggle="collapse">
                            <i class="ri-layout-line"></i>
                            <span> Data Master </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarLayouts">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{route('periodes.index')}}">
                                        Periode
                                    </a>

                                </li>

                                <li>
                                    <a href="{{route('pegawai.index')}}">
                                        Pegawai
                                    </a>

                                </li>



                                <li>
                                    <a href="{{route('jabatans.index')}}">
                                        Tupoksi
                                    </a>

                                </li>


                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#sidebarLayouts2" data-toggle="collapse">
                            <i class="ri-layout-line"></i>
                            <span> Manajemen </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarLayouts2">
                            <ul class="nav-second-level">

                                <li>
                                    <a href="{{route('m_pegawai.index')}}">
                                        Periode Pegawai
                                    </a>

                                </li>
                                <li>
                                    <a href="{{route('m_pegawai.index2')}}">
                                        Periode Tahunan
                                    </a>

                                </li>


                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#sidebarLayouts3" data-toggle="collapse">
                            <i class="ri-layout-line"></i>
                            <span> Monitoring </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarLayouts3">
                            <ul class="nav-second-level">

                                <li>
                                    <a href="{{route('skp.monitoring')}}">
                                        Rencana SKP
                                    </a>

                                </li>
                                <li>
                                    <a href="{{route('log.monitoring')}}">
                                        Log Harian
                                    </a>

                                </li>


                            </ul>
                        </div>
                    </li>
                    <li class="active">
                        <a href="{{route('admin.ds')}}">
                            <i class="ri-dashboard-line"></i>
                            <span> PPKP </span>
                        </a>
                    </li>



                    <li class="menu-title mt-2">Admin</li>

                    <li>
                        <a href="{{route('admin.profile')}}">
                            <i class="ri-shield-user-line"></i>
                            <span> Profil </span>
                        </a>

                    </li>
                    <li>
                        <a href="{{route('admin.user')}}">
                            <i class="ri-user-add-line"></i>
                            <span> Admin </span>
                        </a>

                    </li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="ri-logout-box-line"></i>
                            <span>Logout</span>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </a>
                    </li>


                </ul>

            </div>
            <!-- End Sidebar -->

            <div class="clearfix"></div>

        </div>
        <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->