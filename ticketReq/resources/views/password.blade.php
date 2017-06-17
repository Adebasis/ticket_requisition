@section('title')
    Login
@stop

@include('includes.top')

<section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
    <div class="container aside-xl">
    	<a class="navbar-brand block">ecomps</a>
        <section class="m-b-lg">
            <header class="wrapper text-center">
                <strong>Enter your email address</strong>
            </header>
        	        
            {!! Form::open(array('action' => 'HomeController@postResetPassword', 'id'=>'form1','autocomplete'=>'on')) !!}
            
            	<input type="hidden" name="_token" value="{{ csrf_token() }}">
            	
                <div class="list-group">
                    <div class="list-group-item">
                    {{ Form::input('text', 'txtUsername', null, ['class' => 'form-control no-border','placeholder'=>'Email Address','autofocus'=>'true','required']) }}
                    </div>
                    
                    <div class="list-group-item">
					
                        <div class="re"><img src="<?php echo url('/');?>/public/images/refresh.png" /></div>
                        <div class="rand1"></div>
                        <div class="plus">+</div>
                        <div class="rand2"></div>
                        <div class="plus_eq">=</div>
                        <input type="text" name="total" class="form-control" style="width:20%;margin-top:35px; float:right;" id="total" required autocomplete="off" />
                    
                    </div>
                    
                </div>
                
            	{{ Form::submit('Submit', array('class'=>'btn btn-lg btn-primary btn-block', 'id'=>'submit')) }}
                
                @if(Session::has('error'))
                <p><h4 style="color:#F00;">{!! Session::get('error') !!}</h4></p>
                @endif
                @if(Session::has('msg'))
                <p><h4 style="color:#090;">{!! Session::get('msg') !!}</h4></p>
                @endif
                <div class="text-center m-t m-b"><a href="{{ url('/') }}"><small>Sign In?</small></a></div>
                <div class="line line-dashed"></div>
            
            {!! Form::close() !!}
        
        </section>
    </div>
</section>

@include('includes.footer')

<style type="text/css">
.rand1, .rand2{
	padding: 16px;
	background-color: #ADDB4B;
	margin: 25px 0;
	float: left;
	border-radius: 0px;
}
.plus{
	padding: 7px 0;
	margin: 32px 7px;
	float: left;
}
.plus_eq{
	padding: 7px 0;
	margin: 32px 7px;
	float: left;
}
.re
{
margin:35px;
float:left; cursor:pointer;
/*box-shadow: 2px 2px 2px 1px #818181;
-moz-box-shadow: 2px 2px 2px 1px #818181;
-webkit-box-shadow: 2px 2px 2px 1px #818181;
-ms-box-shadow: 2px 2px 2px 1px #818181;
-o-box-shadow: 2px 2px 2px 1px #818181;*/
}
</style>
<script type="text/javascript">

function randomnum(){
	
	var number1 = 5;
	var number2 = 50;
	var randomnum = (parseInt(number2) - parseInt(number1)) + 1;
	var rand1 = Math.floor(Math.random()*randomnum)+parseInt(number1);
	var rand2 = Math.floor(Math.random()*randomnum)+parseInt(number1);
	$(".rand1").html(rand1);
	$(".rand2").html(rand2);
}

$(document).ready(function(){
	$(".re").click(function(){
	randomnum();
});

$("#submit").click(function(){
	if($('txtUsername').val() == ""){
		$('#txtUsername').focus();
		return false;
	}	
	var total=parseInt($('.rand1').html())+parseInt($('.rand2').html());
	var total1=$('#total').val().trim();
	
	if(total1 == ""){
		$('#total').focus();
		return false;
	}
	if(total!=total1){
		alert("Wrong Calculation Entered");
		randomnum();
		$('#total').val('');
		$('#total').focus();
		return false;
	}
});
randomnum();
});
</script>