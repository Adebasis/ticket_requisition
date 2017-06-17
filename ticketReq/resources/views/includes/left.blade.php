<aside class="bg-default aside-md hidden-print hidden-xs" id="nav">          
    <section class="vbox">
        <section class="w-f scrollable">
            <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2">
                <div class="clearfix wrapper dk nav-user hidden-xs">
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="thumb avatar pull-left m-r">                        
                                <img src="{{ url('/') }}/public/admin_assets/images/a0.png" class="dker" alt="...">
                                <i class="on md b-black"></i>
                            </span>
                            <span class="hidden-nav-xs clear">
                                <span class="block m-t-xs">
                                <strong class="font-bold text-lt">{!! Session::get('ecomps_user_full_name') !!}</strong> 
                                <b class="caret"></b>
                                </span>
                                <span class="text-muted text-xs block">Administrator</span>
                            </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">                      
                            <li><span class="arrow top hidden-nav-xs"></span><a href="#">Settings</a></li>
                            <li><a href="{{ url('/profile') }}">Profile</a></li>
                            <li><a href="{{ url('/change-password') }}">Change Password</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ url('/logout') }}" >Logout</a></li>
                        </ul>
                    </div>
                </div>                
            	
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
                        <li style="cursor:pointer;">
                            <a class="auto" onclick="redirectme('/default');"><i class="i i-home icon"></i><span class="font-bold">Home</span></a>
                        </li>
                        <li class="active" >
                            <a href="javascript:void(0);" class="auto"><span class="pull-right text-muted"><i class="i i-circle-sm-o text"></i><i class="i i-circle-sm text-active"></i></span><b class="badge bg-danger pull-right"></b><i class="i i-stack icon"></i>
                            <span class="font-bold">Initial Setup</span>
                            </a>
                            <ul class="nav dk">
                                <!--<li ><a onclick="redirectme('/adminpanel/departments');" class="auto"><i class="i i-circle-sm-o text"></i><span>Manage Departments</span></a></li>
                                <li ><a onclick="redirectme('/adminpanel/roles');" class="auto"><i class="i i-circle-sm-o text"></i><span>Manage Roles</span></a></li>
                                <li ><a onclick="redirectme('/adminpanel/tasks');" class="auto"><i class="i i-circle-sm-o text"></i><span>Manage Tasks</span></a></li>
                                <li ><a onclick="redirectme('/adminpanel/gamestate');" class="auto"><i class="i i-circle-sm-o text"></i><span>Manage Game States</span></a></li>
                                <li ><a onclick="redirectme('/adminpanel/employeetype');" class="auto"><i class="i i-circle-sm-o text"></i><span>Manage Employee Types</span></a></li>
                                <li ><a class="auto" onclick="redirectme('/adminpanel/deliverytype');"><i class="i i-circle-sm-o text"></i><span>Manage Delivery Types</span></a></li>
                                <li ><a class="auto" onclick="redirectme('/adminpanel/demandtype');"><i class="i i-circle-sm-o text"></i><span>Manage Demand Types</span></a></li>
                                <li ><a class="auto" onclick="redirectme('/adminpanel/locationtype');"><i class="i i-circle-sm-o text"></i><span>Manage Location Types</span></a></li>-->
                            </ul>
                        </li>
                        <li class="active" >
                            <a href="javascript:void(0);" class="auto">
                                <span class="pull-right text-muted"><i class="i i-circle-sm-o text"></i><i class="i i-circle-sm text-active"></i></span>
                                <i class="i i-lab icon"></i><span class="font-bold">Manage Users</span>
                            </a>
                        </li>
                        <li class="active" >
                            <a href="#" class="auto">
                                <span class="pull-right text-muted"><i class="i i-circle-sm-o text"></i><i class="i i-circle-sm text-active"></i></span>
                                <i class="i i-grid2 icon"></i><span class="font-bold">Requests Section</span>
                            </a>
                        </li>
                        <li >
                            <a href="javascript:void(0);" class="auto"><span class="pull-right text-muted"><i class="i i-circle-sm-o text"></i><i class="i i-circle-sm text-active"></i></span>
                            <i class="i i-docs icon"></i><span class="font-bold">Manage Events</span>
                            </a>
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