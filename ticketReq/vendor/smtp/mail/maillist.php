<?php

include('class.phpmailer.php');

	SendEmail("k.jaisundar@rifluxyss.com",'sundar431989@gmail.com',"Call for Online test","Test Message");
	

function SendEmail($from,$to,$subject,$message)							//	mail function starts here
{

	$mail             = new PHPMailer();
	$body             = eregi_replace("[\]",'',$message);

	$mail->IsSendmail(); // telling the class to use SendMail transport

	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->IsSMTP(true);
	$mail->Host		=	 "";  // specify main and backup server
	$mail->SMTPAuth	=	true; // turn on SMTP authentication
	$mail->Username	=	"";  // SMTP username
	$mail->Password	=	""; // SMTP password

	$mail->From       = $from;
	$mail->FromName   = $from;
	$mail->Subject    = $subject;
	
	$mail->Body	  = $message;
	$mail->MsgHTML($body);


	$mail->AddAddress($to,$to);
	
	if(!$mail->Send()){
		return (0);	
	}
	else
	{
	    return (1);
	}
	
}							
?>