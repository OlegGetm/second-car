<?php
include_once('../../functions.php');
$link = to_connect();

$brand = $_REQUEST['brand'];	



$zapros = "SELECT DISTINCT model 
					FROM cars  
					WHERE brand = '$brand'
					ORDER by model ";
				
  	$result = $link->query($zapros);
	$num_results = $result->num_rows; 
 
  // generate the response
  header('Content-Type: text/xml');
  echo    '<?xml version="1.0" encoding="UTF-8" ?>';
	echo '<response>';
  	  for ($i=0; $i <$num_results; $i++)  	{
	  $row = $result->fetch_assoc();
	  echo '<model>' .$row['model'] .'</model>';
	   } 
	echo '</response> ';
 
 ?>