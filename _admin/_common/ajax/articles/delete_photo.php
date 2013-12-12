<?php
include_once('../../functions.php');
$link = to_connect();

$letters_image_id 		= $_POST['image_id'];


$zapros = "	SELECT 			name
 					FROM 				letters_images 
					WHERE letters_image_id = '$letters_image_id'
					LIMIT 1
					";
$result = $link->query ($zapros);
$row = $result->fetch_assoc();

$name = $row['name'];

///////////////////////
			$filename = '../../../../_photos/articles/' .$name;
			if (file_exists($filename))
			unlink ($filename);
			
			$filename = '../../../../_photos/articles/big/' .$name;
			if (file_exists($filename))
			unlink ($filename);
///////////////////////

$zapros  = "DELETE 
 					FROM 			letters_images 
					WHERE 		letters_image_id = '$letters_image_id' 
					LIMIT 1
					";
$result = $link->query ($zapros);

///////////////////////////
header('Content-Type: text/xml;');
echo  "[ { status: $filename } ]";

?>