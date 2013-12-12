<?php
include_once('../../functions.php');

$article_id = $_POST['article_id'];	
$num_parag = $_POST['num_parag'];

$new_text = $_POST['tt'];
$new_text = tipografica ($new_text);
$new_text = clean_data($new_text);

$link = to_connect();

$zapros = "SELECT * 
 					FROM articles 
					WHERE article_id = '$article_id' ";
				
  	$result = $link->query($zapros);
	$row = $result->fetch_assoc();
  

$old_text = $row['text']; 	

$text = $row['text']; 								// Получение hypertext
$paragraph =  explode ("\r\n", $text);	// Разбивка текста на абзацы (получается массив)
  
$older_parag_text = $paragraph[$num_parag] ;    //  первоначальный текст редактируемого параграфа
 
$edit_article  = str_replace($older_parag_text, $new_text, $old_text);  // отредактированный вариант статьи
 
 
	$zapros = "UPDATE articles SET
			text = '$edit_article'
			WHERE article_id = '$article_id' ";
			
			
	$result = $link->query ($zapros);
			
	 
 ?>