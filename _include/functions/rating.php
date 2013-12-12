<?php

function 	calculate_stars ($car_id, $width_star)  {

$link = to_connect();			

					$ar = array();
										
	$zapros =	 "SELECT *
 					FROM stars
 					WHERE car_id = 	'$car_id' 
					LIMIT 1 ";
					
					$result = $link->query ($zapros);
					$row = $result->fetch_assoc();
					
					$votes = ($row['votes'] > 0) ? $row['votes'] : 0;
					$ar['votes'] 	= $votes;
					
					if($votes>0)		{
									for ($n=1; $n<5; $n++) 	 {
									$ar['width' .$n] =  ceil($row['rate_s' .$n]*$width_star);
									$ar['mark' .$n] =  round($row['rate_s' .$n], 3);
									$ar['mark' .$n] =  number_format($ar['mark' .$n], 3, '.', '');
									}
				
				$mark_sum = round($row['rate_sum'], 3);
				$mark_sum =  number_format($mark_sum, 3, '.', '');
				$ar['mark_sum'] 	= $mark_sum;
				}
				return $ar;
}

?>
