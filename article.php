<?php
require_once('_include/functions/functions.php');

$link = to_connect();
session_start();

$car_id = (int)$_GET['car'];


if ($_SERVER['REQUEST_METHOD'] == 'POST')      {    //////////  ДОБАВИТЬ реплику
require_once('_include/engine/add_article_replics.php');
} else    {                                     //////////  ВЫВОД СТРАНИЦЫ


                                            //  фото к статье
$zapros = " SELECT              *
          FROM                letters_images 
          WHERE     car_id  =   '$car_id'
          ORDER BY            parag 
          ";
    $result = $link->query ($zapros); 

    while ($row = $result->fetch_assoc() )    {
        $images[$row['parag']] = array($row['name'], $row['width'], $row['height'], $row['text'], $row['letters_images_id']);
    } 

    $zapros = " SELECT              *
              FROM                letters_videos 
              WHERE     car_id  =     '$car_id'
              ORDER BY            parag ";
    $result = $link->query ($zapros); 

    while ($row = $result->fetch_assoc() )    {
        $videos[$row['parag']] = array($row['sourse'], $row['text']);
    } 

//////////////////
$zapros =   "SELECT *
            FROM              articles
            LEFT JOIN           cars 
          USING             (car_id)
            WHERE car_id =    '$car_id'   
          ";
$result = $link->query ($zapros); 
$row = $result->fetch_assoc();
$article_id = (int)$row['article_id'];


$add_head = '<script type="text/javascript">
var idArticle = "'    .$article_id .'";
var idCar = "'      .$car_id .'"; 
</script>
<script type="text/javascript" src="_include/js/article/article.js"></script>
';

if (($_SESSION['login_user']) == 'oleg3012' ||  ($_SESSION['login_user'])  == 'dima7777') {
require_once('_include/engine/editors_grant.php');
}

require_once('_include/templates/##top.php'); 
require_once('_include/templates/##left.php'); 
$_SESSION['right_menu'] = 'article';
?>
 <!--  FULL column ..................................................... -->
<div id="allContent" style="padding-bottom:100px; background:#fff;">

<?php
////////////////////////////////////////////////////////////////////////////
$this_title = $row['title'];
require_once('_include/templates/#dossier.php');
////////////////////////////////////////////////////////////////////////////
echo '
<div class="arti" style="display:block; width:830px; overflow:hidden; position:relative; background: url(_include/pics/bg_line.gif) repeat-y 30px 0; padding-top:20px; margin-top:30px;">
<div class="area_replics"><a href=article_replics.php?car=' .$car_id .'&amp;parag=' .$i . '><span class="repl">На страницу комментариев</span></a></div>';


$pars =  explode ("\r\n", $row['text']);                  //  на абзацы
foreach($pars as $key => $txt)      {
echo '
<a name="t_' .$key .'"></a>
<div class="wrap_parag">';
        
                                              // Не высвечивать вспл подсказку у заголовков
        $str0 = substr ($txt, 0, 4);  
        if ($str0 == '<h4>')    { 
        echo '
<div  class="parag_h4">' .$txt .'</div>
</div>'; 
        } else        { 

          if ($key == 0)  {                           // если первый параграф - текст с буквицей
          $str1 = mb_substr($txt, 0,1,  'utf-8');
          $str2 = mb_substr($txt, 1, mb_strlen($txt, 'utf-8'),  'utf-8');
  
          echo '
<div id="t_' .$key .'"  class="parag_1" style="text-indent:0px;"><span class="first_cap">' .$str1 .'</span>' .$str2 .'</div>';
          }     else      {
      echo '
<div id="t_' .$key .'" class="parag_1">' .$txt .'</div>'; 
          }
echo '
<div id="repl_' .$key .'" class="area_replics"></div>
</div>';  


///////////////////////////////////////////////
    if (isset($images[$key]))   {   //  фотографии
    
          $photo    = '_photos/articles/' .$images[$key][0];
          $photo_big  = '_photos/articles/big/' .$images[$key][0];
          
          $size_photo = getimagesize($photo); 
          $photo_W =  580;
          $photo_H =  ceil( $size_photo[1] / 580 * $size_photo[0] );
          
        if(file_exists($photo)) {
        echo '
    <div style="display:block; width:'  .$photo_W .'px; height:' .$photo_H .'px; position:relative; margin:20px 0 20px 30px; border:1px solid #ccc; background:#e3e3e3;">
      <img src="' .$photo  .'"  width="' .$photo_W .'" height="'  .$photo_H .'" />'; 
          if(!empty($images[$key][3]))  {
          echo '
          <div class="photo_subscribe">' .$images[$key][3] .'</div>';
          }
            
          if(file_exists($photo_big))  {          echo '
          <div rel="' .$images[$key][0].'" class="photo_zoom"></div>';
          }
      echo '
  </div>
  ';  
      }
    }
    
    if (isset($videos[$key]))   {    echo '
<div style="margin:30px 0 20px 30px; ">' .$videos[$key][0] .'</div>
';  
    }
///////////////////////////////////////////////


}       
}  ?>
</div>

<div style="display:block; width:400px;  padding:10px 0 0 0; margin:40px 0px 0px 100px; color:#616161; border-top:1px dashed #ccc;">У вас есть уточнения, дополнения? Просто кликните дважды на абзац или фото, к которому хотите добавить свое мнение! Принимаются все конструктивные замечания, подкрепленные опытом эксплуатации данного  автомобиля. Они будут обязательно учтены при дальнейшем редактировании статьи.</div>

</div>
<?php
require_once('_include/templates/##bottom.php'); 

// счетик
$zapros = "UPDATE articles SET
            counter = counter +1
          WHERE   article_id = '$article_id' ";
$result = $link->query ($zapros); 

}  ?>