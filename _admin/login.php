<?php
session_start ();
include_once('_common/functions.php');

if ($_GET['logout'] == 'yes')
{ unset ($_SESSION['login_editor']);
  unset ($_SESSION['name_editor']);
}

$login_editor 	= $_POST['login'];
$pass 				= $_POST['pass'];


if (isset ($login) || isset ($pass))  // если введены логин-пароль
{
$link = to_connect();
$zapros = "SELECT *
 					FROM pass_editor 
					WHERE login = '$login_editor'
					AND pass = sha1('$pass') ";
					
 $result = $link->query ($zapros);
 $row = $result->fetch_assoc();

		if  ($result->num_rows > 0 )
		{
		$_SESSION['login_editor'] = $login_editor;
		$_SESSION['name_editor'] = $row['name'];

		$url = 'Location: letters/index.php';
		header ($url);
		}
		else
		{
		$url = 'Location: login.php?new=yes';
		header ($url);
		}

}	else 		{		// надо ввести имя и пароль

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Second-Car Editor</title>
<link rel="stylesheet" href="_common/css/style.css" type="text/css" />
</head>

<body style="background-image:none;">
<div id="wrapper">


<!-- блок в рамке-->
<div style="display:block; width:364px; height:241px; margin:60px auto;  background-image:url(_common/img/bg_login.png); background-repeat:no-repeat; padding:30px 0 0 30px;">

<div class="hidden" <?php  if ($_GET['new'] == 'yes') { echo ' style="	visibility:visible;" '; } ?>>Повторите попытку:</div>

<form action="login.php" method="post" class="editor">
<table cellpadding="0" cellspacing="6px">
<tr>
<td  style="width:80px; 	font-size:18px; color:#FF9933;">Логин</td>
<td><input style="width:140px; font:bold 16px Arial, Helvetica, sans-serif;" name="login"></td>
</tr>

<tr>
<td  style="font-size:18px; color:#FF9933;">Пароль</td>
<td><input type="password" style="width:140px; font:bold 16px Arial, Helvetica, sans-serif;" name="pass" ></td>
</tr>

</table>

<button type="submit" style="font-size:16px; margin:20px 0 0 100px;">&nbsp;Войти&nbsp;</button>
</form>
</div>
<div style="display:block; height:360px; width:10px;"></div><!-- удлинить страницу вниз-->

</div>

</body>
</html>

<?php    }    ?>