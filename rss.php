<?php 
require_once('_include/functions/functions.php');

define('DATE_FORMAT_RFC822','r'); 									// формат даты 

  header('Content-Type: text/xml');
  echo    '<?xml version="1.0" encoding="windows-1251" ?>';


$lastBuildDate=date(DATE_FORMAT_RFC822);                  // Дата последней сборки фида

echo ' 
<rss version="2.0">
<channel>
<title>SECOND-CAR.RU</title>
<link>http://www.second-car.ru</link>
<description>Интернет-журнал о подержанных автомобилях</description>
<pubDate>' .$lastBuildDate .'</pubDate>
<lastBuildDate>' .$lastBuildDate .'</lastBuildDate>
<language>ru</language>'; 

$link = to_connect();
$zapros =  "SELECT id_news, title, text, UNIX_TIMESTAMP(date) as pubdate 
 					FROM news
 					ORDER by date desc 
					LIMIT 10"; 
$result = $link->query ($zapros);

  while($row = $result->fetch_assoc())	{
  
  $title = $row['title']; 
  $text = $row['text']; 
  
  preg_match_all("#(.*?\. ){2}#", $text, $matches);
  $text = $matches[0][0] .$matches[1][1] ; 
  
  //$title = strip_tags(trim($row['title'])); 
  //$text = strip_tags(trim($row['text'])); 
  
  $link = 'http://www.second-car.ru/news.php?id_news=' .$row['id_news'];
  $pubDate = date(DATE_FORMAT_RFC822, $row['pubdate']); 
  
 echo '
	 <item>
		 <title>' .$title .'</title>
		 <description>' .$text .'</description>
		 <link>' .$link .'</link>
		 <guid isPermaLink="true">' .$link .'</guid>
		 <pubDate>' .$pubDate .'</pubDate>
	 </item>'; 
 	} 
	
	echo '
</channel>
</rss>'; 

?>
  
  
  
  
  
  
  
  
  
  
  