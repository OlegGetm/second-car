<?php
session_start ();
 	// Защищаемся от SQL-инъекции
	function cleaner_data($data)  {
				$data = trim ($data);
				$data = htmlspecialchars($data);
				$data = mysql_escape_string($data);
				return $data;
				}

$input_id 		  = $_POST['input_id'];	
$input_value  = $_POST['input_value'];	

$input_id 		  = cleaner_data($input_id); 
$input_value  = cleaner_data($input_value); 

$error_text = 'OK';

switch($input_id)		{ 
			case 'login': $_SESSION['reg']['login'] = $input_value;
						
						if ( !eregi ("^[a-zA-Z0-9_]+$", $input_value ) )		{
						$error_text = "Допускаются только латинские буквы, цифры и знак подчеркивания";	
						break; 	}
						
						$long = strlen($input_value);
					  	if($long<5 || $long>12) {
 					 	$error_text = "Количество знаков должно быть от 5 до 12";  
						break;  }	
							
						$link = new mysqli ('a20057.mysql.mchost.ru', 'a20057_1', 'stopstop');
						$link->select_db    ('a20057_1');
						$zapros = "SELECT id_author 
										  FROM users 
										  WHERE login = '$input_value' ";
						$result = $link->query ($zapros);
						$num = $result->num_rows;
						if ($num>0) 	{
						$error_text = "Пользователь с таким логином уже есть. Выберите другой";	}
					break;

						
			case 'pass1': $_SESSION['reg']['pass1'] = $input_value;
						
						if ( !eregi ("^[a-zA-Z0-9_]+$", $input_value ) )		{
						$error_text = "Допускаются только латинские буквы, цифры и знак подчеркивания";		
						break; }
						
						$long = strlen($input_value);
					  	if($long<5 || $long>12) {
 					 	$error_text = "Количество знаков должно быть от 5 до 12";  }	
					break;
					
			case 'pass2': $_SESSION['reg']['pass2'] = $input_value;
						if($_SESSION['reg']['pass1'] !== $input_value) {
						$error_text = "Пароли не совпадают";	 }	
					break;
					
			case 'email': $_SESSION['reg']['email'] = $input_value;
						if (!eregi(				"^([0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-wyz][a-z](fo|g|l|m|mes|o|op|pa|ro|seum|t|u|v|z)?)$", $input_value) and $input_value != "")	{
  						$error_text = "Некорректный e-mail адрес!";	}	
					break;
			}

if($input_value == '') $error_text = "Обязательно заполните поле";


header('Content-Type: text/xml');
echo    '<?xml version="1.0" ?>';
echo '<response>';
echo '<input_id>' .$input_id  .'</input_id>';
echo '<error_text>' .$error_text  .'</error_text>';
echo '</response> ';	

?>