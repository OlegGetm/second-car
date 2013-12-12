<?php    
/////////////////////////////////////////////  BEGIN CACHE
require_once('_include/classes/class.CacheFile.php'); 
$cache2 = new Cache_File("cachefiles/right_column.cache", 300);

if( $text_cache = $cache2->get() )	{
	print	 $text_cache;
}	else	{
	$cache2->begin_cache(); 


/////// популярные обзоры в массив
$zapros = "	SELECT 						c.brand, c.model, c.year1, c.year2, c.car_id, a.title
 				   	FROM 							articles  a
					
					LEFT JOIN 				    cars as c 
					USING 						(car_id)	
					
				   	ORDER BY 					counter DESC  
					LIMIT							6
					"; 
$result = $link->query ($zapros);  

while ($row = $result->fetch_assoc() )		{
		$top_articles[] = array($row['brand'], $row['model'], $row['year1'], $row['year2'], $row['car_id'], $row['title']);
}	

/////// последние отзывы  в массив
$zapros = "	SELECT 						c.brand, c.model, c.year1, c.year2, c.car_id, o.opinion_id, o.name, o.text
 				   	FROM 							opinions  o
					
					LEFT JOIN 				    cars as c 
					USING 						(car_id)	
					
				   	ORDER BY 					date DESC  
					LIMIT							6
					"; 
$result = $link->query ($zapros);  

while ($row = $result->fetch_assoc() )		{
		$opinions[] = array($row['brand'], $row['model'], $row['year1'], $row['year2'], $row['car_id'], $row['opinion_id'], $row['car_id'], $row['name'], $row['text']);
}	

/////// форумы  в массив
$zapros = "  SELECT 						f.topic_id, f.title, c.car_id, c.brand, c.model, c.year1, c.year2
 				  	FROM 							forum_topics  f
				  	LEFT JOIN 					cars   c
					USING 						(car_id)
				  	ORDER BY 					f.last_date DESC
				  	LIMIT 							8
					"; 
$result = $link->query ($zapros);  

while ($row = $result->fetch_assoc() )		{
		$forums[] = array($row['topic_id'], $row['title'], $row['car_id'], $row['brand'], $row['model'], $row['year1'], $row['year2'] );
}	
?>

<!-- #   right column -->
<div style="display:block; width:260px; overflow:hidden; float:left;">

<!--  top letters-->
<div style="display:block; width:255px; height:400px; overflow:hidden; margin:0px 0 70px 4px; background: url('_include/pics/bg_top_letters.gif') no-repeat;">
<div class="r_label" style="margin:8px 0px 20px 0px;">Самое популярное:</div>

<div id="top_letters">
<?php
$ar_colors =array('f39019', 'f39728', 'f2a241', 'f1ac58', 'efb671', 'efb671');

$last_width = 240;

for ($k=0; $k<6; $k++) 	 {
		echo '
		<div style="width:' .$last_width .'px; background-color:#' .$ar_colors[$k] .';">
			<p><a href="article.php?car=' .$top_articles[$k][4] .'"><span>' .$top_articles[$k][0] .' ' .$top_articles[$k][1] .'</span> (' .$top_articles[$k][2] .'&ndash;' .$top_articles[$k][3] .')
			</a></p>
		</div>
		';
		$last_width = $last_width -rand(7, 15);
}
?>
</div>
</div><!--  top letters-->


<!--  Последние отзывы -->
<div style="display:block; width:255px; height:460px; overflow:hidden; margin:0px 0 70px 4px; background: url('_include/pics/bg_top_letters.gif') no-repeat;">
<div class="r_label" style="margin:8px 0px 10px 0px;">Последние отзывы:</div>
<?php
for ($k=0; $k<6; $k++) 	 {
	echo '
	<span class="fm_title" style="background:#fcd8ad;">'.$opinions[$k][0] .' ' .$opinions[$k][1] .':</span>
	<div class="fm_subtitle">
	<a href=opinion_view.php?opinion=' .$opinions[$k][5] .'>'
	.mb_substr($opinions[$k][8], 0,62,  'utf-8') .'...
	</a>
	</div>
	';
}
?>
</div><!--  Последние отзывы-->


<!-- forums  -->
<div style="display:block; width:245px; height:540px; overflow:hidden; padding:10px 0 0 0px; background: url('_include/pics/d_forum.jpg') no-repeat;">
<div class="r_label" style="margin:0px 0px 10px 16px;">Из форумов:</div>


<!-- forums tabs -->
<div id="tab_a1" style="display:block; height:31px; float:left; margin:0 0 10px 10px; background:#f3f3f3;">
<p style="color:#333; font-size:10px; padding:8px 8px 0 8px; cursor:pointer;">НОВЫЕ ТЕМЫ</p>
</div>
<div id="tab_a2" style="display:block; height:31px; width:90px;  float:left; overflow:hidden; background:url(_include/pics/bg_tab_1.jpg) repeat-x;">
<p style="color:#333; font-size:10px; padding:8px 8px 0 8px; cursor:pointer;">ПОПУЛЯРНЫЕ</p>
</div>
<!-- forums tabs -->

<!-- форумное поле  -->
<div id="n333" style="clear:both;">
<?php 

for ($k=0; $k<8; $k++) 	 {
	echo '
	<div id="topic_' .($k+1) .'"  class="fm_block"> 
	<span class="fm_title" style="background:#d1dfeb;">'.$forums[$k][3] .' ' .$forums[$k][4] .':</span>
	<div class="fm_subtitle">
	<a href=forum_posts.php?car=' .$forums[$k][2].'&amp;topic=' .$forums[$k][0] .'>'
	.mb_substr($forums[$k][1], 0,62,  'utf-8');
	if(mb_strlen($forums[$k][1], 'utf-8')>62)  echo '...';
	
	echo '</a></div></div>
	';
}
?>

</div><!-- форумное поле  -->
</div><!-- forums  -->

<?php 
// echo '<div style="margin:200px 0 0 20px; font-size:9px; color:#999;">' .date('H:i:s') .'</div>'; ?>

</div><!--  #  right column  -->


<?php    /////////////////////////////////////////////  END CACHE
$cache2->end_cache();
}
?>
