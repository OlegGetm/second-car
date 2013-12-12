<?php
if($num_pages>1)		{

	if($_GET['show'] == 'by_brand')	{
	$hr =  'index.php?show=by_brand&page=';
	}	else	{
	$hr = 'index.php?page=';
	}

 	echo '
	<div class="pagination">
	<ul>';
		 for ($k=1; $k<($num_pages+1); $k++) 	 {
					 if ($page == $k)	{
					 echo '<li><strong>' .$k .'</strong></li>';
					 }	else	{
					  echo '<li><a href="' .$hr  .$k .'">' .$k .'</a></li>';
					 }
		}
	echo '
	</ul>
	</div>';
}  ?>

<!-- pagination  -->

</div></div>
</div><!-- средний ряд -->


<?php  if(!$table_width)  { $table_width = 830;} ?>

<!-- нижний  ряд -->
<div style="display:block; position:relative; width:<?php echo $table_width +14; ?>px; height:15px; background:url(../_common/img/tb_center-bottom.png) repeat-x; z-index:0;">
		<div style="display:block; position:absolute; width:15px; height:15px; top:0px; left:0px; overflow:hidden; background:url(../_common/img/tb_left-bottom.png) no-repeat; z-index:10;"></div>
        <div style="display:block; position:absolute; width:12px; height:15px; top:0px; right:0px; overflow:hidden; background:url(../_common/img/tb_right-bottom.png) no-repeat; z-index:10;"></div>


<?php
if($_SESSION['editor'] == 'articles' || $_SESSION['editor'] == 'opinions' || $_SESSION['editor'] == 'attributes')		{
$zapr = 	"SELECT DISTINCT brand
  			 	FROM cars
				ORDER by brand"; 
 $res = $link->query($zapr);

echo '
<div style="display:block; position:absolute; bottom:18px; left:24px;">
<form action="index.php" мethod="post"><select name="select_brand"  onchange="this.form.submit()">
<option selected>По марке</option>
';
	for ($i=0; $i < $res->num_rows; $i++) 	 {
	$r = $res->fetch_assoc();
	echo '<option>' .$r['brand'] .'</option>';
	}
echo '
</select>
</form>
</div>';
}
?>


</div><!-- нижний ряд -->

</div><!-- блок таблицы -->