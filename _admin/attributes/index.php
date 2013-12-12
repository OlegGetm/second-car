<?php
session_start ();
if  (!isset($_SESSION['login_editor'])) { $url = 'Location: ../login.php';
	header ($url); 		}
	
$_SESSION['editor'] = 'attributes';

include_once('../_common/functions.php'); 
$link = to_connect();


$id_name = 'car_id';
/////////////////////////////////////////////////////////////////////////////////////////////////////
$z = $_SESSION['editor'];

$elements["attributes"] =array(	"table_name" 			=> "cars",
										  			"table_width"			=> "830px",		
                                          			"id_name" 				=> "car_id",
                                          			"columns"					=>
														array("id", "Модель", "Годы", "Обзор |", "Эксперт", "| TUV", " "),
													"columns_size"			=>
														array("80", "200", "120", "50", "50", "80", "100")		
											);
/////////////////////////////////////////////////////////////////////////////////////////////////////


$q= "	SELECT 		car_id 
			FROM 			cars 
		";
$result = $link->query($q); 

$total_rows = $result->num_rows;						// общее кол-во заметок
$per_page  =30;													//  заметок на страницу
$num_pages=ceil($total_rows/$per_page);	    // кол-во страниц

if ($_GET['page'])  {
$page = $_GET['page'];  }	else	{
$page = 1;                       }
$start=abs(($page-1)*$per_page);						//  начальный  оператор для LIMIT


if($_REQUEST['select_brand'])    { 
	$brand = $_REQUEST['select_brand'];
	
	$zapros = "SELECT 				* 
					 FROM 					cars
	
					 WHERE  brand = 	'$brand'
					 ORDER BY 			model, year1   "; 

} 	else	if ($_GET['show'] == 'by_date') 		{

	$zapros = "SELECT 				* 
					 FROM 					cars
	
					 ORDER BY 			date desc
					 LIMIT 						$start, $per_page   "; 

}	else	{

	$zapros = "SELECT 				* 
					 FROM 					cars
		 
					 ORDER BY 			brand, model
					 LIMIT 						$start, $per_page   "; 
}

   	$result = $link->query ($zapros);
	
	
	if($_GET['show'] == 'by_date')		{
					$ahref = 'index.php'; 
	} else	{	$ahref = 'index.php?show=by_date'; 	}
	


include_once('../_common/templates/##top.php');  
include_once('../_common/templates/inc.table_top.php'); 

foreach ($elements[$z]['columns'] as $key => $value) {
	if($key !==0)	{
	echo '<td style="width:' .$elements[$z]['columns_size'][$key] .'px;">' .$value .'</td>';
	}	else	{
	echo '<td style="width:' .$elements[$z]['columns_size'][$key] .'px; padding-left:10px;"><a href="' .$ahref .'">'  .$value .'</a></td>';
	}
} 
 echo '</tr>';
 
$color_row = 0;													// пременная для смены цвета строки
  
while ($row = $result->fetch_assoc() )	  {

				if ( is_int($color_row/2) )     {  				// чересстрочный цвет
				 $style_raw = 'style="background:#f3f3f3;"';  }	else 	{   $style_raw = 'style="background:#fff;"';  }

$img = '../../_photos/cars/big/' .$row['car_id'] .'.jpg'; 
if (!file_exists($img))   	
			{  $style_raw = 'style="background:#eddbdb;"'; }  // если нет фото

 echo '
<tr ' .$style_raw .'>
<td style="padding:0 0 0 10px; height:24px; font-size:12px; color:#999;">'.$row['car_id'] .'</td>
<td style="padding:0 0 0 0px;"><a href=edit.php?car_id='.$row['car_id'] .'&amp;status=update>'.$row['brand'] .' '.$row['model'] .'</a></td>

<td>'.$row['year1'] .' - ' .$row['year2'] .'</td>';
	
	if ($row['isset_art'] == 'yes') {$metka = '<img style="margin-left:10px; margin-top:2px;" src="../_common/img/circle.png">';} else {$metka = '';}
	echo 
'<td style="line-height:1.0em;">' .$metka .'</td>';
	
	if ($row['isset_experts'] == 'yes') {$metka = '<img style="margin-left:10px; margin-top:2px;" src="../_common/img/circle.png">';} else {$metka = '';}
	echo '
<td style="line-height:1.0em;">' .$metka .'</td>';

	if ($row['isset_tuv'] == 'yes') {$metka = '<img style="margin-left:10px; margin-top:2px;" src="../_common/img/circle.png">';} else {$metka = '';}
	echo '
<td style="line-height:1.0em;">' .$metka .'</td>';

	$xyz = $row['brand'] .'&nbsp;' .$row['model'];
echo '
<td><div onclick="deleteRaw(' .$row['car_id'] ." , '" .$xyz ."'" .')" style="height:25px; width:25px; background: url(../_common/img/btn_delete.png) no-repeat; cursor:pointer;"></div></td>
</tr>';
 
 ++$color_row;
 }
echo '
</table>';
?>
<!-- end Таблица   -->

<?php 
include_once('../_common/templates/inc.table_bottom.php');
include_once('../_common/templates/##bottom.php'); 
?>    