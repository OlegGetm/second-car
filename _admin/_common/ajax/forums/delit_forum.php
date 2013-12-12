<?php
include_once('../../functions.php');
$id_forum = $_POST['id_forum'];	

$link = to_connect();

$zapros  = "DELETE 
 					FROM forum 
					WHERE id_forum = '$id_forum' ";
			
$result = $link->query ($zapros);
?>