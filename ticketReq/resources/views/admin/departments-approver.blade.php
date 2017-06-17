@include('admin.includes.top')

<script>
function Validation(){
	if($('#Name').val().trim() == ""){
		$('#Name').focus();
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
                                
                                <div class="row">                                    
                                    <div class="col-sm-8">
                                    @if(Session::has('success'))
                                        <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <i class="fa fa-ok-sign"></i><strong>Success !</strong>Approver has been saved.</div>
                                        @endif
                                    </div>
                                </div>
                                
                                {!!Form::open(array('action'=>'AdminController@admin_post_department_approver','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                                    
								{!!Form::hidden('pk_id',$data[0]->id)!!}
                                
                                <div class="row">
                                    
                                    <div class="col-sm-4">
                                        <section class="panel panel-default">
                                        	
                                            <header class="panel-heading font-bold">First Level Approver</header>
                                            <div class="panel-body">
                                            		
                                                    <div class="form-group">
                                                        {{ Form::label('Name', 'Department Name') }}
                                                        {!!Form::text('Name',$data[0]->Name,array('class'=>'form-control','id'=>'Name', 'readonly'))!!}
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        {{ Form::label('Name', 'First Level Approver') }}
                                                        <select name="first_approver" class="form-control chosen-select" >
                                                            <option value="">Select</option>
                                                            <?php foreach($users as $user){ ?>
                                                            <option value="<?php echo $user->id;?>" <?php if($data[0]->first_approver == $user->id){?> selected="selected" <?php }?>><?php echo $user->FirstName;?> <?php echo $user->LastName;?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="row">&nbsp;</div>
                                                    
                                                    {{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}&nbsp; {{ HTML::link('/adminpanel/departments', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}
                                                	
                                                    <div class="row">&nbsp;</div>
                                            	
                                            </div>
                                        </section>           
                                    </div>
                                    <div class="col-sm-4">
                                        <section class="panel panel-default">
                                        	
                                            <header class="panel-heading font-bold">Second Level Approvers</header>
                                            <div class="panel-body">
                                            		
                                                    <div class="form-group">
                                                        {{ Form::label('Name', 'Department Name') }}
                                                        {!!Form::text('Name',$data[0]->Name,array('class'=>'form-control','id'=>'Name', 'readonly'))!!}
                                                    </div>
                                                                                                        
                                                    <div class="form-group">
                                                        {{ Form::label('Name', 'Second Level Approver') }}
                                                        <select name="second_approver[]" data-placeholder="Choose Your Second Level Approvers" multiple class="chosen-select"  >
                                                          <option value=""></option>
                                                          <?php
                                                          $dept = DB::table('department')->orderBy('Name')->get();
														  foreach($dept as $tmpdept){
															  ?>
                                                          	<optgroup label="<?php echo $tmpdept->Name;?>">
                                                            	<?php
																  $users = DB::table('useraccount')->select('id', 'FirstName', 'LastName')->orderBy('FirstName')->where('dept_id', $tmpdept->id)->get();
																  foreach($users as $user){
																	  
																	  $resApp = DB::select("SELECT id FROM useraccount WHERE approver_level=2 and find_in_set(".$data[0]->id.", dept_second_approver) And id='".$user->id."'");
																	  $is_approver = count($resApp);
																  ?>
                                                                <option value="<?php echo $user->id;?>" <?php if($is_approver > 0){?> selected="selected" <?php }?>><?php echo $user->FirstName;?> <?php echo $user->LastName;?></option>
                                                                <?php }?>
                                                            </optgroup>
                                                          <?php }?>
                                                         </select>
                                                    </div>
                                                    
                                                    <div class="row">&nbsp;</div>
                                                    
                                                    {{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}&nbsp; {{ HTML::link('/adminpanel/departments', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}
                                                	
                                                    <div class="row">&nbsp;</div>
                                                    
                                                {!!Form::close()!!}
                                            	
                                            </div>
                                        </section> <br />
<br />
<br />
<br />
<br />
<br />
<br />
          
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

{!!HTML::script('public/admin_assets/js/chosen.jquery.js')!!}
{!! Html::style('public/admin_assets/css/bootstrap-choosen.css') !!}

<script>
$(function() {
$('.chosen-select').chosen();
$('.chosen-select-deselect').chosen({ allow_single_deselect: true });
});
</script>
