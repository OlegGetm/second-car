 <?php
// Database info

//include("conf_global.php");

$dbhost = 'localhost'	;
$dbuser = 'root';
$dbpass = '';
$dbname = 'second-car';

//---------------

//header('Content-type: text/plain');

$dbconn = mysql_connect($dbhost, $dbuser, $dbpass) or die( mysql_error() );
$db = mysql_select_db($dbname) or die( mysql_error() );

$sql = "ALTER DATABASE `".$dbname."` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$result = mysql_query($sql) or die( mysql_error() );
print "Database changed to UTF-8.\n";

$sql = 'SHOW TABLES';
$result = mysql_query($sql) or die( mysql_error() );

while ( $row = mysql_fetch_row($result) )
{
$table = mysql_real_escape_string($row[0]);
$sql = "ALTER TABLE $table DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci, CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
mysql_query($sql) or die( mysql_error() );
print "$table changed to UTF-8.\n";
}

$sql = "ALTER DATABASE `".$dbname."` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";


mysql_close($dbconn);

///////////////////////////////////   ñäåëàíî
///  ïîòîì 
//  ALTER DATABASE `%íàçâàíèå áàçû%` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci
///
////////////////////////////////////

?>