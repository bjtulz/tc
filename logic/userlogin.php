<?php
require "Medoo.php";

use Medoo\Medoo;

$type = "loginResult";


$state = "";
$userid = "";
$usertoken = "";
$usertokenexpire = "";
if ($_POST['userLoginname'] == "" || $_POST['userLogincath'] == ""){
	$state = 400;
}else{
	$userlogin = $_POST['userLoginname'];
	$usercath = $_POST['userLogincath'];
	
	$database = new Medoo([
	    'database_type' => 'mysql',
	    'database_name' => 'tc',
	    'server' => 'localhost',
	    'username' => 'tc',
	    'password' => 'lizhe20080722'
	    ]);
		
	$userData = $database->select("tc_user",
	                               "*",
								   ["tc_user_loginname" => $userlogin]);
	
	$userDataCount = sizeof($userData);
			
	if ($userDataCount == 0) {
		$loginstate = 301;
	} else {
		if ($userData[0]['tc_user_password'] == $usercath) {
			$str = md5(time().$userData[0]['tc_user_id']);
			$token = sha1($str);
			$expiretime = strtotime("+1 day");
			
			if ($database->has("tc_usertoken",["tc_usertoken_uid" =>$userData[0]['tc_user_id']]))
			{			
			$row = $database->update("tc_usertoken",[
			"tc_usertoken_token" => $token,
			"tc_usertoken_timelimit" => $expiretime
			],[
			"tc_usertoken_uid" => $userData[0]['tc_user_id']
			]);
			} else {
			$row = $database->insert("tc_usertoken",[
			"tc_usertoken_uid" => $userData[0]['tc_user_id'],
			"tc_usertoken_token" => $token,
			"tc_usertoken_timelimit" => $expiretime
			]);
			}
			
			$rowcount = $row->rowCount();
			if ($rowcount!=0) {
				$loginstate = 200;
				$userid = $row['tc_user_id'];
				$usertoken = $token;
				$usertokenexpire = $expiretime;
			} else {
				$loginstate = 500;
		    }
		} else {
			$loginstate = 301;
		}
	}
	$output = array(
	             'loginState' => $loginstate,
	             'userID' => $userid,
                 'userToken' => $usertoken,
				 'userTokenExpire' => $usertokenexpire);
    echo json_encode($output);
}
?>