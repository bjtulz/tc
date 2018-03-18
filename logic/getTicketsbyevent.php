<?php
require "Medoo.php";
use Medoo\Medoo;

$userID = $_POST['userID'];
$userToken = $_POST['userToken'];
$eventID = $_POST['eventID'];
if ($userID == "" || $userToken==""||$eventID==""){
} else {
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
$ticketStates = array("Open","Used");
$ticketType = array("Standard","Special");
$ticketsData = $database->select("tc_ticket", 
	                             ["tc_ticket_ticketref","tc_ticket_tagid","tc_ticket_type","tc_ticket_state"],
								 ["tc_ticket_eventid" => $eventID]);
foreach ($ticketsData as $ticket){
	$ticket["tc_ticket_type"]=$ticketType($ticket["tc_ticket_type"]-1);
	$ticket["tc_ticket_state"]=$ticketStates($ticket["tc_ticket_state"]-1);
}
echo json_encode($ticketsData);


}
}							 
?>