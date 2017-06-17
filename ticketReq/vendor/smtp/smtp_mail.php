<?php
date_default_timezone_set('UTC');
//phpinfo();exit;

//function to send email througn PHP mailer starts here
function SendMail($AddAddress,$Subject, $From, $FromName, $Body, $AddAttachment="", $AddCC="",$multiple="0"){
	
	require_once('mail/class.phpmailer.php');
	
	
	//echo $AddAddress.'---'.$From.'--'.$Subject.'--'.$Body.'--'.$AddAttachment.'--'.$multiple;exit; 
	$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
	$mail->IsSendmail(); // telling the class to use SendMail transport
	$mail->IsSMTP(true);   // set mailer to use SMTP
	$mail->SMTPAuth = true;     // turn on SMTP authentication

	//for BLET
	/*$mail->Host		= "smtp.bletindia.com";  // specify main server
	$mail->SMTPSecure = "tls"; // use ssl
	$mail->Port		= 25;  // specify main server // 465 
	$mail->Username = "bletindi";  // SMTP username
	$mail->Password = "fire_blet"; // SMTP password*/
	
	//For gmail
	$mail->Host = "smtp.gmail.com";
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	$mail->Username = "joelcroft658@gmail.com";
	$mail->Password = "demopapu";
	$mail->Port = "465";
	//$mail->Timeout = 3600;  


	try {
		$mail->FromName=$FromName;
		$mail->From=$From;
		
		//set up your reply to email address
		//$mail->AddReplyTo('sureshkumar0505@gmail.com','sureshkumar0505');
		
		$mail->SMTPDebug  =1; 
		$mail->IsHTML(true);
		$mail->Subject =$Subject;
		
		if($multiple=="1"){
			$Mail_id=explode(",",$AddAddress);
			foreach($Mail_id as $addressvalue){
				$mail->AddAddress($addressvalue,"");	
			}
		}else{
			$Mail_id=explode(",",$AddAddress);
			//echo $Mail_id[0]."".$Mail_id[1];exit;
			//$mail->AddAddress($Mail_id[0],$Mail_id[1]);
			$mail->AddAddress($Mail_id[0]);
		}
		
		if($AddCC !=""){
			$cc_id=explode("#",$AddCC);
			foreach($cc_id as $ccvalue) {
				$ccvalue_new=explode(",",$ccvalue);
				//$mail->AddCC("$ccvalue_new[0]","$ccvalue_new[1]");
				$mail->AddCC($ccvalue_new[0]);	
			}
		}
		
		
		/*if($AddBCC !=""){
			$bcc_id=explode(",",$AddCC);
			foreach($bcc_id as $bccvalue) {
				$bccvalue_new=explode(",",$bccvalue);
				$mail->AddBCC($bccvalue_new[0]);	
			}
		}*/
		

		if($AddAttachment !=""){
			if($multiple=="1"){
				$AddAttachmentval =explode(",",$AddAttachment);	
				foreach($AddAttachmentval as $value){
					$mail->AddAttachment($value, $value);
				}
			}else{
				$AddAttachmentval =explode(",",$AddAttachment);	
				$mail->AddAttachment($AddAttachmentval[0], $AddAttachmentval[1]);
			}
		}
		
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
		//$mail->MsgHTML($message);
		$mail->Body =$Body;
		$mail->Send();
		
		print_r($mail->Send());
		//exit;
		
	}catch (phpmailerException $e) {
		echo $e->errorMessage(); //Pretty error messages from PHPMailer
	}catch (Exception $e) {
		echo $e->getMessage(); //Boring error messages from anything else!
	}
}

//function SendMail($AddAddress,$Subject, $From, $FromName, $Body, $AddAttachment="", $AddCC="",$multiple="0"){

//Send mail to all recipients at a time	
/*$email_str="brandonmunshun@gmail.com,sureshkumar0505123@gmail.com";
SendMail($email_str,"SMTP Mail", "joelcroft658@gmail.com","Joel Croft","Hello World !!","","","1");*/

//Send mail to all recipients one by one
$email_array=array("suresh@bletindia.com","sureshkumar02@gmail.com","sureshkumar0505@hotmail.com");
foreach($email_array as $email_val){
	SendMail($email_val,"SMTP Mail", "joelcroft658@gmail.com","Joel Croft","Hello World !!","","","");
}

?>