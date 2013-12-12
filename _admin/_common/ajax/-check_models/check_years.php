<?php
include_once('../../functions.php');
$link = to_connect();

$model = $_REQUEST['model'];	


	$zapros = "SELECT			 year1, year2 
					FROM 					cars
					WHERE model = '$model'  
					ORDER BY 			year1 
					";
  	$result = $link->query($zapros);
	$num_results = $result->num_rows; 
	
  // generate the response
  header('Content-Type: text/xml');
  echo    '<?xml version="1.0" encoding="UTF-8" ?>';
	echo '<response>';
  	  for ($i=0; $i <$num_results; $i++)  	{
	  $row = $result->fetch_assoc();
	  if (!$row['year2']) { $row['year2'] = '300'; }
	  
	  echo '<year1>' .$row['year1'] .'</year1>';
  	  echo '<year2>' .$row['year2'] .'</year2>';
	   } 
	echo '</response> ';
 
 ?>