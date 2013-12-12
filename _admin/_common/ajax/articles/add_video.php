<?php
include_once('../../functions.php');
$link = to_connect();

$car_id 			= $_POST['car_id'];
$parag 			= $_POST['parag'];


$sourse = $_POST['sourse'];


$text = $_POST['text'];
$text = tipografica ($text);
$text = clean_data($text);

$zapros = "INSERT INTO 			letters_videos 
				(car_id, parag, sourse, text)
				VALUES 
				('$car_id',  '$parag', '$sourse', '$text')
"; 
$result = $link->query ($zapros);


$url = 'Location: ../../../articles/add_media.php?car_id=' .$car_id .'#' .$parag;
header ($url);

?>