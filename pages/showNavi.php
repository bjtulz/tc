<?php
require "Medoo.php";

use Medoo\Medoo;

$userid = $_COOKIE["userid"];
$cookie = $_COOKIE["token"];

$current = time();
$database = new Medoo([
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
			echo "1"; 
		} else if ($tokenData[0]["tc_usertoken_timelimit"] <= $current ){
			echo "2"; 
		} else {
			break;
		}


?>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Ticket Management System</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> User Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Home</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Events<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="eventListActive.php">Active Events</a>
                                </li>
								<li>
                                    <a href="eventList.php">All Events</a>
                                </li>
								<li>
                                    <a href="eventAdd.php">Add Event</a>
                                </li>
                                <li>
                                    <a href="eventManage.php">Event Management</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						
						<li>
                            <a href="#"><i class="fa fa-edit fa-fw"></i> Tickets<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="ticketIssue.php">Ticket Issuance</a>
                                </li>
                                <li>
                                    <a href="ticketByEvent.php">Search Ticket by Event</a>
                                </li>
								<li>
                                    <a href="ticketByTag.php">Search Ticket by Tag</a>
                                </li>
								<li>
                                    <a href="ticketManage.php">Ticket Management</a>
                                </li>
						    </ul>
                            <!-- /.nav-second-level -->
                        </li>
						
						<li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> TBD</a>
                        </li>
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>