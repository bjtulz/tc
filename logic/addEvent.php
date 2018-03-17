<?php
require "Medoo.php";
require "getUserState.php";

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
		
		$userStatus = getUserState($userID,$userToken);
		if ( $userStatus != 200){
			$state = 302;
		} else {
			$startTime = strtotime($eventStart);
			$endtime = strtotime($eventEnd);
			$database = new Medoo([
			'database_type' => 'mysql',
			'database_name' => 'tc',
			'server' => 'localhost',
			'username' => 'tc',
			'password' => 'lizhe20080722'
			]);
			
			$eventNewID = $database->insert("tc_event", [
	                          "tc_event_name" => $eventName,
	                          "tc_event_starttime" => $startTime,
	                          "tc_event_endtime" => $endtime,
							  "tc_event_state" => 1,
							  "tc_event_ticketlimit" => $eventTicketLimit,
							  "tc_event_creator" => $userID,
							  ]);
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
	}
	$output = array(
	             'type' => $loginstate,
	             'state' => $userid,
                 'newEventID' => $usertoken,
				 'newEventName' => $usertokenexpire,
				 'newEventStart' => $usertokenexpire,
				 'newEventEnd' => $usertokenexpire,
				 'newEventTicketLimit' => $usertokenexpire);
    echo json_encode($output);






?>