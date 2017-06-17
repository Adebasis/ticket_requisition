<?php
$all = DB::table('request_message')->where('request_id', '=', $request_id)->where('id', '>', $last_id)->orderBy('created_date', 'asc')->get();
$ses_user_id = Session::get('ecomps_user_id');

foreach($all as $index=>$noti){
	$dated = date('D, M d Y', strtotime($noti->created_date));
	$time = date('h:i A', strtotime($noti->created_date));
	
	if($noti->user_type == "admin"){
		$by = 'Admin';
	}elseif($noti->user_type == "vp"){
		$by = 'Vice President';
	}else{
		if($noti->user_id == $ses_user_id){
			$by = 'Me';
		}else{
			$requester = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $noti->user_id );
			$by = $requester->FirstName.' '.$requester->LastName;
		}
	}
	$message = $noti->message;
?>
<article class="timeline-item <?php if($arr_ == 0){?> alt <?php }?>">
    <div class="timeline-caption">
      <div class="panel panel-default">
        <div class="panel-body">
          <span class="arrow  <?php if($arr_ == 0){?> right <?php }else{?>left<?php }?>"></span>
          <span class="timeline-icon"><i class="fa fa-phone time-icon bg-primary"></i></span>
          <span class="timeline-date"></span></span>
          <div class="text-sm"><?php echo $by;?></div>
          <div class="text-sm"><span style="font-size:10px; font-style:italic;"><?php echo $dated;?>&nbsp;<?php echo $time;?></span></div>
          <h5><?php echo $message;?></h5>
        </div>
      </div>
    </div>
</article>
<input type="hidden" id="mid<?php echo $row_id;?>" class="mid" value="<?php echo $noti->id;?>" />
<?php }?>