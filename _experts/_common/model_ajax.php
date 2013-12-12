<div style="width:610px; height:100%;  padding:2px 0px; border-bottom:1px solid #ccc; margin-left:10px;">

<?php
	 $link = to_connect();
   	 $zapros = "SELECT DISTINCT brand
  					   FROM attributes
					   ORDER by brand"; 
  	$result7 = $link->query($zapros);

if (!$row['brand']) { $row['brand'] = 'Авто:'; }

echo '
<select name="brand" class="select" style="width:140px;"  onchange="ajaxSelectModels();">'; 
echo '
<option  selected>' .$row['brand'] .'</option>';
			while ($row7 = $result7->fetch_assoc() )    	{
	     	echo '
<option>' .$row7['brand'] .'</option>
';
			}
		echo '
</select>';
?>

<select name="model" class="select" style="width:140px;" onchange="ajaxSelectYears();">
<option ><? echo $row['model']; ?></option>
</select>

<span style="color:#b8b8b8; padding:0 10px 0 20px;">Годы</span>
<select name="year_begin" class="select" style="width:100px; margin-right:0;" onchange="ajaxSelectYearEnd();">
<option ><? echo $row['year_begin']; ?></option>
</select>

<span style="color:#d3d3d3;"> – </span>
<select name="year_end" class="select" style="width:100px; margin-right:0;">
<option ><? echo $row['year_end']; ?></option>
</select>
</div>