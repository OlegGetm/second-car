<?php

/*
define ("DB_HOST",     	"mysql52.hoster.ru");
define ("DB_NAME",    	"m42311");
define ("DB_PASS",     	"gpFJK2Yk");
define ("DB_BASE",     	"db42311m");

*/

define ("DB_HOST",     	"localhost");
define ("DB_NAME",    	"root");
define ("DB_PASS",     	"" );
define ("DB_BASE",    		"second-car");

//////////////////////////////////////////////////

function to_connect()  {
			$link = new mysqli (DB_HOST, DB_NAME, DB_PASS);
			//$link->query ('SET NAMES cp1251'); 
			$link->query ('SET NAMES utf8'); 
			$link->select_db (DB_BASE);
			return $link;
}
/////////////////////////////////////////////////

function clean_mini($xy)    {
				//$xy = htmlspecialchars ($xy);
				$xy = addslashes ($xy);
				$xy = trim ($xy);
				$xy = mysql_escape_string($xy);
				return $xy;
}


function clean_data($xy)    {
				$xy = htmlspecialchars ($xy);
				$xy = addslashes ($xy);
				$xy = trim ($xy);
				$xy = mysql_escape_string($xy);
				return $xy;
}


function tipografica($data)  {
		$data = trim ($data);
		$data = chop ($data);
		// замена на кавычки-елочки:
		$data = preg_replace("/\"(|(.+?))\"/", "«\\2»",  $data);   
		// убрать случайную еденичную кавычку:
		$data = str_replace("\"", "", $data);
		// замена на длинное тире						 
		$data = preg_replace("/(.+?)\s-\s(.+?)/", "\\1 – \\2",  $data); 	
		return $data;
}



function unload_photo($num_pic, $metka_time, $dir, $newwidth = 460) 		{
		
			$archive_dir = $dir;
			$photo = 'photo_' .$num_pic;
			$filename = $metka_time .'_' .$num_pic .'.jpg';
			
			///echo $filename; exit;
		
			if ($_FILES[$photo]['error']==0) {		
			$types=array("image/pjpeg", "image/jpeg");
			if (in_array($_FILES[$photo]['type'],$types)) {

			$uploadedfile = $_FILES[$photo]['tmp_name']; // временный файл, создаваемый PHP
			$src = imagecreatefromjpeg($uploadedfile);  // Создаем Image которое мы сможем resize
			$size_img = getimagesize($uploadedfile);  
			/// размер фото к стандарту
			
			$photo_ratio = $size_img["0"] / $newwidth;
			$newheight = intval($size_img["1"] / $photo_ratio);
			
			$tmp=imagecreatetruecolor($newwidth,$newheight);
			imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$size_img["0"],$size_img["1"]);
			imagejpeg($tmp, "$archive_dir/$filename",85);
		
			imagedestroy($src);
			imagedestroy($tmp); 
			
			}  else  { echo 'Неверный тип файла'; exit;}
			}  else { echo 'Ошибка при загрузке фото'; exit;}
}

function delete_photo($num_pic, $metka_time, $dir) 		{
			$archive_dir = $dir;
			$filename = $archive_dir .'/' .$metka_time .'_' .$num_pic .'.jpg';
			  	if (file_exists($filename))
			  	unlink ($filename);

}



?>