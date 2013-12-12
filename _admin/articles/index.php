<?php
session_start ();
if  (!isset($_SESSION['login_editor'])) { $url = 'Location: ../login.php'; 	header ($url); 		}
	
$_SESSION['editor'] = 'articles';
include_once('../_common/functions.php'); 
$link = to_connect();

$id_name = 'article_id';

/////////////////////////////////////////////////////////////////////////////////////////////////////
$z = $_SESSION['editor'];
$elements["articles"] =		 array(	"table_name" 			=> "articles",
										  			"table_width"			=> "830px",		
                                          			"id_name" 				=> "article_id",
                                          			"columns"					=>
														array("Модель", "Годы", " ",  "Просм.", " "),
													"columns_size"			=>
														array("300", "190", "90", "90", "90")		
											);
/////////////////////////////////////////////////////////////////////////////////////////////////////

$q="		SELECT article_id 
			FROM articles 
			";

$result = $link->query($q); 

$total_rows = $result->num_rows;						// общее кол-во заметок
$per_page  =20;													//  заметок на страницу
$num_pages=ceil($total_rows/$per_page);	    // кол-во страниц

if ($_GET['page'])  {
$page = $_GET['page'];  }	else	{
$page = 1;                       }
$start=abs(($page-1)*$per_page);							//  начальный  оператор для LIMIT



if($_REQUEST['select_brand'])    { 
	$brand = $_REQUEST['select_brand'];
	
	$zapros = 	"SELECT * 
					 	FROM 							articles
					 	LEFT JOIN 					cars 
						USING 						(car_id)
					 	WHERE  brand = '$brand'
					 	ORDER by model, year1   "; 

} 	else	if ($_GET['show'] == 'by_brand') 		{
	$zapros = 	"SELECT * 
					 	FROM 							articles
					 	LEFT JOIN 					cars 
						USING 						(car_id)
					 	ORDER by brand, model, year1 
					 	LIMIT $start, $per_page   "; 

}	else		{
	$zapros = 	"SELECT * 
					 	FROM 							articles
					 	LEFT JOIN 					cars 
						USING 						(car_id)
					 	ORDER by date desc
					 	LIMIT $start, $per_page "; 
}   	
	
$result = $link->query ($zapros);


$add_head = '
<script language="Javascript" type="text/javascript">
function deleteRaw(idNumber, nameModel)  {
var confirmText = "Вы хотите удалить материал  о " + nameModel + "?";
		if (confirm(confirmText)) {
			window.location="edit.php?status=delete&id=" +idNumber
		} else {  window.location="index.php"
}	}	
</script>
';

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
				 if ($row["publication"] =='no') {$style_raw = 'style="background:#eddbdb;"'; }  // если не к печати
  				 ++$color_row;
	  
$xyz = $row['brand'] .'&nbsp;' .$row['model'];

    echo '
<tr ' .$style_raw .'>
<td style="padding:0px 20px;"><a href="edit.php?' .$id_name. '=' .$row[$id_name] .'"> '.$row['brand']." ".$row['model'] .'</a></td>
<td>'.$row['year1'] .'–' .$row['year2'] .'</td>
<td><span style="cursor:pointer;" onclick="location.href=\'edit_online.php?' .$id_name. '=' .$row[$id_name] .'\'">on-line</span></td>
<td>' . $row['counter'] .'</td>
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