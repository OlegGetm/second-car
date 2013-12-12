<?php

if($_SERVER['HTTP_HOST'] == 'localhost')	{
$url_link = "http://localhost/second-car.ru/article.php?" .$_SERVER['QUERY_STRING'];
}		else		{
$url_link = "http://www.second-car.ru/article.php?" .$_SERVER['QUERY_STRING'];
}

$add_head .= '
<script type="text/javascript" src="_include/js/_core/jquery.color.js"></script>
<script type="text/javascript" src="_include/js/_core/jquery.textarea-expander.js"></script>
<script type="text/javascript" src="_include/js/edit_online/article/article.js"></script>

<script type="text/javascript">var urlPage = "' .$url_link .'";</script>
';  

?>