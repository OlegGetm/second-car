<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>editor</title>
<link rel="stylesheet" href="../_common/css/style.css" type="text/css" />
<script type="text/javascript" src="../../_include/js/_core/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../../_include/js/_core/jquery.color.js"></script>
<?php echo $add_head; ?>
</head>

<body>
<div id="areaToShowroom" style="display:block; position:relative;"></div>

<div id="header">

<?php if($_SESSION['editor'] == 'letters' || $_SESSION['editor'] == 'articles' || $_SESSION['editor'] == 'attributes') {
	echo '
<div class="btn_new"><a href="edit.php?status=insert">Новый&nbsp;&nbsp;»</a></div>
';
}  ?>

<div id="tabs" style="display:block; width:700px; height:28px; padding:12px 0 0 0px; ">
  <ul>
    <li <?php if($_SESSION['editor'] == 'letters') echo 'class="active" ';?>><a href="../letters/index.php"><span>Лента</span></a></li>
    <li <?php if($_SESSION['editor'] == 'articles') echo 'class="active" ';?>><a href="../articles/index.php"><span>Обзоры</span></a></li>
    <li <?php if($_SESSION['editor'] == 'experts') echo 'class="active" ';?>><a href="../experts/index.php"><span>Эксперты</span></a></li>
    <li <?php if($_SESSION['editor'] == 'opinions') echo 'class="active" ';?>><a href="../opinions/index.php"><span>Отзывы</span></a></li>
    <li <?php if($_SESSION['editor'] == 'replics') echo 'class="active" ';?>><a href="../replics/index.php"><span>Реплики</span></a></li>
    <li <?php if($_SESSION['editor'] == 'forum') echo 'class="active" ';?>><a href="../forums/index.php"><span>Портрет</span></a></li>
    <li <?php if($_SESSION['editor'] == 'forum_classic') echo 'class="active" ';?>><a href="../forums_classic/index.php"><span>Форумы</span></a></li>
     <li <?php if($_SESSION['editor'] == 'attributes') echo 'class="active" ';?>><a href="../attributes/index.php" style="margin-left:22px;"><span>Свойства</span></a></li>
  </ul>
</div>
</div><!--end Header-->

<div id="wrapper">

