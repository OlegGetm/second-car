<?php

$model = $_REQUEST['model'];	
$year_begin = $_REQUEST['year_begin'];	

$link = new mysqli ('a20057.mysql.mchost.ru', 'a20057_1', 'stopstop');
$link->select_db ('a20057_1');
	
	$zapros = "SELECT  year_end 
					FROM attributes
 				  WHERE model = '$model' 
				  AND year_begin = '$year_begin' ";
  	$result = $link->query($zapros);
	 $row = $result->fetch_assoc();
	 
 	  if (!$row['year_end']) { $row['year_end'] = 'none'; }
 
  header('Content-Type: text/xml');
  echo    '<?xml version="1.0" encoding="UTF-8" ?>';
		echo '<response>';
  	  	echo '<yearend>' .$row['year_end'] .'</yearend>';
		echo '</response> ';
?>