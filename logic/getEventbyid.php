<?php
require "Medoo.php";

use Medoo\Medoo;

$type = "getEventResult";
$state = "";
$eventID = "";
$eventName = "";
$eventStart = "";
$eventEnd = "";
$eventState = "";
$eventTicketlimit = "";
$eventCreator = "";

if ($_POST['userID'] == "" || $_POST['userToken'] == "" || 	$_POST['eventID'] == "" ) {
		$state = 401;
	} else {
		$userID = $_POST['userID'];
		$userToken = $_POST['userToken'];
		$eventID = $_POST['eventID'];
		
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
			$eventData = $database->select("tc_event",
									"*",
									["tc_event_id" => $eventID]);
			if (count($eventData) == 0){
				$state = 304;
			} else {
				$state = 200;
				$eventID = $eventData[0]["tc_event_id"];
				$eventName = $eventData[0]["tc_event_name"];
				$eventStart = $eventData[0]["tc_event_starttime"];
				$eventEnd = $eventData[0]["tc_event_endtime"];
				$eventState = $eventData[0]["tc_event_state"];
				$eventTicketlimit = $eventData[0]["tc_event_ticketlimit"];
				$eventCreator = $eventData[0]["tc_event_creator"];
			}
		}
		$output = array(
	             'type' => $type,
	             'state' => $state,
                 'eventID' => $eventID,
				 'eventStarttime' => $eventStart,
				 'eventEndtime' => $eventEnd,
				 'eventState' => $eventState,
				 'eventLimit' => $eventTicketlimit,
				 'eventCreator' => $eventCreator);
		echo json_encode($output);
		
		
	}
?>