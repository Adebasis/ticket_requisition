<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Mail;
use Session;

class ReqController extends Controller{
	
	public function __construct(){
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }
		
	public function RequestPageMessageBoard($request_id){
		
		$ecomps_admin_id = Session::get('ecomps_user_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}
				
		// Update read message
		DB::table('request_message')->where('request_id','=',$request_id)->update(array('readby_requestor'=>1));
		
		return view('requests-message-board', compact('request_id'));
	}
	
	public function Post_RequestPageMessageBoard(Request $request){
		
		$ecomps_admin_id = Session::get('ecomps_user_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/');
		}		
		$request_id = $request->request_id;
		$message = $request->message;
		$CreateDate = date('Y-m-d H:i:s');
		
		DB::table('request_message')->insert(array('request_id'=>$request_id, 'message'=>nl2br($message), 'user_id'=>$ecomps_admin_id, 'created_date'=>$CreateDate));
		return "success";exit;
	}
	public function RequestPageMessageBoard_loadmore(Request $request){
		
		$request_id = $request->request_id;
		$last_id = $request->last_id;
		$row_id = $request->row_id;
		$arr_ = $request->arr_;
		$request_msg_count = $request->request_msg_count;
		$current_msg_count = DB::table('request_message')->where('request_id', '=', $request_id)->count();
		if($current_msg_count > $request_msg_count){
			return view('requests-message-board-load-more', compact('request_id', 'last_id', 'arr_', 'row_id'));
		}
	}
}