
<div style="display:block; position:relative; width:864px; margin:0px 3px 30px 3px; background-color:#f4f4f4; border-top:0px solid #c3c3c3; border-bottom:1px solid #ececec;">
      		<div id="vlevo"	style="display:block; width:33px; height:61px;  position:absolute; top:150px; right:40px; background: url(_include/pics/row-left.png) no-repeat bottom; cursor:pointer;"></div>
            <div id="vpravo"	style="display:block; width:33px; height:61px;  position:absolute; top:90px; right:40px; background: url(_include/pics/row-right.png) no-repeat bottom; cursor:pointer; "></div>
      
<div class="letter_title" style="padding:10px 0 20px 8px;">Мнение экспертов</div>


   <div style="display:block; width:754px;  height:330px; overflow:hidden;">      
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
		$photo_src = '_photos/cars/micro/' .$r2['car_id'] .'.jpg';
		if (!file_exists($photo_src)) { $photo_src = '_include/pics/no_photo_auto.jpg'; } 

echo '<li>
 <div style="display:block; width:310px; height:280px; padding:16px 20px; overflow:hidden; background:#fff; border:1px dashed #ccc; margin-right:14px; float:left;">'; 	
		 
		//  блок с фото
		echo '
<a href=expert.php?car=' .$r2['car_id'] .'><div style="display:block; width:310px; height:110px; overflow:hidden;  background:#fbfbfb url(\'' .$photo_src .'\') no-repeat left;"><div class="link1" style="color:#727272; font-size:16px; padding:20px 0 0 160px;">
 ' . $r2['brand'] .' ' .$r2['model'] .'&nbsp;</div></div></a>';
		//  блок с текстом
		$text_limit = mb_substr($r2['text'], 0,300,  'utf-8'); // текст сокращенный
		echo '
<div style="display:block; margin:20px 0 0 0;">
<a href=expert.php?car=' .$r2['car_id'] .'><div class="news_2" style="font-size:12px;">' .$text_limit .'......<div style="margin:16px 0 0 10px; font-weight:bold; color:#727272;">Дальше</div></div></a>
</div>

</div>
</li>
';
  } ?>

        </ul>
        <div style="clear:both;"></div>
	</div>

</div>
</div>