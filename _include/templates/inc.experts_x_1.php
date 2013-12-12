<div class="letter_block">
<div class="letter_title" >Мнение экспертов</div>

<div style="display:block; width:570px; height:290px; position:relative; ">
	  
      <div id="vlevo"	style="display:block; width:33px; height:61px;  position:absolute; top:80px; left:570px; background: url(_include/pics/row-left.png) no-repeat bottom; cursor:pointer;"></div>
      <div id="vpravo"	style="display:block; width:33px; height:61px;  position:absolute; top:20px; left:570px; background: url(_include/pics/row-right.png) no-repeat bottom; cursor:pointer;"></div>

   <div style="display:block; width:550px; height:242px; overflow:hidden; position:absolute; border:1px dashed #ccc; margin:0 0 0 4px;">      
		<div id="slider">
    		<ul>				


<?php
 $q2 = "SELECT * 
 			FROM 							expert_letters
			LEFT JOIN 					cars 
			USING 						(car_id)
 			ORDER BY RAND()
			LIMIT 6  "; 
 $res2 = $link->query ($q2);
 
 
for ($i=0; $i<6; $i++) 	  {
 	
		$r2 = $res2->fetch_assoc();
		$photo_src = '_photos/cars/mini/' .$r2['car_id'] .'.jpg';
		if (!file_exists($photo_src)) { $photo_src = '_include/pics/no_photo_auto.jpg'; } 

echo '<li>

<a href=expert.php?car=' .$r2['car_id'] .'#' .$r2['expert_id'] .'>
<div style="display:block; width:280px; height:210px; position:relative; float:left; margin:0 10px 10px 0; overflow:hidden;  background:#fbfbfb url(\'' .$photo_src .'\') no-repeat left;">
<div class="back_1"><h5>' . $r2['brand'] .' ' .$r2['model'] .'</h5></div>
<div class="front_1"><h5>' . $r2['brand'] .' ' .$r2['model'] .'</h5></div>
 </div></a>';

		$text_limit = mb_substr($r2['text'], 0, 280,  'utf-8');
		echo '
<div style="display:block;  padding:10px 10px 0 0; text-indent:30px;">
<a href=expert.php?car=' .$r2['car_id'] .'#' .$r2['expert_id'] .'><div class="news_2" style="font-size:14px;">' .$text_limit .'......
<p style="margin:18px 0 0 10px;color:#999; font-weight:bold; font-size:12px; text-decoration:underline;">ДАЛЬШЕ</p>
</div>
</a>
</div>

</li>
';
  } ?>

        </ul>
        <div style="clear:both;"></div>
	</div>
    </div>

</div>
