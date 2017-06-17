@include('admin.includes.top')

<script>
function Validation(){
	if($('#OriginalGameDate').val().trim() == ""){
		$('#OriginalGameDate').focus();
		return false;
	}
}
</script>

{!! Html::style('public/admin_assets/js/datepicker/bootstrap-datetimepicker.min.css') !!}

<section class="vbox">
    
    @include('admin.includes.header')
    
    <section>
        <section class="hbox stretch">
            <!-- .aside -->
            @include('admin.includes.left')
            <!-- /.aside -->
            <section id="content">
                <section class="hbox stretch">
                    <section>
                        <section class="vbox">
                            <section class="scrollable padder">              
                                <section class="row m-b-md"></section>
                                <div class="row">
                                    <div class="col-sm-10">
                                        <section class="panel panel-default">
                                        	
                                            <header class="panel-heading font-bold">EDIT GAME</header>
                                            <div class="panel-body">
                                            
                                                {!!Form::open(array('action'=>'AdminController@admin_post_game_edit','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                                    {!!Form::hidden('pk_id',$data[0]->id)!!}
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                            	<div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-lg-4 col-md-6">
                                                                            {{ Form::label('EventCode', 'EVENT CODE') }}
                                                                            {!!Form::text('EventCode', $data[0]->EventCode,array('class'=>'form-control', 'required', 'autofocus'))!!}
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6">
                                                                        	{{ Form::label('GameNumber', 'GAME NUMBER') }}
                                                                            {!!Form::number('GameNumber', $data[0]->GameNumber, array('class'=>'form-control', 'required'))!!}
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6">
                                                                        	
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">&nbsp;</div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        
                                                                        <div class="col-sm-6">
                                                                            {{ Form::label('OriginalGameDate', 'Original Game Date') }}<!--  03/15/2017, 04:30 pm-->
                                                                            <div class="controls input-append date OriginalGameDate" data-date-format="mm/dd/yyyy, HH:ii p">
                                                                                <input name="OriginalGameDate" id="OriginalGameDate" value="{{ date('m/d/Y, h:i a', strtotime($data[0]->OriginalGameDate)) }}" size="16" type="text" class="form-control" readonly>
                                                                                <span class="add-on"><i class="icon-remove"></i></span>
                                                                                <span class="add-on"><i class="icon-th"></i></span>
                                                                        	</div>
                                                                        </div>
                                                                        <?php
																		$ScheduledGameDate = "";
																		if($data[0]->ScheduledGameDate != ""){
																			$ScheduledGameDate = date('m/d/Y, h:i a', strtotime($data[0]->ScheduledGameDate));
																		}
																		?>
                                                                        <div class="col-sm-6">
                                                                        	{{ Form::label('ScheduledGameDate', 'Scheduled Game Date') }}
                                                                            <div class="controls input-append date ScheduledGameDate" data-date-format="mm/dd/yyyy, HH:ii p">
                                                                                <input name="ScheduledGameDate" size="16" type="text" value="{{ $ScheduledGameDate }}" class="form-control" readonly>
                                                                                <span class="add-on"><i class="icon-remove"></i></span>
                                                                                <span class="add-on"><i class="icon-th"></i></span>
                                                                        	</div>
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                    </div>
                                                                </div>
                                                                <?php
																$teams = DB::table('team')->orderBy('Name', 'asc')->get();
																$demandtype = DB::table('demandtype')->orderBy('Name', 'asc')->get();
																$pricingtype = DB::table('pricingtype')->orderBy('Name', 'asc')->get();
																$gamerequeststate = DB::table('gamerequeststate')->orderBy('Name', 'asc')->get();
																$gamestate = DB::table('gamestate')->orderBy('Name', 'asc')->get();
																$allocationpooltype = DB::table('allocationpooltype')->orderBy('Name', 'desc')->get();
																?>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-6">
                                                                            {{ Form::label('team_id', 'Opponent Team') }}
                                                                            <select name="team_id" class="form-control" required>
                                                                            	<option value="">Please Select</option>
                                                                                <?php foreach($teams as $team){?>
                                                                                <option value="<?php echo $team->id;?>" <?php if($team->id==$data[0]->team_id){?> selected="selected" <?php }?>><?php echo $team->Name;?></option>
                                                                                <?php }?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                        	{{ Form::label('demandtype_id', 'Demand type') }}
                                                                            <select name="demandtype_id" class="form-control" required>
                                                                            	<option value="">Please Select</option>
                                                                                <?php foreach($demandtype as $tmp){?>
                                                                                <option value="<?php echo $tmp->id;?>" <?php if($tmp->id==$data[0]->demandtype_id){?> selected="selected" <?php }?>><?php echo $tmp->Name;?></option>
                                                                                <?php }?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">&nbsp;</div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-6">
                                                                            {{ Form::label('pricingtype_id', 'Price Type') }}
                                                                            <select name="pricingtype_id" class="form-control" required>
                                                                            	<option value="">Please Select</option>
                                                                                <?php foreach($pricingtype as $tmp){?>
                                                                                <option value="<?php echo $tmp->id;?>" <?php if($tmp->id==$data[0]->pricingtype_id){?> selected="selected" <?php }?>><?php echo $tmp->Name;?></option>
                                                                                <?php }?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                        	{{ Form::label('requeststate_id', 'Game Request State') }}
                                                                            <select name="requeststate_id" class="form-control" required>
                                                                            	<option value="">Please Select</option>
                                                                                <?php foreach($gamerequeststate as $tmp){?>
                                                                                <option value="<?php echo $tmp->id;?>" <?php if($tmp->id==$data[0]->requeststate_id){?> selected="selected" <?php }?>><?php echo $tmp->Name;?></option>
                                                                                <?php }?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">&nbsp;</div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-lg-3 col-sm-6">
                                                                        	{{ Form::label('gamestate_id', 'Game State') }}
                                                                            <select name="gamestate_id" class="form-control" required>
                                                                            	<option value="">Please Select</option>
                                                                                <?php foreach($gamestate as $tmp){?>
                                                                                <option value="<?php echo $tmp->id;?>" <?php if($tmp->id==$data[0]->gamestate_id){?> selected="selected" <?php }?>><?php echo $tmp->Name;?></option>
                                                                                <?php }?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-3 col-sm-6">
                                                                            {{ Form::label('AllowCompPurchase', 'Allow Comp Purchase') }}
                                                                            {{ Form::select('AllowCompPurchase', array('0' => 'No', '1' => 'Yes'), $data[0]->AllowCompPurchase, array('class'=>'form-control') ) }}
                                                                        </div>
                                                                        <div class="col-lg-3 col-sm-6">
                                                                        	{{ Form::label('AllowPersonalRequests', 'Allow Personal Requests') }}
                                                                            {{ Form::select('AllowPersonalRequests', array('0' => 'No', '1' => 'Yes'), $data[0]->AllowPersonalRequests, array('class'=>'form-control') ) }}
                                                                        </div>
                                                                        <div class="col-lg-3 col-sm-6">
                                                                            {{ Form::label('AllowCompTransfer', 'Allow Comp Transfer') }}
                                                                            {{ Form::select('AllowCompTransfer', array('0' => 'No', '1' => 'Yes'), $data[0]->AllowCompTransfer, array('class'=>'form-control') ) }}
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">&nbsp;</div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <?php
																		$RequestDeadline = "";
																		if($data[0]->RequestDeadline != ""){
																			$RequestDeadline = date('m/d/Y, h:i a', strtotime($data[0]->RequestDeadline));
																		}
																		?>
                                                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                                                            {{ Form::label('RequestDeadline', 'Request Deadline') }}
                                                                            <div class="controls input-append date RequestDeadline" data-date-format="mm/dd/yyyy, HH:ii p">
                                                                                <input name="RequestDeadline" size="16" type="text" value="{{ $RequestDeadline }}" class="form-control" readonly>
                                                                                <span class="add-on"><i class="icon-remove"></i></span>
                                                                                <span class="add-on"><i class="icon-th"></i></span>
                                                                        	</div>
                                                                        </div>
                                                                        <?php
																		$allType = DB::table('allocationpoolgames')->where('game_id', $data[0]->id)->get();
																		$allocationpooltype_id = 0;
																		if(count($allType) > 0){
																			$allocationpooltype_id = $allType[0]->allocationpooltype_id;
																		}
																		?>
                                                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                                                        	{{ Form::label('allocationpooltype_id', 'Allocation Pool Type') }}
                                                                            <select name="allocationpooltype_id" class="form-control">
                                                                                <?php foreach($allocationpooltype as $tmp){?>
                                                                                <option value="<?php echo $tmp->id;?>" <?php if($tmp->id==$allocationpooltype_id){?> selected="selected" <?php }?>><?php echo $tmp->Name;?></option>
                                                                                <?php }?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="clearfix visible-sm"></div>
                                                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                                                        	{{ Form::label('IsSellout', 'Is Sellout ?') }}
                                                                            {{ Form::select('IsSellout', array('0' => 'No', '1' => 'Yes'), $data[0]->IsSellout, array('class'=>'form-control') ) }}
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
													</div>
                                                    <div class="row">
                                                    	<div class="form-group">
                                                          <div class="col-lg-offset-2 col-lg-10">&nbsp;</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-12  text-right1">
                                                                {{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}&nbsp;{{ HTML::link('/adminpanel/game', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                {!!Form::close()!!}
                                            	
                                            </div>
                                        </section>           
                                    </div>
                                </div>
                            
	                            <div class="row"><div>&nbsp;</div></div>
                            
                            </section>
                        </section>
                    </section>
                </section>
            	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
            </section>
        </section>
    </section>

@include('admin.includes.admin_footer')

{!!HTML::script('public/admin_assets/js/datepicker/bootstrap-datetimepicker.js')!!} 

<script type="text/javascript">
    $('.OriginalGameDate').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.ScheduledGameDate').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.RequestDeadline').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	/*$('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });*/
</script>

