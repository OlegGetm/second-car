<?php
require_once('../../functions/functions.php'); 

$link = to_connect();

$type = (int)$_POST['type'];

if ($type == "0") 			{	$order_by = 'number_readers';
} else 							{	$order_by = 'last_date';               }

$zapros = 	"SELECT 	topic_id, car_id, brand, model, year1, title, date
 				  	FROM 							forum_topics 
				  	LEFT JOIN 					cars 
					USING 						(car_id)
				  	ORDER BY 					$order_by 	DESC
				  	LIMIT 8		"; 

$result = $link->query ($zapros);

header('Content-Type: text/xml; ');

$str = "{'forums': [";
while($row = $result->fetch_assoc())	{

$model= urlencode($row[model]);

if(strlen($row[brand])<3) 	{		//защита от пустого значения
$brand = " ";
}	else	{
$brand = $row[brand];
}


$title =mb_substr($row['title'], 0,62,  'utf-8');
if(mb_strlen($title, 'utf-8')>62) $title .= '...';


$str.= "
{car: '$row[car_id]', topic: '$row[topic_id]', brand: '$brand', model: '$model', year1: '$row[year1]', title: '$title'},";
}
$str = substr($str, 0, strlen($str)-1);
$str.= "
] }";
	
echo $str;
?>





















