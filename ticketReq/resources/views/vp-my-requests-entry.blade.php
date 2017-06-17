@section('title')
    New Request
@stop

@include('includes.top')

<script>
function Validation(){
	if($('#Comp').val() == "0" && $('#Purchased').val() == "0"){
		alert("Both COMP LEVEL or PURCHASED should not be 0 (zero).");
		$('#Comp').focus();
		return false;
	}
	$('#btnSave').attr("disabled", "true");
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
                                        	
                                            <header class="panel-heading font-bold">NEW REQUEST</header>
                                            <div class="panel-body">
                                            
                                                {!!Form::open(array('action'=>'VPController@post_VP_NewRequest','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                                    
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                            	<div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-6">
                                                                            {{ Form::label('Name', 'REQUESTED BY') }}
                                                                            {!!Form::text('Name', Session::get('ecomps_user_name') ,array('class'=>'form-control','id'=>'Name', 'disabled'))!!}
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                        	{{ Form::label('Name', 'DEPARTMENT') }}
                                                                            {{ Form::select('dept_id', $department, 0, array('class'=>'form-control','id'=>'requesttype_id', '', 'required')) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">&nbsp;</div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-6">
                                                                        	{{ Form::label('game_id', 'GAME') }}
                                                                            <select class="form-control" name="game_id">
                                                                            <?php
																			$allgames = DB::table('game')->where('id', $game_id)->get();
																			foreach ($allgames as $index=>$tmpgame){
																				
																				$game_id = $tmpgame->id;
																				$team_id = $tmpgame->team_id;
																				$team_name = getDataFromTable("team","Name","id", $team_id);
																				$OriginalGameDate = date('m/d/Y h:i A', strtotime($tmpgame->OriginalGameDate));
																				?>
                                                                                <option value="<?php echo $tmpgame->id;?>"><?php echo $team_name;?> - <?php echo $OriginalGameDate;?></option>
                                                                                <?php
																			}
																			?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            {{ Form::label('Comp', 'COMP LEVEL') }}
                                                                            {!!Form::number('Comp',0,array('class'=>'form-control','id'=>'Comp', 'required', 'autofocus','min'=>'0'))!!}
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                        	{{ Form::label('Purchased', 'PURCHASED') }}
                                                                            {!!Form::number('Purchased',0,array('class'=>'form-control','id'=>'Purchased', 'required','min'=>'0'))!!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">&nbsp;</div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-6">
                                                                            {{ Form::label('RecipientFirstName', 'FIRST NAME') }}
                                                                            {!!Form::text('RecipientFirstName',null,array('class'=>'form-control','id'=>'RecipientFirstName', 'required'))!!}
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                        	{{ Form::label('RecipientLastName', 'LAST NAME') }}
                                                                            {!!Form::text('RecipientLastName',null,array('class'=>'form-control','id'=>'RecipientLastName', 'required'))!!}
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
                                                                <div class="row">&nbsp;</div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-12">
                                                                            {{ Form::label('Instructions', 'INSTRUCTIONS FOR TICKET OFFICE') }}&nbsp;(<span id="Instructions_char">0</span> / 250)
                                                                            {!!Form::textarea('Instructions',null,array('class'=>'form-control','id'=>'Instructions', 'size'=>'30x3','onkeyup'=>'countChar(this, "Instructions_char");'))!!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <style>textarea {   resize: none; }</style>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-12">
                                                                            {{ Form::label('UserComments', 'BUSINESS PURPOSE') }}&nbsp;(<span id="UserComments_char">0</span> / 250)
                                                                            {!!Form::textarea('UserComments',null,array('class'=>'form-control','id'=>'UserComments', 'size'=>'30x3','onkeyup'=>'countChar(this, "UserComments_char");'))!!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                            	<div class="form-group" style="border-left:dotted 2px #000; padding-left:20px;">
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <div class="col-sm-4" style="background-color:#333; color:#fff;">
                                                                            {{ Form::label('Name', date('m/d/Y h:i:s A')) }}
                                                                            </div>
                                                                            <div class="col-sm-4" style="background-color:#333; color:#fff;">
                                                                            {{ Form::label('Name', '&nbsp;') }}
                                                                            </div>
                                                                            <div class="col-sm-4" style="background-color:#333; color:#fff;">
                                                                            {{ Form::label('Name', '&nbsp;') }}
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
                                                                            {{ Form::label('Name', '-') }}
                                                                            </div>
                                                                            <div class="col-sm-4">
                                                                            {{ Form::label('Name', '-') }}
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
                                                                            {{ Form::label('Name', '-') }}
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
                                                                            <div class="text-muted">
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
                                                                                {!!Form::text('CompanyName',null,array('class'=>'form-control','id'=>'CompanyName', 'required'))!!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <div class="col-sm-6">
                                                                                {{ Form::label('locationtype_id', 'LOCATION') }}
                                                                                {{ Form::select('locationtype_id', $locationtype, 0, array('placeholder' => 'Please select ...', 'class'=>'form-control', 'required')) }}
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                {{ Form::label('deliverytype_id', 'DELIVERY') }}
                                                                                {{ Form::select('deliverytype_id', $deliverytype, 0, array('placeholder' => 'Please select ...', 'class'=>'form-control', 'required')) }}
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
                                                            <div class="col-sm-12  text-left">
                                                                {{Form::submit('Submit',array('class'=>'btn btn-success btn-sm', 'id'=> 'btnSave'))}}&nbsp; {{ HTML::link('/vp-approve/my-requests', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}&nbsp;
                                                                @if(Session::has('msg'))
                                                                <span style="color:#090;"><strong>Request has been sent for approval.</strong></span>
                                                                @endif
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