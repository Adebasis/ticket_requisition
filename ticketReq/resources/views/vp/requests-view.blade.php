@section('title')
    Request Details
@stop

@include('vp.includes.top')

<section class="vbox">
    
    @include('vp.includes.header')
    
    <section>
        <section class="hbox stretch">
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
                                            	
                                                {!!Form::open(array('action'=>'HomeController@Post_RequestPageApprover','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                                    
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
                                                                            {{ Form::select('dept_id', $department, $data[0]->dept_id, array('placeholder' => 'Please select ...', 'class'=>'form-control','id'=>'requesttype_id', 'readonly', 'disabled')) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <?php
																		$game = DB::table("game")->select('OriginalGameDate','team_id')->where('id', $data[0]->game_id)->get();
																		$team_id = $game[0]->team_id;
																		$team = DB::table("team")->select('Name')->where('id', $team_id)->get();
																		?>
                                                                        <div class="col-sm-6">
                                                                            {{ Form::label('game', 'Game') }}
                                                                            {!!Form::text('game',$team[0]->Name." - ".date('m/d/Y h:i A', strtotime($game[0]->OriginalGameDate)),array('class'=>'form-control','id'=>'Comp', 'disabled'))!!}
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            {{ Form::label('Comp', 'COMP') }}
                                                                            {!!Form::text('Comp',$data[0]->Comp,array('class'=>'form-control','id'=>'Comp', 'disabled'))!!}
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            {{ Form::label('Purchased', 'PURCHASED') }}
                                                                            {!!Form::text('Purchased',$data[0]->Purchased,array('class'=>'form-control','id'=>'Purchased', 'disabled'))!!}
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
                                                                            {!!Form::textarea('Instructions',$data[0]->Instructions,array('class'=>'form-control','size'=>'30x2','onkeyup'=>'countChar(this, "Instructions_char");', 'disabled'))!!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <style>textarea {   resize: none; }</style>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-12">
                                                                            {{ Form::label('UserComments', 'BUSINESS PURPOSE') }}&nbsp;(<span id="UserComments_char">{{ strlen($data[0]->UserComments) }}</span> / 250)
                                                                            {!!Form::textarea('UserComments',$data[0]->UserComments,array('class'=>'form-control','id'=>'UserComments', 'size'=>'30x2','onkeyup'=>'countChar(this, "UserComments_char");', 'disabled'))!!}
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
                                                                            {{ Form::label('Name', 'N/A') }}
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
                                                                            {{ Form::label('Name', 'In Progress') }}
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
                                                                    <?php
																	$is_approve = $data[0]->first_approver_status;
																	$is_fulfil = $data[0]->is_fulfil;
																	?>
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <div class="col-sm-3" style="background-color:#000;">
                                                                            </div>
                                                                            <div class="col-sm-2 text-center" style="border:dotted 1px #000;">
                                                                            <div class="text-<?php if($is_approve=="1"){?>success<?php }else if($is_approve=="4"){?>danger<?php }?>">
                                                                                <i class="fa fa-circle"></i>
                                                                            </div>
                                                                            </div>
                                                                            <div class="col-sm-2 text-center" style="border:dotted 1px #000;">
                                                                            <div class="text-<?php if($is_fulfil=="1"){?>warning<?php }?>">
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
                                                                                {!!Form::text('CompanyName',$data[0]->CompanyName,array('class'=>'form-control','size'=>'30x2', 'disabled'))!!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <div class="col-sm-6">
                                                                                {{ Form::label('locationtype_id', 'LOCATION') }}
                                                                                {{ Form::select('locationtype_id', $locationtype, $data[0]->locationtype_id, array('placeholder' => 'Please select ...', 'class'=>'form-control', 'disabled')) }}
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                {{ Form::label('deliverytype_id', 'DELIVERY') }}
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
                                                          <div class="col-lg-offset-2 col-sm-10">&nbsp;</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-2">
                                                                
                                                            </div>
                                                            <div class="col-sm-9 text-center">
                                                            <!--<h2>Second Level of Approver has not been assigned to this department !!!</h2>-->
                                                            </div>
                                                            <div class="col-sm-1 text-right">
                                                                {{ HTML::link('/vice-president/history', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}
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

@include('includes.admin_footer')