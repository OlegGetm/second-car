<?php
require_once('../../functions/functions.php'); 

$link = to_connect();


$comment_id = (int)$_POST['comment_id'];


$q = 			"DELETE 
					FROM comments
					WHERE comment_id = '$comment_id'
 					LIMIT 1"; 
$result = $link->query ($q);

header('Content-Type: text/xml;');

echo 'OK';
?>