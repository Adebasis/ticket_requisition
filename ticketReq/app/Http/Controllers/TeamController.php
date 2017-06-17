<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Mail;
use Session;

class TeamController extends Controller
{	
	public function __construct(){
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }
	
	// Team
	public function teamspage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		/*$query = $request->input('search');
		if($query){
			$data = DB::table('team')->where('Name', 'LIKE', '%' . $query . '%')->paginate(20);
		}else{
			$data = DB::table('team')->orderBy('id', 'desc')->paginate(20);
		}*/
		return view('admin.teams')->with('data', '')->with('query', '');
	}
	
	public function admin_teams_entry_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.teams-entry');
	}
	
	public function admin_post_team_entry(Request $request){
		$TeamCode = $request->input('TeamCode');
		$Name = $request->input('Name');
		$ShortName = $request->input('ShortName');
		$NickName = $request->input('NickName');
		$City = $request->input('City');
		$State = $request->input('State');
		$CreateDate = date('Y-m-d H:i:s');
		
		$count = DB::table('team')->where('TeamCode', '=', $TeamCode)->count();
		if($count > 0){
			return redirect('adminpanel/teams/entry')->with('errmsg','')->with('Name', $Name);
		}else{
			
			$id = DB::table('team')->insertGetId(array('TeamCode'=>$TeamCode,'Name'=>$Name,'ShortName'=>$ShortName,'NickName'=>$NickName,'City'=>$City,'State'=>$State,'CreateDate'=>$CreateDate,'LastUpdate'=>$CreateDate));
			
			return redirect('adminpanel/teams');
		}
	}
	
	public function admin_teams_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('team')->where('id', '=', $pk_id)->get();
		return view('admin.teams-edit')->with('data', $data);
	}
	
	public function admin_post_team_edit(Request $request){
		$TeamCode = $request->input('TeamCode');
		$Name = $request->input('Name');
		$ShortName = $request->input('ShortName');
		$NickName = $request->input('NickName');
		$City = $request->input('City');
		$State = $request->input('State');
		$pk_id = $request->input('pk_id');
		$LastUpdate = date('Y-m-d H:i:s');
		
		$count = DB::table('team')->where('TeamCode', '=', $TeamCode)->where('id', '!=', $pk_id)->count();
		if($count > 0){
			return redirect('adminpanel/teams/'.$pk_id.'/edit')->with('errmsg','');
		}else{
			
			DB::table('team')->where('id','=',$pk_id)->update(array('TeamCode'=>$TeamCode,'Name'=>$Name,'ShortName'=>$ShortName,'NickName'=>$NickName,'City'=>$City,'State'=>$State,'LastUpdate'=>$LastUpdate));
			
			return redirect('adminpanel/teams');
		}
	}
	
	public function admin_teams_delete($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		DB::table('team')->where('id', '=', $pk_id)->delete();

		return redirect('adminpanel/teams');
	}
	// Team
	
	
	//Delevary Group
	public function deliverygrouppage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$query = $request->input('search');
		if($query){
			$data = DB::table('deliverygroup')->where('Name', 'LIKE', '%' . $query . '%')->paginate(20);
		}else{
			$data = DB::table('deliverygroup')->orderBy('id', 'desc')->paginate(20);
		}
		return view('admin.deliverygroup')->with('data', $data)->with('query', $query);
	}
	
	public function admin_deliverygroup_entry_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$task = DB::table('deliverytype')->orderBy('id', 'asc')->get();
		return view('admin.deliverygroup-entry')->with('task', $task);
	}
	
	public function admin_post_deliverygroup_entry(Request $request){
		$Name = $request->input('Name');
		$id=$request->input('task_id');
		$CreateDate = date('Y-m-d H:i:s');
		$count = DB::table('deliverygroup')->where('Name', '=', $Name)->count();
		if($count > 0){
			return redirect('adminpanel/deliverygroup/entry')->with('errmsg','')->with('Name', $Name);
		}else{
			
			$deliverygroup_id = DB::table('deliverygroup')->insertGetId(array('Name'=>$Name,'CreateDate'=>$CreateDate));
			for($i=0; $i < count($id);$i++){
				$typeid=$id[$i];
				DB::table('deliverygrouptypes')->insert(array('deliverygroup_id'=>$deliverygroup_id,'deliverytype_id'=>$typeid,'CreateDate'=>$CreateDate));
			}
			return redirect('adminpanel/deliverygroup');
		}
	}
	
	public function admin_deliverygroup_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('deliverygroup')->where('id', '=', $pk_id)->get();
		$task = DB::table('deliverytype')->orderBy('id', 'asc')->get();
		$roletasks = DB::table('deliverygrouptypes')->select('deliverytype_id')->where('deliverygroup_id', '=', $pk_id)->pluck('deliverytype_id');
		return view('admin.deliverygroup-edit')->with('data', $data)->with('task', $task)->with('roletasks', $roletasks);
	}
	
	public function admin_post_deliverygroup_edit(Request $request){
		$Name = $request->input('Name');
		$pk_id = $request->input('pk_id');
		$id=$request->input('task_id');
		$CreateDate = date('Y-m-d H:i:s');
		
		$count = DB::table('deliverygroup')->where('Name', '=', $Name)->where('id', '!=', $pk_id)->count();
		if($count > 0){
			return redirect('adminpanel/deliverygroup/'.$pk_id.'/edit')->with('errmsg','');
		}else{
			
			DB::table('deliverygroup')->where('id','=',$pk_id)->update(array('Name'=>$Name));
			DB::table('deliverygrouptypes')->where('deliverygroup_id','=',$pk_id)->delete();
			for($i=0; $i < count($id);$i++){
				$typeid=$id[$i];
				DB::table('deliverygrouptypes')->insert(array('deliverygroup_id'=>$pk_id,'deliverytype_id'=>$typeid,'CreateDate'=>$CreateDate));
			}
			return redirect('adminpanel/deliverygroup');
		}
	}
	
	public function admin_deliverygroup_delete($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		DB::table('deliverygroup')->where('id', '=', $pk_id)->delete();
		DB::table('deliverygrouptypes')->where('deliverygroup_id', '=', $pk_id)->delete();

		return redirect('adminpanel/deliverygroup');
	}
	//Delevary Group
	
	
	// Pool Type
	public function allocationpooltypepage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$query = $request->input('search');
		if($query){
			$data = DB::table('allocationpooltype')->where('Name', 'LIKE', '%' . $query . '%')->paginate(20);
		}else{
			$data = DB::table('allocationpooltype')->orderBy('id', 'desc')->paginate(20);
		}
		return view('admin.allocationpooltype')->with('data', $data)->with('query', $query);
	}
	
	public function admin_allocationpooltype_entry_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.allocationpooltype-entry');
	}
	
	public function admin_post_allocationpooltype_entry(Request $request){
		$Name = $request->input('Name');
		$UiSort = $request->input('UiSort')?$request->input('UiSort'):0;
		$IsEnabled = $request->input('IsEnabled');
		$CreateDate = date('Y-m-d H:i:s');
		$count = DB::table('allocationpooltype')->where('Name', '=', $Name)->count();
		if($count > 0){
			return redirect('adminpanel/allocationpooltype/entry')->with('errmsg','')->with('Name', $Name);
		}else{
			
			$id = DB::table('allocationpooltype')->insertGetId(array('Name'=>$Name,'UiSort'=>$UiSort,'IsEnabled'=>$IsEnabled,'CreateDate'=>$CreateDate,'LastUpdate'=>$CreateDate));
			
			return redirect('adminpanel/allocationpooltype');
		}
	}
	
	public function admin_allocationpooltype_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('allocationpooltype')->where('id', '=', $pk_id)->get();
		return view('admin.allocationpooltype-edit')->with('data', $data);
	}
	
	public function admin_post_allocationpooltype_edit(Request $request){
		$Name = $request->input('Name');
		$UiSort = $request->input('UiSort')?$request->input('UiSort'):0;
		$IsEnabled = $request->input('IsEnabled');
		$CreateDate = date('Y-m-d H:i:s');
		$pk_id = $request->input('pk_id');
		$LastUpdate = date('Y-m-d H:i:s');
		
		$count = DB::table('allocationpooltype')->where('Name', '=', $Name)->where('id', '!=', $pk_id)->count();
		if($count > 0){
			return redirect('adminpanel/allocationpooltype/'.$pk_id.'/edit')->with('errmsg','');
		}else{
			
			DB::table('allocationpooltype')->where('id','=',$pk_id)->update(array('Name'=>$Name,'UiSort'=>$UiSort,'IsEnabled'=>$IsEnabled,'LastUpdate'=>$LastUpdate));
			
			return redirect('adminpanel/allocationpooltype');
		}
	}
	
	public function admin_allocationpooltype_delete($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		DB::table('allocationpooltype')->where('id', '=', $pk_id)->delete();

		return redirect('adminpanel/allocationpooltype');
	}
	// Pool Type
	
	// Approval Requirement Type
	public function approvalrequirementtypepage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$query = $request->input('search');
		if($query){
			$data = DB::table('approvalrequirementtype')->where('Description', 'LIKE', '%' . $query . '%')->paginate(20);
		}else{
			$data = DB::table('approvalrequirementtype')->orderBy('id', 'desc')->paginate(20);
		}
		return view('admin.approvalrequirementtype')->with('data', $data)->with('query', $query);
	}
	
	public function admin_approvalrequirementtype_entry_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.approvalrequirementtype-entry');
	}
	
	public function admin_post_approvalrequirementtype_entry(Request $request){
		$Description = $request->input('Description');
		$CreateDate = date('Y-m-d H:i:s');
		//$count = DB::table('approvalrequirementtype')->where('TeamCode', '=', $TeamCode)->count();
		//if($count > 0){
			//return redirect('adminpanel/approvalrequirementtype/entry')->with('errmsg','')->with('Name', $Name);
		//}else{
			
			$id = DB::table('approvalrequirementtype')->insertGetId(array('Description'=>$Description,'CreateDate'=>$CreateDate));
			
			return redirect('adminpanel/approvalrequirementtype');
		//}
	}
	
	public function admin_approvalrequirementtype_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('approvalrequirementtype')->where('id', '=', $pk_id)->get();
		return view('admin.approvalrequirementtype-edit')->with('data', $data);
	}
	
	public function admin_post_approvalrequirementtype_edit(Request $request){
		$pk_id = $request->input('pk_id');
		$Description = $request->input('Description');
		
			DB::table('approvalrequirementtype')->where('id','=',$pk_id)->update(array('Description'=>$Description));
			
			return redirect('adminpanel/approvalrequirementtype');
		
	}
	
	public function admin_approvalrequirementtype_delete($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		DB::table('approvalrequirementtype')->where('id', '=', $pk_id)->delete();

		return redirect('adminpanel/approvalrequirementtype');
	}
	// Approval Requirement Type
	
	// pricing Type
	public function pricingtypepage(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$query = $request->input('search');
		if($query){
			$data = DB::table('pricingtype')->where('Name', 'LIKE', '%' . $query . '%')->paginate(20);
		}else{
			$data = DB::table('pricingtype')->orderBy('id', 'desc')->paginate(20);
		}
		return view('admin.pricingtype')->with('data', $data)->with('query', $query);
	}
	
	public function admin_pricingtype_entry_page(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.pricingtype-entry');
	}
	
	public function admin_post_pricingtype_entry(Request $request){
		$Name = $request->input('Name');
		$Description = $request->input('Description');
		$UiSort = $request->input('UiSort')?$request->input('UiSort'):0;
		$IsEnabled = $request->input('IsEnabled');
		$CreateDate = date('Y-m-d H:i:s');
		$count = DB::table('pricingtype')->where('Name', '=', $Name)->count();
		if($count > 0){
			return redirect('adminpanel/pricingtype/entry')->with('errmsg','')->with('Name', $Name);
		}else{
			
			$id = DB::table('pricingtype')->insertGetId(array('Name'=>$Name,'Description'=>$Description,'UiSort'=>$UiSort,'IsEnabled'=>$IsEnabled,'CreateDate'=>$CreateDate,'LastUpdate'=>$CreateDate));
			
			return redirect('adminpanel/pricingtype');
		}
	}
	
	public function admin_pricingtype_edit_page($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		$data = DB::table('pricingtype')->where('id', '=', $pk_id)->get();
		return view('admin.pricingtype-edit')->with('data', $data);
	}
	
	public function admin_post_pricingtype_edit(Request $request){
		$Name = $request->input('Name');
		$Description = $request->input('Description');
		$UiSort = $request->input('UiSort')?$request->input('UiSort'):0;
		$IsEnabled = $request->input('IsEnabled');
		$CreateDate = date('Y-m-d H:i:s');
		$pk_id = $request->input('pk_id');
		$LastUpdate = date('Y-m-d H:i:s');
		
		$count = DB::table('pricingtype')->where('Name', '=', $Name)->where('id', '!=', $pk_id)->count();
		if($count > 0){
			return redirect('adminpanel/pricingtype/'.$pk_id.'/edit')->with('errmsg','');
		}else{
			
			DB::table('pricingtype')->where('id','=',$pk_id)->update(array('Name'=>$Name,'Description'=>$Description,'UiSort'=>$UiSort,'IsEnabled'=>$IsEnabled,'LastUpdate'=>$LastUpdate));
			
			return redirect('adminpanel/pricingtype');
		}
	}
	
	public function admin_pricingtype_delete($pk_id){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		DB::table('pricingtype')->where('id', '=', $pk_id)->delete();

		return redirect('adminpanel/pricingtype');
	}
	// pricing Type
	public function test_page(){
		
		Mail::raw('Hii Hello', function($message){
			$message->to("singkishor@gmail.com");
			$message->subject('My Test');
		});
		exit;
		
		$message="Hello";
		$user = array();
		$subject = 'Demo Subject';
		$content = 'Demo body';
		$domain = "deb-proj.com";
		
		$msg = new \Mailgun\Mailgun(env('MAILGUN_SECRET'));
		$msg->sendMessage($domain, array('from' => 'kishor@deb-proj.com',
		'to' => 'singkishor@gmail.com',
		'subject' => 'Sent from mailgun title',
		'text' => $message));
		dd('Mail Send Successfully');
		exit;
		
		$data = array('name'=>"Virat Gandhi");
   
		Mail::raw('Hi, welcome user!', function($message) {
		 $message->to('singkishor@gmail.com', 'Tutorials Point')->subject('Laravel Basic Testing Mail');
		 $message->from('prasanta4mohapatra@gmail.com','Virat Gandhi');
		});
		echo "Basic Email Sent. Check your inbox.";
		exit;
		
		$to_email = "singkishor@gmail.com";
		$name = "Prasanta";
		$from_email = "prasanta4mohapatra@gmail.com";
		$subject = "Testing";
		//$input_admin=$res_email_template_admin['contents'];  
		//$email_body = str_replace(array('%ADMINNAME%','%NAME%','%WEBSITE%','%EMAIL%','%COMMENT%','%PHONE%'),array($admin,$name,$Enqrer_Website,$from_email,$enq, $Enqrer_Website),$input_admin);
		$email_body = '<b>Hello</b>';
		
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: ".$name." <$from_email>\r\n";
		mail($to_email,$subject,$email_body,$headers);
		exit;
		
		//return view('admin.test');
	}
}