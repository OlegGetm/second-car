<?php
session_start ();
if  (!isset($_SESSION['login_editor'])) { $url = 'Location: ../login.php';
	header ($url); 		}

$_SESSION['editor'] = 'forum';
include_once('../_common/functions.php');

$portrait_id = 	(int)$_GET['portrait_id'];
$car_id = 		(int)$_GET['car_id'];

$status = $_GET['status'];
$delete = $_GET['delete'];

$block_elements[0] = array('Портрет', '(общая характеристика автомобиля, целесообразность покупки, обоснованность цены, отличия машин с разных рынков)', 'about');
$block_elements[1] = array('Управляемость', '(динамика, чувство руля, настройки подвески)', 'drive');
$block_elements[2] = array('Комфорт', '( в т.ч. эргономика, качество отделочных материалов, емкость багажника)', 'comfort');
$block_elements[3] = array('Двигатели', '(линейка моторов, самые популярные на российском рынке, сильные и слабые стороны двигателей, проблемные узлы, наиболее вероятные поломки, масляный аппетит)', 'motor');
$block_elements[4] = array('Кузов', '(варианты кузова, качество сборки, прочность лакокрасочного покрытия, стойкость к коррозии, где быстрее всего появляется ржавчина)', 'body');
$block_elements[5] = array('Трансмиссия, рулевое управление', '(надежность механической коробки передач и «автомата», средний срок службы сцепления)', 'transmis');
$block_elements[6] = array('Подвеска, тормоза', '(надежность передней и задней подвески, самые «расходные» детали подвески, как часто приходится менять, сколько служат тормозные колодки и диски)', 'podveska');
$block_elements[7] = array('Электрика', '(насколько надежна, слабые места)', 'electro');
$block_elements[8] = array('На что обратить внимание при покупке', '', 'buy');
$block_elements[9] = array('Плюсы-минусы автомобиля', '', 'plus');			

		$link = to_connect();
		 
		 $zapros = "SELECT * 
							FROM 						portrait
							WHERE car_id = 	'$car_id'
							ORDER BY 				date DESC
							";
			
		 $result = $link->query ($zapros);
	     $num = $result->num_rows;
			 
		for	($k=0; $k<$num; $k++)	  {
		$row = $result->fetch_assoc();
		$array1[$k] = array($row['portrait_id'], $row['block'], $row['name'], $row['text'], $row['interest']);
		 }	


		$zapros = "SELECT * 
							FROM 						cars
							WHERE car_id = 	'$car_id'
							";	
		$result = $link->query ($zapros);
		$row = $result->fetch_assoc();

include_once('../_common/templates/##top.php');
?>

<script type="text/javascript" src="../_common/ajax/common.js"></script>
<script type="text/javascript" src="../_common/ajax/forums/edit.js"></script>
<script type="text/javascript">  
     $(document).ready(function(){  
		var m = 'a<?php echo $portrait_id; ?>';
		if ($('#' +m).length > 0)	{
		var metka = document.getElementById(m);
		metka.scrollIntoView();
		window.scrollBy(-300, 0);
	}
  });  

function prevReplica(num)		{
	var numBefore =  'a' +num;
	if ($('#' +numBefore).length > 0)	{
		var idNumBefore = document.getElementById(numBefore);
		idNumBefore.scrollIntoView();
		window.scrollBy(-300, 0);
	}
}
</script>
<div id="fullContent" style="margin:20px 0 0 40px;">


<!-- BOX 1  -->
<?php
$table_width =890;
include_once('../_common/templates/inc.table_top_white.php');  ?>
<div  style="margin:0px 6px 0 8px;  background:#fff;">

<?php
$img = '../../_photos/cars/micro/' .$row['car_id'] .'.jpg'; 
if (file_exists($img))   	{  	echo '
<img  style="display:block; float:left; width:170px; height:120px; margin:20px 0 20px 24px; padding:4px; border:1px solid #ddd;" src ="' .$img .'" width="146"  height="110">';
}   

echo '
<div style="display:block; float:left; width:370px; height:100px; color:#727272; font:bold 18px helvetica,sans-serif; margin:20px 0px 0px 50px;">'
.$row['brand'] .' ' .$row['model'] .'&nbsp;&nbsp; /' .$row['year1'] .'–' .$row['year2'] .'/</div>
<div style="clear:both;"></div>';

echo '
<table cellspacing="0" cellpadding="0" style="width:780px; padding:0px 10px 70px 30px;">
<tr><td style="width:220px;"></td><td style="width:530px;"></td></tr>';

	$size_array = count($block_elements);
	for ($i=0; $i<$size_array; $i++) 	{

echo '
<tr>
<td  valign="top" style="border-top: 4px solid #ececec; padding:20px 0;">
<div style="padding:10px; font:bold 14px Tahoma, Arial, sans-serif; color:#707070;">' .$block_elements[$i][0] .'</div> 
</td>

<td valign="top" style="border-top: 4px solid #ececec; padding:20px 0;">';
									
// Ниже  реплики
$block_name = $block_elements[$i][2];

		if ($array1)  {
			foreach ($array1 as $value)	{		
			list ($a0, $a1, $a2, $a3, $a5) = $value;  // potrrait_id, block, name, text, interest
			if ($a1 == $block_name ) {
								
				if ($a5 == "yes") 				{ $colorback = "background-color: #eddbdb;";  }
		else if ($a5 == "no") 				{ $colorback = "background-color: #ccc;";     }
		else if ($a5 == "edit") 				{ $colorback = "background-color: #d6e2f2;"; }
		else											{ $colorback = "background-color: #f3f3f3;"; }	
		
			 	if ($a0 == $portrait_id) 	{ $border = " border:4px solid #FDC8A6;"; 		// если  свежая реплика
				}	else								{ $border = " border:1px solid #ccc;";		   }	
?>

<div id="a<?php echo $a0; ?>" class="repl_1" style=" <?php  echo $colorback .$border;  ?>">
<div class="repl_2"><?php echo $a2;  ?></div>
<div id="b<?php echo $a0; ?>" class="repl_4" onclick="changeToInput('<?php echo $a0; ?>')" ><?php echo $a3; ?></div>
<div id="c<?php echo $a0; ?>"></div>

<div id="d<?php echo $a0; ?>" class="repl_3" style="padding:2px 0 0 0;">
<form>
<span style="margin-left:10px;">
<input type="radio" name="interest" value="yes"  <?php if($a5=='yes') echo 'checked'; ?> onclick="setStatus('<?php echo $a0; ?>', 'yes')" />&nbsp;Интересно 
</span>

<span style="margin-left:20px;">
<input type="radio" name="interest" value="no"  <?php if($a5=='no') echo 'checked'; ?> onclick="setStatus('<?php echo $a0; ?>', 'no')" />&nbsp;Так себе 
</span>

<span style="margin-left:20px;">
<input type="radio" name="interest" value="edit"  <?php if($a5=='edit') echo 'checked'; ?> onclick="setStatus('<?php echo $a0; ?>', 'edit')" />&nbsp;Добавлено в статью
</span>

<span style="margin-left:60px; cursor:pointer;" onclick="deleteRaw('<?php echo $a0; ?>')">Удалить</span>

<img style="margin:0px 0 0 10px; cursor:pointer;" onclick="prevReplica('<?php echo $prev_replica; ?>')" src="../_common/img/row_down.jpg" width="15" height="16">
</form>

</div>
</div>
<?php 	
} 	

$prev_replica = $a0;

}	}
echo '
</td>
</tr>';

	}
?>  			
</table>

</div>	
<?php include_once('../_common/templates/inc.table_bottom_white.php'); ?> <!-- BOX 1  -->
</div>

<?php include_once('../_common/templates/##bottom.php');  ?>
        
