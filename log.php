<?php
require_once('_include/functions/functions.php'); 
require_once('_include/functions/my_calendar.php');
require_once('_include/templates/#top_log.php'); 
			
			//// перевод значения поля бд  в упорядоченный массив
			function my_order_array($str) 	{ 				
			
			$array = array();
			$tt = '::';                            							// разделитель
			$array =  explode ($tt, $str);
			sort($array);
			unset ($array[0]);											// убрать первый пустой элемент массива
			$array = array_count_values ($array);
			arsort($array);
			return $array;
			} 

$link = to_connect();
$name_table = 'statist_secondcar';


if (isset ($_GET['date']) )	{

			$ar_date =  explode("_",$_GET['date']);
			$year 		= $ar_date[0];
			$month 	= $ar_date[1];
			$day 		= $ar_date[2];
			
			}	else	{
			$year 		= date('Y');
			$month 	= date('m');
			$day 		= date('d');
			}

$ymd = $year .'_' .$month .'_' .sprintf('%02d', $day);
?>

<script type="text/javascript">
$(function()  {
$(".column").mouseover( function() 	{ 
							$('#b_' + this.id).show();
							 } );
$(".column").mouseout( function() 	{ 
							$('#b_' + this.id).hide();
							 } );

$(".column").click( function() 	{ 
							var postfix;
							if( ((this.id).length) == 1)  {  postfix =  '0' + this.id; 
							}  else  							{  postfix = this.id;	}
							location.href= '<?php echo $_SERVER['PHP_SELF'] .'?date=' .$ymd .'&'; ?>h=' + postfix;
							 } );

$("#to_calendar").click( function() 	{ 
							$("#calendar").toggle();
							 } );
});	   
</script>


<?php

$hour = date('H');

$date_text = $year .'_' .$month .'_' .$day;



$q = "SELECT * 
 		 FROM $name_table
		 WHERE date_text 	=  '$date_text'  ";

$result = $link->query ($q); 
$num = $result->num_rows;

		while( $row = $result->fetch_assoc())		{
		
		$hour = intval($row['hour']);
		
			
		$bots =  explode ('::', $row['agents']);
		sort($bots);
		unset ($bots[0]);			// убрать первый пустой элемент массива
		$unique_bots = array_unique($bots);
		$unique_bots = count($unique_bots);
	
		//$ar_visits[$hour] 	 = $row['visits'];
		$hosts=$row['ip'];
		$hosts =  explode ('::', $hosts);
		$unique_hosts = array_unique($hosts);
		$unique_hosts = count($unique_hosts);
		$ar_hosts[$hour] = $unique_hosts-1 -$unique_bots;

		$ar_pages[$hour] = $row['pages'];
		$referers  .=$row['referers'];
		$ip    		.=$row['ip'];
		}
?>

<div id="allContent" style="width:960px; background: #f3f3f3; position:relative;">

<!-- вывод календаря -->
<div id="calendar" style="display:none; width:300px; height:300px; position:absolute; top:40px; left:670px;">
<?php  my_calendar(); ?>
</div>

<!-- block -->
<div style="margin:140px 0 570px 70px;">

<?php 
 $month_ar =array("", "января","февраля","марта","апреля","мая","июня", "июля","августа","сентября","октября","ноября","декабря"); 
?>

<h1 style="margin:0px 0 20px 10px; color:#bbb;">Статистика<?php 
if ($ar_date[2] && $ar_date[2]  !== date('d')) echo ' за ' .(int)$day .' ' .$month_ar[(int)$month]; ?></h1>

<div style="display:block; width:762px; height:364px; overflow:hidden; background: url(_include/pics/statistics_bgr.png) no-repeat; padding:15px 0 0 24px;">

<?php
arsort($ar_hosts);
$max = current($ar_hosts);    		 		// максимальное значение посещение
$s =  (260 / $max);								// множитель для опредления размера столбиков

 			for ($i=0; $i<24; $i++) 	 {
	
			if($ar_hosts[$i]) 	{ 					// высота колонки
			$h_hosts = $ar_hosts[$i] *$s; 
			$h_hosts = intval($h_hosts);
			  
			}	else		{ 	$h_hosts = 0; 	}
			
			$hosts_sum = $hosts_sum + $ar_hosts[$i];		// все посещения 
			
			if ($ar_hosts[$i]>99)		{ $pd_left=2;}	// лев.отсуп в зависимости от числа посещений
			else if ($ar_hosts[$i]>9 && $ar_hosts[$i]<100) { $pd_left=6; }
			else	{ $pd_left=10; }  
			
			echo '
<div id="' .$i .'" class="column" style="display:block; position:relative; width:30px; height:300px; float:left; margin-right:0px; background: url(_include/pics/statistics_line.jpg) repeat-y right; cursor:pointer; ">
	<div  style="display:block; position:absolute; bottom:0px; width:30px; height:' .$h_hosts .'px; background: url(_include/pics/statistics_column.jpg) no-repeat;">
			<div style="display:block; width:26px; height:20px; overflow:hidden; position:absolute; top:4px; left:1px; background: url(_include/pics/statistics_label.jpg) no-repeat; ';
			if($h_hosts<20)	{ echo 'visibility:hidden; '; }  echo '
			font-size:12px; font-weight:bold; color:#666;">
					<div style="padding:1px 0 0 ' .$pd_left .'px;">' .$ar_hosts[$i] .'</div>
			</div>';
			if($ar_pages[$i]>0)	{ echo '
			<div id="b_' .$i .'"    style="display:none; width:24px; height:20px; position:absolute; top:-28px; left:1px; background-color:#ebebeb; padding:0 1px; font-size:12px; font-weight:bold; color:#666;">
				<div style="padding:2px 0 0 ' .($pd_left -4) .'px;">' .$ar_pages[$i] .'</div>
			</div>';  }		echo '	
	</div>
</div>
			';
			}
 ?>
<div style="clear:both;"></div>

<?php
$color = '0';
			
			for ($i=0; $i<24	; $i++) 	 {					// дни месяца
							
							if ( is_int($color/2) )       // чересстрочный цвет	
							{ $style_raw = '#d6d6d6';  }
							else
							{ $style_raw = '#e3e3e3';  }
							++$color;
			echo '
			<div style="display:block; width:724px; margin-left:-1px;"> 
			<div style="display:block; width:30px; height:20px; overflow:hidden; float:left; margin-right:0px; background-color:' .$style_raw .';">
					<div style="display:block; width:30px; height:20px; margin:3px 0 0 6px; font-weight:bold; color:#666;">'	.$i .'</div>
			</div></div>';
			}
echo '
<div style="clear:both;"></div>
</div>

<div style="margin:50px 0 50px 0; font-weight:bold; color:#bbb;">Всего посетителей:<span style="padding-left:20px; font-size:22px; ">' .$hosts_sum .'</span></div>';


//$ar_ref = my_order_array($referers);					// вывод всех реферов
//foreach ($ar_ref as $value=> $index)		{
//	$value = substr($value, 0, 60);
//	echo '(<span style="font-weight:bold;">' .$index .'</span>) ' .$value .'  <br>';
//}
//$ar_ref = my_order_array($ip);							// вывод всех ip
//foreach ($ar_ref as $value=> $index)		{
//	$value = substr($value, 0, 60);
//	echo '(<span style="font-weight:bold;">' .$index .'</span>) ' .$value .'  <br>';
//}


//////////// данные за последний час


if(isset($_GET['h']))   {

$this_hour = date('H');
if(isset($_GET['h'])) $this_hour = $_GET['h'];

$zapros = "SELECT * 
 				  FROM $name_table
					WHERE date_text 	=  '$_GET[date]'
					AND hour	= '$this_hour'  ";
$result = $link->query ($zapros); 


		while( $row = $result->fetch_assoc())		{
		$referers_hour		=$row['referers'];
		$ip_hour				=$row['ip'];
		$bots_hour    		=$row['agents'];
		}

echo '<div style="margin:0 0 10px 0; text-lecoration:underline; font-weight:bold;">Откуда идут<span onClick=location.href="' .$_SERVER['PHP_SELF']  .'"; style="padding-left:20px; font-weight:normal; cursor:pointer;">(-)</span></div>

<div id="statistics_referrers">';
$ar_ref = my_order_array($referers_hour);					// вывод реферов за последний час

foreach ($ar_ref as $value=> $index)		{
	// $value = substr($value, 0, 70);
	echo '(<span style="font-weight:bold;">' .$index .'</span>) <a href="' .$value .'">' .$value .'</a><br>';
}

echo '
</div>
<div style="margin:30px 0 10px 0; text-lecoration:underline; font-weight:bold;">IP адреса</div>';

$ar_ref = my_order_array($ip_hour);							// вывод ip за последний час

foreach ($ar_ref as $value=> $index)		{
	$value = substr($value, 0, 60);
	echo '(<span style="font-weight:bold;">' .$index .'</span>) ' .$value .'  <br>';
}


echo '<div style="margin:30px 0 10px 0; text-lecoration:underline; font-weight:bold;">Поисковые боты</div>';

$ar_ref = my_order_array($bots_hour);					// вывод ботов за последний час

foreach ($ar_ref as $value=> $index)		{
	//if(strstr($value, 'bot') )  {
	$value = substr($value, 0, 100);
	echo '(<span style="font-weight:bold;">' .$index .'</span>) ' .$value .'  <br>';
	//}
}


}
?>
</div>


</div><!-- block -->
<!-- ..................................................footer -->
<div style="clear:both;"></div>
</div><!-- wrap -->
</div><!-- wrapper -->
</body>
</html>