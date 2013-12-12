<?php
/*
define ("DB_HOST",      "mysql52.hoster.ru");
define ("DB_NAME",      "m42311");
define ("DB_PASS",      "gpFJK2Yk");
define ("DB_BASE",      "db42311m");
*/


define ("DB_HOST",      "localhost");
define ("DB_NAME",      "root");
define ("DB_PASS",      "pass" );
define ("DB_BASE",      "second-car");


/////////////////////////////////////////////////////////////////////
function pdo_connect()  {
try{
    $dbconn = 'mysql:host=' . DB_HOST . '; dbname=' . DB_BASE;
    global $db;
    $db = new PDO($dbconn ,DB_NAME,DB_PASS);
    //echo 'Good link';
}
catch(PDOException $e)      {   echo $e->getMessage();      exit();         }
}
/////////////////////////////////////////////////////////////////////

function to_connect()  {
            $link = new mysqli (DB_HOST, DB_NAME, DB_PASS);
            $link->query ('SET NAMES utf8'); 
        
            $link->select_db (DB_BASE);
            return $link;
}

// перевод строк
function nl2p($str) {
$str = '<p>'.preg_replace ('/\r\n|\n|\r/', '</p>$0<p>', $str).'</p>';
//$str = preg_replace ('/<p><\/p>/', '', $str);
return $str;
} 


// Защита от SQL-инъекции
function cleaner_data($data)  {
                $data = trim($data);
                $data = chop ($data);
                $data = htmlspecialchars($data);
                $data = mysql_escape_string($data);
                return $data;
}

function clean_post()  {
        foreach ($_POST as $key => $value)      {
                    $value = cleaner_data ($value);
                    global ${$key};
                    ${$key} = $value;
}   }

function clean_get()  {
        foreach ($_GET as $key => $value)       {
                    $value = cleaner_data ($value);
                    global ${$key};
                    ${$key} = $value;
}   }

function tipografica($data)  {
        $data = trim ($data);
        $data = chop ($data);
        // замена на кавычки-елочки:
        $data = preg_replace("/\"(|(.+?))\"/", "«\\2»",  $data);   
        // убрать случайную еденичную кавычку:
        $data = str_replace("\"", "", $data);
        // замена на длинное тире                        
        $data = preg_replace("/(.+?)\s-\s(.+?)/", "\\1 – \\2",  $data);     
        return $data;
}


///////////////////////////////////////
    
function check_badwords ($text)  {              //  защита от плохих слов:

$badwords = array('script', 'function', 'url', 'ttp:', 'href', 'www', 'eval', '.com', '.ru', 'порно', 'секс', 'girl', 'хуй', 'хуев', 'эротик', 'drop', 'insert', 'replace', 'delete', 'update', 'select', 'xrumer', 'хрумер', 'icq');

    $text = strtolower($text);
    
    foreach($badwords as $value)    {
    
            if(stristr($text, $value))       {
            return false;
            }
    }
return true;
}
///////////////////////////////////

?>