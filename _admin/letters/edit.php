<?php
session_start();
if (!isset($_SESSION['login_editor']))
{
    $url = 'Location: ../login.php';
    header($url);
}

//////////////////////////  check, is hack  ////////////////////////////////////////

$correctUri = 'http://www.second-car.ru/_admin/letters/edit.php'; 

$curentUri = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

if(!strstr($curentUri, $correctUri))
{
    die();
}


////////////////////////////////////////////////////////////////////

$_SESSION['editor'] = 'letters';
include_once('../_common/functions.php');
$link               = to_connect();

$letter_id = (int) $_GET['letter_id'];
$page      = (int) $_GET['page'];
$status    = $_GET['status'];
$delete    = $_GET['delete'];





if (!empty($letter_id))
{
    $zapros = "SELECT *,  DATE_FORMAT(date, '%Y_%m') as date_prefix
								FROM 		letters 
								WHERE 	letter_id = $letter_id   ";
    $result = $link->query($zapros);
    $row    = $result->fetch_assoc();

    $image_name = $row['image_name'];
}


if ($delete == 'yes')
{   ////  если удаляем статью:
    $zapros = "DELETE 
 					FROM 							letters 
					WHERE 	letter_id = 	$letter_id 	";
    $result = $link->query($zapros);
    delete_photo(1, $metka_time, $archive_dir);   /////////////  ??????  -------

    header('Location: ' . $_SERVER['HTTP_REFERER']);

////////////////////////////////////////////////////////////////////////////
} else if ($_SERVER['REQUEST_METHOD'] == 'POST')
{   //// ОБРАБОТКА формы - submit
    if (($_FILES['photo_1']['size']) > 0)
    {                            ///////// добавить фото 
        include ('../_common/classes/class.Add_Image.php');


        $file_up = $_FILES['photo_1'];              // загружаемый файл

        $ImageUp = new Add_Image($file_up);          // создать  объект

        if ($ImageUp->validate_image_type() == 'true')
        {


            if (empty($letter_id) || empty($image_name))
            {
                $ImageUp->set_random_name();        // создать случайное имя
                $image_name = $ImageUp->get_newFileName();
            } else
            {
                $ImageUp->new_file_name = $image_name;
            }


            if (!empty($row['date_prefix']))
            {
                $subdir = '../../_photos/letters/' . $row['date_prefix'];
                $subdir = '../../_photos/letters/' . $row['date_prefix'];
            } else
            {
                $subdir = '../../_photos/letters/' . date('Y_m');
            }

            $subdir_big = $subdir . '/big';

            $original_size = $ImageUp->get_original_size();
            $original_W    = $original_size[0];

            ///////////////
            if ($original_W >= 900)
            {

                $ImageUp->create_dir($subdir_big);
                $ImageUp->max_W = '900';
                $ImageUp->add_sharpen = 'yes';        //  добавить ли резкость
                $ImageUp->save_image();
            }
            /////////////////
            if ($original_W >= 580)
            {

                $ImageUp->create_dir($subdir);
                $ImageUp->max_W = '580';
                $ImageUp->add_sharpen = 'yes';
                $ImageUp->save_image();
            }
        }
    }



    $to_print = '1';     // по умолчанию - заметка к печати
    if ($_POST['to_print'] !== '1' && ($_FILES['photo_1']['size']) == 0)
    {
        $to_print = '0';
    }


    $type = clean_data($_POST['type']);

    $title = tipografica($_POST['title']);
    $title = clean_mini($title);

    $text = tipografica($_POST['text']);
    $text = clean_mini($text);

    $author_id = (int) $_POST['author_id'];


    if ($_GET['letter_id'] > 0)
    {         // ОБНОВИТЬ  статью
        $zapros = "UPDATE 			letters 
							SET
							to_print 			= '$to_print',
							type 					= '$type',
							image_name 	= '$image_name',
							title 					= '$title',
							text 					= '$text',
							author_id			= '$author_id'
							
							WHERE letter_id = $letter_id   ";
    } else
    {                      //  ВСТАВИТЬ новую статью
        $zapros =
                "INSERT INTO 	letters 
			(date, to_print, type, image_name, title, text, author_id )
			VALUES 
			(NOW(), '$to_print', '$type',  '$image_name', '$title', '$text', '$author_id'  )";
    }
    $result = $link->query($zapros);


    $url = 'Location: index.php?page=' . $page;
    header($url);



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
} else
{              ////////// ВЫВОД СТРАНИЦЫ
    //  выбрать всех авторов
    $q2   = " SELECT *
						FROM 				authors 
						ORDER BY 		pos
						";
    $res2 = $link->query($q2);

    while ($r2 = $res2->fetch_assoc()) {
        $ar_authors[] = array($r2['author_id'], $r2['form_presentation']);
    }


    include_once('../_common/templates/##top.php');
    ?>

    <script type="text/javascript" src="../_common/ajax/showroom/showroom.js"></script>
    <script type="text/javascript" src="../_common/ajax/showroom_topic/showroom_topic.js"></script>
    <script type="text/javascript" src="../_common/ajax/showroom_right/showroom_right.js"></script>
    <script type="text/javascript">
        var type = "letter";
        var letterId = "<?php echo $row['letter_id']; ?>";
        var title = "<?php echo $row['title']; ?>";
        var photo = "<?php echo '_photos/letters/' . $row['date_prefix'] . '/' . $image_name; ?>";
        var url = "letter.php?letter=<?php echo $row['letter_id']; ?>";

    <?php
    $text      = $row['text'];
    $paragraph = explode("\r\n", $text);
    ?>
        var txt = "<?php echo $paragraph[0] . '\r\n' . $paragraph[1]; ?>";



        function sendform () {
            var inputType = document.myform.type.options [document.myform.type.selectedIndex].text;
            var inputTitle = document.myform.title.value;
            var inputText = document.myform.text.value;

            if(inputType == "Тип заметки") {
                alert ("Необходимо указать тип заметки!");
                document.myform.inputType.focus();
                return false;
            }
            else if(inputTitle.length == 0)  		 {
                alert ("Добавьте заголовок");
                return false;
            }   else if(inputText.length == 0) 		 {
                alert ("Добавьте текст");
                return false;
            }   	else {
                document.myform.submit();
            }
        }
    </script>

    <div id="fullContent" style="margin:20px auto;">



        <!-- BOX 1  -->
        <div style="width:660px; float:left; background:#f5f5f5; padding:0px 6px 0 8px;">

            <form action="<?php echo $_SERVER['SCRIPT_NAME'] . '?letter_id=' . $letter_id . '&page=' . $page; ?>" method="post"  enctype="multipart/form-data" name="myform" onsubmit="return sendform();"  class="editor">

                <div style="padding:34px 0 4px 33px;  color:#727272; font:bold 13px helvetica,sans-serif;">Заголовок:</div> 
                <input name="title"  class="editor" style="width:500px; margin:0 0 0 30px;" value="<?php echo $row['title']; ?>">

                <!-- Тип заметки  -->
                <select name="type" class="editor"  style="width:160px; margin:10px 0 0 30px;">

                    <?php
                    $ar_type   = array('Новости', 'Story', 'Аналитика', 'Техника', 'Тест-драйв', 'Путешествия');
                    echo '
<option>Тип заметки</option>
';
                    foreach ($ar_type as $k => $ar)
                    {
                        if ($row['type'] == $k)
                        {
                            echo '
		<option  selected value=' . $k . '>' . $ar . '</option>
		';
                        } else
                        {
                            echo '
		<option  value=' . $k . '>' . $ar . '</option>
		';
                        }
                    }
                    ?>
                </select>


                <!-- Автор  -->
                <select name="author_id" class="editor"  style="width:220px; margin:10px 0 0 30px;">
                    <option value='0'>Автор не указан</option>
    <?php
    foreach ($ar_authors as $k => $ar)
    {
        if ($row['author_id'] == $ar_authors[$k][0])
        {
            echo '
		<option  selected value=' . $ar_authors[$k][0] . '>' . $ar_authors[$k][1] . '</option>
		';
        } else
        {
            echo '
		<option  value=' . $ar_authors[$k][0] . '>' . $ar_authors[$k][1] . '</option>
		';
        }
    }
    ?>
                </select>

                <textarea id="textarea_1" name="text" class="editor" style="width:600px; height:560px; margin:10px 20px  0 30px;"><?php echo $row['text']; ?></textarea>

                <div style="display:block; width:71px; height:40px; float:left; margin:14px 14px 0px 486px; cursor:pointer; background:url(../_common/img/btn_edit.png);" onclick="sendform();"></div>
                <div style="display:block; width:70px; height:40px; float:left; margin:14px 0 0px 0px; cursor:pointer; background:url(../_common/img/btn_cancel.png);" onclick="javascript:history.back();"></div>
                <div style="clear:both;"></div>

        </div><!-- BOX 1  -->	

        <!-- BOX 2  -->
        <div style="display:block; width:250px; height:401px; overflow:hidden; float:left; margin:0px 0 0px 30px; background:#f5f5f5;">

            <!-- добавить фото  -->
            <div class="label"  style="padding:28px 0 4px 28px;">Добавить или поменять фото</div>

            <div style="margin:0px 0 0px 28px;">
                <input type="file" name="photo_1" class="editor"  style="display:block; width:180px; margin:0 0 20px 0px;" size="10">
    <?php
    $image_dir  = '../../_photos/letters/' . $row['date_prefix'] . '/';
    $filename_1 = $image_dir . $image_name;

    if (strlen($image_name) > 0 && file_exists($filename_1))
    {
        $size_img     = getimagesize($filename_1);
        // привести размер фото к стандарту
        $photo_width  = 160;
        $photo_ratio  = $size_img["0"] / $photo_width;
        $photo_height = round($size_img["1"] / $photo_ratio);

        echo '<img  style="margin:0px 0 0 0px; padding:4px; border:1px solid #ddd;" src ="' . $filename_1 . '" width=' . $photo_width . ' height=' . $photo_height . '>';
    }
    ?>
            </div>


            <div style="margin:50px 0 0px 28px;">
                <div style="width:190px; overflow:hidden; color:#ddd; margin:0px 0 20px 0px;">_____________________________</div>
                <span class="label" style="margin:0px 8px 0px 0px;">Публиковать</span>
                <input type="checkbox" name="to_print" value="1" <?php if ($row['to_print'] == '1') echo 'checked'; ?> style="padding:0; border:0;">

                <div id="btnShowroom" class="label" style="margin:10px 0px 0px 0px; cursor:pointer;">На витрину</div>
                <div id="btnAddMedia" class="label" style="margin:10px 0px 0px 0px; cursor:pointer;"><a href="add_media.php?letter_id=<?php echo $letter_id; ?>">Фото, видео в текст</a></div>  

            </div>

            <input type="hidden" name="image_name" value="<?php echo $image_name; ?>">

        </div><!-- BOX 2  -->
    </form>

    <div style="clear:both;"></div>
    </div>

    <?php
    include_once('../_common/templates/##bottom.php');
}
?>    
