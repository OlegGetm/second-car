<?php
include_once('../../functions.php');
$link = to_connect();

$letter_id 			= $_POST['letter_id'];
$parag 			= $_POST['parag'];


$sourse = $_POST['sourse'];


$text = $_POST['text'];
$text = tipografica ($text);
$text = clean_data($text);

$zapros = "INSERT INTO 			letters_videos 
				(letter_id, parag, sourse, text)
				VALUES 
				('$letter_id',  '$parag', '$sourse', '$text')
"; 
$result = $link->query ($zapros);


$url = 'Location: ../../../letters/add_media.php?letter_id=' .$letter_id .'#' .$parag;
header ($url);

?>