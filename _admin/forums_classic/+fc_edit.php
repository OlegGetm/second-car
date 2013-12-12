<?php
include_once('../_common/functions.php');
$link = to_connect();

$post_id = $_POST['post_id'];

$message = $_POST['message'];
$message = str_replace("<br>", "\r\n", $message);  

	$zapros = "UPDATE forum_posts SET
			message = '$message'
			WHERE post_id = '$post_id' ";
			
			
	$result = $link->query ($zapros);
	
	if($result)	{
	
$message = str_replace("\r", "", $message);  
$message = str_replace("\n", "\\n", $message);

	header('Content-Type: text/xml;');

$str = "{'forum': [
{ post_id: '$post_id', message: '$message' }
] }";
	
echo $str;

}
	
?>
