<?php
function load_photo($brand, $model, $year_begin, $num_parag) 		{
		
			$archive_dir = "../../../../_photos/articles";
			$photo = 'my_photo';
			$filename = $brand .'_' .$model .'_' .$year_begin .'_' .$num_parag .'.jpg';
		
			if ($_FILES[$photo]['error']==0) {		
			$types=array("image/pjpeg", "image/jpeg");
			if (in_array($_FILES[$photo]['type'],$types)) {

			$uploadedfile = $_FILES[$photo]['tmp_name']; // временный файл, создаваемый PHP
			$src = imagecreatefromjpeg($uploadedfile);  // Создаем Image которое мы сможем resize
			$size_img = getimagesize($uploadedfile);  
			/// размер фото к стандарту
			$newwidth = 560;
			$photo_ratio = $size_img["0"] / $newwidth;
			$newheight = intval($size_img["1"] / $photo_ratio);
			
			if ($size_img["0"] == $newwidth) 			{   // если размер фото равен 468px, сразу копируем
			move_uploaded_file($uploadedfile, "$archive_dir/$filename");
			unlink($uploadedfile);
			}   else 			{
			$tmp=imagecreatetruecolor($newwidth,$newheight);
			imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$size_img["0"],$size_img["1"]);
			imagejpeg($tmp, "$archive_dir/$filename",90);
			}
			
			imagedestroy($src);
			imagedestroy($tmp); 

			}  else  { echo 'Неверный тип файла'; exit;}
			}  else { echo 'Ошибка при загрузке фото'; exit;}
}


//////////////////////////////////////////////////////////////////////////////////////////////////////

include_once('../../functions.php');

$article_id = $_GET['article_id'];
$num_parag = $_GET['num_parag'];
$brand = $_GET['brand'];
$brand = str_replace(' ', '', $brand);

$model = $_GET['model'];
$model = str_replace(' ', '', $model);

$year_begin = $_GET['year_begin'];	

$alt_text = $_POST['alt_text'];
$alt_text = tipografica ($alt_text);
$alt_text = clean_data($alt_text);

$text = $_POST['text'];
$text = tipografica ($text);
$text = clean_data($text);

 // добавляем фото

	if( ($_FILES['my_photo']['size']) > 0 )
	{ load_photo($brand, $model, $year_begin, $num_parag);	}


// добавление новой записи
$archive_dir = "../../../../_photos/articles";
$img_name = $brand .'_' .$model .'_' .$year_begin .'_' .$num_parag .'.jpg';
$imgs = "$archive_dir/$img_name";
$size_imgs = getimagesize($imgs);  
$width = $size_imgs["0"];
$height = $size_imgs["1"];


$link = to_connect();

$zapros = "INSERT into articles_photo 
(article_id, num_parag, img_name, width, height, alt_text, text)
VALUES 
('$article_id', '$num_parag', '$img_name', '$width', '$height', '$alt_text', '$text')"; 

$result = $link->query ($zapros);
if (!$result)  {echo "Ошибка 49 ";  exit;  }
	 
?>