<?php
require_once('../../functions/functions.php');
$link = to_connect();

$car_id 	= (int)$_POST['car'];
$ip			= $_POST['ip'];

	$zapros = "SELECT *
						FROM 							stars 
 				  		WHERE car_id = 		'$car_id' 
						LIMIT 1 ";
	
	$result = $link->query ($zapros);
	$row = $result->fetch_assoc();
	
	$votes = (int)$row['votes'];

///////////////////////////////////////////////////
	for ($n=1; $n<5; $n++) 	 {
		
	$rate_new[$n] 			=  (int)$_POST['rate' .$n];	
	$rates_before[$n] 	=  $row['rate_' .$n];
	$rates_after[$n] 		=  $rate_new[$n] + $rates_before[$n];
	}
////////////////////////////////////////////////////

	$zapros = 	"UPDATE stars 
						SET
						rate_1 =  	'$rates_after[1]',
						rate_2 =   '$rates_after[2]',
						rate_3 =  	'$rates_after[3]',
						rate_4 =   '$rates_after[4]',
						votes  = 	'$votes' +1
						
						WHERE car_id = 		'$car_id'
						LIMIT 1 ";
	
	$result = $link->query ($zapros);

///////////////////////////////////////////////////////////////
$rate_sum= ($rates_after[1] + $rates_after[2] + $rates_after[3] + $rates_after[4])/4;
$new_votes = (int)$votes +1;
$rate_sum= round($rate_sum/$new_votes, 3);


for ($n=1; $n<5; $n++) 	 {
$rate_attr[$n] = round($rates_after[$n]/$new_votes, 3);
}

	$zapros_sum = 	"UPDATE stars 
						SET
						rate_s1 =  		'$rate_attr[1]',
						rate_s2 =   	'$rate_attr[2]',
						rate_s3 =  		'$rate_attr[3]',
						rate_s4 =   	'$rate_attr[4]',
						rate_sum =  '$rate_sum'
						
						WHERE car_id = 		'$car_id'
						LIMIT 1 ";
	
	$zapros_sum = $link->query ($zapros_sum);

///////////////////////////////////////////////////////////////
	$zapros_strars_time = 
					"INSERT INTO stars_time
					( car_id, date, ip, rate_1, rate_2, rate_3, rate_4)
					VALUES
					( '$car_id', NOW(), '$ip', '$rate_new[1]', '$rate_new[2]', '$rate_new[3]', '$rate_new[4]') 	
					";
	$zapros_strars_time = $link->query ($zapros_strars_time);
/////////////////////////////////////////////////////////////////

if($result)	{ 


$cook = $rate_new[1] .'|' .$rate_new[2] .'|' .$rate_new[3] .'|' .$rate_new[4] ;

setcookie ($car_id , $cook, time()+31536000, "/" );



header('Content-Type: text/xml;');

$str = "[";
$str.= "
{good: 'yes', rate1: '$rate_new[1]', rate2: '$rate_new[2]', rate3: '$rate_new[3]', rate4: '$rate_new[4]' } 
]";
	
echo $str;

}
?>