<?php
	include_once("ecloginbackend.php");
?>

<!DOCTYPE html>

<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		
	<title>CCC Login</title>
	<meta charset="UTF-8" />
	<link href="validate.js" rel="text/javascript" />
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

</head>

<script src="validate.js"></script>



<body>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="jquery-min.js"></script>
	<!-- Latest compiled and minified JavaScript plugins -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	<nav class="navbar navbar-default">
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
			<!-- collection of links for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="#">About</a></li>
					<li><a href="#">Shows</a></li>
					<li><a href="#">Venues & Rentals</a></li>
					<li><a href="#">Contact</a></li>
					<li><a href="#">Support</a></li>
				</ul>
			</div>
		</div>
	</nav>
	
	<div class="container-fluid"><!-- header/logo -->
		<div class="page-header">
				<img src="ccc.png">
		</div>
	
		<div class="row">
			<div class="col-sm-4">
				<h2>Administration Login</h2>
				<form name="loginForm" action="eclogin.php" method="POST" />
					<div class="form-group">
						<label for="userid">Username:</label>
						<input type="text" name="userid" value="<?php echo $userId; ?>" required />
					</div>
					<div class="form-group">
						<label for="password">Password:</label>
						<input type="password" name="password" value="<?php echo $password; ?>" required />		
					</div>
					<input type="submit" name="btnLogin" value="Login" class="btn btn-primary" />
					<p class="help-block"><?php echo $useridError . "<br />" . $passwordError; ?></p>
				</form>
			</div>
		</div><!-- end row -->
	</div><!-- end of main container -->
</body>


</html>