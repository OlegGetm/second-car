<div class="add_opinion" style="padding:10px; background:#e3e3e3;">
<form name="myform">
<select id="s_brand" name="brand" style="width:160px;  margin-right:20px;">
<?php
$q = "SELECT DISTINCT 	brand 
		FROM 							cars  
		ORDER BY 					brand ";
				
$res = $link->query($q);
while ($r = $res->fetch_assoc() )  {
if ($r['brand'] != $_SESSION['menu']['brand'] )	{    
echo '
<option>' .$r['brand'] .'</option>';
}	else										{  
echo '
<option selected>' .$r['brand'] .'</option>';	
}    }    ?>
</select>

<select id="s_model" name="model"  style="width:160px; margin-right:20px;">
<?php
$brand = $_SESSION['menu']['brand'];
$model = $_SESSION['menu']['model'];

$q = "SELECT DISTINCT 	model 
		FROM 							cars  
		WHERE brand = 			'$brand'
		ORDER BY 					model 		";
				
$res = $link->query($q);
while ($r = $res->fetch_assoc() )  {
if ($r['model'] != $model  )	{    echo '
<option>' .$r['model'] .'</option>';
}	else										{  echo '
<option selected>' .$r['model'] .'</option>';	
}    }    ?>
</select>

<select  id="s_years" name="year_begin"   style="width:100px;">
<?php 
$q = "SELECT  				car_id, year1, year2 
		FROM 						cars  
		WHERE 	model =   '$model'
		ORDER 	BY			year1 ";
				
$res = $link->query($q);
while ($r = $res->fetch_assoc() )  {
if ($r['year1'] != $_SESSION['menu']['year1'] )	{    echo '
<option value="' .$r['car_id'] .'">' .$r['year1'] .'-' .$r['year2'] .'</option>';
}	else										{  echo '
<option selected value="' .$r['car_id'] .'">' .$r['year1'] .'-' .$r['year2'] .'</option>';
}    }    ?>

</select>

<span id="add_text" style="padding:20px 0px 0px 30px; text-decoration:underline; cursor:pointer;" onclick="toPage();">Добавить</span>

</form>
</div>