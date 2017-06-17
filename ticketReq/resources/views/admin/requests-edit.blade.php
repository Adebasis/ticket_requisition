@include('admin.includes.top')

<script>
function Validation(){
	if($('#Name').val().trim() == ""){
		$('#Name').focus();
		return false;
	}
}
</script>

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
                                    <div class="col-sm-11">
                                        <section class="panel panel-default">
                                        	
                                            <header class="panel-heading font-bold">REQUEST DETAILS</header>
                                            <div class="panel-body">
                                            
                                                {!!Form::open(array('action'=>'AdminController@adminEmployeeTypeEdit','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                                    
                                                    {!!Form::hidden('pk_id',$data[0]->id)!!}
                                                    
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                            	<div class="row">
                                                                    <div class="form-group">
                                                                        <?php
																		$requester = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $data[0]->requestor_id );
																		?>
                                                                        <div class="col-sm-6">
                                                                            {{ Form::label('Name', 'REQUESTED BY') }}
                                                                            {!!Form::text('Name', $requester->FirstName.' '.$requester->LastName,array('class'=>'form-control', 'disabled'))!!}
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                        	{{ Form::label('Name', 'DEPARTMENT') }}
                                                                            {{ Form::select('dept_id', $department, $data[0]->dept_id, array('placeholder' => 'Please select ...', 'class'=>'form-control','id'=>'requesttype_id', 'autofocus', 'disabled')) }}
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
																?>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-6">
                                                                            
                                                                            {{ Form::label('game', 'Game') }}
                                                                            {!!Form::text('game',$team[0]->Name." - ".date('m/d/Y h:i A', strtotime($game[0]->OriginalGameDate)),array('class'=>'form-control','id'=>'Comp', 'disabled'))!!}
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            {{ Form::label('Comp', 'COMP LEVEL') }}
                                                                            {!!Form::number('Comp',$data[0]->Comp,array('class'=>'form-control','id'=>'Comp', 'required', 'disabled','min'=>'0'))!!}
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                        	{{ Form::label('Purchased', 'PURCHASE TICKETS') }}
                                                                            {!!Form::number('Purchased',$data[0]->Purchased,array('class'=>'form-control','id'=>'Purchased', 'disabled','min'=>'0'))!!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-6">
                                                                            {{ Form::label('RecipientFirstName', 'FIRST NAME') }}
                                                                            {!!Form::text('RecipientFirstName',$data[0]->RecipientFirstName,array('class'=>'form-control','id'=>'RecipientFirstName', 'disabled'))!!}
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                        	{{ Form::label('RecipientLastName', 'LAST NAME') }}
                                                                            {!!Form::text('RecipientLastName',$data[0]->RecipientLastName,array('class'=>'form-control','id'=>'RecipientLastName', 'disabled'))!!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <script>
																function countChar(val, res) {																
																	var len = val.value.length;
																	if (len > 250) {
																		val.value = val.value.substring(0, 250);
																	} else {
																		$('#'+res).text(parseInt(len));
																	}
																};
																</script>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-12">
                                                                            {{ Form::label('Instructions', 'INSTRUCTIONS FOR TICKET OFFICE') }}&nbsp;(<span id="Instructions_char">{{ strlen($data[0]->Instructions) }}</span> / 250)
                                                                            {!!Form::textarea('Instructions',$data[0]->Instructions,array('class'=>'form-control','id'=>'Instructions', 'size'=>'30x3','onkeyup'=>'countChar(this, "Instructions_char");', ''))!!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <style>textarea {   resize: none; }</style>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-12">
                                                                            {{ Form::label('UserComments', 'BUSINESS PURPOSE') }}&nbsp;(<span id="UserComments_char">{{ strlen($data[0]->UserComments) }}</span> / 250)
                                                                            {!!Form::textarea('UserComments',$data[0]->UserComments,array('class'=>'form-control','id'=>'UserComments', 'size'=>'30x3','onkeyup'=>'countChar(this, "UserComments_char");', ''))!!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                            	<div class="form-group" style="border-left:dotted 2px #000; padding-left:20px;">
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
                                                                            <div class="col-sm-4">&nbsp;</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" style="background-color:#fff;"> <!--C6D0D9-->
                                                                        <div class="form-group">
                                                                            <div class="col-sm-4">
                                                                            <label><?php echo $demand[0]->Name;?></label>
                                                                            </div>
                                                                            <div class="col-sm-4">
                                                                            {{ Form::label('Name', 'No Promotions') }}
                                                                            </div>
                                                                            <div class="col-sm-4">&nbsp;</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" style="background-color:#fff;">
                                                                            <div class="form-group">
                                                                            <div class="col-sm-4" style="margin-top:12px;">
                                                                            {{ Form::label('Name', 'STATUS', array('style' => 'font-weight:bold;')) }}
                                                                            </div>
                                                                            <div class="col-sm-8">&nbsp;</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" style="background-color:#fff;">
                                                                        <div class="form-group">
                                                                            <div class="col-sm-4">
                                                                            <label><?php echo $status[0]->Name;?></label>
                                                                            </div>
                                                                            <div class="col-sm-8">&nbsp;</div>
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
                                                                            <div class="text-<?php if($data[0]->first_approver_status=="1" || $data[0]->second_approver_status=="1" || $data[0]->approve_by_admin=="1" || $data[0]->vc_status=="1"){?>success<?php }else if($data[0]->is_cancel=="1" || $data[0]->user_cancel=="1"){?>danger<?php }?>">
                                                                                <i class="fa fa-circle"></i>
                                                                            </div>
                                                                            </div>
                                                                            <div class="col-sm-2 text-center" style="border:dotted 1px #000;">
                                                                            <div class="text-<?php if($data[0]->is_fulfil=="1"){?>warning<?php }?>">
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
                                                                                {{ Form::label('UserComments', 'COMPANY NAME') }}
                                                                                {!!Form::text('UserComments',$data[0]->CompanyName,array('class'=>'form-control','id'=>'UserComments', 'size'=>'30x2', 'disabled'))!!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <div class="col-sm-6">
                                                                                {{ Form::label('UserComments', 'LOCATION') }}
                                                                                {{ Form::select('locationtype_id', $locationtype, $data[0]->locationtype_id, array('placeholder' => 'Please select ...', 'class'=>'form-control', 'disabled')) }}
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                {{ Form::label('UserComments', 'DELIVERY') }}
                                                                                {{ Form::select('deliverytype_id', $deliverytype, $data[0]->deliverytype_id, array('placeholder' => 'Please select ...', 'class'=>'form-control', 'disabled')) }}
                                                                            </div>
                                                                        </div>
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
                                                            <div class="col-sm-12  text-right">
                                                                <?php /*?>{{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}&nbsp; <?php */?>{{ HTML::link('/adminpanel/requests', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}
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