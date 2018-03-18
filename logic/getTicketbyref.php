<?php
require "Medoo.php";

use Medoo\Medoo;

$type = "getTicketResult";
$state = "";
$ticketID = "";
$ticketTag = "";
$ticketEvent = "";
$ticketIssuetime = "";
$ticketIssuer = "";
$ticketChecktime = "";
$ticketChecker = "";
$ticketType = "";
$ticketState = "";
$ticketNote = "";

if ($_POST['userID'] == "" || $_POST['userToken'] == "" || 	$_POST['ticketRef'] == "" ) {
		$state = 401;
	} else {
		$userID = $_POST['userID'];
		$userToken = $_POST['userToken'];
		$ticketRef = $_POST['ticketRef'];
		
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
			$ticketData = $database->select("tc_ticket",
									"*",
									["tc_ticket_ticketref" => $ticketRef]);
			if (count($ticketData) == 0){
				$state = 304;
			} else {
				$state = 200;
				$ticketID = $ticketData[0]["tc_ticket_id"];
				$ticketTag = $ticketData[0]["tc_ticket_tagid"];
				$ticketEvent = $ticketData[0]["tc_ticket_eventid"];
				$ticketIssuetime = $ticketData[0]["tc_ticket_issuetime"];
				$ticketIssuer = $ticketData[0]["tc_ticket_issuer"];
				$ticketChecktime = $ticketData[0]["tc_ticket_checktime"];
				$ticketChecker = $ticketData[0]["tc_ticket_checker"];
				$ticketType = $ticketData[0]["tc_ticket_type"];
				$ticketState = $ticketData[0]["tc_ticket_state"];
				$ticketNote = $ticketData[0]["tc_ticket_note"];
			}
		}
		$output = array(
	             'type' => $type,
	             'state' => $state,
                 'ticketID' => $ticketID,
				 'ticketRef' => $ticketRef,
				 'ticketTag' => $ticketTag,
				 'ticketEvent' => $ticketEvent,
				 'ticketIssuetime' => $ticketIssuetime,
				 'ticketIssuer' => $ticketIssuer,
				 'ticketChecktime' => $ticketChecktime,
				 'ticketChecker' => $ticketChecker,
				 'ticketType' => $ticketType,
				 'ticketState' => $ticketState,
				 'ticketNote' => $ticketNote);
		echo json_encode($output);
		
		
	}
?>