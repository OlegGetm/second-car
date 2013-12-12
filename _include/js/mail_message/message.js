$(document).ready(function() {   
				
				$('#btnMail').click(function() {  
										$('#addMail').show();
										$('#btnMail').hide();
										
										$("#message_text").focus();
										$("#mail_to").focus();

						})
						   
 });

/* ..............................................................................................................................  */

function sendMail()	{

		
		var mailTo 		= $('#mail_to').val();
		var mailFrom 	= $('#mail_from').val();
		var 	messageText 	= $('#message_text').val();
		var 	hiddenUrl 	= $('#hidden_url').val();


var reg = /^\w+([\.-]?\w+)*@(((([a-z0-9]{2,})|([a-z0-9][-][a-z0-9]+))[\.][a-z0-9])|([a-z0-9]+[-]?))+[a-z0-9]+\.([a-z]{2}|(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum))$/i;


if (!mailTo.match(reg)) {
	alert("Пожалуйста, введите правильный адрес  e-mail");
   $("#mail_to").focus();
}	

else if (!mailFrom.match(reg)) {
	alert("Пожалуйста, введите правильный адрес  e-mail");
   $("#mail_from").focus();
}	

else		{	
			$('#addMail').hide();
			$('#btnMail').show();
					
					$.ajax({
					'url': 				'_include/js/mail_message/message.php',
					'data': 					{	'mail_to': 		 mailTo,
													'mail_from':   mailFrom,
													'message': 	 messageText,
													'url':				hiddenUrl
												 },
					'dataType':	 'json',
					'type':			 'POST',
					'success':		 responseData
				    });
		 }
}
		 
/* ..............................................................................................................................  */

function hideForm()	{  	$('#addMail').hide(); 
										$('#btnMail').show();
									}
/* ..............................................................................................................................  */

function responseData(data)  {

		if (data[0].good == "yes" )  {
		alert("Письмо другу отправлено");
			
		}		else	 {
		alert("Ошибка при отправке письма");
		}
 }
