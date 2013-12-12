<?php
include_once('../../functions.php');
$link = to_connect();


$article_id = $_POST['article_id'];	
$num_parag = $_POST['num_parag'];
$type = $_POST['type'];	

$new_text = $_POST['tt'];
//$new_text = iconv("UTF-8", "CP1251", $new_text);
$new_text = tipografica ($new_text);
$new_text = clean_data($new_text);


 
	$zapros = "UPDATE articles_photo SET
			{$type} = '$new_text'
			WHERE article_id = '$article_id' 
			AND		   num_parag = '$num_parag' 
			";
						
	$result = $link->query ($zapros);

if ($new_text =='' || !$new_text || $new_text =='+') $new_text = ' ';

header('Content-Type: text/xml');
echo    '<?xml version="1.0" ?>';
echo '<response>';
echo '<text>' .$new_text  .'</text>';
echo '</response> ';	
			
	 
 ?>