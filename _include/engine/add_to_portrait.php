<?php

$name = $_POST['name'];
			$name = tipografica ($name);
			$name = cleaner_data($name);

			$text = $_POST['text'];
			$text = tipografica ($text);
			$text = cleaner_data($text);


      if(check_badwords($name) && check_badwords($text) && strlen($name)>2  && strlen($text)>5 ) 	{

		$zapros = "INSERT 
						 INTO 				portrait 
						(date, car_id, block, name, text )
						VALUES 
						(NOW(),   '$car_id',  '$block',  '$name', '$text' )"; 
		
	
		$result = $link->query ($zapros); 
		}			
			

$urls =	$_SERVER['HTTP_REFERER'];
header("location: $urls");

?>