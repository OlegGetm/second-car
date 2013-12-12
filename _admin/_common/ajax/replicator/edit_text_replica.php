<?php
include_once('../../functions.php');

$replica_id = $_POST['id_replica'];	

$new_text = $_POST['tt'];
$new_text = tipografica ($new_text);
$new_text = clean_data($new_text);

$link = to_connect();
 
	$zapros = "UPDATE replics SET
			text = '$new_text'
			WHERE replica_id = '$replica_id' ";
			
			
	$result = $link->query ($zapros);
	
header('Content-Type: text/xml');
echo    '<?xml version="1.0" ?>';
echo '<response>';
echo '<text>' .$new_text  .'</text>';
echo '</response> ';	
			
	 
 ?>