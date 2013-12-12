<?php
require_once('_include/functions/functions.php');
require_once('_include/templates/##top.php');  
require_once('_include/templates/##left.php');

$link = to_connect();

$_SESSION['right_menu'] = 'tuv';

$car_id = (int)$_GET['car'];

$zapros = 	"SELECT *
 				  	FROM 							cars
 				  	WHERE car_id = 		'$car_id' 	";

$result = $link->query ($zapros); 
$row = $result->fetch_assoc();
$model = $row['model'];
?>

<script type="text/javascript">
$(function()  {

			$(".link2").click( function() {
			$(".link2").slideToggle();
			$("#tuv_info").slideToggle();
			})
			
			
for	(var i=0; i<5; i++)	  {
var m = '<?php echo $model; ?>' + '_' + i;
var metka = document.getElementById(m);
		if ($('#' +m).length > 0)	{
		$('#' +m).parent('tr').css('background-color', '#f7e2b5');
		metka.scrollIntoView();
		}
}

var content = document.getElementById('page');
content.scrollIntoView();


});	   
</script>

<?php
$array[0] = array('3', '2–3');
$array[1] = array('5', '4–5');
$array[2] = array('7', '6–7');
$array[3] = array('9', '8–9');
$array[4] = array('11', '10–11');
?>

<!--  FULL column ..................................................... -->
<div id="allContent" style="background:#fff;">
<a name="top"></a>

<?php  
////////////////////////////////////////////
$this_title = 'Рейтинг надежности';
require_once('_include/templates/#dossier.php');
///////////////////////////////////////////
?>

<div class="article" style="margin:20px 0 0 40px;">

<div class="link2" style="width:140px; height:30px;  margin:40px 0px 30px 0px; background:url(_include/pics/vopros3.png) no-repeat; padding:4px 0 0 36px;"><a href ="#"><span style="text-decoration:underline; font-size:16px;">Что такое TÜV</span></a></div>

<div id="tuv_info"  style="display:none; padding:40px 200px 40px 0px; text-indent:30px; line-height:18px;">
<p>
Данные самого последнего <span style="font-weight:bold;">TÜV Report-2010</span>! Немецкая организация технического контроля TÜV проводит техосмотры автомобилей в ФРГ. Вся информация о выявленных неисправностях по-германски педантично собирается, ранжируется. И на ее основе каждый год публикуют сводные рейтинги надежности, так называемые TÜV Report. Принцип их составления довольно прост – чем больший процент машин определенной модели «завернули» инспекторы во время техосмотра, тем ниже машина в списке TÜV Report. Всего таких списков пять, в зависимости от года выпуска автомобилей.
</p>
<p>
Слева в таблице – место, занятое автомобилем (понятно, что чем ближе к пьедесталу, тем лучше). В правой графе указан процент автомобилей, не сумевших пройти техосмотр с первого раза. Конечно, целиком полагаться  на немецкую статистику не стоит. Хотя бы потому, что она не учитывает многих популярных в России иномарок.
</p>
<div class="link2" style="padding:20px 0 0 0; text-indent:0px;"><a href ="#"><span style="text-decoration:underline;">Скрыть справку</span></a></div>
</div>

<!--  начало Рейтинг трехлеток   -->
<?php
for	($k=0; $k<5; $k++)	  {

$age = $array[$k][0];

$zapros = "SELECT *
					FROM 							tuv
					WHERE 	model 	= 		'$model' 				
					AND			age		=		'$age'
					";

$result = $link->query ($zapros);					
$num = $result->num_rows;

 
if 	($num>0)		{	
		if 	($k==0)  {$padding = "20"; } else  {$padding = "50"; } ;
?>

<div  style="padding:<?php echo $padding; ?>px 0 10px 0px; color:#858585; font-size:16px; font-weight:bold;">Рейтинг надежности машин в возрасте <?php echo $array[$k][1]; ?> лет:</div>
 

<div style="display:block; width:630px; overflow:hidden; background-color:#ccc; color:#fff; font-weight:bold;">
<div style="display:block; width:70px;  float:left; padding:4px 2px;">Место</div>
<div style="display:block; width:210px; float:left; padding:4px 0;">Модель</div>
<div style="display:block; width:140px; float:left; padding:4px 0;">Процент отсева</div>
<div style="display:block; width:180px; float:left; padding:4px 0;">Средний пробег, т. км</div>
</div><div style="clear:both;">

<div style="display:block; width:630px; height:10px; background-color:#efefef;"></div>

<div style="display:block; height:140px; width:630px; overflow: auto; background-color:#efefef; ">
<table cellspacing="0" cellpadding="0" bgcolor="#efefef">
<tr>
<td style="width:10px;">&nbsp;</td>
<td style="width:70px;">&nbsp;</td>
<td style="width:250px;">&nbsp;</td>
<td style="width:110px;">&nbsp;</td>
<td style="width:180px;">&nbsp;</td>
</tr>

<?php		
$zapros = 	"SELECT *
					FROM 							tuv
					WHERE 	age		=		'$age'
					ORDER BY 					mesto, model
					";
					
$result = $link->query ($zapros);
$num = $result->num_rows;



for ($i=0; $i<$num; $i++) 	 {
$row = $result->fetch_assoc();
echo  '
<tr>
<td id="' .$row['model'] .'_' .$k .'"></td>
<td>' .$row['mesto'] .'</td>
<td>' .$row['brand'] .' ' .$row['model'] .'</td>
<td>' .$row['otsev'] .'</td>
<td>' .$row['probeg'] .'</td>
</tr>';
			}
echo '
</table></div>
<div style="display:block; width:630px; height:10px; background-color:#efefef;"></div>
</div>';
}
}

echo '
</div></div>';
require_once('_include/templates/##bottom.php'); 
?>