@include('admin.includes.top')

<script>
function Validation(){
	if($('#username').val().trim() == "admin" || $('#username').val().trim() == "Admin"){
		alert("User ID should not be admin.");
		$('#username').focus();
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
                                                <i class="fa fa-ok-sign"></i><strong>Error !</strong> User ID already exist. Try another<a href="#" class="alert-link"></a>.
                                                </div>
                                            @endif
                                            
                                            @if(Session::has('msg'))
                                                <div class="alert alert-success">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <i class="fa fa-ok-sign"></i><strong>Success!</strong> Your profile has been updated<a href="#" class="alert-link"></a>.
                                                </div>
                                            @endif
                                            
                                            <header class="panel-heading font-bold">Your Profile</header>
                                            <div class="panel-body">
                                            
                                            {!!Form::open(array('action'=>'AdminController@admin_post_subadmin_profile_edit','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                            	
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                    {{ Form::label('FirstName', 'First Name') }}
                                                    {!!Form::text('FirstName',$data[0]->FirstName ,array('class'=>'form-control','id'=>'FirstName','maxlength'=>'100', 'autofocus', 'required'))!!}
                                                    </div>
                                                    <div class="col-sm-6">
                                                    {{ Form::label('LastName', 'Last Name') }}
                                                    {!!Form::text('LastName',$data[0]->LastName,array('class'=>'form-control','id'=>'LastName', 'maxlength'=>'100', 'required'))!!}
                                                    </div>
                                                </div>
                                                <div class="row">&nbsp;</div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                    {{ Form::label('username', 'User ID') }}
                                                    {!!Form::text('username',$data[0]->username,array('class'=>'form-control','id'=>'username','maxlength'=>'100', 'required'))!!}
                                                    </div>
                                                    <div class="col-sm-6">
                                                    {{ Form::label('EmailAddress', 'Email Address') }}
                                                    {!!Form::email('EmailAddress',$data[0]->EmailAddress,array('class'=>'form-control','id'=>'EmailAddress','maxlength'=>'100', 'required'))!!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    
                                                </div>
                                                <div class="row">&nbsp;</div> 
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
                </section>
            	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
            </section>
        </section>
    </section>

@include('admin.includes.admin_footer')