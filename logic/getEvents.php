<?php
require "Medoo.php";
require "dbconfig.php";

use Medoo\Medoo;

function getEvents ($userid,$usertoken){
	
	
	$database = new Medoo([
	// required
	'database_type' => 'mysql',
	'database_name' => 'tc',
	'server' => 'localhost',
	'username' => 'tc',
	'password' => 'lizhe20080722'
	]);
	
	$eventStates = array("Active","Inactive");
	
	$alleventData = $database->select("tc_event", 
	                                  ["tc_event_id","tc_event_name","tc_event_starttime","tc_event_endtime","tc_event_state"]);
	
	echo "<thead>";
    echo "<tr>";
	echo "<th>Event ID</th>";
	echo "<th>Event NAme</th>";
	echo "<th>Start Time</th>";
	echo "<th>End time</th>";
	echo "<th>Current State</th>";
	echo "</tr>";
	echo "</thead>";
	
	echo "<tbody>";
	
	foreach($alleventData as $event)
    {
    echo "<td>".$event["tc_event_id"]."</td>";
	echo "<td>".$event["tc_event_name"]."</td>";
	echo "<td>".date('Y-m-d H:i:s',$event["tc_event_starttime"])."</td>";
	echo "<td>".date('Y-m-d H:i:s',$event["tc_event_endtime"])."</td>";
	echo "<td>".$eventStates[$event["tc_event_state"]-1]."</td>";
    }
	echo "</tbody>";

	
}


?>