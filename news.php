<?php
session_start ();  
require_once('_include/functions/functions.php');
clean_get();							// защита от SQL-инъекции


$add_head = '<script type="text/javascript" src="_include/js/comments/comments_news.js"></script>
';

if (($_SESSION['login_user']) == 'oleg3012' ||  ($_SESSION['login_user'])  == 'dima7777')	{
$add_head .= '<script type="text/javascript" src="_include/js/_core/jquery.color.js"></script>
<script type="text/javascript" src="_include/js/edit_online/universal/jquery.editor.js"></script>
<script type="text/javascript">var idNomer = ' .$id_news .';

$(document).ready(function() {       
		$("#edited div").universalEdior("news", "id_news", "column_2");
}); 
</script>
';  }


require_once('_include/templates/##top.php');  
require_once('_include/templates/##left.php');

$link = to_connect();

?>

<!--  FULL column ............................. -->
<div id="allContent"  style="background-color:#fff;">

<!--  Column One  -->
<div style="display:block; width:490px; height:100%; min-height:980px; float:left; padding:0px 20px 90px 60px;">
<div class="arti">
<?php  

$zapros =  "SELECT * 
 					FROM news
 					WHERE id_news = $id_news";
$result = $link->query ($zapros);
$row = $result->fetch_assoc();


$print_date = strftime("%d.%m.%Y", strtotime($row['date']));


echo '<div class ="news_title" style="padding:60px 0 20px 0px; margin:0; color:#FCAE70; line-height:28px;">' .$row['title'] .'</div>';

echo  '
<div style="display:block; width:100px; height:100%; background-color:#ddd; padding:4px; margin-bottom:20px; font:18px bold Arial, sans-serif; color:#fff;">'  
.$print_date .'</div>

<div id="edited">';

// делим на абзацы
$text = ($row['text']);
$paragraph =  explode ("\r\n", $text); // Разбивка текста на абзацы (получается массив)
$num_parag = count($paragraph);
for ($i=0; $i<$num_parag; $i++)		{
if ($i == 0)	{   // если первый параграф - текст с буквицей
					$stroka = $paragraph[0];
					$str1 = substr ($stroka, 0, 1);
					$str2 = substr ($stroka, 1);
					echo '
<div style="text-indent:0px;"><span class="first_cap">' .$str1 .'</span>' .$str2 .'</div>';
		} 		else  		{
		echo '
<div style="text-indent:30px;">' .$paragraph[$i] .'</div>';
}	}

echo '
</div>';   ////   end div 'edited'

		// фотография
		$archive_dir = "_photos/news/";
		$filename_1 = $archive_dir .$row['metka_time'] .'_1.jpg';
			
		if (file_exists($filename_1))   { 
		$size_img = getimagesize($filename_1); 
				echo "<img  style=\"border:3px solid #ccc; margin:40px 0 0 0;\" src =\"" .$filename_1 ."\" width=" .$size_img["0"] ."px height=" .$size_img["1"] ."px>";
		}
?>

</div>

<!-- border -->
<div style="display:block; width:490px; height:10px;  margin:30px 0px 10px 0px; border-bottom: 2px dashed #e1e4ea;"></div>
<!-- button -->
<div  id="button_1" class="btns_add" style="font: 14px  Arial, sans-serif; color:#727272; text-decoration:underline; margin:20px 0 30px 20px; cursor:pointer;" onclick="showForm();">Ваш комментарий</div>

<!-- form -->
<div id="form_1" style="display:none; width:420px;  height:100%;  margin:20px 0px 50px 0px; padding:15px; background-color:#ddd;">
<form name="myform" action="<?php echo $_SERVER['PHP_SELF'] .'?id_topic=' .$id_topic; ?>" method="post">

<div style="padding:0px 0 4px 0px; font-weight:bold; color:#7c7c7c;">Ваше имя:</div>
<input  id="name_1" style="width:380px; height:22px;  font:bold 14px Arial, sans-serif; padding:2px; margin-bottom:20px;"  type="text" name="author" maxlength="40">

<div style="padding:0px 0 4px 0px; font-weight:bold; color:#7c7c7c;">Комментарий:</div>
<textarea  id="text_1" style=" width:400px; height:150px; font:bold 14px Arial, sans-serif; padding:2px;"  name="message"></textarea>

<input type="button"  onclick="sendForm();" style="margin-top:20px; padding:0 6px; font-weight:bold;" value="OK"/>
<input  type="button"  onclick="hideForm();" style="margin-left:20px; padding:0 4px; " value="Отмена"/>
<input  type="hidden" id="id_news" value="<?php echo $id_news; ?>">
</form>
</div>


<div id="new_comment_area" style="display:none; width:470px; height:100%; position:relative; margin:10px 0px 20px 20px;">
<div class="f_nosik"></div>
<div class="f_top"><div class="f_top_left"></div></div>
<div class="f_content">
<div id="name_field" class="f_name"></div>
<div id="text_field" style="text-indent:20px;"></div>
</div>
<div class="f_bottom"><div class="f_bottom_left"></div></div>						
</div>


<?php
$zapros = "SELECT name, text 
 					FROM comments_news
					WHERE id_news = '$id_news'
					ORDER by date desc  ";
$result = $link->query ($zapros);  

while(list($name,$text) = $result->fetch_row())		{	
echo '
<div style="display:block; width:470px; height:100%; position:relative; margin:10px 0px 20px 20px;">
<div class="f_nosik"></div>
<div class="f_top"><div class="f_top_left"></div></div>
<div class="f_content">
<div class="f_name">' .$name .':</div>';

		$abzazs =  explode ("\n", $text);			// Разбивка комментария на абзацы
		$nums	  =  count($abzazs);
		for ($k=0; $k<$nums; $k++)		{
		echo '
<div style="text-indent:20px;">' .$abzazs[$k] .'</div>';
		}
echo '
</div>
<div class="f_bottom"><div class="f_bottom_left"></div></div>						
</div>';
}  ?>


</div>

<!--  Columt Two   -->
<div id="column_2" style="display:block; width:230px; height:100%; float:left;">

<div style="padding:80px 10px 0px 40px;">
<div style="display:block; width:170px;height:24px; overflow:hidden; font:100 22px Impact, sans-serif; color:#ababab; margin-bottom:10px; padding:0 0 4px 0;  border-bottom:7px solid #e3e3e3;">Другие новости:</div>

<?php
$this_type = $row['type'];
$this_id = $row['id_news'];

 $zapros =  "SELECT * 
 					FROM news
					WHERE type = '$this_type'
 					ORDER by date desc 
					LIMIT 17"; 
$result = $link->query ($zapros);
$num = $result->num_rows;

for ($i=0; $i<$num; $i++)		{
  $row = $result->fetch_assoc();
  if ($this_id !== $row['id_news'])	{
  echo '<div class="news_line" style="font-weight:normal;"><a href=news.php?id_news=' .$row['id_news'] .'>' .$row['title'] .'</a></div>';
  }	}
?>
</div>

<!--  end Columt Two   --></div>
</div>
<?php
require_once('_include/templates/##bottom.php');
?>