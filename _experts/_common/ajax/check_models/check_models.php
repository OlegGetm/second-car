<?php

$brand = $_REQUEST['brand'];	

$link = new mysqli ('a20057.mysql.mchost.ru', 'a20057_1', 'stopstop');
$link->select_db ('a20057_1');

$zapros = "SELECT DISTINCT model 
					FROM attributes  
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