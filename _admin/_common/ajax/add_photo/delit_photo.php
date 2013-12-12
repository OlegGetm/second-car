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

///////////////////////
			$filename = '../../../../_photos/articles/' .$img_name;
			if (file_exists($filename))
			unlink ($filename);
///////////////////////

$zapros  = "DELETE 
 					FROM articles_photo 
					WHERE article_id = '$article_id' 
					AND		   num_parag = '$num_parag' 
					";
			
$result = $link->query ($zapros);
?>