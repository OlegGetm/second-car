<?php
session_start ();
if  (!isset($_SESSION['login_editor'])) { $url = 'Location: ../login.php';
	header ($url); 		}
include_once('../_common/functions.php');

$opinion_id = (int)$_GET['opinion_id'];

$link = to_connect(); 

			if ($_GET['status'] == 'delete')  							{     		////   УДАЛЯЕМ статью:
			$zapros  = "DELETE 
								FROM opinions 
								WHERE opinion_id = '$opinion_id' ";
			$result = $link->query ($zapros);
			
			$url = 'Location: index.php';
			header ($url);
			
			}  else if ($_SERVER['REQUEST_METHOD'] == 'POST')  	{   ////  РЕДАКТИРОВАНИЕ статьи

			$text = $_POST['text'];
			$text = tipografica ($text);
			$text = clean_data($text);
							
			$minus = 	$_POST['minus'];
			$minus = tipografica ($minus);
			$minus = clean_data($minus);		
			
			$zapros = "UPDATE opinions SET
							text = '$text',
							minus = '$minus'
							WHERE opinion_id = $opinion_id";
			$result = $link->query ($zapros);

			$url = 'Location: index.php';
			header ($url);

}	else    																		{   ////   ВЫВОД 

   		$zapros = 	"SELECT * 
							FROM 				opinions
							  
							LEFT JOIN 		cars 
							USING 			(car_id)
							 WHERE opinion_id = '$opinion_id' ";
            $result = $link->query ($zapros);
			$row = $result->fetch_assoc();

include_once('../_common/templates/##top.php');
?>
<script type="text/javascript" src="../_common/ajax/showroom/showroom.js"></script>
<script type="text/javascript" src="../_common/ajax/showroom_topic/showroom_topic.js"></script>
<script type="text/javascript" src="../_common/ajax/showroom_right/showroom_right.js"></script>
<script type="text/javascript">
var url = "opinion_view.php?opinion=<?php echo $opinion_id; ?>";
var title = "<?php echo $row['brand'] .' ' .$row['model']; ?> – мнение владельца";
var letterId = "0";
var photo = "<?php echo "_photos/cars/big/" .$row['car_id'] .".jpg"; ?>";

<?php
$text = $row['text']; $paragraph =  explode ("\r\n", $text); 
?>
var txt = "<?php echo $paragraph[0] .'\r\n'.$paragraph[1] ; ?>";
var type = "Отзыв";



function sendform () {
		document.myform.submit();
}
</script>


<div id="fullContent" style="margin:20px 0 0 40px;">
<div id="area_showroom_page" style="display:block; position:absolute; top:-105px; left:60px;"></div>

<!-- BOX 1  -->
<?php
$table_width =680;
include_once('../_common/templates/inc.table_top_white.php');  ?>

<div  style="margin:0px 6px 0 8px;  background:#fff;">

<form action="<?php echo $_SERVER['SCRIPT_NAME'] .'?opinion_id=' .$opinion_id; ?>" method="post"  name="myform"  class="editor">

<div style="padding:34px 0 0px 30px;  color:#727272; font:bold 13px helvetica,sans-serif;"><?php echo $row['name']; ?></div>

<div style="padding:14px 0 0px 30px;  color:#727272; font:bold 13px helvetica,sans-serif;">Текст:</div>
<textarea name="text" class="editor" style="width:600px; height:280px; margin:4px 20px  0 30px;"><?php echo $row['text']; ?></textarea>

<div style="padding:34px 0 0px 30px;  color:#727272; font:bold 13px helvetica,sans-serif;">Недостатки:</div>
<textarea name="minus" class="editor" style="width:600px; height:130px; margin:4px 20px  0 30px;"><?php echo $row['minus']; ?></textarea>

<div style="display:block; width:71px; height:40px; float:left; margin:20px 14px 20px 496px; cursor:pointer; background:url(../_common/img/btn_edit.png);" onclick="sendform();"></div>
  <div style="display:block; width:70px; height:40px; float:left; margin:20px 0 0px 0px; cursor:pointer; background:url(../_common/img/btn_cancel.png);" onclick="javascript:history.back();"></div>
  <div style="clear:both;"></div>

</div>	
<?php include_once('../_common/templates/inc.table_bottom_white.php'); ?> <!-- BOX 1  -->

<!-- BOX 2  -->
<div style="display:block; width:255px; height:342px; overflow:hidden; float:left; margin:0px 0 0px 10px; background:url(../_common/img/box_2.png) no-repeat;">

<?php
echo '
<div style="padding:30px 0 4px 30px;  color:#727272; font:bold 13px helvetica,sans-serif;">';
echo $row['brand'] .' ' .$row['model'] .'&nbsp;&nbsp; /' .$row['year1'] .' - ' .$row['year2'] .'/';
echo '</div>';

$img = '../../_photos/cars/micro/' .$row['car_id'] .'.jpg'; 
if (file_exists($img))   	{  	echo '
<img  style="margin:10px 0 0 24px; padding:4px; border:1px solid #ddd;" src ="' .$img .'" width="146"  height="110">';
}   ?>

<div id="btnShowroom" style="margin:10px 0px 0px 26px; cursor:pointer; color:#727272; font:bold 13px helvetica,sans-serif; ">На витрину</div>
 </div><!-- BOX 2  -->


<!-- BOX 3  
<div style="display:block; width:255px; height:350px; overflow:hidden; float:left; margin:0px 0 0px 10px; background:url(../_common/img/box_2.png) no-repeat;">
<div style="padding:30px 0 4px 30px;  color:#727272; font:bold 13px helvetica,sans-serif;">
 </div> 
   -->

 </form>

 <div style="clear:both;"></div>
</div>

<?php include_once('../_common/templates/##bottom.php');  
}
?>