<?php
require_once('_include/functions/functions.php');
require_once('_include/templates/##top.php'); 
require_once('_include/templates/##left.php'); 

clean_get();							// защита от SQL-инъекции
?>
<!--  ## FULL COLUMN   -->
<div id="allContent">

<!-- ## ФОРУМЫ  -->
 <div style="display:block; width:800px; height:100%; margin:50px 0 50px 40px;">

<?php
 $link = to_connect();
 $sql = 
    "SELECT 			c.car_id, c.brand, c.model, c.year1, c.year2,    
                        a.article_id,                    
                        s.rate_1, s.rate_2, s.rate_3, s.rate_4, s.rate_sum, s.votes                 
    FROM 				cars c
    
    LEFT JOIN 			articles a                    
    USING 				(car_id)

    
    LEFT JOIN 			stars s                    
    USING 				(car_id)  
    
    WHERE c.brand =		'$brand'
    
    GROUP BY 		    c.model, c.year1           
    ORDER BY 			model, year1  ";



$result = $link->query ($sql);
// var_dump($result); exit;

while($row = $result->fetch_assoc())	{
 
 
 if(!empty($row['article_id']))		{
  	$ahref =	'article.php?car=' .$row['car_id'];
 }	 else													{
	 $ahref =	'portrait.php?car=' .$row['car_id'];
 }


$img_name 	=  '_photos/cars/micro/' .$row['car_id'] .'.jpg';
$photo_src 	= file_exists($img_name) ?   $img_name : 		'_include/pics/no_photo.jpg'; 
$data 			= empty($row['year2']) ? 			'с&nbsp;' .$row['year1'] .'-го' :   $row['year1'] .'–' .$row['year2'];  
$car_name 	= 	($row['brand'] == 'Audi' || $row['brand'] == 'Mazda') ? 	$row['brand'] .' ' .$row['model'] :   $row['model'];
$rate_sum 	= $row['rate_sum'];
?>
	
<div style="display:block; float:left; <?php if($prev_model_name == $row['model']) 	{
													echo ' float:left; '; 
													}	else	{
													echo ' clear:left; '; 
													} ?>
width:368px; height:113px; overflow:hidden; margin: 0 0px 28px 24px; background:url(_include/pics/bg_index_artic2.jpg)  repeat-x top; border-top:1px solid #fafafa;">

<a href=<?php echo $ahref; ?>>
<div class="light" style="display:block; width:146px; height:110px; overflow:hidden; float:left; background:#abadb2 url('<?php echo $img_name; ?>');"> </div></a>


<div style="display:block; width:210px; height:111px; float:left; position:relative;"> 
<div class="art_titile">
<a href=<?php echo $ahref; ?>>
<?php echo $car_name; ?></a>
</div>
<div class="index_2" style="margin:0 8px 0 16px; font-size:15px;"><?php echo $data; ?></div>

<?php
if ($rate_sum>0) {
echo '
<a href="rating.php?car=' .$row['car_id'] .'"  title="Народный рейтинг,  оценка: ' .$rate_sum	 .'">
<div class="brand_stars" style="display:block; width:39px; height:39px; position:absolute; bottom:40px; left:168px; overflow:hidden; background:url(_include/pics/brand_stars.jpg);">
<div class="stars_tt" style="padding:16px 0 0 1px; font-weight:bold;">
'.$rate_sum .'
</div></div></a>';
}
?>

<div style="display:block; width:229px; height:14px; float:left; position:absolute; bottom:0px; left:1px; overflow:hidden;">

<?php if (!empty($row['isset_art']))	{	
echo '
<div class="light" style="display:block; width:53; height:14px; float:left; margin-left:1px;"> 
<a href=article.php?car=' .$row['car_id']	.'><img src="_include/pics/brand_obzor.jpg" width="53" height="14"></a>'; 
}	else	{echo '
<div style="display:block; width:53; height:14px; float:left; margin-left:1px;"> 
<img src="_include/pics/brand_empty.jpg" width="53" height="14">'; }?>
</div>

<div class="light" style="display:block; width:53; height:14px; float:left; margin-left:1px;"> 
<?php echo '<a href=portrait.php?car=' .$row['car_id']	?>><img src="_include/pics/brand_portrait.jpg" width="53" height="14"></a>
</div>

<?php 
	if (!empty($row['isset_tuv']))	{	
	echo '
<div class="light" style="display:block; width:53; height:14px; float:left; margin-left:1px;">
<a href=tuv.php?car=' .$row['car_id']	.'><img src="_include/pics/brand_tuv.jpg" width="53" height="14"></a>'; 
	}	else	{	
	echo '
<div style="display:block; width:53; height:14px; float:left; margin-left:1px;"> 
<img src="_include/pics/brand_empty.jpg" width="53" height="14">'; 
	}	?>
</div>

<?php 
	if (!empty($row['isset_experts'] ))		{	
	echo '
<div class="light" style="display:block; width:53; height:14px; float:left; margin-left:1px;"> 
<a href=expert.php?car=' .$row['car_id']	.'><img src="_include/pics/brand_expert.jpg" width="53" height="14"></a>'; 
	}	else	{	echo '
<div style="display:block; width:53; height:14px; float:left; margin-left:1px;"> 
<img src="_include/pics/brand_empty.jpg" width="53" height="14">'; 
	}	?>
</div>

</div></div></div>
<?php 	

$prev_model_name = $row['model'];

}	?>
 
</div>
</div><!--  end FULL COLUMN   --> 

<?php	
require_once('_include/templates/##bottom.php'); 
?>
        