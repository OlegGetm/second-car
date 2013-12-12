<?php
require_once('../../functions/functions.php'); 
$link = to_connect();

$article_id = (int)$_POST['article'];
	
$zapros = "	SELECT *
 					FROM 	replics
 					WHERE article_id = '$article_id'
					ORDER by number, append_to DESC, date 
					";
$result = $link->query ($zapros);

$number =0;

header('Content-Type: text/xml; charset=utf-8');

$str = "[";

while($row = $result->fetch_assoc())	{

$text = str_replace("\r", "", $row[text]);  
$text = str_replace("\n", "\\n", $text);
//if(strlen($row['interest']=='0')) $row['interest'] = '';

$str.= "
{nums: '$number', par: '$row[number]', name: '$row[name]', interest: '$row[interest]', text: '$text'},";

++$number;
}
$str = substr($str, 0, strlen($str)-1);
$str.= "
]";
	
echo $str;


?>