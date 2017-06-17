@include('admin.includes.top')

<script>
function Validation(){
	
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
                            
                            {!!Form::open(array('action'=>'AdminController@admin_post_settings','method'=>'post','onsubmit'=>'return Validation()'))!!}
                            
                            <div class="col-sm-6">
                                <section class="panel panel-default">
                                	
                                    @if(Session::has('msg'))
                                    <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <i class="fa fa-ok-sign"></i><strong>Success!&nbsp;</strong><?php echo Session::get('msg');?></div>
                                    @endif
                                    
                                	<header class="panel-heading font-bold">SMTP Settings<!-- [External]--></header>
                                    <div class="panel-body">
                                        
                                        <?php
										$smtp = DB::table('smtp')->where('id', 1)->get();
										?>
                                                                            
                                        <div class="form-group">
                                            
                                            <div class="col-sm-12">&nbsp;</div>
                                            <div class="col-sm-6">
                                                {{ Form::label('host', 'Host') }}
                                                {!!Form::text('host', $smtp[0]->host, array('class'=>'form-control','id'=>'host','maxlength'=>50, 'required'))!!}
                                            </div>
                                            <div class="col-sm-6">
                                                {{ Form::label('email', 'Email') }}
                                                {!!Form::email('email', $smtp[0]->email, array('class'=>'form-control','maxlength'=>100, 'required'))!!}
                                            </div>
                                            <div class="col-sm-12">&nbsp;</div>
                                            <div class="col-sm-6">
                                                {{ Form::label('password', 'Password') }}
                                                <input name="password" type="password" value="<?php echo base64_decode($smtp[0]->password);?>" class="form-control" />
                                            </div>
                                            <div class="col-sm-2">
                                                {{ Form::label('port', 'Port') }}
                                                {!!Form::number('port', $smtp[0]->port, array('class'=>'form-control','maxlength'=>10, 'required'))!!}
                                            </div>
                                            <div class="col-sm-4">
                                                {{ Form::label('from_name', 'From Name') }}
                                                {!!Form::text('from_name', $smtp[0]->from_name, array('class'=>'form-control','id'=>'from_name','maxlength'=>40, 'required'))!!}
                                            </div>
                                        </div>
                                        <script>
                                        function showPass(){
                                            if($('#lblpass').html() == "Show Password"){
                                                $('#lblpass').html("Hide Password");
                                                $('#txtpass').css("display", "block");
                                            }else{
                                                $('#lblpass').html("Show Password");
                                                $('#txtpass').css("display", "none");
                                            }
                                        }
                                        </script>
                                        <div class="form-group">
                                            <div class="col-sm-12 row">
                                                <div class="col-sm-6">
                                                    <label id="lblpass" style="cursor:pointer;" onclick="showPass();">Show Password.</label>
                                                    <span id="txtpass" style="display:none;">
                                                        <input type="text" class="form-control" value="<?php echo base64_decode($smtp[0]->password);?>" readonly="readonly" />
                                                    </span>
                                                </div>
                                                <div class="col-sm-6">&nbsp;</div>
                                            </div>
                                            <div class="col-sm-12 row">&nbsp;</div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">&nbsp;</div>
                                            <div class="col-sm-3">
                                                {{ Form::label('smtpauth', 'SMTP Auth') }}
                                                <select name="smtpauth" class="form-control">
                                                    <option value="false" <?php if($smtp[0]->smtpauth=="false"){?> selected="selected" <?php }?>>False</option>
                                                    <option value="true" <?php if($smtp[0]->smtpauth=="true"){?> selected="selected" <?php }?>>True</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <?php /*?>{{ Form::label('smtpsecure', 'SMTP Secure') }}
                                                <select name="smtpsecure" class="form-control">
                                                    <option value="false" <?php if($smtp[0]->smtpsecure=="false"){?> selected="selected" <?php }?>>False</option>
                                                    <option value="true" <?php if($smtp[0]->smtpsecure=="true"){?> selected="selected" <?php }?>>True</option>
                                                </select><?php */?>
                                            </div>
                                            <div class="col-sm-12">&nbsp;</div>
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
                                        <input type="hidden" id="siteurl" value="{{url('/')}}">
				                        <input type="hidden" id="csrf" value="{{ csrf_token() }}">
                                    
                                    </div>
                                </section>           
                            </div>
                            
                            <div class="col-sm-6" style="display:none;">
                                <section class="panel panel-default">
                                                                	                                    
                                	<header class="panel-heading font-bold">SMTP Settings [Internal]</header>
                                    <div class="panel-body">
                                        
                                        <?php
										$smtp = DB::table('smtp')->where('id', 2)->get();
										?>                       
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                            <label><h3>Internal Server :: <u>http://ecomps.nymets.com/</u></h3></label>
                                            </div>
                                            <div class="col-sm-12">&nbsp;</div>
                                            <div class="col-sm-6">
                                                {{ Form::label('host1', 'Host') }}
                                                {!!Form::text('host1', $smtp[0]->host, array('class'=>'form-control','id'=>'host','maxlength'=>50, 'required'))!!}
                                            </div>
                                            <div class="col-sm-6">
                                                {{ Form::label('email1', 'Email') }}
                                                {!!Form::email('email1', $smtp[0]->email, array('class'=>'form-control','maxlength'=>100, 'required'))!!}
                                            </div>
                                            <div class="col-sm-12">&nbsp;</div>
                                            <div class="col-sm-6">
                                                {{ Form::label('password1', 'Password') }}
                                                <input name="password1" type="password" value="<?php echo base64_decode($smtp[0]->password);?>" class="form-control" />
                                            </div>
                                            <div class="col-sm-2">
                                                {{ Form::label('port1', 'Port') }}
                                                {!!Form::number('port1', $smtp[0]->port, array('class'=>'form-control','maxlength'=>10, 'required'))!!}
                                            </div>
                                            <div class="col-sm-4">
                                                {{ Form::label('from_name1', 'From Name') }}
                                                {!!Form::text('from_name1', $smtp[0]->from_name, array('class'=>'form-control','id'=>'from_name','maxlength'=>40, 'required'))!!}
                                            </div>
                                        </div>
                                        <script>
                                        function showPass1(){
                                            if($('#lblpass1').html() == "Show Password"){
                                                $('#lblpass1').html("Hide Password");
                                                $('#txtpass1').css("display", "block");
                                            }else{
                                                $('#lblpass1').html("Show Password");
                                                $('#txtpass1').css("display", "none");
                                            }
                                        }
                                        </script>
                                        <div class="form-group">
                                            <div class="col-sm-12 row">
                                                <div class="col-sm-6">
                                                    <label id="lblpass1" style="cursor:pointer;" onclick="showPass1();">Show Password.</label>
                                                    <span id="txtpass1" style="display:none;">
                                                        <input type="text" class="form-control" value="<?php echo base64_decode($smtp[0]->password);?>" readonly="readonly" />
                                                    </span>
                                                </div>
                                                <div class="col-sm-6">&nbsp;</div>
                                            </div>
                                            <div class="col-sm-12 row">&nbsp;</div>
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
                                            <div class="col-sm-6">&nbsp;</div>
                                        </div>
                                                                                
                                    </div>
                                </section>           
                            </div>
                            
                            {!!Form::close()!!}
                            
                        </div>
                    
                    	<div class="row"><div>&nbsp;</div></div>
                    
                    </section>
                </section>
            
            </section>
        	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
        </section>
    </section>

@include('admin.includes.admin_footer')