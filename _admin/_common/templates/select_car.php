<div style="width:580px;  padding:40px 0 0 30px;">

<?php
	 $link = to_connect();
   	 $zapros = "SELECT DISTINCT brand
  					   FROM cars
					   ORDER by brand"; 
  	$result7 = $link->query($zapros);

if (!$row['brand']) { $row['brand'] = 'Авто:'; }

echo '
<select name="brand"  id="s_brand" class="select" style="width:140px;"  onchange="ajaxSelectModels();">'; 
echo '
<option  selected>' .$row['brand'] .'</option>';
			while ($row7 = $result7->fetch_assoc() )    	{
	     	echo '
<option>' .$row7['brand'] .'</option>';
			}
		echo '
</select>';
?>

<select name="model"  id="s_model" class="select" style="width:100px;">
<option ><? echo $row['model']; ?></option>
</select>

<span style="color:#b8b8b8; padding:0 10px 0 20px;">Годы</span>
<select name="year1" id="s_years" class="select" style="width:200px; margin-right:0;" onchange="ajaxSelectYearEnd();">
<option ><? echo $row['year1'] .' - ' .$row['year2']; ?></option>
</select>


</div>