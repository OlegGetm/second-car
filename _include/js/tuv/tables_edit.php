<?php
require_once('../../functions/functions.php'); 

$link = to_connect();

$age = (int)$_POST['age'];

	
$zapros = 	"SELECT *
					FROM 							tuv
					WHERE 	age		=		'$age'
					ORDER BY 					mesto, model
					";
$result = $link->query ($zapros);

header('Content-Type: text/xml;');

$str = "[";
while($row = $result->fetch_assoc())	{
$str.= "
{mesto: '$row[mesto]', brand: '$row[brand]', model: '$row[model]', otsev: '$row[otsev]', probeg: '$row[probeg]'},";
}
$str = substr($str, 0, strlen($str)-1);
$str.= "
]";
	
echo $str;
?>





















