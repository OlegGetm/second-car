<?php
session_start ();
if  (!isset($_SESSION['login_editor'])) { $url = 'Location: ../login.php';
	header ($url); 		}
include_once('../_common/functions.php');

$letter_id = (int)$_GET['letter_id'];
$link = to_connect();


//////////////																					///  фото к статье
$zapros = "SELECT *
 					FROM 						letters_images 
 					WHERE letter_id = 	'$letter_id'
					ORDER BY 				parag ";
$result = $link->query ($zapros); 

		while ($row = $result->fetch_assoc() )		{
				$images[$row['parag']] = array($row['name'], $row['width'], $row['height'], $row['text'], $row['letters_image_id']);
		}
//////////////	
$zapros = "	SELECT							*
					FROM		 						letters_videos 
					WHERE 		letter_id 	= '$letter_id'
					ORDER BY 						parag 
					";
$result = $link->query ($zapros); 

		while ($row = $result->fetch_assoc() )		{
				$videos[$row['parag']] = array($row['sourse'], $row['text'], $row['letters_video_id']);
		}	
		
//////////////			
$zapros = "SELECT  *,  	DATE_FORMAT(date, '%Y_%m') as date_prefix
				  FROM 			letters
				  WHERE 		letter_id = 	'$letter_id'
				  LIMIT 1			"; 
$result = $link->query ($zapros);
$row = $result->fetch_assoc();

$date_prefix  = $row['date_prefix'];

///////////////////////////////////////////////////////////
include_once('../_common/templates/##top.php');		
?>
<script type="text/javascript" src="../_common/ajax/letters/mediateka.js"></script>
<script type="text/javascript">
var letterID = "<?php echo $row['letter_id']; ?>";
var datePrefix = "<?php echo $date_prefix; ?>";
</script>


<div id="fullContent" style="margin:20px 0 0 90px; padding-bottom:1200px;">
<!-- BOX 1  -->
<?php
$table_width =680;
include_once('../_common/templates/inc.table_top_white.php');  ?>

<div  style="margin:0px 6px 0 8px;  background:#fff;">

<div id="main_div"  style="position:relative; padding:30px 50px 70px 40px; font:14px helvetica,arial,sans-serif; ">
  <div style="display:block; position:absolute; top:10px; right:20px;  cursor:pointer; text-decoration:underline;"  onclick="javascript:history.back();">Назад</div>


<div  style="font:bold 26px helvetica,arial,sans-serif; letter-spacing:-0.05em; color:#333; margin:0 0 50px 10px;"><?php echo $row['title']; ?></div>

<?php
$ratio = 0.6;

$pars =  explode ("\r\n", $row['text']); 

foreach($pars as $key=>$txt)   {
echo  '
<div id="' .$key .'" class="overme" style="text-indent:30px; padding:0 0 34px 0;">' .$txt .'</div>
';

		if (isset($images[$key]))		{		//  фотографии и видео
		echo '
<a name="' .$key .'"></a>					
<div style="display:block; width:'  .intval($images[$key][1]*$ratio) .'px; position:relative;  background:#e3e3e3; margin:10px 0 20px 0; padding:0 0 10px 0;">
		<div class="delete_image" id="deletePhoto_' .$images[$key][4] .'"  style="display:block; position:absolute; top:2px; right:2px; width:32px; height:32px; background: url(../_common/img/delete_32.png)  no-repeat; cursor:pointer; z-index:2;"></div>

		<img src=\'../../_photos/letters/' .$date_prefix .'/' .$images[$key][0] .'\'  width=\''  .intval($images[$key][1]*$ratio) .'\' height=\'' .intval($images[$key][2]*$ratio) .'\'>
		
		<div class="textSubscribe" id="textPhoto_' .$images[$key][4] .'" style="width:'  .($images[$key][1]*$ratio -20) .'px; padding:14px 10px; background:#e3e3e3;  font: bold 12px Tahoma, sans-serif; cursor:pointer">' .$images[$key][3] .'</div>
	
</div>	
	';	
		}


		if (isset($videos[$key]))		{		 echo '
<div style="width:600px; overflow:hidden; position:relative; margin:10px 0 20px 0px; z-index:0">
	<div class="delete_video" id="deleteVideo_' .$videos[$key][2] .'"  style="display:block; position:absolute; top:2px; right:0px; width:32px; height:32px; background: url(../_common/img/delete_32.png)  no-repeat; cursor:pointer; ;"></div>
	
	<div>' .$videos[$key][0] .'</div>

	<div class="textSubscribe" id="textVideo_' .$videos[$key][2] .'" style="width:500px; padding:14px 10px; background:#e3e3e3;  font: bold 12px Tahoma, sans-serif; cursor:pointer">' .$videos[$key][1] .'</div>

</div>
';	
		}

}

?>

</div>
</div>	

</div>
<?php include_once('../_common/templates/##bottom.php');  ?>