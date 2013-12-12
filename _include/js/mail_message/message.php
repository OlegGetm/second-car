<?php
require_once('../../functions/functions.php');
$link = to_connect();

//$message 	= iconv("UTF-8", "CP1251", $_POST['message']);	
$message 	= $message .'

-------------------------------------------------------------
Cсылка на страницу голосования:
http://' .$_POST['url'];


$mail_from = $_POST['mail_from'];
$mail_from_edit =  $mail_from = 'From: ' .$mail_from;

$mail_to = $_POST['mail_to'];
$mail_title = 'Не хочешь проголосовать в "Народном рейтинге"?';


	if ( strlen($mail_to)>0 &&  strlen($mail_from)>0  &&  strlen($message)>0)		{
	
	 mail($mail_to, $mail_title, $message, $mail_from_edit);
	
	$message = mysql_escape_string($message);
	$mail_from = mysql_escape_string($mail_from);
	$mail_to = mysql_escape_string($mail_to);
	
	$zapros = "INSERT into mail_messages 
					 (date, mail_to, mail_from, message)
					 VALUES
					 (NOW(), '$mail_to', '$mail_from', '$message') ";
	
	$result = $link->query ($zapros);
	}


if($result)	{ $good	=	"yes";
}	else		{ $good	=	"no";    }

header('Content-Type: text/xml;');

$str = "[";
$str.= "
{good: '$good'} 
]";
	
echo $str;
?>