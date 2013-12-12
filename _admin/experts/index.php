<?php
session_start ();
if  (!isset($_SESSION['login_editor'])) { $url = 'Location: ../login.php';
	header ($url); 		}
	
$_SESSION['editor'] = 'experts';
include_once('../_common/functions.php'); 
$link = to_connect();

$table_name = 'expert_letters';
$id_name = 'expert_letter_id';

/////////////////////////////////////////////////////////////////////////////////////////////////////
$z = $_SESSION['editor'];

$elements["experts"] =		 array(	"table_name" 			=> "expert_letters",
										  			"table_width"			=> "830px",		
                                          			"id_name" 				=> "expert_letter_id",
                                          			"columns"					=>
														array(" ", "Годы", "Эксперт",  " "),
													"columns_size"			=>
														array("310", "150", "250", "90")		
											);
$table_width = $elements[$z]['table_width'];
/////////////////////////////////////////////////////////////////////////////////////////////////////

	$zapros = "SELECT * 
						FROM 							$table_name
				 		
						LEFT JOIN 					cars 
						USING 						(car_id) 
						
				 		LEFT JOIN 					experts 
						USING 						(expert_id)
						
					 	ORDER by 					date DESC				"; 
   	$result = $link->query ($zapros);
///////////////////////////////////////////////////////////////////////////////////////////////////

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
	echo '<td style="width:' .$elements[$z]['columns_size'][$key] .'px;">' .$value .'</td>';
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
<td>' . $row['name'] .'</td>
<td><div onclick="deleteRaw(\'' .$row[$id_name] .'\', \'' .$xyz .'\')" style="height:25px; width:25px; background: url(../_common/img/btn_delete.png) no-repeat; cursor:pointer;"></div></td>
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
