<?php
require_once('../../functions/functions.php'); 
$link = to_connect();

clean_post();

if(strlen($brand)>0)		{

$q = "SELECT 				 	model, car_id 
		FROM 							cars  
		WHERE 	brand = 		'$brand'
		GROUP BY 				model
		ORDER BY 					model 		";
$result = $link->query ($q);

header('Content-Type: text/xml;');
$str = "[";
while($row = $result->fetch_assoc())	{
$str.= "
{ id: '$row[car_id]', model: '$row[model]' },";
}
$str = substr($str, 0, strlen($str)-1);
$str.= "
]";
	
echo $str;
}

/////////////////////////////////////////////////////////////////

else if(strlen($model)>0)		{
	
$q = "SELECT 	car_id,  year1, year2 
		FROM 						cars
		WHERE model = 	'$model' 
		ORDER BY 				year1 ";
$result = $link->query ($q);

header('Content-Type: text/xml;');
$str = "[";
while($row = $result->fetch_assoc())	{
$str.= "
{ car: " .$row['car_id'] .", years: '" .$row['year1'] ."-" .$row['year2'] ."' },";
}
$str = substr($str, 0, strlen($str)-1);
$str.= "
]";
	
echo $str;
}



?>