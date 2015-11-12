<?php
	include_once ("filefunctions.php");
	include_once ("validate.php");

	$userId = "";
	$password = "";
	
	$url = "ecmain.php";
	
	$useridError = "";
	$passwordError = "";
	
	// Validate userId and password
	if (count($_POST) > 0)
	{
		$userId = $_POST["userid"];
		$password = $_POST["password"];
		
		if (isValidUserid($userId, $useridError))
		{
			if (isValidPassword($password, $passwordError))
			{
				// If login credentials are correct proceed to event calendar page with userId saved in session.
				if (isCorrectPassword($userId, $password))
				{
					// for now a hard coded userId will be used. Later it will be retrieved from the database
					session_start();
					$_SESSION["userId"] = 2;
					header('Location:' . $url);
				}
			}
		}
	}
?>