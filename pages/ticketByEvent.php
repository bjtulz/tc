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
                        <h1 class="page-header">Find Ticket by Event</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
									Load Ticket List by Event
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
								Tickets under current event
							</div>
							<!-- /.panel-heading -->
							<div class="panel-body">
								<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
									<thead>
										<tr>
											<th>Ticket Ref No.</th>
											<th>Tag ID</th>
											<th>Type</th>
											<th>State</th>
										</tr>
									</thead>
									<tbody id="ticketList">
									
									</tbody>
								</table>
								<!-- /.table-responsive -->
								<div class="well">
									<h4>Notes</h4>
									<p>Please select one event for further operation.</p>
								</div>
							</div>
							<!-- /.panel-body -->
						</div>
						<!-- /.panel -->
					</div>
					<!-- /.col-lg-12 -->
				</div>
            <!-- /.row -->
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
	
	<!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	
	<script>
    $(document).ready(function() {
		$('#load').click(function(){
			var eventIDtoload = $('#eventid').val();
			var userid = 1;
			var usertoken = "1a39cfe7ea929a253c41d215fb46668659ddf8f0";
			
			$.post("../logic/getTicketsbyevent.php",
				{
				  userID:userid,
				  userToken:usertoken,
				  eventID:eventIDtoload
				},
				function(data){
					var ticketstates=new Array();
					ticketstates["1"]="Available";
					ticketstates["0"]="Expired";
					var tickettypes=new Array();
					tickettypes["1"]="Standard";
					tickettypes["2"]="Special";
					
					var tbl = $('#dataTables-example').DataTable();
					tbl.clear();
					for (var p in data){
						tbl.row.add([data[p].tc_ticket_ticketref,data[p].tc_ticket_tagid,tickettypes[data[p].tc_ticket_type],ticketstates[data[p].tc_ticket_state]]);
					}
					tbl.draw();
				}, "json");
		});
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

</body>

</html>
