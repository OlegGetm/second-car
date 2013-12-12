<?php
include_once('../../functions.php');
$link = to_connect();

$letter_id 			= $_POST['letter_id'];
$par 				= $_POST['parag'];
$date_prefix		= $_POST['date_prefix'];

$text = $_POST['text'];
$text = tipografica ($text);
$text = clean_data($text);

$url = 'Location: ../../../letters/add_media.php?letter_id=' .$letter_id .'#' .$par;

////////////////////////////////
if(($_FILES['my_photo']['size']) == 0)	{                       				// нет фото - тут же выход
	header ($url);
}
////////////////////////////////


	include ('../../classes/class.Add_Image.php'); 		
		
	$file_up = $_FILES['my_photo']; 											// загружаемый файл
		
	$ImageUp = new Add_Image($file_up);								// создать  объект
				
		if($ImageUp->validate_image_type() == 'true' )	{
				
			$ImageUp->set_random_name();								// создать случайное имя
				
				if($ImageUp->original_W >900)	{
									
							$subdir = '../../../../_photos/letters/' .$date_prefix .'/big';
							$ImageUp->create_dir($subdir);
												
							$ImageUp->max_W 					= '900';
							$ImageUp->add_sharpen			= 'yes';  			//  добавить ли резкость
									
							$image_name = $ImageUp->get_newFileName();
							$ImageUp->save_image();
									
							$ar_sizes = $ImageUp->get_newFileSize();
				 }
				
			$subdir = '../../../../_photos/letters/' .$date_prefix;
			$ImageUp->create_dir($subdir);
				
			$ImageUp->max_W 					= '580';
			$ImageUp->add_sharpen			= 'yes';  						
			$image_name = $ImageUp->get_newFileName();
			$ImageUp->save_image();
		}
		

/////////////////////////////////													// если есть фото к этому абзацу - удалить
$zapros = "SELECT * 
 					FROM 						letters_images 
 					WHERE letter_id = '$letter_id'
					AND  parag 			=	'$par'   			";
$result = $link->query ($zapros);

	if( ($result->num_rows)>0)		{
			$zapros  = "DELETE 
								FROM 							letters_images 
								WHERE letter_id 	= '$letter_id'
								AND  parag 				= '$par'  	";
			$result = $link->query ($zapros);
	}

////////////////////////////////
	if (file_exists( '../../../../_photos/letters/' .$date_prefix .'/' .$image_name) && !empty($image_name))	{

		$zapros = "INSERT INTO letters_images 
							(letter_id, parag, name, width, height, text)
							VALUES 
							('$letter_id',  '$par', '$image_name', '$ar_sizes[0]', '$ar_sizes[1]', '$text')
							"; 
		$result = $link->query ($zapros);
	}

header ($url);
?>