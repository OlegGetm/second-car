<?php
session_start (); 

$car_id = (int)$_GET['car'];

require_once('_include/functions/functions.php');
require_once('_include/functions/rating.php');

//clean_get();							// защита от SQL-инъекции

$add_head = '<script type="text/javascript">
var idCar = "'  .$car_id .'";
var votes = "'  .$votes .'";
var ip = "'  .$_SERVER['REMOTE_ADDR'] .'"; 
</script>
<script type="text/javascript" src="_include/js/rating/rating.js"></script>
<script type="text/javascript" src="_include/js/mail_message/message.js"></script>
';

require_once('_include/templates/##top.php');  
require_once('_include/templates/##left.php');


$error_flag = '0';	
$ip = $_SERVER['REMOTE_ADDR'];
////////////	  проверить, не голосовал  ли с того 	же IP за последние 3 дня
$zapros =		"SELECT *
					FROM stars_time 
					WHERE car_id = '$car_id' 		AND
					ip = '$ip'									AND
					TO_DAYS(NOW()) - TO_DAYS(date) <= 3 ";
$result = $link->query ($zapros);
$num = $result->num_rows;
if($num>0)  $error_flag = '1';	
?>
<!--  FULL column ............................. -->
<div id="allContent" style="background:#fff;">

<?php 
$_SESSION['right_menu'] = 'rating';
////////////////////////////////////////////
$this_title = 'Народный рейтинг ';
require_once('_include/templates/#dossier.php');
///////////////////////////////////////////
?>

<!--  left -->
<div style="display:block; width:355px;  float:left;  padding:40px 0 0 140px;">
<!--  rate panel  -->
<div id="rate_panel" style="display:block; width:355px; height:447px;  position:relative;  background: url(_include/pics/rate_panel_max.jpg) no-repeat;">

<div id="hidden" style="display:none; width:355px; height:90px; overflow:hidden; position:absolute; top:0px; left:0px; z-index:100;"></div>

<?php
$ar = calculate_stars ($car_id, 25);

$top_shift	= array('0', '152', '222', '292', '362');
for ($k=1; $k<5; $k++) 	 {
echo '
<div id="contour_' .$k .'"  class="contour_big" style="top:' .$top_shift[$k] .'px;">
<div id="stars_' .$k .'"   class="stars_big" style="width:' .$ar['width' .$k] .'px;"></div>
</div>

<div id="rate_' .$k .'" class="digit_1" style="top:' .($top_shift[$k]-3) .'px; left:299px;">';
	if($ar['mark' .$k] >0 && $ar['mark' .$k] <=10) { 
	if($ar['mark' .$k] == '10.00') $ar['mark' .$k] = '10.0';
	echo $ar['mark' .$k]; 
	}   	
echo '
</div>';
}         ?>

<div style="display:block; position:absolute; top:73px; left:121px; color:#adadad; font-weight:bold;">
<?php  if($ar['votes'] >0 ) { echo $ar['votes']; }   	?>
</div>

<div style="display:block; width:68px; height:60px; overflow:hidden; position:absolute; top:25px; left:274px; 	font:bold 22px Tahoma, sans-serif;	color:#5e5e5e; padding:0px;">
<?php  
	if($ar['mark_sum'] >0 && $ar['mark_sum'] <=10) { 
	if($ar['mark_sum'] == '10.00') $ar['mark_sum'] = '10.0';
	echo $ar['mark_sum']; 
	}   	?>
</div>
       
     <!--  your_rate  -->
<?php 
//$model_cook = str_replace(" ", "@", $model);

if(isset($_COOKIE[$car_id]))	{

$ar_cook =  explode ('|', $_COOKIE[$car_id]);
?>

<div id="your_rate" style="display:block; width:149px; height:264px;  position:absolute; top:138px; left:400px;background:url(_include/pics/your_rate_bgr.jpg) no-repeat;">

<?php
$top_shift	= array('10', '80', '150', '220');
for ($k=0; $k<4; $k++) 	 {
echo '
<div  class="digit_1" style="top:' .$top_shift[$k]  .'px; left:11px;">'
.$ar_cook[$k] 
.'</div>';
}    ?>
</div><!-- your_rate  -->
<?php    }    ?> 

</div><!--  rate panel  -->
<div id="btn_area" style="display:block; width:355px; height:50px; margin:20px 0 0 0;"></div>


<!-- закладки -->
<div style="margin:40px 0 0 0px;">
<script src="http://odnaknopka.ru/ok2.js" type="text/javascript"></script>
</div>

<div id="btnMail" style="margin:30px 0 0 0; color:#ababab;">Проголосовал? <span style="text-decoration:underline; cursor:pointer;">Пригласи товарища!</span></div>


<!--  mail area  -->
<div id="addMail" style="clear:both; display:none; width:326px; margin:40px 0 0 0px; padding:15px; background-color: #e5e5e5;">
<form name="myform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<div style="padding:0px 0 3px 0px; font-weight:bold; color:#909090;">E-mail друга:</div>
<input  id="mail_to"  style="width:300px; height:18px;  font:bold 16px Arial, sans-serif; padding:2px; margin-bottom:20px;"  type="text" maxlength="40">

<div style="padding:0px 0 3px 0px; font-weight:bold; color:#909090;">Ваш E-mail:</div>
<input id="mail_from"  style="width:300px; height:18px; font:bold 16px Arial, sans-serif; padding:2px; margin-bottom:20px;"  type="text" maxlength="40">

<div style="padding:0px 0 4px 0px; font-weight:bold; color:#909090;">Текст сообщения &nbsp;<span style="font-weight:normal;">(можно изменить)</span></div>
<textarea  id="message_text" style="width:300px; height:90px; overflow-y:auto; font:12px Arial, sans-serif; padding:6px 2px 4px 8px;" >
Хочешь проголосовать за <?php echo $_SESSION['menu']['brand'] .' ' .$_SESSION['menu']['model']; ?> в "Народном рейтинге"? Вот ссылка на страницу голосования:
<?php echo 'http://www.second-car.ru/rating.php?model=' .$_SESSION['menu']['model'] .'&year_begin=' .$_SESSION['menu']['year_begin'] ;?>
</textarea>
<br>
<input  type="button"  onclick="sendMail();" style="margin-top:20px; padding:0 6px; font-weight:bold; cursor:pointer;" value="OK"/>
<input  type="button"  onclick="hideForm();" style="margin-left:20px; padding:0 4px; cursor:pointer;" value="Отмена"/>
<input type="hidden" id="hidden_url" 			value="<?php echo $_SERVER['SERVER_NAME'] .$_SERVER['PHP_SELF'] .'?' .$_SERVER['QUERY_STRING']; ?>">
</form>
</div><!--  mail area  -->



</div><!--  left -->

<!--  right  -->
<div style="display:block; width:200px;  height:200px;  float:left; margin:50px 0 0 100px;">

<?php
if($error_flag == '0' && !isset($_COOKIE[$car_id]))		{
echo '
<div id="btnRate" style="display:block; width:100px; height:44px;
				  background: url(_include/pics/rate_btn_vote.jpg) no-repeat; cursor:pointer;
				  margin: 0 0 0 0;">
</div>';
}
?>

</div><!--  right  -->




</div>
<?php
require_once('_include/templates/##bottom.php'); 

?>