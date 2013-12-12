<?php
session_start ();
if  (!isset($_SESSION['login_editor'])) { $url = 'Location: ../login.php'; 	header ($url); 		}
	
$_SESSION['editor'] = 'opinions';
include_once('../_common/functions.php'); 
$link = to_connect();

$id_name = 'opinion_id';

/////////////////////////////////////////////////////////////////////////////////////////////////////
$z = $_SESSION['editor'];
$elements["opinions"] =		 array(	"table_name" 			=> "opinions",
										  			"table_width"			=> "830px",		
                                          			"id_name" 				=> "opinion_id",
                                          			"columns"					=>
														array("Модель", "Годы", "Имя",  "Размер", " "),
													"columns_size"			=>
														array("270", "140", "140", "40",  "150")		
											);
/////////////////////////////////////////////////////////////////////////////////////////////////////

$q="SELECT 	opinion_id 
		FROM 		opinions 
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
	
	$zapros = 	"SELECT * 
					 	FROM 							opinions
					 	LEFT JOIN 					cars 
						USING 						(car_id)
					 	WHERE  brand = 		'$brand'
					 	ORDER 						BY model, year1   "; 

} 	else	if ($_GET['show'] == 'by_brand') 		{
	$zapros = 	"SELECT * 
					 	FROM 							opinions
					 	LEFT JOIN 					cars 
						USING 						(car_id)
					 	ORDER BY 					brand, model, year1 
					 	LIMIT 							$start, $per_page   "; 

}	else		{
	$zapros = "SELECT * 
					 	FROM 							opinions
					 	
						LEFT JOIN 					cars 
						USING 						(car_id)
					 	
						ORDER BY 					date DESC
					 	LIMIT 							$start, $per_page "; 
}   	
	
$result = $link->query ($zapros);


if($_GET['show'] == 'by_brand')	{
				$ahref = 'index.php'; 
} else	{	$ahref = 'index.php?show=by_brand'; 	}




include_once('../_common/templates/##top.php');  
include_once('../_common/templates/inc.table_top.php'); 

foreach ($elements[$z]['columns'] as $key => $value) {
	if($key !==0)	{
	echo '<td style="width:' .$elements[$z]['columns_size'][$key] .'px;">' .$value .'</td>';
	}	else	{
	echo '<td style="width:' .$elements[$z]['columns_size'][$key] .'px; padding-left:20px;"><a href="' .$ahref .'">'  .$value .'</a></td>';
	}
} 
 echo '</tr>';
 
$color_row = 0;													// пременная для смены цвета строки
  
while ($row = $result->fetch_assoc() )	  {
				if ( is_int($color_row/2) )     {  				// чересстрочный цвет
				 				$style_raw = 'style="background:#f6f6f6;"';  
				 }	else 	{   $style_raw = 'style="background:#fff;"';  }
				 ++$color_row;
	  
$xyz = $row['brand'] .'&nbsp;' .$row['model'];

    echo '
<tr ' .$style_raw .'>
<td style="padding:0px 20px;"><a href="edit.php?' .$id_name. '=' .$row[$id_name] .'"> '.$row['brand']." ".$row['model'] .'</a></td>
<td>'.$row['year1'] .'–' .$row['year2'] .'</td>
<td>' . $row['name'] .'</td>
<td>' . strlen($row['text']) .'</td>
<td><div onclick="deleteRaw(' .$row[$id_name] ." , '" .$xyz ."'" .')" style="height:25px; width:25px; background: url(../_common/img/btn_delete.png) no-repeat; cursor:pointer;"></div></td>
</tr>';
}
echo '
</table>';
?>
<!-- end Таблица   -->

<?php 
include_once('../_common/templates/inc.table_bottom.php');
include_once('../_common/templates/##bottom.php'); ?>    