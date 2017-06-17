@include('admin.includes.top')

<script>
function Validation(){
	if($('#user_full_name').val().trim() == ""){
		$('#user_full_name').focus();
		return false;
	}
}

function onlyNumber(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode
	console.log(charCode)
	if ((charCode >= 48 && charCode <= 57) || charCode == 8 || charCode == 16 ||charCode == 34 || charCode == 39 || charCode == 42 || charCode == 46 || charCode == 47 || charCode == 32 || charCode == 43){
		return true;
	} else {
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
                                        	
                                            @if(Session::has('msg'))
                                                <div class="alert alert-success">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <i class="fa fa-ok-sign"></i><strong>Success!</strong> Your profile has been updated<a href="#" class="alert-link"></a>.
                                                </div>
                                            @endif
                                            
                                            <header class="panel-heading font-bold">Your Profile</header>
                                            <div class="panel-body">
                                            
                                            {!!Form::open(array('action'=>'AdminController@adminupdateProfile','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                            	
                                                <div class="form-group">
                                                    {{ Form::label('user_full_name', 'Full Name') }}
                                                    {!!Form::text('user_full_name',$data[0]->user_full_name,array('class'=>'form-control','id'=>'user_full_name'))!!}
                                                </div>
                                                <div class="form-group">
                                                    {{ Form::label('email', 'Email') }}
                                                    {!!Form::text('email',$data[0]->email,array('class'=>'form-control','id'=>'email'))!!}
                                                </div>
                                                <div class="form-group">
                                                    {{ Form::label('username', 'User Name') }}
                                                    {!!Form::text('username',$data[0]->username,array('class'=>'form-control','id'=>'username'))!!}
                                                </div>
                                                <div class="form-group">
                                                	{{ Form::label('location', 'Location') }}
                                                    {!!Form::text('location',$data[0]->location,array('class'=>'form-control','id'=>'location'))!!}
                                                </div>
                                                <div class="form-group">
                                                    {{ Form::label('mobile', 'Mobile') }}
                                                    {!!Form::text('mobile',$data[0]->mobile,array('class'=>'form-control','id'=>'mobile','onKeyPress'=>'return onlyNumber(event);'))!!}
                                                </div>
                                                <div class="form-group">
                                                    {{ Form::label('phone', 'Office Phone') }}
                                                    {!!Form::text('phone',$data[0]->phone,array('class'=>'form-control','id'=>'phone','onKeyPress'=>'return onlyNumber(event);'))!!}
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
                </section>
            	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
            </section>
        </section>
    </section>

@include('admin.includes.admin_footer')