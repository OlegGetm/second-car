<?php
session_start ();
if  (!isset($_SESSION['login_editor'])) { $url = 'Location: ../login.php';
	header ($url); 		}
	
$_SESSION['editor'] = 'attributes';
include_once('../_common/functions.php'); 
include_once('../_common/templates/##top.php');
	
$status = $_GET['status'];
$car_id = $_GET['car_id'];


  $link = to_connect();
  
  $zapros = "SELECT 					* 
					 FROM 					cars
					 WHERE car_id =   '$car_id'   "; 
  
 	$result = $link->query ($zapros);
	$row = $result->fetch_assoc();
?>

<script language="Javascript" type="text/javascript" src="../_common/ajax/cars/list_of_models.js"></script>
<script type="text/javascript">
function sendform() {
var begin = document.myform.year1.value;
var segment = document.myform.segment.options [document.myform.segment.selectedIndex].text;

		 if(begin =="") {
		alert ("Необходимо указать год начала выпуска!");
		document.myform.year1.focus();
		return false;
		}
		else if(segment == "Выберите сегмент") {
		alert ("Пожалуйста, укажите модель автомобиля");
		document.myform.segment.focus();
		return false;	
		}
		else {
		document.myform.submit();
		}
}
</script>

<?php  include_once('../_common/templates/##top.php'); ?>

<div id="fullContent" style="margin:20px 0 0 100px;">

<!-- BOX 1  -->

<?php
$table_width =630;
include_once('../_common/templates/inc.table_top_white.php');  ?>

<div  style="margin:0px 6px 0 8px;  background:#fff;">
<div  style="padding:0px 0 40px 70px;  background:#fff;">

<form action="submit.php?car_id=<?php echo $car_id; ?>" method="post" name="myform" class="editor">

<div style="padding:30px 0 50px 0; font: bold 16px Arial,sans-serif; color:#727272;">

<?php
		if ($status == 'insert')	{	?>

<select name="brand"  onchange="selectModel()"  style="width:150px;">
<option  selected><? echo $row['brand']; ?></option>
<option>Alfa Romeo</option>
<option>Acura</option>
<option>Audi</option>
<option>BMW</option>
<option>Cadillac</option>
<option>Chery</option>
<option>Chevrolet</option>
<option>Chrysler</option>
<option>Citroen</option>
<option>Daewoo</option>
<option>Dodge</option>
<option>FIAT</option>
<option>Ford</option>
<option>Honda</option>
<option>Hummer</option>
<option>Hyundai</option>
<option>Infiniti</option>
<option>Jaguar</option>
<option>Jeep</option>
<option>KIA</option>
<option>Land Rover</option>
<option>Lexus</option>
<option>Mazda</option>
<option>Maybach</option>
<option>Mercedes</option>
<option>MINI</option>
<option>Mitsubishi</option>
<option>Nissan</option>
<option>Opel</option>
<option>Peugeot</option>
<option>Porsche</option>
<option>Renault</option>
<option>Saab</option>
<option>SEAT</option>
<option>Skoda</option>
<option>SsangYong</option>
<option>Subaru</option>
<option>Suzuki</option>
<option>Toyota</option>
<option>Volkswagen</option>
<option>Volvo</option>
<option>ВАЗ</option>
</select>

<?php		}	else	{ 		echo $row['brand'];  	}

		if ($status == 'insert')	{
		echo '
		<select name="model" class="select" style="width:170px;">
		<option >' .$row['model'] .'</option>
		</select>';
		}	else	{  		echo ' ' .$row['model'];  		}
?>
</div>


<div style="margin:10px 0 0 0; ">
<span style="padding: 0 6px 0 0px; color:#000;">Годы выпуска</span>
<input maxlength="4" name="year1" style="width:50px;" value="<?php echo $row['year1']; ?>"> – 
<input maxlength="4" name="year2" style="width:50px;"  value="<?php echo $row['year2']; ?>">
</div>

<div style="margin:30px 0 70px 0; ">
<span style="padding: 0 38px 0 0px; color:#000;">Сегмент</span>
<?php include_once('../../_include/templates/array_segments.php'); ?>

<select name="segment"  class="select" style="width:240px;">
<option value="0">Выберите:</option> 
<?php
foreach($ar_segment as $key => $val) 	{

	if($row['segment'] == $key)	{
echo '<option value="' .$key .'" selected>' .$val .'</option>
';
	}	else	{
echo '<option value="' .$key .'">' .$val .'</option>
';
	}
}
?>
</select>

</div>




<div style="display:block; width:71px; height:40px; float:left; margin:20px 14px 20px 0px; cursor:pointer; background:url(../_common/img/btn_edit.png);" onclick="sendform();"></div>
  <div style="display:block; width:70px; height:40px; float:left; margin:20px 0 0px 0px; cursor:pointer; background:url(../_common/img/btn_cancel.png);" onclick="javascript:history.back();"></div>
  <div style="clear:both;"></div>


<?php 
if ($status !== 'insert')	{
echo '	
<input type="hidden" name="brand" value="' .$row['brand'] .'">
<input type="hidden" name="model" value="' .$row['model'] .'">';
}
?>

</form>

</div></div>
<?php  include_once('../_common/templates/inc.table_bottom_white.php'); ?> <!-- BOX 1  -->

 <div style="clear:both;"></div>
</div>
<?php include_once('../_common/templates/##bottom.php');  ?>