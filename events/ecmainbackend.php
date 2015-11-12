<?php

// Session must be started in order to use it
session_start();
// If the user has successfully logged in (during this session) - show event calendar page, otherwise redirect to login page
if (isset($_SESSION["userId"]))
{	
	include_once ("filefunctions.php");
	include_once ("array2dfunctions.php");
	
	$userId = $_SESSION["userId"];
	$file = "events/events.txt";
	$keys = array("Event ID", "User ID", "Time", "Title", "Description", "");

	$eventsArray = get2DAssocArray($file, $keys); // array variable used to hold file contents
	$errorMessage = "";

	// Add/edit form sticky variables
	$editTitle = "";
	$editDate = "";
	$editTime = "";
	$editDescription = "";
	$editInProgress = "";
	$amMeridiem = "";
	$pmMeridiem = "checked";
	// Additional hidden form input for edit event id sticky variable
	$editEventId = "";

	function deleteEventFromFile($idEvent, $idUser, $eventsArray, $file)
	{
		// Find index of the event to delete
		$i = search_2d_array($eventsArray, "Event ID", $idEvent);
		$p = $eventsArray[$i]["User ID"];
		if ($p == $idUser)
		{
			// Make string array of file and remove line at index
			$eventStringArray = file($file);
			unset($eventStringArray[$i]);
			// Reset array to string and rewrite file
			$fileContent = implode("", $eventStringArray);
			$eventFile = fopen($file, "wb");
			// if the file doesn't open
			if ($eventFile === FALSE)
				$errorMessage = "There was an error deleting the event.";
			// otherwise write the string and close the file
			else 
			{
				fwrite($eventFile, $fileContent);
				fclose($eventFile);
				// Reread the file to the web page's eventsArray
				$eventsArray = get2DAssocArray($file, $keys);
			}
		}
	}
		
	// First, check for any actions
	if (isset($_GET['action']))
	{	
		switch($_GET['action'])
		{
			case "Logout":
				session_destroy();
				header('Location: eclogin.php');
				break;
				case "SortDate":
			case "SortDate":
				usortByKey($eventsArray, "Time");
				break;
			case "SortID":
				usortByKey($eventsArray, "User ID");
				break;
			case "SortTitle":
				usortByKey($eventsArray, "Title");
				break;
			case "DeleteEvent":
				$idEvent = $_GET["EventId"];
				deleteEventFromFile($idEvent, $userId, $eventsArray, $file);
				break;
				/*	This works perfectly for deleting the correct event, but not sure how to now write this to the file...
				foreach ($eventsArray as $key => $item)
				{
					if ($item['Event ID'] == $idEvent && $item['User ID'] == $userId)
						unset($eventsArray[$key]);
				}
				*/
				/*
				$eventStringArray = file($file);
				foreach($eventStringArray as $event)
				{
					if (preg_match("/^$idEvent/", $event))
					{	
						echo $event;
						//unset($eventStringArray[$event]);
						//str_replace($event, "", $eventStringArray);
						echo $event;
						$fileContent = implode("", $eventStringArray);
						$eventFile = fopen($file, "wb");
						// if the file doesn't open
						if ($eventFile === FALSE)
							$errorMessage = "There was an error deleting the event.";
						// otherwise write the string and close the file
						else 
						{
							fwrite($eventFile, $fileContent);
							fclose($eventFile);
							$eventsArray = get2DAssocArray($file, $keys);
						}
					}
				}
				*/
			case "EditEvent":	// This was not condensed into a function due to the many necessary global variables
				$eventId = $_GET["EventId"];
				$i = search_2d_array($eventsArray, "Event ID", $eventId);
				// Show hidden form
				$editInProgress = "checked";
				// If the event id is not found in 2d array, display error.
				if ($i === false)
					$errorMessage = "Error occurred, event not found.";
				// Add event attributes to form from 2dArray
				else	
				{
					$editEventId = $eventId;
					
					// Format date/time
					$uTime = $eventsArray[$i]["Time"];
					$editDate = date("n/d/Y", $uTime);
					$editTime = date("g:i", $uTime);
					$editMeridiem = date("a", $uTime);
					if ($editMeridiem == "am")
						$amMeridiem = "checked";
					else
					{
						$pmMeridiem = "checked";
						$amMeridiem = "";
					}
					
					$editTitle = $eventsArray[$i]["Title"];
					$editDescription =  $eventsArray[$i]["Description"];
				}					
				break;
		}
	}

	// Second, check for a new event addition
	if (isset($_POST["submitEvent"]))
	{
		// Gather form input for stickiness
		$editInProgress = "checked";
		$editTitle = stripslashes($_POST["editEventTitle"]);
		$editDate = stripslashes($_POST["editEventDate"]);
		$editTime = stripslashes($_POST["editEventTime"]);
		$editDescription = stripslashes($_POST["editEventDescription"]);
		$editMeridiem = $_POST["editEventMeridiem"];
		if ($editMeridiem == "am")
		{
			$amMeridiem = "checked";
			$pmMeridiem = "";
		}
		else
		{
			$amMeridiem = "";
			$pmMeridiem = "checked";
		}		
		
		// Check that all fields have been entered
		if (strlen($editTitle) > 0 && strlen($editDate) > 0 && strlen($editTime) > 0 && strlen($editDescription) > 0)
		{
			// Check for date and time format
			$errors = 0;
			if (!preg_match("/^(0?[1-9]|1[0-2])\/(0?[1-9]|[1-2][0-9]|3[01])\/(19|20)\d{2}$/", $editDate))
			{
				$errors++;
				$errorMessage = "Date entered is not in the correct MM/DD/YYYY format.<br>";
			}
			if (!preg_match("/^(0?[1-9]|1[0-9]|\d)\:[0-5][0-9]$/", $editTime))
			{
				$errors++;
				$errorMessage .= "Time entered is not in the correct HH:MM format.<br>";
			}
			// Form successfully filled
			if ($errors == 0)
			{
				// Last form variable to modify before writing to file.
				// Format time to Unix time stamp
				$editDateTime = strtotime($editDate . " " . $editTime . " " . $editMeridiem);
				
				// If the event is an edit
				if (!empty($_POST["editEventId"]))
				{
					$editEventId = $_POST["editEventId"];
					// Create replacement string for array index
					$editedEvent = $editEventId . "\t" . $userId . "\t" . $editDateTime . "\t" . $editTitle . "\t" . $editDescription;		// for now the hard-coded, false Event ID of 7 is used

					// Find index of the original event for replacement
					$i = search_2d_array($eventsArray, "Event ID", $editEventId);
					$p = $eventsArray[$i]["User ID"];
					// Ensure current user wrote the event
					if ($p == $userId)
					{
						// Make string array of file and replace line at index
						$eventStringArray = file($file);
						$eventStringArray[$i] = $editedEvent;
						// Reset array to string and rewrite file
						$fileContent = implode("", $eventStringArray);
						$eventFile = fopen($file, "wb");
						// if the file doesn't open
						if ($eventFile === FALSE)
							$errorMessage = "There was an error saving the edited event.";
						// otherwise write the string and close the file
						else 
						{
							fwrite($eventFile, $fileContent);
							fclose($eventFile);
							// Reread the file to the web page's eventsArray
							$eventsArray = get2DAssocArray($file, $keys);
							
							// Clear form fields after writing file is complete.
							$editTitle = "";
							$editDate = "";
							$editTime = "";
							$editDescription = "";
							$amMeridiem = "";
							$pmMeridiem = "";
							$errorMessage = "The event was successfully saved.";
						}
					}
				}
				else	// It is a new event
				{
					// Create string for appending to file
					$newEvent = "\n" . 7 . "\t" . $userId . "\t" . $editDateTime . "\t" . $editTitle . "\t" . $editDescription;		// for now the hard-coded, false Event ID of 7 is used
					// Open file for appending
					$eventFile = fopen($file, "ab");
					// If the file doesn't open, display a message
					if ($eventFile === FALSE)
						$errorMessage = "There was an error saving the event!";
					// Otherwise write the record, close the file and display a message, then reread the file into the eventsArray		
					else 
					{
						fwrite($eventFile, $newEvent);
						fclose($eventFile);
						// Clear form fields after writing file is complete.
						$editTitle = "";
						$editDate = "";
						$editTime = "";
						$editDescription = "";
						$amMeridiem = "";
						$pmMeridiem = "";
						$errorMessage = "The event was successfully saved.";
						
						// Reread the file to the web page's eventsArray
						$eventsArray = get2DAssocArray($file, $keys);
					}
				}
			}
		}
		else	// Not all fields have been filled
		{
			$errorMessage = "All fields must be filled.";
		}
	} // End submit new event

	function printTable($array2d, $keys)
	{
		// Begin table
		echo "<table class='table table-hover'>";		// added table style
		
		// Add table head row from keys
		echo "<thead>";
		foreach ($keys as $rowHead)
		{
				echo "<th class='success'>$rowHead</th>";		// added text color style
		}
		echo "</thead>";
		
		// Add table rows of content for each event
		foreach ($array2d as $indexR=>$record)
		{
			echo "<tr>";
			// Iterate through each array element's contents and place in a table cell
			foreach ($record as $indexF=>$field)
			{	
				if ($indexF == "Time")			// This seems like a bad practice have the keys as an parameter but hard code this statement
					echo "<td>" . date('j M Y g:i a', $field) . "</td>";
				else
					echo "<td>$field</td>";
			}
					
			// This seems like a bad practice to have the keys as a parameter but hard code this statement
			// If the current array element's eventId is the same as the session's userId, add an extra edit/delete option.
			if ($record['User ID'] == $_SESSION["userId"])
			{
				$i = $record['Event ID'];
				echo "<td><a href='ecmain.php?action=EditEvent&EventId=$i'>edit</a>&nbsp;/&nbsp;<a href='ecmain.php?action=DeleteEvent&EventId=$i'>delete</a></td>";
			}
			else
			{
				echo "<td></td>";
			}			
			
			echo "</tr>";
		}
		
		// End table
		echo "</table>";
	}
}
else	// session does not hold userId and is redirected.
	header('Location:eclogin.php');