@include('admin.includes.top')

<script>
function Validation(){
	if($('#new_password').val().trim() == ""){
		$('#new_password').focus();
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
                                            <i class="fa fa-ok-sign"></i><strong>Success !</strong> Password has been saved.
                                            </div>
                                            @endif
                                            
                                            <header class="panel-heading font-bold">Password Generate for "{{ $data[0]->FirstName }} {{ $data[0]->LastName }}"</header>
                                            <div class="panel-body">
                                            
                                                {!!Form::open(array('action'=>'AdminController@admin_post_useraccount_setpassword','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                                    
                                                    {!!Form::hidden('pk_id',$data[0]->id)!!}
                                                    
                                                    @if($data[0]->password != "")
                                                    
                                                    <div class="form-group">
                                                        {{ Form::label('old_password', 'Current Password') }}
                                                        {!!Form::text('old_password', base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data[0]->password))))) ,array('class'=>'form-control','id'=>'old_password', 'disabled'))!!}
                                                    </div>
                                                    
                                                    @endif
                                                    
                                                    <div class="form-group">
                                                        {{ Form::label('new_password', 'New Password') }}
                                                        {!!Form::text('new_password',null,array('class'=>'form-control','id'=>'new_password', 'autofocus', 'autocomplete'=>'off'))!!}
                                                    </div>
                                                    {{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}&nbsp; {{ HTML::link('/adminpanel/useraccount', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}
                                                
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