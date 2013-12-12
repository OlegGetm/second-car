<?php
require_once('_include/templates/inc.topic.php');  

 if(empty($car_id))	{  $car_id = (int)$_GET['car']; }

//if (($_SESSION['car_id']) != $car_id)		{


$zapros = 	"SELECT 				c.brand, c.model, c.year1, c.year2, c.segment,
                                                    dr.letter_id    				as isset_drive,    
													a.article_id           		as isset_art,                    
                    								e.expert_letter_id     	as isset_experts,
													t.tuv_id               			as isset_tuv
					
					FROM 						cars c 

					LEFT JOIN 				testdrives  dr                    
					USING 					(car_id)

					LEFT JOIN 				articles a                    
					USING 					(car_id)
					
					LEFT JOIN 				expert_letters e 
					USING 					(car_id)
					
					LEFT JOIN 				tuv t                    
					USING 					(model)
					
					WHERE c.car_id = 	'$car_id'
                    GROUP BY 			c.model, c.year1       
					    ";

$res = $link->query ($zapros);  
$r = $res->fetch_assoc();

$_SESSION['car_id'] 					= $car_id;
$_SESSION['menu']['brand'] 		= $r['brand'];
$_SESSION['menu']['model'] 		= $r['model'];
$_SESSION['menu']['year1']		= $r['year1'];
$_SESSION['menu']['year2'] 		= $r['year2'];
$_SESSION['menu']['segment'] 	= $r['segment'];


$_SESSION['menu']['isset_drive'] 		= (int)$r['isset_drive'];
$_SESSION['menu']['isset_art'] 			= (int)$r['isset_art'];
$_SESSION['menu']['isset_experts'] 	= (int)$r['isset_experts'];
$_SESSION['menu']['isset_tuv'] 			=  (int)$r['isset_tuv'];

//}

///////////////////////////////////////////

 $data = (empty($_SESSION['menu']['year2'])) ? '/с ' .$_SESSION['menu']['year1'] .'-го/' : '/' .$_SESSION['menu']['year1'] .' - ' .$_SESSION['menu']['year2'] .'/&nbsp;'; 
	  
$img_name = (file_exists('_photos/cars/big/' .$_SESSION['car_id'] .'.jpg')) ? '_photos/cars/big/' .$_SESSION['car_id'] .'.jpg' : '_include/pics/no_photo.jpg';


echo '
<div style="display:block; width:870px; height:344px; background: #d6d4d5 url(\'_include/pics/d_grad_3.jpg\') repeat-x;">

<div style="display:block; width:560px; height:344px; position:relative;">
<div style="position:absolute; top:6px; left:140px; width:440px; height:330px;   background: #cfd1d4 url(\'' .$img_name .'\') no-repeat;">';  //начало блока фото
				echo '
<div class="back">
<h2>' .$_SESSION['menu']['brand'] .' ' .$_SESSION['menu']['model'] .'</h2>
<h3>' .$this_title .'</h3>
</div>
<div class="front">
<h2>' .$_SESSION['menu']['brand'] .' ' .$_SESSION['menu']['model'] .'</h2>
<h3>' .$this_title .'</h3>
</div>
<div class="data_big_grey">' .$data .'</div>
</div>'; //конец блока фото

	echo '
<div style="position:absolute; top:8px; left:566px; display:block;  width:236px; height:100%">'; // начало правого меню
	
																   // высветить активную ссылку в правом меню
$set_style = 'background-color:#fa9319';  
 
if ( $_SESSION['right_menu'] == 'drive')			{ $style_drive 		= 	$set_style;  }
if ( $_SESSION['right_menu'] == 'article')		{ $style_article 	= $set_style;  }
if ( $_SESSION['right_menu'] == 'experts')		{ $style_experts 	= $set_style;  }
if ( $_SESSION['right_menu'] == 'portrait')		{ $style_portrait	= $set_style;  }
if ( $_SESSION['right_menu'] == 'forums')		{ $style_forums	= $set_style;  }
if ( $_SESSION['right_menu'] == 'rating')			{ $style_rating 		= $set_style;  }
if ( $_SESSION['right_menu'] == 'tuv')				{ $style_tuv 			= $set_style;  }
if ( $_SESSION['right_menu'] == 'opinions')	{ $style_opinions = $set_style;  }
if ( $_SESSION['right_menu'] == 'segment')	{ $style_segment = $set_style;  }


if (($_SESSION['menu']['isset_drive'])  > 0 )	{ echo '
<div class="menu_block">
<a href=letter.php?letter=' .$r['isset_drive'] .'&car=' .$car_id .'><img src="_include/pics/a_testdrive.png" /></a>
<div style="' .$style_article .'"></div>
</div>'; }

if (($_SESSION['menu']['isset_art'])  > 0 )	{ echo '
<div class="menu-block">
<a href=article.php?car=' .$car_id .'><img src="_include/pics/a_exploitation.png" /></a>
<div style="' .$style_article .'"></div>
</div>'; }

echo '
<div class="menu-block">
<a href=portrait.php?car=' .$car_id .'><img src="_include/pics/a_portret.png" /></a>
<div style="' .$style_portrait .'"></div>
</div>

<div class="menu-block">
<a href=rating.php?car=' .$car_id .'><img src="_include/pics/a_stars.png" /></a>
<div style="' .$style_rating .'"></div>
</div>

<div class="menu-block">
<a href=forum_topics.php?car=' .$car_id .'><img src="_include/pics/a_forum.png" /></a>
<div style="' .$style_forums .'"></div>
</div>';

if (($_SESSION['menu']['isset_experts'])  > 0 )	{ echo '
<div class="menu-block">
<a href=expert.php?car=' .$car_id .'><img src="_include/pics/a_experts.png" /></a>
<div style="' .$style_experts .'"></div>
</div>'; }

echo '
<div class="menu-block">
<a href=opinion_main.php?car=' .$car_id .'><img src="_include/pics/a_opinion.png" /></a>
<div style="' .$style_opinions .'"></div>
</div>';


if (($_SESSION['menu']['isset_tuv'])  > 0 )	{ echo '
<div class="menu-block">
<a href=tuv.php?car=' .$car_id .'><img src="_include/pics/a_tuv.png" /></a>
<div style="' .$style_tuv .'"></div>
</div>'; 
}

echo '
<div class="menu-block">
<a href=segment.php?car=' .$car_id .'><img src="_include/pics/a_conkur.png" /></a>
<div style="' .$style_segment .'"></div>
</div>';

echo '
</div>';  //конец правого меню
echo '
</div>';  //конец серого блока
echo '
</div>';  //конец основного блока

?>