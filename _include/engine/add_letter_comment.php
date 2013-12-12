<?php

$_POST['name'] = tipografica ($_POST['name']);  // привести в порядок кавычки, тире, пробелы
$_POST['text'] 		= tipografica ($_POST['text']);                

clean_post();  															

if(check_badwords ($name) && check_badwords ($text) && strlen($name)>2  && strlen($text)>20 )	{

    			$zapros = "INSERT into comments
								(date, letter_id, name, text)
								VALUES 
								(NOW(), '$letter_id', '$name', '$text' ) ";
				$result = $link->query ($zapros);
}


$urls =	$_SERVER['HTTP_REFERER'];
header("location: $urls");

?>