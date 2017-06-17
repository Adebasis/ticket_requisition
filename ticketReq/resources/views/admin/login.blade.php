@include('admin.includes.top')

<section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
    <div class="container aside-xl">
    	<?php
		$appsettings = DB::table('appsettings')->where('id', 2)->get();
		?>
    	<a class="navbar-brand1 block" style="text-align:center;"><img src="{{ url('/') }}/public/admin_assets/images/<?php echo $appsettings[0]->Value;?>" class="m-r-lg" alt="scale" style="width:30%; min-height:inherit; height:95px !important;"></a>
        <section class="m-b-lg">
            <header class="wrapper text-center">
                <strong>Sign in Here</strong>
            </header>
        	        
            {!! Form::open(array('action' => 'AdminController@postLogin', 'id'=>'form1','autocomplete'=>'on')) !!}
            
            	<input type="hidden" name="_token" value="{{ csrf_token() }}">
            	
                <div class="list-group">
                    <div class="list-group-item">
                    {{ Form::input('text', 'txtUsername', null, ['class' => 'form-control no-border','placeholder'=>'Email Address OR User Name','autofocus'=>'true','required']) }}
                    </div>
                    <div class="list-group-item">
                    {{ Form::input('password', 'txtPassword', null, ['class' => 'form-control no-border','placeholder'=>'***********','required']) }}
                    </div>
                </div>
                
            	{{ Form::submit('Sign In', array('class'=>'btn btn-lg btn-primary btn-block')) }}
                
                <p><h4 style="color:#F00;">
                @if(Session::has('error'))
                {!! Session::get('error') !!}
                @endif
                </h4>
                </p>
                
                <div class="text-center m-t m-b"><a href="{{ url('adminpanel/reset/password') }}"><small>Reset password?</small></a></div>
                <div class="line line-dashed"></div>
            
            {!! Form::close() !!}
        
        </section>
    </div>
</section>

@include('admin.includes.footer')