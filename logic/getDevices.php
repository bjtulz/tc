<?php
require "Medoo.php";
require "dbconfig.php";

use Medoo\Medoo;

function getEvents (){
	
	
	$database = new Medoo([
	// required
	'database_type' => 'mysql',
	'database_name' => 'tc',
	'server' => 'localhost',
	'username' => 'tc',
	'password' => 'lizhe20080722'
	]);
	
	
	
	$alldeviceData = $database->select("tc_device", 
	                                  ["tc_device_id","tc_device_name","tc_device_token","tc_device_tokenexpire"]);
	
	echo "<thead>";
    echo "<tr>";
	echo "<th>Device ID</th>";
	echo "<th>Device Name</th>";
	echo "<th>Token</th>";
	echo "<th>Token Expire Time</th>";
	echo "</tr>";
	echo "</thead>";
	
	echo "<tbody>";
	
	foreach($alldeviceData as $device)
    {
    echo "<tr>";
    echo "<td>".$device["tc_device_id"]."</td>";
	echo "<td>".$device["tc_device_name"]."</td>";
	echo "<td>".$device["tc_device_token"]."</td>";
	echo "<td>".date('Y-m-d H:i:s',$device["tc_device_tokenexpire"])."</td>";
	echo "</tr>";
    }
	echo "</tbody>";

	
}


?>