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
		
		$smtpauth = $request->input('smtpauth');
		//$smtpsecure = $request->input('smtpsecure');
		
		require_once base_path('/app/Http/phpmailer.php');
		
		$mail =  new \App\Http\PHPMailer(true);
		
		$mail->IsSMTP();
		$mail->SMTPKeepAlive = true;
		$mail->Host = $host;
		
		if($smtpauth == "false"){
			$mail->SMTPAuth = false;
		}else{
			$mail->SMTPAuth = true;
		}
		/*if($smtpsecure == "false"){
			$mail->SMTPSecure = false;
		}else{
			$mail->SMTPSecure = true;
		}*/
		
		$mail->Username = $from_email;
		$mail->Password = $password;		
		$mail->Port       = $port;
		$mail->From = $from_email;
		$mail->FromName = $from_name;
		
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
			return redirect('adminpanel/test-mail')->with('error',$mail->ErrorInfo);
		}
		return redirect('adminpanel/test-mail')->with('msg','success');
    }
	
	public function admin_post_mail_testings_internal(Request $request){
		
    }
	
	public function testings(){
		echo "ss";exit;
	}
}
