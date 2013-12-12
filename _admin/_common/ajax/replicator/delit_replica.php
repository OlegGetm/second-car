<?php
include_once('../../functions.php');

$link = to_connect();

$id_art_dial = $_POST['id_art_dial'];	


$zapros  = "DELETE 
 					FROM 	replics 
					WHERE replica_id = '$id_art_dial' ";
			
$result = $link->query ($zapros);
?>