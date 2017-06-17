<?php
$all = DB::table('logs')->where('id', '<', $last_id)->orderBy('created_date', 'desc')->take(1)->get();
$count = DB::table('logs')->where('id', '<', $last_id)->count();
foreach($all as $index=>$logs){
	$dated = date('D, M d Y', strtotime($logs->created_date));
	$time = date('h:i A', strtotime($logs->created_date));
	$last_id = $logs->id;
	$data = DB::table('request')->where('id', $logs->request_id)->get();
?>
<article class="timeline-item ">
    <div class="timeline-caption">
      <div class="panel panel-default">
        <div class="panel-body">
          <span class="arrow left"></span>
          <span class="timeline-icon">
          <?php if($logs->user_type=='fulfiler'){?>
            <i class="fa fa-star time-icon" style="color:#fff; background-color:#c0c;"></i>
            <?php }?>
            <?php if($logs->user_type=='first'){?>
            <i class="fa fa-asterisk time-icon" style="color:#fff; background-color:#090;"></i>
            <?php }?>
            <?php if($logs->user_type=='second'){?>
            <i class="fa fa-mortar-board time-icon" style="color:#fff; background-color:#c03;"></i>
            <?php }?>
            <?php if($logs->user_type=='admin'){?>
            <i class="fa fa-star1 time-icon bg-primary">A</i>
            <?php }?>
            <?php if($logs->user_type=='vp'){?>
            <i class="fa fa-life-ring time-icon" style="color:#fff; background-color:#09c;"></i>
            <?php }?>
            <?php if($logs->user_type=='user'){?>
            <i class="fa fa-user time-icon bg-success" style="color:#fff; background-color:#333;"></i>
            <?php }?>
          </span>
          <span class="timeline-date"><?php echo $dated;?><span style="font-size:10px; font-style:italic;">&nbsp;<?php echo $time;?></span></span>
          <div class="text-sm"><?php echo ucwords($logs->user_name);?></div>
          <h5><?php echo $logs->descr;?></h5>
          <hr />
          <div class="text-sm"><h5><strong><u>Request Information</u></strong></h5></div>
          <div class="row">
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="form-group">
                            <?php
                            $requester = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $data[0]->requestor_id );
                            ?>
                            <div class="col-sm-6">
                                {{ Form::label('Name', 'REQUESTED BY') }} : <label><?php echo $requester->FirstName.' '.$requester->LastName;?></label>
                            </div>
                            <?php
							$department = DB::table("department")->select('Name')->where('id', $data[0]->dept_id)->get();
							?>
							<div class="col-sm-6">
								{{ Form::label('Name', 'DEPARTMENT') }} : <label><?php echo $department[0]->Name;?></label>
							</div>
                        </div>
                    </div>
                    <?php
                    $game = DB::table("game")->select('OriginalGameDate','team_id','demandtype_id','requeststate_id')->where('id', $data[0]->game_id)->get();
                    $team_id = $game[0]->team_id;
                    $demandtype_id = $game[0]->demandtype_id;
                    $requeststate_id = $game[0]->requeststate_id;
                    $team = DB::table("team")->select('Name')->where('id', $team_id)->get();
                    $demand = DB::table("demandtype")->select('Name')->where('id', $demandtype_id)->get();
                    $status = DB::table("gamerequeststate")->select('Name')->where('id', $requeststate_id)->get();
                    $deliverytype = DB::table("deliverytype")->select('Name')->where('id', $data[0]->deliverytype_id)->get();
                    $locationtype = DB::table("locationtype")->select('Name')->where('id', $data[0]->locationtype_id)->get();
                    ?>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-6">
                                {{ Form::label('game', 'Game') }}
                                <br />
                                <?php echo $team[0]->Name." - ".date('m/d/Y h:i A', strtotime($game[0]->OriginalGameDate));?>
                            </div>
                            <div class="col-sm-3">
                                {{ Form::label('Comp', 'COMP LEVEL') }} : <label><?php echo $data[0]->Comp;?></label>
                            </div>
                            <div class="col-sm-3">
                                {{ Form::label('Purchased', 'PURCHASE') }} : <label><?php echo $data[0]->Purchased;?></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-12">
                                {{ Form::label('RecipientFirstName', 'Recipient Name') }} : <?php echo $data[0]->RecipientFirstName;?> <?php echo $data[0]->RecipientLastName;?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-12">
                                {{ Form::label('Instructions', 'INSTRUCTIONS FOR TICKET OFFICE') }}
                                {!!Form::textarea('Instructions',$data[0]->Instructions,array('class'=>'form-control','id'=>'Instructions', 'size'=>'30x3','onkeyup'=>'countChar(this, "Instructions_char");', ''))!!}
                            </div>
                        </div>
                    </div>
                    <style>textarea {   resize: none; }</style>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-12">
                                {{ Form::label('UserComments', 'BUSINESS PURPOSE') }}&nbsp;({{ strlen($data[0]->UserComments) }} / 250)
                                {!!Form::textarea('UserComments',$data[0]->UserComments,array('class'=>'form-control','id'=>'UserComments', 'size'=>'30x3','onkeyup'=>'countChar(this, "UserComments_char");', ''))!!}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-12">
                    <div class="form-group" style=" padding-top:10px;">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-4" style="background-color:#333; color:#fff;">
                                {{ Form::label('Name', date('m/d/Y h:i:s A', strtotime($game[0]->OriginalGameDate))) }}
                                </div>
                                <div class="col-sm-4" style="background-color:#333; color:#fff;">
                                {{ Form::label('Name', '&nbsp;') }}
                                </div>
                                <div class="col-sm-4 text-right" style="background-color:#333; color:#fff;">
                                {{ Form::label('Name', $team[0]->Name ) }}
                                </div>
                            </div>
                        </div>
                        <div class="row" style="background-color:#fff;">
                            <div class="form-group">
                                <div class="col-sm-4" style="margin-top:12px;">
                                {{ Form::label('Name', 'DEMAND LEVEL', array('style' => 'font-weight:bold;')) }}
                                </div>
                                <div class="col-sm-4" style="margin-top:12px;">
                                {{ Form::label('Name', 'PROMOTIONS', array('style' => 'font-weight:bold;')) }}
                                </div>
                                <div class="col-sm-4" style="margin-top:12px;">
                                {{ Form::label('Name', 'STATUS', array('style' => 'font-weight:bold;')) }}
                                </div>
                            </div>
                        </div>
                        <div class="row" style="background-color:#fff;">
                            <div class="form-group">
                                <div class="col-sm-4">
                                <label><?php echo $demand[0]->Name;?></label>
                                </div>
                                <div class="col-sm-4">
                                {{ Form::label('Name', 'No Promotions') }}
                                </div>
                                <div class="col-sm-4"><label><?php echo $status[0]->Name;?></label></div>
                            </div>
                        </div>
                        <div class="row" style="background-color:#fff;">
                            <div class="col-sm-12">
                                &nbsp;
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-3" style="background-color:#000; color:#fff;">
                                {{ Form::label('Name', 'Request Status') }}
                                </div>
                                <div class="col-sm-2 text-center" style="border:dotted 1px #000;">
                                APPROVED
                                </div>
                                <div class="col-sm-2 text-center" style="border:dotted 1px #000;">
                                FULFILLED
                                </div>
                                <div class="col-sm-3 text-center" style="border:dotted 1px #000;">
                                LOCATION
                                </div>
                                <div class="col-sm-2 text-center" style="border:dotted 1px #000;">
                                USAGE
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-3" style="background-color:#000;">
                                </div>
                                <div class="col-sm-2 text-center" style="border:dotted 1px #000;">
                                <div class="text-<?php if($data[0]->req_prec == "1" || $data[0]->req_prec == "2"){?>success<?php }else if($data[0]->req_prec == "3"){?>danger<?php }else if($data[0]->req_prec == "4"){?>primary<?php }?>">
                                    <i class="fa fa-circle"></i>
                                </div>
                                </div>
                                <div class="col-sm-2 text-center" style="border:dotted 1px #000;">
                                <div class="text-<?php if($data[0]->req_prec == "2"){?>warning<?php }?>">
                                    <i class="fa fa-circle"></i>
                                </div>
                                </div>
                                <div class="col-sm-3 text-center" style="border:dotted 1px #000;">
                                --
                                </div>
                                <div class="col-sm-2 text-center" style="border:dotted 1px #000;">
                                --
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {{ Form::label('UserComments', 'COMPANY NAME') }} : <?php echo $data[0]->CompanyName;?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    {{ Form::label('UserComments', 'LOCATION') }} : <label><?php echo $locationtype[0]->Name;?></label>
                                </div>
                                <div class="col-sm-6">
                                    {{ Form::label('UserComments', 'DELIVERY') }} : <label><?php echo $deliverytype[0]->Name;?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>       
      </div>
    </div>
</article>
<?php if($count > 1){?>
<div class="timeline-footer" id="focus<?php echo $last_id; ?>">
    <a style="cursor:pointer;" onclick="loadmore();"><i class="fa fa-angle-double-down time-icon inline-block bg-dark" style="color:#FFF;"></i></a>
    <input type="hidden" id="last_id" value="<?php echo $last_id;?>" />
</div>
<?php }else{?>
<input type="hidden" id="last_id" value="0" />
<?php }?>
<?php }?>