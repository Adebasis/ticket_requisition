<?php
// This page is consist of Admin controller.
// Admin controllere has its own methods through which all admin related functionality taken care off.
// Admin controller will get the request when request redirect from the Route.
// It get the request and execute the proper functions based on Route specification.
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Session;

class AdminController extends Controller
{	
	public function __construct(){
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }
	
	public function loginpage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return view('admin.login');
		}
		return redirect('adminpanel/requests');
	}
	
	public function postLogin(Request $request){
		//base64_encode(base64_encode(base64_encode(base64_encode(base64_encode('admin1234')))));
		$username = $request->input('txtUsername');
		$login_password = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($request->input('txtPassword'))))));
		
		$users = DB::table('admin')->where(function ($query) use ($login_password, $username) {
				$query->where('username', $username)
					->where('password', '=', $login_password);
			})->orWhere(function($query) use ($login_password, $username) {
				$query->where('email', $username)
					->where('password', '=', $login_password);	
			})->get();
		//dd($users);	exit;
		//print_r();exit;
		if(count($users) > 0){
			
			Session::set('ecomps_subadmin', 'no');
			Session::set('ecomps_admin_id', $users[0]->id);
			Session::set('ecomps_user_name', $users[0]->username);
			Session::set('ecomps_location', $users[0]->location);
			Session::set('ecomps_user_full_name', $users[0]->user_full_name);			
			
			// Redirect to dashboad
			return redirect('adminpanel/requests');
			
		}else{
			
			return redirect('/adminpanel')->with('error', 'The credentials provided do not match an existing, active account.');
		}		
	}
	
	public function admin_appsettings(){
							
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.apps-settings');
	}
	
	public function admin_post_appsettings(Request $request){
		
		// Logout Time
		$timeout_time = $request->timeout_time?$request->timeout_time:0;		
		DB::table('appsettings')->where('id','=',1)->update(array('Value'=>$timeout_time));
		
		// Time Zone
		$timezone = $request->timezone;
		DB::table('appsettings')->where('id','=',3)->update(array('Value'=>$timezone));
		
		// Time Zone
		$sitemode = $request->sitemode;
		DB::table('appsettings')->where('id','=',5)->update(array('Value'=>$sitemode));
		
		$file = request()->file('image_file');
		if($file){
			$imageName = time().'.'.$file->getClientOriginalExtension();
			$request->image_file->move(public_path('admin_assets/images'), $imageName);
			DB::table('appsettings')->where('id','=',2)->update(array('Value'=>$imageName));
		}		
		return redirect('/adminpanel/apps-settings')->with('msg','Settings has been saved successfully');
	}	
	
	public function settings_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.settings');
	}
	
	public function admin_post_settings(Request $request){
		
		$server_ip = $request->server_ip?$request->server_ip:"";
		$host = $request->host;
		$email = $request->email;
		$port = $request->port?$request->port:0;
		if($request->password == ""){
			$password = "";
		}else{
			$password = trim(base64_encode($request->password));
		}
		$from_name = trim($request->from_name);
		$smtpauth = $request->smtpauth?$request->smtpauth:"";
		//if($password != ""){
			//DB::table('smtp')->where('id','>',0)->update(array('password'=>$password));
		//}
		DB::table('smtp')->where('id','=',1)->update(array('host'=>$host,'server_ip'=>$server_ip,'email'=>$email,'password'=>$password,'port'=>$port,'from_name'=>$from_name,'smtpauth'=>$smtpauth));
		
		$server_ip = $request->server_ip1?$request->server_ip1:"";
		$host = $request->host1;
		$email = $request->email1;
		$port = $request->port1?$request->port1:0;
		if($request->password1 == ""){
			$password = "";
		}else{
			$password = trim(base64_encode($request->password1));
		}
		$from_name = trim($request->from_name1);
		DB::table('smtp')->where('id','=',2)->update(array('host'=>$host,'server_ip'=>$server_ip,'email'=>$email,'password'=>$password,'port'=>$port,'from_name'=>$from_name,'smtpauth'=>$smtpauth));
		
		return redirect('/adminpanel/settings')->with('msg','Settings has been saved successfully');
	}	
	
	// This method has been used to redirect to the reset password page.
	public function resetpasswordpage(){
		return view('admin.password');
	}
	
	public function postResetPassword(Request $request){
		
		/*$username = $request->txtUsername;
		$txtNewPassword = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($request->txtNewPassword)))));
		
		$users = DB::table('admin')->where(function ($query) use ($username) {
				$query->where('username', $username);
					})->orWhere(function($query) use ($username) {
						$query->where('email', $username);
					})->get();
		if(count($users) > 0){
			DB::table('admin')->where('id','=',$users[0]->id)->update(array('password'=>$txtNewPassword));
			return redirect('/adminpanel/reset/password')->with('msg','Your password has been reset successfully');
		}else{
			return redirect('/adminpanel/reset/password')->with('error', 'Email address do not match an existing, active account.');
		}*/
		$txtUsername = $request->txtUsername;
		$users = DB::table('admin')->where('email', $txtUsername)->get();
		
		if(count($users) > 0){
			
			// Mail to user to sent out the password
			//$this->sendMail(0, 11, $txtUsername);
			
			app('App\Http\Controllers\HomeController')->sendMail(0, 12, $txtUsername);
			
			return redirect('/adminpanel/reset/password')->with('msg','Please check your mail to reset your password link !!!');
		}else{
			return redirect('/adminpanel/reset/password')->with('error', 'Email address do not match an existing, active account.');
		}
	}
	public function reset_password($id){
		
		
		$id = base64_decode($id);
		$id_exist = DB::table('admin')->where('id', '=', $id)->count();
		if($id_exist > 0){
			$msg = 'yes';
		}else{
			$msg = 'no';
		}
		return view('admin.reset-password')->with('id_exist', $msg)->with('user_id', $id);
	}
	public function adminpostResetPasswordSave(Request $request){
		
		$id = $request->input('user_id');
		$new_pass = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($request->input('new_pass'))))));
		
		$encryped_id = base64_encode($id);
		
		DB::table('admin')->where('id','=', $id)->update(array('password'=>$new_pass));
		
		$res_user = DB::table('admin')->select('email')->where('id', '=', $id)->get();
		$EmailAddress = $res_user[0]->email;
		
		// Mail to user to sent out the password
		app('App\Http\Controllers\HomeController')->sendMail(0, 13, $EmailAddress);
		
		return redirect('adminpanel/reset/password/'.$encryped_id.'/link')->with('msg','');
		
	}
	
	public function homepage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$no_of_users = DB::table('useraccount')->count();
		return view('admin.home')->with('no_of_users', $no_of_users);
	}
	
	public function changepasswordpage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.change-password');
	}
	
	// This method is being used to handle the change password request by admin.
	public function adminChangePassword(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		$old_pass = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($request->input('old_pass'))))));
		$new_pass = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($request->input('new_pass'))))));;
		
		$subadmin = Session::get('ecomps_subadmin');
		if($subadmin == "yes"){
			
			$count = DB::table('subadmin')->where('password', '=', $old_pass)->count();
			if($count > 0){
				
				DB::table('subadmin')->where('id','=',$ecomps_admin_id)->update(array('password'=>$new_pass));
				
				return redirect('adminpanel/change-password')->with('msg','');
			}else{
				return redirect('adminpanel/change-password')->with('errmsg','');
			}

		}else{
			
			$count = DB::table('admin')->where('password', '=', $old_pass)->count();
			if($count > 0){
				
				DB::table('admin')->where('id','>',0)->update(array('password'=>$new_pass));
				
				return redirect('adminpanel/change-password')->with('msg','');
			}else{
				return redirect('adminpanel/change-password')->with('errmsg','');
			}
		}
	}
	
	public function profilepage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		
		$subadmin = Session::get('ecomps_subadmin');
		if($subadmin == "yes"){
			$data = DB::table('subadmin')->where('id', '=', $ecomps_admin_id)->get();			
			return view('admin.subadmin-profile')->with('data', $data);
		}else{
			$data = DB::table('admin')->where('id', '=', $ecomps_admin_id)->get();			
			return view('admin.profile')->with('data', $data);
		}
	}
	
	// This method is used to handle the request for profile updates. 
	public function adminupdateProfile(Request $request){
		
		$user_full_name = $request->input('user_full_name');
		$email = $request->input('email');
		$username = $request->input('username');
		$location = $request->input('location');
		$mobile = $request->input('mobile');
		$phone = $request->input('phone');
		
		DB::table('admin')->where('id','>',0)->update(array('user_full_name'=>$user_full_name,'email'=>$email,'username'=>$username,'location'=>$location,'mobile'=>$mobile,'phone'=>$phone));
		return redirect('adminpanel/profile')->with('msg','Profile edited successfully');
	}
	
	// Departments
	public function departmentspage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		/*$query = $request->input('search');
		if($query){
			$data = DB::table('department')->where('Name', 'LIKE', '%' . $query . '%')->paginate(20);
		}else{
			$data = DB::table('department')->orderBy('id', 'desc')->paginate(50);
		}*/
		return view('admin.departments')->with('data', '')->with('query', '');
	}	
	public function departments_entry_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.departments-entry');
	}	
	public function admindepartmententry(Request $request){
		
		$Name = $request->input('Name');
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('Y-m-d H:i:s');
		
		//$first_approver = $request->input('first_approver')?$request->input('first_approver'):0;
		
		//$second_approver = $request->input('second_approver');
		
		$count = DB::table('department')->where('Name', '=', $Name)->count();
		if($count > 0){
			return redirect('adminpanel/departments/entry')->with('errmsg','')->with('Name', $Name);
		}else{
			
			$id = DB::table('department')->insertGetId(array('Name'=>$Name,'first_approver'=>0,'second_approver'=>0,'CreateDate'=>$CreateDate));
			
			/*DB::table('useraccount')->where('id','=',$first_approver)->update(array('approver_level'=>1));
			
			// Check 2nd Level approvers selected OR not
			if(count($second_approver) > 0){
				
				// Each approver
				for($i = 0; $i < count($second_approver); $i++){
					
					$all_second_approver = '';
					
					// Get Previous departments from user table
					$users = DB::table('useraccount')->select('id','dept_second_approver')->where('id', $second_approver[$i])->get();
					
					// If department exist
					$tmp_dept = $users[0]->dept_second_approver;
					if($tmp_dept == ""){
						$all_second_approver = $pk_id;
					}else{
						if (strpos($tmp_dept, ',') !== false) {
							$all_second_approver = $tmp_dept.','.$pk_id;
							$tmp_arr = explode(",", $all_second_approver);
							$tmp_arr = array_unique($tmp_arr);
							$all_second_approver = implode(",", $tmp_arr);
						}
					}
					
					// Update status as second level approver
					DB::table('useraccount')->where('id','=',$second_approver[$i])->update(array('approver_level'=>2, 'dept_second_approver'=>$all_second_approver));
				}
			}
			*/
			return redirect('adminpanel/departments');
		}
	}	
	public function departments_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('department')->where('id', '=', $pk_id)->get();
		return view('admin.departments-edit')->with('data', $data);
	}	
	public function admindepartmentedit(Request $request){
		$Name = $request->input('Name');
		$pk_id = $request->input('pk_id');
		
		$count = DB::table('department')->where('Name', '=', $Name)->where('id', '!=', $pk_id)->count();
		if($count > 0){
			return redirect('adminpanel/departments/'.$pk_id.'/edit')->with('errmsg','');
		}else{
			
			DB::table('department')->where('id','=',$pk_id)->update(array('Name'=>$Name));
			
			return redirect('adminpanel/departments');
		}
	}	
	public function departments_approver_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('department')->where('id', '=', $pk_id)->get();
		$users = DB::table('useraccount')->select('FirstName', 'LastName', 'id')->orderBy('FirstName')->where('dept_id', '=', $pk_id)->get();
		//print_r($users);exit;
		return view('admin.departments-approver', compact('data', 'users'));
	}	
	public function admin_post_department_approver(Request $request){
				
		$first_approver = $request->input('first_approver')?$request->input('first_approver'):0;
		
		$second_approver = $request->input('second_approver');
		
		$pk_id = $request->input('pk_id');
		
		DB::table('department')->where('id','=',$pk_id)->update(array('first_approver'=>$first_approver));
		
		// Remove All First Level approver
		DB::table('useraccount')->where('dept_id','=',$pk_id)->where('approver_level', 1)->update(array('approver_level'=>0));
		
		// Assign Status First Level Approver
		DB::table('useraccount')->where('id','=',$first_approver)->update(array('approver_level'=>1));
		
		$resApp = DB::select("SELECT id,dept_second_approver FROM useraccount WHERE approver_level=2 and find_in_set(".$pk_id.", dept_second_approver)");
		
		if(count($resApp) > 0){
			
			// Remove selected department for each users
			foreach($resApp as $tmpuser){
				$tmp_dept = $tmpuser->dept_second_approver;
				if($tmp_dept != ""){
					$tmp_arr = explode(",", $tmp_dept);
					$arr = array_diff($tmp_arr, array($pk_id));
					
					$all_second_approver = "";
					if(count($arr) > 0){
						$all_second_approver = implode(",", $arr);
					}
					DB::table('useraccount')->where('id','=',$tmpuser->id)->update(array('approver_level'=>0, 'dept_second_approver'=>$all_second_approver));
				}
			}			
		}
		// Check 2nd Level approvers selected OR not
		if(count($second_approver) > 0){
			
			// Each approver
			for($i = 0; $i < count($second_approver); $i++){
				
				$all_second_approver = '';
				
				// Get Previous departments from user table
				$users = DB::table('useraccount')->select('id','dept_second_approver')->where('id', $second_approver[$i])->get();
				
				// If department exist
				$tmp_dept = $users[0]->dept_second_approver;
				if($tmp_dept == ""){
					$all_second_approver = $pk_id;
				}else{
					if (strpos($tmp_dept, ',') !== false) {
						$all_second_approver = $tmp_dept.','.$pk_id;
						$tmp_arr = explode(",", $all_second_approver);
						$tmp_arr = array_unique($tmp_arr);
						$all_second_approver = implode(",", $tmp_arr);
					}
				}
				
				// Update status as second level approver
				DB::table('useraccount')->where('id','=',$second_approver[$i])->update(array('approver_level'=>2, 'dept_second_approver'=>$all_second_approver));
			}
		}
		
		return redirect('adminpanel/departments/'.$pk_id.'/approver')->with('success', 'true');
	}
	public function admindepartmentdelete($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		DB::table('department')->where('id', '=', $pk_id)->delete();

		return redirect('adminpanel/departments');
	}
	// Departments
	
	// Roles
	public function rolespage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$query = $request->input('search');
		if($query){
			$data = DB::table('role')->where('Name', 'LIKE', '%' . $query . '%')->paginate(20);
		}else{
			$data = DB::table('role')->orderBy('id', 'asc')->paginate(20);
		}
		return view('admin.roles')->with('data', $data)->with('query', $query);
	}	
	public function roles_entry_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.roles-entry');
	}	
	public function adminRolesEntry(Request $request){
		$Name = $request->input('Name');
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('Y-m-d H:i:s');		
		
		$count = DB::table('role')->where('Name', '=', $Name)->count();
		if($count > 0){
			return redirect('adminpanel/roles/entry')->with('errmsg','')->with('Name', $Name);
		}else{
			
			$id = DB::table('role')->insertGetId(array('Name'=>$Name,'CreateDate'=>$CreateDate));
			
			return redirect('adminpanel/roles');
		}
	}	
	public function roles_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('role')->where('id', '=', $pk_id)->get();
		return view('admin.roles-edit')->with('data', $data);
	}		
	public function adminRolesEdit(Request $request){
		$Name = $request->input('Name');
		$pk_id = $request->input('pk_id');
		
		$count = DB::table('role')->where('Name', '=', $Name)->where('id', '!=', $pk_id)->count();
		if($count > 0){
			return redirect('adminpanel/roles/'.$pk_id.'/edit')->with('errmsg','');
		}else{
			
			DB::table('role')->where('id','=',$pk_id)->update(array('Name'=>$Name));
			
			return redirect('adminpanel/roles');
		}
	}	
	public function adminRolesDelete($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		DB::table('role')->where('id', '=', $pk_id)->delete();

		return redirect('adminpanel/roles');
	}	
	public function roles_tasks_assign_page($pk_id){
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('role')->where('id', '=', $pk_id)->get();
		$task = DB::table('task')->orderBy('id', 'asc')->get();
		$roletasks = DB::table('roletasks')->select('task_id')->where('role_id', '=', $pk_id)->pluck('task_id');

		return view('admin.roles-tasks-assign', compact('data', 'task', 'roletasks'));
	}	
	public function admin_post_roles_tasks_assign_page(Request $request){
		
		$pk_id = $request->input('pk_id');
		$tasks = $request->input('task_id');
		
		# Delete all tasks for selected Role
		DB::table('roletasks')->where('role_id', '=', $pk_id)->delete();
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('Y-m-d H:i:s');
		
		# insert fresh data
		for($i = 0; $i < count($tasks); $i++){
			
			$task_id = $tasks[$i];
			DB::table('roletasks')->insert(array('role_id'=>$pk_id,'task_id'=>$task_id,'CreateDate'=>$CreateDate));
		}
		return redirect('adminpanel/roles/'.$pk_id.'/tasks/assign')->with('success', 'true');
	}
	// Roles
	
	// Tasks
	public function taskspage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$query = $request->input('search');
		if($query){
			$data = DB::table('task')->where('Name', 'LIKE', '%' . $query . '%')->paginate(20);
		}else{
			$data = DB::table('task')->orderBy('id', 'desc')->paginate(20);
		}
		return view('admin.tasks')->with('data', $data)->with('query', $query);
	}	
	public function tasks_entry_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.tasks-entry');
	}	
	public function adminTasksEntry(Request $request){
		$Name = $request->input('Name');
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('Y-m-d H:i:s');
		
		$count = DB::table('task')->where('Name', '=', $Name)->count();
		if($count > 0){
			return redirect('adminpanel/tasks/entry')->with('errmsg','')->with('Name', $Name);
		}else{
			
			$id = DB::table('task')->insertGetId(array('Name'=>$Name,'CreateDate'=>$CreateDate));
			
			return redirect('adminpanel/tasks');
		}
	}	
	public function tasks_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('task')->where('id', '=', $pk_id)->get();
		return view('admin.tasks-edit')->with('data', $data);
	}	
	public function adminTasksEdit(Request $request){
		$Name = $request->input('Name');
		$pk_id = $request->input('pk_id');
		
		$count = DB::table('task')->where('Name', '=', $Name)->where('id', '!=', $pk_id)->count();
		if($count > 0){
			return redirect('adminpanel/tasks/'.$pk_id.'/edit')->with('errmsg','');
		}else{
			
			DB::table('task')->where('id','=',$pk_id)->update(array('Name'=>$Name));
			
			return redirect('adminpanel/tasks');
		}
	}	
	public function adminTasksDelete($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		DB::table('task')->where('id', '=', $pk_id)->delete();

		return redirect('adminpanel/tasks');
	}
	// Tasks
	
	// Game State
	public function gamestatepage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$query = $request->input('search');
		if($query){
			$data = DB::table('gamestate')->where('Name', 'LIKE', '%' . $query . '%')->paginate(20);
		}else{
			$data = DB::table('gamestate')->orderBy('id', 'desc')->paginate(20);
		}
		return view('admin.gamestate')->with('data', $data)->with('query', $query);
	}	
	public function gamestate_entry_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.gamestate-entry');
	}	
	public function adminGamestateEntry(Request $request){
		$Name = $request->input('Name');
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('Y-m-d H:i:s');
		
		$count = DB::table('gamestate')->where('Name', '=', $Name)->count();
		if($count > 0){
			return redirect('adminpanel/gamestate/entry')->with('errmsg','')->with('Name', $Name);
		}else{
			
			$id = DB::table('gamestate')->insertGetId(array('Name'=>$Name,'CreateDate'=>$CreateDate));
			DB::table('gamestate')->where('id','=',$id)->update(array('GameStateCode'=>$id));
			
			return redirect('adminpanel/gamestate');
		}
	}	
	public function gamestate_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('gamestate')->where('id', '=', $pk_id)->get();
		return view('admin.gamestate-edit')->with('data', $data);
	}	
	public function adminGamestateEdit(Request $request){
		$Name = $request->input('Name');
		$pk_id = $request->input('pk_id');
		
		$count = DB::table('gamestate')->where('Name', '=', $Name)->where('id', '!=', $pk_id)->count();
		if($count > 0){
			return redirect('adminpanel/gamestate/'.$pk_id.'/edit')->with('errmsg','');
		}else{
			
			DB::table('gamestate')->where('id','=',$pk_id)->update(array('Name'=>$Name));
			
			return redirect('adminpanel/gamestate');
		}
	}	
	public function adminGamestateDelete($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		DB::table('gamestate')->where('id', '=', $pk_id)->delete();
		
		return redirect('adminpanel/gamestate');
	}
	// Game State
	
	// Employee Type
	public function employeetypepage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$query = $request->input('search');
		if($query){
			$data = DB::table('employeetype')->where('Name', 'LIKE', '%' . $query . '%')->paginate(20);
		}else{
			$data = DB::table('employeetype')->orderBy('FulfillmentOrder', 'asc')->paginate(20);
		}
		return view('admin.employeetype')->with('data', $data)->with('query', $query);
	}	
	public function employeetype_entry_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.employeetype-entry');
	}	
	public function adminEmployeeTypeEntry(Request $request){
		$Name = $request->input('Name');
		$FulfillmentOrder = $request->input('FulfillmentOrder')?$request->input('FulfillmentOrder') : 0;
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('Y-m-d H:i:s');
		
		$count = DB::table('employeetype')->where('Name', '=', $Name)->count();
		if($count > 0){
			return redirect('adminpanel/employeetype/entry')->with('errmsg','')->with('Name', $Name);
		}else{
			
			$id = DB::table('employeetype')->insertGetId(array('Name'=>$Name,'FulfillmentOrder'=>$FulfillmentOrder, 'CreateDate'=>$CreateDate));
			DB::table('employeetype')->where('id','=',$id)->update(array('EmployeeTypeCode'=>$id));
			
			return redirect('adminpanel/employeetype');
		}
	}	
	public function employeetype_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('employeetype')->where('id', '=', $pk_id)->get();
		return view('admin.employeetype-edit')->with('data', $data);
	}	
	public function adminEmployeeTypeEdit(Request $request){
		$Name = $request->input('Name');
		$FulfillmentOrder = $request->input('FulfillmentOrder')?$request->input('FulfillmentOrder') : 0;
		$pk_id = $request->input('pk_id');
		
		$count = DB::table('employeetype')->where('Name', '=', $Name)->where('id', '!=', $pk_id)->count();
		if($count > 0){
			return redirect('adminpanel/employeetype/'.$pk_id.'/edit')->with('errmsg','');
		}else{
			
			DB::table('employeetype')->where('id','=',$pk_id)->update(array('Name'=>$Name,'FulfillmentOrder'=>$FulfillmentOrder));
			
			return redirect('adminpanel/employeetype');
		}
	}	
	public function adminEmployeeTypeDelete($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		DB::table('employeetype')->where('id', '=', $pk_id)->delete();
		
		return redirect('adminpanel/employeetype');
	}
	// Employee Type
	
	// Delivery Type
	public function deliverytypepage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$query = $request->input('search');
		/*if($query){
			$data = DB::table('deliverytype')->where('Name', 'LIKE', '%' . $query . '%')->paginate(20);
		}else{
			$data = DB::table('deliverytype')->orderBy('id', 'desc')->paginate(20);
		}*/
		return view('admin.deliverytype')->with('data', '')->with('query', '');
	}	
	public function deliverytype_entry_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.deliverytype-entry');
	}	
	public function admindeliverytypeentry(Request $request){
		$Name = $request->input('Name');
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('Y-m-d H:i:s');
		
		$count = DB::table('deliverytype')->where('Name', '=', $Name)->count();
		if($count > 0){
			return redirect('adminpanel/deliverytype/entry')->with('errmsg','')->with('Name', $Name);
		}else{
			
			$id = DB::table('deliverytype')->insertGetId(array('Name'=>$Name,'CreateDate'=>$CreateDate));
			DB::table('deliverytype')->where('id','=',$id)->update(array('DeliveryTypeCode'=>$id));
			
			return redirect('adminpanel/deliverytype');
		}
	}	
	public function deliverytype_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('deliverytype')->where('id', '=', $pk_id)->get();
		return view('admin.deliverytype-edit')->with('data', $data);
	}	
	public function admindeliverytypeedit(Request $request){
		$Name = $request->input('Name');
		$pk_id = $request->input('pk_id');
		
		$count = DB::table('deliverytype')->where('Name', '=', $Name)->where('id', '!=', $pk_id)->count();
		if($count > 0){
			return redirect('adminpanel/deliverytype/'.$pk_id.'/edit')->with('errmsg','');
		}else{
			
			DB::table('deliverytype')->where('id','=',$pk_id)->update(array('Name'=>$Name));
			
			return redirect('adminpanel/deliverytype');
		}
	}	
	public function admindeliverytypedelete($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		DB::table('deliverytype')->where('id', '=', $pk_id)->delete();
		
		return redirect('adminpanel/deliverytype');
	}
	// Delivery Type
	
	// Demand Type
	public function demandtypepage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$query = $request->input('search');
		if($query){
			$data = DB::table('demandtype')->where('Name', 'LIKE', '%' . $query . '%')->paginate(20);
		}else{
			$data = DB::table('demandtype')->orderBy('UiSort', 'asc')->paginate(20);
		}
		return view('admin.demandtype')->with('data', $data)->with('query', $query);
	}	
	public function demandtype_entry_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.demandtype-entry');
	}	
	public function admindemandtypeentry(Request $request){
		$Name = $request->input('Name');
		$IsEnabled = $request->input('IsEnabled');
		$UiSort = $request->input('UiSort')?$request->input('UiSort'):0;
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('Y-m-d H:i:s');
		
		$count = DB::table('demandtype')->where('Name', '=', $Name)->count();
		if($count > 0){
			return redirect('adminpanel/demandtype/entry')->with('errmsg','')->with('Name', $Name);
		}else{
			
			$id = DB::table('demandtype')->insertGetId(array('Name'=>$Name,'IsEnabled'=>$IsEnabled,'UiSort'=>$UiSort,'DemandTypeCode'=>'-','CreateDate'=>$CreateDate,'LastUpdate'=>$CreateDate));
			DB::table('demandtype')->where('id','=',$id)->update(array('DemandTypeCode'=>$id));
			
			return redirect('adminpanel/demandtype');
		}
	}	
	public function demandtype_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('demandtype')->where('id', '=', $pk_id)->get();
		return view('admin.demandtype-edit')->with('data', $data);
	}	
	public function admindemandtypeedit(Request $request){
		$Name = $request->input('Name');
		$IsEnabled = $request->input('IsEnabled');
		$UiSort = $request->input('UiSort')?$request->input('UiSort'):0;
		$pk_id = $request->input('pk_id');
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$LastUpdate = $dt->format('Y-m-d H:i:s');
		
		$count = DB::table('demandtype')->where('Name', '=', $Name)->where('id', '!=', $pk_id)->count();
		if($count > 0){
			return redirect('adminpanel/demandtype/'.$pk_id.'/edit')->with('errmsg','');
		}else{
			
			DB::table('demandtype')->where('id','=',$pk_id)->update(array('Name'=>$Name,'IsEnabled'=>$IsEnabled,'UiSort'=>$UiSort,'LastUpdate'=>$LastUpdate));
			
			return redirect('adminpanel/demandtype');
		}
	}	
	public function admindemandtypedelete($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		DB::table('demandtype')->where('id', '=', $pk_id)->delete();
		
		return redirect('adminpanel/demandtype');
	}
	// Demand Type
	
	// Location Type
	public function locationtypepage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.locationtype')->with('data', '')->with('query', '');
	}	
	public function locationtype_entry_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.locationtype-entry');
	}	
	public function adminlocationtypeentry(Request $request){
		$Name = $request->input('Name');
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('Y-m-d H:i:s');
		
		$count = DB::table('locationtype')->where('Name', '=', $Name)->count();
		if($count > 0){
			return redirect('adminpanel/locationtype/entry')->with('errmsg','')->with('Name', $Name);
		}else{
			
			$id = DB::table('locationtype')->insertGetId(array('Name'=>$Name,'LocationTypeCode'=>'-','CreateDate'=>$CreateDate));
			DB::table('locationtype')->where('id','=',$id)->update(array('LocationTypeCode'=>$id));
			
			return redirect('adminpanel/locationtype');
		}
	}	
	public function locationtype_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('locationtype')->where('id', '=', $pk_id)->get();
		return view('admin.locationtype-edit')->with('data', $data);
	}	
	public function adminlocationtypeedit(Request $request){
		$Name = $request->input('Name');
		$pk_id = $request->input('pk_id');
		
		$count = DB::table('locationtype')->where('Name', '=', $Name)->where('id', '!=', $pk_id)->count();
		if($count > 0){
			return redirect('adminpanel/locationtype/'.$pk_id.'/edit')->with('errmsg','');
		}else{
			
			DB::table('locationtype')->where('id','=',$pk_id)->update(array('Name'=>$Name));
			
			return redirect('adminpanel/locationtype');
		}
	}	
	public function adminlocationtypedelete($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		DB::table('locationtype')->where('id', '=', $pk_id)->delete();
		
		return redirect('adminpanel/locationtype');
	}
	// Location Type
	
	// Game Request Type
	public function gamerequeststatepage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$query = $request->input('search');
		if($query){
			$data = DB::table('gamerequeststate')->where('Name', 'LIKE', '%' . $query . '%')->paginate(20);
		}else{
			$data = DB::table('gamerequeststate')->orderBy('id', 'asc')->paginate(20);
		}
		return view('admin.gamerequeststate')->with('data', $data)->with('query', $query);
	}	
	public function gamerequeststate_entry_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.gamerequeststate-entry');
	}	
	public function admingamerequeststateentry(Request $request){
		
		$Name = $request->input('Name');
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('Y-m-d H:i:s');
		
		$count = DB::table('gamerequeststate')->where('Name', '=', $Name)->count();
		if($count > 0){
			return redirect('adminpanel/gamerequeststate/entry')->with('errmsg','')->with('Name', $Name);
		}else{
			
			$id = DB::table('gamerequeststate')->insertGetId(array('Name'=>$Name,'RequestStateCode'=>'-','CreateDate'=>$CreateDate));
			DB::table('gamerequeststate')->where('id','=',$id)->update(array('RequestStateCode'=>$id));
			
			return redirect('adminpanel/gamerequeststate');
		}
	}	
	public function gamerequeststate_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('gamerequeststate')->where('id', '=', $pk_id)->get();
		return view('admin.gamerequeststate-edit')->with('data', $data);
	}	
	public function admingamerequeststateedit(Request $request){
		$Name = $request->input('Name');
		$pk_id = $request->input('pk_id');
		
		$count = DB::table('gamerequeststate')->where('Name', '=', $Name)->where('id', '!=', $pk_id)->count();
		if($count > 0){
			return redirect('adminpanel/gamerequeststate/'.$pk_id.'/edit')->with('errmsg','');
		}else{
			
			DB::table('gamerequeststate')->where('id','=',$pk_id)->update(array('Name'=>$Name));
			
			return redirect('adminpanel/gamerequeststate');
		}
	}	
	public function admingamerequeststatedelete($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		DB::table('gamerequeststate')->where('id', '=', $pk_id)->delete();
		
		return redirect('adminpanel/gamerequeststate');
	}
	// Game Request Type
	
	// useraccountpage
	public function useraccountpage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		/*$query = $request->input('search');
		if($query){
			$data = DB::table('useraccount')->orWhere('FirstName', 'LIKE', '%' . $query . '%')->orWhere('LastName', 'LIKE', '%' . $query . '%')->paginate(20);
		}else{
			$data = DB::table('useraccount')->orderBy('id', 'desc')->paginate(20);
		}*/
		//$data = DB::table('useraccount')->orWhere('FirstName', 'LIKE', '%' . $query . '%')->orWhere('LastName', 'LIKE', '%' . $query . '%')->orderBy('id', 'asc')->toSql();
		//dd($data);	exit;
		return view('admin.useraccount');
	}
	public function useraccountpage_list(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$result = array();
		$data = DB::table('useraccount')->orderBy('id', 'desc')->get();		
		array_push($result, $data);
		return $data;
	}
	public function admin_useraccount_entry_page(){
		//echo base64_decode(base64_decode(base64_decode(base64_decode(base64_decode('Vm10YWIyTXlVa2RqUm1oV1ltdEtZVlpyWkdwTlJsRjNVbFJzVVZWVU1Eaz0=')))));exit;
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$department=DB::table('department')->orderBy('Name', 'asc')->pluck('Name','id');
		$employeetype=DB::table('employeetype')->orderBy('Name', 'asc')->pluck('Name','id');
		
		return view('admin.useraccount-entry', compact('department', 'employeetype'));
	}	
	public function admin_post_useraccount_entry(Request $request){
		$FirstName = $request->input('FirstName');
		$LastName = $request->input('LastName');
		$EmailAddress = $request->input('EmailAddress');
		$user_name = $request->input('user_name');
		$dept_id = $request->input('dept_id')?$request->input('dept_id'):0;
		$level = $request->input('level')?$request->input('level'):0;
		$dept_second_approver = $request->input('dept');
		$is_vp = $request->input('is_vp');
		
		if($dept_second_approver !=''){
			$dept_second_approver=implode(',',$dept_second_approver);
		}else{
			$dept_second_approver="";
		}
		
		$password = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($request->input('password'))))));
		$employeetype_id = $request->input('employeetype_id')?$request->input('employeetype_id'):0;
		
		$HasCc = $request->input('HasCc');
		$is_fulfiler = $request->input('is_fulfiler')?$request->input('is_fulfiler'):0;
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('Y-m-d H:i:s');
		
		$count = DB::table('useraccount')->where('EmailAddress', '=', $EmailAddress)->count();
		if($count > 0){
			return redirect('adminpanel/useraccount/entry')->with('errmsg','');
		}else{
			
			if($level != "" && $level == "1"){
				$tmplevel = DB::table('department')->where('first_approver', '>', 0)->where('id', '=', $dept_id)->count();
				if($tmplevel > 0){
					return redirect('adminpanel/useraccount/entry')->with('errmsg_level','');
				}
			}
			
			// If VP
			$dept_of_vp="";
			if($is_vp == "1"){
				//DB::table('useraccount')->where('id','>',0)->update(array('is_vp'=>0));
				$dept_of_vp=$request->input('dept');
				if($dept_of_vp !=''){
					$dept_of_vp=implode(',',$dept_of_vp);
				}else{
					$dept_of_vp="";
				}
			}
					
			$id = DB::table('useraccount')->insertGetId(array('FirstName'=>$FirstName,'LastName'=>$LastName,'EmailAddress'=>$EmailAddress,'user_name'=>$user_name,'dept_id'=>$dept_id,'is_fulfiler'=>$is_fulfiler,'password'=>$password,'approver_level'=>$level,'is_vp'=>$is_vp,'dept_of_vp'=>$dept_of_vp,'dept_second_approver'=>$dept_second_approver,'employeetype_id'=>$employeetype_id,'HasCc'=>$HasCc,'CreateDate'=>$CreateDate,'LastUpdate'=>$CreateDate));
			
			if($level != "" && $level == "1"){				
				DB::table('department')->where('id','=',$dept_id)->update(array('first_approver'=>$id));
			}
						
			return redirect('adminpanel/useraccount');
		}
	}	
	public function admin_useraccount_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$department=DB::table('department')->orderBy('Name', 'asc')->pluck('Name','id');
		$employeetype=DB::table('employeetype')->orderBy('Name', 'asc')->pluck('Name','id');
		$data = DB::table('useraccount')->where('id', '=', $pk_id)->get();
		
		return view('admin.useraccount-edit', compact('data', 'department', 'employeetype'));
	}
	public function admin_post_useraccount_edit(Request $request){
		
		$pk_id = $request->input('pk_id');
		$FirstName = $request->input('FirstName');
		$level = $request->input('level');
		$LastName = $request->input('LastName');
		$EmailAddress = $request->input('EmailAddress');
		//$user_name = $request->input('user_name');
		$dept_id = $request->input('dept_id')?$request->input('dept_id'):0;
		//$password = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($request->input('password'))))));
		$employeetype_id = $request->input('employeetype_id');
		//$SeniorityDate = $request->input('SeniorityDate');
		$HasCc = $request->input('HasCc');
		$is_fulfiler = $request->input('is_fulfiler')?$request->input('is_fulfiler'):0;
		
		$is_vp = $request->input('is_vp');
		$dept_second_approver=$request->input('dept');
		$level = $request->input('level')?$request->input('level'):0;
		if($level == 1 || $level == 0){
			$dept_second_approver="";
		}
		if($dept_second_approver !=''){
			$dept_second_approver=implode(',',$dept_second_approver);
		}else{
			$dept_second_approver="";
		}
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$LastUpdate = $dt->format('Y-m-d H:i:s');
		
		if($level != "" && $level == "1"){
			
			$tmplevel = DB::table('department')->where('first_approver', '>', 0)->where('id', '=', $dept_id)->count();
			if($tmplevel > 0){
				return redirect('adminpanel/useraccount/'.$pk_id.'/edit')->with('errmsg_level','');
			}
		}
		
		if($level == ""){
			DB::table('department')->where('id','=',$dept_id)->where('first_approver', '=', $pk_id)->update(array('first_approver'=>0));
		}
		
		if($level != "" && $level == "1"){
			DB::table('department')->where('id','=',$dept_id)->update(array('first_approver'=>$pk_id));
		}
		
		// If VP is selected
		if($is_vp == "1"){
			
			$dept_of_vp=$request->input('dept');
			if($dept_of_vp !=''){
				$dept_of_vp=implode(',',$dept_of_vp);
			}else{
				$dept_of_vp="";
			}
			
			DB::table('useraccount')->where('id','=',$pk_id)->update(array('is_vp'=>1,'dept_of_vp'=>$dept_of_vp));
		}
		DB::table('useraccount')->where('id','=',$pk_id)->update(array('FirstName'=>$FirstName,'LastName'=>$LastName,'EmailAddress'=>$EmailAddress,'dept_id'=>$dept_id,'is_fulfiler'=>$is_fulfiler,'approver_level'=>$level,'dept_second_approver'=>$dept_second_approver,'employeetype_id'=>$employeetype_id,'HasCc'=>$HasCc,'LastUpdate'=>$LastUpdate));
				
		return redirect('adminpanel/useraccount');
	}
	public function admin_useraccount_setpassword_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('useraccount')->where('id', '=', $pk_id)->get();
		return view('admin.useraccount-setpassword')->with('data', $data);
	}
	public function admin_post_useraccount_setpassword(Request $request){
		
		$new_password = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($request->input('new_password'))))));
		$pk_id = $request->input('pk_id');
		
		DB::table('useraccount')->where('id','=',$pk_id)->update(array('password'=>$new_password));
		
		// Mail Here
		
		return redirect('adminpanel/useraccount/'.$pk_id.'/setpassword')->with('msg', 'true');		
	}
	public function admin_useraccount_delete($pk_id){
		//echo $pk_id;exit;
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$res_dept = DB::table('useraccount')->select('dept_id')->where('id', $pk_id)->get();
		$dept_id = $res_dept[0]->dept_id;
		
		DB::table('department')->where('id','=',$dept_id)->where('first_approver','=',$pk_id)->update(array('first_approver'=>0));
		DB::table('useraccount')->where('id','=',$pk_id)->update(array('is_deleted'=>1));
						
		return redirect('adminpanel/useraccount');
	}
	public function admin_post_users_multi_delete(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		
		$checkValues = $request->input('checkValues');
		for($i = 0; $i < count($checkValues); $i++){
			
			$user_id = $checkValues[$i];
			
			$res_dept = DB::table('useraccount')->select('dept_id')->where('id', $user_id)->get();
			$dept_id = $res_dept[0]->dept_id;
			
			DB::table('department')->where('id','=',$dept_id)->where('first_approver','=',$user_id)->update(array('first_approver'=>0));
			DB::table('useraccount')->where('id','=',$user_id)->update(array('is_deleted'=>1));
			
		}
		return "success";exit;
	}
	public function admin_useraccount_assign_reports_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('useraccount')->where('id', '=', $pk_id)->get();
		return view('admin.useraccount-assign-reports', compact('data'));
	}
	public function admin_post_users_assign_reports(Request $request){
		
		$pk_id = $request->input('pk_id');
		
		$pages = $request->input('pages');
		$allow_pages = "";
		if($pages !=''){
			$allow_pages = implode(',',$pages);
		}
		DB::table('useraccount')->where('id','=',$pk_id)->update(array('allow_pages'=>$allow_pages));
		return redirect('adminpanel/useraccount/'.$pk_id.'/assign-reports')->with('msg','');
	}
	// useraccountpage
	
	// subadminpage
	public function subadminpage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.subadmin');
	}
	public function admin_subadmin_entry_page(){
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$department=DB::table('department')->orderBy('Name', 'asc')->pluck('Name','id');
		return view('admin.subadmin-entry', compact('department'));
	}	
	public function admin_post_subadmin_entry(Request $request){
		$user_id = $request->input('user_id');
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('Y-m-d H:i:s');
		
		$pages = $request->input('pages');
		$allow_pages = "users";
		if($pages !=''){
			$allow_pages = implode(',',$pages);
		}
		
		DB::table('subadmin')->insertGetId(array('user_id'=>$user_id,'allow_pages'=>$allow_pages,'CreateDate'=>$CreateDate,'LastUpdate'=>$CreateDate));
		return redirect('adminpanel/subadmin');
	}
	public function admin_subadmin_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('subadmin')->where('id', '=', $pk_id)->get();
		
		return view('admin.subadmin-edit', compact('data'));
	}
	public function admin_post_subadmin_edit(Request $request){
		
		$pk_id = $request->input('pk_id');
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$LastUpdate = $dt->format('Y-m-d H:i:s');
		
		$pages = $request->input('pages');
		$allow_pages = "users";
		if($pages !=''){
			$allow_pages = implode(',',$pages);
		}
		DB::table('subadmin')->where('id','=',$pk_id)->update(array('allow_pages'=>$allow_pages,'LastUpdate'=>$LastUpdate));
		
		return redirect('adminpanel/subadmin');
	}
	public function admin_subadmin_delete($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		
		DB::table('subadmin')->where('id', '=', $pk_id)->delete();
		
		return redirect('adminpanel/subadmin');
	}
	public function admin_post_subadmin_profile_edit(Request $request){
		
		$pk_id = Session::get('ecomps_admin_id');
		
		$FirstName = $request->input('FirstName');
		$LastName = $request->input('LastName');
		$username = $request->input('username');
		$EmailAddress = $request->input('EmailAddress');
		
		$LastUpdate = date('Y-m-d H:i:s');
		
		$count = DB::table('subadmin')->where('username', '=', $username)->where('id', '<>', $pk_id)->count();
		if($count > 0){
			return redirect('adminpanel/profile')->with('errmsg','');
		}else{
			DB::table('subadmin')->where('id','=',$pk_id)->update(array('FirstName'=>$FirstName,'LastName'=>$LastName,'username'=>$username,'EmailAddress'=>$EmailAddress,'LastUpdate'=>$LastUpdate));
		}
		return redirect('adminpanel/profile')->with('msg','');
	}
	// subadminpage
	
	// Request Section
	public function RequestPage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$query = $request->input('search');
	
		if($query){
			//$data = DB::table('request')->orWhere('RecipientFirstName', 'LIKE', '%' . $query . '%')->orWhere('RecipientLastName', 'LIKE', '%' . $query . '%')->paginate(50);
		}else{
			//$data = DB::table('request')->orderBy('id', 'desc')->paginate(50);
		}
		return view('admin.requests')->with('query', $query);
	}
	public function RequestPageEdit($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		//$requesttype = DB::table('requesttype')->where('IsEnabled', 1)->orderBy('name')->pluck('name', 'id');
		$department = DB::table('department')->orderBy('Name')->pluck('Name', 'id');
		$locationtype = DB::table('locationtype')->orderBy('Name')->pluck('Name', 'id');
		$deliverytype = DB::table('deliverytype')->orderBy('Name')->pluck('Name', 'id');
		$data = DB::table('request')->where('id', '=', $pk_id)->get();
		
		return view('admin.requests-edit', compact('data','department', 'locationtype', 'deliverytype'));
	}
	public function admin_post_requests_multi_approved(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		$log_approver_name = trim(Session::get('ecomps_user_full_name'));
		
		$checkValues = $request->input('checkValues');
		$status = $request->input('status');
		$data = array();
		$Dated = date('Y-m-d H:i:s');
		$IP = $_SERVER['REMOTE_ADDR'];
		
		for($i = 0; $i < count($checkValues); $i++){
			
			$request_id = $checkValues[$i];
			
			// Get Requestor Email
			$res_request = DB::table('request')->select('requestor_id')->where('id', $request_id)->get();
			$requestor_id = $res_request[0]->requestor_id;
			$res_user = DB::table('useraccount')->select('EmailAddress','FirstName','LastName')->where('id', $requestor_id)->get();
			$to_email = $res_user[0]->EmailAddress;
			$log_requstor_name = trim($res_user[0]->FirstName.' '.$res_user[0]->FirstName);
			
			// IF Approved
			if($status == "1"){
				DB::update('update request set approve_by_admin=1,is_forward_to_fulfil=1,is_approve=1,req_prec=1 where id = ?', array($request_id));
				
				// Mail to Requestor
				$requestor_email = $res_user[0]->EmailAddress;
				if($requestor_email != ""){
					app('App\Http\Controllers\HomeController')->sendMail($request_id, 9, $requestor_email);
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
				$logs_type = DB::table('logs_type')->where('id', 10)->get();
				$descr = str_replace(array('%APPROVER_NAME%','%REQUESTER_NAME%'),array($log_approver_name,$log_requstor_name),$logs_type[0]->name);
				DB::table('logs')->insert(array('user_id'=>1,'user_name'=>$log_approver_name,'user_type'=>'admin','request_id'=>$request_id,'descr'=>$descr,'ip'=>$IP,'created_date'=>$Dated));
				// ECOMPS LOGS
				
			}
			
			// IF Rejected
			if($status == "4"){
				
				DB::update('update request set is_cancel = 1,approve_by_admin=2,req_prec=3 where id = ?', array($request_id));
				
				$approver_lvl = "Admin";
				if($to_email != ""){
					app('App\Http\Controllers\HomeController')->sendMail($request_id, 3, $to_email, $approver_lvl);
				}
				
				// ECOMPS LOGS
				$logs_type = DB::table('logs_type')->where('id', 11)->get();
				$descr = str_replace(array('%APPROVER_NAME%','%REQUESTER_NAME%'),array($log_approver_name,$log_requstor_name),$logs_type[0]->name);
				DB::table('logs')->insert(array('user_id'=>1,'user_name'=>$log_approver_name,'user_type'=>'admin','request_id'=>$request_id,'descr'=>$descr,'ip'=>$IP,'created_date'=>$Dated));
				// ECOMPS LOGS
			}
			
		}
		return "success";exit;
	}		
	public function RequestPageMessageBoard($request_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
		
		// Update read message
		DB::table('request_message')->where('request_id','=',$request_id)->update(array('readby_admin'=>1));
		
		return view('admin.requests-message-board', compact('request_id'));
	}	
	public function adminPost_RequestPageMessageBoard(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
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
		
		DB::table('request_message')->insert(array('request_id'=>$request_id, 'message'=>nl2br($message), 'user_type'=>'admin', 'user_id'=>$ecomps_admin_id, 'created_date'=>$CreateDate));
		return "success";exit;
	}
	public function adminRequestPageMessageBoard_loadmore(Request $request){
		
		$request_id = $request->request_id;
		$last_id = $request->last_id;
		$row_id = $request->row_id;
		$arr_ = $request->arr_;
		$request_msg_count = $request->request_msg_count;
		$current_msg_count = DB::table('request_message')->where('request_id', '=', $request_id)->count();
		if($current_msg_count > $request_msg_count){
			return view('admin.requests-message-board-load-more', compact('request_id', 'last_id', 'arr_', 'row_id'));
		}
	}	
	// Request Section
		
	// logs page
	public function logspage(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		
		// Update read message
		DB::table('logs')->where('id','>',0)->update(array('read_by_admin'=>1));
		
		return view('admin.logs');
	}
	public function admin_post_logs_load_more_page(Request $request){
		$last_id = $request->last_id;
		return view('admin.logs-load-more', compact('last_id'));
	}
	public function admin_download_logs(){
		
		$table = DB::table('logs')->get();
		
		$filename = "logs.csv";
		$handle = fopen($filename, 'w+');
		fputcsv($handle, array('id', 'User name', 'descr', 'IP', 'Request From', 'Created At'));
		
		foreach($table as $row) {
			fputcsv($handle, array($row->id, $row->user_name, $row->descr, $row->ip, $row->request_from, $row->created_date));
		}
	
		fclose($handle);
	
		$headers = array(
			'Content-Type' => 'text/csv',
		);
		
		return \Response::download($filename, 'logs.csv', $headers);
	}
	// logs page
		
	// Game
	public function gamepage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.game');
	}	
	public function admin_game_entry_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$teams = DB::table('team')->orderBy('Name', 'asc')->pluck('Name','id');
		$demandtype = DB::table('demandtype')->orderBy('Name', 'asc')->pluck('Name','id');
		$pricingtype = DB::table('pricingtype')->orderBy('Name', 'asc')->pluck('Name','id');
		$gamerequeststate = DB::table('gamerequeststate')->orderBy('Name', 'asc')->pluck('Name','id');
		$gamestate = DB::table('gamestate')->orderBy('Name', 'asc')->pluck('Name','id');
		$allocationpooltype = DB::table('allocationpooltype')->orderBy('Name', 'desc')->pluck('Name','id');
		
		$latestCode = DB::table('game')->orderBy('ID', 'DESC')->take(1)->pluck('EventCode');
		$eventcode = "";
		if($latestCode != ""){
			$first = substr($latestCode[0],0, 3);
			$last = substr($latestCode[0], 3) + 1;
			$eventcode = $first.str_pad($last, 4, '0', STR_PAD_LEFT);
		}		
		return view('admin.game-entry', compact('teams', 'demandtype', 'pricingtype', 'gamerequeststate', 'gamestate', 'eventcode', 'allocationpooltype'));
	}	
	public function admin_post_game_entry(Request $request){
		$EventCode = $request->input('EventCode');
		$GameNumber = $request->input('GameNumber');
				
		$OriginalGameDate = "";
		if($request->input('OriginalGameDate') != ""){
			$tmp = explode(",", $request->input('OriginalGameDate'));
			$tmpdate = explode("/", $tmp[0]);
			$tmptime = $tmp[1];
			$OriginalGameDate = $tmpdate[2].'-'.$tmpdate[0].'-'.$tmpdate[1].' '.$tmptime;
			$OriginalGameDate = date("Y-m-d H:i:s", strtotime($OriginalGameDate));
		}
		$ScheduledGameDate = NULL;
		if($request->input('ScheduledGameDate') != ""){
			$tmp = explode(",", $request->input('ScheduledGameDate'));
			$tmpdate = explode("/", $tmp[0]);
			$tmptime = $tmp[1];
			$ScheduledGameDate = $tmpdate[2].'-'.$tmpdate[0].'-'.$tmpdate[1].' '.$tmptime;
			$ScheduledGameDate = date("Y-m-d H:i:s", strtotime($ScheduledGameDate));
		}
		$team_id = $request->input('team_id');
		$demandtype_id = $request->input('demandtype_id');
		$pricingtype_id = $request->input('pricingtype_id');
		$requeststate_id = $request->input('requeststate_id');
		$gamestate_id = $request->input('gamestate_id');
		
		$AllowCompPurchase = $request->input('AllowCompPurchase');
		$AllowPersonalRequests = $request->input('AllowPersonalRequests');
		$AllowCompTransfer = $request->input('AllowCompTransfer');
		
		$RequestDeadline = NULL;
		if($request->input('RequestDeadline') != ""){
			$tmp = explode(",", $request->input('RequestDeadline'));
			$tmpdate = explode("/", $tmp[0]);
			$tmptime = $tmp[1];
			$RequestDeadline = $tmpdate[2].'-'.$tmpdate[0].'-'.$tmpdate[1].' '.$tmptime;
			$RequestDeadline = date("Y-m-d H:i:s", strtotime($RequestDeadline));
		}
		
		$allocationpooltype_id = $request->input('allocationpooltype_id');
		$IsSellout = $request->input('IsSellout')?$request->input('IsSellout'):0;		
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('Y-m-d H:i:s');
		
		$count = DB::table('game')->where('EventCode', '=', $EventCode)->count();
		if($count > 0){
			return redirect('adminpanel/game/entry')->with('errmsg','')->with('eventcode', $EventCode);
		}else{
			//echo $ScheduledGameDate;exit;
			$id = DB::table('game')->insertGetId(array('EventCode'=>$EventCode,'GameNumber'=>$GameNumber,'OriginalGameDate'=>$OriginalGameDate,'ScheduledGameDate'=>$ScheduledGameDate,'team_id'=>$team_id,'demandtype_id'=>$demandtype_id,'pricingtype_id'=>$pricingtype_id,'requeststate_id'=>$requeststate_id,'gamestate_id'=>$gamestate_id,'AllowCompPurchase'=>$AllowCompPurchase, 'AllowPersonalRequests'=>$AllowPersonalRequests, 'AllowCompTransfer'=>$AllowCompTransfer,'IsSellout'=>$IsSellout,'RequestDeadline'=>$RequestDeadline, 'CreateDate'=>$CreateDate,'LastUpdate'=>$CreateDate));
			
			DB::table('allocationpoolgames')->insert(array('game_id'=>$id,'allocationpooltype_id'=>$allocationpooltype_id,'CreateDate'=>$CreateDate));
			
			return redirect('adminpanel/game');
		}
	}	
	public function admin_game_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('game')->where('id', '=', $pk_id)->get();
		$teams = DB::table('team')->orderBy('Name', 'asc')->pluck('Name','id');
		$demandtype = DB::table('demandtype')->orderBy('Name', 'asc')->pluck('Name','id');
		$pricingtype = DB::table('pricingtype')->orderBy('Name', 'asc')->pluck('Name','id');
		$gamerequeststate = DB::table('gamerequeststate')->orderBy('Name', 'asc')->pluck('Name','id');
		$gamestate = DB::table('gamestate')->orderBy('Name', 'asc')->pluck('Name','id');
		$allocationpooltype = DB::table('allocationpooltype')->orderBy('Name', 'desc')->pluck('Name','id');
		
		return view('admin.game-edit', compact('data','teams', 'demandtype', 'pricingtype', 'gamerequeststate', 'gamestate', 'eventcode', 'allocationpooltype'));
	}	
	public function admin_post_game_edit(Request $request){
		
		$pk_id = $request->input('pk_id');
		$EventCode = $request->input('EventCode');
		$GameNumber = $request->input('GameNumber');
		
		$OriginalGameDate = "";
		if($request->input('OriginalGameDate') != ""){
			$tmp = explode(",", $request->input('OriginalGameDate'));
			$tmpdate = explode("/", $tmp[0]);
			$tmptime = $tmp[1];
			$OriginalGameDate = $tmpdate[2].'-'.$tmpdate[0].'-'.$tmpdate[1].' '.$tmptime;
			$OriginalGameDate = date("Y-m-d H:i:s", strtotime($OriginalGameDate));
		}
		$ScheduledGameDate = NULL;
		if($request->input('ScheduledGameDate') != ""){
			$tmp = explode(",", $request->input('ScheduledGameDate'));
			$tmpdate = explode("/", $tmp[0]);
			$tmptime = $tmp[1];
			$ScheduledGameDate = $tmpdate[2].'-'.$tmpdate[0].'-'.$tmpdate[1].' '.$tmptime;
			$ScheduledGameDate = date("Y-m-d H:i:s", strtotime($ScheduledGameDate));
		}
		$team_id = $request->input('team_id');
		$demandtype_id = $request->input('demandtype_id');
		$pricingtype_id = $request->input('pricingtype_id');
		$requeststate_id = $request->input('requeststate_id');
		$gamestate_id = $request->input('gamestate_id');
		
		$AllowCompPurchase = $request->input('AllowCompPurchase');
		$AllowPersonalRequests = $request->input('AllowPersonalRequests');
		$AllowCompTransfer = $request->input('AllowCompTransfer');
		
		$RequestDeadline = NULL;
		if($request->input('ScheduledGameDate') != ""){
			$tmp = explode(",", $request->input('RequestDeadline'));
			$tmpdate = explode("/", $tmp[0]);
			$tmptime = $tmp[1];
			$RequestDeadline = $tmpdate[2].'-'.$tmpdate[0].'-'.$tmpdate[1].' '.$tmptime;
			$RequestDeadline = date("Y-m-d H:i:s", strtotime($RequestDeadline));
		}
		
		$allocationpooltype_id = $request->input('allocationpooltype_id');
		$IsSellout = $request->input('IsSellout')?$request->input('IsSellout'):0;		
		$LastUpdate = date('Y-m-d H:i:s');
		
		$count = DB::table('game')->where('EventCode', '=', $EventCode)->where('id', '!=', $pk_id)->count();
		if($count > 0){
			return redirect('adminpanel/game/'.$pk_id.'/edit')->with('errmsg','')->with('eventcode', $EventCode);
		}else{
			//echo $ScheduledGameDate;exit;
			DB::table('game')->where('id','=',$pk_id)->update(array('EventCode'=>$EventCode,'GameNumber'=>$GameNumber,'OriginalGameDate'=>$OriginalGameDate,'ScheduledGameDate'=>$ScheduledGameDate,'team_id'=>$team_id,'demandtype_id'=>$demandtype_id,'pricingtype_id'=>$pricingtype_id,'requeststate_id'=>$requeststate_id,'gamestate_id'=>$gamestate_id,'AllowCompPurchase'=>$AllowCompPurchase, 'AllowPersonalRequests'=>$AllowPersonalRequests, 'AllowCompTransfer'=>$AllowCompTransfer,'IsSellout'=>$IsSellout,'RequestDeadline'=>$RequestDeadline, 'LastUpdate'=>$LastUpdate));
		}
		DB::table('allocationpoolgames')->where('game_id','=',$pk_id)->update(array('allocationpooltype_id'=>$allocationpooltype_id));
		return redirect('adminpanel/game');
	}	
	public function admin_game_delete($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		DB::table('game')->where('id', '=', $pk_id)->delete();
		DB::table('allocationpoolgames')->where('game_id', '=', $pk_id)->delete();
		
		return redirect('adminpanel/game');
	}
	// Game
	
	// Site Resource Type
	public function siteresourcetypepage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$query = $request->input('search');
		if($query){
			$data = DB::table('siteresourcetype')->where('Name', 'LIKE', '%' . $query . '%')->paginate(20);
		}else{
			$data = DB::table('siteresourcetype')->orderBy('id', 'desc')->paginate(20);
		}
		return view('admin.siteresourcetype', compact('data', 'query'));
	}	
	public function admin_siteresourcetype_entry_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.siteresourcetype-entry');
	}	
	public function admin_post_siteresourcetype_entry(Request $request){
		$Name = $request->input('Name');
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('Y-m-d H:i:s');
		
		$count = DB::table('siteresourcetype')->where('Name', '=', $Name)->count();
		if($count > 0){
			return redirect('adminpanel/siteresourcetype/entry')->with('errmsg','')->with('Name', $Name);
		}else{
			
			DB::table('siteresourcetype')->insertGetId(array('Name'=>$Name,'CreateDate'=>$CreateDate));
			
			return redirect('adminpanel/siteresourcetype');
		}
	}	
	public function admin_siteresourcetype_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('siteresourcetype')->where('id', '=', $pk_id)->get();
		return view('admin.siteresourcetype-edit')->with('data', $data);
	}	
	public function admin_post_siteresourcetype_edit(Request $request){
		$Name = $request->input('Name');
		$pk_id = $request->input('pk_id');
		
		$count = DB::table('siteresourcetype')->where('Name', '=', $Name)->where('id', '!=', $pk_id)->count();
		if($count > 0){
			return redirect('adminpanel/siteresourcetype/'.$pk_id.'/edit')->with('errmsg','');
		}else{
			
			DB::table('siteresourcetype')->where('id','=',$pk_id)->update(array('Name'=>$Name));
			
			return redirect('adminpanel/siteresourcetype');
		}
	}	
	public function admin_siteresourcetype_delete($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		DB::table('siteresourcetype')->where('id', '=', $pk_id)->delete();
		
		return redirect('adminpanel/siteresourcetype');
	}
	// Site Resource Type
	
	// Ticket Resource Type
	public function ticketsourcetypepage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$query = $request->input('search');
		if($query){
			$data = DB::table('ticketsourcetype')->where('Name', 'LIKE', '%' . $query . '%')->paginate(20);
		}else{
			$data = DB::table('ticketsourcetype')->orderBy('id', 'desc')->paginate(20);
		}
		return view('admin.ticketsourcetype', compact('data', 'query'));
	}	
	public function admin_ticketsourcetype_entry_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.ticketsourcetype-entry');
	}	
	public function admin_post_ticketsourcetype_entry(Request $request){
		$Name = $request->input('Name');
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('Y-m-d H:i:s');
		
		$count = DB::table('ticketsourcetype')->where('Name', '=', $Name)->count();
		if($count > 0){
			return redirect('adminpanel/ticketsourcetype/entry')->with('errmsg','')->with('Name', $Name);
		}else{
			
			DB::table('ticketsourcetype')->insertGetId(array('Name'=>$Name,'CreateDate'=>$CreateDate));
			
			return redirect('adminpanel/ticketsourcetype');
		}
	}	
	public function admin_ticketsourcetype_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('ticketsourcetype')->where('id', '=', $pk_id)->get();
		return view('admin.ticketsourcetype-edit')->with('data', $data);
	}	
	public function admin_post_ticketsourcetype_edit(Request $request){
		$Name = $request->input('Name');
		$pk_id = $request->input('pk_id');
		
		$count = DB::table('ticketsourcetype')->where('Name', '=', $Name)->where('id', '!=', $pk_id)->count();
		if($count > 0){
			return redirect('adminpanel/ticketsourcetype/'.$pk_id.'/edit')->with('errmsg','');
		}else{
			
			DB::table('ticketsourcetype')->where('id','=',$pk_id)->update(array('Name'=>$Name));
			
			return redirect('adminpanel/ticketsourcetype');
		}
	}	
	public function admin_ticketsourcetype_delete($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		DB::table('ticketsourcetype')->where('id', '=', $pk_id)->delete();
		
		return redirect('adminpanel/ticketsourcetype');
	}
	// Ticket Resource Type
	
	// Promotion
	public function requests_fully_approved_page(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$query = $request->input('search');
		if($query){
			//$data = DB::table('request')->andWhere('is_forward_to_fulfil', 1)->orWhere('RecipientFirstName', 'LIKE', '%' . $query . '%')->orWhere('RecipientLastName', 'LIKE', '%' . $query . '%')->paginate(50);
			//$data = DB::table('request')->where('is_forward_to_fulfil', 1)->orderBy('id', 'desc')->paginate(50);
		}else{
			//$data = DB::table('request')->where('is_forward_to_fulfil', 1)->orderBy('id', 'desc')->paginate(50);
		}
		return view('admin.requests-fully-approved', compact('', 'query'));
	}
	
	// Promotion
	public function promotionpage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$query = $request->input('search');
		if($query){
			$data = DB::table('promotion')->where('Name', 'LIKE', '%' . $query . '%')->paginate(20);
		}else{
			$data = DB::table('promotion')->orderBy('id', 'desc')->paginate(20);
		}
		return view('admin.promotion', compact('data', 'query'));
	}	
	public function admin_promotion_entry_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.promotion-entry');
	}	
	public function admin_post_promotion_entry(Request $request){
		$Name = $request->input('Name');
		
		$timestamp =strtotime("now");
		$dt = new \DateTime("@$timestamp");
		$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
		$dt->setTimeZone($destinationTimezone);
		$CreateDate = $dt->format('Y-m-d H:i:s');
		
		$count = DB::table('promotion')->where('Name', '=', $Name)->count();
		if($count > 0){
			return redirect('adminpanel/promotion/entry')->with('errmsg','')->with('Name', $Name);
		}else{
			
			DB::table('promotion')->insertGetId(array('Name'=>$Name,'CreateDate'=>$CreateDate));
			
			return redirect('adminpanel/promotion');
		}
	}	
	public function admin_promotion_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('promotion')->where('id', '=', $pk_id)->get();
		return view('admin.promotion-edit')->with('data', $data);
	}	
	public function admin_post_promotion_edit(Request $request){
		$Name = $request->input('Name');
		$pk_id = $request->input('pk_id');
		
		$count = DB::table('promotion')->where('Name', '=', $Name)->where('id', '!=', $pk_id)->count();
		if($count > 0){
			return redirect('adminpanel/promotion/'.$pk_id.'/edit')->with('errmsg','');
		}else{
			
			DB::table('promotion')->where('id','=',$pk_id)->update(array('Name'=>$Name));
			
			return redirect('adminpanel/promotion');
		}
	}	
	public function admin_promotion_delete($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		DB::table('promotion')->where('id', '=', $pk_id)->delete();
		
		return redirect('adminpanel/promotion');
	}
	// Promotion
	
	// Email Template
	public function emailtemplatepage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.emailtemplate');
	}
	public function admin_emailtemplate_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('emailtemplate')->where('id', '=', $pk_id)->get();
		return view('admin.emailtemplate-edit')->with('data', $data);
	}	
	public function admin_post_emailtemplate_edit(Request $request){
		$title = $request->input('title');
		$subject = $request->input('subject');
		$contents = $request->input('contents');
		$pk_id = $request->input('pk_id');
		
		DB::table('emailtemplate')->where('id','=',$pk_id)->update(array('title'=>$title, 'subject'=>$subject,'contents'=>$contents));
		
		return redirect('adminpanel/emailtemplate');
	}
	// Email Template
	
	public function logout(){
		
		Session::forget('ecomps_admin_id');
		Session::forget('ecomps_user_name');
		
		Session::forget('ecomps_subadmin');
		Session::forget('ecomps_user_full_name');
		Session::forget('ecomps_subadmin_allow_pages');
		
		return redirect('/adminpanel');
	}
	public function admin_reports_requested_by_users(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.reports_requested_by_users');
	}
	public function admin_post_reports_requested_users_download(Request $request){
		$requestor = $request->input('tmp_requestor');
		$tmp_sdate = $request->input('tmp_start_date');
		$tmp_edate = $request->input('tmp_end_date');
		
		$sch='';
		if($requestor != ''){
			$sch=$sch."requestor_id = '$requestor' AND ";
		}
		if($tmp_sdate != "" && $tmp_edate != ""){
			$sch=$sch." (DATE(CreateDate) BETWEEN '$tmp_sdate' AND '$tmp_edate') AND ";
		}
		if($tmp_sdate != "" && $tmp_edate == ""){
			$sch=$sch." DATE(CreateDate) >= '$tmp_sdate' AND ";
		}
		if($tmp_sdate == "" && $tmp_edate != ""){
			$sch=$sch." DATE(CreateDate) <= '$tmp_edate' AND ";
		}
		$sch = substr($sch,0,-5); 
		if($sch != ""){
			$str = "select * from request where ".$sch." order by CreateDate desc";
		}else{
			$str = "select * from request where id < 0";
		}
		//echo $str;exit;
		$data = DB::select(DB::raw($str));
		
		$filename = "requested-by-users-reports.csv";
		$handle = fopen($filename, 'w+');
		fputcsv($handle, array('Sl', 'Requestor', 'Game', 'Created', 'Recipient', 'Company', 'Department', 'Comp', 'Purch', 'Location', 'Delivery', 'Used'));
		
		$i = 1;
		foreach($data as $row) {
			$requester = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $row->requestor_id);
			$requester_name = '';
			if(count($requester) > 0){
				$requester_name = $requester->FirstName.' '.$requester->LastName;
			}
			$game_date = date('m/d/Y', strtotime(getDataFromTable("game","OriginalGameDate","id", $row->game_id )));
			$created = date('m/d/Y', strtotime($row->CreateDate));
			$recepient = $row->RecipientFirstName.' '.$row->RecipientLastName;
			$dept = getDataFromTable("department","Name","id", $row->dept_id);
			$company = $row->CompanyName;
			$comp = $row->Comp;
			$purch = $row->Purchased;
			$location = getDataFromTable("locationtype","Name","id", $row->locationtype_id);
			$delivery = getDataFromTable("deliverytype","Name","id", $row->deliverytype_id);
			$used = $row->Purchased.'/'.$row->Comp;
			
			fputcsv($handle, array($i, $requester_name, $game_date, $created, $recepient,$company, $dept, $comp, $purch, $location, $delivery, $used));
			
			$i++;
		}
	
		fclose($handle);
	
		$headers = array(
			'Content-Type' => 'text/csv',
		);
		
		return \Response::download($filename, 'requested-by-users-reports.csv', $headers);
	}
	public function admin_reports_requested_by_games(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.reports_requested_by_games');
	}
	public function admin_post_reports_requested_games_download(Request $request){
		$game = $request->input('tmp_game');
		$tmp_sdate = $request->input('tmp_start_date');
		$tmp_edate = $request->input('tmp_end_date');
		
		$sch='';
		if($game != ''){
			$sch=$sch."game_id = '$game' AND ";
		}
		if($tmp_sdate != "" && $tmp_edate != ""){
			$sch=$sch." (DATE(CreateDate) BETWEEN '$tmp_sdate' AND '$tmp_edate') AND ";
		}
		if($tmp_sdate != "" && $tmp_edate == ""){
			$sch=$sch." DATE(CreateDate) >= '$tmp_sdate' AND ";
		}
		if($tmp_sdate == "" && $tmp_edate != ""){
			$sch=$sch." DATE(CreateDate) <= '$tmp_edate' AND ";
		}
		$sch = substr($sch,0,-5); 
		if($sch != ""){
			$str = "select * from request where ".$sch." order by CreateDate desc";
		}else{
			$str = "select * from request where id < 0";
		}
		//echo $str;exit;
		$data = DB::select(DB::raw($str));
		
		$filename = "requested-by-games-reports.csv";
		$handle = fopen($filename, 'w+');
		fputcsv($handle, array('Sl', 'Requestor', 'Game', 'Created', 'Recipient', 'Company', 'Department', 'Comp', 'Purch', 'Location', 'Delivery', 'Used'));
		
		$i = 1;
		foreach($data as $row) {
			$requester = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $row->requestor_id);
			$requester_name = '';
			if(count($requester) > 0){
				$requester_name = $requester->FirstName.' '.$requester->LastName;
			}
			$game_date = date('m/d/Y', strtotime(getDataFromTable("game","OriginalGameDate","id", $row->game_id )));
			$created = date('m/d/Y', strtotime($row->CreateDate));
			$recepient = $row->RecipientFirstName.' '.$row->RecipientLastName;
			$dept = getDataFromTable("department","Name","id", $row->dept_id);
			$company = $row->CompanyName;
			$comp = $row->Comp;
			$purch = $row->Purchased;
			$location = getDataFromTable("locationtype","Name","id", $row->locationtype_id);
			$delivery = getDataFromTable("deliverytype","Name","id", $row->deliverytype_id);
			$used = $row->Purchased.'/'.$row->Comp;
			
			fputcsv($handle, array($i, $requester_name, $game_date, $created, $recepient,$company, $dept, $comp, $purch, $location, $delivery, $used));
			
			$i++;
		}
	
		fclose($handle);
	
		$headers = array(
			'Content-Type' => 'text/csv',
		);
		
		return \Response::download($filename, 'requested-by-games-reports.csv', $headers);
	}
	public function admin_reports_requested_by_teams(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.reports_requested_by_teams');
	}
	public function admin_post_reports_requested_teams_download(Request $request){
		$game = $request->input('tmp_game');
		$tmp_sdate = $request->input('tmp_start_date');
		$tmp_edate = $request->input('tmp_end_date');
		
		$sch='';
		if($game != ''){
			$sch=$sch."game_id = '$game' AND ";
		}
		if($tmp_sdate != "" && $tmp_edate != ""){
			$sch=$sch." (DATE(CreateDate) BETWEEN '$tmp_sdate' AND '$tmp_edate') AND ";
		}
		if($tmp_sdate != "" && $tmp_edate == ""){
			$sch=$sch." DATE(CreateDate) >= '$tmp_sdate' AND ";
		}
		if($tmp_sdate == "" && $tmp_edate != ""){
			$sch=$sch." DATE(CreateDate) <= '$tmp_edate' AND ";
		}
		$sch = substr($sch,0,-5); 
		if($sch != ""){
			$str = "select * from request where ".$sch." order by CreateDate desc";
		}else{
			$str = "select * from request where id < 0";
		}
		//echo $str;exit;
		$data = DB::select(DB::raw($str));
		
		$filename = "requested-by-teams-reports.csv";
		$handle = fopen($filename, 'w+');
		fputcsv($handle, array('Sl', 'Requestor', 'Game', 'Created', 'Recipient', 'Company', 'Department', 'Comp', 'Purch', 'Location', 'Delivery', 'Used'));
		
		$i = 1;
		foreach($data as $row) {
			$requester = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $row->requestor_id);
			$requester_name = '';
			if(count($requester) > 0){
				$requester_name = $requester->FirstName.' '.$requester->LastName;
			}
			$game_date = date('m/d/Y', strtotime(getDataFromTable("game","OriginalGameDate","id", $row->game_id )));
			$created = date('m/d/Y', strtotime($row->CreateDate));
			$recepient = $row->RecipientFirstName.' '.$row->RecipientLastName;
			$dept = getDataFromTable("department","Name","id", $row->dept_id);
			$company = $row->CompanyName;
			$comp = $row->Comp;
			$purch = $row->Purchased;
			$location = getDataFromTable("locationtype","Name","id", $row->locationtype_id);
			$delivery = getDataFromTable("deliverytype","Name","id", $row->deliverytype_id);
			$used = $row->Purchased.'/'.$row->Comp;
			
			fputcsv($handle, array($i, $requester_name, $game_date, $created, $recepient,$company, $dept, $comp, $purch, $location, $delivery, $used));
			
			$i++;
		}
	
		fclose($handle);
	
		$headers = array(
			'Content-Type' => 'text/csv',
		);
		
		return \Response::download($filename, 'requested-by-teams-reports.csv', $headers);
	}
	public function admin_reports_fulfilled_by_date(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.reports_fulfilled_by_date');
	}
	public function admin_post_reports_fulfilled_date_download(Request $request){
		
		$tmp_sdate = $request->input('tmp_start_date');
		$tmp_edate = $request->input('tmp_end_date');
		
		$sch='';
		if($tmp_sdate != "" && $tmp_edate != ""){
			$sch=$sch." (DATE(CreateDate) BETWEEN '$tmp_sdate' AND '$tmp_edate') AND ";
		}
		if($tmp_sdate != "" && $tmp_edate == ""){
			$sch=$sch." DATE(CreateDate) >= '$tmp_sdate' AND ";
		}
		if($tmp_sdate == "" && $tmp_edate != ""){
			$sch=$sch." DATE(CreateDate) <= '$tmp_edate' AND ";
		}
		$sch = substr($sch,0,-5); 
		if($sch != ""){
			$str = "select * from request where is_fulfil=1 And ".$sch." order by CreateDate desc";
		}else{
			$str = "select * from request where id < 0";
		}
		//echo $str;exit;
		$data = DB::select(DB::raw($str));
		
		$filename = "fulfilled-by-date-reports.csv";
		$handle = fopen($filename, 'w+');
		fputcsv($handle, array('Sl', 'Requestor', 'Game', 'Created', 'Recipient', 'Company', 'Department', 'Comp', 'Purch', 'Location', 'Delivery', 'Used'));
		
		$i = 1;
		foreach($data as $row) {
			$requester = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $row->requestor_id);
			$requester_name = '';
			if(count($requester) > 0){
				$requester_name = $requester->FirstName.' '.$requester->LastName;
			}
			$game_date = date('m/d/Y', strtotime(getDataFromTable("game","OriginalGameDate","id", $row->game_id )));
			$created = date('m/d/Y', strtotime($row->CreateDate));
			$recepient = $row->RecipientFirstName.' '.$row->RecipientLastName;
			$dept = getDataFromTable("department","Name","id", $row->dept_id);
			$company = $row->CompanyName;
			$comp = $row->Comp;
			$purch = $row->Purchased;
			$location = getDataFromTable("locationtype","Name","id", $row->locationtype_id);
			$delivery = getDataFromTable("deliverytype","Name","id", $row->deliverytype_id);
			$used = $row->Purchased.'/'.$row->Comp;
			
			fputcsv($handle, array($i, $requester_name, $game_date, $created, $recepient,$company, $dept, $comp, $purch, $location, $delivery, $used));
			
			$i++;
		}
	
		fclose($handle);
	
		$headers = array(
			'Content-Type' => 'text/csv',
		);
		
		return \Response::download($filename, 'fulfilled-by-date-reports.csv', $headers);
	}
	public function admin_reports_fulfilled_by_games(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.reports_fulfilled_by_games');
	}
	public function admin_post_reports_fulfilled_games_download(Request $request){
		$game = $request->input('tmp_game');
		$tmp_sdate = $request->input('tmp_start_date');
		$tmp_edate = $request->input('tmp_end_date');
		
		$sch='';
		if($game != ''){
			$sch=$sch."game_id = '$game' AND ";
		}
		if($tmp_sdate != "" && $tmp_edate != ""){
			$sch=$sch." (DATE(CreateDate) BETWEEN '$tmp_sdate' AND '$tmp_edate') AND ";
		}
		if($tmp_sdate != "" && $tmp_edate == ""){
			$sch=$sch." DATE(CreateDate) >= '$tmp_sdate' AND ";
		}
		if($tmp_sdate == "" && $tmp_edate != ""){
			$sch=$sch." DATE(CreateDate) <= '$tmp_edate' AND ";
		}
		$sch = substr($sch,0,-5); 
		if($sch != ""){
			$str = "select * from request where is_fulfil=1 And ".$sch." order by CreateDate desc";
		}else{
			$str = "select * from request where id < 0";
		}
		//echo $str;exit;
		$data = DB::select(DB::raw($str));
		
		$filename = "fulfilled-by-games-reports.csv";
		$handle = fopen($filename, 'w+');
		fputcsv($handle, array('Sl', 'Requestor', 'Game', 'Created', 'Recipient', 'Company', 'Department', 'Comp', 'Purch', 'Location', 'Delivery', 'Used'));
		
		$i = 1;
		foreach($data as $row) {
			$requester = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $row->requestor_id);
			$requester_name = '';
			if(count($requester) > 0){
				$requester_name = $requester->FirstName.' '.$requester->LastName;
			}
			$game_date = date('m/d/Y', strtotime(getDataFromTable("game","OriginalGameDate","id", $row->game_id )));
			$created = date('m/d/Y', strtotime($row->CreateDate));
			$recepient = $row->RecipientFirstName.' '.$row->RecipientLastName;
			$dept = getDataFromTable("department","Name","id", $row->dept_id);
			$company = $row->CompanyName;
			$comp = $row->Comp;
			$purch = $row->Purchased;
			$location = getDataFromTable("locationtype","Name","id", $row->locationtype_id);
			$delivery = getDataFromTable("deliverytype","Name","id", $row->deliverytype_id);
			$used = $row->Purchased.'/'.$row->Comp;
			
			fputcsv($handle, array($i, $requester_name, $game_date, $created, $recepient,$company, $dept, $comp, $purch, $location, $delivery, $used));
			
			$i++;
		}
	
		fclose($handle);
	
		$headers = array(
			'Content-Type' => 'text/csv',
		);
		
		return \Response::download($filename, 'fulfilled-by-games-reports.csv', $headers);
	}
	
	public function admin_get_error_page(){
		return view('err');
	}
	
	public function admin_post_error_logs(Request $request){
		
		$user_id = Session::get('ecomps_user_id')?Session::get('ecomps_user_id'):Session::get('ecomps_admin_id');
		if($user_id == ""){ $user_id = 0; }
		$page_url = $request->input('page_url');
		$err_desc = $request->input('err_desc');
		$created_date = date('Y-m-d H:i:s');
		
		DB::table('error_logs')->insertGetId(array('user_id'=>$user_id,'page_url'=>$page_url,'err_desc'=>$err_desc,'created_date'=>$created_date));
		
		return "success";exit;
	}
	public function admin_get_error_logs_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.error_logs');
	}
	public function admin_post_error_logs_multi_delete(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$checkValues = $request->input('checkValues');
		for($i = 0; $i < count($checkValues); $i++){
			$id = $checkValues[$i];
			DB::table('error_logs')->where('id', '=', $id)->delete();			
		}
		return "success";exit;
	}
	public function admin_500_customize_page(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}else{
			$err_data=DB::table("appsettings")->where('id',"=",4)->get();
			return view('admin.500_customize_error')->with('data',$err_data);
		}
		
	}
	public function edit_customize_error(Request $request){
	
		$contents=$request->input("contents");
		DB::table("appsettings")->where('id','=',4)->update(array('Value'=>$contents));
		return redirect('adminpanel/500_customize_error');
	}
	
	public function admin_maintenance_message_page(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}else{
			$err_data=DB::table("appsettings")->where('id',"=",6)->get();
			return view('admin.maintenance_message_page')->with('data',$err_data);
		}
		
	}
	public function admin_post_maintenance_message(Request $request){
		
		$contents=$request->input("contents");
		DB::table("appsettings")->where('id','=',6)->update(array('Value'=>$contents));
		return redirect('adminpanel/customize_maintenance_message');
	}
		
	public function site_mode_page(Request $request){
		return view('500_mode');
	}		
}