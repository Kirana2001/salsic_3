<div class="navbar navbar-expand-md navbar-dark bg-blue-700">
    <div class="navbar-brand">
        <a href="{{url('/dashboard')}}" class="d-inline-block">
            <img src="{{asset('/images/salsic-logo.png')}}" alt="" style="height:45px;object-fit: contain;">
        </a>
    </div>

    <div class="d-md-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-tree5"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                    <i class="icon-paragraph-justify3"></i>
                </a>
            </li>
        </ul>

        <span class="badge ml-md-3 mr-md-auto">&nbsp;</span>

        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
					<img src="{{asset('global_assets/images/user-default.png') }}" class="rounded-circle mr-2"
						height="34" alt="">
					<span>{{Auth::user()->name}}</span>
				</a>

				<div class="dropdown-menu dropdown-menu-right">
					<a href="{{ url('/ubah-password') }}" class="dropdown-item"><i class="icon-cog5"></i> Ubah Password</a>
					<a href="{{ url('/logout') }}" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
				</div>
            </li>

        </ul>
    </div>
</div>
