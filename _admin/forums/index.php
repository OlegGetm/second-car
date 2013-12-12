<?php
session_start ();
if  (!isset($_SESSION['login_editor'])) { $url = 'Location: ../login.php';
	header ($url); 		}
	
$_SESSION['editor'] = 'forum';

include_once('../_common/functions.php'); 
$link = to_connect();


$id_name = 'portrait_id';
/////////////////////////////////////////////////////////////////////////////////////////////////////
$z = $_SESSION['editor'];

$elements["forum"] =		 array(	"table_name" 			=> "portrait",
										  			"table_width"			=> "830px",		
                                          			"id_name" 				=> "portrait_id",
                                          			"columns"					=>
														array("", "Годы", ""),
													"columns_size"			=>
														array("210", "170", "330")		
											);
/////////////////////////////////////////////////////////////////////////////////////////////////////

$per_page  =80;													//  заметок на страницу
$num_pages=8;	    											// кол-во страниц

if ($_GET['page'])  {
$page = $_GET['page'];  }	else	{
$page = 1;                       }
$start=abs(($page-1)*$per_page);						//  начальный  оператор для LIMIT

  		
	$zapros = "SELECT  car_id, portrait_id, name,   brand, model, year1, year2
						FROM 								portrait 
						
						LEFT JOIN 						cars
					 	USING								(car_id)
						
         				ORDER BY 						date DESC	 
						LIMIT 								$start, $per_page "; 

   	$result = $link->query ($zapros);



include_once('../_common/templates/##top.php');  
include_once('../_common/templates/inc.table_top.php'); 

foreach ($elements[$z]['columns'] as $key => $value) {
	echo '<td style="width:' .$elements[$z]['columns_size'][$key] .'px;">' .$value .'</td>';
} 
 echo '</tr>';
 
$povtor = 1;
  $color = 1;
  $prev_brand = 'no';

  while ($row = $result->fetch_assoc())	  {

	if( $row['model'] == $prev_model && $row['year1'] == $prev_yearbegin )		{
	
	 ++$povtor;
	 
	 $prev_name 		= $row['name'];
	 
	 $prev_brand 		= $row['brand'];
	 $prev_model 		= $row['model'];
	 $prev_yearbegin = $row['year1'];
	 $prev_yearend 	= $row['year2'];
	 $prev_id 				= $row['portrait_id'];
	 $prev_car_id 		= $row['car_id'];
		
	 continue;
	 
	 }		else 		{
		 		if ( is_int($color/2) )       // чересстрочный цвет
				{ $style_raw = 'style="background:#f6f6f6;"';  }  else { $style_raw = 'style="background:#fff;"';  }
	 
if($prev_brand !== 'no')	{	   
echo '
<tr ' .$style_raw .'>
<td style="padding:0px 20px; height:27px;"><a href="edit.php?portrait_id='.$prev_id .'&car_id=' .$prev_car_id .'">'.$prev_brand.' '.$prev_model;
 		if($povtor>1) { echo '&nbsp;&nbsp; (' .$povtor .')';  }
echo '</a></td>
<td>'.$prev_yearbegin .'–' .$prev_yearend .'</td>
<td>'.$prev_name .'</td>
</tr>';
}
 	 $prev_name 		= $row['name'];
	 $prev_brand 		= $row['brand'] ;
	 $prev_model 		= $row['model'];
	 $prev_yearbegin = $row['year1'];
 	 $prev_yearend 	= $row['year2'];
	 $prev_id			 	= $row['portrait_id'];
 	 $prev_car_id 		= $row['car_id'];
		
		$povtor =1;
		++$color;
		}
  }
echo '
</table>';
?>
<!-- end Таблица   -->

<?php
include_once('../_common/templates/inc.table_bottom.php'); 
include_once('../_common/templates/##bottom.php'); 
?>    
