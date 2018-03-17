<?php
require "Medoo.php";

use Medoo\Medoo;

function getUserState ($userid,$usertoken){
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
								   "["AND" => [
								   "tc_usertoken_uid" => $userid,
								   "tc_usertoken_token" => $usertoken
								   ]]");
	if (count($tokenData) == 0 ) {
		echo "301"; //token does not exist
	} else if ($tokenData[0]["tc_usertoken_timelimit"] <= $current ){
		echo "302"; //token expired; 
	} else {
		echo "200"; //token active
	}
	
}
getUserState {1,"e64175deead998c9df8bf7728e56698404d375ae"};
?>