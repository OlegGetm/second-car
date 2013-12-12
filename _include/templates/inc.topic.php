<!--  # Top Stories   -->

<?php
if( substr($_SERVER['PHP_SELF'], -9) == 'index.php')    {
$bgr = ' background-color:#c6c4c5;';	}  
else if( (substr($_SERVER['PHP_SELF'], -10) == 'letter.php' ||
			substr($_SERVER['PHP_SELF'], -15) == 'article_tuv.php' ) 	)    {
$bgr =' background: url(_include/pics/d_grad_7.jpg) repeat-x;';	}  

else if( substr($_SERVER['PHP_SELF'], -9) == 'lenta.php')    {
$bgr =' background:#ededed url(_include/pics/d_grad_1.jpg) repeat-y;';	}  

else  { $bgr =' background:#e6e6e6;'; }

echo '
<div style="display:block; width:850px; height:119px; padding:0 0 0px 20px; overflow:hidden;' .$bgr .'">';

$link = to_connect();

		$q = "SELECT  * 
				  FROM showroom
				  WHERE area =  'topic'
				  ORDER BY pos
				  LIMIT 4"; 

$res = $link->query ($q);

for ($i=0; $i<4; $i++) 	 {
$r = $res->fetch_assoc();

if($i == 0)		{$left_px =44;  }  else {$left_px =10;  }

echo '
<div style="display:block; position:relative; width:207px; height:117px; overflow:hidden; float:left; margin: 0 5px 0 0; background: url(_include/pics/topic.png) no-repeat;">

<a href="' .$r['url'] .'"><div class="link5" style="position:absolute; top:12px; left:' .$left_px .'px; padding:0 4px 0 0;">'.$r['title'] .'
</div></a>

<div class="link1" style="position:absolute; bottom:14px; right:14px; font-size:15px; color:#e6e6e6; ">'
.$r['subtitle'] .'</div>

</div>';
}
?>

</div><!--  # Top Stories   -->
<div style="clear:both;"></div>
