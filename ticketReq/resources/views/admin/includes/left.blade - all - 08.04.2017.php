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
                            <a href="javascript:void(0);" class="auto"><span class="pull-right text-muted"><i class="i i-circle-sm-o text"></i><i class="i i-circle-sm text-active"></i></span><b class="badge bg-danger pull-right"></b><i class="i i-stack icon"></i>
                            <span class="font-bold">Initial Setup</span>
                            </a>
                            <ul class="nav dk">
                                <li style=" border-bottom:dotted 1px #ccc;border-top:dotted 1px #ccc" ><a onclick="redirectme('/adminpanel/departments');return false;" class="auto"><i class="i i-circle-sm-o text"></i><span>Manage Departments</span></a></li>
                                <li style=" border-bottom:dotted 1px #ccc;border-top:dotted 1px #ccc" ><a onclick="redirectme('/adminpanel/useraccount');return false;" class="auto"><i class="i i-flow-tree text"></i><span>Manage Users</span></a></li>
                                <?php /*?><li style=" border-bottom:dotted 1px #ccc;" ><a onclick="redirectme('/adminpanel/tasks');" class="auto"><i class="i i-circle-sm-o text"></i><span>Manage Tasks</span></a></li>
                                <li style=" border-bottom:dotted 1px #ccc;" ><a onclick="redirectme('/adminpanel/roles');" class="auto"><i class="i i-circle-sm-o text"></i><span>Manage Roles</span></a></li><?php */?>
                                
                                <?php /*?><li style=" border-bottom:dotted 1px #ccc;" ><a onclick="redirectme('/adminpanel/gamestate');" class="auto"><i class="i i-circle-sm-o text"></i><span>Manage Game States</span></a></li>
                                <li style=" border-bottom:dotted 1px #ccc;" ><a onclick="redirectme('/adminpanel/gamerequeststate');" class="auto"><i class="i i-circle-sm-o text"></i><span>Request Game States</span></a></li>
                                <li style=" border-bottom:dotted 1px #ccc;" ><a onclick="redirectme('/adminpanel/employeetype');" class="auto"><i class="i i-circle-sm-o text"></i><span>Manage Employee Types</span></a></li><?php */?>
                                <li style=" border-bottom:dotted 1px #ccc;" ><a class="auto" onclick="redirectme('/adminpanel/deliverytype');"><i class="i i-dsc text"></i><span>Manage Delivery Types</span></a></li>
                                <?php /*?><li style=" border-bottom:dotted 1px #ccc;" ><a class="auto" onclick="redirectme('/adminpanel/deliverygroup');"><i class="i i-circle-sm-o text"></i><span>Manage Delivery Group</span></a></li>
                                <li style=" border-bottom:dotted 1px #ccc;" ><a class="auto" onclick="redirectme('/adminpanel/demandtype');"><i class="i i-circle-sm-o text"></i><span>Manage Demand Types</span></a></li><?php */?>
                                <li style=" border-bottom:dotted 1px #ccc;" ><a class="auto" onclick="redirectme('/adminpanel/locationtype');"><i class="i i-local text"></i><span>Manage Location Types</span></a></li>
                                <li style=" border-bottom:dotted 1px #ccc;" ><a class="auto" onclick="redirectme('/adminpanel/teams');"><i class="i i-users3 text"></i><span>Manage Teams</span></a></li>
                                <?php /*?><li style=" border-bottom:dotted 1px #ccc;" ><a class="auto" onclick="redirectme('/adminpanel/allocationpooltype');"><i class="i i-circle-sm-o text"></i><span>Manage Allocation Pool Type</span></a></li>
       							<li style=" border-bottom:dotted 1px #ccc;" ><a class="auto" onclick="redirectme('/adminpanel/approvalrequirementtype');"><i class="i i-circle-sm-o text"></i><span>Approval Requirement Type</span></a></li><?php */?>
                                <!--<li style=" border-bottom:dotted 1px #ccc;" ><a class="auto" onclick="redirectme('/adminpanel/siteresourcetype');"><i class="i i-circle-sm-o text"></i><span>Site Source Type</span></a></li>-->
                                <?php /*?><li style=" border-bottom:dotted 1px #ccc;" ><a class="auto" onclick="redirectme('/adminpanel/pricingtype');"><i class="i i-circle-sm-o text"></i><span>Manage Pricing Type</span></a></li>
                                <li style=" border-bottom:dotted 1px #ccc;" ><a class="auto" onclick="redirectme('/adminpanel/ticketsourcetype');"><i class="i i-circle-sm-o text"></i><span>Ticket Resource Type</span></a></li><?php */?>
                                <!--<li style=" border-bottom:dotted 1px #ccc;" ><a class="auto" onclick="redirectme('/adminpanel/promotion');"><i class="i i-circle-sm-o text"></i><span>Manage Promotion</span></a></li>-->
                                <li style=" border-bottom:dotted 1px #ccc;" ><a class="auto" onclick="redirectme('/adminpanel/emailtemplate');"><i class="i i-list text"></i><span>Manage Email Template</span></a></li>
                            </ul>
                        </li>
                        <!--<li class="active" >
                            <a href="javascript:void(0);" class="auto" onclick="redirectme('/adminpanel/useraccount');">
                                <span class="pull-right text-muted"><i class="i i-circle-sm-o text"></i><i class="i i-circle-sm text-active"></i></span>
                                <i class="i i-lab icon"></i><span class="font-bold">Manage Users</span>
                            </a>
                        </li>-->
                        <li class="active" >
                            <a href="javascript:void(0);" class="auto" onclick="redirectme('/adminpanel/subadmin');">
                                <span class="pull-right text-muted"><i class="i i-circle-sm-o text"></i><i class="i i-circle-sm text-active"></i></span>
                                <i class="glyphicon glyphicon-user"></i><span class="font-bold">Manage Sub Admin</span>
                            </a>
                        </li>
                        <li class="active" >
                            <a href="javascript:void(0);" class="auto" onclick="redirectme('/adminpanel/requests');">
                                <span class="pull-right text-muted"><i class="i i-circle-sm-o text"></i><i class="i i-circle-sm text-active"></i></span>
                                <i class="i i-grid2 icon"></i><span class="font-bold">Requests Section</span>
                            </a>
                        </li>
                        <li class="active" >
                            <a href="javascript:void(0);" class="auto" onclick="redirectme('/adminpanel/fully-approved-requests');">
                                <span class="pull-right text-muted"><i class="i i-circle-sm-o text"></i><i class="i i-circle-sm text-active"></i></span>
                                <i class="i i-grid3 icon"></i><span class="font-bold">Fully Approved Requests</span>
                            </a>
                        </li>
                        <li class="active" >
                            <a href="javascript:void(0);" class="auto" onclick="redirectme('/adminpanel/game');"><span class="pull-right text-muted"><i class="i i-circle-sm-o text"></i><i class="i i-circle-sm text-active"></i></span>
                            <i class="i i-gauge icon"></i><span class="font-bold">Manage Games</span>
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