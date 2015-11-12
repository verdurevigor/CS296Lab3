<?php

function isCorrectPassword($userId, $password)
{
	return true;
}


function validatePassword($password)
{
	if (strlen($password) < 8 || strlen($password) > 16)
		return false;
	else if (preg_match("/[A-Z]/", $password) == 0)
		return false;
	else if (preg_match("/[a-z]/", $password) == 0)
		return false;
	else if (preg_match("/[0-9]/", $password) == 0)
		return false;
	else
		return true;
}

function isValidUserid($userId, &$useridError)
{
	if (strlen($userId) < 8 || strlen($userId) > 16)
	{
		$useridError = "Username must be between 8-16 characters";
		return false;
	}
	else
		return true;
}


// This function copied from Mary's after creating my own (above). Then I tweaked this code some.
function isValidPassword($password, &$error_message)
{
	$error_message == "";
	// Check length requirement.
	if (!preg_match("/^\w{8,16}$/", $password))
		$error_message = "Password must be between 8 and 16 characters.<br />";
	// Check character requirements
	if(!preg_match("/[A-Z]/", $password))
		$error_message .= "Password must contain at least one upper-case character.<br />";
	if(!preg_match("/[a-z]/", $password))
		$error_message .= "Password must contain at least one lower-case character.<br />";
	if(!preg_match("/[0-9]/", $password))
		$error_message .= "Password must contain at least one number.";
	
	if ($error_message == "")
		return true;
	else
		return false;
}

/*
// isCorrectPassword test
if (isCorrectPassword("catattack", "calicocrazy"))
	echo ("The function isCorrectPassword returned true");
else
	echo ("The function isCorrectPassword returned false");

echo ("<br/><br/>");

// validatePassword tests

$pw1 = "2Short";
$pw2 = "Way2DangLong123456";
$pw3 = "Good1ToUse";
$pw4 = "NoNumber";
$pw5 = "12345678";

if (validatePassword($pw1))
	echo ("$pw1 is a good password!");
else
	echo ("$pw1 does not conform to the password requirements.");
echo ("<br/>");

if (validatePassword($pw2))
	echo ("$pw2 is a good password!");
else
	echo ("$pw2 does not conform to the password requirements.");
echo ("<br/>");

if (validatePassword($pw3))
	echo ("$pw3 is a good password!");
else
	echo ("$pw3 does not conform to the password requirements.");
echo ("<br/>");

if (validatePassword($pw4))
	echo ("$pw4 is a good password!");
else
	echo ("$pw4 does not conform to the password requirements.");
echo ("<br/>");

if (validatePassword($pw5))
	echo ("$pw5 is a good password!");
else
	echo ("$pw5 does not conform to the password requirements.");
echo ("<br/>");
*/
?>