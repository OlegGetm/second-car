<?php
require_once('_include/functions/functions.php');
require_once('_include/templates/array_segments.php');

$link = to_connect();



$zapros = "SELECT    	*
				  FROM 	cars  "; 
$result = $link->query ($zapros);




while ($row = $result->fetch_assoc() )  {

		$car_id 			= $row['car_id'];
					
		$q = "SELECT    				car_id
				 FROM 					stars  
				WHERE car_id  = 	'$car_id'
				"; 
					
		$res = $link->query ($q);
		$nums = $res->num_rows;	
		////////////////////////////////////////////////////			
		

		
		if($nums==0)			{
		
		$rate = array();
		$rate_sum = array();	
		
		
		echo '<br>' .$row['brand'] .' ' .$row['model']; 
			
				for($n=0; $n<4; $n++)		{
				
				$rating = 0;				
				$voices = rand(5, 11);
							
							for($k=0; $k<$voices; $k++)	{
							
							$rate_new = rand(5, 8);
							$rating = $rating + $rate_new;
							}
		
				$rate[$n] =  $rating;
		
				$rate_sum[$n] =  round($rating/$voices, 2);

				}
			
		$rate_common_sum = $rate_sum[0] + $rate_sum[1] + $rate_sum[2] + $rate_sum[3];
		// $rate_common_sum =  $rate_common_sum /4;
		$rate_common_sum = round($rate_common_sum/4, 2);
			
		$q2 = 
		"INSERT into stars 
		(car_id, rate_1, rate_2, rate_3, rate_4, votes, rate_s1, rate_s2, rate_s3, rate_s4, rate_sum)
		VALUES 
		( '$car_id', '$rate[0]', '$rate[1]', '$rate[2]', '$rate[3]', '$voices', '$rate_sum[0]', '$rate_sum[1]', '$rate_sum[2]' ,'$rate_sum[3]', '$rate_common_sum')	
		"; 

		$ress = $link->query($q2);
		
	
		
		
		}		
		
	}
		////////////////////////////////////////////////////
		
		
		
					
					


echo 'OK';
exit;

?>