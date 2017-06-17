<?php

# Check is SESSION started
if ((function_exists('session_status') && session_status() !== PHP_SESSION_ACTIVE) || !session_id()){
	session_start();
}

# overrides the default PHP memory limit.
//ini_set('memory_limit', '-1');  

# make GD Font Path
//putenv('GDFONTPATH='.realpath('.')); 

class eCaptchaSecurity {

	#font type
	var $font = 'Halant.ttf';

	public $width;
	public $height;
	public $type;
	public $font_color;
	public $captcha_name;
	
	function generateCase($cap_type){
		$global_arr = array();

			#simple
				//summation
				for ($i = 1; $i <= 20; $i++) {
					$max_sum=20;
					$sum = 0;
					for ($b = 0; $b < $max_sum; $b++) {
						if(($i+$b)<=$max_sum){
							$global_arr[$i.' + '.$b.' ='] = $i+$b;
							$sum = $i+$b;
						}
					}
				}

			#simple & middle
			if($cap_type == 'm' || $cap_type == 'c'){
				//subtraction
				for ($i = 1; $i <= 20; $i++) {
					$max_sum=20;
					$sum = 0;
					for ($b = 1; $b < $max_sum; $b++) {
						if(($i-$b)>0 && ($i-$b)<=$max_sum){
							$global_arr[$i.' - '.$b.' ='] = $i-$b;
							$sum = $i-$b;
						}
					}
				}
			}

			#simple & middle & complex
			if($cap_type == 'c'){
				//multiplication
				for ($i = 1; $i <= 20; $i++) {
					$max_sum=20;
					$sum = 0;
					for ($b = 1; $b < $max_sum; $b++) {
						if(($i*$b)<=$max_sum){
							$global_arr[$i.' x '.$b.' ='] = $i*$b;
							$sum = $i*$b;
						}
					}
				}
				//divide
				for ($i = 1; $i <= 20; $i++) {
					$max_sum=20;
					$sum = 0;
					for ($b = 1; $b < $max_sum; $b++) {
						if(is_int($i/$b) && ($i/$b)<=$max_sum){
							$global_arr[$i.' / '.$b.' ='] = $i/$b;
							$sum = $i/$b;
						}
					}
				}
			}


		return $global_arr;
	}


	function eCaptchaSecurity($width='75',$height='26',$type='',$font_color,$captcha_name=''){

		global $_SESSION;

		putenv('GDFONTPATH=' . realpath('.'));
		
		$fontsizeinPX = 19;
		$fontsizeinPT = ($fontsizeinPX*3)/4;

		//get text color
		list($r, $g, $b) = sscanf($font_color, "#%02x%02x%02x");

		// The text to draw
		$exp_code = $this->generateCase($type);
		//get random code
		$text = array_rand($exp_code, 1);

		// make session code
		//$_SESSION['code_'.$captcha_name] = $exp_code[$text];
		
		// Create the image
		$im = imagecreatetruecolor($width, $height);
		imagealphablending($im,false);


		// Create some colors
		$shadow_color = imagecolorallocatealpha($im, floor((1+$r)/2), floor((1+$g)/2), floor((1+$b)/2), 85);
		$text_color = imagecolorallocate($im, $r, $g, $b);

		$col=imagecolorallocatealpha($im,255,255,255,127);
		imagefilledrectangle($im, 0, 0, 399, 29, $col);
		imagealphablending($im,true);

		// Add some shadow to the text
		imagettftext($im, $fontsizeinPT, 0, 6, 21, $shadow_color, $this->font, $text) or die('Error in imagettftext function');

		// Add the text
		imagettftext($im, $fontsizeinPT, 0, 5, 20, $text_color, $this->font, $text) or die('Error in imagettftext function');

		/* output captcha image to browser */
		header('Content-Type: image/png');
		imagealphablending($im,false);
		imagesavealpha($im,true);

		// Using imagepng() results in clearer text compared with imagejpeg()
		imagepng($im);
		imagedestroy($im);

		exit();
	}
}
//$_SESSION['e_cap_debug'] = $_GET;
unset($_SESSION['e_cap_debug']);
$captcha = new eCaptchaSecurity (
	(isset($_GET['w']) ? str_replace('amp;','',$_GET['w']) : '75'),
	(isset($_GET['h']) ? str_replace('amp;','',$_GET['h']) : '26'),
	(isset($_GET['t']) ? str_replace('amp;','',$_GET['t']) : 's'),
	(isset($_GET['c']) ? '#'.str_replace('amp;','',$_GET['c']) : '#555555'),
	(isset($_GET['n']) ? str_replace('amp;','',$_GET['n']) : 'ecaptcha')
);
?>