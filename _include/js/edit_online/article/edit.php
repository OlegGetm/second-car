<?php
require_once('../../../functions/functions.php');

$link = to_connect();

$article_id = $_POST['article_id'];	
$num_parag = $_POST['num_parag'];                          

$new_text = $_POST['text'];
//$new_text = iconv("UTF-8", "CP1251", $new_text);
$new_text = tipografica($new_text);  		
$new_text = cleaner_data($new_text); 


//$new_text = preg_replace("/\\r\\n$/", "",  $new_text); 		// последний перевод строки
$new_text = preg_replace("#\n#is", ""  ,$new_text);


$new_text_array 	=  explode ("\\r\\n", $new_text);					//  сколько абзацев в присланном тексте
$num_abzazs 		  	=  count($new_text_array);						// количество абзацев

$zapros = "SELECT * 
 					FROM articles 
					WHERE article_id = '$article_id' ";
				
  	$result = $link->query($zapros);
	$row = $result->fetch_assoc();
  
 ////// экзекуция с текстом, чтобы найти нужный параграф
$older_text = $row['text']; 	

$pars =  explode ("\r\n", $older_text);							// Разбивка текста на абзацы (получается массив)
$older_parag_text = $pars[$num_parag] ;   		 		//  прежний текст  параграфа
 																					// отредактированный вариант статьи
$edit_article  = str_replace($older_parag_text, $new_text, $older_text);  
 
 
	$zapros = "UPDATE articles SET
					  text = '$edit_article'
			          WHERE article_id = '$article_id' ";
	$result5 = $link->query ($zapros);

	
	
	///////////////////////////////////////////////////////////////////////////      изменить нумерацию реплик
		if($num_abzazs > 1)		{	
		$nn = $num_parag+0;
		
		$zapros = "SELECT id, number
 						FROM article_replics 
						WHERE article_id = '$article_id'
						AND number > '$nn' ";
	
						$result = $link->query ($zapros);
						$ns = $result->num_rows;	

		while(list($id, $number) = $result->fetch_row())		{	
		$new_number = $number + $num_abzazs - 1;
				
				$zapros_2 = "UPDATE article_replics 
								SET
								number = '$new_number'
								WHERE 
								id = '$id'   ";
				$result_2 = $link->query ($zapros_2);
			}	
			}
	///////////////////////////////////////////////////////////////////////////
		
	if($result5)	{
	header('Content-Type: text/xml;');	

	$str = 
'[';
	
	for ($i=0; $i<$num_abzazs; $i++) 	 {
	
	$str.= "
{num: '$num_abzazs', text: '$new_text_array[$i]'},";
	}	
	
	$str = substr($str, 0, strlen($str)-1);
	$str.= '
]';
	
echo $str;

}
?>

