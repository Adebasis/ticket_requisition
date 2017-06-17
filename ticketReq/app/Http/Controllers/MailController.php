<?php
// This is Controller of Mail functionality.

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Session;
use Mail;
class MailController extends Controller
{
	
	public function __construct()
    {
        $this->middleware(function ($request, $next) {
            //$this->projects = Auth::user()->projects;

            return $next($request);
        });
    }
	public function test_mail(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.testmail');
	}
    public function admin_post_mail_testings(Request $request){
		
		$host = $request->input('host');
		$from_email = $request->input('email');
		$to_email = $request->input('to_email');
		$password = $request->input('password');
		$port = $request->input('port');
		$from_name = $request->input('from_name');
		$subject = $request->input('subject');
		$message = $request->input('message');
		
		require_once ('/home/ecomps/public_html/app/Http/phpmailer.php');
		
		$mail =  new \App\Http\PHPMailer(true);
		//print_r($mail);exit;
		$mail->IsSMTP();
		$mail->SMTPKeepAlive = true;
		$mail->Host = $host;
		//$mail->SMTPSecure = "ssl";
		
		$mail->SMTPAuth = false;
		$mail->SMTPSecure = false;
		
		$mail->Username = $from_email;
		$mail->Password = $password;		
		$mail->Port       = $port;
		$mail->From = $from_email;
		$mail->FromName = $from_name;
		
		/*$addr = explode(',',$to_email);
		foreach ($addr as $ad) {
			$mail->AddAddress( trim($ad) );       
		}*/
		$mail->AddAddress($to_email);
		
		$mail->IsHTML(true);
		$mail->Subject = $subject;
		$mail->Body    = $message;
		$mail->smtpConnect([
			'ssl' => [
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			]
		]);
		
		if(!$mail->Send()){
			/*echo "<pre>";
			print_r($mail);
			echo $mail->ErrorInfo;
			exit;*/
			return redirect('adminpanel/test-mail')->with('error',$mail->ErrorInfo);
		}
		return redirect('adminpanel/test-mail')->with('msg','success');
    }
	
	public function admin_post_mail_testings_internal(Request $request){
		
		$host = $request->input('host');
		$from_email = $request->input('email');
		$to_email = $request->input('to_email');
		$password = $request->input('password');
		$port = $request->input('port');
		$from_name = $request->input('from_name');
		$subject = $request->input('subject');
		$message = $request->input('message');
		
		require_once base_path('/app/Http/phpmailer.php');
		
		$mail =  new \App\Http\PHPMailer(true);
		//print_r($mail);exit;
		$mail->IsSMTP();
		$mail->SMTPKeepAlive = true;
		$mail->Host = $host;
		//$mail->SMTPSecure = "ssl";
		$mail->SMTPAuth = true;
		$mail->Username = $from_email;
		$mail->Password = $password;		
		$mail->Port       = $port;
		$mail->From = $from_email;
		$mail->FromName = $from_name;
		
		/*$addr = explode(',',$to_email);
		foreach ($addr as $ad) {
			$mail->AddAddress( trim($ad) );       
		}*/
		$mail->AddAddress($to_email);
		
		$mail->IsHTML(true);
		$mail->Subject = $subject;
		$mail->Body    = $message;
		$mail->smtpConnect([
			'ssl' => [
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			]
		]);
		
		if(!$mail->Send()){
			/*echo "<pre>";
			print_r($mail);
			echo $mail->ErrorInfo;
			exit;*/
			return redirect('adminpanel/test-mail')->with('int_error',$mail->ErrorInfo);
		}
		return redirect('adminpanel/test-mail')->with('int_msg','success');
    }
	
	public function testings(){
		echo "ss";exit;
	}
}
