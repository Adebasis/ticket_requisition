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
                                
                                {!!Form::open(array('action'=>'AdminController@admin_post_subadmin_entry','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                        <section class="panel panel-default">
                                        	
                                            @if(Session::has('errmsg'))
                                            <div class="alert alert-danger">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="fa fa-ok-sign"></i><strong>Error !</strong> User ID already exist.<a href="#" class="alert-link">&nbsp;Try again</a>.
                                            </div>
                                            @endif
                                            
                                            <header class="panel-heading font-bold">SubAdmin Account [Entry]</header>
                                            <div class="panel-body">
                                            	
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                    {{ Form::label('FirstName', 'Select User Name') }}
                                                    <select name="user_id" id="user_id" class="form-control" required>
                                                    	<option value=""></option>
                                                        <?php
														
														$users = DB::select("select id,FirstName,LastName from useraccount where is_deleted=0 And id not in (select user_id from subadmin)  order by FirstName");
														foreach ($users as $index=>$tmp){
														?>
                                                        <option value="<?php echo $tmp->id;?>"><?php echo $tmp->FirstName;?>&nbsp;<?php echo $tmp->LastName;?></option>
                                                        <?php
														}
														?>
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="row">&nbsp;</div>
                                                
                                                <div class="form-group">
                                                    
                                                </div>
                                                                                              
                                                <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">&nbsp;</div>
                                                </div>
                                                {{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}&nbsp; {{ HTML::link('/adminpanel/subadmin', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}
                                                
                                                
                                            	
                                            </div>
                                        </section>           
                                    </div>
                                	<div class="col-sm-5">
                                        <section class="panel panel-default">
                                        	
                                            <header class="panel-heading font-bold">Assign Pages to Access</header>
                                            <div class="panel-body">                                            	
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="department" ><i></i>Manage Departments</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" id="users" value="users" ><i></i>Manage Users</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="delivery" ><i></i>Manage Delivery Types</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="location" ><i></i>Manage Location Types</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="team" ><i></i>Manage Teams</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="email" ><i></i>Manage Email Templates</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="smtp" ><i></i>SMTP Settings</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="smtp-test" ><i></i>SMTP Test Mail</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="apps" ><i></i>Apps Settings</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="subadmin" ><i></i><span class="font-bold">Manage Sub Admin</span></label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" id="request" value="request" checked="checked" ><i></i><span class="font-bold">Request Section (<em><strong style="color:#F00;">Default</strong></em>&nbsp;)</span></label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="fullapproved" ><i></i><span class="font-bold">Fully Approved Requests</span></label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="game" ><i></i><span class="font-bold">Manage Games</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="requested_users" ><i></i>Requested tickets by users</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" id="users" value="requested_games" ><i></i>Requested tickets by games</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="requested_teams" ><i></i>Requested tickets by team</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="fulfilled_date" ><i></i>Fulfilled tickets by date</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="fulfilled_games" ><i></i>Fulfilled tickets by game</label>
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