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
                                    <div class="col-sm-6">
                                        <section class="panel panel-default">
                                        	
                                            @if(Session::has('success'))
                                            <div class="alert alert-success">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="fa fa-ok-sign"></i><strong>Success !</strong>Task has been saved.
                                            </div>
                                            @endif
                                            
                                            <header class="panel-heading font-bold">Tasks For [{{ $data[0]->Name }}]</header>
                                            <div class="panel-body">
                                            
                                                {!!Form::open(array('action'=>'AdminController@admin_post_roles_tasks_assign_page','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                                    
                                                    {!!Form::hidden('pk_id',$data[0]->id)!!}
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            {{ Form::label('Name', 'Tasks Name', array('style'=>'font-weight:bold;text-decoration:underline;')) }}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        
                                                        <div class="col-sm-12">
                                                            
                                                            @foreach ($task as $index=>$tmptask)
                                                            
                                                            <?php
															$checked = 0;
															if($roletasks){
																$tmproletasks = $roletasks->toArray();
																$checked = in_array($tmptask->id, $tmproletasks);
																if($checked){
																	$checked = 1;
																}
															}
															?>
                                                            <div class="checkbox i-checks">
                                                              <label>
                                                                {{ Form::checkbox('task_id[]', $tmptask->id, $checked , ['class' => 'field']) }}
                                                                <i></i>{{ $tmptask->Name }}
                                                              </label>
                                                            </div>
                                                            
                                                            @endforeach
                                                            
                                                          </div>
                                                        
                                                    </div>
                                                    <div class="form-group">
                                                        
                                                        <div class="col-sm-12">
                                                    		{{ Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}&nbsp; {{ HTML::link('/adminpanel/roles', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}
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
                </section>
            	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
            </section>
        </section>
    </section>

@include('admin.includes.admin_footer')