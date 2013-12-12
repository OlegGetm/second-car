<?php
include_once('../../functions.php');
$link = to_connect();

$letters_video_id 		= $_POST['video_id'];

$zapros  = "DELETE 
 					FROM 			letters_videos 
					WHERE 		letters_video_id = '$letters_video_id' 
					LIMIT 1
					";
$result = $link->query ($zapros);

///////////////////////////
header('Content-Type: text/xml;');
echo  "[ { status: 'delete' } ]";

?>