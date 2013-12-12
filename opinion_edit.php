<?php
session_start (); 
require_once('_include/functions/functions.php');

$link = to_connect();
clean_get();							// защита от SQL-инъекции

if ($_SERVER['REQUEST_METHOD'] == 'POST')      {   //////////// ОБРАБОТКА  новых реплик
 
    if(check_badwords($_POST['name']) && check_badwords($_POST['text']) && check_badwords($_POST['minus']) && strlen($_POST['name']) && strlen($_POST['text']) >20) 	{
   
	$date = date("y.m.d - H:i:s");   //  добавляем время
	$stroka_1 = "date, ";
	$stroka_2 = "'$date', ";
	
		foreach ($_POST as $key => $value)			
		{
			$value = tipografica ($value);
			$value = cleaner_data($value);
		$stroka_1 .= $key .", ";
		$stroka_2 .= "'" .$value  ."'" .", ";
		$$key = $value;
		}
		
	$stroka_1 = substr ($stroka_1, 0, -2);
	$stroka_2 = substr ($stroka_2, 0, -2);
			
	$zapros = "INSERT into opinions (" .$stroka_1 .")
					 VALUES (" .$stroka_2  .")";

    $result = $link->query ($zapros);


 ///////////////////////////////////////////////////////////
 
 
  $mess = '
 Пришел отзыв о ' .$brand .' ' .$model .'
 Отправлен пользователем ' .$_POST['name'] ;
  
  $mess = iconv( 'UTF-8', 'KOI8-R//IGNORE', $mess);
 
 
$title = 'Пришел отзыв об автомобиле ' .$brand .' ' .$model;
 $title = iconv( 'UTF-8', 'KOI8-R//IGNORE', $title);

$title= '=?koi8-r?B?' .$title .'?=';

$to = 'oleg3012@yandex.ru';

$head = "Content-Type: text/plain;\r\n";
$head .= "X-Mailer: PHP/".phpversion()."\r\n";
$head .= "To: $to \r\n";
$head .= "From: mail@second-car.ru \r\n";
$head .= "Subject: $title\n";


mail($to, $title, $mess, $header);
 
 



}

$urls =	'opinion_main.php';
header("location: $urls");


}	else		{								//////// ВЫВОД СТРАНИЦЫ


require_once('_include/templates/##top.php'); 
require_once('_include/templates/##left.php'); 
$_SESSION['right_menu'] = 'opinions';

$car_id = (int)$_GET['car'];

?>

<script language="javascript">
function sendform () {
var name = document.myform.name.value
var year = document.myform.year.options [document.myform.year.selectedIndex] .text
var run = document.myform.run.value
var text = document.myform.text.value

		if(year =="Выберите:") {
		alert ("Пожалуйста, укажите год выпуска автомобиля!");
		document.myform.year.focus();
		return false;
		}
		else if(run =="") {
		alert ("Пожалуйста, укажите пробег автомобиля");
		document.myform.run.focus();
		return false;	
		}
		else if(text.length<120) {
		alert ("Слишком короткий отзыв. Расскажите побольше о своем автомобиле");
		document.myform.text.focus();
		return false;
		}
		else if(name =="") {
		alert ("Пожалуйста, укажите ваше имя");
		document.myform.name.focus();
		return false;
		}
		else {
		return true;
		}
}
</script>

<!--  FULL column ..................................................... -->
<div id="allContent" style="background-color:#fff;">

<?php  
////////////////////////////////////////////
$pic = 4;
$this_title = 'Отзывы владельцев';
require_once('_include/templates/#dossier.php');
///////////////////////////////////////////


$brand = $_SESSION['menu']['brand'];
$model = $_SESSION['menu']['model'];
$year1 = $_SESSION['menu']['year1'];
$year2 = $_SESSION['menu']['year2'];

echo '
<div class="arti" style="padding:0px 190px 90px 50px; margin-top:30px;">';

if  ($brand == 'Mazda' || $brand == 'Toyota' || $brand == 'Skoda' || $brand == 'Audi')
{ $mister = 'вашу'; }
else { $mister = 'ваш'; }
?>

<form action="opinion_edit.php" method="post"  name="myform"  onsubmit="return sendform();">
<h4 style="padding:0px 0 60px 24px; color:#999; font-size:24px; font-weight:bold; font-style:italic;">Ваш отзыв:</h4>


<!-- left --><div class="opinion_area" style="padding:0 0 40px 20px;">
<table cellpadding="0" cellspacing="6px">
<tr>
<td><span style="color:#333;">Год выпуска*</span></td>
<td>
<select class="select" style="width:140px; margin-left:10px;" name="year"> 
<option  selected value=''>Выберите:</option>
<?php
$end = $year2;
$begin = $year1;
if (!$year2) {$end=2010;}
		$different = ($end - $begin) +1;
				for ($k=0; $k<$different; ++$k)   {
						echo '<option>' .$begin .'</option>';
						$begin = $begin+1;
						}
?>
</select>
</td>
</tr>

<tr>
<td><span style="color:#333;">Пробег* </span></td><td><input style="width:30px;" name="run" maxlength="3">&nbsp;&nbsp;тыс. км</td>
</tr>

<tr>
<td>Двигатель</td><td><input style="width:30px;" name="motor" maxlength="3">&nbsp;&nbsp;(например: 1.8 )</td>
</tr>

<tr>
<td>Тип кузова</td><td>
<select class="select" style="width:140px; margin-left:10px;" name="body"> 
<option  selected value="">Выберите:</option>
<option>Седан</option>
<option>Хэтчбек</option>
<option>Универсал</option>
<option>Внедорожник</option>
<option>Кабриолет</option>
</select>
</td>
</tr>

<tr>
<td>КПП</td><td>
<select class="select"  style="width:140px; margin-left:10px;" name="gear"> 
<option  selected value="">Выберите:</option>
<option>Механическая</option>
<option>Автомат</option>
<option>Вариатор</option>
<option>Роботиз.</option>
</select>
</td>
</tr>

<tr>
<td>Привод</td><td>
<select class="select" style="width:140px; margin-left:10px;"  name="transmission"> 
<option  selected value="">Выберите:</option>
<option>Передний</option>
<option>Задний</option>
<option>Полный</option>
</select>
</td>
</tr>
</table>

<!-- вниз --><div style="display:block; height:20px; width:10px; "></div>  

<div><span style="color:#333;">Текст отзыва*</span></div>
<textarea  name="text" class="textarea_1"  style="width:500px; height:200px;"></textarea>

<!-- вниз --><div style="display:block; height:20px; width:10px; "></div>

<div>Слабые места <?php echo $brand .' ' .$model;  ?></div>
<textarea name="minus" class="textarea_1"  style="width:500px; height:100px;"></textarea>

<div style="margin-top:20px;">
Порекомендовали бы  знакомым?</div>
<select class="select" style="margin-top:4px; width:180px;"  name="friends"> 
<option  selected value="">Выберите:</option>
<option>Да</option>
<option>Нет</option>
<option>Трудно сказать</option>
</select>

<div style="margin-top:20px;">
Как оцениваете стоимость содержания</div>
<select  class="select" style="margin-top:4px; width:180px;" name="price"> 
<option  selected value="">Выберите:</option>
<option>Очень дорого</option>
<option>Дорого</option>
<option>Приемлемо</option>
<option>Недорого</option>
</select>

<div style="margin-top:20px;">
Какие запчасти используете?</div>
<select class="select" style="margin-top:4px; width:180px;"  name="original"> 
<option  selected value="">Выберите:</option>
<option>Только оригинальные</option>
<option>В основном оригинальные</option>
<option>В основном неоригинальные</option>
<option>Только неоригинальные</option>
</select>

<!-- вниз --><div style="display:block; height:20px; width:10px; "></div>
<table cellpadding="0" cellspacing="6px">
<tr>
<td></td><td></td>
</tr>
<tr>
<td><span style="color:#000;">Ваше имя*</span></td><td><input size="26" name="name" maxlength="20" maxlength="30"></td>
</tr>
<tr>
<td>Город</td><td><input size="26" name="city" maxlength="20"></td>
</tr>
<tr>
<td>E-mail</td><td><input size="26" name="email" maxlength="20"></td>
</tr>
</table>

<input type="hidden" name="car_id" value="<?php echo $car_id; ?>">


<!-- вниз -->
<div style=" display:block; width:380px; margin:40px 0 0 0; padding:2px 4px; font-size:11px; font-weight:normal; color:#9b9b9b; border-top:1px dashed #ccc;">* Поля со звездочкой надо обязательно заполнить</div>

<!-- кнопки............................. -->
<div style="display:block; height:40px; width:10px;  padding:0 0 0 20px;"></div>
<button type="submit" style="font-size:16px; padding:2px; cursor:pointer;">Добавить </button>
 <span style="margin-right:30px;">&nbsp;</span>
<button type="button" onclick="javascript:history.back();" style="font-size:16px; padding:2px; cursor:pointer;">Отмена</button>
</div>
<!-- end  кнопки................. -->
</form>

</div></div>
</div>
<?php 
require_once('_include/templates/##bottom.php'); 
}
?> 
