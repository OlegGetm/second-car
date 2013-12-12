<?php
$add_head = '<script type="text/javascript" src="_include/js/cars/cars.js"></script>
<script type="text/javascript">

$(document).ready(function() {	
			$(".add_opinion").css("padding", "4px").css("background", "#efefef");
			$("#add_text").text("Добавьте ваш отзыв");
			});
</script>

<style type="text/css">
option { padding-right: 0.5em; padding-left: 0.5em; background-color:#fff; }
select { padding: 0.1em 0 0.1em 0.5em; }
</style>
';

$car_id = (int)$_GET['car'];

require_once('_include/functions/functions.php');
require_once('_include/templates/##top.php');  
require_once('_include/templates/##left.php');

$_SESSION['right_menu'] = 'opinions';
?>

<!--  FULL column ..................................................... -->
<div id="allContent" style="background-color:#fff; padding-bottom:1000px;">

<?php  
////////////////////////////////////////////

$this_title = 'Отзывы владельцев';
require_once('_include/templates/#dossier.php');
///////////////////////////////////////////


$zapros = "SELECT *
 					FROM 							opinions
 					LEFT JOIN 					cars 
					USING 						(car_id)
 				  	WHERE car_id = 		'$car_id' 	
					ORDER BY					date desc ";
 
$result = $link->query ($zapros);
$row = $result->fetch_assoc();
echo '
<div style="width:680px; margin:30px 0 0 50px;">';


require_once('_include/templates/inc.opinion.php');  
echo '
</div>';

mysqli_data_seek($result, 0);
$num_results = $result->num_rows;

echo '
<table width="680px" border="0" cellspacing="0" cellpadding="0" class="table_sell" bgcolor="#f6f6f6" style="margin:30px 0 0 50px; border:1px solid #f1f1f1; color:#5b5b5b;">
<tr style="text-align:left; background-color:#ccc; color:#fff; font-weight:normal;">
<td style="width:200px; padding-left:30px;">Автомобиль</td>
<td style="width:70px;">Выпуска</td>
<td style="width:90px;">Пробег, км</td>
<td style="width:150px;">Автор отзыва</td>
</tr>';
	 echo '
<tr style="background:#fff; height:10px;">
<td></td><td></td><td></td><td></td>
</tr>';
	
	  for ($i=0; $i <$num_results; $i++)	  {
				if ( is_int($i/2) )       						// чересстрочный цвет
				{ 				$style_raw = 'style="background:#fff; height:20px;"';  
				}	else	{ 	$style_raw = 'style="height:20px;"';  }
  
     $row = $result->fetch_assoc();
    echo '<tr ' .$style_raw .'>';
	echo '
<td><a href=opinion_view.php?opinion='.$row['opinion_id'] .'><span style="padding:0 20px 0 10px; color:#5b5b5b; font-size:16px; font-weight:bold;">'.$row['brand']." ".$row['model'].'</span></a></td>
<td  style="font-size:16px; font-weight:normal; color:#636363; padding-left:10px;">'.$row['year'] .'</span></td>
<td  style="font-size:16px; font-weight:normal; color:#636363; padding:0 38px 0 0; text-align:right;">'.$row['run'] .' 000</span></td>
<td  style="font-size:16px; font-weight:bold; color:#000; padding-left:10px;"><a href=opinion_view.php?opinion='.$row['opinion_id'] .'><span style="color:#5b5b5b; font-size:15px; font-style:italic;">'.$row['name'].'</span></a></span></td>
</tr>';
  }
	echo '
</table>';
?>

</div>
<?php  require_once('_include/templates/##bottom.php');  ?>