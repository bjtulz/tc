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
                        <h1 class="page-header">Ticket Management</h1>
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
									Load Ticket Information
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-6">
											<form role="form">
												<div class="form-group">
													<label>Ticket Ref No:</label>
													<input type = "text" id = "ticketref" class="form-control" placeholder="Ticket Ref">
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
                            Ticket Information
                        </div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-6">
									<form role="form">
                                        <div class="form-group">
                                            <label>Ticket ID</label>
                                            <input type = "text" id = "tID" class="form-control" placeholder="">
                                        </div>
										<div class="form-group">
                                            <label>Ticket Ref No.</label>
                                            <input type = "text" id = "tRef" class="form-control" placeholder="">
                                        </div>
										<div class="form-group">
                                            <label>Ticket Tag ID</label>
                                            <input type = "text" id = "tTag" class="form-control" placeholder="">
                                        </div>
										<div class="form-group">
                                            <label>Event ID</label>
                                            <input type = "text" id = "tEvent" class="form-control" placeholder="">
                                        </div>
										<div class="form-group">
                                            <label>Issuance Time</label>
                                            <input type = "datetime-local" id = "tIsTime" class="form-control" placeholder="">
                                        </div>
										<div class="form-group">
                                            <label>Issue User</label>
                                            <input type = "text" id = "tIsUser" class="form-control" placeholder="">
                                        </div>
										<div class="form-group">
                                            <label>Ticket Notes</label>
                                            <input type = "text" id = "tNotes" class="form-control" placeholder="">
                                        </div>
                                        
                                    </form>
								</div>

								<div class="col-lg-6">
									<form role="form">
										<div class="form-group">
                                            <label>Checked on</label>
                                            <input type = "datetime-local" id = "tChkTime" class="form-control" placeholder="">
                                        </div>
										<div class="form-group">
                                            <label>Checked by</label>
                                            <input type = "text" id = "tChkUser" class="form-control" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label>Ticket Type</label>
                                            <select id = "tType" class="form-control">
                                                <option value=1>Standard</option>
                                            </select>
                                        </div>
										<div class="form-group">
                                            <label>Ticket State</label>
                                            <select id = "tState" class="form-control">
                                                <option value=1>Available</option>
                                                <option value=0>Expired</option>
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
			var ticketReftoload = $('#ticketref').val();
			var userid = 1;
			var usertoken = "1a39cfe7ea929a253c41d215fb46668659ddf8f0";
			
			$.post("../logic/getTicketbyref.php",
				{
				  userID:userid,
				  userToken:usertoken,
				  ticketRef:ticketReftoload
				},
				function(data){
					switch (data.state){
					    case 200:
							$('#tID').val(data.ticketID);
						    $('#tRef').val(data.ticketRef);
			                $('#tTag').val(data.ticketTag);
			                $('#tEvent').val(data.ticketEvent);
			                $('#tIsTime').val(timestampToTime(data.ticketIssuetime));
							$('#tIsUser').val(data.ticketIssuer);
							$('#tNotes').val(data.ticketNote);
							$('#tChkTime').val(timestampToTime(data.ticketChecktime));
							$('#tChkUser').val(data.ticketChecker);
							$('#tType').val(data.ticketType);
							$('#tState').val(data.ticketState);
							break;
						default:
                            $('#noticearea').append("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Failed to load ticket, please check again or contact system admin.</div>");
					        break;
					}
				}, "json");
		});
		$('#update').click(function(){
		var userid = 1;
		var usertoken = "1a39cfe7ea929a253c41d215fb46668659ddf8f0";
		var ticketRef = $('#tRef').val();
		var ticketTag = $('#tTag').val();
		var ticketType = $('#tType').val();
		var ticketState = $('#tState').val();
		
		
		$.post("../logic/updateTicket.php",
			{
			  userID:userid,
			  userToken:usertoken,
			  ticketRef:ticketRef,
			  ticketTag:ticketTag,
			  ticketType:ticketType,
			  ticketState:ticketState
			},
			function(data){
				switch (data.state){
					case 200:
						$('#noticearea').append("<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Succeed to update this ticket. </div>");
						break;
					default:
						$('#noticearea').append("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Failed to update ticket, please check again or contact system admin.</div>");
						break;
				}
			}, "json");
		});
	});
	</script>

</body>

</html>
