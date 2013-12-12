<?php 
session_start (); 
error_reporting(0);

require_once('_include/functions/functions.php');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Статистика Second-car.ru</title>
<link rel="stylesheet" href="_include/css/_main.css" type="text/css" />
<style type="text/css">
td  a, td a:visited, span a	{ color:#a7a7a7; font-weight:bold; }
.data_curent a, .data_curent a:visited   { color:#db7816; }
</style>

<script type="text/javascript" src="_include/js/_core/jquery-1.3.2.min.js"></script>

<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> 
</head>

<body>
<div id="page">

<!--  Title  -->
<div style="width: 960px; height: 53px; position:relative; background-color:#c6c4c5;">
<div style="display:block; width:183px; height:148px; position:absolute; top:0; left:0; background:url(_include/pics/logo_orange.png) no-repeat;  z-index:200;"></div>

<div id="to_calendar"  style="display:block; width:84px; height:67px; position:absolute; top:4px; left:840px; cursor:pointer; background:#000 url(_include/pics/calendar.jpg) no-repeat; z-index:300;"></div>
</div>

