<?php
require "Medoo.php";

use Medoo\Medoo;

$type = "addEventResult";
$state = "";
$newEventID = "";
$newEventName = "";
$newEventStart = "";
$newEventEnd = "";
$newEventTicketLimit = "";

if ($_POST['userID'] == "" ||
    $_POST['userToken'] == "" ||
	$_POST['eventName'] == "" ||
	$_POST['eventStart'] == "" ||
	$_POST['eventEnd'] == ""||
	$_POST['eventTicketLimit'] == "") {
		$state = 301;
	} else {
		$userID = $_POST['userID'];
		$userToken = $_POST['userToken'];
		$eventName = $_POST['eventName'];
		$eventStart = $_POST['eventStart'];
		$eventEnd = $_POST['eventEnd'];
		$eventTicketLimit = $_POST['eventTicketLimit'];
		
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
			
			
			$database->insert("tc_event", [
	                          "tc_event_name" => $eventName,
	                          "tc_event_starttime" => $eventStart,
	                          "tc_event_endtime" => $eventEnd,
							  "tc_event_state" => 1,
							  "tc_event_ticketlimit" => $eventTicketLimit,
							  "tc_event_creator" => $userID,
							  ]);
			$eventNewID = $database->id();
			if ( $eventNewID != "" ) {
				$newEventID = $eventNewID;
				$state = 200;
				$newEventName = $eventName;
				$newEventStart = $eventStart;
				$newEventEnd = $eventEnd;
				$newEventTicketLimit = $eventTicketLimit;
			} else {
				$state = 303;
			}
		
	}
	$output = array(
	             'type' => $type,
	             'state' => $state,
                 'newEventID' => $newEventID,
				 'newEventName' => $newEventName,
				 'newEventStart' => $newEventStart,
				 'newEventEnd' => $newEventEnd,
				 'newEventTicketLimit' => $newEventTicketLimit);
    echo json_encode($output);
	}





?>