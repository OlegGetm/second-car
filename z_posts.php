<?php
require_once('_include/functions/functions.php');
$link = to_connect();



$zapros = "SELECT topic_id
 				  FROM 	forum_posts_older 
				  ORDER by date";
$result = $link->query ($zapros); 

/////////////////////////////////////

while ($row = $result->fetch_assoc() )		{

$topic_id = $row['topic_id'];
		
		$q = "SELECT 		post_id
 				  FROM 			forum_posts_older 
 				  WHERE 		topic_id = '$topic_id'
				  ORDER 		by date 
				  LIMIT				1
				  ";
				  
		$res = $link->query ($q); 
		$r = $res->fetch_assoc();
		$post_id = $r['post_id'];

		$q2 = "UPDATE   forum_posts 
						SET
						level  = '0'
						WHERE post_id  = '$post_id' 
						";
						$r2 = $link->query ($q2);

}


echo 'OK';
?>