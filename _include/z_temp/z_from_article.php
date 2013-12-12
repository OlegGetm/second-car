<?php
require_once('_include/functions/functions.php');
$link = to_connect();



$zapros = "SELECT    	*
				  FROM 	letters_media  "; 
$result = $link->query ($zapros);

while ($row = $result->fetch_assoc() )  {


					$letter_id 	= $row['id_letter'];
					$year1 	= $row['year_begin'];


						$zapros2 = "SELECT 	car_id 	FROM 	cars
											WHERE
											model = '$model'
											AND
											year1 = '$year1'   ";
		
		
						$result2 = $link->query ($zapros2);
						$row2 = $result2->fetch_assoc();
						
						$car_id  =  $row2['car_id'];
						
		
	$zapros3 = "UPDATE articles2 SET
						car_id =  '$car_id'
						WHERE
						model = '$model'
						AND
						year_begin = '$year1'   ";

$result3 = $link->query ($zapros3);	
}


echo 'OK';
exit;



?>