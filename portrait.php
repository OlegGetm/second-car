<?php
require_once('_include/functions/functions.php');
session_start ();

$car_id = (int)$_GET['car'];


if ($_SERVER['REQUEST_METHOD'] =="POST")  	{   	//	ОБРАБОТКА  submit

clean_get();
$link = to_connect();
require_once('_include/engine/add_to_portrait.php');			

}	else		{																			//////// ВЫВОД СТРАНИЦЫ

$_SESSION['right_menu'] = 'forum';

$block_elements[0] = array('В целом', '(общая характеристика автомобиля, целесообразность покупки, обоснованность цены, отличия машин с разных рынков)', 'about');
$block_elements[1] = array('Управляемость', '(динамика, чувство руля, настройки подвески)', 'drive');
$block_elements[2] = array('Комфорт', '( в т.ч. эргономика, качество отделочных материалов, емкость багажника)', 'comfort');
$block_elements[3] = array('Двигатели', '(линейка моторов, самые популярные на российском рынке, сильные и слабые стороны двигателей, проблемные узлы, наиболее вероятные поломки, масляный аппетит)', 'motor');
$block_elements[4] = array('Кузов', '(варианты кузова, качество сборки, прочность лакокрасочного покрытия, стойкость к коррозии, где быстрее всего появляется ржавчина)', 'body');
$block_elements[5] = array('Трансмиссия, рулевое управление', '(надежность механической коробки передач и «автомата», средний срок службы сцепления)', 'transmis');
$block_elements[6] = array('Подвеска, тормоза', '(надежность передней и задней подвески, самые «расходные» детали подвески, как часто приходится менять, сколько служат тормозные колодки и диски)', 'podveska');
$block_elements[7] = array('Электрика', '(насколько надежна, слабые места)', 'electro');
$block_elements[8] = array('На что обратить внимание при покупке', '', 'buy');
$block_elements[9] = array('Плюсы-минусы автомобиля', '', 'plus');			


$add_head = '<script type="text/javascript">
var carId = "'  .$car_id .'"; 
</script>
<script type="text/javascript" src="_include/js/portrait/portrait.js"></script>';
require_once('_include/templates/##top.php');  
require_once('_include/templates/##left.php');
$_SESSION['right_menu'] = 'portrait';
?>

<!--  FULL column ............................. -->
<div id="allContent" style="background-color:#fff; padding-bottom:100px;">
<?php  

$zapros =	 	"SELECT 	block, name, text
 				  	FROM 							portrait
				 	LEFT JOIN 					cars 
					USING 						(car_id)
 				  	WHERE car_id = 		'$car_id' 	
					ORDER by block, date              	  ";

 						
  		$result = $link->query ($zapros);
		$num = $result->num_rows;

		for	($k=0; $k<$num; $k++)	  {
		$row = $result->fetch_assoc();
		$array1[$k] = array($row['block'], $row['name'], $row['text']);
		 }	

////////////////////////////////////////////
$this_title = 'Портрет';
require_once('_include/templates/#dossier.php');
///////////////////////////////////////////
$brand = $_SESSION['menu']['brand'];

echo '
<table width="780px" cellspacing="0" cellpadding="0" style="margin-top:20px;">
<tr>
<td style="width:210px;"></td>
<td style="width:500px;"></td>
</tr>';

$size_array = count($block_elements);
	
	for ($i=0; $i<$size_array; $i++) 	{
	echo '
<tr><td  valign="top" class="forum_tdleft" ';
if($i==0) echo ' style="border-top:0px solid #e1e4ea;" ';    echo '>
<div class="forum_title">' .$block_elements[$i][0] .'</div> 
<div style="font: bold 12px Arial,sans-serif; color:#747474;">' .$block_elements[$i][1] .'</div>
</td>
<td class="forum_tdright" '; 
if($i==0) echo ' style="border-top:0px solid #e1e4ea;" ';    echo '>';

									
								$block_name = $block_elements[$i][2];
								
								if ($array1)		{
								foreach ($array1 as $value)	{
					 			list ($a1, $a2, $a3)	= $value;
								if ($a1 == $block_name )	{

								echo '
<div style="display:block; width:490px; height:100%; position:relative; margin:10px 0px;">
<div class="f_nosik"></div>

<div class="f_top"><div class="f_top_left"></div></div>
<div class="f_content">
<div class="f_name">' .$a2 .':</div>';

$abzazs =  explode ("\n", $a3);			// Разбивка текста реплики на абзацы


				foreach($abzazs as $value)	  {
				echo '
<div style="margin-bottom:6px;">' .$value .'</div>';
				}
echo '
</div>
<div class="f_bottom"><div class="f_bottom_left"></div></div>						
</div>';
	}	}	}
	
echo '
<div class="btns_add" style="font: 14px  Arial, sans-serif; color:#727272; text-decoration:underline; margin:20px 0 0 20px; cursor:pointer;"  id=\'' .$i .'\'>Ваш комментарий</div>
<a name=\'' .$i  .'\'></a>
</td></tr>';
	}
?>  			
</table>
</div>
<?php
require_once('_include/templates/##bottom.php'); 
}
?>