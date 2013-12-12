
<div style="display:block; width:862px; padding:6px 3px 6px 3px; margin:0 0 30px 0; background-color:#f7f7f7; border-bottom:2px solid #ececec;">

<div class="letter_title" style="padding-bottom:10px;"><a href="rating_all.php">Народный рейтинг - голосуют все!</a></div>

<div style="display:block; width:300px; height:100%; float:left; padding:0px 0 14px 0;">
<?php

$zapros = "SELECT 						*
 					FROM 							stars s
					LEFT JOIN 					cars  c
					USING 						(car_id)
					ORDER BY 					rate_sum DESC, brand, model
					LIMIT 							18 	";
					
$result2 = $link->query ($zapros);

for ($i=0; $i<18; $i++) 	 {
   $row2 = $result2->fetch_assoc();
  
   if($i==0) { $max_rate=$row2['rate_sum'];	}
   if($i==17)  {$min_rate=$row2['rate_sum'];	}
   if($i<8)  {
 	$img_name = '_photos/cars/micro/' .$row2['car_id'] .'.jpg';
	if (!file_exists($img_name)) 	{ $img_name = '_include/pics/photo_grey.gif'; }
	$ahref = 'rating.php' .'?car=' .$row2['car_id'];			
	echo '
<div style="display:block;  width:146px; height:110px; float:left; margin:0px 1px 1px 0px;  background:#ccc; position:relative; z-index:300;">
<a href="' .$ahref .'"><img src="' .$img_name .'"  width="146" height="110" ></a>
<div class="link3" style="display:block; position:absolute; bottom:0px; right:0px; font:bold 20px Tahoma,sans-serif; color:#fff; background-color:#5e5e5e; filter:alpha(opacity:80); KHTMLOpacity: 0.80; 	MozOpacity: 0.80; opacity: 0.80;"><div style="padding:0 7px 0 7px; z-index:1;">'
	.($i+1) .'</div></div>
</div>';
   }
	}
?>
</div>
<div style="display:block; width:544px; height:100%; float:left; margin-top:0px;">

<?php
//$kolonka_min =100;				// минимальная длина  столбика в px
//$kolonka_max =350;				// максимальная  длина  столбика в px

$interval = $max_rate -$min_rate;

$kolonka_shift =280;
$s =  280 / $interval;	

mysqli_data_seek($result2, 0);
$count =1;   							// вернуться на первую позицию выборки

for ($i=0; $i<18; $i++) 	 {
   $row2 = $result2->fetch_assoc();
   
   $w_kolonka = ($row2['rate_sum']  - $min_rate) *280 /$interval;
   $w_kolonka = intval($w_kolonka) +100;
	 
echo '
<div  style="display:block; width:530px; height:25px; background: url(_include/pics/line_2.jpg) repeat-x; cursor:pointer; ">
	<a href=\'rating.php' .'?car=' .$row2['car_id']  .'\'>
	<div  style="display:block; width:' .$w_kolonka .'px; height:25px; background: url(_include/pics/colon_1.jpg) no-repeat right; position:relative;">
	<div  style="display:block; width:200px; overflow:hidden; position:absolute; top:4px; left:' .($w_kolonka +16) .'px; font:bold 14px Arial,sans-serif; color:#727272;"><span class="link1">' .$row2['brand'] . '  ' .$row2['model'] .'</span>
	</div>
	<div class="link3"  style="display:block; position:absolute; top:3px; left:' .($w_kolonka -40) .'px;">'
	.$row2['rate_sum'] . '
	</div>
	</div>
	</a>
</div>';
}

?>
</div>

<a href="rating_all.php">
<div class="letter_text" style="clear:both; padding:20px 270px 10px 10px; ">
Считаете, что рейтинги надежности автомобилей, ежегодно публикуемые в США, Германии и других странах, не соответствуют действительности? Нет проблем – можете высказать свою точку зрения и проголосовать за свой автомобиль в "Народном рейтинге". Критериев оценки четыре: управляемость, комфорт, надежность и стоимость обслуживания. Каждый оценивается по 10-бальной системе, из них выводится общий балл. Подтасовки в "Народном рейтинге" исключены.  Чем больше читателей проголосует, тем объективнее будет общая картина. Поэтому проголосовал сам – пригласи товарища!
</div></a>


<!--  линия с коммент -->
<div class="comm_block" style="border-bottom:0;">
<a href="rating_all.php"><p>ДАЛЬШЕ</p></a>
</div><!--  линия с коммент -->

</div>