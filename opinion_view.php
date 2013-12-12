<?php
$add_head = '<script type="text/javascript" src="_include/js/cars/cars.js"></script>

<style type="text/css">
option { padding:0 0.5em; background-color:#fff; }
select { padding: 0 0 0 0.5em; }
</style>
';

require_once('_include/functions/functions.php');
require_once('_include/templates/##top.php');  
require_once('_include/templates/##left.php');

$_SESSION['right_menu'] = 'opinions';

$opinion_id = (int)$_GET['opinion'];

$zapros = "SELECT *
 					FROM 							opinions
 					WHERE opinion_id = 	'$opinion_id' ";
 $result = $link->query ($zapros);
 $row = $result->fetch_assoc();

$car_id =  $row['car_id'];
?>

<!--  FULL column  -->
<div id="allContent" style="height:100%; min-height:980px; background-color:#fff;">

<?php
////////////////////////////////////////////
$this_title = 'Отзывы владельцев';
require_once('_include/templates/#dossier.php');
///////////////////////////////////////////

?>

<div class="arti" style="padding:0px 190px 0px 50px;">

<table cellpadding="0" cellspacing="2px" style="background-color:#d6d6d6; font-weight:bold; padding:10px 20px 10px 10px; margin:20px 0 20px 0px;">
<tr>
<td style="color:#fff; padding:0 30px 10px 0;">Владелец</td><td style="color:#676767;"><?php echo $row['name']; ?></td>
</tr>
<tr>
<td style="color:#fff;">Автомобиль</td><td style="color:#676767;"><?php echo $row['year']; ?> года</td>
</tr>
<tr>
<td style="color:#fff;">Пробег</td><td style="color:#676767;"><?php echo $row['run']; ?>&nbsp;тыс. км</td>
</tr>

<?php
if ($row['body'] !== '')	{  echo '
<tr><td style="color:#fff;">Кузов</td><td style="color:#676767;">' .$row['body'] .'</td></tr>';  }
if ($row['motor'] !== '')	{ echo '
<tr><td style="color:#fff;">Мотор</td><td style="color:#676767;">' .$row['motor'] .'</td></tr>';  }
if ($row['gear'] !== '')	{ echo '
<tr><td style="color:#fff;">Коробка</td><td style="color:#676767;">' .$row['gear'] .'</td></tr>'; }
if ($row['transmission'] !== '')	{ echo '
<tr><td style="color:#fff;">Привод</td><td style="color:#676767;">' .$row['transmission'] .'</td></tr>'; }
?>
</table>

<?php
$pars =  explode ("\r\n", $row['text']); 
foreach($pars as $key=>$txt)   {
	$str = substr ($txt, 0, 4);	
	if ($key == 0)		{
					$str1 = mb_substr($txt, 0,1,  'utf-8');
					$str2 = mb_substr($txt, 1, mb_strlen($txt, 'utf-8'),  'utf-8');
	echo  '
	<div style="text-indent:0px;"><span class="first_cap">' .$str1 .'</span>' .$str2 .'</div>';
	}	else	{	echo '
	<div style="text-indent:30px;">' .$txt .'</div>';	
	}
}



echo '
<div style="display:block; height:40px; width:10px; clear:both;"></div>';

if ($row['minus'] !== '')	{
$minus	 = $row['minus'];
$minus =  explode ("\r\n", $minus); // Разбивка текста на абзацы (получается массив)
$num_minus = count($minus);
echo '
<div style="padding:0 0 20px 0; margin:0;">
<div style="font-weight:bold;">Слабые места:</div>';
	for ($i=0; $i<$num_minus; $i++)		{ echo '
<div style="margin-bottom:10px;">' .$minus[$i] .'</div>';	
	}	
echo '
</div>';
}

if ($row['price'] !== '')	{
echo '
<p style="font-weight:bold; padding:0 0 5px 0; margin:0;">Стоимость содержания:
<span style="font-weight:normal;">&nbsp;&nbsp;' .$row['price'] .'</span></p>';
}

if ($row['friends'] !== '')		{
echo '
<p style="font-weight:bold; padding:0 0 5px 0; margin:0;">Порекомендовали бы своим знакомым?
<span style="font-weight:normal;">&nbsp;&nbsp;' .$row['friends'] .'</span></p>';
}

if ($row['original'] !== '')	{
echo '
<p style="font-weight:bold; padding:0 0 0 0; margin:0;">Использую запчасти:
<span style="font-weight:normal;">&nbsp;&nbsp;' .$row['original'] .'</span></p>';
}
?>


<div style="padding:40px 0 50px 0px; color:#ababab; text-decoration:underline; cursor:pointer;" onclick="history.back();">Назад</div>

</div>


<!-- нижний блок -->
<div style="width:600px; margin:0px 0 0 50px; padding:20px 0 0 0; border-top:1px solid #ccc;">

<div style="color:#ccc; font:bold 16px Arial, sans-serif;  margin:0 0 4px 0;">Добавьте свой отзыв:</div>

<?php require_once('_include/templates/inc.opinion.php');  ?>

</div><!-- нижний блок -->



</div>
</div>
<?php
require_once('_include/templates/##bottom.php'); 
?>