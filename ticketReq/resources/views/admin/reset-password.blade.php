@section('title')
    Reset Password
@stop

@include('includes.top')

<script>
function Validation(){
	
	if($('#new_pass').val().trim() == ""){
		$('#new_pass').focus();
		return false;
	}
	if($('#con_pass').val().trim() == ""){
		$('#con_pass').focus();
		return false;
	}
	if($('#con_pass').val().trim() != $('#new_pass').val().trim()){
		$('#con_pass').focus();
		return false;
	}
}
</script>

<section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
    <div class="container aside-xl">
    	<a class="navbar-brand block">ecomps</a>
        <section class="m-b-lg">
            <header class="wrapper text-center">
                <strong>Enter your new password</strong>
            </header>
                
                <?php if(Session::get('id_exist') == "no"){?>
                <p><h4 style="color:#F00;">This link has been expired !!!</h4></p>
                <?php }else{?>
                
                <?php if(Session::has('errmsg')){?>
                <p><h4 style="color:#F00;">Wrong old password !!!</h4></p>
                <?php }?>
                
                <?php if(Session::has('msg')){?>
                <p><h4 style="color:#090;">Password has been changed !!!</h4></p>
                <?php }?>
                
                {!!Form::open(array('action'=>'AdminController@adminpostResetPasswordSave','method'=>'post','onsubmit'=>'return Validation()'))!!}
                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                    <div class="list-group">
                        
                        <div class="list-group-item">
                        {!!Form::password('new_pass', array('class'=>'form-control no-border','id'=>'new_pass','maxlength'=>20,'placeholder'=>'New Password'))!!}
                        </div>
                        <div class="list-group-item">
                        {!!Form::password('con_pass', array('class'=>'form-control no-border','id'=>'con_pass','maxlength'=>20,'placeholder'=>'Re-Type Password'))!!}
                        </div>
                                            
                    </div>
                    {{ Form::submit('SUBMIT', array('class'=>'btn btn-lg btn-primary btn-block')) }}
                    
                {!!Form::close()!!}
                <?php }?>
                
                <div class="text-center m-t m-b"><a href="{{ url('/adminpanel') }}"><small>Sign In?</small></a></div>
                <div class="line line-dashed"></div>
        
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