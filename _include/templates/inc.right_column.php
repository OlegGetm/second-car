<!--   tops...right   -->
<div style="display:block;  width:230px; height:462px; position:relative; overflow:hidden; float:left; margin:64px 0 0 0px;">

<div class="r_label" style="margin-left:0px;">Повестка дня:</div>
<?php

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
				  	LIMIT 							4					"; 
$result = $link->query ($zapros);


while ($row = $result->fetch_assoc() )		{   // новости в  повестку дня
			$right_topics[] = array( 'letter.php?letter=' .$row['letter_id'], $row['title']);
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


foreach($right_topics as $val)		{ 	echo '
<div class="r_list"><a href="' .$val[0] .'">'.$val[1] .'</a></div>
';
}
?>
</div><!--   tops...right   -->

<!-- forums area  -->
<div style="display:block; width:255px; overflow:hidden; margin:50px 0 0 0; ">

<div class="r_label" style="margin:14px 24px 10px 50px;">Из форумов:</div>

<!-- forums  -->
<div style="display:block;  width:254px; height:545px; position:relative; overflow:hidden; float:left; ">
<!-- forums tabs -->
<div id="tab_a1" style="display:block; height:31px; float:left; margin-left:20px; background:#eee;">
<p style="color:#333; font-size:10px; padding:8px 8px 0 8px; cursor:pointer;">НОВЫЕ ТЕМЫ</p>
</div>
<div id="tab_a2" style="display:block; height:31px; width:90px; overflow:hidden; background:url(_include/pics/bg_tab_1.jpg) repeat-x;">
<p style="color:#333; font-size:10px; padding:8px 8px 0 8px; cursor:pointer;">ПОПУЛЯРНЫЕ</p>
</div>
<div style="clear:both;"></div><!-- forums tabs -->


<div style="width:220px; height:470px;">
<!-- форумное поле  -->
<div id="n333" style="display:block;  width:220px; padding:18px 0 10px 20px;">
<?php 
$zapros = 	"SELECT 	topic_id, car_id, brand, model, year1, title, date
 				  	FROM 							forum_topics 
				  	LEFT JOIN 					cars 
					USING 						(car_id)
				  	ORDER BY last_date desc
				  	LIMIT 9"; 
$result = $link->query ($zapros);  

$count_1 = 1;
while(list($topic_id, $car_id, $brand, $model, $year_1, $title, $date) = $result->fetch_row())		{
echo '
<div id="topic_' .$count_1 .'"  class="fm_block"> 
<span class="fm_title">'.$brand .' ' .$model .':</span>
<a href=forum_posts.php?car=' .$car_id .'&amp;topic=' .$topic_id .'>
<div class="fm_subtitle">'
.mb_substr($title, 0,62,  'utf-8');
if(mb_strlen($title, 'utf-8')>62)  echo '...';

echo '
</div>
</a>
</div>';
++$count_1;
}  ?>
</div><!-- форумное поле  -->
</div>
</div><!-- forums  -->
</div><!-- forums area  -->
