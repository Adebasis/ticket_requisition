<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Mail;
use Session;

class ReminderController extends Controller{
	
	public function __construct(){
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }
	
	public function remind_send_remider_emails_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return view('admin.login');
		}
		return view('admin.send-reminder-emails');
	}
	
    public function remind_post_send_remider_emails_page(Request $request){
		
		//return;
		// Identify the HOST
		$smpt = DB::table('smtp')->where('id', '=', 2)->get();
		$host = $smpt[0]->host;
		$from_email = $smpt[0]->email;
		$password = base64_decode($smpt[0]->password);
		$port = $smpt[0]->port;
		$from_name = $smpt[0]->from_name;
		
		set_time_limit(0);
				
		require_once ('/home/ecomps/public_html/app/Http/phpmailer.php');
		//require_once base_path('/app/Http/phpmailer.php');
		
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
		
		//		
		$email_template = DB::table('emailtemplate')->where('id', 14)->get();
		$subject = $email_template[0]->subject;
		$input_admin = $email_template[0]->contents;
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('m/d/Y');
		
		$today = $dt->format('Y-m-d');
		$allgames = DB::table('game')->where('requeststate_id', 3)->where(DB::Raw('DATE(OriginalGameDate)'), '=' , $today)->get();
		$game_ids = "0";
		foreach ($allgames as $index=>$game){
			if($game_ids == "0"){
				$game_ids = $game->id;
			}else{
				$game_ids = $game_ids.",".$game->id;
			}
		}
		
		$noof_email_sent = 0;
		
		// Get all pending requests and send email to 2st approvers (of that department) and VP
		$allreqs = DB::select("SELECT * from request WHERE req_prec=0 and second_approver_status=0 and game_id IN(".$game_ids.")");				
		if(count($allreqs) > 0){
						
			foreach ($allreqs as $index=>$reqs){
				
				// Get department of the request
				$dept_id = $reqs->dept_id;
				
				// Get request id
				$request_id = $reqs->id;
				
				$to_email = "";
				
				// If request is sent to VP
				if($reqs->sent_to_vc == "1"){
					
					$res_getmail = DB::select("SELECT EmailAddress FROM useraccount WHERE is_vp=1");
					foreach($res_getmail as $mail){
						$to_email.= ",".$mail->EmailAddress;
						$noof_email_sent++;
					}
					$to_email = substr($to_email, 1);
				}else{
					
					// Check 1st approver is exist or not in that department
					// If available then mail sent to 1st approver
					// Also check the approve statas, If not then sent to 1st approver					
					// Otherwise sent to 2nd approvers
					if($reqs->first_approver > 0 && $reqs->first_approver_status == "0"){
						
						// 1st Level of Approver
						$res_getmail = DB::select("SELECT EmailAddress FROM useraccount WHERE approver_level=1 and dept_id='".$dept_id."'");
						
						if(count($res_getmail) > 0){
							foreach($res_getmail as $mail){
								$to_email.= ",".$mail->EmailAddress;
								$noof_email_sent++;
							}
						}
					}
					
					// Check 2nd approvers is exist or not in that department
					// If available then mail sent to 2nd approvers
					if($reqs->second_approver > 0 && $reqs->second_approver_status == "0"){
						
						// All 2nd Level of Approvers
						$res_getmail = DB::select("SELECT EmailAddress FROM useraccount WHERE approver_level=2 and find_in_set(".$dept_id.", dept_second_approver)");
						foreach($res_getmail as $mail){
							$to_email.= ",".$mail->EmailAddress;
							$noof_email_sent++;
						}
						$to_email = substr($to_email, 1);
					}
				}
				
				$link = url('/').'/request/'.$request_id.'/public/view';
				
				$game_date = date('m/d/Y h:i A', strtotime(getDataFromTable("game","OriginalGameDate","id", $reqs->game_id)));
				$demand_type = getDataFromTable("locationtype","Name","id", $reqs->locationtype_id);
				
				$opponent = "";
				$res_teamid = DB::table('game')->select('team_id')->where('id', $reqs->game_id)->get();
				$team_id = $res_teamid[0]->team_id;
				if($team_id > 0){
					$res_team = DB::table('team')->select('Name')->where('id', $team_id)->get();
					$opponent = $res_team[0]->Name;
				}
				$requestor = "";
				$requester = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $reqs->requestor_id);
				if(count($requester) > 0){
					$requestor = $requester->FirstName.' '.$requester->LastName;
				}
				
				$recepient = $reqs->RecipientFirstName.' '.$reqs->RecipientLastName;
				$type = getDataFromTable("deliverytype","Name","id", $reqs->deliverytype_id);
				$submitted_date = date('m/d/Y h:i A', strtotime($reqs->CreateDate));
				$comps = $reqs->Comp;
				$Purchased = $reqs->Purchased;
				$total = $comps + $Purchased;
				
				$approver_lvl = "";
				
				$email_body = str_replace(array('%LINK%','%GAME_DATE%','%DEMAND_TYPE%','%OPPONENT%','%REQUESTER%','%RECIPIENT%','%TYPE%','%SUBMITTED_DATE%','%COMP%','%PURCHASED%','%TOTAL%','%APPROVER_LEVEL%'),array($link,$game_date,$demand_type,$opponent,$requestor,$recepient,$type,$submitted_date,$comps,$Purchased,$total,$approver_lvl),$input_admin);
				
				// Check email addresses are not empty
				if($to_email != ""){
				
					$addr = explode(',',$to_email);
					foreach ($addr as $ad) {
						$mail->AddAddress( trim($ad) );       
					}
									
					$mail->IsHTML(true);
					$mail->Subject = $subject;
					$mail->Body    = $email_body;
					$mail->smtpConnect([
						'ssl' => [
							'verify_peer' => false,
							'verify_peer_name' => false,
							'allow_self_signed' => true
						]
					]);
					$mail->Send();
				}
			}
		}
		
		
		$allreqs = DB::select("SELECT * from request WHERE is_forward_to_fulfil=1 and game_id IN(".$game_ids.")");				
		if(count($allreqs) > 0){
						
			foreach ($allreqs as $index=>$reqs){
												
				// Get All VP email if First Approver not available
				$res_getmail = DB::select("SELECT EmailAddress FROM useraccount WHERE is_fulfiler=1");
				$to_email = "";
				foreach($res_getmail as $mail){
					$to_email.= ",".$mail->EmailAddress;
					$noof_email_sent++;
				}
				$to_email = substr($to_email, 1);
				
				$request_id = $reqs->id;
				
				$link = url('/').'/request/'.$request_id.'/public/view';
				
				$game_date = date('m/d/Y h:i A', strtotime(getDataFromTable("game","OriginalGameDate","id", $reqs->game_id)));
				$demand_type = getDataFromTable("locationtype","Name","id", $reqs->locationtype_id);
				
				$opponent = "";
				$res_teamid = DB::table('game')->select('team_id')->where('id', $reqs->game_id)->get();
				$team_id = $res_teamid[0]->team_id;
				if($team_id > 0){
					$res_team = DB::table('team')->select('Name')->where('id', $team_id)->get();
					$opponent = $res_team[0]->Name;
				}
				$requestor = "";
				$requester = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $reqs->requestor_id);
				if(count($requester) > 0){
					$requestor = $requester->FirstName.' '.$requester->LastName;
				}
				
				$recepient = $reqs->RecipientFirstName.' '.$reqs->RecipientLastName;
				$type = getDataFromTable("deliverytype","Name","id", $reqs->deliverytype_id);
				$submitted_date = date('m/d/Y h:i A', strtotime($reqs->CreateDate));
				$comps = $reqs->Comp;
				$Purchased = $reqs->Purchased;
				$total = $comps + $Purchased;
				
				$approver_lvl = "";
				
				$email_body = str_replace(array('%LINK%','%GAME_DATE%','%DEMAND_TYPE%','%OPPONENT%','%REQUESTER%','%RECIPIENT%','%TYPE%','%SUBMITTED_DATE%','%COMP%','%PURCHASED%','%TOTAL%','%APPROVER_LEVEL%'),array($link,$game_date,$demand_type,$opponent,$requestor,$recepient,$type,$submitted_date,$comps,$Purchased,$total,$approver_lvl),$input_admin);
				
				// Check email addresses are not empty
				if($to_email != ""){
				
					$addr = explode(',',$to_email);
					foreach ($addr as $ad) {
						$mail->AddAddress( trim($ad) );       
					}
									
					$mail->IsHTML(true);
					$mail->Subject = $subject;
					$mail->Body    = $email_body;
					$mail->smtpConnect([
						'ssl' => [
							'verify_peer' => false,
							'verify_peer_name' => false,
							'allow_self_signed' => true
						]
					]);
					$mail->Send();
				}
			}
		}
		
		// Save in logs table
		
		
		$ecomps_admin_id = trim(Session::get('ecomps_admin_id'));
		$user_type = trim(Session::get('ecomps_front_user_is_admin'));
		if($user_type == "yes"){
			$user_type = "user";
		}else{
			$user_type = "admin";
		}
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('Y-m-d H:i:s');
		
		DB::table('reminder_logs')->insertGetId(array('user_id'=>$ecomps_admin_id,'user_type'=>$user_type,'submitted_date'=>$CreateDate,'noof_email_sent'=>$noof_email_sent));
		
		return redirect('adminpanel/send-reminder-emails')->with('msg','success');
    }
	
	public function remind_send_remider_delete($id){
		
		DB::table('reminder_logs')->where('id', '=', $id)->delete();
		return redirect('adminpanel/send-reminder-emails');
	}
	
}