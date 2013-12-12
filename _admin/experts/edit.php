<?php
session_start ();
if  (!isset($_SESSION['login_editor'])) { $url = 'Location: ../login.php';
	header ($url); 		}
include_once('../_common/functions.php');

$expert_letter_id = $_GET['expert_letter_id'];
$status = $_GET['status'];

$link = to_connect();

if ($status == 'delete') 		 {   														 ////  если УДАЛЯЕМ статью:
$zapros  = "DELETE 
 					FROM expert_letters 
					WHERE expert_letter_id = $id ";
$result = $link->query ($zapros);
header('Location: '.$_SERVER['HTTP_REFERER']);

} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {       //// ОБРАБОТКА формы 

if($_POST['print'] == 'yes' ) {
				$publication = 'yes';	}	else	{ 
				$publication = 'no'; }
				
				$brand = $_POST['brand'];
				$model = $_POST['model'];
				$year_begin = $_POST['year_begin'];
				$year_end = $_POST['year_end'];
				$name = $_POST['name'];
				
				$text = tipografica ($_POST['text']);
				$text = clean_mini($text);		

if ($status == 'insert' )	 	{   														//  ВСТАВИТЬ новую статью 

			$zapros = "INSERT INTO expert_articles 
			(date, publication, name, brand, model, year_begin, year_end, text )
			VALUES 
			(NOW(), '$publication', '$name', '$brand',  '$model', '$year_begin', '$year_end', '$text'  )"; 
							
		}  	  else   {         												// ОБНОВИТЬ 
		
		$zapros = "UPDATE expert_letters SET
						date_mod = NOW(),
						to_print = '$to_print',
						text = '$text'
						WHERE id = $id   ";
	  }
	
	 $result = $link->query ($zapros);     	if (!$result)  {echo "Ошибка 49 ";   exit;  }	  
					
					// добавление  строки в таблице attributes
		$zapros = "	SELECT *
 							FROM attributes 
							WHERE car_id = '$car_id'   ";
		 $result = $link->query ($zapros);
		 $num = $result->num_rows;
 
 			if ($num>0)	 			{   						// если уже есть такая запись
			$zapros = "	UPDATE attributes SET
								isset_experts = 'yes'
								WHERE car_id = '$car_id'  ";
			$result = $link->query ($zapros);  	 if (!$result)   {echo "Ошибка 29"; exit; }
      		}
	$url = 'Location: index.php';
	header ($url);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


}  else 				{     											////     ВЫВОД статьи

include_once('../_common/templates/##top.php');		

			if ($status !== 'insert' )			{	 	
			
	$zapros = "SELECT * 
					FROM 									expert_letters
								
					LEFT JOIN 					cars 
					USING 						(car_id)

				 	LEFT JOIN 					experts 
					USING 						(expert_id)
								
					WHERE expert_letter_id = '$expert_letter_id' ";
					
			$result = $link->query ($zapros);  
			$row = $result->fetch_assoc();
		
?>
<script type="text/javascript">
function sendform () {
var txt = document.myform.text.value;
		if(txt.length<10) {
		alert ("Добавьте текст");
		txt.focus();
		return false;
		} else {
		document.myform.submit();
		}
}
</script>
<?php 	}    else  { ?>
<script type="text/javascript" src="../_common/ajax/check_models/validator.js"></script>
<script type="text/javascript">
function sendform () {
var txt = document.myform.text.value;
var year = document.myform.year_begin.options [document.myform.year_begin.selectedIndex].text;
		if(txt.length<10) {
		alert ("Добавьте текст");
		txt.focus();
		return false;
		}
		else if(year =="") {
		alert ("Укажите модельный год");
		document.myform.year_begin.focus();
		return false;
		} else {
		document.myform.submit();
		}
}
</script>
<?php 	}    ?>

<script type="text/javascript" src="../_common/ajax/showroom/showroom.js"></script>
<script type="text/javascript" src="../_common/ajax/showroom_topic/showroom_topic.js"></script>
<script type="text/javascript" src="../_common/ajax/showroom_right/showroom_right.js"></script>
<script type="text/javascript">
var url = "expert.php?car=<?php echo $row['car_id'] .'#' .$row['expert_id'] ; ?>";
var title = "<?php echo $row['model'] .' - мнение эксперта'; ?>";

<?php
$text = $row['text'];
$paragraph =  explode ("\r\n", $text); 
?>
var txt = "<?php echo $paragraph[0] .'\r\n' .$paragraph[1] ; ?>";
var type = "Expert";
var letterId = "0";
var photo = "<?php echo "_photos/cars/big/" .$row['car_id'] .".jpg"; ?>";
</script>

<div id="fullContent" style="margin:20px 0 0 40px;">
<div id="area_showroom_page" style="display:block; position:absolute; top:-105px; left:60px;"></div>

<!-- BOX 1  -->
<?php
$table_width =680;
include_once('../_common/templates/inc.table_top_white.php');  ?>

<div  style="margin:0px 6px 0 8px;  background:#fff;">

<form action="<?php echo $_SERVER['SCRIPT_NAME'] .'?expert_letter_id=' .$expert_letter_id; ?>" method="post"  name="myform"  class="editor">

<?php
if ($status == 'insert' ) 	{  include_once('../_common/_model_ajax.php');	 

$zapros =  "SELECT name
 					FROM expert_pass 
					ORDER BY name";
$res = $link->query ($zapros);
echo '
<select name="name" style="margin:10px 0 0 30px;">
 <option selected >Автор:</option>';
		while($r = $res->fetch_assoc() )		{	echo '<option>' .$r['name'] .'</option>'; 	}	
echo '</select>
<div style="clear:both;"></div>';
 }  else	{ 
 echo '
<div style="padding:34px 0 4px 30px;  color:#727272; font:bold 13px helvetica,sans-serif;">Эксперт: ' .$row['name'] .'</div>';
 } ?>
 
<textarea name="text" class="editor" style="width:600px; height:560px; margin:10px 20px  0 30px;"><?php echo $row['text']; ?></textarea>

<div style="display:block; width:71px; height:40px; float:left; margin:20px 14px 20px 496px; cursor:pointer; background:url(../_common/img/btn_edit.png);" onclick="sendform();"></div>
  <div style="display:block; width:70px; height:40px; float:left; margin:20px 0 0px 0px; cursor:pointer; background:url(../_common/img/btn_cancel.png);" onclick="javascript:history.back();"></div>
  <div style="clear:both;"></div>

</div>	
<?php include_once('../_common/templates/inc.table_bottom_white.php'); ?> <!-- BOX 1  -->

<!-- BOX 2  -->
<div style="display:block; width:255px; height:431px; overflow:hidden; float:left; margin:0px 0 0px 10px; background:url(../_common/img/box_2.png) no-repeat;">

<?php
echo '
<div style="padding:50px 0 4px 30px;  color:#727272; font:bold 13px helvetica,sans-serif;">';

if ($status !== 'insert' )	 {
echo $row['brand'] .' ' .$row['model'] .'&nbsp;&nbsp; /' .$row['year1'] .'–' .$row['year2'] .'/';
}

echo '</div>';

$img = '../../_photos/cars/micro/' .$row['car_id'] .'.jpg'; 
if (file_exists($img))   	{  	echo '
<img  style="margin:10px 0 0 24px; padding:4px; border:1px solid #ddd;" src ="' .$img .'" width="146"  height="110">';
}   ?>

<div><input type="checkbox" name="print" value="1" <?php if($row['to_print'] == '1') echo 'checked'; ?> style="margin:14px 0 0 24px; border:0;" ><span style="color:#727272; font:bold 13px helvetica,sans-serif; margin:0px 0px 0px 10px;">Публиковать </span></div>

<div id="btnShowroom" style="margin:10px 0px 0px 49px; cursor:pointer; color:#727272; font:bold 13px helvetica,sans-serif; ">На витрину</div>
 </div><!-- BOX 2  -->



 </form>

 <div style="clear:both;"></div>
</div>

<?php include_once('../_common/templates/##bottom.php');  
}
?>