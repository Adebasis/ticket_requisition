<? session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>eCaptcha Examples</title>
<meta name="keywords" content="">
<meta name="description" content="">

<script src="//code.jquery.com/jquery-latest.min.js"></script>
</head>
<body>

<h1>eCaptcha demo</h1>
<form action="" method="post">

<?php
## config ##
$captcha_title = 		'Dokažite da niste robot! Upišite rezultat';
$captcha_textcolor = 	'000000';
$captcha_width = 		'75';
$captcha_height = 		'24';
$captcha_type = 		'c';
$captcha_name = 		'demo';

## print ##
echo '
	<script type="text/javascript">
		$(document).ready(function() {
		    $("#reload_ecaptcha").click(function(){

		    	var current_time = new Date();
			    var normalPath = "ecaptcha.php?w='.$captcha_width.'&h='.$captcha_height.'&t='.$captcha_type.'&c='.$captcha_textcolor.'&n='.$captcha_name.'&time="+current_time;
			    $("#ecaptcha").attr({ src: normalPath });

		     });
		});
	</script>
	<div style="margin:5px 0;">'.$captcha_title.': <br/>
		<span id="reload_ecaptcha" style="cursor:pointer;"><img src="refresh.png" alt="" title="reload" /></span>
		<img src="ecaptcha.php?w='.$captcha_width.'&amp;h='.$captcha_height.'&amp;t='.$captcha_type.'&amp;c='.$captcha_textcolor.'&amp;n='.$captcha_name.'" id="ecaptcha" alt="" style="width:'.$captcha_width.'px;height:'.$captcha_height.'px;" /> <input name="ecaptcha" size="5" type="text" style="font-weight: bolder;margin-top: 3px;position: absolute;" />
	</div>';
?>
<input type="reset" value="Poništi" />
<input type="button" value="Pošalji" name="send" />

</form>

</body>
</html>