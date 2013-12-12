<?php
session_start(); 
require_once('../functions/config.php');
include ('../classes/class.Upload.php'); 
$db = Database::connect();

clean_post();									// защита от SQL-инъекции


if(empty($num)) $num = '1';
$input_name 	= 'file_' .$num;  									// имя input-загрузчика
$file_up 			= $_FILES[$input_name]; 					// загружаемый файл
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$fileUploded = new Uploaded($file_up);						// создать  объект
		
	if($fileUploded->validate_image_type() == 'true' )	{
		
		$subdir = '../upload/' .$_SESSION['user']['login'];  // поддиректорию  для юзера
		$fileUploded->create_dir($subdir);
		$subdir = '../upload/' .$_SESSION['user']['login'] .'/big';
		$fileUploded->create_dir($subdir);
		
		
		$fileUploded->max_W 					= '1210';
		$fileUploded->max_H	 					= '1600';
		$fileUploded->set_random_name();
		
		$fileUploded->save_image();
		
		////  make thumbnail :
				$subdir = '../upload/' .$_SESSION['user']['login'] .'/mini';  // поддиректорию  для мини
				$fileUploded->create_dir($subdir);
								
				$fileUploded->max_W 				= '200';
				$fileUploded->max_H 					= '150';
				$fileUploded->crop_by_height 	= 'no';			//  миниатюры одной высоты
				$fileUploded->add_sharpen		= 'yes';  		//  добавить резкость
				
				$fileUploded->save_image();
	
		
		////////////////////////////////////////////
		$image_name = $fileUploded->get_newFileName();
		

// определить номер позиции (pos) :



$sth = $db->prepare("SELECT MAX(pos) FROM images
								
								WHERE 	main_cat 	= ? 
								AND			sub_cat	= ?
								AND			user_id		= ?  ");

$sth->execute(array($main_cat, $sub_cat, $_SESSION['user']['user_id'] ));

$pos=$sth->fetchColumn();
if(empty($pos))	{ $pos = '0'; }


		
		
		$sth = $db->prepare(
			"INSERT INTO images 
			(user_id, main_cat, sub_cat, date, name,  pos, title, url, showroom ) 
			VALUES 
			(:user_id,  :main_cat, :sub_cat, NOW(), :name, :pos, :title, :url, :showroom )");
			 
		$sth->execute(array( 	':user_id'		 => $_SESSION['user']['user_id'], 
								 			':main_cat'	=> $main_cat,
											':sub_cat' 		=> $sub_cat,
											':name' 		=> $image_name,
											':pos' 			=> $pos+1,
											':title' 			=> $title,
											':url' 				=> $url,
											':showroom' => $showroom
										));
		//////////////////////////////////////////
		
		
		$_SESSION['errors'][$input_name] = 'Файл ' .$fileUploded->get_newFileName() .' успешно загружен';

		}	else	{
		$_SESSION['errors'][$input_name] = 'Это не графический файл. Загрузка остановлена'; 
		}

header('Location: '.$_SERVER['HTTP_REFERER']);

?>