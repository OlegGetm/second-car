<?php
include_once('../../functions.php');
$link = to_connect();

$article_id = $_POST['article_id'];	
$num_parag = $_POST['num_parag'];	
 
$zapros = "SELECT * 
 					FROM articles_photo 
					WHERE article_id = '$article_id'
					AND
					num_parag = '$num_parag'
					";
	
$result = $link->query ($zapros);
$row = $result->fetch_assoc();

$img_name = $row['img_name'];
$width = $row['width'];
$height = $row['height'];
$alt_text = $row['alt_text'];
$text = $row['text'];

if ($img_name 	=='' || !$img_name 	) $img_name 	= ' ';
if ($width			=='' || !$width 			) $width 			= ' ';
if ($height 		=='' || !$height 		) $height 			= ' ';
if ($alt_text 		=='' || !$alt_text 		) $alt_text 		= ' ';
if ($text 			=='' || !$text 				) $text 				= ' ';

header('Content-Type: text/xml');
echo    '<?xml version="1.0"  ?>';
echo '<response>';
echo '<img_name>' .$img_name  .'</img_name>';
echo '<width>' .$width  .'</width>';
echo '<height>' .$height  .'</height>';
echo '<alt_text>' .$alt_text  .'</alt_text>';
echo '<text>' .$text  .'</text>';
echo '</response> ';	

?>