<?php
require_once('_include/functions/functions.php');
require_once('_include/templates/##top.php');  
require_once('_include/templates/##left.php');

$_SESSION['right_menu'] = 'segment';

?>

<!--  FULL column ..................................................... -->
<div id="allContent" style="padding-bottom:400px; background:#fff;">

<?php 
////////////////////////////////////////////
$pic = 1;
$this_title = 'Одноклассники';
require_once('_include/templates/#dossier.php');
///////////////////////////////////////////

echo '
<div style="display:block; width:500px; height:100%; margin:30px 0 100px 140px; ">';

 $segment = $_SESSION['menu']['segment'];
 //$model = $_SESSION['menu']['model'];
 
 $link = to_connect();
 $zapros = "
 					SELECT 					c.car_id, c.brand, c.model, c.year1, c.year2,
													a.article_id           		as isset_art     
 					
					FROM 						cars c

					LEFT JOIN 				articles a                    
					USING 					(car_id)

					WHERE segment 	= 	'$segment' 

 					ORDER BY 					brand
					 					"; 
 $result = $link->query ($zapros);
 $count =$result->num_rows;


	 while($row = $result->fetch_assoc() )   {
		
		$lambda_years = $_SESSION['menu']['year1'] - $row['year1'];
		if($lambda_years <0) { $lambda_years = 0 - $lambda_years; }
		
		
		if ($row['brand'] !== $_SESSION['menu']['brand']   && $row['brand'] !== 'Alfa Romeo' &&  $lambda_years <4  ) 	{


		
	$img_name = '_photos/cars/micro/' .$row['car_id'] .'.jpg';
	if (!file_exists($img_name)) 	{ $img_name = '_include/pics/photo_grey.gif'; }
	
	$ahref =  !empty($row['isset_art']) ? 
																'article.php?car=' .$row['car_id']  :
																'portrait.php?car=' .$row['car_id'];

	if (!$row['year2']) 	{	
	$data = '/с ' .$row['year1'] .'-го/'; 
	} else  {
	$data = '/' .$row['year1'] .'–' .$row['year2'] .'/&nbsp;'; 
	}
?>
	
<div style="display:block;  width:468px; height:116px; position:relative; overflow:hidden; background: url('<?php echo $img_name; ?>') no-repeat;  border-top: 2px solid #eee;">

<div style="display:block; width:300px; height:120px; margin: 10px  0 0 160px;"> 
<a href=<?php echo $ahref; ?>>
<div class="art_titile">
<?php echo $row['brand'] .'&nbsp;' .$row['model']; ?>
</div>
<div class="index_2" style="margin: 0pt 8px 0pt 16px; font-size: 15px;">
<?php echo $data; ?>
</div>
</a>
</div>

<?php
echo '
</div>';
	}	}

?>


</div>

</div>

<?php 
require_once('_include/templates/##bottom.php');  ?>