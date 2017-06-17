@section('title')
    My Profile
@stop

@include('includes.top')

<section class="vbox">
    
    @include('includes.header')
    
    <section class="hbox stretch">
        
        <section id="content">
            <section class="hbox stretch">
            
                <section class="vbox">
                    <section class="scrollable padder">              
                        <section class="row m-b-md"></section>
                        
                        <div class="row">
                            <div class="col-sm-3">&nbsp;</div>
                            <div class="col-sm-6">
                                <section class="panel panel-default">
                                	
                                	<header class="panel-heading font-bold">My Profile</header>
                                    <div class="panel-body">
                                        
                                        <?php
										$ecomps_admin_id = Session::get('ecomps_user_id');
										$data = DB::table('useraccount')->where('id', $ecomps_admin_id)->get();
										$name = $data[0]->FirstName.' '.$data[0]->LastName;
										$res_department = DB::table('department')->where('id', $data[0]->dept_id)->get();
										$department = "";
										if(count($res_department) > 0){
											$department = $res_department[0]->Name;
										}
										?>
                                        
                                        @if(Session::has('msg'))
                                        <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <i class="fa fa-ok-sign"></i><strong>Success!&nbsp;</strong><?php echo Session::get('msg');?></div>
                                        @endif
                                        
                                        {!!Form::open(array('action'=>'AdminController@admin_post_settings','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                        
                                            <div class="form-group">
                                            	<div class="row">
                                                    <div class="col-sm-6">
                                                        {{ Form::label('host', 'First Name') }}
                                                        <input type="text" class="form-control" value="<?php echo $name;?>" readonly="readonly" />
                                                    </div>
                                                    <div class="col-sm-6">&nbsp;</div>
                                            	</div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        {{ Form::label('host', 'Email Address') }}
                                                        <input type="text" class="form-control" value="<?php echo $data[0]->EmailAddress;?>" readonly="readonly" />
                                                    </div>
                                                    <div class="col-sm-6">&nbsp;</div>
                                            	</div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        {{ Form::label('host', 'Department') }}
                                                        <input type="text" class="form-control" value="<?php echo $department;?>" readonly="readonly" />
                                                    </div>
                                                    <div class="col-sm-6">&nbsp;</div>
                                            	</div>
                                            </div>
                                            <div class="form-group">&nbsp;</div>
                                            
										{!!Form::close()!!}
                                    
                                    </div>
                                </section>           
                            </div>
                        </div>                    
                    </section>
                </section>
            
            </section>
        	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
        </section>
    </section>

@include('includes.admin_footer')