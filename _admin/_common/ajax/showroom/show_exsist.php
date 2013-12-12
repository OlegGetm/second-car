<?php
include_once('../../functions.php');

$link = to_connect();
 
 $zapros = "SELECT *
 					FROM showroom
					WHERE area = 'lenta'
					ORDER by  pos
					 ";
$result = $link->query ($zapros);  
 
header('Content-Type: text/xml;');

$str = "[";
while($row = $result->fetch_assoc())	{
	
if(strlen($row[title]) == 0) $row[title] = 'no';	
if(strlen($row[type]) == 0) $row[type] = '';	
	
$str.= "
{pos: '$row[pos]', title: '$row[title]', type: '$row[type]' },";
}
$str = substr($str, 0, strlen($str)-1);
$str.= "
]";
	
echo $str;
?>
