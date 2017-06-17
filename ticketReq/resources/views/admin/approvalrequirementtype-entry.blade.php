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
                                            <i class="fa fa-ok-sign"></i><strong>Error !</strong> Location Type already exist.<a href="#" class="alert-link">&nbsp;Try again</a>.
                                            </div>
                                            @endif
                                            
                                            <header class="panel-heading font-bold">Approval Requirement Type [Entry]</header>
                                            <div class="panel-body">
                                            
                                                {!!Form::open(array('action'=>'TeamController@admin_post_approvalrequirementtype_entry','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                                 <script>
																function countChar(val, res) {																
																	var len = val.value.length;
																	if (len > 100) {
																		val.value = val.value.substring(0, 100);
																	} else {
																		$('#'+res).text(parseInt(len));
																	}
																};
												</script>
                                                    
                                                    <div class="form-group">
                                                        {{ Form::label('Description', 'Description') }}&nbsp;(<span id="Instructions_char">0</span> / 100)
                                                        {!!Form::textarea('Description',null,array('class'=>'form-control','id'=>'Description', 'autofocus','rows'=>'5','onkeyup'=>'countChar(this, "Instructions_char");'))!!}
                                                    </div>
                                                    
                                                    {{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}&nbsp; {{ HTML::link('/adminpanel/approvalrequirementtype', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}
                                                
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