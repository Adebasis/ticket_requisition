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
                                        	                                            
                                            <header class="panel-heading font-bold">GAME DETAILS</header>
                                            <div class="panel-body">
                                            
                                                {!!Form::open(array('action'=>'AdminController@adminEmployeeTypeEdit','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                                    
                                                    {!!Form::hidden('pk_id',$data[0]->id)!!}
                                                    
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                            	<div class="row">
                                                                    <div class="form-group">
                                                                        
                                                                        <div class="col-sm-6">
                                                                            {{ Form::label('Name', 'REQUESTED BY') }}
                                                                            {!!Form::text('Name', null,array('class'=>'form-control', 'disabled'))!!}
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                        	{{ Form::label('requesttype_id', 'REQUEST TYPE') }}
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-6">
                                                                            {{ Form::label('Comp', 'COMP') }}
                                                                            {!!Form::text('Comp',null,array('class'=>'form-control','id'=>'Comp', ''))!!}
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                        	{{ Form::label('Purchased', 'PURCHASED') }}
                                                                            {!!Form::text('Purchased',null,array('class'=>'form-control','id'=>'Purchased', ''))!!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-6">
                                                                            {{ Form::label('RecipientFirstName', 'FIRST NAME') }}
                                                                            {!!Form::text('RecipientFirstName',null,array('class'=>'form-control','id'=>'RecipientFirstName', ''))!!}
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                        	{{ Form::label('RecipientLastName', 'LAST NAME') }}
                                                                            {!!Form::text('RecipientLastName',null,array('class'=>'form-control','id'=>'RecipientLastName', ''))!!}
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
                                                                            {{ Form::label('Instructions', 'INSTRUCTIONS FOR TICKET OFFICE') }}&nbsp;(<span id="Instructions_char">0</span> / 250)
                                                                            {!!Form::textarea('Instructions',null,array('class'=>'form-control','size'=>'30x2','onkeyup'=>'countChar(this, "Instructions_char");'))!!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <style>textarea {   resize: none; }</style>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-12">
                                                                            {{ Form::label('UserComments', 'BUSINESS PURPOSE') }}&nbsp;(<span id="UserComments_char">0</span> / 250)
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
															$team = DB::table('team')->where('id', $data[0]->team_id)->get();
															$team_name = $team[0]->Name;
															?>
                                                            <div class="col-sm-6">
                                                            	<div class="form-group" style="border-left:dotted 2px #000; padding-left:20px;">
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <div class="col-sm-4" style="background-color:#333; color:#fff;">
                                                                            {{ Form::label('Name', date('m/d/Y h:i:s A', strtotime($data[0]->OriginalGameDate))) }}
                                                                            </div>
                                                                            <div class="col-sm-4" style="background-color:#333; color:#fff;">
                                                                            {{ Form::label('Name', '&nbsp;') }}
                                                                            </div>
                                                                            <div class="col-sm-4" style="background-color:#333; color:#fff;">
                                                                            {{ Form::label('Name', $team_name) }}
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
                                                                                {!!Form::text('CompanyName',null,array('class'=>'form-control','size'=>'30x2'))!!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <div class="col-sm-6">
                                                                                {{ Form::label('locationtype_id', 'LOCATION') }}
                                                                                
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                {{ Form::label('deliverytype_id', 'DELIVERY') }}
                                                                                
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
                                                                {{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}&nbsp; {{ HTML::link('/game/calender', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}
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