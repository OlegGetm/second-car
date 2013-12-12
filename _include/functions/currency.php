<?php 

///////////////////////// курс валют ////////////////////
	
if  (!isset($_SESSION['kursdollar']) 	|| !isset($_SESSION['kurseuro']))	{
		$zapros7 =  "SELECT *
  							FROM _currency
							ORDER by date desc
							LIMIT 1 "; 
  	   
	   $link = to_connect('sell');
	   $result7 = $link->query($zapros7);    if (!$result7)   { echo "Ошибка 7";     exit;   }
	   $row7 = $result7->fetch_assoc();
	   
	   $date = $row7['date'];
	   $kursdollar = $row7['kursdollar'];
	   $kurseuro = $row7['kurseuro'];
	   $current_date = date("Ymd");
	   
		if ( $current_date > $date ) { //пора обновлять курс валют
	
 							function get_content() 		{ // Формируем сегодняшнюю дату 
							$date_web = date("d/m/Y"); 
							// Формируем ссылку 
							$url = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$date_web"; 
							// Загружаем HTML-страницу 
							$fd = fopen($url, "r"); 
							$text=""; 
										if (!$fd) 	{
										echo "Запрашиваемая страница не найдена"; 
										}	else  	{  // Чтение содержимого файла в переменную $text 
										  while (!feof ($fd)) $text .= fgets($fd, 4096); 
										} 
							// Закрыть открытый файловый дескриптор 
							fclose ($fd); 
							return $text; 
							} 
 
  // Получаем текущие курсы валют в rss-формате с сайта www.cbr.ru 
  $content = get_content(); 

  // Разбираем содержимое, при помощи регулярных выражений 
  $pattern = "#<Valute ID=\"([^\"]+)[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>([^<]+)#i"; 
  preg_match_all($pattern, $content, $out, PREG_SET_ORDER); 


			  foreach($out as $cur) 	 { 
			  if($cur[2] == 840) $dollar = str_replace(",",".",$cur[4]); 
			  if($cur[2] == 978) $euro   = str_replace(",",".",$cur[4]); 
			  } 

					if ( $dollar !== '' && $euro !== '')		{
					$zapros8 = "INSERT into _currency 
					(date, kursdollar, kurseuro)
					values 
					('$current_date', '$dollar', '$euro')"; 
							
					$link8 =  to_connect('sell');
					$result8 = $link8->query ($zapros8);  	if (!$result8)   { echo "Ошибка 8";  exit;  }
					 }
			}
$_SESSION['kursdollar'] = $kursdollar;
$_SESSION['kurseuro'] = $kurseuro;
}				
?>