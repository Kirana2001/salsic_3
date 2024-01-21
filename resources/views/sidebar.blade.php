<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md bg-blue-700">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content">

        {{-- <!-- User menu -->
        <div class="sidebar-user">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <div class="media-title font-weight-semibold">{{Auth::user()->name}}</div>
                        <div class="font-size-xs opacity-50">
                            <i class="icon-user font-size-sm"></i> &nbsp;{{Auth::user()->role->name}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu --> --}}


        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- main -->
                {{-- <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li> --}}
                <li class="nav-item">
                    <a href="{{url('/dashboard')}}" class="nav-link {{request()->is('dashboard') ? 'active' : ''}}">
                        <i class="icon-home4"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>

                @if (in_array(Auth::user()->role_id, [1]))
                <li class="nav-item">
                    <a href="{{url('/users')}}" class="nav-link {{request()->is('users*') ? 'active' : ''}}">
                        <i class="icon-users"></i>
                        <span>
                            User
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{url('/atlets')}}" class="nav-link {{request()->is('atlets*') ? 'active' : ''}}">
                        <i class="icon-user"></i>
                        <span>
                            Atlet
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{url('/pelatih')}}" class="nav-link {{request()->is('pelatih*') ? 'active' : ''}}">
                        <i class="icon-user"></i>
                        <span>
                            Pelatih
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{url('/wasit')}}" class="nav-link {{request()->is('wasit*') ? 'active' : ''}}">
                        <i class="icon-user"></i>
                        <span>
                            Wasit
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{url('/arena')}}" class="nav-link {{request()->is('arena*') ? 'active' : ''}}">
                        <i class="icon-home7"></i>
                        <span>
                            Arena
                        </span>
                    </a>
                </li>

                <li class="nav-item nav-item-submenu {{request()->is(['pemudas*', 'anggotas*']) ? 'active nav-item-expanded nav-item-open' : ''}}">
                    <a href="#" class="nav-link"><i class="icon-users4"></i> <span>Manajemen Pemuda</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        <li class="nav-item">
                            <a href="{{url('/pemudas')}}" class="nav-link {{request()->is('pemudas*') ? 'active' : ''}}">
                                <span>
                                    Organisasi
                                </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{url('/anggotas')}}" class="nav-link {{request()->is('anggotas*') ? 'active' : ''}}">
                                <span>
                                    Anggota
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-item-submenu {{request()->is(['pendaftaran*', 'peminjaman*']) ? 'active nav-item-expanded nav-item-open' : ''}}">
                    <a href="#" class="nav-link"><i class="icon-list-unordered"></i> <span>Manajemen User</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        <li class="nav-item">
                            <a href="{{url('/pendaftaran-atlets')}}" class="nav-link {{request()->is('pendaftaran-atlets*') ? 'active' : ''}}">
                                <span>
                                    Pendaftaran Atlet
                                </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{url('/pendaftaran-pelatih')}}" class="nav-link {{request()->is('pendaftaran-pelatih*') ? 'active' : ''}}">
                                <span>
                                    Pendaftaran Pelatih
                                </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{url('/pendaftaran-wasit')}}" class="nav-link {{request()->is('pendaftaran-wasit*') ? 'active' : ''}}">
                                <span>
                                    Pendaftaran Wasit
                                </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{url('/peminjaman-arena')}}" class="nav-link {{request()->is('peminjaman-arena*') ? 'active' : ''}}">
                                <span>
                                    Peminjaman Arena
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-item-submenu {{request()->is(['articles*', 'events*','jadwal*','profiles*']) ? 'active nav-item-expanded nav-item-open' : ''}}">
                    <a href="#" class="nav-link"><i class="icon-mobile2"></i> <span>Manajemen Aplikasi</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        <li class="nav-item">
                            <a href="{{url('/articles')}}" class="nav-link {{request()->is('articles*') ? 'active' : ''}}">
                                <i class="icon-file-text"></i>
                                <span>
                                    Artikel
                                </span>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        <li class="nav-item">
                            <a href="{{url('/events')}}" class="nav-link {{request()->is('events*') ? 'active' : ''}}">
                                <i class="icon-file-text"></i>
                                <span>
                                    Event
                                </span>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        <li class="nav-item">
                            <a href="{{url('/jadwal')}}" class="nav-link {{request()->is('jadwal*') ? 'active' : ''}}">
                                <i class="icon-file-text"></i>
                                <span>
                                    Jadwal
                                </span>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        <li class="nav-item">
                            <a href="{{url('/profiles')}}" class="nav-link {{request()->is('profiles*') ? 'active' : ''}}">
                                <i class="icon-file-text"></i>
                                <span>
                                    Profile
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                @if (!in_array(Auth::user()->role_id, [1]))
                <li class="nav-item">
                    <a href="{{url('/profile')}}" class="nav-link {{request()->is('profile*') ? 'active' : ''}}">
                        <i class="icon-user"></i>
                        <span>
                            Profile
                        </span>
                    </a>
                </li>
                @endif
                <!-- /main -->

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
