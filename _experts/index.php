<?php
session_start ();
if  (!isset($_SESSION['login'])) { $url = 'Location: ./login.php';
	header ($url); 		}

include_once('../_admin/_common/functions.php');
include_once('_common/#top.php');
?>

<!-- Подтверждение удаления статьи   -->
<script language="Javascript" type="text/javascript">
function deleteRaw(message)   {
if (confirm("Вы уверены, что хотите удалить эту статью?")) {
			window.location="edit.php?delete=yes&id=" +message
		}  else {
			window.location="index.php"
} }	
</script>

<div id="fullContent">

 <!-- Кнопка_новая статья  -->
<div style="display:block; margin:20px 0 0 780px;"><a href=edit.php?status=insert><img src="_common/img/btn_new.png"></a></div>

<!-- Блок выбора -->
<div style="display:block; margin:0px 0px 0px 70px;">

<?php
if ($_GET['show_lastest']=='yes') 	{
$show_button = 'Сортировать по маркам';
$show_url = '<a href=index.php>';
}	else	{
$show_button = 'Сортировать по дате';
$show_url = '<a href=index.php?show_lastest=yes>';
}

$link = to_connect();
$login = $_SESSION['login'];

	if ($_GET['show_lastest'] == 'yes')  	{
	$zapros = "SELECT * 
  					FROM experts
					WHERE  login = '$login'
					ORDER by date desc"; 	
	}   else  	{
  $zapros = "SELECT * 
  					FROM experts
					WHERE  login = '$login'
					ORDER by brand, model "; 
	}

   	$result = $link->query ($zapros); 
	$num_results = $result->num_rows;

	if ($num_results > 0)	{
    echo $show_url .'<span class="sort">' .$show_button .'</span></a>';
	}

echo '
</div>';
	
	if ($num_results > 0)	{
	echo '
<table width="800" border="0" cellspacing="0" cellpadding="0"  class="table_sell" style="margin:20px 0 0 70px;"><tr class="tr_1" style="background-color:#d7d7d7;">

	<td style="width:230px;">Модель</td>
	<td style="width:190px;">Годы выпуска</td>
	<td style="width:190px;">Автор</td>
	<td style="width:40px;"></td>
	</tr>
	<tr style="background:#f6f6f6;"><td style="height:20px;"></td><td></td><td></td><td></td></tr>
	';
  
  for ($i=0; $i <$num_results; $i++)
  {
				if ( is_int($i/2) )       // чересстрочный цвет
				{ $style_raw = 'style="background:#f6f6f6;"';  }
				else
				{ $style_raw = 'style="background:#fff;"'; }
  
     $row = $result->fetch_assoc();

$name = $row['name'];
$name =  explode (" ", $name);
$name = $name[1];

    echo '
<tr ' .$style_raw .'>
<td class="tt" style="padding:4px 10px;">
<a href="edit.php?id=' .$row['id'] .'"> '.
$row['brand']." ".$row['model'] .'
</a></td>
<td class="tt">'.$row['year_begin']." – ".$row['year_end'].'</span></td>
<td class="tt">'.$name.'</span></td>';

	echo '<td><input type="button" style="color:#000;" onclick="deleteRaw(';
	echo $row['id'];
	echo ')" value="Удалить&nbsp;" /></td>';

	echo '</tr>';
  }
	echo '</table>';
}
?>
<div style="display:block; height:360px; width:10px;"></div><!-- вниз  --> 
<!-- end fullContent  --->
</div>

<?php include_once('_common/#bottom.php'); ?>       
