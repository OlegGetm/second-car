<?php
session_start ();
if  (!isset($_SESSION['login_editor'])) { $url = 'Location: ../login.php';
	header ($url); 		}
include_once('../_common/functions.php');

$article_id 	= (int)$_GET['article_id'];
$status 		= $_GET['status'];

$link = to_connect();

if ($status == 'delete')  {   													////  если УДАЛИТЬ  статью:
$zapros  = "DELETE 
 					FROM 							articles 
					WHERE article_id = 	'$article_id' ";
$result = $link->query ($zapros);
header('Location: '.$_SERVER['HTTP_REFERER']);


} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {   //// ОБРАБОТКА формы 

				$to_print = $_POST['to_print'] ;
				$car_id =   (int)$_POST['car_id'];		///////  НАЙТИ CAR_ID !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
				
				$title = tipografica ($_POST['title']);
				$title = clean_mini($title);
				
				$text = tipografica ($_POST['text']);
				$text = clean_mini($text);		


		if ($status == 'insert' )	 	{   							//  ВСТАВИТЬ новую статью 

			$zapros = 
			"INSERT INTO 		articles 
			(date, to_print, car_id, title, text )
			VALUES 
			(NOW(), '$to_print', '$car_id', '$title', '$text'  )"; 
							
		}  	  else   {         												// ОБНОВИТЬ 
		
		$zapros = "UPDATE articles 
							SET
							date_mod = 			NOW(),
							to_print = 				'$to_print',
							title = 						'$title',
							text = 						'$text'
							WHERE article_id = '$article_id'   ";
	  }
	
	 $result = $link->query ($zapros);     	if (!$result)  {echo "Ошибка 49 ";   exit;  }

																		// добавление  строки в таблице attributes
		$zapros = 	"SELECT 				*
 							FROM 						attributes 
							WHERE car_id = 	'$car_id'  ";
		 $result = $link->query ($zapros);
		 $num = $result->num_rows;
 
 			if ($num>0)	 			{   						// если уже есть такая запись
			$zapros = "UPDATE attributes 
							SET
							isset_art = 'yes'
							WHERE car_id = 	'$car_id'  ";
			$result = $link->query ($zapros);  
      		}
	$url = 'Location: index.php';
	header ($url);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

}  else    {     												////////// РЕДАКТИРОВАНИЕ статьи
				
include_once('../_common/templates/##top.php');		


			if ($status !== 'insert' )			{	 	
			
			 $zapros = "SELECT * 
								FROM articles 
								
								LEFT JOIN 					cars 
								USING 						(car_id)
								
								WHERE article_id = '$article_id'  ";
								
								
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
<script type="text/javascript" src="../_common/ajax/cars/cars.js"></script>
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
var url = "article.php?car=<?php echo $row['car_id']; ?>";
var title = "<?php echo $row['title']; ?>";

<?php
$text = $row['text'];
$paragraph =  explode ("\r\n", $text); 
?>
var txt = "<?php echo $paragraph[0] .'\r\n' .$paragraph[1] ; ?>";
var type = "review";
var letterId = "0";
var photo = "<?php echo "_photos/cars/big/" .$row['car_id'] .".jpg"; ?>";
</script>



<div id="fullContent" style="margin:20px 0 0 40px;">
<div id="area_showroom_page" style="display:block; position:absolute; top:-105px; left:60px;"></div>
<!-- BOX 1  -->
<div style=" display:block; width:660px; float:left; background:#f5f5f5; padding:0px 6px 0 8px;">

<form action="<?php echo $_SERVER['SCRIPT_NAME'] .'?article_id=' .$article_id; ?>" method="post"  name="myform"  class="editor">

<?php
if ($status == 'insert' ) 	{  include_once('../_common/templates/select_car.php');	
}  ?>

<div style="padding:34px 0 4px 30px;  color:#727272; font:bold 13px helvetica,sans-serif;">Заголовок:</div>
<input  name="title"  class="editor" style="width:500px; margin:0 0 0 30px;" value="<?php echo $row['title']; ?>">

<textarea name="text" class="editor" style="width:600px; height:560px; margin:10px 20px  0 30px;"><?php echo $row['text']; ?></textarea>

<div style="display:block; width:71px; height:40px; float:left; margin:20px 14px 20px 496px; cursor:pointer; background:url(../_common/img/btn_edit.png);" onclick="sendform();"></div>
  <div style="display:block; width:70px; height:40px; float:left; margin:20px 0 0px 0px; cursor:pointer; background:url(../_common/img/btn_cancel.png);" onclick="javascript:history.back();"></div>
  <div style="clear:both;"></div>

</div><!-- BOX 1  -->	


<!-- BOX 2  -->
<div style="display:block; width:255px; height:401px; overflow:hidden; float:left; margin:0px 0 0px 40px; background:#f5f5f5;">

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

<div style="margin:30px 0 0px 28px;">
	<div style="width:190px; overflow:hidden; color:#ddd; margin:0px 0 20px 0px;">_____________________________</div>
<span class="label" style="margin:0px 8px 0px 0px;">Публиковать</span>
<input type="checkbox" name="to_print" value="1" <?php if($row['to_print'] == '1') echo 'checked'; ?> style="padding:0; border:0;">

<div id="btnShowroom" class="label" style="margin:10px 0px 0px 0px; cursor:pointer;">На витрину</div>
<div id="btnAddMedia" class="label" style="margin:10px 0px 0px 0px; cursor:pointer;"><a href="add_media.php?car_id=<?php echo $row['car_id']; ?>">Фото, видео в текст</a></div>  

</div>
 
 </div><!-- BOX 2  -->

<?php    if ($status !== 'insert' ) 	{  
echo'
<input type="hidden" name="car_id" value="' .$row['car_id'] .'">';
}   ?>

 </form>

 <div style="clear:both;"></div>
</div>

<?php include_once('../_common/templates/##bottom.php');  
}
?>