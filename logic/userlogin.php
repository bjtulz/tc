<?php
error_reporting(E_ALL);  
if ($_POST['userLoginname'] == "" || $_POST['userLogincath'] == ""){
	echo "没有传入参数";
}else{
	//Input
	$userlogin = $_POST['userLoginname'];
	$usercath = $_POST['userLogincath'];
	
	//Output
	$loginstate = ""; //state: 200 success 301 wrong username/password 400 internal error
	$userid = "";
	$usertoken = "";
	$usertokenexpire = "";
	
	//Link DB
	$con = mysqli_connect("localhost","tc","lizhe20080722","tc");
    if (!$con)
       {
        die('Could not connect: ' . mysql_error());
       }
	
	$result = mysqli_query($con,"SELECT * FROM tc_user WHERE tc_user_loginname = '".$userlogin."'");
	$row=mysqli_fetch_array($result);
		
	if ($row['tc_user_id'] == "") {
		$loginstate = "301";
	} else {
		if ($row['tc_user_password'] == $usercath) {
			$str = md5(time().$row['tc_user_id']);
			$token = sha1($str);
			$expiretime = strtotime("+1 day");
			$insert = "UPDATE tc_usertoken SET tc_usertoken_token = '".$token."',tc_usertoken_timelimit = ".$expiretime."
                       WHERE tc_usertoken_uid = ". $row['tc_user_id'];
			if (mysqli_query($con,$insert) != false) {
				$loginstate = "200";
				$userid = $row['tc_user_id'];
				$usertoken = $token;
				$usertokenexpire = $expiretime;
			} else {
				$loginstate = "500";
		    }
		} else {
			$loginstate = "301";
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