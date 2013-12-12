<?php
session_start ();
if  (!isset($_SESSION['login'])) { $url = 'Location: ./login.php';
	header ($url); 		}

include_once('../_admin/_common/functions.php');
$link = to_connect();

$id = $_GET['id'];

					if ($_GET['delete'] == 'yes')  {   ////  если удаляем статью:
					$zapros  = "DELETE 
										FROM expert_articles 
										WHERE id = '$id'    ";
					$result = $link->query ($zapros);
					header('Location: '.$_SERVER['HTTP_REFERER']);

} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {   //// Обработка формы - submit

$brand = $_POST['brand'];
$model = $_POST['model'];
$year_begin = $_POST['year_begin'];
$year_end = $_POST['year_end'];
$name = $_POST['name'];
$login = $_SESSION['login'];

$text = $_POST['text'];
$text = tipografica($text);

				if (strlen($_GET['id'])== 0)   {         //  ВСТАВИТЬ  статью
					
				$zapros = "INSERT expert_articles  
				(date, brand, model, year_begin, year_end, name, login, text )
				VALUES 
				(NOW(),  '$brand', '$model', '$year_begin', '$year_end', '$name', '$login', '$text') "; 
				 
				 }	else	{  											 // ОБНОВИТЬ  статью
				$zapros = "
				UPDATE expert_articles SET
				date_mod = NOW(),
				brand = '$brand',
				model = '$model',
				year_begin = '$year_begin',
				year_end = '$year_end',
				name = '$name',
				login = '$login',
				text = '$text'	
				WHERE id = '$id'  ";
				}  	 

$result = $link->query ($zapros);


//////////// добавление  строки в таблице attributes
	$link = to_connect();
	$zapros = "SELECT *
 					FROM attributes 
					WHERE model = '$model'  AND year_begin = '$year_begin' ";
 $result = $link->query ($zapros);
 $num = $result->num_rows;
 
 			if ($num>0)	 			{   // если уже есть такая запись
			$zapros = 	"UPDATE attributes SET
								isset_experts = 'yes'
								WHERE model = '$model'  AND year_begin = '$year_begin' ";
			$result = $link->query ($zapros);
			}
      
	$url = 'Location: index.php';
	header ($url);
}

else 		{    								 ////////// вывод страницы редактирования

			 $zapros = "SELECT * 
								FROM expert_articles 
								WHERE id = '$id' ";
			 $result = $link->query ($zapros);  
			 $row = $result->fetch_assoc();

include_once('_common/#top.php');
?>

<script type="text/javascript" src="../_admin/_common/__cars.js"></script>
<script type="text/javascript" src="_common/ajax/check_models/validator.js"></script>
<script type="text/javascript">
function sendform () {
var brand = document.myform.brand.options [document.myform.brand.selectedIndex].text;
var model = document.myform.model.options [document.myform.model.selectedIndex].text;
var year = document.myform.year_begin.options [document.myform.year_begin.selectedIndex].text;
var name = document.myform.name.options [document.myform.name.selectedIndex].text;
var text = document.myform.text.value;

		if(brand == "Авто:") {
		alert ("Не указана марка автомобиля");
		document.myform.brand.focus();
		return false;
		}
		else if(model == "Выберите") {
		alert ("Не указана модель");
		document.myform.model.focus();
		return false;	
		}
		else if(year =="Выберите") {
		alert ("Не указан модельный год");
		document.myform.year_begin.focus();
		return false;
		}
		else if(name =="Автор:") {
		alert ("Не указан  автор статьи");
		document.myform.name.focus();
		return false;
		}
		else if(text =="") {
		alert ("Не набран текст");
		document.myform.text.focus();
		return false;
		}
		else {
		document.myform.submit();
		}
}
</script>

<div id="fullContent">
<div style="padding:50px 0 20px 60px;">
<form action="<?php echo $_SERVER['SCRIPT_NAME'] .'?id=' .$id; ?>" method="post"  name="myform"  class="editor">

<!-- Выбор модели  -->
<?php include_once('_common/model_ajax.php');  ?>

<div style="margin:20px 0 0 10px;">
<select name="name" class="select" style="width:294px; background-color:#fffbf0; border-style:none; padding:3px 2px;" >

<? 
if($_SESSION['number_authors'] == 'one') {
echo '<option selected>' .$_SESSION['name'] .'</option>';

}	else	 {
	
    $zapros =  "SELECT name
 					FROM expert_pass 
					WHERE login = '" .$_SESSION['login'] ."'
					ORDER BY name DESC";
   $res = $link->query ($zapros);
	
		if ( $_GET['status'] == 'insert')   {    // новая статья, автора еще нет
		echo '
  		<option selected >Автор:</option>';
				while($r = $res->fetch_assoc() )		{
				echo '
				<option>' .$r['name'] .'</option>';
				}	
				
		}	else		{
				echo '
				<option selected>' .$row['name'] .'</option>';
						while($r = $res->fetch_assoc() )		{
						if($r['name'] !== $row['name'])
						echo '
						<option>' .$r['name'] .'</option>';
						}	
		}
}

 ?>
</select>
</div>

<!-- кнопки OK Cancel  -->
 <div style="position:absolute; display:block;  top:200px; left:739px; width:90px; height:50px; background:url(_common/img/btn_ok.png); cursor:pointer;"  onclick="sendform();"></div>
 
 <div style="position:absolute; display:block;  top:260px; left:739px; width:90px; height:48px; background:url(_common/img/btn_cancel.png); cursor:pointer;"  onclick="javascript:history.back();" ></div>



<div style="display:block; width:626px; height:700px; margin:70px 0 0 0;">
<div style="display:block; width:626px; height:25px; background:url(_common/img/form_bgr_top.jpg) no-repeat;"></div>
<div style="display:block; width:626px;  height:607px; background:url(_common/img/form_bgr_middle.jpg) repeat-y;">
<textarea cols="70" rows="30" name="text" class="editor" style="padding:0px 0px 0 10px; width:600px;  height:600px; margin:0 0 0 6px; border-style:none; overflow-y:auto; background-color:#fffbf0;"><? echo $row['text']; ?></textarea>
</div>
<div style="display:block; width:626px; height:28px; background:url(_common/img/form_bgr_bottom.jpg) no-repeat;"></div>
</div>


</form>
</div>
</div>

<?php include_once('_common/#bottom.php');
}
?>