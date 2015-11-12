window.onload = startForm;

function startForm()
{
	document.loginForm.userid.focus();
	document.loginForm.onsubmit = checkForm;
}

// Validate login form
function checkForm()
{
	// Variable to hold password alert box message.
	var message = "";
	
	// Checks that a username was entered - if not, function stops here
	if (document.loginForm.userid.value == "")
	{
		alert("Please enter a username.");
		document.loginForm.userid.focus();
		return false;
	}
	// Checks that a password was entered - if not, function stops here
	if (document.loginForm.password.value == "")
	{
		alert("Please enter a password.");
		document.loginForm.password.focus();
		return false;
	}
	
	// Checks password for character requirements.
	if (document.loginForm.password.value.length < 8 || document.loginForm.password.value.length > 16)
	{
		message += "Invalid password - must be between 8-16 characters.\n";
	}
	if (document.loginForm.password.value.search("[A-Z]") == -1)
	{
		message += "Invalid password - must contain at least one upper-case letter.\n";
	}
	if (document.loginForm.password.value.search("[a-z]") == -1)
	{
		message += "Invalid password - must contain at least one lower-case letter.\n";
	}
	if (document.loginForm.password.value.search("[0-9]") == -1)
	{
		message += "Invalid password - must contain at least one number.";
	}
	
	// If no errors occurred return true.
	if (message == "")
		return true;
	// Otherwise give invalid password message and do not return true/false so php file can reiterate input errors on login page.					Is this a bad practice?
	else
	{
		document.loginForm.password.focus();
		alert(message);
	}
}
