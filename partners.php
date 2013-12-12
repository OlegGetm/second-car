<?php
require_once('_include/functions/functions.php');
require_once('_include/templates/##top.php');  
require_once('_include/templates/##left.php');

$id_news = $_REQUEST['id_news'];
?>

<!--  FULL column ............................. -->
<div id="allContent" style="height:1200px; background-color:#fff;">

<div style="margin:90px 0 90px 70px;">

<div class ="news_title" style="color:#727272; margin:0 0 70px 0;">Наши партнеры:</div>


<div style="display:block; width:600px; height:140px; overflow:hidden;  background:#f5f5f5;">
<a href="http://www.autostat.ru">
<div style="display:block; width:120px; height:140px; overflow:hidden; float:left; background: url(_photos/partners/autostat.gif) no-repeat 10px 10px;"></div>
</a>
<div class="link2" style="display:block; width:400px; height:120px; overflow:hidden; float:left; padding:20px 0 0 30px; font-size:16px; ">
<a href="http://www.autostat.ru">
Аналитическое агентство "АВТОСТАТ"
</a>
</div>
</div>

<div style="display:block; width:600px; height:140px; overflow:hidden;  background:#f8f8f8;">
<a href="http://www.podboravto.ru">
<div style="display:block; width:120px; height:140px; overflow:hidden; float:left; background: url(_photos/partners/podborauto.jpg) no-repeat 10px 10px;"></div>
</a>
<div class="link2" style="display:block; width:400px; height:120px; overflow:hidden; float:left; padding:20px 0 0 30px; font-size:16px; ">
<a href="http://www.podboravto.ru">
Компания  "ПодборАвто"
</a>
</div>
</div>



<div style="clear:both;"></div>
</div>
</div>
<?php
require_once('_include/templates/##bottom.php');
?>