<?php

	$events = array (
				array(	'eventId'=>1,
						'userId'=>1,
						'date'=>strtotime("2012-04-01 00:00:00"),
						'title'=>"April Fools Day",
						'description'=>"Today is the perfect day to play practical jokes on all of your classmates."), 
				array(	'eventId'=>2,
						'userId'=>3,
						'date'=>strtotime("2012-04-01 00:00:00"),
						'title'=>"Term Project Due",
						'description'=>"The final version of your term project is due at noon today."), 
				array(	'eventId'=>3,
						'userId'=>1,
						'date'=>strtotime("2012-04-02 00:00:00"),
						'title'=>"First Day of Classes",
						'description'=>"Ready or not.  Here we go!"), 
				array(	'eventId'=>14,
						'userId'=>2,
						'date'=>strtotime("2012-04-08 00:00:00"),
						'title'=>"Easter",
						'description'=>"Don't forget lots of chocolate eggs for your favorite teacher."), 
				array(	'eventId'=>6,
						'userId'=>3,
						'date'=>strtotime("2012-04-18 00:00:00"),
						'title'=>"End of 2nd Week",
						'description'=>"You've made it through 2 weeks.  Congratulations!")
			);

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

	// Returns index of array element if value at key is correct
	// otherwise returns false
	function search_2d_array($array, $key, $value) {
		for ($i = 0; $i < count($array); $i++)
		{
			if (isset($array[$i][$key])) {
				if ($array[$i][$key] == $value) {
					return $i;
				}
			}	
		}
		return false;
    };
	
	function usortByKey(&$array, $key, $asc=SORT_ASC) {
		$sort_flags = array(SORT_ASC, SORT_DESC);
		if(!in_array($asc, $sort_flags)) 
			throw new InvalidArgumentException('sort flag only accepts SORT_ASC or SORT_DESC');
		$cmp = function(array $a, array $b) use ($key, $asc, $sort_flags) {
			if(!isset($a[$key]) || !isset($b[$key])) {
				throw new Exception('attempting to sort on non-existent keys');
			}
			if($a[$key] == $b[$key]) return 0;
			return ($asc==SORT_ASC xor $a[$key] < $b[$key]) ? 1 : -1; 
		};
		usort($array, $cmp);
	};
	
	// This function sorts by key just as the function above, however, the key parameter can be an array - used to sort by multiple values
	function usortByArrayKey(&$array, $key, $asc=SORT_ASC) {
		$sort_flags = array(SORT_ASC, SORT_DESC);
		if(!in_array($asc, $sort_flags)) 
			throw new InvalidArgumentException('sort flag only accepts SORT_ASC or SORT_DESC');
		$cmp = function(array $a, array $b) use ($key, $asc, $sort_flags) {
			if(!is_array($key)) { //just one key and sort direction
				if(!isset($a[$key]) || !isset($b[$key])) {
					throw new Exception('attempting to sort on non-existent keys');
				}
				if($a[$key] == $b[$key]) return 0;
				return ($asc==SORT_ASC xor $a[$key] < $b[$key]) ? 1 : -1;
			} 
			else 
			{ //using multiple keys for sort and sub-sort
				foreach($key as $sub_key => $sub_asc) {
					//array can come as 'sort_key'=>SORT_ASC|SORT_DESC or just 'sort_key', so need to detect which
					if(!in_array($sub_asc, $sort_flags)) { $sub_key = $sub_asc; $sub_asc = $asc; }
					//just like above, except 'continue' in place of return 0
					if(!isset($a[$sub_key]) || !isset($b[$sub_key])) {
						throw new Exception('attempting to sort on non-existent keys');
					}
					if($a[$sub_key] == $b[$sub_key]) continue;
					return ($sub_asc==SORT_ASC xor $a[$sub_key] < $b[$sub_key]) ? 1 : -1;
				}
            return 0;
			}
		};
		usort($array, $cmp);
	};
	
	/*
	echo2DArray($events);
	$index = search_2d_array($events, 'eventId', 14);
	if ($index !== false)
	{
		echo("found event id 14");
		echo ("<br />");
		echo('userId ' . $events[$index]['userId'] . "<br />");
		echo('date ' . $events[$index]['date'] . "<br />");
		echo('title ' . $events[$index]['title']. "<br />");
		echo('description ' . $events[$index]['description'] . "<br />");
	}
	*/
	//echo ("sorting by user id");
	//echo ("<br />");
	//usortByKey($events, 'userId');
	//echo2DArray($events);
	
?>