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
                                        	
                                            <header class="panel-heading font-bold">NEW GAME</header>
                                            <div class="panel-body">
                                            
                                                {!!Form::open(array('action'=>'AdminController@admin_post_game_entry','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                                    
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-8">
                                                            	<div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-3">
                                                                            {{ Form::label('EventCode', 'EVENT CODE') }}
                                                                            {!!Form::text('EventCode', $eventcode,array('class'=>'form-control', 'required', 'autofocus'))!!}
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                        	{{ Form::label('GameNumber', 'GAME NUMBER') }}
                                                                            {!!Form::number('GameNumber', 0, array('class'=>'form-control', 'required'))!!}
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                        	
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">&nbsp;</div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        
                                                                        <div class="col-sm-3">
                                                                            {{ Form::label('OriginalGameDate', 'Original Game Date') }}
                                                                            <div class="controls input-append date OriginalGameDate" data-date-format="mm/dd/yyyy, HH:ii p">
                                                                                <input name="OriginalGameDate" id="OriginalGameDate" size="16" type="text" class="form-control" readonly>
                                                                                <span class="add-on"><i class="icon-remove"></i></span>
                                                                                <span class="add-on"><i class="icon-th"></i></span>
                                                                        	</div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                        	{{ Form::label('ScheduledGameDate', 'Scheduled Game Date') }}
                                                                            <div class="controls input-append date ScheduledGameDate" data-date-format="mm/dd/yyyy, HH:ii p">
                                                                                <input name="ScheduledGameDate" size="16" type="text" value="" class="form-control" readonly>
                                                                                <span class="add-on"><i class="icon-remove"></i></span>
                                                                                <span class="add-on"><i class="icon-th"></i></span>
                                                                        	</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-6">
                                                                            {{ Form::label('team_id', 'Opponent Team') }}
                                                                            {{ Form::select('team_id', $teams, 0, array('placeholder' => 'Please select ...', 'class'=>'form-control', 'required')) }}
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                        	{{ Form::label('demandtype_id', 'Demand type') }}
                                                                            {{ Form::select('demandtype_id', $demandtype, 0, array('placeholder' => 'Please select ...', 'class'=>'form-control', 'required')) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">&nbsp;</div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-6">
                                                                            {{ Form::label('pricingtype_id', 'Price Type') }}
                                                                            {{ Form::select('pricingtype_id', $pricingtype, 0, array('placeholder' => 'Please select ...', 'class'=>'form-control', 'required')) }}
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                        	{{ Form::label('requeststate_id', 'Game Request State') }}
                                                                            {{ Form::select('requeststate_id', $gamerequeststate, 0, array('placeholder' => 'Please select ...', 'class'=>'form-control', 'required')) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">&nbsp;</div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-3">
                                                                        	{{ Form::label('gamestate_id', 'Game State') }}
                                                                            {{ Form::select('gamestate_id', $gamestate, 0, array('placeholder' => 'Please select ...', 'class'=>'form-control', 'required')) }}
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            {{ Form::label('AllowCompPurchase', 'Allow Comp Purchase') }}
                                                                            {{ Form::select('AllowCompPurchase', array('0' => 'No', '1' => 'Yes'), null, array('class'=>'form-control') ) }}
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                        	{{ Form::label('AllowPersonalRequests', 'Allow Personal Requests') }}
                                                                            {{ Form::select('AllowPersonalRequests', array('0' => 'No', '1' => 'Yes'), null, array('class'=>'form-control') ) }}
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            {{ Form::label('AllowCompTransfer', 'Allow Comp Transfer') }}
                                                                            {{ Form::select('AllowCompTransfer', array('0' => 'No', '1' => 'Yes'), null, array('class'=>'form-control') ) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">&nbsp;</div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-3">
                                                                            {{ Form::label('RequestDeadline', 'Request Deadline') }}
                                                                            <div class="controls input-append date RequestDeadline" data-date-format="mm/dd/yyyy, HH:ii p">
                                                                                <input name="RequestDeadline" size="16" type="text" value="" class="form-control" readonly>
                                                                                <span class="add-on"><i class="icon-remove"></i></span>
                                                                                <span class="add-on"><i class="icon-th"></i></span>
                                                                        	</div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                        	{{ Form::label('allocationpooltype_id', 'Allocation Pool Type') }}
                                                                            {{ Form::select('allocationpooltype_id', $allocationpooltype, 0, array('class'=>'form-control')) }}
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                        	{{ Form::label('IsSellout', 'Is Sellout ?') }}
                                                                            {{ Form::select('IsSellout', array('0' => 'No', '1' => 'Yes'), null, array('class'=>'form-control') ) }}
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

