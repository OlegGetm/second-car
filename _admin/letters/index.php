<?php
session_start ();
if  (!isset($_SESSION['login_editor'])) { $url = 'Location: ../login.php';
	header ($url); 		}
	
$_SESSION['editor'] = 'letters';
include_once('../_common/functions.php'); 
$link = to_connect();

$table_name 	= 'letters';
$id_name 		= 'letter_id';
$page 				= (int)$_GET['page'];

/////////////////////////////////////////////////////////////////////////////////////////////////////
$z = $_SESSION['editor'];

$elements["letters"] = array(	"table_name" 			=> "letters",
										  	"table_width"			=> "830",		
                                          	"id_name" 				=> "letter_id",
                                          	"columns"					=>
												array("Заголовок", "Фото", "Тип", "Просм.", "Ком.", ""),	
											"columns_size"			=>
												array("360", "60", "80", "35", "45", "70")	 
											);

 //  тип новости 
$ar_type = array('Новости', 'Story', 'Аналитика','Техника', 'Тест-драйв', 'Путешествия');
/////////////////////////////////////////////////////////////////////////////////////////////////////

$q="	SELECT				 	letter_id 
		FROM 						letters
		";
$result = $link->query($q); 

$total_rows = $result->num_rows;						// общее кол-во заметок
$per_page  =30;													//  заметок на страницу
$num_pages=ceil($total_rows/$per_page);	    // кол-во страниц

if ($_GET['page'])  {
$page = $_GET['page'];  }	else	{
$page = 1;                       }
$start=abs(($page-1)*$per_page);							//  начальный  оператор для LIMIT



	$zapros = 	"SELECT 
						 l.letter_id, l.date, to_print, l.title, l.text,  l.type, image_name, author_id, visits,
						COUNT(comment_id) as coms
					 	
						FROM 							letters as l
					 
					 	LEFT JOIN 				    comments 
						USING 						(letter_id)
					 	
						GROUP BY 				l.letter_id
						
					 	ORDER BY 					date DESC
					 	LIMIT 							$start, $per_page "; 
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
				 if ($row['to_print'] =='0' && $row['type'] != '4') {$style_raw = 'style="background:#eddbdb;"'; }  // если не к печати
  				 ++$color_row;
	  
    echo '
<tr ' .$style_raw .'>
<td style="padding-left:20px;"><a href="edit.php?letter_id=' .$row["letter_id"] .'&page=' .$page .'">'.
$row['title'] .'</a></td>

<td>';
if(!empty($row['image_name'])) {echo '<span style="font-size:48px; line-height:10px; color:#999;"> &#8226;  </span>'; }	
echo '</td>

<td>'.$ar_type[$row[type]].'</td>

<td><div style="width:25px;  background:#bbb; padding:2px; text-align:center; color:#fff; font-size:11px; ">' .$row["visits"] .'</div></td>
<td>';
	if($row['coms']>0)		{
	echo '
<div style="width:25px; height:18px; background: url(../_common/img/td_comments.gif) no-repeat 0 1px; padding:3px 0 0 0px; text-align:center; color:#fff; font-size:10px;">' .$row["coms"] .'</div>';
	}
echo '	
</td>
<td><div onclick="deleteRaw(' .$row["letter_id"] .')" style="height:25px; width:25px; background: url(../_common/img/btn_delete.png) no-repeat; cursor:pointer;"></div></td>
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