<?php
require_once('_include/functions/functions.php');
require_once('_include/templates/##top.php');  
require_once('_include/templates/##left.php');

$_SESSION['right_menu'] = 'experts';

clean_get();							// защита от SQL-инъекции
$car_id = (int)$_GET['car'];

?>
<!--  FULL column ..................................................... -->
<div id="allContent" style="background-color:#fff;">

<?php  
 ////////////////////////////////////////////
$this_title = 'Мнение экспертов';
require_once('_include/templates/#dossier.php');
///////////////////////////////////////////

echo '
<div class="arti" style="padding:0px 240px 90px 50px;">';

$zapros = "SELECT * 
 					FROM 							expert_letters
					LEFT JOIN 					cars 
					USING 						(car_id)

				 	LEFT JOIN 					experts 
					USING 						(expert_id)
					
					WHERE 		car_id 	=	'$car_id'	
					AND 	to_print		= 	'1' 
					ORDER BY date                   					";

$result = $link->query ($zapros);


while ($row = $result->fetch_assoc() )		{

echo '
<a name="' .$row['expert_id'] .'"></a>	
<div style="margin:50px 0 70px 0;">
<div style="font:bold 18px Tahoma,sans-serif; margin:20px 0 20px 0;">' .
$row['name'] .', &nbsp;';

if(strlen($row['title'])>0)  echo '<span  class="art_subtitle" style="font-size:14px; padding:0;">' .$row['title'] .'&nbsp;</span>';


if(strlen($row['url'])>0)	{
echo '
<a href="http://' .$row['url'] .'"><span  class="art_subtitle" style="font-size:14px; text-decoration:underline; padding:0;">' .$row['company'] .'</span></a>';
}	else	{ echo '<span class="art_subtitle" style="font-size:14px; padding:0;">' .$row['company'] .'</span>';   }

echo '</div>';

$pars =  explode ("\r\n", $row['text']); 									// делим на абзацы
foreach($pars as $i=> $txt)			{
if ($i == 0)	{   																// если первый параграф - текст с буквицей
					$str1 = mb_substr($txt, 0,1,  'utf-8');
					$str2 = mb_substr($txt, 1, mb_strlen($txt, 'utf-8'),  'utf-8');
					echo '
<div style="text-indent:0px;"><span class="first_cap">'  .$str1 .'</span>' .$str2 .'</div>';
		}		else    {
		echo '
<div style="text-indent:30px;">' .$txt .'</div>';	
	  }	
}
echo '
</div>
';
}
?>
</div>
</div>
<?php
require_once('_include/templates/##bottom.php'); 
?>