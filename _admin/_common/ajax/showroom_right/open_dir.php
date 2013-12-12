<?php
include_once('../../functions.php');

$directory = '../../../../_photos/backgrounds';
$d = opendir($directory);

while( $f = readdir($d) )	{
	
	if(is_file("$directory/$f"))
	
	$file_array[] = $f;
}

closedir($d);


 
header('Content-Type: text/xml;');

$str = "[";
foreach ($file_array as $value)	{
	
$str.= "
{file_name: '$value' },";
}

$str = substr($str, 0, strlen($str)-1);
$str.= "
]";
	
echo $str;
?>
