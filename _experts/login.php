<?php
session_start ();
include_once('../_admin/_common/functions.php');

if ($_GET['logout'] == 'yes')		{
  unset ($_SESSION['login']);
  unset ($_SESSION['name']);
  unset ($_SESSION['number_authors']);
		
  $url = 'Location: login.php';
  header ($url);
}

$login_post = $_POST['login_post'];
$pass_post = $_POST['pass_post'];

if ($_SERVER['REQUEST_METHOD'] == 'POST')   {   // если введены логин-пароль

$link = to_connect();
$zapros = "SELECT *
 					FROM expert_pass 
					WHERE login = '$login_post'
					AND pass = sha1('$pass_post') ";
 $result = $link->query ($zapros);

		if ($result->num_rows >0 )    {    							// если правильные логин-пароль
		
					if ($result->num_rows >1)    {					// если под одним логином больше одного эксперта
					$_SESSION['number_authors'] = 'many';
					}	else	{
					$_SESSION['number_authors'] = 'one';	
					}

		while($row = $result->fetch_assoc() )		{
		$_SESSION['login'] = $row['login'];
		$_SESSION['name'] .= $row['name'];
		}
	
		$url = 'Location: index.php';
		header ($url);
		}
		else
		{
		$url = 'Location: login.php?error=yes';
		header ($url);
		}

}	else 		{																// надо ввести имя и пароль
include_once('_common/#top.php');
?>


<!--  fullContent     -->
<div id="fullContent">

<!-- блок в рамке-->
<div style="display:block; width:364px; height:241px; margin:110px 0 0 240px;  background-image:url(_common/img/bg_login.png); background-repeat:no-repeat; padding:30px 0 0 20px;">

<div class="hidden" <?php  if ($_GET['error'] == 'yes') { echo ' style="	visibility:visible;" '; } ?>>Повторите попытку:</div>

<form action="login.php" method="post" class="editor">
<table cellpadding="0" cellspacing="6px">
<tr>
<td><span style="width:150px; 	font-size:18px; font-weight:normal; color:#FF9933; padding-right:20px;">Логин</span></td><td><input size="16" name="login_post"></td>
</tr>
<tr>
<td><span style="font-size:18px; font-weight:normal; color:#FF9933; padding-right:20px;">Пароль</span></td><td><input type="password" size="16" name="pass_post" value=""></td>
</tr>
</table>

<button type="submit" style="font-size:16px; margin:20px 0 0 100px;">&nbsp;Войти&nbsp;</button>
</form>
</div>
<div style="display:block; height:360px; width:10px;"></div><!-- удлинить страницу вниз-->

</div>
<?php include_once('_common/#bottom.php');
}
?>