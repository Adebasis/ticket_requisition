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
                                        	
                                            @if(Session::has('errmsg'))
                                            <div class="alert alert-danger">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="fa fa-ok-sign"></i><strong>Error !</strong> Delivery Group already exist.<a href="#" class="alert-link">&nbsp;Try again</a>.
                                            </div>
                                            @endif
                                            
                                            <header class="panel-heading font-bold">Delivery Group [Edit]</header>
                                            <div class="panel-body">
                                            
                                                {!!Form::open(array('action'=>'TeamController@admin_post_deliverygroup_edit','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                                    
                                                    {!!Form::hidden('pk_id',$data[0]->id)!!}
                                                    
                                                    <div class="form-group">
                                                        {{ Form::label('Name', 'Name') }}
                                                        {!!Form::text('Name',$data[0]->Name,array('class'=>'form-control','id'=>'Name', 'autofocus'))!!}
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            {{ Form::label('Name', 'Delivery Type', array('style'=>'font-weight:bold;text-decoration:underline;')) }}
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
                                                    
                                                    {{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}&nbsp; {{ HTML::link('/adminpanel/deliverygroup', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}
                                                
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