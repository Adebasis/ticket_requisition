@section('title')
    Calender
@stop

@include('includes.top')

<section class="vbox">
    
    @include('includes.header')
    <?php
	$current_year = date('Y');
	$current_month = date('m');
	$current_date = date('Y-m-d');
	
	//$allgames = DB::table('game')->where('requeststate_id', 3)->where(DB::Raw('month(DATE(OriginalGameDate))'), '=' , $current_month)->where(DB::Raw('year(DATE(OriginalGameDate))'), '=' , $current_year)->get();
	$allgames = DB::table('game')->where('requeststate_id', 3)->where(DB::Raw('DATE(OriginalGameDate)'), '>=' , $current_date)->get();
	//print_r($allgames);exit;
	?>
    <section>
        <section class="hbox stretch">
            
            {!! Html::style('public/admin_assets/js/fullcalendar/fullcalendar.css') !!}
            {!! Html::style('public/admin_assets/js/fullcalendar/theme.css')!!}
            
            <div class="panel-body">
                <div class="col-sm-1">&nbsp;</div>
                <div class="col-sm-10">
                
                <section class="panel border bg-light1">
                  <div class="calendar" id="calendar"></div>
                </section>
                
                </div>
                
            </div>
        </section>
    </section>

@include('includes.admin_footer')

{!!HTML::script('public/admin_assets/js/fullcalendar/fullcalendar.min.js')!!}

<style>
.fc-header-left, .fc-header-right {
   visibility: hidden;
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
			background: url('../public/images/logos/".$logo."');
			background-repeat: no-repeat;
			padding-top: 50px;
			text-align: center;
			background-position: center;
			}";
	}
    ?>
</style>

<?php
/*$x = "";
for($i=0;$i<5;$i++){
	$x .= $i.",";
}
echo rtrim($x, ',');exit;*/

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
?>
<script>
+function ($) {

  $(function(){

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
				/*var tooltip = '<div class="tooltipevent" style="width:23%;height:100px;background:#F4F4F4;position:absolute;z-index:10001;">' + calEvent.title + '</div>';*/
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
    /*$('#myEvents').on('change', function(e, item){
      addDragEvent($(item));
    });

    $('#myEvents li > div').each(function() {
      addDragEvent($(this));
    });*/
	
	
	
	$('#calendar').fullCalendar('gotoDate', date);
	
    $(document).on('click', '#dayview', function() {
      $('.calendar').fullCalendar('changeView', 'agendaDay')
    });

    $('#weekview').on('click', function() {
      $('.calendar').fullCalendar('changeView', 'agendaWeek')
    });

    $('#monthview').on('click', function() {
      $('.calendar').fullCalendar('changeView', 'month')
    });

  });
}(window.jQuery);
</script>