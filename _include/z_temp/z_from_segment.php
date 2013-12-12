<?php
require_once('_include/functions/functions.php');
require_once('_include/templates/array_segments.php');

$link = to_connect();



$zapros = "SELECT    	*
				  FROM 	cars  "; 
$result = $link->query ($zapros);




while ($row = $result->fetch_assoc() )  {

					$car_id 			= $row['car_id'];
					$segment_old 	= $row['segment'];

					foreach($ar_segment as $key => $val) 	{
					
							if($val == $segment_old)		{
							
							$segment_new = $key;
								
							$zapros3 = 
							"UPDATE cars 
							SET
							segment2 =  '$segment_new'
							WHERE
							car_id = '$car_id'    						  ";
	
							$result3 = $link->query ($zapros3);	
							break;
							}
					}

}


echo 'OK';
exit;

?>