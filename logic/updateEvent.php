<?php
require "Medoo.php";

use Medoo\Medoo;

$type = "updateEventResult";
$state = "";


if ($_POST['userID'] == "" ||
    $_POST['userToken'] == "" ||
	$_POST['eventID'] == "" ||
	$_POST['eventName'] == "" ||
	$_POST['eventStart'] == "" ||
	$_POST['eventEnd'] == ""||
	$_POST['eventTicketLimit'] == "" ||
	$_POST['eventStatus'] == "") {
		$state = 301;
	} else {
		$userID = $_POST['userID'];
		$userToken = $_POST['userToken'];
		$eventID = $_POST['eventID'];
		$eventName = $_POST['eventName'];
		$eventStart = $_POST['eventStart'];
		$eventEnd = $_POST['eventEnd'];
		$eventTicketLimit = $_POST['eventTicketLimit'];
		$eventStatus = $_POST['eventStatus'];
		
		$current = time();
		$database = new Medoo([
	    // required
	    'database_type' => 'mysql',
	    'database_name' => 'tc',
	    'server' => 'localhost',
	    'username' => 'tc',
	    'password' => 'lizhe20080722'
	    ]);
		
		$tokenData = $database->select("tc_usertoken",
	                               "*",
								   ["AND" => [
								   "tc_usertoken_uid" => $userID,
								   "tc_usertoken_token" => $userToken
								   ]]);
		if (count($tokenData) == 0 ) {
			$userStatus = 301; //token does not exist
			$state = 301;
		} else if ($tokenData[0]["tc_usertoken_timelimit"] <= $current ){
			$userStatus = 302; //token expired; 
			$state = 302;
		} else {
			$userStatus = 200; //token active
		}
		
		if ( $userStatus == 200){
			
			
			$updateresult = $database->update("tc_event", [
	                          "tc_event_name" => $eventName,
	                          "tc_event_starttime" => $eventStart,
	                          "tc_event_endtime" => $eventEnd,
							  "tc_event_state" => $eventStatus,
							  "tc_event_ticketlimit" => $eventTicketLimit
							  ],[
							  "tc_event_id" => $eventID
							  ]);
			
			if ( $updateresult->rowCount() == 1 ) {
				$state = 200;
			} else {
				$state = 400;
			}
		
	}
	$output = array(
	             'type' => $type,
	             'state' => $state);
    echo json_encode($output);
	}





?>