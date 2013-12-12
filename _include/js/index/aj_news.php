<?php
require_once('../../functions/functions.php'); 

clean_get();
$link = to_connect();
	
$zapros = "SELECT id_news, title
 					FROM news
					WHERE type = '$type'
 					ORDER by date desc 
					LIMIT 16"; 
$result = $link->query ($zapros);

header('Content-Type: text/xml;');

$str = "{'news': [";
while($row = $result->fetch_assoc())	{
$str.= "
{id_news: '$row[id_news]', title: '$row[title]'},";
}
$str = substr($str, 0, strlen($str)-1);
$str.= "
] }";
	
echo $str;
?>





















