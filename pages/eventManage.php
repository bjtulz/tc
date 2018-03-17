<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ticket Management System</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php
		echo file_get_contents("showNavi.php");
		?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Event Management</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
				<div class="row">
                    <div id ="noticearea" class="col-lg-12">
                        
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
									Load Event
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-6">
											<form role="form">
												<div class="form-group">
													<label>Event ID:</label>
													<input type = "text" id = "eventid" class="form-control" placeholder="Event ID">
												</div>
											</form>
											<button id="load" class="btn btn-default">Load</button>
											<button id="reset" class="btn btn-default">Reset</button>
									</div>
								</div>
							<!-- /.col-lg-12 -->
							</div>
						</div>
					</div>
                </div>
				<div class="row">
				<div class="col-lg-12">
                    <div class="panel panel-default">
						<div class="panel-heading">
                            Event Information
                        </div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-6">
									<form role="form">
                                        <div class="form-group">
                                            <label>Event ID:</label>
                                            <input type = "text" id = "eID" class="form-control" placeholder="Event ID">
                                        </div>
										<div class="form-group">
                                            <label>Event Name:</label>
                                            <input type = "text" id = "eName" class="form-control" placeholder="Event Name">
                                        </div>
										<div class="form-group">
                                            <label>Start Time</label>
                                            <input type = "datetime-local" id = "eStart" class="form-control" placeholder="Start Time">
                                        </div>
										<div class="form-group">
                                            <label>End Time</label>
                                            <input type = "datetime-local" id = "eEnd" class="form-control" placeholder="End Time">
                                        </div>
										<div class="form-group">
                                            <label>Ticker Number Limit</label>
                                            <input type = "text" id = "eLimit" class="form-control" placeholder="Ticket Number Limit">
                                        </div>
										<div class="form-group">
                                            <label>Creator</label>
                                            <input type = "text" id = "eCreator" class="form-control" placeholder="Creator">
                                        </div>
                                        
                                    </form>
								</div>

								<div class="col-lg-6">
									<form role="form">
                                        <div class="form-group">
                                            <label>Event Status:</label>
                                            <select id = "eStatus" class="form-control">
                                                <option value=1>Active</option>
                                                <option value=2>Inactive</option>
                                            </select>
                                        </div>
									</form>
									<button id="update" class="btn btn-default">Update</button>
                                    <button id="cancel" class="btn btn-default">Reset</button>
								</div>
							</div>
						</div>
					</div>
                    <!-- /.col-lg-12 -->
                </div>
				</div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	
	<script>
	function timestampToTime(timestamp) {
        var date = new Date(timestamp * 1000);
        Y = date.getFullYear() + '-';
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
        D = (date.getDate()+1 < 10 ? '0'+date.getDate() : date.getDate()) + '';
        h = (date.getHours()+1 < 10 ? '0'+date.getHours() : date.getHours()) + ':';
        m = (date.getMinutes()+1 < 10 ? '0'+date.getMinutes() : date.getMinutes()) + ':';
        s = (date.getSeconds()+1 < 10 ? '0'+date.getSeconds() : date.getSeconds());
        return Y+M+D+"T"+h+m+s;
    }
	$(document).ready(function() {
		$('#load').click(function(){
			var eventIDtoload = $('#eventid').val();
			var userid = 1;
			var usertoken = "e64175deead998c9df8bf7728e56698404d375ae";
			
			$.post("../logic/getEventbyid.php",
				{
				  userID:userid,
				  userToken:usertoken,
				  eventID:eventIDtoload
				},
				function(data){
					switch (data.state){
					    case 200:
							$('#eventid').val("");
						    $('#eID').val(data.eventID);
			                $('#eName').val(data.eventName);
			                $('#eStart').val(timestampToTime(data.eventStarttime));
			                $('#eEnd').val(timestampToTime(data.eventEndtime));
							$('#eLimit').val(data.eventLimit);
							$('#eStatus').val(data.eventState);
							$('#eCreator').val(data.eventCreator);
							break;
						default:
                            $('#noticearea').append("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Failed to load event, please check again or contact system admin.</div>");
					        break;
					}
				}, "json");
		});
	});
	</script>

</body>

</html>
