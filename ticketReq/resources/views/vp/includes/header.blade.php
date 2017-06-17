<header class="bg-white header header-md navbar navbar-fixed-top-xs box-shadow">
    <div class="navbar-header aside-md dk">
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html"><i class="fa fa-bars"></i></a>
        <a href="{{ url('/vice-president') }}" class="navbar-brand"><img src="{{ url('/') }}/public/admin_assets/images/logo.png" class="m-r-sm" alt="scale"><span class="hidden-nav-xs">eComps</span></a>
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user"><i class="fa fa-cog"></i></a>
    </div>
    <ul class="nav navbar-nav hidden-xs">
        <li class="dropdown">
        	<!--<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="i i-grid"></i></a>-->
        </li>
    </ul>
    <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">
        <!--<li class="hidden-xs"><a href="{{ url('/new/request') }}">New Request</a></li>
        <li class="hidden-xs"><a href="{{ url('/vice-president/game/calender') }}">Event Calendar</a></li>
        <li class="hidden-xs"><a href="{{ url('/vice-president/history') }}">History</a></li>-->
        <!--<li class="dropdown hidden-xs">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="thumb-sm avatar pull-left i-settings">
                </span>Help<b class="caret"></b>
            </a>
            <ul class="dropdown-menu pull-right animated fadeInRight">            
                <li><span class="arrow top"></span><a href="{{ url('/contact') }}">Contact Info</a></li>
                <li><a href="{{ url('/game/calender') }}">Game Calendar</a></li>
                <li class="divider"></li>
                <li><a href="#" >About Credit</a></li>
            </ul>
        </li>-->
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="thumb-sm avatar pull-left">
                <img src="{{ url('/') }}/public/admin_assets/images/a0.png" alt="...">
                </span>
                {!! Session::get('ecomps_vp_name') !!} <b class="caret"></b>
            </a>
            <ul class="dropdown-menu animated fadeInRight">
                <li><a href="#">Profile</a></li>
                <li><a href="#">Change Password</a></li>
                <li class="divider"></li>
                <li><a href="{{ url('/vice-president/logout') }}" >Logout</a></li>
            </ul>
        </li>
    </ul>      
</header>