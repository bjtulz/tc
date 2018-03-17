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
                        <h1 class="page-header">Add an event</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
				<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div id = "inputarea" class="panel-heading">
                            Input event information
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form">
                                        <div class="form-group">
                                            <label>Event Title</label>
                                            <input type = "text" id = "etitle" class="form-control" placeholder="Title">
                                        </div>
										<div class="form-group">
                                            <label>Start Time</label>
                                            <input type = "datetime-local" id = "estart" class="form-control" placeholder="Start">
                                        </div>
										<div class="form-group">
                                            <label>End Time</label>
                                            <input type = "datetime-local" id = "eend" class="form-control" placeholder="End">
                                        </div>
										<div class="form-group">
                                            <label>Ticker Number Limit</label>
                                            <input type = "text" id = "elimit" class="form-control" placeholder="Number">
                                        </div>
                                        
                                    </form>
									<button id="submit" class="btn btn-default">Add</button>
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

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
	function timestampToTime(timestamp) {
        var date = new Date(timestamp * 1000);
        Y = date.getFullYear() + '-';
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
        D = date.getDate() + ' ';
        h = date.getHours() + ':';
        m = date.getMinutes() + ':';
        s = date.getSeconds();
        return Y+M+D+h+m+s;
    }
    $(document).ready(function() {
        $('#submit').click(function(){
			var eventname = $('#etitle').val();
			var eventstart = $('#estart').val();
			var eventend = $('#eend').val();
			var eventlimit = $('#elimit').val();
			
			var times = new Date(eventstart);
			var timee = new Date(eventend);
			
			var stimestamp = times.getTime()/1000;
			var etimestamp = timee.getTime()/1000;
			
			var userid = 1;
			var usertoken = "e64175deead998c9df8bf7728e56698404d375ae";
			
			$.post("../logic/addEvent.php",
				{
				  userID:userid,
				  userToken:usertoken,
				  eventName:eventname,
				  eventStart:stimestamp,
				  eventEnd:etimestamp,
				  eventTicketLimit:eventlimit
				},
				function(data){
					switch (data.state){
						case 200:
						    $('#inputarea').append("<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Succeed to add new event. Event ID:"+data.newEventID+" Event name:"+data.newEventName+"("+timestampToTime(data.newEventStart)+"~"+timestampToTime(data.newEventEnd)+") Ticket number limit:"+data.newEventTicketLimit+"</div>");
						default:
                            $('#inputarea').append("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Failed to add new event</div>");
					}
				  
				});

			});
    });
    </script>

</body>

</html>
