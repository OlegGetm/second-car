<?php
session_start ();
if  (!isset($_SESSION['login_editor'])) { $url = 'Location: ../login.php';
	header ($url); 		}
include_once('../_common/functions.php');

$topic_id = $_GET['topic_id'];

$link = to_connect();

			$zapros = "SELECT 					* 
							  FROM 						forum_topics
							  LEFT JOIN 				cars
							  USING 						(car_id)	 
							  WHERE topic_id = 	'$topic_id'
							  LIMIT 						1    ";
            $result = $link->query ($zapros);
     		$row = $result->fetch_assoc();
			
			$car_id = $row['car_id'];
			$brand = $row['brand'];
			$model = $row['model'];
			$year1 = $row['year1'];
			$title = $row['title'];
			
			$zapros = "SELECT 					* 
							  FROM 						forum_posts 
							  WHERE topic_id = 	'$topic_id'
							  ORDER BY 				date DESC ";
            $result = $link->query ($zapros);
			

$add_head = '<script type="text/javascript" src="+fc_edit.js"></script>
<style type="text/css">
.temp_textarea {   
	font:14px Arial,sans-serif;
	overflow-y: auto;
	border-style: none;
}
</style>
';

include_once('../_common/templates/##top.php');
?>

<div id="fullContent" style="margin:20px 0 0 100px;">

<!-- BOX 1  -->

<?php
$table_width =730;
include_once('../_common/templates/inc.table_top_white.php');  ?>

<div  style="margin:0px 6px 0 8px;  background:#fff;">
<div  style="padding:0px 0 340px 70px;  background:#fff;">


<div class="delete_topic" id="topic_<?php echo $topic_id; ?>"  style="text-align:right; padding:20px 50px 0px 0px; font:bold 15px Arial, Helvetica, sans-serif; color:#903; text-decoration:underline; cursor:pointer;">Удалить всю тему</div>

<?php
$img = '../../_photos/cars/micro/' .$car_id .'.jpg'; 
if (file_exists($img))   	{  	echo '
<img  style="display:block; float:left; width:170px; height:120px; margin:20px 0 0 0; padding:4px; border:1px solid #ddd;" src ="' .$img .'" width="146"  height="110">';
}   
echo '
<div style="display:block; float:left; width:370px; height:100px; color:#727272; font:bold 18px helvetica,sans-serif; margin:20px 0px 0px 20px;">'
.$brand .' ' .$model .'&nbsp;&nbsp; /' .$year1 .'– /
<div style="color:#727272; font:italic bold 16px helvetica,sans-serif; margin:20px 0px 0px 0px; text-decoration:none;">"'
.$title .'"</div>
</div>
<div style="clear:both;"></div>';
?>

<?php
while ($row = $result->fetch_assoc() )	  {

echo '
<div id="row_' .$row['post_id'] .'" style="width:600px; background-color:#f6f6f6; margin:20px 0 0px 0px;   border:1px solid #ccc;">
<div style="padding:10px 20px 0 20px; font: bold 14px Arial,sans-serif; color:#ccc;">'  .$row['author'] .'</div>
<div class="text_edit" id="' .$row['post_id'] .'" style="padding:10px 20px 20px 20px; line-height:16px; font:14px Arial,sans-serif;">';

		$pars =  explode ("\r\n", $row['message']); 
		foreach($pars as $txt)		{
		echo $txt .'<br>';
		}
echo '
</div>
</div>';
 }
 
 echo '
</div></div>';
 include_once('../_common/templates/inc.table_bottom_white.php'); ?> <!-- BOX 1  -->

 <div style="clear:both;"></div>
</div>
<?php include_once('../_common/templates/##bottom.php');  ?>