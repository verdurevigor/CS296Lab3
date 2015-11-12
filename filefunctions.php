<?php
	
	// Opens file and creates a 2d array from the file contents
	function get2DArray($filename)
	{

		$array2D = array();
		@$fp = fopen($filename, 'r');

		if (!$fp)
			throw new Exception("Can't open file $filename. $php_errormsg.");
		
		$i = 0;
		while(!feof($fp))
		{
				if (($record = fgetcsv($fp, 2000, "\t")) !== false)
				{
					$array2D[$i] = $record;
					$i++;
				}
				else
					throw new Exception("Can't read record from the file $filename");
		}
		
		if (!fclose($fp))
			throw new Exception ("Can't close file $filename");
		
		return $array2D;
	}
	
	// Caution: This function will throw an exception the last line of the text file is empty.
	// Therefore, when appending to the file in other areas, it is necessary to add a newline character BEFORE adding the new value.
	// The new value cannot end in a newline character.
	
	// returns a 2d array that uses a numeric key as the index for the event and a string key for the event contents
	// ie array[event1,key1], array[event1, key2], etc for each event where key is the title of the content.
	function get2DAssocArray($filename, $keys)
	{
		$array2D = array();
		@$fp = fopen($filename, 'r');

		if (!$fp)
			return $array2D;
		
		$i = 0;
		while(!feof($fp))
		{
			if (($record = fgetcsv($fp, 2000, "\t")) !== false)
			{
				for ($k = 0; $k < count($keys); $k++)
				{
					// if every record doesn't have the same number of fields
					if (isset($record[$k]) && trim($record[$k]) != "")
					{
						$array2D[$i][$keys[$k]] = $record[$k];
					}
				}
				$i++;
			}
			else
				throw new Exception("Can't read record from the file $filename");
		}
		
		if (!fclose($fp))
			throw new Exception ("Can't close file $filename");
		
		return $array2D;
	}
	
	/*	Commented out because this same exact function is in array2dfunctions.php
	function echo2DArray($array)
	{
		echo "<p>There are " . count($array) . " rows in the 2D array<br />";
		echo "Each record has " . count($array[0]) . " fields</p>";
		foreach ($array as $indexR=>$record)
		{
			echo "$indexR&nbsp;&nbsp;&nbsp;";
			foreach ($record as $indexF=>$field)
				echo "$indexF: $field&nbsp;&nbsp;&nbsp;";
			echo "<br />";
		}
	}
	*/
/*	
	try
	{
		$events = get2DArray('events/events.txt');
		echo2DArray($events);
		$events = get2DAssocArray('events/events.txt', array('event id', 'user id', 'date', 'title', 'description'));
		echo2DArray($events);
	}
	catch (Exception $e)
	{
		echo "Exception: " . $e->getMessage() . " occurred in " . $e->getFile() . " at line " . $e->getLine() . "." ; 
	}
*/
?>