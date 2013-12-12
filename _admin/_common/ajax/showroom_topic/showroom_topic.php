<?php
include_once('../../functions.php');
$link = to_connect();

$pos = $_POST['pos'];
$url = $_POST['url'];

$title = $_POST['title'];
//$title = iconv("UTF-8", "CP1251", $title);
$title = tipografica ($title);
$title = clean_mini($title);

$subtitle = $_POST['subtitle'];
//$subtitle = iconv("UTF-8", "CP1251", $subtitle);
$subtitle = tipografica ($subtitle);
$subtitle = clean_mini($subtitle);

$photo = $_POST['photo'];


$zapros = "UPDATE showroom SET
			title = '$title',
			subtitle = '$subtitle',
			url = '$url',
			photo = '$photo'
			WHERE area = 'topic' 
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