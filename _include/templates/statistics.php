<?php
$name_table = 'statist_secondcar';

$year 		= date('Y');
$month 	= date('m');
$day 		= date('d');
$hour 		= date('H');

$date_text = $year .'_' .$month .'_' .$day;

$ip = '';   		if($_SERVER['REMOTE_ADDR'])				{ $ip =  $_SERVER['REMOTE_ADDR'] 		.'::';	}
$agent = '';   
if($_SERVER['HTTP_USER_AGENT']  && (strstr($_SERVER['HTTP_USER_AGENT'], 'bot') || strstr($_SERVER['HTTP_USER_AGENT'], 'Bot'))  )	 { 	 // если  бот, записать user_agent
$agent =  $_SERVER['HTTP_USER_AGENT']  .'::';	
}    

$referer = '';

if( strlen($_SESSION['refer'])>0  )	{		  
					$referer = urldecode($_SESSION['refer']);
				//	$referer = iconv('utf-8', 'windows-1251' , $referer);
					$referer = $referer .'::';
}


$q =    "SELECT * 
 			FROM $name_table
			WHERE date_text 	=  '$date_text'  
			AND hour = '$hour'   ";
$result = $link->query ($q); 
$num = $result->num_rows;


if  ( $_SESSION['visited'] !== 'yes'  && 	!strstr($referer, 'second-car') ) 	{	///////////////// новый посетитель
	
	if(strlen($agent>0))	$stroka = ''; else $stroka = 'visits = visits +1,';  // плюс посетитель если не бот
	
	
				if ($num >0)		{	// есть строчка в бд  с этим часом, увеличить кол-во уникальных посещений
				$q = "UPDATE $name_table SET
								  " .$stroka ."
								  pages = pages +1,
								  referers = concat(referers, '$referer'),
								  ip = concat(ip, '$ip'),
								  agents = concat(agents, '$agent')
								 WHERE date_text 	=  '$date_text'  
								 AND hour = '$hour'   ";
								  
				$result = $link->query ($q); 
	
				}		else	{		//  первый заход посетителей в этот час, создать новую строчку в бд
				$q = "INSERT into $name_table
								(date_text, hour, visits, pages, referers, ip, agents)
								VALUES 
								('$date_text', '$hour',  '1', '1', '$referer', '$ip', '$agent')  "; 	
				$result = $link->query ($q); 	
				}
	
}		else	  {	        										/////////////////  не новый посетитель 
							if ($num >0)		{	// увеличить кол-во просмотров страниц
							$q = "UPDATE $name_table SET
										pages = pages +1
								 		WHERE date_text 	=  '$date_text'  
								 		AND hour = '$hour'   ";
							$result = $link->query ($q); 
							}	
}

if(!isset($_SESSION['visited']))   		$_SESSION['visited'] = 'yes';

?>