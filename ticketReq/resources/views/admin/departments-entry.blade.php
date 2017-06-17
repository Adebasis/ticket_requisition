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
                                            @if(Session::has('errmsg'))
                                                <div class="alert alert-danger">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <i class="fa fa-ok-sign"></i><strong>Error !</strong> Department name already exist.<a href="#" class="alert-link">&nbsp;Try again</a>.
                                                </div>
                                                @endif
                                        </div>
                                	</div>
                                    
                                    {!!Form::open(array('action'=>'AdminController@admindepartmententry','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                    
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <section class="panel panel-default">
                                                                                                
                                                <header class="panel-heading font-bold">Department [Entry]</header>
                                                <div class="panel-body">
                                                		
                                                        <div class="form-group">
                                                            {{ Form::label('Name', 'Department Name') }}
                                                            {!!Form::text('Name',null,array('class'=>'form-control','id'=>'Name', 'autofocus'))!!}
                                                        </div>
                                                        
                                                        <?php /*?><div class="form-group">
                                                            {{ Form::label('Name', 'First Level Approver') }}
                                                            <select name="first_approver" class="form-control chosen-select"  >
                                                                <option value="">Select</option>
                                                                <?php
                                                                $users = DB::select("SELECT * FROM useraccount WHERE approver_level = 0");
																foreach($users as $user){
																?>
                                                                <option value="<?php echo $user->id;?>"><?php echo $user->FirstName;?> <?php echo $user->LastName;?></option>
                                                                <?php }?>
                                                            </select>
                                                        </div><?php */?>
                                                        
                                                        {{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}&nbsp; {{ HTML::link('/adminpanel/departments', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}
                                                    
                                                                                                        
                                                </div>
                                            </section>           
                                        </div>
                                        
                                        <?php /*?><div class="col-sm-4">
                                            <section class="panel panel-default">
                                                                                                
                                                <header class="panel-heading font-bold">Second Level Approvers</header>
                                                <div class="panel-body">
                                                		
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
																	  
																	  //$resApp = DB::select("SELECT id FROM useraccount WHERE approver_level=2 and find_in_set(".$data[0]->id.", dept_second_approver) And id='".$user->id."'");
																	  //$is_approver = count($resApp);
																  ?>
                                                                <option value="<?php echo $user->id;?>"><?php echo $user->FirstName;?> <?php echo $user->LastName;?></option>
                                                                <?php }?>
                                                            </optgroup>
                                                          <?php }?>
                                                         </select>
                                                    </div>
                                                        
                                                        {{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}&nbsp; {{ HTML::link('/adminpanel/departments', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}
                                                    
                                                                                                        
                                                </div>
                                            </section>   <br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
        
                                        </div><?php */?>
                                        
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