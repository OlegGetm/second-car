<?php
$model = $_REQUEST['model'];	

$link = new mysqli ('a20057.mysql.mchost.ru', 'a20057_1', 'stopstop');
$link->select_db ('a20057_1');

	$zapros = "SELECT year_begin, year_end 
					FROM attributes
					WHERE model = '$model'  
					ORDER by year_begin ";
  	$result = $link->query($zapros);
	$num_results = $result->num_rows; 
	
  // generate the response
  header('Content-Type: text/xml');
  echo    '<?xml version="1.0" encoding="UTF-8" ?>';
	echo '<response>';
  	  for ($i=0; $i <$num_results; $i++)  	{
	  $row = $result->fetch_assoc();
	  if (!$row['year_end']) { $row['year_end'] = 'none'; }
	  
	  echo '<yearbegin>' .$row['year_begin'] .'</yearbegin>';
  	  echo '<yearend>' .$row['year_end'] .'</yearend>';
	   } 
	echo '</response> ';
 
 ?>