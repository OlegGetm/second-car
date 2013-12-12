<?php
include_once('../../functions.php');
$link = to_connect();

$pos = $_POST['pos'];
$url = $_POST['url'];
$photo = $_POST['photo'];

$photo = '_photos/backgrounds/' .$photo .'.jpg' ;

$title = $_POST['title'];
//$title = iconv("UTF-8", "CP1251", $title);
$title = tipografica ($title);
$title = clean_mini($title);


$zapros = "UPDATE showroom SET
			title = '$title',
			url = '$url',
			photo = '$photo'
			WHERE area = 'right' 
			AND      pos = '$pos' ";
$result = $link->query ($zapros);

			
header('Content-Type: text/xml;');

if($result)		{
echo "
[ {good: 'yes' }  ]";	
	
}	else	{
echo "
[ {good: 'no' }  ]";	
}
	 
	 
 ?>