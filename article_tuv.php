<?php
$add_head = '<script type="text/javascript" src="_include/js/tuv/tuv.js"></script>
';

require_once('_include/functions/functions.php');
require_once('_include/templates/##top.php');  
require_once('_include/templates/##left.php');
?>


<!-- # full  -->
<div id="allContent" style=" background:#fff url(_include/pics/d_grad_3.jpg) repeat-x top;">

<?php require_once('_include/templates/inc.topic.php');  ?>

<div style="margin:0px 200px 40px 50px;">

<div class="letter_title" style="margin:30px 0 40px 9px;">Рейтинг надежности TUV</div>


<div style="line-height:18px;"><span class="first_cap" style="background:#ccc;">Т</span>олько у нас – полные данные самого последнего <span style="font-weight:bold;">TUV Report-2010!</span> Немецкая организация технического контроля TUV проводит техосмотры автомобилей в ФРГ. Вся информация о выявленных неисправностях по-германски педантично собирается, ранжируется. И на ее основе каждый год публикуют сводные рейтинги надежности, так называемые TUV Report. Принцип их составления довольно прост – чем больший процент машин определенной модели «завернули» инспекторы во время техосмотра, тем ниже машина в списке TUV Report. Всего таких списков пять, в зависимости от года выпуска автомобилей.</div>
<div style="text-indent:30px; line-height: 18px;">Слева в таблице – место, занятое автомобилем (понятно, что чем ближе к пьедесталу, тем лучше). Правее указан процент автомобилей, не сумевших пройти техосмотр с первого раза.  Для большей объективности помимо цифр отбраковки по каждому автомобилю дается его средний пробег. Сноска не лишняя, поскольку показания одометров у машин-одногодок могут расходиться более чем вдвое! Особенно несладко приходится автомобилям, которые частенько задействуют в качестве такси, в прокатных конторах, флит-парках компаний. Само собой, повышенный износ таких экземпляров надо держать в уме, сравнивая с техническим состоянием (и строчкой в рейтинге) машин, привыкших к более тепличным условиям эксплуатации.</div>
<div style="text-indent:30px; line-height: 18px;">Конечно, целиком полагаться  на немецкую статистику не стоит. Хотя бы потому, что она не учитывает многих популярных в России иномарок.</div>


<a name="top" />
<div  style="padding:30px 0 20px 0px; color:#333; font-size:16px; font-weight:bold;">Рейтинг надежности машин:</div>


<!--  tabs   -->
<div id="set_tuv" class="nav_tab_blue" style="margin-left:0px;">
<div id="3" class="selected">В возрасте 2–3 лет</div>
<div id="5" style="text-decoration:underline;"> 4–5 лет</div>
<div id="7" style="text-decoration:underline;"> 6–7 лет</div>
<div id="9" style="text-decoration:underline;"> 8–9 лет</div>
<div id="11" style="text-decoration:underline;"> 10–11 лет</div>
</div>
<div style="clear:both; "></div>
<!--  end tabs   -->

<table width="620px" cellspacing="0" cellpadding="0" style="color:#fff;">
<tr style="background-color:#ccc; font-weight:bold;">
<td style="width:10px;"></td>
<td style="width:70px; padding:10px 0 6px 0;">Место</td>
<td style="width:200px; padding-top:10px;">Название модели</td>
<td style="width:120px; padding-top:10px;">Процент отсева</td>
<td style="width:140px; padding-top:10px;">Средн. пробег, т.км</td>
</tr>
</table>

<div id="area_load" style="min-height:900px; width:620px; background:#efefef;">
<table id="table_1"  width="620px" cellspacing="0" cellpadding="0" bgcolor="#efefef">
<tr>
<td style="width:10px; height:10px;"></td>
<td style="width:70px;"></td>
<td style="width:220px;"></td>
<td style="width:120px;"></td>
<td style="width:120px;"></td>
</tr>

<?php		
$link = to_connect();
$zapros = 	"SELECT *
					FROM 							tuv
					WHERE 	age		=		'3'
					ORDER BY 					mesto, model
					";
$result = $link->query ($zapros);
$num = $result->num_rows;


for ($i=0; $i<$num; $i++) 	 {
	
				if ( is_int($i/2) )       // чересстрочный цвет
				{ $style_raw = 'style="background:#fff; height:20px;"';  }
				else
				{ $style_raw = 'style="background:#f7f7f7; height:20px;"';  }
	
 $row = $result->fetch_assoc();
 echo '
<tr ' .$style_raw .'>
<td id="' .$row['model'] .'"></td>
<td>' .$row['mesto'] .'</td>
<td>' .$row['brand'] .' ' .$row['model'] .'</td>
<td>' .$row['otsev'] .' %</td>
<td>' .$row['probeg'] .'</td>
</tr>';
}
?>

</table>
</div>


<div id="onTop" style="font:bold 14px Helvetica, sans-serif; padding:30px 0px 0px 480px; color:#333; text-decoration:underline;">Наверх</div>

</div>

</div></div>
<?php
require_once('_include/templates/##bottom.php');
?>