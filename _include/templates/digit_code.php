<?php

$digit[0] = 'w';
$digit[1] = 'l';
$digit[2] = 'a';
$digit[3] = 'n';
$digit[4] = 'y';
$digit[5] = 'b';
$digit[6] = 'r';
$digit[7] = 'z';
$digit[8] = 'k';
$digit[9] = 'c';

$total = '';

for ($i=0; $i<4; $i++) 	{
		if ($i==0) $a = rand (1, 9);   // чтобы не начинать с нуля
		else		    $a = rand (0, 9);
echo '<img src="_include/pics/digi_' .$digit[$a] .'.gif" >';
$total = $total . $a ;
}

$total = intval($total);
//echo $total;

?>