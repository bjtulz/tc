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
                        <h1 class="page-header">Issue a ticket</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
				<div class="row">
                    <div id ="noticearea" class="col-lg-12">
                        
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
                        <div class="panel-heading">
                            Input ticket information
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form">
                                        <div class="form-group">
                                            <label>Event ID</label>
                                            <input type = "text" id = "eID" class="form-control" placeholder="Event ID">
                                        </div>
										<div class="form-group">
                                            <label>Tag ID</label>
                                            <input type = "text" id = "tID" class="form-control" placeholder="Tag ID">
                                        </div>
										<div class="form-group">
                                            <label>Ticket Type</label>
                                            <select id = "tType" class="form-control">
                                                <option value=1>Standard</option>
												<option value=2>Special</option>
                                            </select>
                                        </div>
										<div class="form-group">
                                            <label>Ticket Notes</label>
                                            <input type = "text" id = "tNote" class="form-control" placeholder="Notes">
                                        </div>
										                                      
                                    </form>
									<button id="submit" class="btn btn-default">Issue</button>
                                    <button id="reset" class="btn btn-default">Reset</button>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
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
	    $(document).ready(function() {
        $('#submit').click(function(){
			var eid = $('#eID').val();
			var tid = $('#tID').val();
			var ttype = $('#tType').val();
			var tnote = $('#tNote').val();
			
			
			if (eid == "" || tid=="" || ttype=="" ||tnote=="")
			{
				$('#noticearea').append("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Please fullfill the form.</div>");
				return;
			}
			
						
			var userid = 1;
			var usertoken = "1a39cfe7ea929a253c41d215fb46668659ddf8f0";
			
			$.post("../logic/issueTicket.php",
				{
				  userID:userid,
				  userToken:usertoken,
				  eventID:eid,
				  tagID:tid,
				  ticketType:ttype,
				  ticketNotes:tnote
				},
				function(data){
					switch (data.state){
					    case 200:					
						    $('#noticearea').append("<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Succeed to issue a ticket for event ID"+data.ticketEvent+". Ticket Ref: "+data.ticketRef+" Tag ID: "+data.ticketTag +"</div>");
							$('#eID').val("");
			                $('#tID').val("");
			                $('#tType').val("");
			                $('#tNote').val("");
							break;
						case 301,302,303:
                            $('#noticearea').append("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Failed to add new event, please check again or contact system admin.</div>");
					        break;
					}
				  
				}, "json");

			});
		$('#reset').click(function(){
			$('#eID').val("");
			$('#tID').val("");
			$('#tType').val("");
			$('#tNote').val("");
			
			});
    });
	</script>
</body>

</html>
