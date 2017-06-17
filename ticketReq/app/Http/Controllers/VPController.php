<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Mail;
use Session;

class VPController extends Controller{
	
	public function __construct(){
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }
	
	public function home_page(){
		
		$ecomps_admin_id = Session::get('ecomps_vp_id');
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		return view('vp-home');
	}
	
	public function pending_request_page(){
		
		$ecomps_admin_id = Session::get('ecomps_vp_id');
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		return view('vp-pending-requests');
	}
	
	public function RequestPageApprover($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_vp_id');
		$is_fulfiler = Session::get('ecomps_user_is_fulfiler');
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		$department = DB::table('department')->orderBy('Name')->pluck('Name', 'id');
		$locationtype = DB::table('locationtype')->orderBy('Name')->pluck('Name', 'id');
		$deliverytype = DB::table('deliverytype')->orderBy('Name')->pluck('Name', 'id');
		
		// 1 = Approve, 4 = Rejected
		$requeststatustype = DB::table('requeststatustype')->orWhere('id', '=', 1)->orWhere('id', '=', 4)->orderBy('Description')->pluck('Description', 'id');
		
		$data = DB::table('request')->where('id', '=', $pk_id)->get();
		return view('vp-requests-view', compact('data','department', 'locationtype', 'deliverytype', 'requeststatustype'));
	}
	
	public function RequestShowonly($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_vp_id');
				
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		$department = DB::table('department')->orderBy('Name')->pluck('Name', 'id');
		$locationtype = DB::table('locationtype')->orderBy('Name')->pluck('Name', 'id');
		$deliverytype = DB::table('deliverytype')->orderBy('Name')->pluck('Name', 'id');
		
		// 1 = Approve, 4 = Rejected
		$requeststatustype = DB::table('requeststatustype')->orWhere('id', '=', 1)->orWhere('id', '=', 4)->orderBy('Description')->pluck('Description', 'id');
		
		$data = DB::table('request')->where('id', '=', $pk_id)->get();
		return view('vp-requests-show', compact('data','department', 'locationtype', 'deliverytype', 'requeststatustype'));
	}
	
	public function vc_post_requests_multi_approved(Request $request){
		//echo "A";exit;
		$ecomps_admin_id = Session::get('ecomps_vp_id');
		$log_approver_name = trim(Session::get('ecomps_vp_name'));
		
		$checkValues = $request->input('checkValues');
		$status = $request->input('status');
		$data = array();
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$Dated = $dt->format('Y-m-d H:i:s');
		
		for($i = 0; $i < count($checkValues); $i++){
			
			$request_id = $checkValues[$i];
			$approver_id = 0;
			
			// Get Requestor Email
			$res_request = DB::table('request')->select('requestor_id')->where('id', $request_id)->get();
			$requestor_id = $res_request[0]->requestor_id;
			$res_user = DB::table('useraccount')->select('EmailAddress','FirstName','LastName')->where('id', $requestor_id)->get();
			$requestor_email = $res_user[0]->EmailAddress;
			$log_requstor_name = trim($res_user[0]->FirstName.' '.$res_user[0]->LastName);
			
			// If Approved
			if($status == "1"){
				
				// Finally move to Fulfil department (is_forward_to_fulfil = 1)
				DB::update('update request set first_approver_status=1,second_approver_status=1,is_forward_to_fulfil=1,is_approve=1,vc_status=1,is_cancel=0,req_prec=1 where id = ?', array($request_id));
				
				// Mail to Requestor
				if($requestor_email != ""){
					app('App\Http\Controllers\HomeController')->sendMail($request_id, 8, $requestor_email);
				}
				// Mail to Requestor
				
				// All Fulfiler
				$to_email = "";
				$res_getmail = DB::select("SELECT EmailAddress FROM useraccount WHERE is_fulfiler=1");
				foreach($res_getmail as $mail){
					$to_email.= ",".$mail->EmailAddress;
				}
				$to_email = substr($to_email, 1);
				
				// Mail
				if($to_email != ""){
					app('App\Http\Controllers\HomeController')->sendMail($request_id, 2, $to_email);
				}
				
				// ECOMPS LOGS
				$logs_type = DB::table('logs_type')->where('id', 7)->get();			
				$descr = str_replace(array('%APPROVER_NAME%','%REQUESTER_NAME%'),array($log_approver_name,$log_requstor_name),$logs_type[0]->name);
				DB::table('logs')->insert(array('user_id'=>$requestor_id,'user_name'=>$log_approver_name,'user_type'=>'vp','request_id'=>$request_id,'descr'=>$descr,'created_date'=>$Dated));
				// ECOMPS LOGS
				
			// If Rejected
			}else{
				
				DB::update('update request set is_cancel=1,vc_status=2,req_prec=3 where id = ?', array($request_id));
				
				// Mail to Requestor
				$approver_lvl = "Vice President";
				if($requestor_email != ""){
					app('App\Http\Controllers\HomeController')->sendMail($request_id, 3, $requestor_email, $approver_lvl);
				}
				// Mail to Requestor
				
				// ECOMPS LOGS
				$logs_type = DB::table('logs_type')->where('id', 8)->get();			
				$descr = str_replace(array('%APPROVER_NAME%','%REQUESTER_NAME%'),array($log_approver_name,$log_requstor_name),$logs_type[0]->name);
				DB::table('logs')->insert(array('user_id'=>$requestor_id,'user_name'=>$log_approver_name,'user_type'=>'vp','request_id'=>$request_id,'descr'=>$descr,'created_date'=>$Dated));
				// ECOMPS LOGS
				
			}
		}
		return "success";exit;
	}
	
	public function Post_VP_RequestPageApprover(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_vp_id');
		$log_approver_name = trim(Session::get('ecomps_vp_name'));
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		$pk_id = $request->input('pk_id');
		$requeststatustype_id = $request->input('requeststatustype_id');
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$Dated = $dt->format('Y-m-d H:i:s');
		
		// Get Requestor Email
		$res_request = DB::table('request')->select('requestor_id')->where('id', $pk_id)->get();
		$requestor_id = $res_request[0]->requestor_id;
		$res_user_email = DB::table('useraccount')->select('EmailAddress','FirstName','LastName')->where('id', $requestor_id)->get();
		$log_requstor_name = trim($res_user_email[0]->FirstName.' '.$res_user_email[0]->FirstName);
		$requestor_email = $res_user_email[0]->EmailAddress;
		
		// 1 = Approve
		if($requeststatustype_id == "1"){
			
			// Finally move to Fulfil department (is_forward_to_fulfil = 1)
			DB::update('update request set first_approver_status=1,second_approver_status=1,is_forward_to_fulfil=1,is_approve=1,vc_status=1,is_cancel=0,req_prec=1 where id = ?', array($pk_id));
			
			// Mail to Requestor
			if($requestor_email != ""){
				app('App\Http\Controllers\HomeController')->sendMail($pk_id, 8, $requestor_email);
			}
			// Mail to Requestor
			
			// All Fulfiler
			$to_email = "";
			$res_getmail = DB::select("SELECT EmailAddress FROM useraccount WHERE is_fulfiler=1");
			foreach($res_getmail as $mail){
				$to_email.= ",".$mail->EmailAddress;
			}
			$to_email = substr($to_email, 1);
			
			// Mail
			if($to_email != ""){
				app('App\Http\Controllers\HomeController')->sendMail($pk_id, 2, $to_email);
			}
			
			$msg = 'This request has been forwarded to Ticket Department';
			
			// ECOMPS LOGS
			$IP = $_SERVER['REMOTE_ADDR'];
			$logs_type = DB::table('logs_type')->where('id', 7)->get();			
			$descr = str_replace(array('%APPROVER_NAME%','%REQUESTER_NAME%'),array($log_approver_name,$log_requstor_name),$logs_type[0]->name);
			DB::table('logs')->insert(array('user_id'=>$requestor_id,'user_name'=>$log_approver_name,'user_type'=>'vp','request_id'=>$pk_id,'descr'=>$descr,'ip'=>$IP,'created_date'=>$Dated));
			// ECOMPS LOGS
			
		}
		
		//4 = Rejected
		if($requeststatustype_id == "4"){
			
			DB::update('update request set is_cancel=1,req_prec=3 where id = ?', array($pk_id));
			$msg = 'This request has been rejected';
			
			// Mail to Requestor
			$to_email = $res_user_email[0]->EmailAddress;
			if($to_email != ""){
				
				// Template 3
				app('App\Http\Controllers\HomeController')->sendMail($pk_id, 3, $to_email, $approver_lvl);
			}
			
			// ECOMPS LOGS
			$logs_type = DB::table('logs_type')->where('id', 8)->get();			
			$descr = str_replace(array('%APPROVER_NAME%','%REQUESTER_NAME%'),array($log_approver_name,$log_requstor_name),$logs_type[0]->name);
			DB::table('logs')->insert(array('user_id'=>$requestor_id,'user_name'=>$log_approver_name,'user_type'=>'vp','request_id'=>$pk_id,'descr'=>$descr,'created_date'=>$Dated));
			// ECOMPS LOGS
			
		}
		
		return redirect('/vp-approve/request/'.$pk_id.'/view/approver')->with('msg', $msg);
	}
	
	public function historypage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_vp_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		return view('vp-history');
	}
	
	public function rejectedhistorypage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_vp_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		return view('vp-rejected-history');
	}
	
	public function RequestPageMessageBoard($request_id){
		
		$ecomps_admin_id = Session::get('ecomps_vp_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		
		// Update read message
		DB::table('request_message')->where('request_id','=',$request_id)->update(array('readby_vp'=>1));
		
		return view('vp-message-board', compact('request_id'));
	}
	
	public function Post_VP_RequestPageMessageBoard(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_vp_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		$request_id = $request->request_id;
		$message = $request->message;
				
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('Y-m-d H:i:s');
		
		DB::table('request_message')->insert(array('request_id'=>$request_id, 'message'=>nl2br($message), 'user_id'=>$ecomps_admin_id, 'created_date'=>$CreateDate));
		return "success";exit;
	}
	
	public function myrequestpage(){
		$ecomps_admin_id = Session::get('ecomps_vp_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		return view('vp-my-requests');
	}
	public function myrequestentrypage($game_id){
		$ecomps_admin_id = Session::get('ecomps_vp_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		$data = DB::table('game')->where('id', $game_id)->get();
		
		$dept_id = Session::get('ecomps_user_dept_id');
		
		//$requesttype = DB::table('requesttype')->where('IsEnabled', 1)->orderBy('name')->pluck('name', 'id');
		$locationtype = DB::table('locationtype')->orderBy('Name')->pluck('Name', 'id');
		$deliverytype = DB::table('deliverytype')->orderBy('Name')->pluck('Name', 'id');
		//$department = DB::table('department')->orderBy('Name')->where('first_approver', '>', 0)->where('id', '=', $dept_id)->pluck('Name', 'id');
		$department = DB::table('department')->where('id', '=', $dept_id)->pluck('Name', 'id');
		
		return view('vp-my-requests-entry', compact('department', 'locationtype', 'deliverytype','game_id'));

	}
	
	public function post_VP_NewRequest(Request $request){
		
		$requestor_id = Session::get('ecomps_vp_id');
		$game_id = $request->game_id;
		$dept_id = $request->dept_id;
		
		$Comp = $request->Comp?$request->Comp:0;
		$Purchased = $request->Purchased?$request->Purchased:0;
		$RecipientFirstName = $request->RecipientFirstName;
		$RecipientLastName = $request->RecipientLastName;
		$Instructions = $request->Instructions;
		$UserComments = $request->UserComments;
		$CompanyName = $request->CompanyName;
		$locationtype_id = $request->locationtype_id;
		$deliverytype_id = $request->deliverytype_id;
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('Y-m-d H:i:s');
		
		$IP = $_SERVER['REMOTE_ADDR'];
		
		$requstor_name = trim(Session::get('ecomps_user_name'));
				
		$id = DB::table('request')->insertGetId(array('requestor_id'=>$requestor_id,'first_approver'=>0,'second_approver'=>0,'req_position'=>0,'dept_id'=>$dept_id, 'game_id'=>$game_id, 'deliverytype_id'=>$deliverytype_id,'locationtype_id'=>$locationtype_id,'Comp'=>$Comp,'Purchased'=>$Purchased,'RecipientFirstName'=>$RecipientFirstName,'RecipientLastName'=>$RecipientLastName,'Instructions'=>$Instructions,'UserComments'=>$UserComments,'CompanyName'=>$CompanyName,'IP'=>$IP,'CreateDate'=>$CreateDate,'LastUpdate'=>$CreateDate,'is_forward_to_fulfil'=>1,'first_approver_status'=>0,'second_approver_status'=>0,'req_prec'=>1));
		
		// ECOMPS LOGS
		$logs_type = DB::table('logs_type')->where('id', 1)->get();
		$IP = $_SERVER['REMOTE_ADDR'];
		$descr = str_replace(array('%REQUESTOR_NAME%'),array($requstor_name),$logs_type[0]->name);
		DB::table('logs')->insert(array('user_id'=>$requestor_id,'user_name'=>$requstor_name,'user_type'=>'vp','request_id'=>$id,'descr'=>$descr,'ip'=>$IP,'created_date'=>$CreateDate));
		// ECOMPS LOGS
				
		// All Fulfiler
		$to_email = "";
		$res_getmail = DB::select("SELECT EmailAddress FROM useraccount WHERE is_fulfiler=1");
		foreach($res_getmail as $mail){
			$to_email.= ",".$mail->EmailAddress;
		}
		$to_email = substr($to_email, 1);
		
		//echo $to_email;exit;
		if($to_email != ""){
			
			// Template 2
			app('App\Http\Controllers\HomeController')->sendMail($id, 2, $to_email);
		}
		// Mail to First Approver
		
		return redirect('vp-approve/game/'.$game_id.'/view')->with('msg','success');
	}
}