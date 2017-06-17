<aside class="bg-default aside-md hidden-print hidden-xs" id="nav">          
    <section class="vbox">
        <section class="w-f scrollable">
            <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2">
                
                <script>
				function redirectme(path){
					var url = $('#tmp_site_url').val();
					window.location = url + path;
				}
				</script> 
                <style>.dk li{cursor:pointer;}</style>
                <input type="hidden" value="{{ url('/') }}" id="tmp_site_url" />
                <!-- nav -->
                <nav class="nav-primary hidden-xs">
                <div class="text-muted text-sm hidden-nav-xs padder m-t-sm m-b-sm"></div>
                    <ul class="nav nav-main" data-ride="collapse">
                        <li style="cursor:pointer; border-bottom:dotted 1px #ccc;">
                            <a class="auto" onclick="redirectme('/adminpanel/home');"><i class="i i-home icon"></i><span class="font-bold">Home<!--{{ request()->segment(2) }}--></span></a>
                        </li>
                        <li class="active" >
                            <a href="javascript:void(0);" class="auto">
                                <span class="pull-right text-muted"><i class="i i-circle-sm-o text"></i><i class="i i-circle-sm text-active"></i></span>
                                <b class="badge bg-danger pull-right"></b><i class="i i-stack icon"></i>
                                <span class="font-bold">Initial Setup</span>
                            </a>
                            <?php
							$subadmin = Session::get('ecomps_subadmin');
							$ecomps_admin_id = Session::get('ecomps_admin_id');
							$pages = DB::table('subadmin')->select('allow_pages')->where('user_id', '=', $ecomps_admin_id)->get();
							$allow_pages = array();
							if(count($pages) > 0){
								$allow_pages = $pages[0]->allow_pages;
								$allow_pages = explode(",", $allow_pages);
							}
							?>
                            <ul class="nav dk">
                                <?php
								if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('department', $allow_pages))){
								?>
                                <li style=" border-bottom:dotted 1px #ccc;border-top:dotted 1px #ccc" >
                                	<a onclick="redirectme('/adminpanel/departments');return false;" class="auto">
                                    	<i class="i i-circle-sm-o text"></i><span>Manage Departments</span>
									</a>
                                </li>
                                <?php }?>
                                <?php
								//if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('users', $allow_pages))){
								?>
                                <li style=" border-bottom:dotted 1px #ccc;border-top:dotted 1px #ccc" >
                                	<a onclick="redirectme('/adminpanel/useraccount');return false;" class="auto">
                                    	<i class="i i-flow-tree text"></i><span>Manage Users</span>
                                	</a>
                                </li>
                                <?php //}?>
                                <?php
								if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('delivery', $allow_pages))){
								?>
                                <li style=" border-bottom:dotted 1px #ccc;" >
                                	<a class="auto" onclick="redirectme('/adminpanel/deliverytype');">
                                    	<i class="i i-dsc text"></i><span>Manage Delivery Types</span>
                                	</a>
                                </li>
                                <?php }?>
                                <?php
								if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('location', $allow_pages))){
								?>
                                <li style="border-bottom:dotted 1px #ccc;" >
                                	<a class="auto" onclick="redirectme('/adminpanel/locationtype');">
                                    	<i class="i i-local text"></i><span>Manage Location Types</span>
                                	</a>
                                </li>
                                <?php }?>
                                <?php
								if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('team', $allow_pages))){
								?>
                                <li style=" border-bottom:dotted 1px #ccc;" >
                                    <a class="auto" onclick="redirectme('/adminpanel/teams');">
                                    	<i class="i i-users3 text"></i><span>Manage Teams</span>
                                    </a>
                                </li>
                                <?php }?>
                                <?php
								if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('email', $allow_pages))){
								?>
                                <li style=" border-bottom:dotted 1px #ccc;" >
                                	<a class="auto" onclick="redirectme('/adminpanel/emailtemplate');">
                                    	<i class="i i-list text"></i><span>Manage Email Template</span>
                                	</a>
                                </li>
                                <?php }?>
                                
                                <?php
								if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('500', $allow_pages))){
								?>
                                <li style=" border-bottom:dotted 1px #ccc;" >
                                	<a class="auto" onclick="redirectme('/adminpanel/500_costomize_error');">
                                    	<i class="i i-list text"></i><span>Manage 500 Customize Error</span>
                                	</a>
                                </li>
                                <?php }?>
                                
                                <?php
								if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('maintenance_page', $allow_pages))){
								?>
                                <li style=" border-bottom:dotted 1px #ccc;" >
                                	<a class="auto" onclick="redirectme('/adminpanel/customize_maintenance_message');">
                                    	<i class="i i-list text"></i><span>Customize Maintenance Page</span>
                                	</a>
                                </li>
                                <?php }?>
                                
                            </ul>
                        </li>
                        <?php
						if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('reminder-email', $allow_pages))){
						?>
                        <li style="cursor:pointer; border-bottom:dotted 1px #ccc;">
                            <a class="auto" onclick="redirectme('/adminpanel/send-reminder-emails');"><i class="i i-home icon"></i><span class="font-bold">Send Reminder Emails</span></a>
                        </li>
                        <?php }?>
                        <?php
						if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('subadmin', $allow_pages))){
						?>
                        <li class="active" >
                            <a href="javascript:void(0);" class="auto" onclick="redirectme('/adminpanel/subadmin');">
                                <span class="pull-right text-muted"><i class="i i-circle-sm-o text"></i><i class="i i-circle-sm text-active"></i></span>
                                <i class="glyphicon glyphicon-user"></i><span class="font-bold">Manage Sub Admin</span>
                            </a>
                        </li>
                        <?php }?>
						<?php
                        if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('request', $allow_pages))){
                        ?>
                        <li class="active" >
                            <a href="javascript:void(0);" class="auto" onclick="redirectme('/adminpanel/requests');">
                                <span class="pull-right text-muted"><i class="i i-circle-sm-o text"></i><i class="i i-circle-sm text-active"></i></span>
                                <i class="i i-grid2 icon"></i><span class="font-bold">Requests Section</span>
                            </a>
                        </li>
                        <?php }?>
						<?php
                        if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('fullapproved', $allow_pages))){
                        ?>
                        <li class="active" >
                            <a href="javascript:void(0);" class="auto" onclick="redirectme('/adminpanel/fully-approved-requests');">
                                <span class="pull-right text-muted"><i class="i i-circle-sm-o text"></i><i class="i i-circle-sm text-active"></i></span>
                                <i class="i i-grid3 icon"></i><span class="font-bold">Fully Approved Requests</span>
                            </a>
                        </li>
                        <?php }?>
						<?php
                        if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('game', $allow_pages))){
                        ?>
                        <li class="active" >
                            <a href="javascript:void(0);" class="auto" onclick="redirectme('/adminpanel/game');"><span class="pull-right text-muted"><i class="i i-circle-sm-o text"></i><i class="i i-circle-sm text-active"></i></span>
                            <i class="i i-gauge icon"></i><span class="font-bold">Manage Games</span>
                            </a>
                        </li>
                        <?php }?>
                        <?php
                        if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('game', $allow_pages))){
                        ?>
                        <li class="active" >
                            <a href="javascript:void(0);" class="auto" onclick="redirectme('/adminpanel/download-event-logs');"><span class="pull-right text-muted"><i class="i i-circle-sm-o text"></i><i class="i i-circle-sm text-active"></i></span>
                            <i class="i i-gauge icon"></i><span class="font-bold">Download Event Logs</span>
                            </a>
                        </li>
                        <?php }?>
                        <li class="active" >
                            <a href="javascript:void(0);" class="auto">
                                <span class="pull-right text-muted"><i class="i i-circle-sm-o text"></i><i class="i i-circle-sm text-active"></i></span>
                                <b class="badge bg-danger pull-right"></b><i class="i i-stack icon"></i>
                                <span class="font-bold">Reports</span>
                            </a>
                            <ul class="nav dk">
                                <?php
								if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('requested_users', $allow_pages))){
								?>
                                <li style=" border-bottom:dotted 1px #ccc;border-top:dotted 1px #ccc" >
                                	<a onclick="redirectme('/adminpanel/reports/requested/users');return false;" class="auto">
                                    	<i class="i i-circle-sm-o text"></i><span>Requested tickets by user</span>
									</a>
                                </li>
                                <?php }?>
                                <?php
								if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('requested_games', $allow_pages))){
								?>
                                <li style=" border-bottom:dotted 1px #ccc;border-top:dotted 1px #ccc" >
                                	<a onclick="redirectme('/adminpanel/reports/requested/games');return false;" class="auto">
                                    	<i class="i i-flow-tree text"></i><span>Requested tickets by game</span>
                                	</a>
                                </li>
                                <?php }?>
                                <?php
								if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('requested_teams', $allow_pages))){
								?>
                                <li style=" border-bottom:dotted 1px #ccc;" >
                                	<a class="auto" onclick="redirectme('/adminpanel/reports/requested/teams');">
                                    	<i class="i i-dsc text"></i><span>Requested tickets by team</span>
                                	</a>
                                </li>
                                <?php }?>
                                <?php
								if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('fulfilled_date', $allow_pages))){
								?>
                                <li style="border-bottom:dotted 1px #ccc;" >
                                	<a class="auto" onclick="redirectme('/adminpanel/reports/fulfilled/date');">
                                    	<i class="i i-local text"></i><span>Fulfilled tickets by date</span>
                                	</a>
                                </li>
                                <?php }?>
                                <?php
								if(($ecomps_admin_id > 0 && $subadmin=="no") || ($subadmin=="yes" && in_array('fulfilled_games', $allow_pages))){
								?>
                                <li style=" border-bottom:dotted 1px #ccc;" >
                                    <a class="auto" onclick="redirectme('/adminpanel/reports/fulfilled/games');">
                                    	<i class="i i-users3 text"></i><span>Fulfilled tickets by game</span>
                                    </a>
                                </li>
                                <?php }?>
                                
                            </ul>
                        </li>
                    </ul>
                    <div class="line dk hidden-nav-xs"></div>
                    
                </nav>
                <!-- / nav -->
            </div>
        </section>
    
        <footer class="footer hidden-xs no-padder text-center-nav-xs">
        
        <a href="#nav" data-toggle="class:nav-xs" class="btn btn-icon icon-muted btn-inactive m-l-xs m-r-xs">
        <i class="i i-circleleft text"></i>
        <i class="i i-circleright text-active"></i>
        </a>
        </footer>
    </section>
</aside>