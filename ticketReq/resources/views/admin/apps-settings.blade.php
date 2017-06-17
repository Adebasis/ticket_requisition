@include('admin.includes.top')

<script>
function Validation(){
	var val = $("#image_file").val();
	if(val != ""){
		if (!val.match(/(?:gif|jpg|png|bmp)$/)) {
			alert("This is not an image file !");
			$("#image_file").val('');
			return false;
		}
	}
}
</script>

<section class="vbox">
    
    @include('admin.includes.header')
    
    <section class="hbox stretch">
        <!-- .aside -->
        @include('admin.includes.left')
        <!-- /.aside -->
        <section id="content">
            <section class="hbox stretch">
            
                <section class="vbox">
                    <section class="scrollable padder">              
                        <section class="row m-b-md"></section>
                        <div class="row">
                            <div class="col-sm-6">
                                <section class="panel panel-default">
                                	
                                	<header class="panel-heading font-bold">Apps Settings</header>
                                    <div class="panel-body">
                                        
                                        <?php
										$appsettings = DB::table('appsettings')->where('id', 1)->get();
										$timezone = DB::table('appsettings')->where('id', 3)->get();
										$sitemode = DB::table('appsettings')->where('id', 5)->get();
										?>
                                        
                                        @if(Session::has('msg'))
                                        <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <i class="fa fa-ok-sign"></i><strong>Success!&nbsp;</strong><?php echo Session::get('msg');?></div>
                                        @endif
                                        
                                        {!!Form::open(array('action'=>'AdminController@admin_post_appsettings','method'=>'post','files'=>true,'onsubmit'=>'return Validation();'))!!}
                                        
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    {{ Form::label('timeout_time', 'Timeout Time (in minutes, if 0 then no limit)') }}
                                                    {!!Form::number('timeout_time', $appsettings[0]->Value, array('class'=>'form-control','maxlength'=>3, 'required', 'style'=>'width:20%'))!!}
                                            	</div>
                                                
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">&nbsp;</div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    {{ Form::label('timezone', 'Maintenance Mode') }}
                                                    <select name="sitemode" class="form-control">
                                                    	<option value="0" <?php if($sitemode[0]->Value=="0"){?> selected="selected" <?php }?>>OFF</option>
                                                        <option value="1" <?php if($sitemode[0]->Value=="1"){?> selected="selected" <?php }?>>ON</option>
                                                    </select>
                                            	</div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">&nbsp;</div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    {{ Form::label('timezone', 'Set the Timezone') }}
                                                    <select name="timezone" class="form-control">
                                                    	<?php
														$tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
														foreach($tzlist as $tzone){
														?>
                                                    	<option value="<?php echo $tzone;?>" <?php if($tzone == $timezone[0]->Value){?> selected="selected" <?php }?>><?php echo $tzone;?></option>
                                                        <?php }?>
                                                    </select>
                                            	</div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">&nbsp;</div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                	<label><b>As per Timezone [<?php echo $timezone[0]->Value;?>]</b></label>
                                            	</div>                                                
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                    <?php
													$timestamp =strtotime("now");
													$dt = new DateTime("@$timestamp");
													$destinationTimezone = new DateTimeZone(Config::get('app.timezone'));
													$dt->setTimeZone($destinationTimezone);
													echo $CreateDate = $dt->format('l, F d, Y, H:i:s A'); // Friday, May 12, 2017, 10:25:43 AM
													?>
													</label>
                                            	</div>                                                
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">&nbsp;</div>
                                            </div>
                                            <?php
											$appsettings = DB::table('appsettings')->where('id', 2)->get();
											?>
                                            <div class="form-group">
                                                <div class="col-sm-6">
                                                    {{ Form::label('timeout_time', 'Logo') }}
                                                    {!! Form::file('image_file', array('id'=>'image_file','class' => 'form-control', 'accept'=>'image/*')) !!}
                                            	</div>
                                                <div class="col-sm-6">
                                                    <img src="{{ url('/') }}/public/admin_assets/images/<?php echo $appsettings[0]->Value;?>" class="m-r-lg" alt="scale" style="width:30%; min-height:inherit; height:95px !important;">
                                            	</div>
                                            </div>
                                            <div class="form-group">&nbsp;</div>
                                            <div class="form-group">
                                            	<div class="col-sm-6">
                                            		{{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}
                                            	</div>
                                                <div class="col-sm-6">
                                                	
                                            	</div>
                                            </div>
                                            <div class="form-group">
                                            	<div class="col-sm-6">&nbsp;</div>
                                                <div class="col-sm-6" id="lblmsg">&nbsp;</div>
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
        	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
        </section>
    </section>

@include('admin.includes.admin_footer')