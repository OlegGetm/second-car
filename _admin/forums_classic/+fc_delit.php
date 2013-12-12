<?php
include_once('../_common/functions.php');

$link = to_connect();

$post_id 		= (int)$_POST['post_id'];
$topic_id	 	= (int)$_POST['topic_id'];
$type 			= 		  $_POST['type'];


if($type == 'delete_topic')	{			//////////////////////////////////////////////////////
	
	
		$zapros  = "	DELETE 
 							FROM 			forum_posts 
							WHERE 		topic_id = '$topic_id' 
							";
		$result = $link->query ($zapros);
	

		$zapros  = "	DELETE 
 							FROM 			forum_topics 
							WHERE 		topic_id = '$topic_id' 
							";
		$result = $link->query ($zapros);
	
	
	$str = "[ { status: 'OK' } ]";

}	else	{											//////////////////////////////////////////////////////


	$zapros  = "	DELETE 
 						FROM 			forum_posts 
						WHERE 		post_id = '$post_id' 
						";
	$result = $link->query ($zapros);
	
	$str = "[ { post_id: '$post_id' } ]";	
}

if($result)	{
header('Content-Type: text/xml;');
echo $str;
}
	
?>
