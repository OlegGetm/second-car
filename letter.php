<?php
require_once('_include/functions/functions.php');

clean_get();
$link      = to_connect();
$letter_id = (int) $_GET['letter'];

////////////////////
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{     // обработка  новых сообщений
 //   require_once('_include/engine/add_letter_comment.php');
} else
{



    session_start();                  // вывод страницы

    $zapros = "SELECT 	 *
                FROM		 	letters_images 
                WHERE 		letter_id 	= '$letter_id'
                ORDER BY 		parag ";
    $result = $link->query($zapros);

    while ($row = $result->fetch_assoc()) {
        $images[$row['parag']] = array($row['name'], $row['width'], $row['height'], $row['text'], $row['letters_images_id']);
    }

    $zapros = "SELECT		*
                    FROM             letters_videos 
                    WHERE           letter_id 	= '$letter_id'
                    ORDER BY 	parag ";
    $result = $link->query($zapros);

    while ($row = $result->fetch_assoc()) {
        $videos[$row['parag']] = array($row['sourse'], $row['text']);
    }

    $zapros   = "SELECT
                    l.letter_id , l.title, l.text, l.image_name,
                    DATE_FORMAT(l.date, '%Y_%m') as date_prefix, 
                    a.name as author, a.title as author_title

                    FROM 		letters l
                    LEFT JOIN 	authors as a 
                    USING 		(author_id)	
                    WHERE 		letter_id = 	'$letter_id'
                    LIMIT 1		";
    $result      = $link->query($zapros);
    $row         = $result->fetch_assoc();
    $date_prefix = $row['date_prefix'];

    $add_head = '
<script type="text/javascript" src="_include/js/letter/letter.js"></script>
<script type="text/javascript" src="_include/js/index/forums.js"></script>
';

    if ($_SESSION['grant'] == 'editor')
    {
        $add_head .= '
<script type="text/javascript" src="_include/js/editorial/comments_edit.js"></script>
';
    }


    require_once('_include/templates/##top.php');
    require_once('_include/templates/##left.php');
    ?>
    <!-- # full  -->
    <div id="allContent" style="padding-bottom:100px;  background:#fff url(_include/pics/bg_line.gif) repeat-y 40px 0; ">
            <?php require_once('_include/templates/inc.topic.php'); ?>
        <!-- # left column  -->
        <div style="display:block; width:640px; float:left;">

            <?php
////////////////////////////////////////////////////////////////////////////
            $car_id = (int) $_GET['car'];

            if (!empty($car_id))
            {
                $_SESSION['right_menu'] = 'drive';
                $this_title             = $row['title'];
                require_once('_include/templates/#dossier.php');
            }
////////////////////////////////////////////////////////////////////////////

            echo '
<div style="width:580px; padding:0px 0px 0 30px; ">';

            if (empty($car_id))
            {
                echo '
						<div class="letter_title" style="margin:30px 0 10px 0;">' . $row['title'] . '</div>';

                $title_photo     = '_photos/letters/' . $date_prefix . '/' . $row['image_name'];
                $title_photo_big = '_photos/letters/' . $date_prefix . '/big/' . $row['image_name'];
                $rel_url         = $date_prefix . '/big/' . $row['image_name'];

                $size_photo = getimagesize($title_photo);
                $photo_W    = 580;
                $photo_H    = ceil($size_photo[1] / 580 * $size_photo[0]);

                if (!empty($row['image_name']) && file_exists($title_photo))
                {
                    $size_img = getimagesize($title_photo);
                    echo '
		<div style="display:block; position:relative; width:' . $photo_W . 'px; height:' . $photo_H . 'px; margin:0 0 40px 2px; background: url(' . $title_photo . ');">';

                    if (file_exists($title_photo_big))
                    {
                        echo '<div rel="' . $rel_url . '" class="photo_zoom"></div>';
                    }
                    echo '</div>';
                }
            }

            echo '
<div style="margin:40px 0 0 0;"></div>';

            $pars = explode("\r\n", $row['text']);
            foreach ($pars as $key => $txt)
            {
                $str = substr($txt, 0, 4);
                if ($str == '<h4>')
                {
                    echo $txt;
                } else
                {

                    if ($key == 0)
                    {
                        echo "\n" .'<div  class="letter_text" style="text-indent:0px;"><span class="first_cap">' . mb_substr($txt, 0, 1, 'utf-8') . '</span>' . mb_substr($txt, 1, mb_strlen($txt, 'utf-8'), 'utf-8') . '</div>';
                    } else
                    {
                    echo "\n" .'<div class="letter_text">' . $txt . '</div>';
                    }
                }
                //////	
                $photo     = '_photos/letters/' . $date_prefix . '/' . $images[$key][0];
                $photo_big = '_photos/letters/' . $date_prefix . '/big/' . $images[$key][0];

                $size_photo = getimagesize($photo);
                $photo_W    = 580;
                $photo_H    = ceil($size_photo[1] / 580 * $size_photo[0]);
                //////

                if (isset($images[$key]) && file_exists($photo))
                {  //  фотографии и видео
                    echo "\n" .'<div style="display:block; width:' . $photo_W . 'px; height:' . $photo_H . 'px; position:relative; margin:20px 0 20px 0; border:1px solid #ccc; background:#e3e3e3;">
	<img src="' . $photo . '"  width="' . $photo_W . '" height="' . $photo_H . '" />';
                    if (!empty($images[$key][3]))
                    {
                        echo "\n" .'<div class="photo_subscribe">' . $images[$key][3] . '</div>';
                    }

                    if (file_exists($photo_big))
                    {
                        echo "\n" . '<div rel="' . $date_prefix . '/big/' . $images[$key][0] . '" class="photo_zoom"></div>';
                    }
                    echo "\n" . '</div>' ."\n";
                }


                if (isset($videos[$key]))
                {
                    echo "\n" .'<div style="margin:30px 0 20px 0px; ">' . $videos[$key][0] . '</div>';
                }
            }



            if (strlen($row['author']))
            {
                echo "\n" .'<div class="author_1">// ' . $row['author'];
                if (strlen($row['author_title']))
                {
                    echo '<span>, ' . $row['author_title'] . '</span>';
                }
                echo "\n" .'</div>';
            }
            ?>


            <!--  линия с коммент -->
            <!--
            <div class="comm_block" style="margin:10px 0 0 10px;">
            <a><p onclick="javascript:history.back();">НАЗАД</p></a>
            </div>
            --->
            <!--  линия с коммент -->


            <div style="margin:40px 0 0 0;"></div>
            <a name="comments"></a>
            <!-- button 
            <div  id="buttonForm" style="margin:20px 0 40px 10px; cursor:pointer; color:#999; font-weight:bold; font-size:12px; text-decoration:underline; pointer;" onclick="toggleForm();">ДОБАВИТЬ КОММЕНТАРИЙ</div>
-->
            <!-- form -->
            <div id="form_1" style="display:none; width:410px;  margin:20px 0px 50px 10px; padding:20px; background-color:#ececec; border:1px solid #ddd;">
                <form name="myform" action="<?php echo $_SERVER['PHP_SELF'] . '?letter=' . $letter_id; ?>" method="post">

                    <div style="padding:0px 0 4px 0px; font-weight:bold; color:#7c7c7c;">Ваше имя:</div>
                    <input  id="input_name" style="width:400px; height:22px;  background:#f8f8f8;  font:normal 14px Arial, sans-serif; padding:4px 0 0 2px; margin-bottom:20px; border:1px solid #ddd;"  type="text" name="name" maxlength="40">

                    <div style="padding:0px 0 4px 0px; font-weight:bold; color:#7c7c7c;">Комментарий:</div>
                    <textarea  id="input_text" style=" width:400px; height:150px; overflow-y:auto; background:#f8f8f8; font:normal 14px Arial, sans-serif; padding:4px 0 0 2px; border:1px solid #ddd;"  name="text"></textarea>

                    <input type="button"  onclick="sendForm();" style="cursor:pointer; margin-top:20px; padding:0 6px; font-weight:bold;" value="OK"/>
                    <input  type="button" onclick="toggleForm();" style="cursor:pointer; margin-left:20px; padding:0 4px; " value="Отмена"/>
                </form>
            </div>

            <?php
            $zapros = "SELECT  * 
                FROM 		comments
                WHERE 		letter_id = '$letter_id'
                ORDER BY 	date	DESC ";
            $result = $link->query($zapros);

            if ($result)
            {
                while ($row = $result->fetch_assoc()) {
                    echo '
<div id="comment_' . $row['comment_id'] . '" class="wrap_comment" style="display:block; width:490px; height:100%; position:relative; margin:10px 0px 20px 10px;">
<div class="f_nosik"></div>
<div class="f_top"><div class="f_top_left"></div></div>
<div class="f_content" style="line-height:1.3em; padding:10px 20px 24px 20px;">
<div class="f_name">' . $row['name'] . ':</div>';

                    $pars = explode("\r\n", $row['text']);
                    foreach ($pars as $txt)
                    {
                        echo '
			<div style="text-indent:20px;">' . $txt . '</div>';
                    }
                    echo '
</div>
<div class="f_bottom"><div class="f_bottom_left"></div></div>						
</div>';
                }
            }
            ?>
        </div>

    </div><!-- # left column  -->

    <!-- # right column  -->
    <div class="r_col" style="display:block; width:230px; overflow:hidden; float:left;">

    <?php
    if (empty($car_id))
    {
        require_once('_include/templates/inc.right_column.php');
    }
    ?>
    </div><!-- # right column  -->
    <div style="clear:both;"></div>



    </div><!--  full   -->
    <?php
    require_once('_include/templates/##bottom.php');

// счетчик
    $zapros = "UPDATE letters 
            SET
            visits  = visits +1
            WHERE letter_id  = '$letter_id' ";
    $result = $link->query($zapros);
}
?>
