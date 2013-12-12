<?php
session_start ();
require_once('_include/functions/functions.php');
$link = to_connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST')  {   //////// ЗАПИСЬ НОВОГО ПОСТА

$topic_id = (int)$_POST['topic_id'];

$_POST['author'] 	= tipografica ($_POST['author']);  		
$_POST['title'] 			= tipografica ($_POST['title']);                
$_POST['message'] = tipografica ($_POST['message']);  

clean_post();  	


																		
if(strlen($quote)>0)	{																	//добавить цитату, если есть

		$quote = str_replace('<p>', '', $quote);
		$quote = str_replace('</p>', '\\r\\n', $quote);
			$quote = str_replace('<div class="quote_1">', '', $quote);  // убрать форматирование вложенных цитат
			$quote = str_replace('</div>', '', $quote); 							// убрать форматирование вложенных цитат
		
		$message = '<span class="cite_1">' .$quote_author .' написал(а):</span>\\r\\n[quote]' .$quote .'[\/quote]\\r\\n' .$message;
}


   if(check_badwords($title) && check_badwords($author) && check_badwords($message) && strlen($title)>5  && strlen($message)>5 ) 	{
					   

						$zapros = "INSERT into forum_posts 
										(topic_id,  author, message, date )
										VALUES 
										('$topic_id', '$author', '$message', NOW()) ";
						$result = $link->query ($zapros);

						$zapros = "UPDATE forum_topics 
										 SET
										 number_posts  = number_posts +1,
										 last_author = '$author',
										 last_post_id = LAST_INSERT_ID(),
										 last_date =  NOW()
										 WHERE topic_id  = '$topic_id' ";
						$result = $link->query ($zapros);
						}	
						
$urls =	$_SERVER['HTTP_REFERER'];
header("location: $urls");

}		else   	{														///////////////////// 	ПОКАЗ СТРАНИЦЫ

$topic_id 	= (int)$_GET['topic'];


$zapros = "SELECT title, car_id
 				  FROM 	forum_topics 
 				  WHERE topic_id = '$topic_id'
				  LIMIT 1";
$result = $link->query ($zapros); 


		$row = $result->fetch_assoc();
		$car_id = $row['car_id'];
		
		$title_first = $row['title'];
		
		$title =substr($title_first, 0,90) ;
		if(strlen($title_first)>90)  {   $title .= '...';  }
		
////////////////////////////////////////////////////////////////


$add_head = '<script type="text/javascript" src="_include/js/forums/forum_posts.js"></script>
';

require_once('_include/templates/##top.php');  
require_once('_include/templates/##left.php');

$_SESSION['right_menu'] = 'forums';
?>

<!--  FULL column ............................. -->
<div id="allContent" style="background-color:#fff;">
<?php 

////////////////////////////////////////////
$this_title = 'Форум';
require_once('_include/templates/#dossier.php');
///////////////////////////////////////////


echo '
<div class="posts_title" style="padding:20px 0 0px 70px;"><span style="text-decoration:underline;"><a href=forum_topics.php?car=' .$car_id .'>Все темы</a></span>  -> ' .$title	.'</div>


<div style="padding:30px 2px 0px 70px;">

<a name="top"></a>';

if(strlen($topic_id))	{
$zapros = "SELECT 				*
 				  FROM 					forum_posts  f
 				  WHERE topic_id = '$topic_id'
				  ORDER 				by  f.date
				 ";
$result = $link->query ($zapros); 



 while ($row = $result->fetch_assoc() )		{
	$posts[$row['level']][$row['post_id']] = array($row['post_id'], $row['level'], $row['parent_id'], $row['message'], $row['author'], $row['date']);
 }	
 
 function walk_posts($ar)	{
 
	for ($n = 1; $n<4; $n++)		{
			

								foreach($ar[$n] as $v )	{
									echo '<div style="width:400px; margin:10px 10px 10px ' .(60*$n) .'px; padding:10px; background:#f4f4f4;">';
									echo $v[3] .'.......... ' .$v[1] .'.......... ' .$ar[1][99][4]  ;
									echo '</div>';
									
											if($v[0] == $ar[2][$v[2]] )	{
												echo '<div style="width:400px; margin:10px 10px 10px ' .(60*$n) .'px; padding:10px; background:#ccc;">22222222222';
												//echo $ar[($n+1)][$v[3]] ;
												echo '</div>';	
												
											}
									
								}
	
			 
	 }
 }
 
 walk_posts($posts);
 ///////////////////////////
$result = $link->query ($zapros); 



while ($row = $result->fetch_assoc() )	  {
$print_date = strftime("%d.%m.%Y в %H:%M", strtotime($row['date']));


echo '
<a name="' .$row['id_post'] .'"></a>
<div class="post_warp"';
 if($row['level'] =='0')	{ echo ' style="border:3px solid #ddd; font-weight;bold; margin:0px 0px 24px 0px;"';	 }
 echo '>

<div class="post_name" id="author_' .$row['post_id'] .'">' .$row['author'] .',
<span class="post_date">' .$print_date .'</span>
</div>
<div id="message_' .$row['post_id'] .'" class="posts_message" style="padding:10px 14px 20px 12px; color:#484848;">';

$pars =  explode ("\r\n", $row['message']);						// Разбивка  на абзацы
	foreach ($pars as $txt)		{ 
			echo '
			<p>' .$txt .'</p>
			';
	}
echo '
</div>

<div style=" position:absolute; bottom:7px; right:20px; padding:2px 3px; background:#C8C8C8; color:#fff; font-size:13px; cursor:pointer;" onclick="showFormDown(\'' .((int)$row['level'] +1) .'\', \'' .$row['post_id'] .'\');">
Ответить
</div>

				
</div>
<div style="clear:both;"></div>';
 }
echo '</div>';
}   ?>
<!-- button-form area -->
<div style="display:block; height:750px; padding:20px 0 0 80px; border-top:2px solid #fff;">
<a name="bottom"></a>
<div id="button_1" onclick="showForm();" style="font: 14px  Arial, sans-serif; color:#727272; text-decoration:underline; margin:20px 0 0 10px; cursor:pointer;">Ответить</div>

<?php
	// if($show_form !== 'yes')   
	// {    /// если не вошел под логином, дать форму логина	
	// require_once('_include/templates/form_login.php');
    // 	}	else   {    /// если залогинен, дать форму отправки нового сообщения		?>

<div id="a6" style="display:none; width:470px; margin-top:20px; padding:15px; background-color:#ccc; border:0px solid #ccc;">
<form name="myform" action="<?php echo $_SERVER['PHP_SELF'] .'?id_topic=' .$id_topic .'#top'; ?>" method="post">

<div id="quote_block"  style="display:none;">
<div style="padding:0px 0 4px 0px; font-weight:bold; color:#7c7c7c;">Цитата:</div>
<textarea id="quote_text" style=" width:440px; height:100px; border-style:none; font:14px Arial, sans-serif; text-indent::20px; padding:6px; background-color:#ffffcc;"  name="quote"></textarea>
</div>

<div style="padding:10px 0 4px 0px; font-weight:bold; color:#7c7c7c;">Ваше имя:</div>
<input  id="user_name" style="width:440px; height:22px;  font:bold 16px Arial, sans-serif; padding:2px; margin-bottom:20px;"  type="text" name="author" maxlength="79">


<div  style="padding:0px 0 4px 0px; font-weight:bold; color:#7c7c7c;">Текст сообщения:</div>
<textarea id="user_text" style=" width:440px; height:200px; font:bold 16px Arial, sans-serif; padding:4px;"  name="message"></textarea>

<input  type="submit" onclick="submitForm();" style="margin-top:30px; padding:0 6px; font-weight:bold;" value="OK"/>
<input  type="button"  onclick="hideForm();" style="margin-left:20px; padding:0 4px; " value="Отмена"/>

<input  type="hidden" name="title" value="<?php echo $title_first; ?>" />
<input  type="hidden" name="topic_id" value="<?php echo $topic_id; ?>" />

<input  type="hidden" name="level" id="input_level" value="0" />
<input  type="hidden" name="parent_id" id="input_parentID" value="0"  />

</form>
</div>
<!-- end button-form area --></div>
<?php 	// }	
echo '
</div>';
						// добавить в топик кол-во прочтений
						$zapros = "UPDATE forum_topics 
										 SET
										 number_readers  = number_readers +1
										 WHERE id_topic  = '$id_topic' ";
						$result = $link->query ($zapros);
					
require_once('_include/templates/##bottom.php'); 
 }  ?>