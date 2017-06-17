<?php
//
// req_prec on request table
// 0 = Pending
// 1 = approve
// 2 = fulfil
// 3 = reject/cancel
// 4 = user cancel
//
//
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Mail;
use Session;
use adLDAP;

require_once base_path('/vendor/ldap/adLDAP.php');

class HomeController extends Controller{
	
	public function __construct(){
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }
	
	public function profilepage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_user_id');
		
		if(trim($ecomps_admin_id) == ""){
			return view('login');
		}
		
		return view('profile');
	}
	
	public function changepasswordpage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_user_id');
		
		if(trim($ecomps_admin_id) == ""){
			return view('login');
		}
		
		return view('change-password');
	}
	
	public function ChangePassword(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_user_id');
		
		$old_pass = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($request->input('old_pass'))))));
		$new_pass = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($request->input('new_pass'))))));;
		
		$count = DB::table('useraccount')->where('password', '=', $old_pass)->count();
		if($count > 0){
			
			DB::table('useraccount')->where('id','=', $ecomps_admin_id)->update(array('password'=>$new_pass));
			
			return redirect('account/change-password')->with('msg','');
		}else{
			return redirect('account/change-password')->with('errmsg','');
		}		
	}
	
	public function loginpage(Request $request){
		
		//echo base64_decode(base64_decode(base64_decode(base64_decode(base64_decode('VjFkNGIyTXlTWGxUV0hCWFltNUNhRlpXVVhkUFVUMDk=')))));exit;
		//echo base64_encode(base64_encode(base64_encode(base64_encode(base64_encode('Met$2017')))));exit;
		$ecomps_admin_id = Session::get('ecomps_user_id');
		$ecomps_vp_id = Session::get('ecomps_vp_id');
		
		if(trim($ecomps_vp_id) != ""){
			return view('vp-home');
		}
		
		$approver_level =  Session::get('ecomps_user_approver_level');
		
		if($ecomps_admin_id == ""){
			return view('login');
		}
		
		if(trim($approver_level) == "second"){
			return view('history-approvers');
		}else if(trim($ecomps_vp_id) != ""){
			return view('vp-home');
		}else{
			return view('default');
		}
		
		return view('default');
	}
	
	public function usernameToGuid($username){
        $this->adldap->utilities()->validateNotNull('Username', $username);
        $this->adldap->utilities()->validateLdapIsBound();
        $filter = $this->adldap->getUserIdKey().'='.$username;
        $fields = array('objectGUID');
        $results = $this->connection->search($this->adldap->getBaseDn(), $filter, $fields);
        $numEntries = $this->connection->countEntries($results);
        if ($numEntries > 0) {
            $entry = $this->connection->getFirstEntry($results);
            $guid = $this->connection->getValuesLen($entry, 'objectGUID');
            $strGUID = $this->adldap->utilities()->binaryToText($guid[0]);
            return $strGUID;
        }
        return false;
    }
	
	public function GUIDtoStr($binary_guid) {
		//$unpacked = unpack('Va/v2b/n2c/Nd', $binary_guid);
		//print_r($unpacked);exit;
		//return sprintf('%08X-%04X-%04X-%04X-%04X%08X', $unpacked['a'], $unpacked['b1'], $unpacked['b2'], $unpacked['c1'], $unpacked['c2'], $unpacked['d']);
		
		$hex_guid = unpack("H*hex", $binary_guid); 
		  $hex = $hex_guid["hex"];
		  
		  $hex1 = substr($hex, -26, 2) . substr($hex, -28, 2) . substr($hex, -30, 2) . substr($hex, -32, 2);
		  $hex2 = substr($hex, -22, 2) . substr($hex, -24, 2);
		  $hex3 = substr($hex, -18, 2) . substr($hex, -20, 2);
		  $hex4 = substr($hex, -16, 4);
		  $hex5 = substr($hex, -12, 12);
		
		  $guid_str = $hex1 . "-" . $hex2 . "-" . $hex3 . "-" . $hex4 . "-" . $hex5;
		
		  return $guid_str;
		
	}
	
	public function postLogin(Request $request){
		
		$username = $request->input('txtUsername');
		$password = $request->input('txtPassword');
		
		// AD Congfiguration
		/*$config = array(
						'account_suffix' => "@ny-mets.com",
						'domain_controllers' => array("mets2k12pdc01.ny-mets.com"),
						'base_dn' => 'dc=ny-mets,dc=com',
						'admin_username' => 'mwashington',
						'admin_password' => 'reboot2016',
					);
    	$adldap = new adLDAP($config);
		
		//echo $adldap->user()->username2guid($username);exit;
		
		//$userinfo = $adldap->user()->info($username, array('objectguid'));
		//echo '<pre>';
		//print_r($userinfo);exit;
		
		//echo strtoupper($this->GUIDtoStr($userinfo[0]['objectguid'][0]));exit;
		//echo $objectGUID = strtoupper(implode('\\', str_split(bin2hex($userinfo[0]['objectguid'][0]), 2)));exit;
		//$guid = $adldap->decodeGuid($userinfo[0]['objectguid'][0]);
		//print_r($guid);
		
		//exit;
		
		//echo '<pre>';
		//$result=$adldap->user()->infoCollection("mwashington", array("*"));
		//print_r($result);exit;
		
		// Authenicate
		$result = $adldap->authenticate($username, $password);
		print_r($result);exit;
		
		*/
		
		$login_password = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($request->input('txtPassword'))))));
		
		$users = DB::table('useraccount')->where('EmailAddress', $username)->where('password', $login_password)->where('is_deleted', 0)->get();
		
		if(count($users) > 0){
			
			$dept = DB::table("department")->where("id", $users[0]->dept_id)->get();
			
			// If subadmin
			$front_user_is_admin = 'no';
			$is_subadmin = DB::table("subadmin")->where("user_id", $users[0]->id)->count();
			if($is_subadmin > 0){
				$front_user_is_admin = 'yes';
				Session::set('ecomps_subadmin', 'yes');
				Session::set('ecomps_front_user', 'yes');
				Session::set('ecomps_admin_id', $users[0]->id);
				Session::set('ecomps_user_name', $users[0]->FirstName.' '.$users[0]->LastName);
				Session::set('ecomps_user_full_name', $users[0]->FirstName.' '.$users[0]->LastName);
			}
			
			// If is_vp = 1
			if($users[0]->is_vp == "1"){
				Session::set('ecomps_vp_id', $users[0]->id);
				Session::set('ecomps_vp_name', $users[0]->FirstName.' '.$users[0]->LastName);
				
				Session::set('ecomps_user_name', $users[0]->FirstName.' '.$users[0]->LastName);
				Session::set('ecomps_user_dept_id', $users[0]->dept_id);
				Session::set('ecomps_user_deptname', $dept[0]->Name);
				
				// Redirect to dashboad
				return redirect('/vp-approve');
			}
			
			Session::set('ecomps_user_id', $users[0]->id);
			Session::set('ecomps_user_name', $users[0]->FirstName.' '.$users[0]->LastName);
			Session::set('ecomps_user_dept_id', $users[0]->dept_id);
			Session::set('ecomps_user_deptname', $dept[0]->Name);
			//Session::set('ecomps_front_user', 'no');
															
			$approver_level = 0;
			if($users[0]->approver_level == "1"){
				$approver_level = 'first';
			}
			if($users[0]->approver_level == "2"){
				$approver_level = 'second';
			}
			
			$approver_no_of_level = 0;
			if($dept[0]->first_approver > 0){
				$approver_no_of_level = $approver_no_of_level + 1;
			}
			if($users[0]->dept_second_approver != ""){
				$approver_no_of_level = $approver_no_of_level + 1;
			}
			
			$is_fulfiler = 0;
			if($users[0]->is_fulfiler != "0"){
				$is_fulfiler = 1;
			}
			
			Session::set('ecomps_user_no_of_approver_level', $approver_no_of_level);
			Session::set('ecomps_user_approver_level', $approver_level);
			Session::set('ecomps_user_first_approver', $dept[0]->first_approver);
			Session::set('ecomps_user_second_approver', $dept[0]->second_approver);
			Session::set('ecomps_user_is_fulfiler', $is_fulfiler);
			Session::set('ecomps_front_user_is_admin', $front_user_is_admin);
			
			// Redirect to dashboad
			return redirect('default');
			
		}else{
			return redirect('/')->with('error', 'The credentials provided do not match an existing, active account.');
		}		
	}
	
	public function logout(){
		
		Session::forget('ecomps_user_id');
		Session::forget('ecomps_user_name');
		
		Session::forget('ecomps_user_dept_id');
		Session::forget('ecomps_user_deptname');
		Session::forget('ecomps_user_approver_level');
		Session::forget('ecomps_user_no_of_approver_level');
		Session::forget('ecomps_user_first_approver');
		Session::forget('ecomps_user_second_approver');
		
		Session::forget('ecomps_front_user');
		Session::forget('ecomps_admin_id');
		Session::forget('ecomps_front_user_is_admin');
		Session::forget('ecomps_user_name');
		Session::forget('ecomps_user_full_name');
		
		Session::forget('ecomps_vp_id');
		Session::forget('ecomps_vp_name');
		
		return redirect('/');
	}
	
	public function resetpasswordpage(){
		return view('password');
	}
	
	public function postResetPassword(Request $request){
		
		$txtUsername = $request->txtUsername;
		$txtNewPassword = $this->random_password(8);
		$users = DB::table('useraccount')->where('EmailAddress', $txtUsername)->get();
		
		if(count($users) > 0){
			
			$txtNewPassword = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($txtNewPassword)))));
			
			DB::table('useraccount')->where('EmailAddress','=',$txtUsername)->update(array('password'=>$txtNewPassword));
			
			// Mail to user to sent out the password
			$this->sendMail(0, 4, $txtUsername);
			
			return redirect('/reset/password')->with('msg','Your password has been sent !!!');
		}else{
			return redirect('/reset/password')->with('error', 'Email address do not match an existing, active account.');
		}
	}
	
	public function random_password( $length = 8 ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
		$password = substr( str_shuffle( $chars ), 0, $length );
		return $password;
	}
	
	public function newRequest(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_user_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		
		$dept_id = Session::get('ecomps_user_dept_id');
		
		//$requesttype = DB::table('requesttype')->where('IsEnabled', 1)->orderBy('name')->pluck('name', 'id');
		$locationtype = DB::table('locationtype')->orderBy('Name')->pluck('Name', 'id');
		$deliverytype = DB::table('deliverytype')->orderBy('Name')->pluck('Name', 'id');
		//$department = DB::table('department')->orderBy('Name')->where('first_approver', '>', 0)->where('id', '=', $dept_id)->pluck('Name', 'id');
		$department = DB::table('department')->where('id', '=', $dept_id)->pluck('Name', 'id');
		
		return view('requests-entry', compact('department', 'locationtype', 'deliverytype'));
	}
	
	public function postNewRequest(Request $request){
		
		$requestor_id = Session::get('ecomps_user_id');
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
		
		$CreateDate = date('Y-m-d H:i:s');
		$IP = $this->get_client_ip();
		
		$approver_level = trim(Session::get('ecomps_user_approver_level'));
		$front_user_is_admin = trim(Session::get('ecomps_front_user_is_admin'));
		$requstor_name = trim(Session::get('ecomps_user_name'));
		$first_approver = 0;
		$second_approver = 0;
		$first_approver_status = 0;
		$second_approver_status = 0;
		$is_forward_to_fulfil = 0;
		
		// 0 = Normal
		if($approver_level == "0"){
			$first_approver = trim(Session::get('ecomps_user_first_approver'));
			$req_position = 1;
		}else if($approver_level == "first"){
			$second_approver = trim(Session::get('ecomps_user_second_approver'));
			$first_approver_status = 1;
			$req_position = 2;
		}else if($approver_level == "second"){
			$first_approver_status = 1;
			$second_approver_status = 1;
			$is_forward_to_fulfil = 1;
			$req_position = 0;
		}
		if($front_user_is_admin == "yes"){
			$first_approver_status = 1;
			$second_approver_status = 1;
			$is_forward_to_fulfil = 1;
			$req_position = 0;
		}
		$id = DB::table('request')->insertGetId(array('requestor_id'=>$requestor_id,'first_approver'=>$first_approver,'second_approver'=>$second_approver,'req_position'=>$req_position,'dept_id'=>$dept_id, 'game_id'=>$game_id, 'deliverytype_id'=>$deliverytype_id,'locationtype_id'=>$locationtype_id,'Comp'=>$Comp,'Purchased'=>$Purchased,'RecipientFirstName'=>$RecipientFirstName,'RecipientLastName'=>$RecipientLastName,'Instructions'=>$Instructions,'UserComments'=>$UserComments,'CompanyName'=>$CompanyName,'IP'=>$IP,'CreateDate'=>$CreateDate,'LastUpdate'=>$CreateDate,'is_forward_to_fulfil'=>$is_forward_to_fulfil,'first_approver_status'=>$first_approver_status,'second_approver_status'=>$second_approver_status));
		//$id = 476;
		
		// ECOMPS LOGS
		$logs_type = DB::table('logs_type')->where('id', 1)->get();
		$descr = str_replace(array('%REQUESTOR_NAME%'),array($requstor_name),$logs_type[0]->name);
		
		DB::table('logs')->insert(array('user_id'=>$requestor_id,'user_name'=>$requstor_name,'user_type'=>'user','request_id'=>$id,'descr'=>$descr,'ip'=>$IP,'created_date'=>$CreateDate));
		// ECOMPS LOGS
		
		// Mail to First Approver
		$to_email = "";
		
		// If User is Admin, then mail will be sent to fulfiller
		if($front_user_is_admin == "yes"){
			
			// All Fulfiler
			$res_getmail = DB::select("SELECT EmailAddress FROM useraccount WHERE is_fulfiler=1");
			foreach($res_getmail as $mail){
				$to_email.= ",".$mail->EmailAddress;
			}
			$to_email = substr($to_email, 1);
		}else{
			
			
			if($approver_level == "0"){
				
				$first_approver = trim(Session::get('ecomps_user_first_approver'));
				
				// If First Approver available
				if($first_approver > 0){
					
					// Get First Approver email
					$res_getmail = DB::table('useraccount')->select('EmailAddress')->where('id', $first_approver)->get();
					$to_email = $res_getmail[0]->EmailAddress;
					
					// Mail to requestor for confirmation
					$res_login_user_mail = DB::select("SELECT EmailAddress FROM useraccount WHERE id='".$requestor_id."'");
					$to_login_user_email = $res_login_user_mail[0]->EmailAddress;
					if($to_login_user_email != ""){
						
						// Template 10
						$this->sendMail($id, 10, $to_login_user_email);
					}
				}else{
					
					// Get All VP email if First Approver not available
					$res_getmail = DB::select("SELECT EmailAddress FROM useraccount WHERE is_vp=1");
					foreach($res_getmail as $mail){
						$to_email.= ",".$mail->EmailAddress;
					}
					$to_email = substr($to_email, 1);
					
					
					// Update status for sent_to_vc
					DB::update('update request set sent_to_vc = 1 where id = ?', array($id));
				}
				
			}else if($approver_level == "first"){
				
				// All 2nd Level of Approvers
				$res_getmail = DB::select("SELECT EmailAddress FROM useraccount WHERE approver_level=2 and find_in_set(".$dept_id.", dept_second_approver)");
				foreach($res_getmail as $mail){
					$to_email.= ",".$mail->EmailAddress;
				}
				$to_email = substr($to_email, 1);
				
			}else if($approver_level == "second"){
				
				// All Fulfiler
				$res_getmail = DB::select("SELECT EmailAddress FROM useraccount WHERE is_fulfiler=1");
				foreach($res_getmail as $mail){
					$to_email.= ",".$mail->EmailAddress;
				}
				$to_email = substr($to_email, 1);
			}
		}
		
		//echo $to_email;exit;
		if($to_email != ""){
			
			// Template 2
			$this->sendMail($id, 2, $to_email);
		}
		// Mail to First Approver
		
		return redirect('game/'.$game_id.'/view')->with('msg','success');
	}
	
	public function RequestPageEdit($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_user_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		$department = DB::table('department')->orderBy('Name')->pluck('Name', 'id');
		$locationtype = DB::table('locationtype')->orderBy('Name')->pluck('Name', 'id');
		$deliverytype = DB::table('deliverytype')->orderBy('Name')->pluck('Name', 'id');
		$data = DB::table('request')->where('id', '=', $pk_id)->get();
		return view('requests-edit', compact('data','department', 'locationtype', 'deliverytype'));
	}
	
	public function RequestPageApprover_public($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_user_id');
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		
		$data = DB::table('request')->where('id', '=', $pk_id)->get();
		
		if($ecomps_admin_id == ""){
			return view('requests-view-public', compact('data'));
		}else{
			return $this->RequestPageApprover($pk_id);
		}
	}
	
	public function RequestPageApprover($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_user_id');
		$is_fulfiler = Session::get('ecomps_user_is_fulfiler');
		$dept_id = Session::get('ecomps_user_dept_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		$department = DB::table('department')->orderBy('Name')->pluck('Name', 'id');
		$locationtype = DB::table('locationtype')->orderBy('Name')->pluck('Name', 'id');
		$deliverytype = DB::table('deliverytype')->orderBy('Name')->pluck('Name', 'id');
						
		if($dept_id == "4" && $is_fulfiler == "1"){
			$requeststatustype = DB::table('requeststatustype')->where('id', '=', 2)->orderBy('Description')->pluck('Description', 'id');
		}else{
			// 1 = Approve, 4 = Rejected
			$requeststatustype = DB::table('requeststatustype')->orWhere('id', '=', 1)->orWhere('id', '=', 4)->orderBy('Description')->pluck('Description', 'id');
		}
		
		//print_r($requeststatustype);exit;
		
		$data = DB::table('request')->where('id', '=', $pk_id)->get();
		return view('requests-view', compact('data','department', 'locationtype', 'deliverytype', 'requeststatustype'));
	}
	
	public function Post_RequestPageApprover(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_user_id');
		$log_approver_name = trim(Session::get('ecomps_user_name'));
		
		// If 1st Level, then forwarded to second level
		$user_approver_level = Session::get('ecomps_user_approver_level');
				
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		
		$pk_id = $request->input('pk_id');
		$Dated = date('Y-m-d H:i:s');		
		$dept_id = Session::get('ecomps_user_dept_id');
		$IP = $this->get_client_ip();
		$to_email = "";
		
		// Get Requestor Email
		$res_request = DB::table('request')->select('requestor_id')->where('id', $pk_id)->get();
		$requestor_id = $res_request[0]->requestor_id;
		$res_user_email = DB::table('useraccount')->select('EmailAddress','FirstName','LastName')->where('id', $requestor_id)->get();
		$log_requstor_name = trim($res_user_email[0]->FirstName.' '.$res_user_email[0]->LastName);
		
		// If Cancel By Requestor of his own request
		// Check First approver approved then mail to First approver
		// Check Second approver approved then mail to all 2nd level of approvers of his department (Belongs to current department)
		// 
		$is_cancel = $request->input('is_cancel');
		if($is_cancel == "yes"){
			
			DB::update("update request set req_prec=4,user_cancel = '1' where id = ?", array($pk_id));
			$msg = 'Your request has been cancelled successfully.';
			
			// ECOMPS LOGS
			$logs_type = DB::table('logs_type')->where('id', 9)->get();
			$descr = str_replace(array('%REQUESTER_NAME%'),array($log_requstor_name),$logs_type[0]->name);
			DB::table('logs')->insert(array('user_id'=>$requestor_id,'user_name'=>$log_approver_name,'user_type'=>'user','request_id'=>$pk_id,'descr'=>$descr,'ip'=>$IP,'created_date'=>$Dated));
			// ECOMPS LOGS
			
			return redirect('/request/'.$pk_id.'/view/approver')->with('msg', $msg);
		}
		//
		
		$requeststatustype_id = $request->input('requeststatustype_id');
				
		// 1 = Approve
		if($requeststatustype_id == "1"){
			
			// If No of approver is 0/1 then direct forwarded to Fulfuiller department
			// Get dept_id from request table
			$res_req = DB::select("SELECT dept_id FROM request where id='".$pk_id."'");
			$tmp_dept_id = 0;
			if(count($res_req) > 0){
				$tmp_dept_id = $res_req[0]->dept_id;
			}
			$res_user = DB::select("SELECT id FROM `useraccount` WHERE find_in_set(".$tmp_dept_id.", `dept_second_approver`)");
			
			$no_of_approver_level =  "";
			if(count($res_user) > 0){
				$no_of_approver_level = $res_user[0]->id;
			}
			
			$to_email = "";
			if($no_of_approver_level == ""){
				
				// Finally move to Fulfil department (is_forward_to_fulfil = 1)
				DB::update('update request set is_forward_to_fulfil = 1,first_approver_status=1,second_approver_status=1,req_prec=1 where id = ?', array($pk_id));
				$msg = 'This request has been forwarded to Ticket Department';
				
				// All Fulfiler
				$res_getmail = DB::select("SELECT EmailAddress FROM useraccount WHERE is_fulfiler=1");
				foreach($res_getmail as $mail){
					$to_email.= ",".$mail->EmailAddress;
				}
				$to_email = substr($to_email, 1);
				
			}else{
												
				if($user_approver_level == "first"){
					
					$approver_id = Session::get('ecomps_user_second_approver');
					
					DB::update('update request set first_approver_status=1,req_position=2 where id = ?', array($pk_id));
					$msg = 'This request has been approved and forwarded to second level of Approver';
					
					
					// All 2nd Level of Approvers
					$res_getmail = DB::select("SELECT EmailAddress FROM useraccount WHERE approver_level=2 and find_in_set(".$dept_id.", dept_second_approver)");
					foreach($res_getmail as $mail){
						$to_email.= ",".$mail->EmailAddress;
					}
					$to_email = substr($to_email, 1);					
					
					
					// Mail to Requestor when 1st Approver approved
					$requestor_email = $res_user_email[0]->EmailAddress;
					if($requestor_email != ""){
						
						// Template 6
						$this->sendMail($pk_id, 6, $requestor_email);
					}
					// Mail to Requestor when 1st Approver approved
					
					// ECOMPS LOGS
					$logs_type = DB::table('logs_type')->where('id', 2)->get();
					$descr = str_replace(array('%APPROVER_NAME%','%REQUESTER_NAME%'),array($log_approver_name,$log_requstor_name),$logs_type[0]->name);
					DB::table('logs')->insert(array('user_id'=>$requestor_id,'user_name'=>$log_approver_name,'user_type'=>'first','request_id'=>$pk_id,'descr'=>$descr,'ip'=>$IP,'created_date'=>$Dated));
					// ECOMPS LOGS
					
				}
				// If 2nd Level and no of approver 2, then forwarded to Fulfuiller department
				if($user_approver_level == "second"){
					
					// Finally move to Fulfil department (is_forward_to_fulfil = 1)
					DB::update('update request set is_forward_to_fulfil = 1,second_approver_status=1,req_prec=1 where id = ?', array($pk_id));
					$msg = 'This request has been forwarded to Ticket Department';
					
					// Mail to Requestor when 2nd Approver approved
					$requestor_email = $res_user_email[0]->EmailAddress;
					if($requestor_email != ""){
						
						// Template 7
						$this->sendMail($pk_id, 7, $requestor_email);
					}
					// Mail to Requestor when 2nd Approver approved
					
					// ECOMPS LOGS
					$logs_type = DB::table('logs_type')->where('id', 3)->get();
					$descr = str_replace(array('%APPROVER_NAME%','%REQUESTER_NAME%'),array($log_approver_name,$log_requstor_name),$logs_type[0]->name);
					DB::table('logs')->insert(array('user_id'=>$requestor_id,'user_name'=>$log_approver_name,'user_type'=>'second','request_id'=>$pk_id,'descr'=>$descr,'ip'=>$IP,'created_date'=>$Dated));
					// ECOMPS LOGS
					
					// All Fulfiler
					$res_getmail = DB::select("SELECT EmailAddress FROM useraccount WHERE is_fulfiler=1");
					foreach($res_getmail as $mail){
						$to_email.= ",".$mail->EmailAddress;
					}
					$to_email = substr($to_email, 1);
					
				}
			}
			DB::update('update request set is_approve=1 where id = ?', array($pk_id));
			
			// Mail
			if($to_email != ""){
				
				// Template 2
				$this->sendMail($pk_id, 2, $to_email);
			}
			
		}
		
		//4 = Rejected
		if($requeststatustype_id == "4"){
			
			$approver_lvl = "";
			
			// If 1st Level rejected
			if(Session::get('ecomps_user_approver_level') == "first"){
				DB::update("update request set first_approver_status = '2' where id = ?", array($pk_id));
				$approver_lvl = "First Level of Approver";
				
				$logs_type = DB::table('logs_type')->where('id', 4)->get();
				$logs_user_type = 'first';
			}
			// If 2nd Level rejected
			if(Session::get('ecomps_user_approver_level') == "second" && Session::get('ecomps_user_no_of_approver_level') == "2"){
				DB::update("update request set second_approver_status = '2' where id = ?", array($pk_id));
				$approver_lvl = "Second Level of Approver";
				
				$logs_type = DB::table('logs_type')->where('id', 5)->get();
				$logs_user_type = 'second';
			}
			DB::update('update request set is_cancel=1,req_prec=3 where id = ?', array($pk_id));
			$msg = 'This request has been rejected';
			
			// Mail to Requestor
			$to_email = $res_user_email[0]->EmailAddress;
			if($to_email != ""){
				
				// Template 3
				$this->sendMail($pk_id, 3, $to_email, $approver_lvl);
			}
			
			// ECOMPS LOGS
			$descr = str_replace(array('%APPROVER_NAME%','%REQUESTER_NAME%'),array($log_approver_name,$log_requstor_name),$logs_type[0]->name);
			DB::table('logs')->insert(array('user_id'=>$requestor_id,'user_name'=>$log_approver_name,'user_type'=>$logs_user_type,'request_id'=>$pk_id,'descr'=>$descr,'ip'=>$IP,'created_date'=>$Dated));
			// ECOMPS LOGS
			
		}
		
		//2 = Fulfil
		if($requeststatustype_id == "2"){
			
			// Last Level
			DB::update('update request set is_forward_to_fulfil=0, is_fulfil = 1,req_prec=2,fulfil_by='.$ecomps_admin_id.',fulfil_date=now() where id = ?', array($pk_id));
			$msg = 'This request has been fulfilled';
			
			// Mail to Requestor
			$to_email = $res_user_email[0]->EmailAddress;
			if($to_email != ""){
				
				// Template 1
				$this->sendMail($pk_id, 1, $to_email);
			}
			
			// ECOMPS LOGS
			$logs_type = DB::table('logs_type')->where('id', 6)->get();
			$descr = str_replace(array('%FULFILLER_NAME%','%REQUESTER_NAME%'),array($log_approver_name,$log_requstor_name),$logs_type[0]->name);
			DB::table('logs')->insert(array('user_id'=>$requestor_id,'user_name'=>$log_approver_name,'user_type'=>'fulfiler','request_id'=>$pk_id,'descr'=>$descr,'ip'=>$IP,'created_date'=>$Dated));
			// ECOMPS LOGS
			
		}
				
		return redirect('/request/'.$pk_id.'/view/approver')->with('msg', $msg);
	}
	
	public function homepage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_user_id');
		$approver_level =  trim(Session::get('ecomps_user_approver_level'));
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		
		if($approver_level == "second"){
			return redirect('chart');
		}else{
			return view('default');
		}
	}
	
	public function aboutpage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		return view('about');
	}
	
	public function historypage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_user_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		
		$dept_id = Session::get('ecomps_user_dept_id');
		$approver_level =  Session::get('ecomps_user_approver_level');
		$is_fulfiler = Session::get('ecomps_user_is_fulfiler');
		
		$search = $request->input('search');
		
		// 4 = Ticket Department
		//echo $approver_level;
		/*if($approver_level == "0"){
			return view('history-normal-users', compact('search'));
		
		// Approvers
		}else{			
			return view('history-approvers', compact('search'));
			
		}*/
		
		if($dept_id == "4" && $is_fulfiler == "1"){
			
			return view('history-ticket-department', compact('data', 'department', 'requeststatustype', 'useraccount', 'team', 'years'));
		
		// Normal Requester
		}else if($approver_level == "0"){
			return view('history-normal-users', compact('search'));
		
		// Approvers
		}else{			
			return view('history-approvers', compact('search'));
			
		}
		
	}
	
	public function front_post_requests_multi_approved(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_user_id');
		
		$checkValues = $request->input('checkValues');
		$status = $request->input('status');
		$data = array();
		$Dated = date('Y-m-d H:i:s');
		$to_email = "";
		
		for($i = 0; $i < count($checkValues); $i++){
			
			$request_id = $checkValues[$i];	
			$approver_id = 0;
			
			// Get Requestor Email
			$res_request = DB::table('request')->select('requestor_id')->where('id', $request_id)->get();
			$requestor_id = $res_request[0]->requestor_id;
			$res_user = DB::table('useraccount')->select('EmailAddress','FirstName','LastName')->where('id', $requestor_id)->get();
			
			// If No of approver is 0/1 then direct forwarded to Fulfuiller department
			// Get dept_id from request table
			$res_req = DB::select("SELECT dept_id FROM request where id='".$request_id."'");
			$tmp_dept_id = 0;
			$no_of_approver_level = "";
			if(count($res_req) > 0){
				$tmp_dept_id = $res_req[0]->dept_id;
				
				$res_users = DB::select("SELECT id FROM `useraccount` WHERE find_in_set(".$tmp_dept_id.", `dept_second_approver`)");
				if(count($res_users) > 0){
					$no_of_approver_level = $res_users[0]->id;
				}
			}
			
			// If Approved
			if($status == "1"){
				if($no_of_approver_level == ""){
					
					// Finally move to Fulfil department (is_forward_to_fulfil = 1)
					DB::update('update request set is_forward_to_fulfil = 1,first_approver_status=1,second_approver_status=1,req_prec=1 where id = ?', array($request_id));
					
					// All Fulfiler
					
					$res_getmail = DB::select("SELECT EmailAddress FROM useraccount WHERE is_fulfiler=1");
					foreach($res_getmail as $mail){
						$to_email.= ",".$mail->EmailAddress;
					}
					$to_email = substr($to_email, 1);
					
				}else{
					
					// If 1st Level, then forwarded to second level
					if(Session::get('ecomps_user_approver_level') == "first"){
						$approver_id = Session::get('ecomps_user_second_approver');
						DB::update('update request set first_approver_status=1,req_position=2 where id = ?', array($request_id));
												
						// All 2nd Level of Approvers
						$res_getmail = DB::select("SELECT EmailAddress FROM useraccount WHERE approver_level=2 and find_in_set(".$tmp_dept_id.", dept_second_approver)");
						$to_email = "";
						foreach($res_getmail as $mail){
							$to_email.= ",".$mail->EmailAddress;
						}
						$to_email = substr($to_email, 1);					
						
						
						// Mail to Requestor when 1st Approver approved
						$requestor_email = $res_user[0]->EmailAddress;
						if($requestor_email != ""){
							
							// Template 6
							$this->sendMail($request_id, 6, $requestor_email);
						}
						// Mail to Requestor when 1st Approver approved
						
						
					}
					// If 2nd Level and no of approver 2, then forwarded to Fulfuiller department
					if(Session::get('ecomps_user_approver_level') == "second"){
						
						$to_email = "";
						
						// Finally move to Fulfil department (is_forward_to_fulfil = 1)
						DB::update('update request set is_forward_to_fulfil = 1,second_approver_status=1,req_prec=1 where id = ?', array($request_id));
						
						// Mail to Requestor when 2nd Approver approved
						$requestor_email = $res_user[0]->EmailAddress;
						if($requestor_email != ""){
							$this->sendMail($request_id, 7, $requestor_email);
						}
						// Mail to Requestor when 2nd Approver approved
						
						// All Fulfiler
						$res_getmail = DB::select("SELECT EmailAddress FROM useraccount WHERE is_fulfiler=1");
						foreach($res_getmail as $mail){
							$to_email.= ",".$mail->EmailAddress;
						}
						
						$to_email = substr($to_email, 1);
					}	
				}
				DB::update('update request set is_approve=1 where id = ?', array($request_id));
				
				// Mail
				
				if($to_email != ""){
					
					// Template 2
					$this->sendMail($request_id, 2, $to_email);
				}
				
				// If Rejected
			}else{
				
				$to_email = $res_user[0]->EmailAddress;
				
				if(Session::get('ecomps_user_approver_level') == "first"){	
									
					DB::update('update request set first_approver_status=2 where id = ?', array($request_id));
					
					$approver_lvl = "First Level of Approver";
					if($to_email != ""){
						
						// Template 3
						$this->sendMail($request_id, 3, $to_email, $approver_lvl);
					}
				}
				if(Session::get('ecomps_user_approver_level') == "second"){					
					DB::update('update request set second_approver_status=2 where id = ?', array($request_id));
					
					$approver_lvl = "Second Level of Approver";
					if($to_email != ""){
						
						// Template 3
						$this->sendMail($request_id, 3, $to_email, $approver_lvl);
					}
				}
				
				// Update status as cancelled
				DB::update('update request set is_cancel=1,req_prec=3 where id = ?', array($request_id));
				
			}
		}
		return "success";exit;
	}
	
	public function front_post_requests_multi_fulfiled(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_user_id');		
		$checkValues = $request->input('checkValues');
		
		for($i = 0; $i < count($checkValues); $i++){
			
			$request_id = $checkValues[$i];	
			
			DB::update('update request set is_fulfil=1,req_prec=2,fulfil_by='.$ecomps_admin_id.',fulfil_date=now() where id = ?', array($request_id));
			
			// Get Requestor Email
			$res_request = DB::table('request')->select('requestor_id')->where('id', $request_id)->get();
			$requestor_id = $res_request[0]->requestor_id;
			$res_user = DB::table('useraccount')->select('EmailAddress')->where('id', $requestor_id)->get();
			
			// Mail to Requestor
			$to_email = $res_user[0]->EmailAddress;
			if($to_email != ""){
				
				// Template 1
				$this->sendMail($request_id, 1, $to_email);
			}
		}
		return "success";exit;
	}
		
	public function contactpage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_user_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		return view('contact');
	}
	
	public function calenderpage(){
		
		$ecomps_admin_id = Session::get('ecomps_user_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		return view('calender');
	}
	
	public function chartpage(){
		
		$ecomps_admin_id = Session::get('ecomps_user_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		return view('vp-home');
	}
	
	public function gameviewpage($game_id){
		
		$ecomps_admin_id = Session::get('ecomps_user_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		$data = DB::table('game')->where('id', $game_id)->get();
		
		$dept_id = Session::get('ecomps_user_dept_id');
		
		//$requesttype = DB::table('requesttype')->where('IsEnabled', 1)->orderBy('name')->pluck('name', 'id');
		$locationtype = DB::table('locationtype')->orderBy('id')->pluck('Name', 'id');
		$deliverytype = DB::table('deliverytype')->orderBy('Name')->pluck('Name', 'id');
		$department = DB::table('department')->where('id', '=', $dept_id)->pluck('Name', 'id');
		
		return view('requests-entry', compact('department', 'locationtype', 'deliverytype','game_id'));
		
	}
		
    public function sendMail($request_id, $tempate_id, $to_email, $approver_lvl=""){
		
		return;
		
		$smpt = DB::table('smtp')->where('id', 1)->get();
		$host = $smpt[0]->host;
		$from_email = $smpt[0]->email;
		$password = base64_decode($smpt[0]->password);
		$port = $smpt[0]->port;
		$from_name = $smpt[0]->from_name;
		
		$email_template = DB::table('emailtemplate')->where('id', $tempate_id)->get();
		$subject = $email_template[0]->subject;
		$input_admin = $email_template[0]->contents;
		
		// 4 = Password Template
		if($tempate_id == "4"){
			$users = DB::table('useraccount')->select('FirstName', 'LastName', 'password')->where('EmailAddress', $to_email)->get();
			$user_name = $users[0]->FirstName.' '.$users[0]->LastName;
			$password = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($users[0]->password)))));
			$email_body = str_replace(array('%USER_NAME%','%EMAIL%','%PASSWORD%'),array($user_name,$to_email,$password),$input_admin);			
		}else{
		
			$reqs = DB::table('request')->where('id', $request_id)->get();
			
			$link = url('/').'/request/'.$request_id.'/public/view';
			$game_date = date('m/d/Y h:i A', strtotime(getDataFromTable("game","OriginalGameDate","id", $reqs[0]->game_id)));
			$demand_type = getDataFromTable("locationtype","Name","id", $reqs[0]->locationtype_id);
			
			$opponent = "";
			$res_teamid = DB::table('game')->select('team_id')->where('id', $reqs[0]->game_id)->get();
			$team_id = $res_teamid[0]->team_id;
			if($team_id > 0){
				$res_team = DB::table('team')->select('Name')->where('id', $team_id)->get();
				$opponent = $res_team[0]->Name;
			}
			$requestor = "";
			$requester = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $reqs[0]->requestor_id);
			if(count($requester) > 0){
				$requestor = $requester->FirstName.' '.$requester->LastName;
			}
			
			$recepient = $reqs[0]->RecipientFirstName.' '.$reqs[0]->RecipientLastName;
			$type = getDataFromTable("deliverytype","Name","id", $reqs[0]->deliverytype_id);
			$submitted_date = date('m/d/Y h:i A', strtotime($reqs[0]->CreateDate));
			$comps = $reqs[0]->Comp;
			$Purchased = $reqs[0]->Purchased;
			$total = $comps + $Purchased;
			
			$email_template = DB::table('emailtemplate')->where('id', $tempate_id)->get();
			$subject = $email_template[0]->subject;
			$input_admin = $email_template[0]->contents;
			
			if($tempate_id == "10"){
				
				$requestor = "";
				$requester = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $reqs[0]->first_approver);
				if(count($requester) > 0){
					$requestor = $requester->FirstName.' '.$requester->LastName;
				}
				$email_body = str_replace(array('%GAME_NAME%','%APPROVER_NAME%'),array($opponent,$requestor),$input_admin);
			}else{
				$email_body = str_replace(array('%LINK%','%GAME_DATE%','%DEMAND_TYPE%','%OPPONENT%','%REQUESTER%','%RECIPIENT%','%TYPE%','%SUBMITTED_DATE%','%COMP%','%PURCHASED%','%TOTAL%','%APPROVER_LEVEL%'),array($link,$game_date,$demand_type,$opponent,$requestor,$recepient,$type,$submitted_date,$comps,$Purchased,$total,$approver_lvl),$input_admin);
			}
		}
		//echo $email_body;exit;
 		return;
		if(trim($host) != ""){
			
			set_time_limit(0);
			
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
			
			$addr = explode(',',$to_email);
			foreach ($addr as $ad) {
				$mail->AddAddress( trim($ad) );       
			}
			//$mail->AddAddress($to_email);
			
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
			try {
				if(!$mail->Send()){
					//echo "Mailer Error: " . $mail->ErrorInfo;
					//exit;
				}
			} catch (Exception $e) {
				
			}
		}
    }	
	
	public function valid_ip($ip) {
		return $ip && substr($ip, 0, 4) != '127.' && substr($ip, 0, 4) != '127.' && substr($ip, 0, 3) != '10.' && substr($ip, 0, 2) != '0.' ? $ip : false;
	}
	
	public function get_client_ip() {
		return @$_SERVER['HTTP_X_FORWARDED_FOR'] ? explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'], 2)[0] : @$_SERVER['HTTP_CLIENT_IP'] ? explode(',', $_SERVER['HTTP_CLIENT_IP'], 2)[0] : $this->valid_ip(@$_SERVER['REMOTE_ADDR']) ?: 'UNKNOWN';
	}
}