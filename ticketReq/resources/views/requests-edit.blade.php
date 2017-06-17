@include('includes.top')

<script>
function Validation(){
	if($('#Name').val().trim() == ""){
		$('#Name').focus();
		return false;
	}
}
</script>

<section class="vbox">
    
    @include('includes.header')
    
    <section>
        <section class="hbox stretch">
            <!-- .aside -->
            <?php /*?>@include('admin.includes.left')<?php */?>
            <!-- /.aside -->
            <section id="content">
                <section class="hbox stretch">
                    <section>
                        <section class="vbox">
                            <section class="scrollable padder">              
                                <section class="row m-b-md"></section>
                                <div class="row">
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-10">
                                        <section class="panel panel-default">
                                        	                                            
                                            <header class="panel-heading font-bold">REQUEST DETAILS</header>
                                            <div class="panel-body">
                                            	
                                                <?php
												$approver_level = Session::get('ecomps_user_approver_level');
												
												if($approver_level == "0"){
                                                ?>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-sm-12 text-center">
                                                            <h1>This request is not requestable for the current user.</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group">
                                                      <div class="col-lg-offset-2 col-lg-10">&nbsp;</div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12 text-center">
                                                            {{ HTML::link('/history', 'BACK TO HISTORY', array('class' => 'btn btn-danger btn-sm'))}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php }?>
												<?php if($approver_level == "second" && $data[0]->approval_status == "0"){?>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-sm-12 text-center">
                                                            <h1>This request is not approved by first level of Approver.</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group">
                                                      <div class="col-lg-offset-2 col-lg-10">&nbsp;</div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12 text-center">
                                                            {{ HTML::link('/history', 'BACK TO HISTORY', array('class' => 'btn btn-danger btn-sm'))}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php }else if(($approver_level == "first" && $data[0]->approval_status == "1") || ($approver_level == "second" && $data[0]->approval_status == "2") || ($approver_level == "third" && $data[0]->approval_status == "3")){?>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-sm-12 text-center">
                                                            <h1>This request is already approved by you.</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group">
                                                      <div class="col-lg-offset-2 col-lg-10">&nbsp;</div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12 text-center">
                                                            {{ HTML::link('/history', 'BACK TO HISTORY', array('class' => 'btn btn-danger btn-sm'))}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php }else if($approver_level == "first" || $approver_level == "second" || $approver_level == "third"){?>
                                                    
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
                                                                        	{{ Form::label('dept_id', 'DEPARTMENT') }}
                                                                            {{ Form::select('dept_id', $department, $data[0]->dept_id, array('placeholder' => 'Please select ...', 'class'=>'form-control','id'=>'requesttype_id', 'readonly', 'required')) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-6">
                                                                            {{ Form::label('Comp', 'COMP') }}
                                                                            {!!Form::text('Comp',$data[0]->Comp,array('class'=>'form-control','id'=>'Comp', 'autofocus'))!!}
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                        	{{ Form::label('Purchased', 'PURCHASED') }}
                                                                            {!!Form::text('Purchased',$data[0]->Purchased,array('class'=>'form-control','id'=>'Purchased', ''))!!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-6">
                                                                            {{ Form::label('RecipientFirstName', 'FIRST NAME') }}
                                                                            {!!Form::text('RecipientFirstName',$data[0]->RecipientFirstName,array('class'=>'form-control','id'=>'RecipientFirstName', ''))!!}
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                        	{{ Form::label('RecipientLastName', 'LAST NAME') }}
                                                                            {!!Form::text('RecipientLastName',$data[0]->RecipientLastName,array('class'=>'form-control','id'=>'RecipientLastName', ''))!!}
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
                                                                            {!!Form::textarea('Instructions',$data[0]->Instructions,array('class'=>'form-control','size'=>'30x2','onkeyup'=>'countChar(this, "Instructions_char");'))!!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <style>textarea {   resize: none; }</style>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-12">
                                                                            {{ Form::label('UserComments', 'BUSINESS PURPOSE') }}&nbsp;(<span id="UserComments_char">{{ strlen($data[0]->UserComments) }}</span> / 250)
                                                                            {!!Form::textarea('UserComments',$data[0]->UserComments,array('class'=>'form-control','id'=>'UserComments', 'size'=>'30x2','onkeyup'=>'countChar(this, "UserComments_char");'))!!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                            	<div class="form-group" style="border-left:dotted 2px #000; padding-left:20px;">
                                                                    <?php
																	$game = DB::table("game")->select('OriginalGameDate','team_id')->where('id', $data[0]->game_id)->get();
																	$team_id = $game[0]->team_id;
																	$team = DB::table("team")->select('Name')->where('id', $team_id)->get();
																	?>
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
                                                                            {{ Form::label('Name', 'Very High Demand') }}
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
                                                                            {{ Form::label('Name', 'Closed') }}
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
                                                                            <div class="text-success">
                                                                                <i class="fa fa-circle"></i>
                                                                            </div>
                                                                            </div>
                                                                            <div class="col-sm-2 text-center" style="border:dotted 1px #000;">
                                                                            <div class="text-muted">
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
                                                                                {{ Form::label('CompanyName', 'COMPANY NAME') }}
                                                                                {!!Form::text('CompanyName',$data[0]->CompanyName,array('class'=>'form-control','size'=>'30x2'))!!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <div class="col-sm-6">
                                                                                {{ Form::label('locationtype_id', 'LOCATION') }}
                                                                                {{ Form::select('locationtype_id', $locationtype, $data[0]->locationtype_id, array('placeholder' => 'Please select ...', 'class'=>'form-control', 'required')) }}
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                {{ Form::label('deliverytype_id', 'DELIVERY') }}
                                                                                {{ Form::select('deliverytype_id', $deliverytype, $data[0]->deliverytype_id, array('placeholder' => 'Please select ...', 'class'=>'form-control', 'required')) }}
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
                                                            <div class="col-sm-2">
                                                                {{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}&nbsp; {{ HTML::link('/history', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}
                                                            </div>
                                                            <div class="col-sm-9 text-center">
                                                            <!--This game is not requestable for the current user-->
                                                            </div>
                                                            <div class="col-sm-1 text-right">
                                                                <?php /*?>{{ HTML::link('/request/'.$data[0]->id.'/delete', 'Delete', array('class' => 'btn btn-danger btn-sm'))}}<?php */?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                {!!Form::close()!!}
                                            	
                                                <?php }?>
                                                
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