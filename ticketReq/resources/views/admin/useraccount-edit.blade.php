@include('admin.includes.top')

<script>
function Validation(){
	if($('#FirstName').val().trim() == ""){
		$('#FirstName').focus();
		return false;
	}
	if($('#is_vp').val() == "1"){
		if($('#level').val() != "" || $('#is_fulfiler').val() == "1"){
			alert("Admin / Approvers / Fulfuller user can not be assign as Vice President.");
			return false;
		}
	}
}
function get_level(){
	$('#lbllevel').css('display','none');
	if($('#level').val()==2){
		$('#lbllevel').css('display','block');
	}
}
function get_fulfil(){
	$('#is_fulfiler').attr('disabled', true);
	if($('#dept_id').val()==4){		
		$('#is_fulfiler').attr('disabled', false);
	}else{
		$("#is_fulfiler")[0].selectedIndex = 0;
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
                                
                                {!!Form::open(array('action'=>'AdminController@admin_post_useraccount_edit','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                
                                {!!Form::hidden('pk_id',$data[0]->id)!!}
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                        <section class="panel panel-default">
                                        	
                                            @if(Session::has('errmsg_level'))
                                            <div class="alert alert-danger">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="fa fa-ok-sign"></i><strong>Error !</strong> Approver Level already exist.<a href="#" class="alert-link">&nbsp;Try again</a>.
                                            </div>
                                            @endif
                                            
                                            <header class="panel-heading font-bold">User Account [Edit]</header>
                                            <div class="panel-body">
                                            	
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                    {{ Form::label('FirstName', 'First Name') }}
                                                    {!!Form::text('FirstName',$data[0]->FirstName,array('class'=>'form-control','id'=>'FirstName','maxlength'=>'100', 'autofocus', 'required'))!!}
                                                    </div>
                                                    <div class="col-sm-6">
                                                    {{ Form::label('LastName', 'Last Name') }}
                                                    {!!Form::text('LastName',$data[0]->LastName,array('class'=>'form-control','id'=>'LastName', 'maxlength'=>'100', 'required'))!!}
                                                    </div>
                                                </div>
                                                <div class="row">&nbsp;</div>
                                                <div class="form-group">
                                                    {{ Form::label('EmailAddress', 'Email Address') }}
                                                    {!!Form::email('EmailAddress',$data[0]->EmailAddress,array('class'=>'form-control','id'=>'EmailAddress','maxlength'=>'200', 'required'))!!}
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        {{ Form::label('dept_id', 'Department') }}
                                                        {{ Form::select('dept_id', $department, $data[0]->dept_id, array('placeholder' => 'Please select ...', 'class'=>'form-control','id'=>'dept_id', '', 'required', 'onchange'=>'get_fulfil()')) }}
                                                    </div>
                                                    <?php
                                                    $level = $data[0]->approver_level;
													$is_fulfiler = $data[0]->is_fulfiler;
                                                    ?>
                                                    <div class="col-sm-3">
                                                        {{ Form::label('is_fulfiler', 'Is Fulfiler ?') }}
                                                        <select name="is_fulfiler" id="is_fulfiler" class="form-control" <?php if($data[0]->dept_id != "4"){?> disabled="disabled" <?php }?>>
                                                        	<option value="0" <?php if($is_fulfiler=="0"){?> selected="selected" <?php }?>>No</option>
                                                            <option value="1" <?php if($is_fulfiler=="1"){?> selected="selected" <?php }?>>Yes</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        {{ Form::label('level', 'Approver Level') }}
                                                        {{ Form::select('level',['1'=>'First Level','2'=>'Second Level'] , $level , array('placeholder' => 'N/A', 'class'=>'form-control','onchange'=>'get_level()')) }}
                                                    </div>
                                                </div>
                                                <div class="row">&nbsp;</div>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-sm-6">
                                                        {{ Form::label('employeetype_id', 'Employee Type') }}
                                                        {{ Form::select('employeetype_id', $employeetype, $data[0]->employeetype_id, array('placeholder' => 'Please select ...', 'class'=>'form-control','id'=>'requesttype_id', '', 'required')) }}
                                                        </div>
                                                        <div class="col-sm-3">
                                                            {{ Form::label('HasCc', 'HasCc') }}
                                                            {{Form::select('HasCc',['0'=>'No','1'=>'Yes'],$data[0]->HasCc,['class'=>'form-control','id'=>'HasCc'])}}
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label for="is_vp"><strong><i class="fa fa-life-ring" style="color:#09C;" title="Vice President"></i>&nbsp;is VP</strong></label>
                                                            {{Form::select('is_vp',['0'=>'No','1'=>'Yes'],$data[0]->is_vp,['class'=>'form-control','id'=>'is_vp'])}}
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
                                    
                                    <?php
									$dis='none';
									if($data[0]->approver_level == 2 || $data[0]->is_vp == "1"){
										$dis='block';
									}
									?>
                                    
                                    <div class="col-sm-6" id="lbllevel" style="display:<?php echo $dis;?>;">
                                        <section class="panel panel-default">
                                        	
                                            <header class="panel-heading font-bold">Departments (if Second Level Approver)</header>
                                            <div class="panel-body">
                                            	
                                                <div class="row">
                                                    <?php
													if($data[0]->approver_level == 2){
														$arrdept=$data[0]->dept_second_approver;
													}
													if($data[0]->is_vp == "1"){
														$arrdept=$data[0]->dept_of_vp;
													}
													if($arrdept !=''){
														$arrdept=explode(',',$arrdept);
													}else{
														$arrdept[]="";
													}
													//print_r($arrdept);exit;
													$dept = DB::table('department')->orderBy('Name', 'asc')->get();
													foreach($dept as $d){
													?>
                                                    <div class="col-sm-6">
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="dept[]" value="<?php echo $d->id;?>" <?php if(in_array($d->id,$arrdept)){?> checked="checked" <?php }?>><i></i><?php echo $d->Name;?></label></div>
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