<?php
session_start ();
if  (!isset($_SESSION['login_editor'])) { $url = 'Location: ../login.php';
	header ($url); 		}
	
$_SESSION['editor'] = 'replics';

include_once('../_common/functions.php'); 
$link = to_connect();


$id_name = 'replica_id';
/////////////////////////////////////////////////////////////////////////////////////////////////////
$z = $_SESSION['editor'];

$elements["replics"] =		array(	"table_name" 			=> "replics",
										  			"table_width"			=> "830px",		
                                          			"id_name" 				=> "replica_id",
                                          			"columns"					=>
														array(" ", " ", " "),
													"columns_size"			=>
														array("310", "150", "340")		
												);
/////////////////////////////////////////////////////////////////////////////////////////////////////

$q="SELECT 			replica_id 
		FROM 				replics 
		";

$result = $link->query($q); 

$total_rows = $result->num_rows;						// общее кол-во заметок
$per_page  =80;													//  заметок на страницу
$num_pages=ceil($total_rows/$per_page);	    // кол-во страниц

if ($_GET['page'])  {
$page = $_GET['page'];  }	else	{
$page = 1;                       }
$start=abs(($page-1)*$per_page);						//  начальный  оператор для LIMIT


$zapros = 
"SELECT  replica_id, r.date, r.text, r.name, brand, model, year1, year2, article_id, a.title,
COUNT(article_id) as povtors	 
FROM 	replics r

INNER JOIN articles a
USING	(article_id)

INNER JOIN cars
USING (car_id)

GROUP BY article_id,  r.name
ORDER BY r.date DESC	
LIMIT 			$start, $per_page "; 

$result = $link->query ($zapros);


include_once('../_common/templates/##top.php');  
include_once('../_common/templates/inc.table_top.php'); 


foreach ($elements[$z]['columns'] as $key => $value) {
	echo '<td style="width:' .$elements[$z]['columns_size'][$key] .'px;">' .$value .'</td>';
} 
 echo '</tr>';
 
while ($row = $result->fetch_assoc())	  {

		 	if ( is_int($color/2) )       // чересстрочный цвет
			{ $style_raw = 'style="background:#f3f3f3;"';  }  else { $style_raw = 'style="background:#fff;"';  }
	 		++$color;
   
echo '
<tr ' .$style_raw .'>
<td style="padding:0px 20px; height:27px;"><a href=edit.php?article_id='.$row['article_id'] .'&replica_id=' .$row['replica_id'].'>'.$row['brand'].' '.$row['model'];
 		if($row['povtors']>1) { echo '&nbsp;&nbsp; (' .$row['povtors'] .')';  }
echo '</a></td>
<td>'.$row['year1'] .'–' .$row['year2'] .'</td>
<td>'.$row['name'] .'</td>
</tr>';
  }
echo '
</table>';
?>
<!-- end Таблица   -->

<?php include_once('../_common/templates/inc.table_bottom.php'); ?> 

</div><!--  fullContent  -->
<?php include_once('../_common/templates/##bottom.php'); ?>    
