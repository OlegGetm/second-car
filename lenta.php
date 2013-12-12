<?php
require_once('_include/functions/functions.php'); 

clean_get();															
$link = to_connect();

$q="SELECT 						letter_id 
		FROM 							letters
		WHERE  to_print = 		'1' 			";
$result = $link->query($q); 

$total_rows = $result->num_rows;								// общее кол-во заметок
$per_page  =10;															//  заметок на страницу
$num_pages=ceil($total_rows/$per_page);	    		// кол-во страниц

//if (isset($_GET['page'])) $page=($_GET['page']-1); // else $page=0;

$start=abs(($page-1)*$per_page);								//  первый оператор для LIMIT

$zapros = 	"SELECT l.letter_id, l.date, to_print, l.title, l.text, image_name, author_id,  
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
				  	LIMIT 							$start, $per_page "; 
$result = $link->query ($zapros);


$add_head = '
<script type="text/javascript" src="_include/js/index/forums.js"></script>
';

require_once('_include/templates/##top.php'); 
require_once('_include/templates/##left.php'); 
?>

<!--  ## FULL COLUMN   -->
<div id="allContent" style="padding-bottom:0; ">
<?php  require_once('_include/templates/inc.topic.php');  ?>


<!-- # common area   -->
<div style="display:block; width:870px; overflow:hidden;  background: url(_include/pics/d_grad_1.jpg) repeat-y;">

<!-- .......................... # left column   -->
<div style="display:block; width:610px; overflow:hidden; float:left;  padding-top:26px;">


<?php
while ($row = $result->fetch_assoc() )  {

if($row['showroom_type'] !== 'letter')		{    			//   отображать, если не из шоурума 
echo '
<div class="letter_block">
<div class="letter_title"><a href="letter.php?letter=' .$row['letter_id'] .'">' .$row['title'] .'</a></div>
';

$image = '_photos/letters/' .$row['date_prefix'] .'/' .$row['image_name'];
		if (!empty($row['image_name']) && file_exists($image))	{
			$size_img = getimagesize($image); 
			$ht =  intval( 580 / $size_img[0] *$size_img[1]);
			echo '
<div style="width:580px; height:' .$ht .'px; margin:0 0 0 5px; background:#ccc url(\'' .$image .'\') no-repeat;">
</div>';
		}

 
$paragraph =  explode ("\r\n", $row['text']); 
for ($i=0; $i<1; $i++)		{
	echo '
	<div class="letter_text">
	<a href="letter.php?letter=' .$row['letter_id'] .'">' .$paragraph[$i] .'</a>
	</div>';
	}
?>

<!--  линия с коммент -->
<div class="comm_block">
<a href="letter.php?letter=<?php 	echo $row['letter_id']; ?>"><p>ДАЛЬШЕ</p></a>
<?php  if($row['coms'] >0)	
	{  			
echo '
<a href="letter.php?letter=' .$row['letter_id'] .'#comments">
<div class="comm_booble"><span>' .$row['coms'] .'</span></div>
</a>'; 
	}  
?>
</div><!--  линия с коммент -->
</div><!--  letter_block -->

<?php	}	}      ?>


<!-- блок навигации -->
<div  style="display:block; width:570px; height:70px; position:relative;">

<?php
 $prev_page = $page -1;
 $next_page = $page +1;
 
  if($prev_page == 1)	{ 
  $prev_href = 'index.php'; 
  }	else	{	
  $prev_href = 'lenta.php?page=' .$prev_page ; 	}
 
 echo '<a href="' .$prev_href .'"><div class="btn_pages" style="left:14px">Назад</div></a>';
 
 if( $next_page <= $num_pages)		{
 echo '<a href="lenta.php?page=' .$next_page .'"><div class="btn_pages" style="right:20px;">Вперед</div></a>';
 }
?>
</div><!-- блок навигации -->

</div><!-- #  left column   -->


<!-- #   right column -->
<?php  include_once('_include/templates/#right_column.php');  ?>


</div><!-- #  common area   -->
<div style="clear:both;"></div>
</div><!--  ## full   --> 

<?php  require_once('_include/templates/##bottom.php');  ?>