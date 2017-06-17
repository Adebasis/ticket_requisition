<header class="bg-white header header-md navbar navbar-fixed-top-xs box-shadow">
    <div class="navbar-header aside-md dk">
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html"><i class="fa fa-bars"></i></a>
        <?php
		$appsettings = DB::table('appsettings')->where('id', 2)->get();
		?>
        <a href="{{ url('/adminpanel/') }}" class="navbar-brand"><img src="{{ url('/') }}/public/admin_assets/images/<?php echo $appsettings[0]->Value;?>" class="m-r-sm" alt="scale"><span class="hidden-nav-xs">eComps</span></a>
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user"><i class="fa fa-cog"></i></a>
    </div>
    <ul class="nav navbar-nav hidden-xs">
        <li class="dropdown">
        	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="i i-grid"></i></a>
            <section class="dropdown-menu aside-lg bg-white on animated fadeInLeft">
                <div class="row m-l-none m-r-none m-t m-b text-center">
                    <div class="col-xs-4">
                        <div class="padder-v">
                            <a href="#">
                            <span class="m-b-xs block">
                            <i class="i i-mail i-2x text-primary-lt"></i>
                            </span>
                            <small class="text-muted">Mailbox</small>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="padder-v">
                            <a href="#">
                                <span class="m-b-xs block">
                                <i class="i i-calendar i-2x text-danger-lt"></i>
                                </span>
                                <small class="text-muted">Calendar</small>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="padder-v">
                            <a href="#">
                                <span class="m-b-xs block">
                                <i class="i i-map i-2x text-success-lt"></i>
                                </span>
                                <small class="text-muted">Map</small>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="padder-v">
                            <a href="#">
                                <span class="m-b-xs block">
                                <i class="i i-paperplane i-2x text-info-lt"></i>
                                </span>
                                <small class="text-muted">Trainning</small>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="padder-v">
                            <a href="#">
                                <span class="m-b-xs block">
                                <i class="i i-images i-2x text-muted"></i>
                                </span>
                                <small class="text-muted">Photos</small>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="padder-v">
                            <a href="#">
                                <span class="m-b-xs block">
                                <i class="i i-clock i-2x text-warning-lter"></i>
                                </span>
                                <small class="text-muted">Timeline</small>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </li>
    </ul>
    <!--<form class="navbar-form navbar-left input-s-lg m-t m-l-n-xs hidden-xs" role="search">
    <div class="form-group">
    <div class="input-group">
    <span class="input-group-btn">
    <button type="submit" class="btn btn-sm bg-white b-white btn-icon"><i class="fa fa-search"></i></button>
    </span>
    <input type="text" class="form-control input-sm no-border" placeholder="Search apps, projects...">            
    </div>
    </div>
    </form>-->
    <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">
        <li class="hidden-xs" style="display:none1;">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="i i-chat3"></i>
            <?php
			$logs_total_count = DB::table('logs')->where('read_by_admin', 0)->count();
			$logs_count = DB::table('logs')->where('read_by_admin', 0)->orderBy('created_date', 'desc')->take(5)->get();
			if(count($logs_count) > 0){
			?>
            <span class="badge badge-sm up bg-primary count1">!</span>
            <?php }?>
          </a>
          <section class="dropdown-menu aside-xl animated fadeInDown">
            <section class="panel bg-white">
              <div class="panel-heading b-light bg-light">
                <strong>You have <span class="count"><?php echo $logs_total_count - 1;?></span> notifications</strong>
              </div>
              <div class="list-group list-group-alt">
                <?php
				foreach ($logs_count as $index=>$logs){
					
				?>
                <a href="#" class="media list-group-item">
					<span class="media-body block m-b-none">
                  		<?php if($logs->user_type=='fulfiler'){?>
						<i class="glyphicon glyphicon-star-empty" style="color:#C0C;"></i>&nbsp;<?php echo ucwords($logs->user_name);?>
                        <?php }?>
                        <?php if($logs->user_type=='first'){?>
						<i class="glyphicon glyphicon glyphicon-asterisk" style="color:#090;"></i>&nbsp;<?php echo ucwords($logs->user_name);?>
                        <?php }?>
                        <?php if($logs->user_type=='second'){?>
						<i class="fa fa-mortar-board" style="color:#C03;"></i>&nbsp;<?php echo ucwords($logs->user_name);?>
                        <?php }?>
                        <?php if($logs->user_type=='admin'){?>
						<i class="glyphicon glyphicon-star-empty" style="color:#C0C;"></i>&nbsp;<?php echo ucwords($logs->user_name);?>
                        <?php }?>
                        <?php if($logs->user_type=='vp'){?>
						<i class="fa fa-life-ring" style="color:#09C;"></i>&nbsp;<?php echo ucwords($logs->user_name);?>
                        <?php }?>
                        <?php if($logs->user_type=='user'){?>
						<i class="glyphicon glyphicon-user" style="color:#0C6;"></i>&nbsp;<?php echo ucwords($logs->user_name);?>
                        <?php }?>
                  	</span>
                  <span class="media-body block1 text-sm m-b-none">
                    <?php echo $logs->descr;?><br>
                    <small class="text-muted"><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($logs->created_date))->diffForHumans();?></small>
                  </span>
                </a>
                <?php }?>
              </div>
              <div class="panel-footer text-sm text-center">
                <a class="pull-right1"><i class="fa fa-cog"></i></a>
                <a href="{{ url('/adminpanel/events/logs') }}">See all the notifications</a>
              </div>
            </section>
          </section>
        </li>
        
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="thumb-sm avatar pull-left">
                <img src="{{ url('/') }}/public/admin_assets/images/a0.png" alt="...">
                </span>
                {!! Session::get('ecomps_user_full_name') !!} <b class="caret"></b>
            </a>
            <?php
			$subadmin = Session::get('ecomps_subadmin');
			$ecomps_admin_id = Session::get('ecomps_admin_id');
			$pages = DB::table('subadmin')->select('allow_pages')->where('id', '=', $ecomps_admin_id)->get();
			$allow_pages = array();
			if(count($pages) > 0){
				$allow_pages = $pages[0]->allow_pages;
				$allow_pages = explode(",", $allow_pages);
			}
			?>
            <ul class="dropdown-menu animated fadeInRight">            
                <?php
				if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('smtp', $allow_pages))){
				?>
                <li><span class="arrow top"></span><a href="{{ url('/adminpanel/settings') }}">SMTP Settings</a></li>
                <?php }?>
				<?php
                if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('smtp-test', $allow_pages))){
                ?>
                <li><a href="{{ url('/adminpanel/test-mail') }}">SMTP Test Mail</a></li>
                <?php }?>
				<?php
                if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('apps', $allow_pages))){
                ?>
                <li><a href="{{ url('/adminpanel/apps-settings') }}">Apps Settings</a></li>
                <?php }?>
                <?php
                if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('db', $allow_pages))){
                ?>
                <li><a href="{{ url('/adminpanel/database/backup') }}">DB Backup</a></li>
                <?php }?>
                <li class="divider"></li>
                <li><a href="{{ url('/adminpanel/profile') }}">Profile</a></li>
                <li><a href="{{ url('/adminpanel/change-password') }}">Change Password</a></li>
                <li class="divider"></li>
                <li><a href="{{ url('/adminpanel/logout') }}" >Logout</a></li>
            </ul>
        </li>
    </ul>      
</header>