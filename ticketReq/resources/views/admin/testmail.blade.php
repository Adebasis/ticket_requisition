@include('admin.includes.top')

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
                                	
                                	<header class="panel-heading font-bold">SMTP Settings / Test Mail</header>
                                    <div class="panel-body">
                                        
                                        <?php
										$smtp = DB::table('smtp')->where('id', 1)->get();	
										?>
                                        
                                        @if(Session::has('error'))
                                        <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <i class="fa fa-ok-sign"></i><strong>Error! &nbsp;</strong><?php echo Session::get('error');?></div>
                                        @endif
                                        
                                        @if(Session::has('msg'))
                                        <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <i class="fa fa-ok-sign"></i><strong>Success! &nbsp;</strong>Message has been sent</div>
                                        @endif
                                        
                                        {!!Form::open(array('action'=>'MailController@admin_post_mail_testings','method'=>'post'))!!}
                                        	
                                            <div class="form-group">
                                                <div class="col-sm-12">&nbsp;</div>
                                                <div class="col-sm-6">
                                                    {{ Form::label('host', 'Host') }}
                                                    {!!Form::text('host', $smtp[0]->host, array('class'=>'form-control','id'=>'host','maxlength'=>50, 'required'))!!}
                                            	</div>
                                                <div class="col-sm-6">
                                                    {{ Form::label('email', 'Email') }}
                                                    {!!Form::email('email', $smtp[0]->email, array('class'=>'form-control','maxlength'=>50, 'required'))!!}
                                            	</div>
                                                <div class="col-sm-12">&nbsp;</div>
                                                <div class="col-sm-6">
                                                    {{ Form::label('password', 'Password') }}
                                                    <input name="password" type="text" class="form-control" value="<?php //echo base64_decode($smtp[0]->password);?>" />
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
                                            	<div class="col-sm-12">
                                                    {{ Form::label('to_email', 'To') }}
                                                    {!!Form::text('to_email', null, array('class'=>'form-control','id'=>'to_email', 'required'))!!}
                                            	</div>
                                                <div class="col-sm-12">
                                                    {{ Form::label('subject', 'Subject') }}
                                                    {!!Form::text('subject', null, array('class'=>'form-control','id'=>'host', 'required'))!!}
                                            	</div>
                                                <div class="col-sm-12">
                                                    {{ Form::label('message', 'Message') }}
                                                    <textarea name="message" class="form-control" required></textarea>
                                            	</div>
                                            </div>
                                            <div class="form-group">&nbsp;</div>
                                            <div class="form-group">&nbsp;</div>
                                            <div class="form-group">
                                            	<div class="col-sm-6">
                                            		{{Form::submit('SEND',array('class'=>'btn btn-success btn-sm'))}}
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
                            
                            <div class="col-sm-6" style="display:none;">
                                <section class="panel panel-default">
                                	
                                	<header class="panel-heading font-bold">[Internal] SMTP Settings / Test Mail</header>
                                    <div class="panel-body">
                                        
                                        <?php
										$smtp = DB::table('smtp')->where('id', 2)->get();
										?>
                                        
                                        @if(Session::has('int_error'))
                                        <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <i class="fa fa-ok-sign"></i><strong>Error! &nbsp;</strong><?php echo Session::get('int_error');?></div>
                                        @endif
                                        
                                        @if(Session::has('int_msg'))
                                        <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <i class="fa fa-ok-sign"></i><strong>Success! &nbsp;</strong>Message has been sent</div>
                                        @endif
                                        
                                        {!!Form::open(array('action'=>'MailController@admin_post_mail_testings_internal','method'=>'post'))!!}
                                        
                                            <div class="form-group">
                                            	<div class="col-sm-12">
                                                <label><h3>Internal Server :: <u>http://ecomps.nymets.com/</u></h3></label>
                                                </div>
                                                <div class="col-sm-12">&nbsp;</div>
                                                <div class="col-sm-6">
                                                    {{ Form::label('host', 'Host') }}
                                                    {!!Form::text('host', $smtp[0]->host, array('class'=>'form-control','id'=>'host','maxlength'=>50, 'required'))!!}
                                            	</div>
                                                <div class="col-sm-6">
                                                    {{ Form::label('email', 'Email') }}
                                                    {!!Form::email('email', $smtp[0]->email, array('class'=>'form-control','maxlength'=>50, 'required'))!!}
                                            	</div>
                                                <div class="col-sm-12">&nbsp;</div>
                                                <div class="col-sm-6">
                                                    {{ Form::label('password', 'Password') }}
                                                    <input name="password" type="text" class="form-control" value="<?php //echo base64_decode($smtp[0]->password);?>" />
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
                                            <div class="form-group">&nbsp;</div>
                                            <div class="form-group">
                                            	<div class="col-sm-12">
                                                    {{ Form::label('to_email', 'To') }}
                                                    {!!Form::text('to_email', null, array('class'=>'form-control','id'=>'to_email', 'required'))!!}
                                            	</div>
                                                <div class="col-sm-12">
                                                    {{ Form::label('subject', 'Subject') }}
                                                    {!!Form::text('subject', null, array('class'=>'form-control','id'=>'host', 'required'))!!}
                                            	</div>
                                                <div class="col-sm-12">
                                                    {{ Form::label('message', 'Message') }}
                                                    <textarea name="message" class="form-control" required></textarea>
                                            	</div>
                                            </div>
                                            <div class="form-group">&nbsp;</div>
                                            <div class="form-group">
                                            	<div class="col-sm-6">
                                            		{{Form::submit('SEND',array('class'=>'btn btn-success btn-sm'))}}
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