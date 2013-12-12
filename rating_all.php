<?php
$add_head = '<script type="text/javascript">

var colorBefore;
$(function()  {
$("tr:even").css("background-color", "#ececec");
$("#c_1").css("background-color", "#f8f8f8");


		$("tr").mouseover( function()  { 
		colorBefore = $(this).css("background-color");
		$(this).css("background-color", "#ffefca");
		});
		$("tr").mouseout( function()  { 
		$(this).css("background-color", colorBefore);
		});
});	   
</script>

<style type="text/css">
td {
	padding:4px 0 4px 0;
	font-size:15px;
}

td span  {
	font-weight:normal; font-size:13px;
}

</style>
';

require_once('_include/functions/functions.php'); 
require_once('_include/templates/##top.php');  
require_once('_include/templates/##left.php');

clean_get();							// защита от SQL-инъекции
if(!$type)  { $type="sum"; }
$type = 'rate_' .$type;

$array_type = array   ( 'rate_sum' => 'общая оценка',
						 			'rate_s1' => 'управляемость',
						 			'rate_s2' => 'комфорт',
						 			'rate_s3' => 'надежность',
						 			'rate_s4' => 'стоимость обслуживания'
						  			);
?>
<!--  FULL column ............................. -->
<div id="allContent" style="padding-bottom:100px; background:#fff url('_include/pics/d_grad_3.jpg') repeat-x top;">

<?php
require_once('_include/templates/inc.topic.php'); 
?>


<?php
 $link = to_connect();
  $zapros = "SELECT *
 					FROM stars
					LEFT JOIN 					cars 
					USING 						(car_id)
					WHERE {$type}>0 AND {$type}<10
					ORDER BY {$type} DESC, brand, model
					";
$result = $link->query ($zapros);
?>

<div style="margin:30px 0 10px 9px; font: italic bold 26px Georgia,serif; color:#333; letter-spacing:-0.03em;">Топ "Народного рейтинга":&nbsp; <?php echo $array_type[$type]; ?>
</div>

<div  id="rating_links" style="display:block; width:800px; margin:0 0 14px 10px;">
<span>[<a href="rating_all.php?type=sum">Общая оценка</a>]</span>
<span>[<a href="rating_all.php?type=s1">Управляемость</a>]</span>
<span>[<a href="rating_all.php?type=s2">Комфорт</a>]</span>
<span>[<a href="rating_all.php?type=s3">Надежность</a>]</span>
<span>[<a href="rating_all.php?type=s4">Стоимость обслуживания</a>]</span>
</div>


	<?php
   for ($i=0; $i<20; $i++) 	 {
   $row = $result->fetch_assoc();
 	$img_name = '_photos/cars/micro/' .$row['car_id'] .'.jpg';
	if (!file_exists($img_name)) 	{ $img_name = '_include/pics/photo_grey.gif'; }
	$ahref = 'rating.php' .'?car=' .$row['car_id'];			
	echo '
<div style="display:block;  width:146px; height:110px; float:left; margin:0px 0px 1px 1px;  background:#ccc; position:relative; z-index:300;">
<a href="' .$ahref .'"><img src="' .$img_name .'"  width="146" height="110" title="' .$row['brand'] .'&nbsp;' .$row['model'] .'&nbsp;' .$row['year1'] .'–' .$row['year2'] .'"></a>
<div class="link3" style="display:block; position:absolute; bottom:0px; right:0px; font:bold 20px Tahoma,sans-serif; color:#fff; background-color:#5e5e5e; filter:alpha(opacity:80); KHTMLOpacity: 0.80; 	MozOpacity: 0.80; opacity: 0.80;"><div style="padding:0 7px 0 7px; z-index:1;">'
	.($i+1) .'</div></div>
</div>';
	}
?>
<div style="clear:both;"></div>

<div style="display:block; width:734px; height:24px; overflow:hidden; margin:10px 0 4px 1px; background-color:#999; color:#f7f7f7; font-weight:bold;">
<div style="display:block; width:80px;  float:left; padding:6px 0px 3px 6px; ">Место</div>
<div style="display:block; width:350px; float:left; padding:6px 0px 3px 0;">Модель</div>
<div style="display:block; width:130px; float:left; padding:6px 2px 3px 0;">Рейтинг</div>
<div style="display:block; width:130px; float:left; padding:6px 2px 3px 0;">Проголосовало</div>
</div>
<div style="clear:both;"></div>

<div style="display:block;  width:734px; height:730px; margin:0 0 90px 1px; overflow:auto; overflow-x:hidden; background-color:#f7f7f7; font-weight:bold; ">
<table id="table_rate" cellspacing="0" cellpadding="0" style="margin:0 0 0 3px;">
<tr id="c_1">
<td style="width:90px; height:1px;"></td>
<td style="width:330px; height:1px;"></td>
<td style="width:150px; height:1px;"></td>
<td style="width:150px; height:1px;"></td>
</tr>

<?php
mysqli_data_seek($result, 0);
$count =1;
while( $row = $result->fetch_assoc())		{
	
	$ahref = 'rating.php' .'?car=' .$row['car_id'];			
	if (!$row['year2']) 	{	   	$data = '(с ' .$row['year1'] .')'; 
	} 	else  						{ 		$data = '(' .$row['year1'] .'–' .$row['year2'] .')'; 		}

if ($row['rate_sum']>0)		{
echo '	
<tr>
<td style="padding-left:20px; padding-right:20px;">' .($count) .'</td>
<td class="link1"><a href=' .$ahref .'>' .$row['brand'] .'&nbsp;' .$row['model'] .'&nbsp;&nbsp;&nbsp;<span>' .$data .'</span></a></td>
<td style="padding-left:20px;">' .$row[$type] .'</td>
<td style="font-weight:normal; padding-left:10px;">' .$row['votes'] .'</td>
</tr>';
++$count;
}	}
?>

</table>
</div>


<!-- закладки -->
<div style="margin:40px 0 0 14px;">
<script src="http://odnaknopka.ru/ok2.js" type="text/javascript"></script>
</div>


</div> 
<?php	 require_once('_include/templates/##bottom.php');   ?>