<div class="btn_new"><a href="edit.php?status=insert">Новый&nbsp;&nbsp;»</a></div>

<div id="tabs" style="display:block; position:absolute; top:20px; left:40px;">
  <ul>
    <li></li>
    <li <?php if($_SESSION['editor'] == 'lenta') echo 'class="active" ';?>><a href="../lenta/index.php"><span>Лента</span></a></li>
    <li <?php if($_SESSION['editor'] == 'articles') echo 'class="active" ';?>><a href="../articles/index.php"><span>Обзоры</span></a></li>
    <li <?php if($_SESSION['editor'] == 'experts') echo 'class="active" ';?>><a href="../experts/index.php"><span>Эксперты</span></a></li>
    <li <?php if($_SESSION['editor'] == 'opinions') echo 'class="active" ';?>><a href="../opinions/index.php"><span>Отзывы</span></a></li>
    <li <?php if($_SESSION['editor'] == 'replics') echo 'class="active" ';?>><a href="../replics/index.php"><span>Реплики</span></a></li>
    <li <?php if($_SESSION['editor'] == 'forum') echo 'class="active" ';?>><a href="../forums/index.php"><span>Форумы</span></a></li>
    <li <?php if($_SESSION['editor'] == 'forum_classic') echo 'class="active" ';?>><a href="../forums_classic/index.php"><span>Форумы-2</span></a></li>
     <li <?php if($_SESSION['editor'] == 'attributes') echo 'class="active" ';?>><a href="../attributes/index.php" style="margin-left:22px;"><span>Свойства</span></a></li>
  </ul>
</div>