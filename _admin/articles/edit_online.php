<?php
session_start ();

	if  (!isset($_SESSION['login_editor'])) 		{ 
	$url = 'Location: ../login.php';
	header ($url); 		}
	
$_SESSION['editor'] = 'article';
include_once('../_common/functions.php'); 
include_once('../_common/templates/##top.php');

$article_id = $_GET['article_id'];

$link = to_connect();
//  обзор на параграфы
$zapros = "SELECT text
 					FROM articles 
					WHERE article_id = '$article_id' ";
$result = $link->query ($zapros);   
$row = $result->fetch_assoc();
$text = ($row['text']);
$paragraph =  explode ("\r\n", $text); // Разбивка текста на абзацы (получается массив)
$num_parag = count($paragraph);


?>
<script type="text/javascript">var idR = '';</script>
<script type="text/javascript" src="../_common/ajax/common.js"></script>
<script type="text/javascript" src="../_common/ajax/replicator/edit.js"></script>

<div id="fullContent" style="background-image:url(../_common/img/background_bw.jpg); ">
<div style="padding: 20px 0 0 30px; min-height:900px;">

<table width="860" cellspacing="0" cellpadding="0">

<?php
$bb = 0;

for ($i=0; $i<$num_parag; $i++)		{
	
	$str1 = substr ($paragraph[$i], 0, 4);	
	
				if ( is_int($bb/2) )      			// чересстрочный цвет
								{ $style_raw = 'style="background:#f0f0f0; "'; 
				}	else		{ $style_raw = 'style="background:#dadada; "';  }
	
	echo '
<tr ' .$style_raw .'>
<td valign="top">';
				if ($str1 == '<h4>')		{	// Не высвечиваем заголовки
				echo '<div style="margin:10px 0 10px 10px;">' .$paragraph[$i] .'</div>'; 
				}	else				{	
echo '						
<textarea id="' .$i .'"  style="width:600px;  height:240px; overflow:auto;  font: bold 12pt  Arial, sans-serif; margin-top:4px; padding:10px;">' .
$paragraph[$i] .'
</textarea>';
				}
echo '</td>';

$border = '';
echo '
<td valign="top">';
if ($str1 !== '<h4>')
echo '<input type="button" style="margin:20px 90px 0 0px; padding:0;" onclick="editedArticle(' .$article_id .', ' .$i .');" value="Править">';
echo '</td>
</tr>';
++$bb;
	
}	
?>  

</table>
</div></div>

<body onLoad="javascript:location.href='#<?php echo $a4; ?>'" >

<?php
 include_once('../_common/templates/##bottom.php');
?>
        
