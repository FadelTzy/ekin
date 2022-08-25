     <!-- Topbar Start -->
     <div class="navbar-custom">
         <div class="container-fluid">

             <ul class="list-unstyled topnav-menu float-right mb-0">





                 <li class="dropdown d-none d-lg-inline-block">
                     <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen" href="#">
                         <i class="fe-maximize noti-icon"></i>
                     </a>
                 </li>



                 <li class="dropdown notification-list topbar-dropdown">
                     <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                         <i class="fe-bell noti-icon"></i>
                         <span class="badge badge-danger rounded-circle noti-icon-badge">5</span>
                     </a>
                     <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                         <!-- item-->
                         <div class="dropdown-item noti-title">
                             <h5 class="m-0">
                                 <span class="float-right">
                                     <a href="" class="text-dark">
                                         <small>Clear All</small>
                                     </a>
                                 </span>Notification
                             </h5>
                         </div>

                         <div class="noti-scroll" data-simplebar>

                             <!-- item-->
                             <a href="javascript:void(0);" class="dropdown-item notify-item active">
                                 <div class="notify-icon bg-soft-primary text-primary">
                                     <i class="mdi mdi-comment-account-outline"></i>
                                 </div>
                                 <p class="notify-details">Doug Dukes commented on Admin Dashboard
                                     <small class="text-muted">1 min ago</small>
                                 </p>
                             </a>



                         </div>

                         <!-- All-->
                         <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                             View all
                             <i class="fe-arrow-right"></i>
                         </a>

                     </div>
                 </li>

                 <li class="dropdown notification-list topbar-dropdown">
                     <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                         <span class="pro-user-name ml-1">
                             Welcome, {{Auth::guard('admin')->user()->name}} <i class="mdi mdi-chevron-down"></i>
                         </span>
                     </a>
                     <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                         <!-- item-->


                         <!-- item-->
                         <a href="javascript:void(0);" class="dropdown-item notify-item">
                             <i class="ri-account-circle-line"></i>
                             <span>Profil</span>
                         </a>




                         <!-- item-->
                         <a href="javascript:void(0);" class="dropdown-item notify-item">
                             <i class="ri-message-line"></i>
                             <span>Pesan</span>
                         </a>

                         <div class="dropdown-divider"></div>

                         <!-- item-->

                         <a class="dropdown-item notify-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                             <i class="ri-logout-box-line"></i>
                             <span>Keluar</span>
                         </a>
                         <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                             @csrf
                         </form>
                     </div>
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