<?php
require_once('../../../functions/functions.php');
$link = to_connect();


$id = $_POST['id'];
$sql_name = $_POST['sql_name'];
$id_name = $_POST['id_name'];

$old_text = $_POST['old_text'];
$old_text = trim ($old_text);
//$old_text 	= iconv("UTF-8", "CP1251", $old_text);
$old_text = str_replace('\"', '"', $old_text);  					//  проигнорировать старые неправильные (одинарные) кавычки
			
$new_text = $_POST['new_text'];
//$new_text 	= iconv("UTF-8", "CP1251", $new_text);	
$new_text = tipografica($new_text);  							// привести в порядок кавычки, тире, пробелы
$new_text = cleaner_data($new_text); 

$zapros = "SELECT * 
 					FROM {$sql_name}
					WHERE {$id_name} = '$id'     
					";
				
  	$result = $link->query($zapros);
	$row = $result->fetch_assoc();
  
 ////// экзекуция с текстом, чтобы найти нужный параграф
$all_text = $row['text']; 		
$edited_article  = str_replace($old_text, $new_text, $all_text);  			
				
				$zapros = "UPDATE {$sql_name}
								 SET
								 text = '$edited_article'
								 WHERE {$id_name} = {$id}   
								 ";
				$result = $link->query ($zapros);

if ($result)	{

header('Content-Type: text/xml;');

$paragraph =  explode ("\r\n", $new_text); // Разбивка текста на абзацы (получается массив)
$num_parag = count($paragraph);

$str = "
[";
		for ($i=0; $i<$num_parag; $i++)		{
		$str.= "
{paragraph: '$paragraph[$i]' },";
		}
		
$str = substr($str, 0, strlen($str)-1);
$str.= "
] ";
	
echo $str;
}
?>