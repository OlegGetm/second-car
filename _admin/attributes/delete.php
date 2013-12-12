<?php
include_once('../_common/functions.php');
$link = to_connect();

$status= $_GET['status'];
$car_id = $_GET['car_id'];

	  
	  $q  = 
	  "DELETE from cars 
	  WHERE 
	  car_id = $car_id ";
	  
	  $result = $link->query ($q);
	  
	  
	  
	  
	  
	  header('Location: '.$_SERVER['HTTP_REFERER']);

?> 