<?php
session_start ();
	if  (!isset($_SESSION['login_editor'])) 		{ 
	$url = 'Location: ../login.php';
	header ($url); 		}
	
$_SESSION['editor'] = 'replics';
include_once('../_common/functions.php'); 
include_once('../_common/templates/##top.php');

$article_id =  	(int)$_GET['article_id'];
$replica_id =  	(int)$_GET['replica_id'];

$link = to_connect();


//  Вытаскиваем реплики			
$zapros = 	"SELECT    						*
					 FROM 							replics
					 WHERE 	article_id =  		'$article_id'
					 AND 		append_to = 	't'
					 ORDER BY						date, number  ";

$result = $link->query ($zapros); 
$num = $result->num_rows;	
		
		while ($row = $result->fetch_assoc())	{
		++$count;
		$ar_1[$row['number']][] = array($row['name'], $row['text'], $row['replica_id'], $row['interest'], $count);
		 }	

///$last_replica = $ar_1[$num-1][3];   // номер самой последней реплики

$zapros = "SELECT    						*
					 FROM 							articles
 					 INNER JOIN 					cars
					 USING							(car_id)
					 WHERE article_id =  		'$article_id'			";

$result = $link->query ($zapros); 
$row = $result->fetch_assoc();

?>
<script type="text/javascript">var idR = '';</script>
<script type="text/javascript">
function prevReplica(num)		{
	var numBefore =  'a' +num;
	if ($('#' +numBefore).length > 0)	{
		var idNumBefore = document.getElementById(numBefore);
		idNumBefore.scrollIntoView();
		window.scrollBy(-300, 0);
	}
}
</script>

<script type="text/javascript" src="../_common/ajax/common.js"></script>
<script type="text/javascript" src="../_common/ajax/replicator/edit.js"></script>

<div id="fullContent" style="margin:20px 0 0 40px;">

<!-- BOX 1  -->
<?php
$table_width =890;
include_once('../_common/templates/inc.table_top_white.php');  

echo '
<div  style="margin:0px 6px 0 8px;  background:#fff;">';

$img = '../../_photos/cars/micro/' .$row['car_id'] .'.jpg'; 
if (file_exists($img))   	{  	echo '
<img  style="display:block; float:left; width:170px; height:120px; margin:20px 0 0 24px; padding:4px; border:1px solid #ddd;" src ="' .$img .'" width="146"  height="110">';
}   

echo '
<div style="display:block; float:left; width:370px; height:100px; color:#727272; font:bold 18px helvetica,sans-serif; margin:20px 0px 0px 50px;">'
.$row['brand'] .' ' .$row['model'] .'&nbsp;&nbsp; /' .$row['year1'] .'–' .$row['year2'] .'/</div>
<div style="clear:both;"></div>';
?>

<table cellspacing="0" cellpadding="0" style="width:830px; padding:0px 0 70px 10px;">
<tr>
<td style=""><img src="../_common/img/zero.gif" width="320" height="1"></td>
<td><img src="../_common/img/zero.gif" width="532" height="1"></td>
</tr>

<?php
$prev_replica = 0;

$text = ($row['text']);
$pars =  explode ("\r\n", $text); 								// Разбивка  на абзацы 

foreach($pars as $k=>$txt) 	{


	if (isset($ar_1[$k])) 		{
	echo '
<tr ' .$style_raw .'>
<td valign="top"  style="border-top: 4px solid #ccc; padding:20px 0;">		
						
<textarea id="' .$k .'"  style=" height:380px; width:290px; overflow:auto;  font:15px Arial, sans-serif; margin-top:4px; padding:10px; background:#f3f3f3; border:0;">' .
$txt .'
</textarea>
<div style="margin:2px 0 10px 4px;">
<input type="button" onclick="editedArticle(' .$article_id .', ' .$k .');" value="Править" style="cursor:pointer;">
<input type="button"  onclick="javascript:history.back();" value="Назад" style="margin-left:10px; cursor:pointer;">
</div>
</td>';

echo '
<td valign="top"  style="border-top: 4px solid #ccc; padding:20px 0;">';
	
		foreach($ar_1[$k] as $val)	{																//   реплики
		list ($a1, $a2, $a3, $a4, $a5)	= $val;	
								
				if ($a4 == "yes") 				{ $colorback = "background-color: #eddbdb;";  }
		else if ($a4 == "no") 				{ $colorback = "background-color: #ccc;";     }
		else if ($a4 == "edit") 				{ $colorback = "background-color: #d6e2f2;"; }
		else											{ $colorback = "background-color: #f3f3f3;"; }
		
		if ($a3 == $replica_id) 	{ $border = " border:4px solid #FDC8A6;"; 		// если  свежая реплика
		}	else								{ $border = " border:1px solid #ccc;";		   }	
?>

<a name="<?php echo $a3; ?>"></a>
<a name="bookmark<?php echo $a5; ?>"></a>
<div id="a<?php echo $a3; ?>" class="repl_1" style=" <?php  echo $colorback .$border;  ?>">
<div class="repl_2"><?php echo $a1;  ?></div>
<div id="b<?php echo $a3; ?>" class="repl_4" onclick="changeToInput('<?php echo $a3; ?>')" ><?php echo $a2; ?></div>
<div id="c<?php echo $a3; ?>"></div>

<div id="d<?php echo $a3; ?>" class="repl_3">
<form>
<span style="margin-left:10px;"><input type="radio" name="interest" value="yes"  <?php if($a4=='yes') echo 'checked'; ?> onclick="setStatus('<?php echo $a3; ?>', 'yes')" />&nbsp;Интересно </span>

<span style="margin-left:20px;"><input type="radio" name="interest" value="no"  <?php if($a4=='no') echo 'checked'; ?> onclick="setStatus('<?php echo $a3; ?>', 'no')" />&nbsp;Так себе</span>

<span style="margin-left:20px;"><input type="radio" name="interest" value="edit"  <?php if($a4=='edit') echo 'checked'; ?> onclick="setStatus('<?php echo $a3; ?>', 'edit')" />&nbsp;Добавлено в статью</span>

<span style="margin-left:60px; cursor:pointer;" onclick="deleteRaw('<?php echo $a3; ?>')">Удалить</span>

<a href="#bookmark<?php echo ($a5-1); ?>">
<img style="margin:0px 0 0 10px; cursor:pointer;"  src="../_common/img/row_down.jpg" width="15" height="16"></a>
</form>
</div></div>
<?php 	

} 	

echo '</td></tr>';
	
}	else		{  	continue; 	}	

}	
?>  
</table>
</div>	
<?php include_once('../_common/templates/inc.table_bottom_white.php'); ?> <!-- BOX 1  -->
<body onLoad="javascript:location.href='#<?php echo $replica_id; ?>'" >
</div>
<?php include_once('../_common/templates/##bottom.php');  ?>