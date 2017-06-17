@include('admin.includes.top')

<script>
function Validation(){
	if($('#FirstName').val().trim() == ""){
		$('#FirstName').focus();
		return false;
	}
	if($('#password').val().trim() == ""){
		$('#password').focus();
		return false;
	}
	if($('#is_vp').val() == "1"){
		if($('#level').val() != "" || $('#is_fulfiler').val() == "1"){
			alert("Approvers / Fulfuller user can not be assign as Vice President.");
			return false;
		}
	}
}
function get_level(){
	$('#lbllevel').css('display','none');
	if($('#level').val()==2 || $('#is_vp').val()==1){
		$('#lbllevel').css('display','block');
	}
}
function get_fulfil(){
	$('#is_fulfiler').attr('disabled', true);
	if($('#dept_id').val()==4){
		$('#is_fulfiler').attr('disabled', false);
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
                                
                                {!!Form::open(array('action'=>'AdminController@admin_post_useraccount_entry','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                        <section class="panel panel-default">
                                        	
                                            @if(Session::has('errmsg'))
                                            <div class="alert alert-danger">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="fa fa-ok-sign"></i><strong>Error !</strong> Email address already exist.<a href="#" class="alert-link">&nbsp;Try again</a>.
                                            </div>
                                            @endif
                                            
                                            @if(Session::has('errmsg_level'))
                                            <div class="alert alert-danger">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="fa fa-ok-sign"></i><strong>Error !</strong> Approver Level already exist.<a href="#" class="alert-link">&nbsp;Try again</a>.
                                            </div>
                                            @endif
                                            
                                            <header class="panel-heading font-bold">User Account [Entry]</header>
                                            <div class="panel-body">
                                            	
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                    {{ Form::label('FirstName', 'First Name') }}
                                                    {!!Form::text('FirstName',null,array('class'=>'form-control','id'=>'FirstName','maxlength'=>'100', 'autofocus', 'required'))!!}
                                                    </div>
                                                    <div class="col-sm-6">
                                                    {{ Form::label('LastName', 'Last Name') }}
                                                    {!!Form::text('LastName',null,array('class'=>'form-control','id'=>'LastName', 'maxlength'=>'100', 'required'))!!}
                                                    </div>
                                                </div>
                                                <div class="row">&nbsp;</div>
                                                <div class="form-group">
                                                    {{ Form::label('EmailAddress', 'Email Address') }}
                                                    {!!Form::email('EmailAddress',null,array('class'=>'form-control','id'=>'EmailAddress','maxlength'=>'200', 'required'))!!}
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                    {{ Form::label('user_name', 'User Name') }}
                                                    {!!Form::text('user_name',null,array('class'=>'form-control','id'=>'user_name','maxlength'=>'50', 'required'))!!}
                                                    </div>
                                                    <div class="col-sm-6">
                                                    {{ Form::label('password', 'Password') }}
                                                    {!!Form::password('password',null,array('class'=>'form-control','id'=>'password','maxlength'=>'100', 'required', 'required'))!!}
                                                    </div>
                                                </div>
                                                <div class="row">&nbsp;</div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        {{ Form::label('dept_id', 'Department') }}
                                                        {{ Form::select('dept_id', $department, 0, array('placeholder' => 'Please select ...', 'class'=>'form-control','id'=>'dept_id', 'required', 'onchange'=>'get_fulfil()')) }}
                                                    </div>
                                                    <div class="col-sm-3">
                                                        {{ Form::label('is_fulfiler', 'Is Fulfiler ?') }}
                                                        {{ Form::select('is_fulfiler',['0'=>'No','1'=>'Yes'], 0 , array('class'=>'form-control', 'disabled')) }}
                                                    </div>
                                                    <div class="col-sm-3">
                                                        {{ Form::label('level', 'Approver Level') }}
                                                        {{ Form::select('level',['1'=>'First Level','2'=>'Second Level'] , 0 , array('placeholder' => 'N/A', 'class'=>'form-control', 'onchange'=>'get_level()')) }}
                                                    </div>
                                                </div>
                                                <div class="row">&nbsp;</div>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-sm-6">
                                                        {{ Form::label('employeetype_id', 'Employee Type') }}
                                                        {{ Form::select('employeetype_id', $employeetype, 0, array('placeholder' => 'Please select ...', 'class'=>'form-control','id'=>'requesttype_id', 'required')) }}
                                                    </div>
                                                        <div class="col-sm-3">
                                                            {{ Form::label('HasCc', 'HasCc') }}
                                                            {{Form::select('HasCc',['0'=>'NO','1'=>'Yes'],'null',['class'=>'form-control','id'=>'HasCc'])}}
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label for="is_vp"><strong><i class="fa fa-life-ring" style="color:#09C;" title="Vice President"></i>&nbsp;is VP</strong></label>
                                                            {{Form::select('is_vp',['0'=>'No','1'=>'Yes'],0,['class'=>'form-control','id'=>'is_vp', 'onchange'=>'get_level()'])}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">&nbsp;</div>
                                                </div>
                                                {{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}&nbsp; {{ HTML::link('/adminpanel/useraccount', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}
                                                
                                                
                                            	
                                            </div>
                                        </section>           
                                    </div>
                                    
                                    <div class="col-sm-6" id="lbllevel" style="display:none;">
                                        <section class="panel panel-default">
                                        	
                                            <header class="panel-heading font-bold">Departments (if Second Level Approver)</header>
                                            <div class="panel-body">
                                            	
                                                <div class="row">
                                                    <?php
													$dept = DB::table('department')->orderBy('Name', 'asc')->get();
													foreach($dept as $d){
													?>
                                                    <div class="col-sm-6">
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="dept[]" value="<?php echo $d->id;?>" ><i></i><?php echo $d->Name;?></label></div>
                                                    </div>
                                                    <?php }?>
                                                </div>
                                                <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">&nbsp;</div>
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