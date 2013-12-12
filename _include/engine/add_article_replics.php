<?php

clean_get();
$article_id = (int)$_GET['article'];

$text = tipografica ($_POST['text']);
$text = cleaner_data($text);

$name = tipografica ($_POST['name']);
$name = cleaner_data($name);

  
      if(check_badwords($name) && check_badwords($text) && strlen($name)>2  && strlen($text)>5 ) 	{

						$zapros = "INSERT into replics 
										(date, article_id, number, name, text)
										values 
										(NOW(), '$article_id', '$number', '$name', '$text') ";
						$result = $link->query ($zapros); 	
		}

$urls =	$_SERVER['HTTP_REFERER'];
header("location: $urls");

?>