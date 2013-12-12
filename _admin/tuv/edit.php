<?php
include_once('../_common/_top.php');
include_once('../_common/functions.php');

$id_tuv = $_GET['id_tuv'];
$status = $_GET['status'];
$delete = $_GET['delete'];
?>

<SCRIPT language=JavaScript src="../_common/Java_1.js"></SCRIPT>

<script language="javascript">
function sendform () {
year = document.myform.year_begin.value

		if(year =="") {
		alert ("Необходимо указать год начала выпуска!");
		document.myform.year_begin.focus();
		return false;
		}
	
		else {
		return true;
		}
}
</script>


<?php
////  если удаляем статью:
if ($delete == 'yes')
{
$link = new_connect(); 
$zapros  = "DELETE 
 					FROM tuv 
					WHERE id_tuv = $id_tuv";
$result = $link->query ($zapros);
if (!$result)  {echo "Ошибка 39 ";  exit;  }
header('Location: '.$_SERVER['HTTP_REFERER']);
}

else if ($_SERVER['REQUEST_METHOD'] !== 'POST')  {   
			//// если редактирование статьи
 			if  ($status !== 'insert')
 			{
			 $link = new_connect();
			 $zapros = "SELECT * 
								FROM tuv 
								WHERE id_tuv = $id_tuv";
			 $result = $link->query ($zapros);
					if (!$result) { echo "Ошибка 17"; exit;   }
			$row = $result->fetch_assoc();
			}

?>

<form action="<?php echo $_SERVER['SCRIPT_NAME'] .'?id_tuv=' .$id_tuv; ?>" method="post"  name="myform" onsubmit="return sendform();"  class="editor">

<?php include_once('../_common/_select_list.php'); ?>

<span style="color:#EEBF99;">Модель</span>
<select name="model" class="select" style="width:150px;">
<option ><? echo $row['model']; ?></option>
</select>

<span style="color:#EEBF99;">Годы вып.</span>
<input size="4" 
name="year_begin" 
value="<? echo $row['year_begin']; ?>">--

<input size="4" 
name="year_end" 
value="<? echo $row['year_end']; ?>">

<!-- вниз --><div class="shift_down"></div>
<span style="color:#EEBF99;">Итоги TUV за год:</span>
<input size="4" 
name="year_tuv" 
value="<? echo $row['year_tuv']; ?>">

<span style="color:#EEBF99; margin-left:30px;">Позиция в рейтинге:</span>
<input size="4" 
name="rating" 
value="<? echo $row['rating']; ?>">

<!-- кнопки............................. -->
<div style="float: right; display:block; 	width:152px; height:410px; margin-top:106px; margin-right:20px;">
<div style="display:block; width:152px; height:160px; background: url(../_common/img/metal.jpg)  no-repeat left bottom;">

<!-- вниз --><div style="display:block; height:20px; width:10px; "></div>
<div style="padding-left:20px;">
<input type="submit"  style="
	display:block;
	width:100px;
    height:30px;
	font-family: Arial, Tahoma, sans-serif;
    font-size: 12pt;
    font-weight: bold;
    color:#fff;
	background-color:#8a8378; 
	padding-left:6px;
	 "  
value="Править">

<!-- вниз --><div style="display:block; height:18px; width:10px;"></div>
<button type="button" onclick="javascript:history.back();"
style="
	display:block;
	width:100px;
    height:30px;
	font-family: Arial, Tahoma, sans-serif;
    font-size: 12pt;
    font-weight: bold;
    color:#fff;
	background-color:#C1B9AC; 
	padding-left:6px;
	 "  
>Отмена</button>
  
   </div>
 </div>
 
 <!-- вниз --><div style="display:block; height:30px; width:10px; "></div>
 
 <!-- публиковать............... -->
 <div style="display:block; width:152px; height:110px; background: url(../_common/img/metal.jpg)  no-repeat left bottom;">
<!-- вниз --><div style="display:block; height:10px; width:10px; "></div>
 <div style="padding-left:20px;">
 <span style="color:#787878;">Публиковать</span>
<!-- вниз --><div style="display:block; height:10px; width:10px; "></div>
<?php
if ($row['publication'] == 'yes') 
{
echo '<div><input type="radio" name="publication" value="yes" checked><span style="color:#787878;">&nbsp;&nbsp;Да</span></div>';
echo '<div><input type="radio" name="publication" value="no"><span style="color:#787878;">&nbsp;&nbsp;Нет</span></div>';
}
else {
echo '<div><input type="radio" name="publication" value="yes"><span style="color:#787878;">&nbsp;&nbsp;Да</span></div>';
echo '<div><input type="radio" name="publication" value="no" checked><span style="color:#787878;">&nbsp;&nbsp;Нет</span></div>';
 }
?> 
</div>
</div>
 </div>
<!-- end  кнопки................. -->
    
<!-- вниз --><div class="shift_down"></div>
<span style="color:#EEBF99;">Заголовок</span>

<input size="50"  class="editor" 
name="title" 
value="<? echo $row['title']; ?>">

<!-- вниз --><div class="shift_down"></div>
<div style="color:#EEBF99;">Текст статьи</div>

<textarea cols="70" rows="24"  class="editor" style="padding-left:20px;  padding-top:20px;" 
name="text">
<? echo $row['text']; ?>
</textarea>

</form>

<?php } else {
 //// Обработка формы - submit

$date = date("y.m.d - H:i:s");

$link = new_connect();
if (isset($_GET['id_tuv']) && $_GET['id_tuv']!='') 
  {   // Выполняется обновление существующей статьи
			foreach ($_POST as $key => $value)
			{
			$value = addslashes ($value);
			$value = trim ($value);
			$stroka .= $key ." = " ."'" .$value ."'" .", ";
			$$key = $value;
			}
	
	$stroka = substr ($stroka, 0, -2) ." ";
	
	// добавляем дату
	$stroka = "date_mod = '$date', " .$stroka;

$id_tuv = $_GET ['id_tuv'];
$zapros = "UPDATE tuv SET "  .$stroka ."WHERE id_tuv = " .$id_tuv;
  }

  else 
  {         //  Выполняется добавление новой статьи
	
	//  добавляем время
	$stroka_1 = "date, ";
	$stroka_2 = "'$date', ";
	
		foreach ($_POST as $key => $value)
		{
		$value = addslashes ($value);
		$value = trim ($value);
		$stroka_1 .= $key .", ";
		$stroka_2 .= "'" .$value  ."'" .", ";
		$$key = $value;
		}
		
	$stroka_1 = substr ($stroka_1, 0, -2);
	$stroka_2 = substr ($stroka_2, 0, -2);
			
	$zapros = "INSERT into tuv (" .$stroka_1 .")
			VALUES (" .$stroka_2
			.")";
 }

$result = $link->query ($zapros);
if (!$result)  {echo "Ошибка 49 ";  exit;  }


//////////// добавление строки в таблицу attributes
$link = new_connect();
$zapros = "SELECT id_attrib, brand, model, year_begin, isset_photo 
 					FROM attributes 
					WHERE model = '$model'  AND year_begin = '$year_begin' ";
 $result = $link->query ($zapros);
 $num = $result->num_rows;
 
 ////////// добавка_1
 $row = $result->fetch_assoc();
 $photo = $row['isset_photo'];
 /////////// end  // добавка_1

if ($num < 1)
 	{
			if  ($publication == 'yes')
				{ $str1 = 'isset_photo, ';
				  $str2 = "'yes', ";	
				}
			else
				{ $str1 = 'isset_photo, ';
				  $str2 = "'no', ";	
				}
		
			$zapros = "INSERT into attributes 
					(date, brand, model, year_begin, year_end, segment, " .$str1 ."isset_tuv)
					values 
					('$date', '$brand', '$model', '$year_begin', '$year_end', '$segment', " .$str2 ."'yes')"; 
			
			$result = $link->query ($zapros);
					
					 if (!$result) 
					 { 	echo "Ошибка 22 базы данных во время выполнения запроса";
						exit; }
		}			
else
{
			// добавка_2  - одна строка ниже
			if  ($publication == 'yes' || $photo == 'yes')
				{ $str1 = ", isset_photo = 'yes'";  }
			else
				{$str1 = ", isset_photo = 'no'"; }			


	$zapros = "UPDATE attributes SET
					isset_tuv = 'yes'" .$str1
					."
					WHERE model = '$model'  AND year_begin = '$year_begin' ";
	
	$result = $link->query ($zapros);
			
			 if (!$result) 
			 { 	echo "Ошибка 23 базы данных во время выполнения запроса";
				exit; }
}
//////////////////////////////////////////////


      
	$url = 'Location: index.php';
	header ($url);
	    
////  end  Обработка формы - submit
}

include_once('../_common/_left_bottom.php');
?>