<?php
require_once('_include/functions/functions.php');

$link = to_connect();
session_start();

$car_id = (int)$_GET['car'];



$zapros = 	"SELECT *
 				  	FROM 							testdrives
				  	LEFT JOIN 					cars 
					USING 						(car_id)
 				  	WHERE car_id = 		'$car_id' 	";

$result = $link->query ($zapros); 
$row = $result->fetch_assoc();
$testdrive_id = (int)$row['testdrive_id'];



require_once('_include/templates/##top.php'); 
require_once('_include/templates/##left.php'); 
$_SESSION['right_menu'] = 'testdrive';
?>
 <!--  FULL column ..................................................... -->
<div id="allContent" style="padding-bottom:100px; background:#fff;">

<?php

////////////////////////////////////////////////////////////////////////////
$this_title = $row['title'];
require_once('_include/templates/#dossier.php');
////////////////////////////////////////////////////////////////////////////

$n = -1;   // счетчик для фото


// вытаскиваем фото к статье
$zapros3 = "SELECT *
 					FROM articles_photo 
 					WHERE article_id = $article_id
					ORDER by num_parag ";
					
$result3 = $link->query ($zapros3); 
$num3 = $result3->num_rows;	

		for ($m=0; $m<$num3; $m++)			{
		$row3 = $result3->fetch_assoc();
		$ar_photo[$m] = array($row3['num_parag'], $row3['img_name'], $row3['width'], $row3['height'], $row3['alt_text'], $row3['text']);
		 }	

echo '
<div class="arti" style="display:block; width:830px; overflow:hidden; position:relative; background: url(_include/pics/bg_line.gif) repeat-y; padding-top:20px; margin-top:30px;">
<div class="area_replics"><a href=article_replics.php?car=' .$car_id .'&amp;parag=' .$i . '><span class="repl">На страницу комментариев</span></a></div>';



$pars =  explode ("\r\n", $row['text']); 									// делим на абзацы
foreach($pars as $i=> $txt)			{
echo '
<a name="t_' .$i .'"></a>
<div class="wrap_parag">';
				
																							// Не высвечиваем вспл подсказку у заголовков
				$str0 = substr ($txt, 0, 4);	
				if ($str0 == '<h4>')		{	
				echo '
<div  class="parag_h4">' .$txt .'</div>
</div>'; 
				}	else				{	

					if ($i == 0)	{   												// если первый параграф - текст с буквицей
					$str1 = mb_substr($txt, 0,1,  'utf-8');
					$str2 = mb_substr($txt, 1, mb_strlen($txt, 'utf-8'),  'utf-8');
	
					echo '
<div id="t_' .$i .'"  class="parag_1" style="text-indent:0px;"><span class="first_cap">' .$str1 .'</span>' .$str2 .'</div>';
					} 		else  		{
			echo '
<div id="t_' .$i .'" class="parag_1">' .$txt .'</div>';	
					}


					if ($ar_photo)		{		//  фотографии
						
					foreach ($ar_photo as $value)	{
					list ($c1, $c2, $c3, $c4, $c5, $c6)	= $value;
					if ($c1 == $i )	{   ++$n;
					echo '
					
<a name="f_' .$n .'"></a>
<div class="wrap_parag">

<div id="f_' .$n .'" class="photo_1" style="width:'  .$c3 .'px; height:' .$c4 .'px; background:#e3e3e3 url(\'_photos/articles/' .$c2 .'\');">
<div class="photo_subscribe">' .$c6 .'</div>
</div>	

<div id="repl_f_' .$n .'" class="area_replics" style="top:20px;"></div>
</div>';	

					} 
					} }
}				
}  ?>
</div>



</div>
<?php
require_once('_include/templates/##bottom.php'); 

 ?>