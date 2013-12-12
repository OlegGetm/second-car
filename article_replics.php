<?php
session_start ();
require_once('_include/functions/functions.php');

$link = to_connect();
$car_id = (int)$_GET['car'];


if ($_SERVER['REQUEST_METHOD'] == 'POST')  {   	//////////  ДОБАВИТЬ реплику
require_once('_include/engine/add_article_replics.php');

}	else		{																		//////// ВЫВОД СТРАНИЦЫ



$zapros = "SELECT * 
 				  	FROM 							articles
 				  	WHERE car_id = 		'$car_id' 	";
$result = $link->query ($zapros);  
$row = $result->fetch_assoc();

$article_id = $row['article_id'];   

//  Вытаскиваем реплики			
		$zapros2 = "SELECT *
							FROM replics 
							WHERE article_id = '$article_id'
							ORDER by number, date  ";
		$result2 = $link->query ($zapros2);

		while ($row2 = $result2->fetch_assoc() )		{
			$replics[] = array($row2['number'], $row2['name'], $row2['text'], $row2['interest'] );
		}	




$text = ($row['text']);													// Получение hypertext
$paragraph =  explode ("\r\n", $text);						// Разбивка текста на абзацы
$num_parag = count($paragraph);




$add_head = '<script type="text/javascript">
var idArticle = "'  .$article_id .'"; 
</script>
<script type="text/javascript" src="_include/js/article/article_repl_load.js"></script>';


require_once('_include/templates/##top.php');  
require_once('_include/templates/##left.php');
$_SESSION['right_menu'] = 'article';

///  FULL column 
echo '<div id="allContent" style="background-color:#f8f8f8;">';

////////////////////////////////////////////
$this_title = 'Комментарии к обзору';
require_once('_include/templates/#dossier.php');
///////////////////////////////////////////

echo '
<div id="allContent" style="background-color:#fff;">';

$n 		= -1;  		// для фото счетчик
$count = -1;			// общий счетчик 

for ($i=0; $i<$num_parag; $i++)			{

echo '

<a name="block_' .$i .'"></a>
<div class="comments_row" style="display:block; width:830px; height:100%;  border-bottom: 1px solid #ccc;">
<div class="comments_left">' .
$paragraph[$i] .'
</div>';

echo '
<div class="comments_right" id="t_' .$i .'">';
				// Ниже  реплики
	

				foreach ($replics as $value)	{
					if($value[0] == $i) {
								echo '
					<a name="t_' .$i .'"></a>								
					<div style="display:block; width:520px; height:100%; position:relative; margin:10px 0px 10px 20px;">
					<div class="f_nosik"></div>
					<div class="f_top"><div class="f_top_left"></div></div>
					<div class="f_content">
					<div class="f_name">' .$value[1] .':</div>';
												
					$abzazs =  explode ("\r\n", $value[2]);			// Разбивка текста реплики на абзацы
					$num_abz = count($abzazs);
					
								for ($k=0; $k<$num_abz; $k++)		{
												echo '
												<div style="text-indent:20px;">' .$abzazs[$k] .'</div>'; 			
								}
					
					if($value[3]=="edit")		{ echo '
					<div style="margin:10px 50px 0 20px; padding:10px 0 10px 20px; background-color:#ffeff2; border-left:10px solid #f79bac; font-weight:bold; line-height:18px;">От редакции: информация  учтена<br>при редактировании статьи.</div>';	}
					
					echo '
					</div>
					<div class="f_bottom"><div class="f_bottom_left"></div></div>						
					</div>';
						}	}	
			/////
			$str0 = substr ($paragraph[$i], 0, 4);	
			if ($str0 !== '<h4>')	{	echo '
<div class="btns_add" style="font: 14px  Arial, sans-serif; color:#727272; text-decoration:underline; margin:20px 0 20px 30px; cursor:pointer;" id="t_' .$i .'">Ваш комментарий</div>';  }

			echo '
</div></div>
<div style="clear:both;"></div>
';

	}  ?>  

</div>		
</div>
<?php
require_once('_include/templates/##bottom.php'); 
}
?>