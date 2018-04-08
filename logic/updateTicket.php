<?php
require "Medoo.php";

use Medoo\Medoo;

$type = "updateTicketResult";
$state = "";


if ($_POST['userID'] == "" ||
    $_POST['userToken'] == "" ||
	$_POST['ticketRef'] == "" ||
	$_POST['ticketTag'] == "" ||
	$_POST['ticketType'] == ""||
	$_POST['ticketState'] == "") {
		$state = 400; //lack parameters
	} else {
		$userID = $_POST['userID'];
		$userToken = $_POST['userToken'];
		$ticketRef = $_POST['ticketRef'];
		$ticketTag = $_POST['ticketTag'];
		$ticketType = $_POST['ticketType'];
		$ticketState = $_POST['ticketState'];
				
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
			
			
			$updateresult = $database->update("tc_ticket", [
	                          "tc_ticket_tagid" => $ticketTag,
	                          "tc_ticket_type" => $ticketType,
	                          "tc_ticket_state" => $ticketState
							  ],[
							  "tc_event_ticketref" => $ticketRef
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