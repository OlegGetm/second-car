<?php
include_once('../../functions.php');
$link = to_connect();

$text 		= $_POST['text'];
$text 		= tipografica ($text);
$text 		= clean_data($text);

if($_POST['type'] == 'textPhoto')		{

$letters_image_id 		= (int)$_POST['id'];

$q = "			UPDATE 				letters_images 
					SET
					text					 = '$text'
					WHERE letters_image_id = '$letters_image_id' 
					";
$result = $link->query ($q);

////////////////////////////
} else if($_POST['type'] == 'textVideo')		{

$letters_video_id 		= (int)$_POST['id'];

$q = "			UPDATE 				letters_videos 
					SET
					text					 = '$text'
					WHERE letters_video_id = '$letters_video_id' 
					";
$result = $link->query ($q);
}


///////////////////////////
header('Content-Type: text/xml;');
echo  "[ { status: 'update_text' } ]";

?>