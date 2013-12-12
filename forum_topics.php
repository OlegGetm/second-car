<?php
require_once('_include/functions/functions.php');
clean_get();							

$link = to_connect();
$car_id = (int)$_GET['car'];

if ($_SERVER['REQUEST_METHOD'] == 'POST')  {   				// обработка  новых сообщений
session_start ();


$_POST['author'] 		= tipografica ($_POST['author']);  
$_POST['title'] 				= tipografica ($_POST['title']);                
$_POST['message'] 	= tipografica ($_POST['message']);  

clean_post();  
$car_id = (int)$_POST['car'];


   if(check_badwords($title) && check_badwords($author) && check_badwords($message) && strlen($title)>5  && strlen($message)>5 && strlen($car_id) ) 	{
   
						$zapros = "INSERT into forum_topics
										(date, car_id,  title, author, last_author, last_date)
										VALUES 
										(NOW(), '$car_id', '$title', '$author', '$author', NOW()) ";
						$result = $link->query ($zapros);

						$zapros = "INSERT into forum_posts 
										(topic_id, level, author, message, date )
										VALUES 
										(LAST_INSERT_ID(), '0', '$author', '$message', NOW()) ";
						$result = $link->query ($zapros);
						}

$urls =	$_SERVER['HTTP_REFERER'];
header("location: $urls");

}		else   	{			///////////////////////////////////// 	ПОКАЗ СТРАНИЦЫ

require_once('_include/templates/##top.php');  
require_once('_include/templates/##left.php');
$_SESSION['right_menu'] = 'forums';



?>
<!--  FULL column ............................. -->
<div id="allContent" style="height:100%; min-height:1280px; background-color:#fff;">

<?php 
$show_form = '';	
if  (isset($_SESSION['login_user'])) { $show_form = 'yes'; }  ?>

<script type="text/javascript">
function showForm()  {
$("#button_1").fadeOut(100, function(){$("#a6").fadeIn(800)} );	}
function hideForm()  {
$("#a6").fadeOut("slow", function(){$("#button_1").fadeIn(1000)} );	}
</script>

<?php  
$zapros = "SELECT 	topic_id, title, author, hide, date, number_posts, number_readers, last_author, last_post_id, last_date
 				  FROM 		forum_topics 
 				   WHERE car_id = 		'$car_id' 	
				  ORDER 	by last_date DESC ";
 						
  		$result = $link->query ($zapros);  
	

////////////////////////////////////////////
$this_title = 'Форум';
require_once('_include/templates/#dossier.php');
///////////////////////////////////////////

$brand = $_SESSION['menu']['brand'];

if ($result)	{
echo '

<div style="display:block; width:826px; padding:4px 0; margin:50px 0 0px 4px; background-color:#ccc; color:#f7f7f7; font-weight:bold;">
<div style="width:496px; 	float:left; text-align: center; border-right:1px solid #fff;">Темы</div>
<div style="width:82px; 	float:left; text-align: center; border-right:1px solid #fff;">Ответов</div>
<div style="width:82px; 	float:left; 	text-align: center; border-right:1px solid #fff;">Просм.</div>
<div style="width:160px; float:left; text-align: center;">Последн.</div>
<div style="clear:both;"></div>
</div>

<div style="display:block; width:820px; padding:20px 0px 20px 10px; background-color:#f7f7f7;">

';

$color_i = 0;

while(list($topic_id, $title, $author, $hide, $date, $number_posts, $number_readers, $last_author, $last_post_id, $last_date) = $result->fetch_row())		{


echo '
<div style="display:block; width:820px; height:40px; overflow:hidden; border-bottom:1px solid #d6d6d6; padding:1px 0; ">

<div class="topics"><a href=forum_posts.php?car=' .$car_id .'&amp;topic=' .$topic_id .'>'

.substr($title, 0,62) ;
if(strlen($title)>62) echo '...';

echo '
</a></div>

<div class="border_1"></div>
<div class="topics_numb">'
.$number_posts .'
</div>

<div class="border_1"></div>
<div class="topics_numb">'
.$number_readers .'
</div>

<div class="border_1"></div>

<div class="topics_date">
<div style="font:11px Verdana,Arial,Helvetica,sans-serif; font-weight:bold; color:#787c86;">'
.$last_author .'&nbsp;
<a href=forum_posts.php?topic=' .$topic_id .'#' .$last_post_id .'
<img src="_include/pics/forum_latest.gif" width="18" height="9">
</a>
</div>

<div style="padding-top:5px; font:10px Arial,sans-serif;">' .
strftime("%d.%m.%Y в %H:%M", strtotime($last_date))	  .'
</div>
</div>

<div style="clear:both;"></div>
</div>';
++ $color_i ;
 }
echo '
</div>';
}  ?>


<!-- button-form area -->
<div style="display:block; height:490px; padding:20px 0 0 30px; border-top:2px solid #fff;">
<div id="button_1" onclick="showForm();" style="font:14px  Arial, sans-serif; color:#727272; text-decoration:underline; margin:20px 0 0 10px; cursor:pointer;">Добавить тему</div>

<?php 
// if($show_form !== 'yes')   {    /// если не вошел под логином, дать форму логина		
// require_once('_include/templates/form_login.php');

// }	else   {    /// если залогинен, дать форму отправки нового сообщения		
?>

<div id="a6" style="display:none; width:470px; margin-top:20px; padding:15px; background-color: #ccc; border:0px solid #ccc;">
<form name="myform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">


<div style="padding:0px 0 4px 0px; font-weight:bold; color:#fff;">Ваше имя:</div>
<input  style="width:440px; height:22px;  font:bold 16px Arial, sans-serif; padding:2px; margin-bottom:20px;"  type="text" name="author" maxlength="79">

<div style="padding:0px 0 4px 0px; font-weight:bold; color:#fff;">Название темы:</div>
<input  style="width:440px; height:22px;  font:bold 16px Arial, sans-serif; padding:2px; margin-bottom:20px;"  type="text" name="title" maxlength="79">

<div style="padding:0px 0 4px 0px; font-weight:bold; color:#fff;">Текст:</div>
<textarea style=" width:440px; height:200px; font:bold 16px Arial, sans-serif; padding:2px;"  name="message"></textarea>

<input  type="submit" style="margin-top:30px; padding:0 6px; font-weight:bold;" value="OK"/>
<input  type="button"  onclick="hideForm();" style="margin-left:20px; padding:0 4px; " value="Отмена"/>
<input 	type="hidden" name="car" value="<?php echo $car_id; ?>" />

</form>
</div>
<!-- end button-form area --></div>
<?php 	// }		  ?>

</div>
<?php
require_once('_include/templates/##bottom.php'); 
}
?>