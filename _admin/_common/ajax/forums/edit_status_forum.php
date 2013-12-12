<?php
include_once('../../functions.php');
$link = to_connect();

$portrait_id = (int)$_POST['portrait_id'];	
$interest = $_POST['interest'];

$zapros = 	"UPDATE portrait
				 	SET
					interest =  '$interest'
					WHERE portrait_id = '$portrait_id' ";
			
$result = $link->query ($zapros);

header('Content-Type: text/xml');
echo    '<?xml version="1.0"  ?>';
echo '<response>';
echo '<id_forum>' .$id_forum  .'</id_forum>';
echo '<interest>' .$interest  .'</interest>';
echo '</response> ';	
	
?>