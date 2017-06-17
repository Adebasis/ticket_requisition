<header class="bg-white header header-md navbar navbar-fixed-top-xs box-shadow">
    <div class="navbar-header aside-md dk">
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target="#nav"><i class="fa fa-bars"></i></a>
        <?php
        $appsettings = DB::table('appsettings')->where('id', 2)->get();
        ?>
        <a href="{{ url('/') }}" class="navbar-brand"><img src="{{ url('/') }}/public/admin_assets/images/<?php echo $appsettings[0]->Value; ?>" class="m-r-sm" alt="scale"><span class="hidden-nav-xs">eComps</span></a>
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user"><i class="fa fa-cog"></i></a>
    </div>
	<?php
	$ecomps_user_id = trim(Session::get('ecomps_user_id'));
	$is_subadmin = DB::table("subadmin")->where("user_id", $ecomps_user_id)->count();
	?>
    <ul class="nav navbar-nav hidden mobile-menu" id="nav">
		<?php if (!Session::has('ecomps_vp_id')) { ?>
            <li class="dropdown"><a style="cursor:pointer;" data-toggle="modal" data-target="#myGameModal">New Request</a></li>
            <li class="dropdown"><a href="{{ url('/history') }}">History</a></li>
        <?php } ?>
        <?php if (trim(Session::get('ecomps_user_approver_level')) == "first" || trim(Session::get('ecomps_user_approver_level')) == "second" || Session::get('ecomps_user_is_fulfiler') == "1") { ?>
            <li class="dropdown"><a href="{{ url('/chart') }}">Chart</a></li>
        <?php } ?>
        <?php if ($is_subadmin > 0) {?>
            <li class="dropdown"><a href="{{ url('/adminpanel/useraccount') }}" target="_blank">Go to Admin</a></li>
        <?php } ?>
        <?php if (Session::has('ecomps_vp_id')) { ?>
            <li class="dropdown"><a href="{{ url('/vp-approve/my-requests') }}">My Requests</a></li>
            <li class="dropdown"><a href="{{ url('/vp-approve/requests') }}">Pending Requests</a></li>
            <li class="dropdown"><a href="{{ url('/vp-approve/history') }}">History</a></li>
        <?php } ?>
        
    </ul>
    <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">

        <?php if (!Session::has('ecomps_vp_id')) { ?>
            <li class="hidden-xs"><a style="cursor:pointer;" data-toggle="modal" data-target="#myGameModal">New Request</a></li>
            <li class="hidden-xs"><a href="{{ url('/history') }}">History</a></li>
        <?php } ?>
        <?php if (trim(Session::get('ecomps_user_approver_level')) == "first" || trim(Session::get('ecomps_user_approver_level')) == "second" || Session::get('ecomps_user_is_fulfiler') == "1") { ?>
            <li class="hidden-xs"><a href="{{ url('/chart') }}">Chart</a></li>
        <?php } ?>
        <?php if ($is_subadmin > 0) {?>
            <li class="hidden-xs"><a href="{{ url('/adminpanel/requests') }}" target="_blank">Go to Admin</a></li>
        <?php } ?>
        <?php if (Session::has('ecomps_vp_id')) { ?>
            <li class="hidden-xs"><a href="{{ url('/vp-approve/my-requests') }}">My Requests</a></li>
            <li class="hidden-xs"><a href="{{ url('/vp-approve/requests') }}">Pending Requests</a></li>
            <li class="hidden-xs"><a href="{{ url('/vp-approve/history') }}">History</a></li>
        <?php } ?>
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
                {!! Session::get('ecomps_user_name') !!} <b class="caret"></b>
            </a>
            <ul class="dropdown-menu animated fadeInRight">
                <!--<li><span class="arrow top"></span><a href="#">Settings</a></li>-->
                <li><a href="{{ url('/account/profile') }}">Profile</a></li>
                <li><a href="{{ url('/account/change-password') }}">Change Password</a></li>
                <li class="divider"></li>
                <li><a href="{{ url('/logout') }}" >Logout</a></li>
            </ul>
        </li>
    </ul>
</header>