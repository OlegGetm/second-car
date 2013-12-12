<?php
require_once('_include/functions/functions.php');
$link = to_connect();


$zapros = "SELECT    	*
				  FROM 	cars  "; 
$result = $link->query ($zapros);

while ($row = $result->fetch_assoc() )  {

$old_foto =  '_photos/cars/micro/' .$row['brand'] .'_' .$row['model'] .'_' .$row['year1'] .'_1.jpg';
$new_foto =  '_photos/cars/micro2/' .$row['car_id']   .'.jpg';

	if (file_exists($old_foto))	{
	
	

	
	//rename ($old_foto, $new_foto);
	
	$file = join ('', file ($old_foto));
	$fp = fopen ($new_foto , 'w');
 	fwrite ($fp, $file);
	fclose ($fp);
	
	
	 }


}

//////////////////////////////////
/*
$oldfilename = 'ПУТЬ_К_СТАРОМУ_ФАЙЛУ';
$newfilename = 'ПУТЬ_К_НОВОМУ_ФАЙЛУ';

$file = join ('', file ($oldfilename));
$fp = fopen ($newfilename , 'w');
 fwrite ($fp, $file);
fclose ($fp);
unlink ($oldfilename); 
*/

////////////////////////////////////////////

echo 'Файлы скопированы';


?>