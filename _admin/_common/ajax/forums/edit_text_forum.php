<?php
include_once('../../functions.php');
$link = to_connect();

$portrait_id = $_POST['portrait_id'];	

$new_text = $_POST['tt'];
$new_text = iconv("UTF-8", "CP1251", $new_text);
$new_text = tipografica ($new_text);
$new_text = clean_data($new_text);

 
	$zapros = 	"UPDATE 	portrait 
						SET
						text = '$new_text'
						WHERE portrait_id = '$portrait_id' ";
			
			
	$result = $link->query ($zapros);
	
header('Content-Type: text/xml');
echo    '<?xml version="1.0"  ?>';
echo '<response>';
echo '<text>' .$new_text  .'</text>';
echo '</response> ';	
			
	 
 ?>