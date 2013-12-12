<?php
include_once('../../functions.php');

$id_art_dial = $_POST['id_art_dial'];	
$interest = $_POST['interest'];

$link = to_connect();

$zapros = "UPDATE replics SET
						interest =  '$interest'
						WHERE replica_id = '$id_art_dial' ";
			
$result = $link->query ($zapros);

header('Content-Type: text/xml');
echo    '<?xml version="1.0" ?>';
echo '<response>';
echo '<id_art_dial>' .$id_art_dial  .'</id_art_dial>';
echo '<interest>' .$interest  .'</interest>';
echo '</response> ';	
	
?>