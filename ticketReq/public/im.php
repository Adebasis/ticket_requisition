<?php
ini_set('max_execution_time', 3600);

// MYSQL Connect
//$mysqlcon = mysqli_connect("localhost","root","","ecomps") or die('Oops connection error -> ' . mysqli_connect_error());
$mysqlcon = mysqli_connect("localhost","root","Firefly98","test") or die('Oops connection error -> ' . mysqli_connect_error());

if(isset($_REQUEST['action']) && $_REQUEST['action'] == "game"){
	
	$str = "select * from test.games";
	$qry = mysqli_query($mysqlcon, $str);
	while($res = mysqli_fetch_assoc($qry)){
		
		$GameId = $res['GameId'];
		$EventCode = $res['EventCode'];
		$GameNumber = $res['GameNumber'];
		$OriginalGameDate = date('Y-m-d H:i:s', strtotime($res['OriginalGameDate']));
		
		//$ScheduledGameDate = "";
		//if($res['ScheduledGameDate'] != ""){
		//	$ScheduledGameDate = date('Y-m-d H:i:s', strtotime($res['ScheduledGameDate']));
		//}
		$OpponentId = $res['OpponentId'];
		
		$DemandTypeCode = $res['DemandTypeCode'];
		$PricingTypeCode = $res['PricingTypeCode'];
		$RequestStateCode = $res['RequestStateCode'];
		
		$AllowCompPurchase = $res['AllowCompPurchase'];
		$AllowPersonalRequests = $res['AllowPersonalRequests'];
		$AllowCompTransfer = $res['AllowCompTransfer'];
		$GameStateCode = $res['GameStateCode'];
		$IsSellout = $res['IsSellout'];
		$RequestDeadline = date('Y-m-d H:i:s', strtotime($res['RequestDeadline']));
		
		
		$str1 = "select id from team where teamid='$res[OpponentId]'";
		$qry1 = mysqli_query($mysqlcon, $str1);
		$res1 = mysqli_fetch_assoc($qry1);	
		$team_id = $res1['id'];
		
		$str1 = "select id from DemandType where DemandTypeCode='$res[DemandTypeCode]'";
		$qry1 = mysqli_query($mysqlcon, $str1);
		$res1 = mysqli_fetch_assoc($qry1);	
		$DemandType_id = $res1['id'];
		
		$str1 = "select id from PricingType where PricingTypeCode='$res[PricingTypeCode]'";
		$qry1 = mysqli_query($mysqlcon, $str1);
		$res1 = mysqli_fetch_assoc($qry1);	
		$PricingType_id = $res1['id'];
		
		$str1 = "select id from gamerequeststate where RequestStateCode='$res[RequestStateCode]'";
		$qry1 = mysqli_query($mysqlcon, $str1);
		$res1 = mysqli_fetch_assoc($qry1);	
		$RequestState_id = $res1['id'];
		
		$str1 = "select id from gamestate where GameStateCode='$res[GameStateCode]'";
		$qry1 = mysqli_query($mysqlcon, $str1);
		$res1 = mysqli_fetch_assoc($qry1);	
		$gamestate_id = $res1['id'];
		
		echo $str = "insert into test.game_new set EventCode='$EventCode',GameNumber='$GameNumber',OriginalGameDate='$OriginalGameDate',team_id='$team_id',DemandType_id='$DemandType_id',PricingType_id='$PricingType_id',RequestState_id='$RequestState_id',AllowCompPurchase='$AllowCompPurchase',AllowPersonalRequests='$AllowPersonalRequests',AllowCompTransfer='$AllowCompTransfer',gamestate_id='$gamestate_id',IsSellout='0',RequestDeadline='$RequestDeadline',CreateDate=null,LastUpdate=null";
		
		mysqli_query($mysqlcon, $str);
	}
}
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "user"){
	$str = "select * from test.useraccounts";
	$qry = mysqli_query($mysqlcon, $str);
	while($res = mysqli_fetch_assoc($qry)){
			
		$FirstName = addslashes($res['FirstName']);
		$LastName = addslashes($res['LastName']);
		$EmailAddress = addslashes($res['EmailAddress']);
		
		$str1 = "select * from department where DeptId='$res[DeptId]'";
		$qry1 = mysqli_query($mysqlcon, $str1);
		$res1 = mysqli_fetch_assoc($qry1);	
		$dept_id = $res1['id'];
		if($dept_id == ""){
			$dept_id = 0;
		}
		$str1 = "select * from employeetype where EmployeeTypeCode='$res[EmployeeTypeCode]'";
		$qry1 = mysqli_query($mysqlcon, $str1);
		$res1 = mysqli_fetch_assoc($qry1);	
		$employeetype_id = $res1['id'];
		if($employeetype_id == ""){
			$employeetype_id = 0;
		}
		$password = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode('Met$2017')))));
			
		$str = "insert into test.useraccount_new set FirstName='$FirstName',LastName='$LastName',EmailAddress='$EmailAddress',user_name='',dept_id='$dept_id',employeetype_id='$employeetype_id',password='$password',CreateDate=null,LastUpdate=null";
		mysqli_query($mysqlcon, $str);	
	}
}
exit;