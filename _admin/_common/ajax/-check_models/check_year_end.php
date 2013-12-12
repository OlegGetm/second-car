<?php
include_once('../../functions.php');
$link = to_connect();

$model = $_REQUEST['model'];	
$year1 = $_REQUEST['year1'];	


	
	$zapros = "SELECT  year2 
					FROM cars
 				  WHERE model = '$model' 
				  AND year1 = '$year1' ";
  	$result = $link->query($zapros);
	 $row = $result->fetch_assoc();
	 
 	  if (!$row['year2']) { $row['year2'] = 'none'; }
 
  header('Content-Type: text/xml');
  echo    '<?xml version="1.0" encoding="UTF-8" ?>';
		echo '<response>';
  	  	echo '<year2>' .$row['year2'] .'</year2>';
		echo '</response> ';
?>