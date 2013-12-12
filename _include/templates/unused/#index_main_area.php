<?php   
session_start(); 
require_once('_include/functions/functions.php'); 

require_once('_include/classes/class.CacheFile.php'); 
$cache = new Cache_File("cachefiles/index_main.cache", 300);

if($text_cache = $cache->get() )	{
	print	 $text_cache;
}	else	{
	$cache->begin_cache(); 



$add_head = '
<script type="text/javascript" src="_include/js/_core/easySlider1.5_mod.js"></script>
<script type="text/javascript" src="_include/js/index/slider.js"></script>
<script type="text/javascript" src="_include/js/index/forums.js"></script>
';


require_once('_include/templates/##top.php'); 
require_once('_include/templates/##left.php'); 


$car_topics 		= array();
$news				= array();
$showroom 		= array();
$right_topics 	= array();
/////////////////////////////////////

$zapros = "SELECT  						car_id, brand, model, year1, title 
					FROM 							articles
					LEFT JOIN 					cars 
					USING 						(car_id)
 					WHERE 	to_print = 	'1' 
 					ORDER BY 					date_mod desc
					LIMIT 							6"; 
$result = $link->query ($zapros);

while ($row = $result->fetch_assoc() )		{
		$car_topics[] = array($row['car_id'], $row['title'], $row['brand'], $row['model'], $row['year1']);
}	

/////// новости в массив
$zapros =   "SELECT l.letter_id, l.date, to_print, l.title, l.text, image_name, author_id,  
					DATE_FORMAT(l.date, '%Y_%m') as date_prefix, 
					COUNT(comment_id) as coms,
					sh.type as showroom_type
				  	
					FROM 							letters as l
				  	LEFT JOIN 				    comments 
					USING 						(letter_id)
					
				  	LEFT JOIN 				    showroom as sh 
					USING 						(letter_id)					
					
				  	WHERE  	to_print = 	'1'  
					GROUP BY 				l.letter_id
				  	ORDER BY 					l.date DESC
				  	LIMIT 							10					"; 
$result = $link->query ($zapros);

while ($row = $result->fetch_assoc() )		{
		$news[] = array($row['letter_id'], $row['title'], $row['text'], $row['date_prefix'], $row['image_name'], $row['coms'],$row['showroom_type']);
		
				if($c<4)	{										// новости в  повестку дня
				$right_topics[] = array( 'letter.php?letter=' .$row['letter_id'], $row['title']);
				}
	++$c;	
}	

/////// повестку дня  и шоурум в массивы
$zapros = "	SELECT 						*
 				   	FROM 							showroom
				   	ORDER BY 					area, pos  "; 
				  
$result = $link->query ($zapros);  

while($row = $result->fetch_assoc())	{
		
		if($row['area'] == 'lenta' && strlen($row['title'])>0 )		{
		$showroom[($row['pos']-1)] = array($row['title'], $row['text'], $row['url'], $row['photo'], $row['type']);
		}		
		elseif ($row['area'] == 'right' )	 	{
		$right_topics[] = array($row['url'], $row['title']);
		}
}

?>

<!--  ## full   -->
<div id="allContent" style="padding-bottom:0; ">
<?php  require_once('_include/templates/inc.topic.php');  ?>

<!--  # tops    -->
<div style="display:block; width:865px; height:462px; overflow:hidden; padding-left:5px; background: url('_include/pics/d_grad_0.jpg') repeat-x;  position:relative; border-bottom:1px solid #ccc;">

<!--   tops...auto   -->
<div style="display:block; width:603px; height:462px; overflow:hidden; float:left;">
<!--   tops...auto...left   -->
<div style="display:block; width:402px; height:462px; float:left;">
<?php
echo '
<a href=article.php?car='.$car_topics[0][0] .'>
<div class="light" style="display:block; width:401px; height:301px; overflow:hidden; margin:0 	0 1px 0; position:relative;  cursor:pointer;">
<img src="_photos/cars/big/' .$car_topics[0][0] .'.jpg"  width="401" height="301" />
<div class="back_1"><h5>' .$car_topics[0][1] .'</h5></div>
<div class="front_1"><h5>' .$car_topics[0][1] .'</h5></div>
	<div class="corner_model"><div>' .$car_topics[0][2] .' ' .$car_topics[0][3] .'	</div></div>
</div></a>';

for($i=1; $i<3; $i++)		{
echo '
<a href=article.php?car='.$car_topics[$i][0] .'>
<div class="light" style="display:block; width:200px; height:150px; overflow:hidden; float:left; position:relative;'; if($i==1) {echo ' margin:0 1px 0 0;'; } echo ' cursor:pointer;">
<img src="_photos/cars/mini/' .$car_topics[$i][0] .'.jpg"  width="200" height="150" />
<div class="corner_model"><div>' .$car_topics[$i][2] .' ' .$car_topics[$i][3] .'	</div></div>
</div></a>';
}
?>
</div><!--   tops...auto...left   -->

<!--   tops...auto...right   -->
<div style="display:block; width:200px; height:462px; overflow:hidden;  float:left;">
<?php

for($i=3; $i<6; $i++)		{
echo '
<a href=article.php?car='.$car_topics[$i][0] .'>
<div class="light" style="display:block; width:200px; height:150px; overflow:hidden; position:relative;  margin:0 0 1px 0; cursor:pointer;">
<img src="_photos/cars/mini/' .$car_topics[$i][0] .'.jpg"  width="200" height="150" />
<div class="corner_model"><div>' .$car_topics[$i][2] .' ' .$car_topics[$i][3] .'	</div></div>
</div></a>';
}
?>
</div><!--   tops...auto...right   -->
</div><!--   tops...auto   -->

<!--   tops...right   -->
<div style="display:block;  width:255px; height:462px; position:relative; overflow:hidden; float:left; margin:0 0 0 6px;background: url('_include/pics/d_right.jpg') no-repeat;">

<div class="r_label">Повестка дня:</div>
<?php
foreach($right_topics as $val)		{ 	echo '
<div class="r_list"><a href="' .$val[0] .'">'.$val[1] .'</a></div>
';
}

?>
</div><!--   tops...right   -->
</div><!--  # tops    -->

<!--  shadow   -->
<div style="display:block; width:870px; height:8px; overflow:hidden; background: url('_include/pics/d_shad_1.jpg') repeat-x;"></div>


<!-- # common area   -->
<div style="display:block; width:870px; overflow:hidden;  padding:26px 0 0px 0; background: url(_include/pics/d_grad_1.jpg) repeat-y;">


<!-- .......................... # left column   -->
<div style="display:block; width:610px; overflow:hidden; float:left;">

<?php
for ($k=0; $k<10; $k++) 	 {

if($k==2)	{																	//  вставить рейтинг
require_once('_include/templates/inc.rating_x_1.php');  }  
if($k==4)	{																	//  вставить экспертов
require_once('_include/templates/inc.experts_x_1.php'); } 


if (isset($showroom[$k]))		{										//	добавить  из шоурума
echo '
<div class="letter_block">
<div class="letter_title"><a href="' .$showroom[$k][2] .'">' .$showroom[$k][0] .'</a></div>';
$image =	$showroom[$k][3];
$types 	=	$showroom[$k][4];

	if (file_exists($image))	{
			$size_img 	= getimagesize($image); 
			$ht 				=  intval( 560 / $size_img[0] *$size_img[1]);
			$imgDiv		 = '<div style="width:560px; height:' .$ht .'px; margin:0 0 0 5px;  background:#ccc url(\'' .$image .'\') no-repeat -10px -' .(($size_img[1] - $ht)/2) .'px;">
			</div>';
			
			 echo $imgDiv;
	}
	
$paragraph =  explode ("\r\n", $showroom[$k][1]); 

for ($i=0; $i<1; $i++)		{
	echo '
	<div class="letter_text">
	<a href="' .$showroom[$k][2] .'">' .$paragraph[$i] .'</a>
	</div>';
	}
?>


<!--  линия с коммент -->
<div class="comm_block">
<a href="<?php 	echo $showroom[$k][2]; ?>"><p>ДАЛЬШЕ</p></a>
<?php  if($row['coms'] >0)	{  			echo '
<a href="' .$showroom[$k][2] .'#comments">
<div class="comm_booble"><span>' .$row['coms'] .'</span></div>
</a>'; 
}  ?>
</div><!--  линия с коммент -->
</div><!--  letter_block -->
<?php }       ////////////////////////////////////////////////////////////


if($news[$k][6] !== 'letter')		{ 					//   обычные новости, если не из шоурума

echo '
<div class="letter_block">
<div class="letter_title"><a href="letter.php?letter=' .$news[$k][0] .'">' .$news[$k][1]  .'</a></div>';

$image = '_photos/letters/' .$news[$k][3] .'/' .$news[$k][4];

	if (!empty($news[$k][4]) && file_exists($image))	{
				$size_img 	= getimagesize($image); 
				$ht 				=  intval( 560 / $size_img[0] *$size_img[1]);
				$imgDiv		 = '<div style="width:560px; height:' .$ht .'px; margin:0 0 0 5px; background:#ccc url(\'' .$image .'\') no-repeat -10px -' .(($size_img[1] - $ht)/2) .'px;">
				</div>';

	  echo $imgDiv;
	}

$paragraph =  explode ("\r\n", $news[$k][2]); 
for ($i=0; $i<1; $i++)		{
	echo '
	<div class="letter_text">
	<a href="letter.php?letter=' .$news[$k][0] .'">' .$paragraph[$i] .'</a>
	</div>';
	}
?>

<!--  линия с коммент -->
<div class="comm_block">
<a href="letter.php?letter=<?php 	echo $news[$k][0]; ?>"><p>ДАЛЬШЕ</p></a>
<?php  if($news[$k][5] >0)	
	{  			
echo '
<a href="letter.php?letter=' .$news[$k][0] .'#comments">
<div class="comm_booble"><span>' .$news[$k][5] .'</span></div>
</a>'; 
	}  
?>
</div><!--  линия с коммент -->
</div><!--  letter_block -->

<?php	}	}    ?>

<!-- блок навигации -->
<div  style="display:block; width:570px; height:70px; position:relative; margin-top:70px;">
<a href="lenta.php?page=2"><div class="btn_pages" style="right:30px;">Вперед</div></a>
</div>


</div>
</div><!-- #  left column   -->

<?php    /////////////////////////////////////////////  END CACHE
$cache->end_cache();
}
?>