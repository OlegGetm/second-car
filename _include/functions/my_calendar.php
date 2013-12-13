<? 
function my_calendar($fill='') { 
  
  $month_names=array("январь","февраль","март","апрель","май","июнь", "июль","август","сентябрь","октябрь","ноябрь","декабрь"); 
  
  if (!empty($_GET['y'])) 
    $y=$_GET['y'];
  if (!empty($_GET['m'])) 
    $m=$_GET['m']; 

  if (!empty($_GET['date']) && strstr($_GET['date'],"-"))
  {
    list($y,$m)=explode("-", $_GET['date']);
  } 
    
  if (empty($y) || $y < 1970 || $y > 2037)
  {
    $y=date("Y");
  } 
    
  if (!empty($m) || $m < 1 || $m > 12)
  {
   $m=date("m");
  }  

  $month_stamp	= mktime(0,0,0,$m,1,$y);
  $day_count		= date("t",$month_stamp);
  $weekday			= date("w",$month_stamp);
  if ($weekday==0)
    $weekday=7;
  $start				=-($weekday-2);
  $last         = ($day_count+$weekday-1) % 7;
  
  if ($last==0) {
     $end=$day_count; 
  } else {
    $end=$day_count+7-$last;
  } 
  
  $today				= date("Y-m-d");
  $prev					= date('?\m=m&\y=Y',mktime (0,0,0,$m-1,1,$y));  
  $next					= date('?\m=m&\y=Y',mktime (0,0,0,$m+1,1,$y));
  $i = 0;
?> 

 <div>
  <span><a href="<? echo $prev ?>">&lt;&lt;&nbsp;</a></span> 
  <span><? echo $month_names[$m-1]," ",$y ?></span> 
  <span><a href="<? echo $next ?>">&nbsp;&gt;&gt;</a></span> 
  </div>
   
 
  <table border=0 cellspacing=3 cellpadding=2> 
 <tr><td>Пн</td><td>Вт</td><td>Ср</td><td>Чт</td><td>Пт</td><td>Сб</td><td>Вс</td></tr>
 
<? 
  for($d=$start;  $d<=$end;  $d++) { 
    if (!($i++ % 7)) echo '
	<tr>';
    echo '<td align="center">';
    if ($d < 1 OR $d > $day_count) {
      echo '&nbsp';
    } else {
      $now= $y ."_" .$m ."_" .sprintf("%02d",$d);
      if ($d == date("d")) {
        echo '
		<span class="data_curent">
		<a href="'.$_SERVER['PHP_SELF'].'?date='.$now.'">'.$d.'</a>
		</span>
		'; 
      } else {
        echo '
		<a href="'.$_SERVER['PHP_SELF'].'?date='.$now.'">'.$d.'</a>
		';
      }
    } 
    echo '
	</td>
	';
    if (!($i % 7))  echo '
	</tr>';
  } 
?>
</table> 
<? } ?>