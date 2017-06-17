<?php
/*
Page Name: top.blade.php
* This is the html page, 
*/
?>
<!DOCTYPE html>
<html lang="en" class=" ">
<head>  
    <meta charset="utf-8" />
    <title>eComps | @yield('title')</title>
    <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  	
    {!! Html::style('public/admin_assets/css/bootstrap.css') !!}
    {!! Html::style('public/admin_assets/css/animate.css') !!}
    {!! Html::style('public/admin_assets/css/font-awesome.min.css') !!}
    {!! Html::style('public/admin_assets/css/icon.css') !!}
    {!! Html::style('public/admin_assets/css/font.css') !!}
    {!! Html::style('public/admin_assets/css/app.css') !!}
    
    <!--[if lt IE 9]>
    {!!HTML::script('public/admin_assets/js/moment.min.js')!!}
    {!!HTML::script('public/admin_assets/ie/html5shiv.js')!!}
    {!!HTML::script('public/admin_assets/ie/respond.min.js')!!}
    {!!HTML::script('public/admin_assets/ie/excanvas.js')!!}
	<![endif]-->
    
	{!!HTML::script('public/admin_assets/js/jquery.min.js')!!}
    {!!HTML::script('public/admin_assets/js/bootstrap.js')!!}
    {!!HTML::script('public/admin_assets/js/app.js')!!}
    {!!HTML::script('public/admin_assets/js/charts/flot/demo.js')!!}    
    
    {!!HTML::script('public/admin_assets/js/sortable/jquery.sortable.js')!!}
	{!!HTML::script('public/admin_assets/js/app.plugin.js')!!}
    
    {!!HTML::script('public/admin_assets/js/fullcalendar/fullcalendar.min.js')!!}
    {!! Html::style('public/admin_assets/js/fullcalendar/fullcalendar.css') !!}
    {!! Html::style('public/admin_assets/js/fullcalendar/theme.css')!!}
            
    <!-- Modal -->
    <div id="myGameModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
        
        <!-- Modal content-->
            <div class="modal-content">
                <!--<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Calendar</h4>
                </div>-->
                <?php
                $current_date = date('Y-m-d');
                $allgames = DB::table('game')->where('requeststate_id', 3)->where(DB::Raw('DATE(OriginalGameDate)'), '>=' , $current_date)->get();
                ?>
                <section>
                    <section class="hbox stretch">
                        <div class="panel-body">
                            <div class="col-sm-12">
                                <section class="panel border bg-light1">
                                  <div class="calendar" id="calendar"></div>
                                </section>
                            </div>
                        </div>
                    </section>
                </section>
                <!--<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>-->
            </div>
        
                        
            <style>
            .fc-header-left, .fc-header-right {
               /*visibility: hidden;*/
            }
            .fc-day:hover{border:dotted 2px #666;}
            .tooltipevent {
                position: relative;
                background: #F4F4F4;
                border: 1px solid #ccc;
            }
            .tooltipevent:after, .arrow_box:before {
                bottom: 100%;
                left: 50%;
                border: solid transparent;
                content: " ";
                height: 0;
                width: 0;
                position: absolute;
                pointer-events: none;
            }
            
            .tooltipevent:after {
                border-color: rgba(136, 183, 213, 0);
                border-bottom-color: #ccc;
                border-width: 10px;
                margin-left: -10px;
            }
            .tooltipevent:before {
                border-color: rgba(194, 225, 245, 0);
                border-bottom-color: #c2e1f5;
                border-width: 37px;
                margin-left: -37px;
            }
            </style>
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
			$is_vp = Session::get('ecomps_vp_id');
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
                
				if($is_vp > 0){
					$events_loop .= "{
						title: '$team_name',
						start: new Date($y, $m1, $d),
						className:'test$game_id',
						url: '".url('/')."/vp-approve/game/$game_id/view',
						tooltip: 'test event',
						OriginalGameDate : '$OriginalGameDate',
						Promotions:'$Promotions'
					},";
				}else{
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
            }
            $events_loop = rtrim($events_loop, ',');
            $events = "events: [".$events_loop."]";
            ?>
            <script>
            $(document).ready(function(){					
                $('#myGameModal').on('shown.bs.modal', function () {
                   $("#calendar").fullCalendar('render');
                });
            });
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
            
            </script>
            <!--<style>#myGameModal {display:block; }</style>-->
        </div>
    </div>    
    <!-- Modal -->
    
    <?php
	$ecomps_user_id = Session::get('ecomps_user_id');
	
	// 1 = Time Out
	$res_timeout = DB::table('appsettings')->where('id', '1')->get();
	$timeout_time = $res_timeout[0]->Value;
	if($ecomps_user_id != "" && $timeout_time > 0){
		
		// Minute to seconds
		$timeout_time = $timeout_time * 60;
	?>
    <script language="Javascript" type="text/javascript">
	var countdown;
	var countdown_number;
	function countdown_init(count) {
		countdown_number = count;
		countdown_trigger();
	}
	function countdown_trigger() {
		if(countdown_number > 0) {
			countdown_number--;
			document.getElementById('countdown_text').value = countdown_number;
			if(countdown_number > 0) {
				countdown = setTimeout('countdown_trigger()', 1000);
			}
		}
		if(countdown_number == 0){
			var msg = "Your session has been expired.";
			alert(msg)
			window.location.href='<?php echo url('/logout');?>';
		}
	}
	</script>
    <?php }?>
</head>
<body class="" <?php if($ecomps_user_id != "" && $timeout_time > 0){?> onLoad="countdown_init(<?php echo $timeout_time;?>);" <?php }?> >
<?php if($ecomps_user_id != "" && $timeout_time > 0){?><input type="hidden" id="countdown_text"><?php }?>