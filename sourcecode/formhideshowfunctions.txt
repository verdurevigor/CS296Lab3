window.onload = showHideNewEventForm;

function showHideNewEventForm()
{
	if (document.getElementById('showHideCheckbox').checked)
		document.getElementById('addNewEvent').style.display = 'block';
	else
		document.getElementById('addNewEvent').style.display = 'none';
}