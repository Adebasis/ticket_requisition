@include('admin.includes.top')

<script>
function Validation(){
	/*if($('#username').val().trim() == "admin" || $('#username').val().trim() == "Admin"){
		alert("User ID should not be admin.");
		$('#username').focus();
		return false;
	}*/
	var checkValues = $('input[id=request]:checked').map(function(){
										return $(this).val();
									}).get();
	
	if(checkValues == ""){
		alert("You can not change default page.");
		$('#request').prop('checked', true);
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
                                
                                {!!Form::open(array('action'=>'AdminController@admin_post_subadmin_edit','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                <input type="hidden" name="pk_id" value="<?php echo $data[0]->id;?>" />
                                <div class="row">
                                    <div class="col-sm-6">
                                        <section class="panel panel-default">
                                        	
                                            @if(Session::has('errmsg'))
                                            <div class="alert alert-danger">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="fa fa-ok-sign"></i><strong>Error !</strong> User ID already exist.<a href="#" class="alert-link">&nbsp;Try again</a>.
                                            </div>
                                            @endif
                                            
                                            <header class="panel-heading font-bold">SubAdmin Account [Edit]</header>
                                            <div class="panel-body">
                                            	
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                    <label><h2><u>User Name</u></h2></label>
                                                    </div>
                                                    <?php														
													$users = DB::select("select id,FirstName,LastName,EmailAddress from useraccount where id='".$data[0]->user_id."'");
													?>
                                                    <div class="col-sm-12">
                                                    <label><h1><?php echo $users[0]->FirstName;?>&nbsp;<?php echo $users[0]->LastName;?></h1></label>
                                                    </div>
                                                    <div class="col-sm-12">
                                                    <label style="font-size:14px; font-weight:bold;"><h2><u>Email Address</u></h2></label>
                                                    </div>
                                                    <div class="col-sm-12">
                                                    <label><h1><?php echo $users[0]->EmailAddress;?></h1></label>
                                                    </div>
                                                </div>
                                                <div class="row">&nbsp;</div>
                                                
                                                <div class="form-group">
                                                    
                                                </div>
                                                
                                                <div class="row">&nbsp;</div>                                                
                                                <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">&nbsp;</div>
                                                </div>
                                                {{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}&nbsp; {{ HTML::link('/adminpanel/subadmin', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}
                                            	
                                            </div>
                                        </section>           
                                    </div>
                                	<div class="col-sm-5">
                                        <section class="panel panel-default">
                                        	<?php
											$allow_pages = $data[0]->allow_pages;
											//$pages = array();
											//if($allow_pages != ""){
												$pages = explode(",", $allow_pages);
											//}
											//print_r($pages);
											?>
                                            <header class="panel-heading font-bold">Assign Pages to Access</header>
                                            <div class="panel-body">                                            	
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="department" <?php if(in_array('department', $pages)){?> checked="checked" <?php }?> ><i></i>Manage Departments</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="users" id="users" <?php if(in_array('users', $pages)){?> checked="checked" <?php }?>  ><i></i>Manage Users</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="delivery" <?php if(in_array('delivery', $pages)){?> checked="checked" <?php }?>  ><i></i>Manage Delivery Types</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="location" <?php if(in_array('location', $pages)){?> checked="checked" <?php }?>  ><i></i>Manage Location Types</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="team" <?php if(in_array('team', $pages)){?> checked="checked" <?php }?>  ><i></i>Manage Teams</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="email" <?php if(in_array('email', $pages)){?> checked="checked" <?php }?>  ><i></i>Manage Email Templates</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="smtp" <?php if(in_array('smtp', $pages)){?> checked="checked" <?php }?>  ><i></i>SMTP Settings</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="smtp-test" <?php if(in_array('smtp-test', $pages)){?> checked="checked" <?php }?>  ><i></i>SMTP Test Mail</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="apps" <?php if(in_array('apps', $pages)){?> checked="checked" <?php }?>  ><i></i>Apps Settings</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="subadmin" <?php if(in_array('subadmin', $pages)){?> checked="checked" <?php }?>  ><i></i><span class="font-bold">Manage Sub Admin</span></label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" id="request" value="request" <?php if(in_array('request', $pages)){?> checked="checked" <?php }?>  ><i></i><span class="font-bold">Request Section (<em><strong style="color:#F00;">Default</strong></em>&nbsp;)</span></label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="fullapproved" <?php if(in_array('fullapproved', $pages)){?> checked="checked" <?php }?>  ><i></i><span class="font-bold">Fully Approved Requests</span></label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="game" <?php if(in_array('game', $pages)){?> checked="checked" <?php }?>  ><i></i><span class="font-bold">Manage Games</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="requested_users" <?php if(in_array('requested_users', $pages)){?> checked="checked" <?php }?> ><i></i>Requested tickets by users</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" id="users" value="requested_games" <?php if(in_array('requested_games', $pages)){?> checked="checked" <?php }?> ><i></i>Requested tickets by games</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="requested_teams" <?php if(in_array('requested_teams', $pages)){?> checked="checked" <?php }?> ><i></i>Requested tickets by team</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="fulfilled_date" <?php if(in_array('fulfilled_date', $pages)){?> checked="checked" <?php }?> ><i></i>Fulfilled tickets by date</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="fulfilled_games" <?php if(in_array('fulfilled_games', $pages)){?> checked="checked" <?php }?> ><i></i>Fulfilled tickets by game</label>
                                                        </div>
                                                    </div>
                                                </div>                                            	
                                            </div>
                                        </section>           
                                    </div>
                                </div>
                                
                                {!!Form::close()!!}
                                
                            </section>
                        </section>
                    </section>
                </section>
            	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
            </section>
        </section>
    </section>

@include('admin.includes.admin_footer')