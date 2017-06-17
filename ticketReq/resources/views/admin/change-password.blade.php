@include('admin.includes.top')

<script>
function Validation(){
	if($('#old_pass').val().trim() == ""){
		$('#old_pass').focus();
		return false;
	}
	if($('#new_pass').val().trim() == ""){
		$('#new_pass').focus();
		return false;
	}
	if($('#con_pass').val().trim() == ""){
		$('#con_pass').focus();
		return false;
	}
	if($('#con_pass').val().trim() != $('#new_pass').val().trim()){
		$('#old_pass').focus();
		return false;
	}
}
</script>

<section class="vbox">
    
    @include('admin.includes.header')
    
    <section class="hbox stretch">
        <!-- .aside -->
        @include('admin.includes.left')
        <!-- /.aside -->
        <section id="content">
            <section class="hbox stretch">
            
                <section class="vbox">
                    <section class="scrollable padder">              
                        <section class="row m-b-md"></section>
                        <div class="row">
                            <div class="col-sm-6">
                                <section class="panel panel-default">
                                
                                    @if(Session::has('msg'))
                                    <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <i class="fa fa-ok-sign"></i><strong>Success!</strong> Your password has been changed<a href="#" class="alert-link"></a>.
                                    </div>
                                    @endif
                                	
                                    @if(Session::has('errmsg'))
                                    <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <i class="fa fa-ok-sign"></i><strong>Error !</strong> Old password is incorrect.<a href="#" class="alert-link">&nbsp;Try again</a>.
                                    </div>
                                    @endif
                                    
                                	<header class="panel-heading font-bold">Change Password</header>
                                    <div class="panel-body">
                                        
                                        {!!Form::open(array('action'=>'AdminController@adminChangePassword','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                        
                                            <div class="form-group">
                                            	{{ Form::label('old_pass', 'Old Password') }}
                                                {!!Form::password('old_pass', array('class'=>'form-control','id'=>'old_pass','maxlength'=>20))!!}
                                            </div>
                                            <div class="form-group">
                                            	{{ Form::label('new_pass', 'New Password') }}
                                                {!!Form::password('new_pass', array('class'=>'form-control','id'=>'new_pass','maxlength'=>20))!!}
                                            </div>
                                            <div class="form-group">
                                            	{{ Form::label('con_pass', 'Re-Type Password') }}
                                                {!!Form::password('con_pass', array('class'=>'form-control','id'=>'con_pass','maxlength'=>20))!!}
                                            </div>
                                            
                                            {{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}
                                            
										{!!Form::close()!!}
                                    
                                    </div>
                                </section>           
                            </div>
                        </div>
                    
                    	<div class="row"><div>&nbsp;</div></div>
                    
                    </section>
                </section>
            
            </section>
        	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
        </section>
    </section>

@include('admin.includes.admin_footer')