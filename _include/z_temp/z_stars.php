<?php
require_once('_include/functions/functions.php');
$link = to_connect();



$zapros = "SELECT    	*
				  FROM 	attributes  "; 
$result = $link->query ($zapros);

while ($row = $result->fetch_assoc() )  {

$car_id = $row['car_id'];

$rate_s1 = $row['rate_1'];
$rate_s2 = $row['rate_2'];
$rate_s3 = $row['rate_3'];						
$rate_s4 = $row['rate_4'];	
	
	$zapros3 = "UPDATE stars SET
						rate_s1 =  '$rate_s1',
						rate_s2 =  '$rate_s2',
						rate_s3 =  '$rate_s3',
						rate_s4 =  '$rate_s4'
						
						WHERE
						car_id = '$car_id'
						  ";

$result3 = $link->query ($zapros3);	
}


echo 'OK';
exit;



?>