<?php
include_once('../../functions.php');
$link = to_connect();

$pos = $_POST['pos'];
$url = $_POST['url'];


if ($_POST['delete'] == 'yes')		{				/////// если удалить блок из showroom

$zapros = "UPDATE showroom SET
				title = '',
				text = '',
				url = '',
				type = '',
				letter_id = ''
				WHERE area = 'lenta' 
				AND      pos = '$pos' ";
$result = $link->query ($zapros);
				
				
}		else			{										///////////// иначе


$title = $_POST['title'];
//$title = iconv("UTF-8", "CP1251", $title);
$title = tipografica ($title);
$title = clean_mini($title);

$text = $_POST['text'];
//$text = iconv("UTF-8", "CP1251", $text);
$text = tipografica ($text);
$text = clean_mini($text);

$letter_id = $_POST['letter_id'];
$photo = $_POST['photo'];
$type = $_POST['type'];
//$type = iconv("UTF-8", "CP1251", $type);

$zapros =   "UPDATE 				showroom 
					SET
					title = 					'$title',
					text = 					'$text',
					url = 					'$url',
					letter_id =			'$letter_id',
					type = 					'$type',
					photo = 				'$photo'
					
					WHERE area 	= 	'lenta' 
					AND      pos = 		'$pos' ";
$result = $link->query ($zapros);

}

header('Content-Type: text/xml;');

if($result)		{
echo "
[ {good: 'yes' }  ]";	
	
}	else	{
echo "
[ {good: 'no' }  ]";	
}
	 
	 
 ?>