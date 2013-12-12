<?php 
session_start (); 
error_reporting(0);

require_once('_include/functions/functions.php');
$link = to_connect();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="ALL">
<meta name="description" content="Автомобили без грима">
<meta name="keywords" content="second-hand, эксплуатация, ресурс, автомобили с пробегом, подержанные автомобили, подержанная машина, рейтинг надежности автомобилей, авто с пробегом, second-car, американки, японки, автомобили из Америки, секонд кар, секонд-кар, секонд-кар.ру, сэконд-кар, сэконд, ремонт, автосервис, техосмотр, TUV, тюф, Audi, BMW, Cadillac,Chery, Chevrolet, Chrysler, Citroen, Daewoo, Dodge, FIAT, Ford, Honda, Hummer, Hyundai, Infiniti, Jeep, KIA, Land Rover, Lexus, Lincoln, Mazda,Mercedes,Mercedes-Benz, MINI, Mitsubishi, Nissan, Opel, Peugeot, Porsche, Renault, Saab, Skoda, SsangYong, Subaru, Suzuki, Toyota, Volkswagen, Volvo">
<title>Second-car.ru  –  Автомобили без грима.</title>
<link rel="stylesheet" href="_include/css/_main.css" type="text/css" />
<!-- 
<link rel=alternate type=application/rss+xml title=RSS href=http://www.second-car.ru/rss.php>
-->
<script type="text/javascript" src="_include/js/_core/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="_include/js/_core/jquery.pngFix.js"></script>


<script type="text/javascript">  
     $(document).ready(function(){  
       $(document).pngFix();  
   });  
</script>
<?php echo $add_head; ?>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> 

</head>

<body>
<div id="page">

<div style="display:block; width:184px; height:152px; position:absolute; top:0; left:0; background:url(_include/pics/logo_orange.png) no-repeat;  z-index:20;"></div>



