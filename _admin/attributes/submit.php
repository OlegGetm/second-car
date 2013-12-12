<?php
session_start ();
if  (!isset($_SESSION['login_editor'])) { $url = 'Location: ../login.php';
	header ($url); 		}
	
include_once('../_common/functions.php');
$link = to_connect();

$car_id = $_GET['car_id'];


$brand 	= $_POST['brand'];
$model 	= $_POST['model'];
$year1 	= $_POST['year1'];
$year2 	= $_POST['year2'];
$segment = $_POST['segment'];

$isset_art 		= $_POST['isset_art'];
$isset_tuv 		= $_POST['isset_tuv'];
$isset_experts = $_POST['isset_experts'];



if (!empty($car_id)) 		  {   									// UPDATE 

	$q = 
	"UPDATE cars 
	SET
	brand = '$brand', 
	model = '$model',
	year1 = '$year1',
	year2 = '$year2',
	segment = '$segment'
	WHERE car_id = $car_id		";


	$result = $link->query($q);
	
	$q = 
	"UPDATE attributes 
	SET
	isset_art = '$isset_art',
	isset_tuv = '$isset_tuv',
	isset_experts = '$isset_experts'
	WHERE car_id = $car_id		";

	$result = $link->query($q);
	
}	 else  	  {        														//////////// INSERT
	
	$q = 
	"INSERT into cars 
	(brand, model, year1, year2, segment)
	VALUES 
	('$brand', '$model', '$year1', '$year2', '$segment')	"; 

	$result = $link->query($q);

	$q = 
	"SELECT  			car_id
	FROM 					cars
	ORDER BY			car_id DESC
	LIMIT 1   ";

	$result = $link->query($q);
	$row = $result->fetch_assoc();
	$last_id =  $row['car_id'];


	$q = 
	"INSERT into attributes 
	(car_id, isset_art,  isset_tuv, isset_experts)
	VALUES 
	('$last_id', '$isset_art', '$isset_tuv', '$isset_experts')"; 

	$result = $link->query($q);

																			// добавить строчку в рейтинг
	$q = 
	"INSERT into stars 
	(car_id)
	VALUES
	('$last_id')     "; 

	$result = $link->query($q);

}


$url = 'Location: index.php?show_table=yes';
header ($url);

?>
        