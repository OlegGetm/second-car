<?php
session_start ();
$_SESSION['editor'] = 'tuv';

include_once('../_common/_top.php');
include_once('../_common/functions.php');
?>

<!-- Общий блок кнопок -->
<div style="margin:10px;  padding:10px; width:760px; height:36px; background-color:#F8F1E1; border:dashed; border-color:#CCCCCC; border-width:5px;">

<div style="float:left; padding:3px;">
<!-- Кнопка_новая статья  -->
<a href=edit.php?status=insert><span style="background-color:#A89D8B; font-size:13pt; color:#fff; border-style:outset;">&nbsp; &nbsp;Новая статья&nbsp;&nbsp;</span></a>

<?php
if (!isset ($_GET['show_lastest'])) 
{
$show_button = '&nbsp; &nbsp;Сортировать по бренду&nbsp;&nbsp;';
$show_url = '<a href=index.php?show_lastest=no>';
}
else
{
$show_button = '&nbsp; &nbsp;Показать последние&nbsp;&nbsp;';
$show_url = '<a href=index.php>';
}
?>

<!-- Кнопка_ последние статьи  -->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<? echo $show_url; ?><span style="background-color:#A89D8B; font-size:13pt; color:#fff; border-style:outset; margin-left:0px;"><? echo $show_button; ?></span></a>

</div>

<!-- Кнопка_ выбор по бренду   -->
<div style="float:right; display:inline; margin-top:4px;">
<?php
$link = new_connect();
  
  $zapros = "SELECT *
  					FROM tuv 
					ORDER by brand"; 
  $result = $link->query($zapros);

	echo '<form action="index.php" мethod="post">';
	echo '<select name="select_brand" class="select" onchange="this.form.submit()">'; 
	echo '<option value="" selected>Выберите марку&nbsp;&nbsp;</option>';
	for ($i=0; $i < $result->num_rows; $i++) 
  {
  $row = $result->fetch_assoc();
	if ($row['brand'] == $older_brand)
	{continue;}
	echo '<option>';
	echo $row['brand'];
	echo '</option>';
	$older_brand = $row['brand'];
	}

 echo '</select>';
 echo '</form>';
?>
</div>

<div style="clear:left;"></div>
</div>
 
<!-- Сценарий   Подтверждение удаления статьи   -->
<script language="Javascript" type="text/javascript">
	function deleteRaw(message)
{
 if (confirm("Вы уверены, что хотите удалить статью?")) {
			window.location="edit.php?delete=yes&id_tuv=" +message
		}
		else {
			window.location="index.php"
		}
}	
</script>

<!-- блок смещаем вниз   -->
<div style="width:10px; height:20px; display:block;"></div>


<!-- СУПЕРБЛОК   -->
<?php 
if ($_REQUEST['select_brand'])
	{
	$select_brand = $_REQUEST['select_brand'];
	$zapros = "select * from tuv  where brand = '$select_brand'";
	}
else	if ($_GET['show_lastest'] == 'no') 
	{
	$zapros = "SELECT * 
					 FROM tuv 
					 ORDER by brand"; 
	}
 else
	{
	$zapros = "SELECT * 
					 FROM tuv 
					 ORDER by date desc"; 
	}

	$link = new_connect();
   	$result = $link->query ($zapros);
   if (!$result) 
  {
    echo "Ошибка базы данных во время выполнения запроса";
    exit;
  }
	
	
	$num_results = $result->num_rows;
	echo '<table width="790" border="0" class="editor">';
  
  for ($i=0; $i <$num_results; $i++)
  {
     $row = $result->fetch_assoc();
	echo '<tr>';
	echo '<td><span style="color:#666;">'.$row['brand']." ".$row['model'].'</span></td>';
	echo '<td><span style="color:#666;">'.$row['year_begin'] .'–' .$row['year_end'] .'</span></td>';
	echo '<td><p>'.$row['title'].'</p></td>';
	echo '<td style="background-color:#BCB6AA; width:30px;"><a href=edit.php?id_tuv='.$row['id_tuv'];
	echo '><p style="color:#fff;">Править</p></a></td>';
	echo '<td style="width:50px;"></td>';
	
	echo '<td style="width:60px;"><input type="button" style="color:#ccc;" onclick="deleteRaw(';
	echo $row['id_tuv'];
	echo ')" value="Del&nbsp;" /></td>';

	echo '</tr>';
  }
	echo '</table>';


include_once('../_common/_left_bottom.php');
?>
        
