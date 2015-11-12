<?php

include_once("ecmainbackend.php");

?>

<!DOCTYPE html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	
	<title>CCC Event Calendar</title>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	
</head>

<body>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="jquery-min.js"></script>
	<!-- Latest compiled and minified JavaScript plugins -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<!-- Extra javascript form function -->
	<script src="formhideshowfunctions.js"></script>
	
	<nav class="navbar navbar-default"><!-- Navigation bar -->
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">CCC</a>
			</div>
			<!-- Collection of links for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="#">About</a></li>
					<li><a href="#">Shows</a></li>
					<li><a href="#">Venues & Rentals</a></li>
					<li><a href="#">Contact</a></li>
					<li><a href="#">Support</a></li>
				</ul>
				<ul class="nav navbar-right">
					<li><a href="ecmain.php?action=Logout">Logout</a></li>
				</ul>
			</div>
		</div>
	</nav><!-- End of navigation -->
		
	<div class="page-header"><!-- Header/logo -->
			<img src="ccc.png">
	</div><!-- End of header/logo -->
	
	<div class="container">
		<div id="addNewEvent" class="row"><!-- New/edit event form. Capable of hiding -->	
			<div class="col-sm">
				<p class="h4 text-danger"><?php echo $errorMessage; ?></p>
			</div>
			<div class="col-sm">
				<form action="ecmain.php" method="POST" class="form">	
					<div class="form-group col-sm-4">
						<label for="newEventTitle">Event Title</label>
						<input type="text" name="editEventTitle" class="form-control" autocomplete="off" required value="<?php echo $editTitle; ?>" >
					</div>
					<div class="form-group col-sm-2">
						<label for="newEventDate">Date and Time</label>
						<input type="text" name="editEventDate" class="form-control" placeholder="MM/DD/YYYY" autocomplete="off" required value="<?php echo $editDate; ?>" >
					<br>	<input type="text" name="editEventTime" class="form-control" placeholder="HH:MM" autocomplete="off" required value="<?php echo $editTime; ?>" >
						<input type="radio" name="editEventMeridiem" value="am" <?php echo $amMeridiem; ?> /> am
						<input type="radio" name="editEventMeridiem" value="pm" <?php echo $pmMeridiem; ?> /> pm
					</div>
					<div class="form-group col-sm-1">
						<!-- Hide eventId that is shown for edits. Never allow user input on this field. -->
						<div class="hidden-xs hidden-sm hidden-md hidden-lg">
							<input type="text" name="editEventId" class="form-control" value="<?php echo $editEventId; ?>" >
						</div>
					</div>
					<div class="form-group col-sm-8">
						<label for="newEventDescription">Description</label>
						<textarea class="form-control" name="editEventDescription" rows="3" required ><?php echo $editDescription; ?></textarea>
						<br><button type="submit" name="submitEvent" class="btn btn-success">Submit</button>
						<button type='button' class='btn'>Cancel</button>
					</div>
				</form>
			</div>
		</div>
		
		<div class="row"><!-- Beginning of page content -->
			<div class="col-sm-2"><!-- Row for table sorting and new entry button and event calendar -->
				<form action="ecmain.php" method="GET" class="form well">
					<div class="form-group">
						<h4>Sort by:</h4>
					</div>
					<div class="form-group">
						<input type="radio" name="action" value="SortDate" /> Date
					</div>
					<div class="form-group">
						<input type="radio" name="action" value="SortID" /> User ID
					</div>
					<div class="form-group">
						<input type="radio" name="action" value="SortTitle" /> Event Title
					</div>
					<div class="form-group">
						<input type="submit" value="Sort Events" class="btn btn-primary" />
					</div>
					<div class="form-group">
						<input type="checkbox" id="showHideCheckbox"  onclick="showHideNewEventForm()" <?php echo $editInProgress; ?> > Add New Event	<!-- Php variable will give attribute "checked" if an edit is in progress -->
					</div>
				</form>
			</div>
			
			<div class="col-sm-8"><!-- Event calendar filled here -->
				<h2>Calendar Events</h2>
				<?php printTable($eventsArray, $keys); ?>
			</div>
		</div><!-- End page content -->
	</div><!-- End of main container -->
</body>

</html>