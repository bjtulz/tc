<?php
if ($_POST['userID'] == "" || $_POST['userToken'] == ""){
	echo "没有传入参数";
} else {
	//input
	$userid = $_POST['userID'];
	$usertoken = $_POST['userToken'];
	
	//output
	$type = "userinfo";
	$state = ""; //200 Success 301 302 303 Invalid token 500 Internal error
	$usershownname = ""
	$usertype = "";
	$userstate = "";
	
	//Link DB
	$con = mysqli_connect("localhost","tc","lizhe20080722","tc");
    if (!$con)
       {
        die('Could not connect: ' . mysql_error());
       }
	
	$result = mysqli_query($con,"SELECT * FROM tc_usertoken WHERE tc_usertoken_token = '".$usertoken."'");
	$row=mysqli_fetch_array($result);
	if ($row['tc_usertoken_uid'] == "") {
		$state = "301";
	} else {
		if ($row['tc_usertoken_uid'] != $userid){
        $state = "302";		
	    } else {
			$timenow = time();
			if ($timenow > $row['tc_usertoken_timelimit']) {
				$state = "303";
			} else {
				$result2 = mysqli_query($con,"SELECT * FROM tc_user WHERE tc_user_id = '".$userid."'");
	            $row2=mysqli_fetch_array($result);
				if ($row2['tc_user_showname'] != ""){
					$state = "200";
					$usershownname = $row2['tc_user_showname'];
					$usertype = $row2['tc_user_type'];
	                $userstate = $row2['tc_user_state'];
				}else {
					$state = "500";
				}
			}
		}
	}
	$output = array(
	             'type' => $type,
	             'state' => $state,
                 'usershownname' => $usershownname,
				 'usertype' => $usertype,
				 'userstate' => $userstate);
    echo json_encode($output);
    	
	
	
}
?>