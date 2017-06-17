@section('title')
    Home
@stop

@include('includes.top')

<section class="vbox">
    
    @include('includes.header')
    
    <section>
      <section class="hbox stretch">
                
        <?php
		$current_date = date('Y-m-d');
		$allgames = DB::table('game')->where('requeststate_id', 3)->where(DB::Raw('DATE(OriginalGameDate)'), '>=' , $current_date)->get();
		$no_of_games = count($allgames);
		?>
        <div class="row">
        <div class="col-sm-1">&nbsp;</div>
        <div class="col-sm-10">
        <section id="content">
          <section class="hbox1 stretch">
            <section>
              <section class="vbox">
                <section class="scrollable padder">              
                  <section class="row m-b-md">
                    <div class="col-sm-6">
                      <h3 class="m-b-xs text-black">Dashboard</h3>
                      <small>Welcome back, {!! Session::get('ecomps_user_name') !!}, <i class="fa fa-map-marker fa-lg text-primary"></i> {!! Session::get('ecomps_location') !!}</small>
                    </div>
                  </section>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="panel b-a">
                        <div class="row m-n">
                          <div class="col-md-6 b-b b-r">
                            <?php if(Session::get('ecomps_user_approver_level') == "first" || Session::get('ecomps_user_approver_level') == "second" || Session::get('ecomps_user_is_fulfiler') == "1"){?>
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
                            <?php }else if(Session::has('ecomps_vp_id')){?>
                            <a href="{{ url('vp-approve/requests') }}" class="block padder-v hover">
                              <span class="i-s i-s-2x pull-left m-r-sm">
                                <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i>
                                <i class="i i-plus2 i-1x text-white"></i>
                              </span>
                              <?php
								$ecomps_admin_id = trim(Session::get('ecomps_vp_id'));
								
								// Get selected departments from User Account Table
								$tmp = DB::select(DB::raw("select dept_of_vp from useraccount where id='$ecomps_admin_id'"));
								
								$dept_of_vp = 0;
								if(count($tmp) > 0){
									$dept_of_vp = $tmp[0]->dept_of_vp;
								}
								$str = "select * from request where id!='' And is_forward_to_fulfil=0 And is_fulfil=0 And user_cancel=0 And dept_id in (".$dept_of_vp.")";
								$data = DB::select(DB::raw($str));
								$pending_req = 0;
								foreach ($data as $index=>$tmpdata){
								if($tmpdata->is_forward_to_fulfil == "0" && $tmpdata->is_fulfil == "0" && $tmpdata->is_cancel == "0" && $tmpdata->user_cancel == "0"){
									$pending_req=$pending_req+1;
								}
								}
							  ?>
                              <span class="clear">
                                <span class="h3 block m-t-xs text-danger"><?php echo $pending_req;?></span>
                                <small class="text-muted text-u-c">Pending Requests</small>
                              </span>
                            </a>
                            <?php }?>
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
                                <span class="h5 block m-t-xs">Next Game</span>
                                <span class="h4 block m-t-xs text-primary"><?php echo $team_name;?></span>
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
						$no_of_req = DB::table('request')->count();
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
                                            
                    </div>
                  </div>           
                  <div class="row bg-light1 dk m-b">
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
		<param name="wmode" value="transparent" />
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
                    
                    <div class="col-md-5" style="padding-left:2%;">
                      
                      <section class="panel panel-default">
                            <header class="panel-heading">                    
                              <span class="label bg-dark h5"><?php echo $no_of_games;?></span> Games VS Requests
                            </header>
                            
                                {!!HTML::script('public/admin_assets/js/slimscroll/jquery.slimscroll.min.js')!!}
                                
                            <section class="panel-body slim-scroll" data-height="315px" data-size="10px">
                              
                              <?php
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
                                    
                                ?>
                              <article class="media">
                                <span class="pull-left thumb-sm">
                                <img src="<?php echo url('/');?>/public/images/logos/<?php echo $logo;?>" class=" hover-rotate">
                                </span>
                                <div class="media-body">
                                  <div class="media-xs text-center text-muted">
                                    
                                  </div>
                                  <span class="h4 block m-t-xs text-danger"><?php echo $team_name;?>,&nbsp;<small class="text-muted text-u-c"><?php echo $OriginalGameDate;?></small></span>
                                  <span>&nbsp;</span>
                                  <small class="block h5 text-muted text-u-c"><a href="#" class="" style="line-height:25px;">Users</a> <span class="label label-info"><?php echo $total_requested_ticket;?></span>&nbsp;|&nbsp;<a href="#" class="">Total Purchased</a> <span class="label label-success"><?php echo $total_purchased_ticket;?></span></small>
                                  
                                </div>
                              </article>            
                              <div class="line pull-in"></div>
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
                    <div class="col-md-4"<?php /*?> style="width:31%;"<?php */?>>
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
                        <a href="#" class="list-group-item clearfix">
                            
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
                    
                    </section>
                    </div>
                    <div class="col-md-4">
                        <section class="panel b-light">
                            <!--<header class="panel-heading"><strong>Calendar</strong></header>-->
                            <div id="calendar" class="calendar bg-light dker m-l-n-xxs m-r-n-xxs"></div>
                        </section>                  
                    </div>
                </div>
                </section>
              </section>
            </section>
            <!-- side content -->
            
            <!-- / side content -->
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
        </section>
        </div>
        </div>
      </section>
      
    </section>
  </section>

@include('includes.admin_footer')
    
{!!HTML::script('public/admin_assets/js/fullcalendar/fullcalendar.min.js')!!}
{!! Html::style('public/admin_assets/js/fullcalendar/fullcalendar.css') !!}
{!! Html::style('public/admin_assets/js/fullcalendar/theme.css')!!}