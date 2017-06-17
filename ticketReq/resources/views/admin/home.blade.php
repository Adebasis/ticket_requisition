@include('admin.includes.top')

<section class="vbox">
    
    @include('admin.includes.header')
    
    <section>
      <section class="hbox stretch">
        <!-- .aside -->
        @include('admin.includes.left')
        <!-- /.aside -->
        
        <?php
		$current_date = date('Y-m-d');
		$allgames = DB::table('game')->where('requeststate_id', 3)->where(DB::Raw('DATE(OriginalGameDate)'), '>=' , $current_date)->get();
		$no_of_games = count($allgames);
		?>
        
        <section id="content">
          <section class="hbox stretch">
            <section>
              <section class="vbox">
                <section class="scrollable padder">              
                  <section class="row m-b-md">
                    <div class="col-sm-6">
                      <h3 class="m-b-xs text-black">Dashboard</h3>
                      <small>Welcome back, {!! Session::get('ecomps_user_full_name') !!}, <i class="fa fa-map-marker fa-lg text-primary"></i> {!! Session::get('ecomps_location') !!}</small>
                    </div>
                    <div class="col-sm-6 text-right text-left-xs m-t-md">
                      <!--<div class="btn-group">
                        <a class="btn btn-rounded btn-default b-2x dropdown-toggle" data-toggle="dropdown">Widgets <span class="caret"></span></a>
                        <ul class="dropdown-menu text-left pull-right">
                          <li><a href="#">Notification</a></li>
                          <li><a href="#">Messages</a></li>
                          <li><a href="#">Analysis</a></li>
                          <li class="divider"></li>
                          <li><a href="#">More settings</a></li>
                        </ul>
                      </div>
                      <a href="#" class="btn btn-icon b-2x btn-default btn-rounded hover"><i class="i i-bars3 hover-rotate"></i></a>
                      <a href="#nav, #sidebar" class="btn btn-icon b-2x btn-info btn-rounded" data-toggle="class:nav-xs, show"><i class="fa fa-bars"></i></a>-->
                    </div>
                  </section>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="panel b-a">
                        <div class="row m-n">
                          <div class="col-md-6 b-b b-r">
                            <a href="#" class="block padder-v hover">
                              <span class="i-s i-s-2x pull-left m-r-sm">
                                <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i>
                                <i class="i i-plus2 i-1x text-white"></i>
                              </span>
                              <?php
							  $fulfilled_tickets = DB::table('request')->where('is_fulfil', 1)->count()
							  ?>
                              <span class="clear">
                                <span class="h3 block m-t-xs text-danger"><?php echo $fulfilled_tickets;?></span>
                                <small class="text-muted text-u-c">Fullfilled Tickets</small>
                              </span>
                            </a>
                          </div>
                          <div class="col-md-6 b-b">
                            <a href="#" class="block padder-v hover">
                              <span class="i-s i-s-2x pull-left m-r-sm">
                                <i class="i i-hexagon2 i-s-base text-success-lt hover-rotate"></i>
                                <i class="i i-users2 i-sm text-white"></i>
                              </span>
                              <span class="clear">
                                <span class="h3 block m-t-xs text-success">
                                <?php
								$no_of_users = DB::table('useraccount')->where('is_deleted', 0)->count();
								echo $no_of_users;
								?>
                                </span>
                                <small class="text-muted text-u-c">Users</small>
                              </span>
                            </a>
                          </div>
                          <div class="col-md-6 b-b b-r">
                            <a href="#" class="block padder-v hover">
                              <span class="i-s i-s-2x pull-left m-r-sm">
                                <i class="i i-hexagon2 i-s-base text-info hover-rotate"></i>
                                <i class="i i-location i-sm text-white"></i>
                              </span>
                              <span class="clear">
                                <span class="h3 block m-t-xs text-info"><?php echo $no_of_games;?> <span class="text-sm"></span></span>
                                <small class="text-muted text-u-c">Upcoming Games</small>
                              </span>
                            </a>
                          </div>
                          <?php
						$current_date = date('Y-m-d');
						$allgames = DB::select("select * from game where requeststate_id=3 And DATE(OriginalGameDate) >='".$current_date."' And id in (select game_id from request) ORDER BY OriginalGameDate limit 0,1");
						
						$game_id = 0;
						$team_id = 0;
						$team_name = "";
						$team_code = "";
						$logo = "";
						$OriginalGameDate = "UPCOMING GAME";
						if(count($allgames) > 0){
							$game_id = $allgames[0]->id;
							$team_id = $allgames[0]->team_id;
							$team_name = getDataFromTable("team","Name","id", $team_id);
							$team_code = getDataFromTable("team","TeamCode","id", $team_id);
							$logo = $team_code.'.png';
							$OriginalGameDate = date('m/d/Y h:i A', strtotime($allgames[0]->OriginalGameDate));
						}
						
						?>
                          <div class="col-md-6 b-b">
                            <a href="#" class="block padder-v hover">
                              <span class="i-s i-s-2x pull-left m-r-sm">
                              	<?php if($logo == ""){?>
                                <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
								<?php }else{?>
                                <img src="<?php echo url('/');?>/public/images/logos/<?php echo $logo;?>" class=" hover-rotate">
                                <?php }?>
                                <i class="i i-alarm i-sm text-white"></i>
                              </span>
                              <span class="clear">
                                <span class="h3 block m-t-xs text-primary"><?php echo $team_name;?></span>
                                <small class="text-muted text-u-c"><?php echo $OriginalGameDate;?></small>
                              </span>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                      <div class="panel b-a">
                        <div class="panel-heading no-border bg-primary lt text-center">
                          <span class="h3 block m-t-xs text-white">Requests</span>
                        </div>
                        <?php
						$no_of_req = DB::table('request')->where('game_id','>',0)->count();
						$no_of_pending_req = DB::table('request')->where('is_cancel','=',0)->where('is_approve','=',0)->count();
						$no_of_rejected_req = DB::table('request')->where('is_cancel','=',1)->count();
						?>
                        <div class="padder-v text-center clearfix">                            
                          <div class="col-xs-6 b-r">
                            <div class="h3 font-bold"><?php echo $no_of_req;?></div>
                            <small class="text-muted">No of Requests</small>
                          </div>
                          <div class="col-xs-6">
                            <div class="h3 font-bold"><?php echo $no_of_pending_req;?></div>
                            <small class="text-muted">Pending Approval</small>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                      <div class="panel b-a">
                        <div class="panel-heading no-border bg-info lter text-center">
                          <span class="h3 block m-t-xs text-white">Rejected Requests</span>
                        </div>
                        <div class="padder-v text-center clearfix">                            
                          <div class="col-xs-12 b-r">
                            <div class="h3 font-bold"><?php echo $no_of_rejected_req;?></div>
                            <small class="text-muted">No of Rejected Requests</small>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3 hide">
                      <section class="panel b-a">
                        <header class="panel-heading b-b b-light">
                          <ul class="nav nav-pills pull-right">
                            <li>
                              <a href="#" class="text-muted" data-bjax data-target="#b-c">
                                <i class="i i-cycle"></i>
                              </a>
                            </li>
                            <li>
                              <a href="#" class="panel-toggle text-muted">
                                <i class="i i-plus text-active"></i>
                                <i class="i i-minus text"></i>
                              </a>
                            </li>
                          </ul>
                          Connection
                        </header>
                        <div class="panel-body text-center bg-light lter" id="b-c">
                          <div class="easypiechart inline m-b m-t" data-percent="60" data-line-width="4" data-bar-Color="#23aa8c" data-track-Color="#c5d1da" data-color="#2a3844" data-scale-Color="false" data-size="120" data-line-cap='butt' data-animate="2000">
                            <div>
                              <span class="h2 m-l-sm step"></span>%
                              <div class="text text-xs">completed</div>
                            </div>
                          </div>
                        </div>
                      </section>                      
                    </div>
                  </div>           
                  <div class="row bg-light dk m-b">
                    <div class="col-md-7 dker1">
                      <!--<h4>Request Status: Next 6 Games</h4>-->
                  	<?php
					 function renderChartHTML($chartSWF, $strURL, $strXML, $chartId, $chartWidth, $chartHeight, $debugMode=false,$registerWithJS=false, $setTransparent="") {
    // Generate the FlashVars string based on whether dataURL has been provided
    // or dataXML.
    $strFlashVars = "&chartWidth=" . $chartWidth . "&chartHeight=" . $chartHeight . "&debugMode=" . boolToNum($debugMode);
    if ($strXML=="")
        // DataURL Mode
        $strFlashVars .= "&dataURL=" . $strURL;
    else
        //DataXML Mode
        $strFlashVars .= "&dataXML=" . $strXML;
    
    $nregisterWithJS = boolToNum($registerWithJS);
    if($setTransparent!=""){
      $nsetTransparent=($setTransparent==false?"opaque":"transparent");
    }else{
      $nsetTransparent="window";
    }
$HTML_chart = <<<HTMLCHART
	<!-- START Code Block for Chart $chartId -->
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="$chartWidth" height="$chartHeight" id="$chartId">
		<param name="allowScriptAccess" value="always" />
		<param name="movie" value="$chartSWF"/>		
		<param name="FlashVars" value="$strFlashVars&registerWithJS=$nregisterWithJS" />
		<param name="quality" value="high" />
		<param name="wmode" value="$nsetTransparent" />
		<embed src="$chartSWF" FlashVars="$strFlashVars&registerWithJS=$nregisterWithJS" quality="high" width="$chartWidth" height="$chartHeight" name="$chartId" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" />
	</object>
	<!-- END Code Block for Chart $chartId -->
HTMLCHART;

  return $HTML_chart;
}

// boolToNum function converts boolean values to numeric (1/0)
function boolToNum($bVal) {
    return (($bVal==true) ? 1 : 0);
}

					$current_date = date('Y-m-d');
					$allgames = DB::select("select * from game where requeststate_id=3 And DATE(OriginalGameDate) >='".$current_date."' And id in (select game_id from request) order by OriginalGameDate limit 0,10");
					
                      $strXML1="<chart palette='4' canvasBgAlpha='0' formatNumberScale='0' legendBgAlpha='0' caption='Request Status: Next 10 Games' shownames='1' showvalues='0' decimals='0' numberPrefix=''>
					<categories>";
					foreach ($allgames as $index=>$tmpgame){
									$OriginalGameDate = date('m/d/y', strtotime($tmpgame->OriginalGameDate));
						$strXML1.="<category label='$OriginalGameDate' />";
					}
					$strXML1.="</categories>
					<dataset seriesName='Pending Level I' color='42A0FF' showValues='0'>";
					foreach ($allgames as $index=>$tmpgame){
						$no = 0;
						$res_count = DB::select("select count(id) as total from request where game_id=".$tmpgame->id." And req_prec=0");
						if(count($res_count) > 0){
							$no = $res_count[0]->total;
						}
						$strXML1.="<set value='$no' />";
					}
					$strXML1.="</dataset>
					<dataset seriesName='Pending Level II' color='FFB76F' showValues='0'>";
					foreach ($allgames as $index=>$tmpgame){
						$no = 0;
						$res_count = DB::select("select count(id) as total from request where game_id=".$tmpgame->id." And req_prec=1");
						if(count($res_count) > 0){
							$no = $res_count[0]->total;
						}
						$strXML1.="<set value='$no' />";
					}
					$strXML1.="</dataset>
					<dataset seriesName='Pending Fulfillment' color='B0B0B0' showValues='0'>";
						foreach ($allgames as $index=>$tmpgame){
						$no = 0;
						$res_count = DB::select("select count(id) as total from request where game_id=".$tmpgame->id." And req_prec=2");
						if(count($res_count) > 0){
							$no = $res_count[0]->total;
						}
						$strXML1.="<set value='$no' />";
					}
					$strXML1.="</dataset>
				</chart>";
				echo renderChartHTML(url('/')."/public/js/FusionCharts/Charts/MSColumn3D.swf", "", $strXML1, "myNext", "100%", 358);
                ?>
                    </div>
                    
                    <div class="col-md-5">
                      
                      <section class="panel panel-default">
                    <header class="panel-heading">                    
                      <span class="label bg-dark h5"><?php echo $no_of_games;?></span> Games VS Requests
                    </header>
                    <section class="panel-body slim-scroll" data-height="315px" data-size="10px">
                      
                      <?php
					  if($game_id == "" || $game_id == 0){
						  $game_id = 0;
					  }
					  $allgames = DB::select("select * from game where id ='$game_id'");
					  $x = 0;
						foreach ($allgames as $index=>$tmpgame){

							$game_id = $tmpgame->id;
							$team_id = $tmpgame->team_id;
							$team_name = getDataFromTable("team","Name","id", $team_id);
							$team_code = getDataFromTable("team","TeamCode","id", $team_id);
							$logo = $team_code.'.png';
							
							$OriginalGameDate = date('m/d/Y h:i A', strtotime($tmpgame->OriginalGameDate));
														
							$req = DB::select("select sum(Comp) as Ticket_Required from request where game_id='".$tmpgame->id."'");
							$total_requested_ticket = $req[0]->Ticket_Required;
							if($total_requested_ticket == ""){ $total_requested_ticket = 0; }
							
							$req = DB::select("select sum(Purchased) as Ticket_Purchased from request where game_id='".$tmpgame->id."' And is_fulfil=1");
							$total_purchased_ticket = $req[0]->Ticket_Purchased;
							if($total_purchased_ticket == ""){ $total_purchased_ticket = 0; }
							
							$req = DB::select("select count(id) as total_req from request where game_id='".$tmpgame->id."'");
							$total_req = $req[0]->total_req;
							if($total_req == ""){ $total_req = 0; }
							$x = $x + $total_req;
							
						?>
                      <article class="media">
                        <span class="pull-left thumb-sm">
                        <img src="<?php echo url('/');?>/public/images/logos/<?php echo $logo;?>" class=" hover-rotate">
                        </span>
                        <div class="media-body">
                          <div class="media-xs text-center text-muted">
                            
                          </div>
                          <span class="h5 block m-t-xs text-danger"><?php echo $team_name;?>,&nbsp;<small class="text-muted text-u-c"><?php echo $OriginalGameDate;?></small></span>
                          <small class="block h6 text-muted text-u-c"><a href="#" class="" style="line-height:25px;">Users </a> <span class="label label-info"><?php echo $total_req;?></span>&nbsp;|&nbsp;<a href="#" class="">Comp</a> <span class="label label-success"><?php echo $total_requested_ticket;?></span>&nbsp;|&nbsp;<a href="#" class="">Purchased</a> <span class="label label-success"><?php echo $total_purchased_ticket;?></span></small>
                          
                        </div>
                      </article>            
                      <!--<div class="line pull-in"></div>-->
                      <?php }?>
                      
                      <?php
					  $allgames = DB::select("select * from game where id<>'$game_id' And requeststate_id=3 And DATE(OriginalGameDate) >='".$current_date."' And id in (select game_id from request) order by OriginalGameDate ");
					  $x = 0;
						foreach ($allgames as $index=>$tmpgame){

							$game_id = $tmpgame->id;
							$team_id = $tmpgame->team_id;
							$team_name = getDataFromTable("team","Name","id", $team_id);
							$team_code = getDataFromTable("team","TeamCode","id", $team_id);
							$logo = $team_code.'.png';
							
							$OriginalGameDate = date('m/d/Y h:i A', strtotime($tmpgame->OriginalGameDate));
														
							$req = DB::select("select sum(Comp) as Ticket_Required from request where game_id='".$tmpgame->id."'");
							$total_requested_ticket = $req[0]->Ticket_Required;
							if($total_requested_ticket == ""){ $total_requested_ticket = 0; }
							
							$req = DB::select("select sum(Purchased) as Ticket_Purchased from request where game_id='".$tmpgame->id."' And is_fulfil=1");
							$total_purchased_ticket = $req[0]->Ticket_Purchased;
							if($total_purchased_ticket == ""){ $total_purchased_ticket = 0; }
							
							$req = DB::select("select count(id) as total_req from request where game_id='".$tmpgame->id."'");
							$total_req = $req[0]->total_req;
							if($total_req == ""){ $total_req = 0; }
							$x = $x + $total_req;
							
						?>
                      <article class="media">
                        <span class="pull-left thumb-sm">
                        <img src="<?php echo url('/');?>/public/images/logos/<?php echo $logo;?>" class=" hover-rotate">
                        </span>
                        <div class="media-body">
                          <div class="media-xs text-center text-muted">
                            
                          </div>
                          <span class="h5 block m-t-xs text-danger"><?php echo $team_name;?>,&nbsp;<small class="text-muted text-u-c"><?php echo $OriginalGameDate;?></small></span>
                          <small class="block h6 text-muted text-u-c"><a href="#" class="" style="line-height:25px;">Users</a> <span class="label label-info"><?php echo $total_req;?></span>&nbsp;|&nbsp;<a href="#" class="">Comp</a> <span class="label label-success"><?php echo $total_requested_ticket;?></span>&nbsp;|&nbsp;<a href="#" class="">Purchased</a> <span class="label label-success"><?php echo $total_purchased_ticket;?></span></small>
                          
                        </div>
                      </article>            
                      <!--<div class="line pull-in"></div>-->
                      <?php }?>
                      
                    </section>
                  </section>
                  
                      
                      
                    </div>
                  </div>
                <div class="row">
                    <div class="col-md-4">
                        <section class="panel b-a">
                            
                            <div class="panel-heading b-b"> 
                                <a href="#" class="font-bold">Ticket Sent</a>
                            </div>
                            
                            <?php
							$allreq = DB::table('request')->where('is_fulfil', 1)->orderBy('fulfil_date', 'desc')->take(5)->get();
							foreach ($allreq as $index=>$tmpreq){
								$requester = DB::table('useraccount')->select('FirstName', 'LastName')->where('id','=',$tmpreq->requestor_id)->get();
								$requester_name = '';
								if(count($requester) > 0){
									$requester_name = $requester[0]->FirstName.' '.$requester[0]->LastName;
								}
								$no_of_ticket = $tmpreq->Purchased + $tmpreq->Comp;
								$pr = '';
								if($no_of_ticket > 1){
									$pr = 's';
								}
							?>
                            <div class="clearfix panel-footer">
                                <small class="text-muted pull-right"><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($tmpreq->fulfil_date))->diffForHumans();?></small>
                                <a href="#" class="thumb-sm pull-left m-r">
                                <img src="{{ url('/') }}/public/admin_assets/images/no32.png" alt="..." class="img-circle">
                                </a>
                                
                                <div class="clear">
                                    <a href="#"><strong><?php echo $requester_name;?></strong></a>
                                    <small class="block text-muted">
                                    <b><?php echo $tmpreq->RecipientFirstName;?> <?php echo $tmpreq->RecipientLastName;?></b>, <?php echo $no_of_ticket;?> Ticket<?php echo $pr;?> fulfilled</small>
                                </div>
                            </div>
                            <?php }?>
                        </section>
                    </div>
                    <div class="col-md-4">
                    <section class="panel b-a">
                    <div class="panel-heading b-b">
                    <span class="badge bg-warning pull-right">&nbsp;</span>
                    <a href="#" class="font-bold">Messages</a>
                    </div>
                    <ul class="list-group list-group-lg no-bg auto">                          
                    <?php
						$all = DB::table('logs')->orderBy('created_date', 'desc')->take(5)->get();
						foreach($all as $index=>$logs){
							$dated = date('D, M d Y', strtotime($logs->created_date));
							$time = date('h:i A', strtotime($logs->created_date));
						?>
                        <a href="{{url('adminpanel/requests')}}/{{$logs->request_id}}/view/edit" class="list-group-item clearfix">
                            
                            <span class="clear1">
                            
                            <?php if($logs->user_type=='fulfiler'){?>
                            <i class="fa fa-star time-icon" style="color:#c0c;"></i>
                            <?php }?>
                            <?php if($logs->user_type=='first'){?>
                            <i class="fa fa-asterisk time-icon" style="color:#090;"></i>
                            <?php }?>
                            <?php if($logs->user_type=='second'){?>
                            <i class="fa fa-mortar-board time-icon" style="color:#c03;"></i>
                            <?php }?>
                            <?php if($logs->user_type=='admin'){?>
                            <i class="fa fa-star1 time-icon bg-primary">A</i>
                            <?php }?>
                            <?php if($logs->user_type=='vp'){?>
                            <i class="fa fa-life-ring time-icon" style="color:#09c;"></i>
                            <?php }?>
                            <?php if($logs->user_type=='user'){?>
                            <i class="fa fa-user time-icon bg-success" style="color:#333;"></i>
                            <?php }?>
                            <?php echo ucwords($logs->user_name);?>, <small class="text-muted"><?php echo $dated;?> <?php echo $time;?></small>
                            <small class="text-muted clear text-ellipsis1"><?php echo $logs->descr;?></small>
                            </span>
                        </a>
                    <?php }?>
                    </ul>
                    <!--<div class="clearfix panel-footer">
                    <div class="input-group">
                    <input type="text" class="form-control input-sm btn-rounded" placeholder="Search">
                    <span class="input-group-btn">
                    <button type="submit" class="btn btn-default btn-sm btn-rounded"><i class="fa fa-search"></i></button>
                    </span>
                    </div>
                    </div>-->
                    </section>
                    </div>
                <div class="col-md-4">
                <section class="panel b-light">
                <!--<header class="panel-heading"><strong>Calendar</strong></header>-->
                <div id="calendar" class="calendar bg-light dker m-l-n-xxs m-r-n-xxs"></div>
                <!--<div class="list-group">
                <a href="#" class="list-group-item text-ellipsis">
                <span class="badge bg-warning">7:30</span> 
                Meet a friend
                </a>
                <a href="#" class="list-group-item text-ellipsis"> 
                <span class="badge bg-success">9:30</span> 
                Have a kick off meeting with .inc company
                </a>
                </div>-->
                </section>                  
                </div>
                </div>
                </section>
              </section>
            </section>
            <!-- side content -->
            <aside class="aside-md bg-black hide" id="sidebar">
              <section class="vbox animated fadeInRight">
                <section class="scrollable">
                  <div class="wrapper"><strong>Live feed</strong></div>
                  <ul class="list-group no-bg no-borders auto">
                    <li class="list-group-item">
                      <span class="fa-stack pull-left m-r-sm">
                        <i class="fa fa-circle fa-stack-2x text-success"></i>
                        <i class="fa fa-reply fa-stack-1x text-white"></i>
                      </span>
                      <span class="clear">
                        <a href="#">Goody@gmail.com</a> sent your email
                        <small class="icon-muted">13 minutes ago</small>
                      </span>
                    </li>
                    <li class="list-group-item">
                      <span class="fa-stack pull-left m-r-sm">
                        <i class="fa fa-circle fa-stack-2x text-danger"></i>
                        <i class="fa fa-file-o fa-stack-1x text-white"></i>
                      </span>
                      <span class="clear">
                        <a href="#">Mide@live.com</a> invite you to join a meeting
                        <small class="icon-muted">20 minutes ago</small>
                      </span>
                    </li>
                    <li class="list-group-item">
                      <span class="fa-stack pull-left m-r-sm">
                        <i class="fa fa-circle fa-stack-2x text-info"></i>
                        <i class="fa fa-map-marker fa-stack-1x text-white"></i>
                      </span>
                      <span class="clear">
                        <a href="#">Geoge@yahoo.com</a> is online
                        <small class="icon-muted">1 hour ago</small>
                      </span>
                    </li>
                    <li class="list-group-item">
                      <span class="fa-stack pull-left m-r-sm">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-info fa-stack-1x text-white"></i>
                      </span>
                      <span class="clear">
                        <a href="#"><strong>Admin</strong></a> post a info
                        <small class="icon-muted">1 day ago</small>
                      </span>
                    </li>
                  </ul>
                  <div class="wrapper"><strong>Friends</strong></div>
                  <ul class="list-group no-bg no-borders auto">
                    <li class="list-group-item">
                      <div class="media">
                        <span class="pull-left thumb-sm avatar">
                          <img src="{{ url('/') }}/public/admin_assets/images/a3.png" alt="..." class="img-circle">
                          <i class="on b-black bottom"></i>
                        </span>
                        <div class="media-body">
                          <div><a href="#">Chris Fox</a></div>
                          <small class="text-muted">about 2 minutes ago</small>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="media">
                        <span class="pull-left thumb-sm avatar">
                          <img src="{{ url('/') }}/public/admin_assets/images/a2.png" alt="...">
                          <i class="on b-black bottom"></i>
                        </span>
                        <div class="media-body">
                          <div><a href="#">Amanda Conlan</a></div>
                          <small class="text-muted">about 2 hours ago</small>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="media">
                        <span class="pull-left thumb-sm avatar">
                          <img src="{{ url('/') }}/public/admin_assets/images/a1.png" alt="...">
                          <i class="busy b-black bottom"></i>
                        </span>
                        <div class="media-body">
                          <div><a href="#">Dan Doorack</a></div>
                          <small class="text-muted">3 days ago</small>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="media">
                        <span class="pull-left thumb-sm avatar">
                          <img src="{{ url('/') }}/public/admin_assets/images/a0.png" alt="...">
                          <i class="away b-black bottom"></i>
                        </span>
                        <div class="media-body">
                          <div><a href="#">Lauren Taylor</a></div>
                          <small class="text-muted">about 2 minutes ago</small>
                        </div>
                      </div>
                    </li>
                  </ul>
                </section>
              </section>              
            </aside>
            <!-- / side content -->
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
        </section>
      </section>
    </section>
  </section>

@include('admin.includes.admin_footer')


    {!!HTML::script('public/admin_assets/js/fullcalendar/fullcalendar.min.js')!!}
    {!! Html::style('public/admin_assets/js/fullcalendar/fullcalendar.css') !!}
    {!! Html::style('public/admin_assets/js/fullcalendar/theme.css')!!}


<style>
<?php
// Retrive all open status game
// 3 = Open from gamerequesttype table
// SELECT * FROM `game` WHERE `requeststate_id`=3 and DATE(OriginalGameDate) = '2017-03-14'
//SELECT * FROM `game` WHERE `requeststate_id`=3 and month(DATE(OriginalGameDate)) = '03' and year(DATE(OriginalGameDate)) = '2017'
foreach ($allgames as $index=>$tmpgame){
	
	$game_id = $tmpgame->id;
	$team_id = $tmpgame->team_id;
	$team_code = getDataFromTable("team","TeamCode","id", $team_id);
	$logo = $team_code.'.png';
	
	echo ".test$game_id{
		background: url('".url('/')."/public/images/logos/".$logo."');
		background-repeat: no-repeat;
		padding-top: 25px !important;
		text-align: center;
		background-position: top;
		background-size: 20px 20px;
		}";
}
?>
</style>
            
<?php
$events_loop = "";
foreach ($allgames as $index=>$tmpgame){
	
	$game_id = $tmpgame->id;
	$team_id = $tmpgame->team_id;
	$team_name = getDataFromTable("team","Name","id", $team_id);
	$OriginalGameDate = date('m/d/Y h:i A', strtotime($tmpgame->OriginalGameDate));
	$y = date('Y', strtotime($tmpgame->OriginalGameDate));
	$m1 = date('m', strtotime($tmpgame->OriginalGameDate));
	if($m1 < 10){
		$m1 = str_replace("0", "", $m1);
	}
	$m1 = $m1 - 1;
	
	$d = date('d', strtotime($tmpgame->OriginalGameDate));
	$Promotions = 'No Promotions';
	
	$events_loop .= "{
		title: '$team_name',
		start: new Date($y, $m1, $d),
		className:'test$game_id',
		url: '".url('/')."/game/$game_id/view',
		tooltip: 'test event',
		OriginalGameDate : '$OriginalGameDate',
		Promotions:'$Promotions'
	},";
}
$events_loop = rtrim($events_loop, ',');
$events = "events: [".$events_loop."]";


$events_loop = "";
foreach ($allgames as $index=>$tmpgame){
	
	$team_id = $tmpgame->team_id;
	$team_name = getDataFromTable("team","Name","id", $team_id);
	
	$total_purchased_ticket = 0;	
	$percent = 0;
	
	$req = DB::select("select sum(Purchased) as purchased from request where game_id='".$tmpgame->id."' And is_fulfil=1");
	if(count($req) > 0){
		$percent = $req[0]->purchased;
	}
	$events_loop .= "{
		label: '$team_name',
		data: $percent
	},";
}

$events_loop = rtrim($events_loop, ',');
$g_vs_r = "[".$events_loop."]";
//echo $g_vs_r;
/*$g_vs_r = '[{
      label: "iPhone5S",
      data: 64
    },    
    {
      label: "iPad Mini",
      data: 1
    }]';*/
?>
<script>
$(document).ready(function(){
	
	// fullcalendar
	var date = new Date();
	date.setMonth(date.getMonth() + 0);
	//alert(date)
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	var addDragEvent = function($this){};
	$('.calendar').each(function() {
	
		$(this).fullCalendar({
		header: {
		  left: 'prev',
		  center: 'title',
		  right: 'next'
		},
		editable: false,
		droppable: false, // this allows things to be dropped onto the calendar !!!
		drop: function(date, allDay) {}
		,
		<?php echo $events;?>,
		   eventMouseover: function(calEvent, jsEvent) {
				
				var tooltip = '<div class="tooltipevent" style="width:23%;height:auto;background:#F4F4F4;position:absolute;z-index:10001;"><div style="width:100%; font-size:14px; font-weight:bold; text-align:center; padding-top:6px;">' + calEvent.OriginalGameDate + '</div><div style="width:100%; font-size:14px; font-weight:bold; text-align:center;">vs ' + calEvent.title + '</div><div style="width:100%; line-height:1px; border:dotted 1px #ccc;">&nbsp;</div><div style="width:100%; font-size:13px; font-weight:bold; padding-top:6px; padding-left:2%;">Enter Requested By</div><div style="width:100%; font-size:13px; padding-top:6px; padding-left:2%;">' + calEvent.OriginalGameDate + '</div><div style="width:100%; font-size:13px; font-weight:bold; padding-top:6px; padding-left:2%;">Promotions</div><div style="width:100%; font-size:13px; padding-top:6px; padding-left:2%;">' + calEvent.Promotions + '</div></div>';
				$("body").append(tooltip);
				$(this).mouseover(function(e) {
					$(this).css('z-index', 10000);
					$('.tooltipevent').fadeIn('500');
					$('.tooltipevent').fadeTo('10', 1.9);
				}).mousemove(function(e) {
					$('.tooltipevent').css('top', e.pageY + 40);
					$('.tooltipevent').css('left', e.pageX - 180);
				});
			},
		
		eventMouseout: function(calEvent, jsEvent) {
			 $(this).css('z-index', 8);
			 $('.tooltipevent').remove();
		},
		
		
		});
	});                    
	$('#calendar').fullCalendar('gotoDate', date);
});


$(function(){

  // 
  var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
  var d1 = [];
  for (var i = 0; i <= 11; i += 1) {
    d1.push([i, parseInt((Math.floor(Math.random() * (1 + 20 - 10))) + 10)]);
  }

  $("#flot-1ine").length && $.plot($("#flot-1ine"), [{
          data: d1
      }], 
      {
        series: {
            lines: {
                show: true,
                lineWidth: 1,
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 0.3
                    }, {
                        opacity: 0.3
                    }]
                }
            },
            points: {
                radius: 3,
                show: true
            },
            grow: {
              active: true,
              steps: 50
            },
            shadowSize: 2
        },
        grid: {
            hoverable: true,
            clickable: true,
            tickColor: "#f0f0f0",
            borderWidth: 1,
            color: '#f0f0f0'
        },
        colors: ["#1bb399"],
        xaxis:{
        },
        yaxis: {
          ticks: 5
        },
        tooltip: true,
        tooltipOpts: {
          content: "chart: %x.1 is %y.4",
          defaultTheme: false,
          shifts: {
            x: 0,
            y: 20
          }
        }
      }
  );

  var d0 = [
    [0,0],[1,0],[2,1],[3,2],[4,15],[5,5],[6,12],[7,10],[8,55],[9,13],[10,25],[11,10],[12,12],[13,6],[14,2],[15,0],[16,0]
  ];
  var d00 = [
    [0,0],[1,0],[2,1],[3,0],[4,1],[5,0],[6,2],[7,0],[8,3],[9,1],[10,0],[11,1],[12,0],[13,2],[14,1],[15,0],[16,0]
  ];
  $("#flot-sp1ine").length && $.plot($("#flot-sp1ine"), [
          d0, d00
      ],
      {
        series: {
            lines: {
                show: false
            },
            splines: {
              show: true,
              tension: 0.4,
              lineWidth: 1,
              fill: 0.4
            },
            points: {
                radius: 0,
                show: true
            },
            shadowSize: 2
        },
        grid: {
            hoverable: true,
            clickable: true,
            tickColor: "#d9dee9",
            borderWidth: 1,
            color: '#d9dee9'
        },
        colors: ["#19b39b", "#644688"],
        xaxis:{
        },
        yaxis: {
          ticks: 4
        },
        tooltip: true,
        tooltipOpts: {
          content: "chart: %x.1 is %y.4",
          defaultTheme: false,
          shifts: {
            x: 0,
            y: 20
          }
        }
      }
  );
  
  var d2 = [];
  for (var i = 0; i <= 6; i += 1) {
    d2.push([i, parseInt((Math.floor(Math.random() * (1 + 30 - 10))) + 10)]);
  }
  var d3 = [];
  for (var i = 0; i <= 6; i += 1) {
    d3.push([i, parseInt((Math.floor(Math.random() * (1 + 30 - 10))) + 10)]);
  }
  $("#flot-chart").length && $.plot($("#flot-chart"), [{
          data: d2,
          label: "Unique Visits"
      }, {
          data: d3,
          label: "Page Views"
      }], 
      {
        series: {
            lines: {
                show: true,
                lineWidth: 1,
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 0.3
                    }, {
                        opacity: 0.3
                    }]
                }
            },
            points: {
                show: true
            },
            shadowSize: 2
        },
        grid: {
            hoverable: true,
            clickable: true,
            tickColor: "#f0f0f0",
            borderWidth: 0
        },
        colors: ["#1bb399","#177bbb"],
        xaxis: {
            ticks: 15,
            tickDecimals: 0
        },
        yaxis: {
            ticks: 10,
            tickDecimals: 0
        },
        tooltip: true,
        tooltipOpts: {
          content: "'%s' of %x.1 is %y.4",
          defaultTheme: false,
          shifts: {
            x: 0,
            y: 20
          }
        }
      }
  );


  // live update
  var data = [],
  totalPoints = 300;

  function getRandomData() {

    if (data.length > 0)
      data = data.slice(1);

    // Do a random walk

    while (data.length < totalPoints) {

      var prev = data.length > 0 ? data[data.length - 1] : 50,
        y = prev + Math.random() * 10 - 5;

      if (y < 0) {
        y = 0;
      } else if (y > 100) {
        y = 100;
      }

      data.push(y);
    }

    // Zip the generated y values with the x values

    var res = [];
    for (var i = 0; i < data.length; ++i) {
      res.push([i, data[i]])
    }

    return res;
  }

  var updateInterval = 30, live;
  $("#flot-live").length && ( live = $.plot("#flot-live", [ getRandomData() ], {
    series: {
      lines: {
          show: true,
          lineWidth: 1,
          fill: true,
          fillColor: {
              colors: [{
                  opacity: 0.2
              }, {
                  opacity: 0.1
              }]
          }
      },
      shadowSize: 2
    },
    colors: ["#cccccc"],
    yaxis: {
      min: 0,
      max: 100
    },
    xaxis: {
      show: false
    },
    grid: {
        tickColor: "#f0f0f0",
        borderWidth: 0
    },
  }) ) && update();

  function update() {

    live.setData([getRandomData()]);

    // Since the axes don't change, we don't need to call plot.setupGrid()

    live.draw();
    setTimeout(update, updateInterval);
  };

  // bar
  var d1_1 = [
    [10, 120],
    [20, 70],
    [30, 100],
    [40, 60]
  ];

  var d1_2 = [
    [10, 80],
    [20, 60],
    [30, 30],
    [40, 35]
  ];

  var d1_3 = [
    [10, 80],
    [20, 40],
    [30, 30],
    [40, 20]
  ];

  var data1 = [
    {
        label: "Product 1",
        data: d1_1,
        bars: {
            show: true,
            fill: true,
            lineWidth: 1,
            order: 1,
            fillColor: { colors: [{ opacity: 0.5 }, { opacity: 0.9}] }
        },
        color: "#6783b7"
    },
    {
        label: "Product 2",
        data: d1_2,
        bars: {
            show: true,
            fill: true,
            lineWidth: 1,
            order: 2,
            fillColor: { colors: [{ opacity: 0.5 }, { opacity: 0.9}] }
        },
        color: "#4fcdb7"
    },
    {
        label: "Product 3",
        data: d1_3,
        bars: {
            show: true,
            fill: true,
            lineWidth: 1,
            order: 3,
            fillColor: { colors: [{ opacity: 0.5 }, { opacity: 0.9}] }
        },
        color: "#8dd168"
    }
  ];

  var d2_1 = [
    [90, 10],
    [70, 20]
  ];

  var d2_2 = [
    [80, 10],
    [60, 20]
  ];

  var d2_3 = [
    [120, 10],
    [50, 20]
  ];

  var data2 = [
    {
        label: "Product 1",
        data: d2_1,
        bars: {
            horizontal: true,
            show: true,
            fill: true,
            lineWidth: 1,
            order: 1,
            fillColor: { colors: [{ opacity: 0.5 }, { opacity: 1}] }
        },
        color: "#6783b7"
    },
    {
        label: "Product 2",
        data: d2_2,
        bars: {
            horizontal: true,
            show: true,
            fill: true,
            lineWidth: 1,
            order: 2,
            fillColor: { colors: [{ opacity: 0.5 }, { opacity: 1}] }
        },
        color: "#4fcdb7"
    },
    {
        label: "Product 3",
        data: d2_3,
        bars: {
            horizontal: true,
            show: true,
            fill: true,
            lineWidth: 1,
            order: 3,
            fillColor: { colors: [{ opacity: 0.5 }, { opacity: 1}] }
        },
        color: "#8dd168"
    }
  ];

  $("#flot-bar").length && $.plot($("#flot-bar"), data1, {
      xaxis: {
          
      },
      yaxis: {
          
      },
      grid: {
          hoverable: true,
          clickable: false,
          borderWidth: 0
      },
      legend: {
          labelBoxBorderColor: "none",
          position: "left"
      },
      series: {
          shadowSize: 1
      },
      tooltip: true,
  });

  $("#flot-bar-h").length && $.plot($("#flot-bar-h"), data2, {
      xaxis: {
          
      },
      yaxis: {
          
      },
      grid: {
          hoverable: true,
          clickable: false,
          borderWidth: 0
      },
      legend: {
          labelBoxBorderColor: "none",
          position: "left"
      },
      series: {
          shadowSize: 1
      },
      tooltip: true,
  });

  // pie

  var da = [
    {
      label: "iPhone5S",
      data: 40
    },    
    {
      label: "iPad Mini",
      data: 10
    }
  ],
  <?php /*?>var da = <?php echo $g_vs_r;?>,<?php */?>
  da1 = [],
  series = Math.floor(Math.random() * 4) + 3;

  for (var i = 0; i < series; i++) {
    da1[i] = {
      label: "Series" + (i + 1),
      data: Math.floor(Math.random() * 100) + 1
    }
  }

  $("#flot-pie-donut").length && $.plot($("#flot-pie-donut"), da, {
    series: {
      pie: {
        innerRadius: 0.4,
        show: true,
        stroke: {
          width: 0
        },
        label: {
          show: true,
          threshold: 0.05
        },

      }
    },
    colors: ["#65b5c2","#4da7c1","#3993bb","#2e7bad","#23649e"],
    grid: {
        hoverable: true,
        clickable: false
    },
    tooltip: true,
    tooltipOpts: {
      content: "%s: %p.0%"
    }
  });


});  
</script>