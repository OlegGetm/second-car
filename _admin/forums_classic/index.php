<?php
session_start ();
if  (!isset($_SESSION['login_editor'])) { $url = 'Location: ../login.php';
	header ($url); 		}
	
$_SESSION['editor'] = 'forum_classic';

include_once('../_common/functions.php'); 
$link = to_connect();

$id_name = 'topic_id';
/////////////////////////////////////////////////////////////////////////////////////////////////////
$z = $_SESSION['editor'];

$elements["forum_classic"] = array(	"table_name" 	=> "forum_topics",
										  			"table_width"			=> "830px",		
                                          			"id_name" 				=> "topic_id",
                                          			"columns"					=>
														array("", "Заголовок", "Ответ.",  "Прочли"),
													"columns_size"			=>
														array("230", "380", "50", "70")		
											);
/////////////////////////////////////////////////////////////////////////////////////////////////////

$per_page  =30;													//  заметок на страницу
$num_pages=5;	    											// кол-во страниц

if ($_GET['page'])  {
$page = $_GET['page'];  }	else	{
$page = 1;                       }
$start=abs(($page-1)*$per_page);						//  начальный  оператор для LIMIT

	$zapros = 	"SELECT *
					 	FROM 					forum_topics
					 
					 	LEFT JOIN 			cars
						USING 				(car_id)			
					 
         			 	ORDER BY 			last_date DESC	
					 	LIMIT 					$start, $per_page ";  

   	$result = $link->query ($zapros);


include_once('../_common/templates/##top.php');  
include_once('../_common/templates/inc.table_top.php'); 


foreach ($elements[$z]['columns'] as $key => $value) {
	if($key !==0)	{
	echo '<td style="width:' .$elements[$z]['columns_size'][$key] .'px;">' .$value .'</td>';
	}	else	{
	echo '<td style="width:' .$elements[$z]['columns_size'][$key] .'px; padding-left:20px;">'  .$value .'</td>';
	}
} 
 echo '</tr>';
 
$color_row = 0;													// пременная для смены цвета строки
  
while ($row = $result->fetch_assoc() )	  {
				if ( is_int($color_row/2) )     {  				// чересстрочный цвет
				 $style_raw = 'style="background:#f6f6f6;"';  }	else 	{  $style_raw = 'style="background:#fff;"'; }
				++$color_row;

 echo '
<tr ' .$style_raw .'>
<td style="padding:0px 20px; height:27px;"><a href=edit.php?topic_id='.$row['topic_id'] .'>'
.$row['brand'] .' ' .$row['model'] .'&nbsp;&nbsp; /' .$row['year1'] .'–' .$row['year2'] .'/</a></td>
<td><a href=edit.php?topic_id='.$row['topic_id'] .'>'.mb_substr($row['title'], 0, 62, 'utf-8') .'</a></td>
<td>'.$row['number_posts'] .'</td>
<td>'.$row['number_readers'] .'</td>
</tr>';
}
echo '
</table>';
?>
<!-- end Таблица   -->

<?php 
include_once('../_common/templates/inc.table_bottom.php');
include_once('../_common/templates/##bottom.php');
?>    