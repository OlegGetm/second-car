function validate (value, id)		{

	if (id)	{
	value = encodeURIComponent(value);
	id 		  = encodeURIComponent(id);
	var tt = 'input_id=' +id +'&input_value=' +value;
	
	if (xmlHttp) 	  { 	 
	  		if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0) 	 {
			 xmlHttp.open("POST", "_include/js/registration/validator.php", true);
			xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xmlHttp.onreadystatechange = writeErrors;
			xmlHttp.send(tt);
			}	 }
	}
}

////////////////////////

function writeErrors ()		{
if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
		
		responseXml = xmlHttp.responseXML;
  		xmlDoc = responseXml.documentElement;
 	 	
		var id 				= xmlDoc.getElementsByTagName('input_id')[0].firstChild.data;
		var errorText 	= xmlDoc.getElementsByTagName('error_text')[0].firstChild.data;


var  aa  = document.getElementById('r_' +id);		// место для вывода сообщения

if(errorText == 'OK')	{
	var 	img1 = document.createElement('img');
		img1.src = "_include/pics/ok.png" ;
		img1.setAttribute('width', '36'); 
		img1.setAttribute('height', '36');
		aa.appendChild(img1);
}	else	{
var div1 = document.createElement('div');
div1.className = 'eror_text'; 
eText = document.createTextNode(errorText);
div1.appendChild(eText);
aa.appendChild(div1);
}


}	}

///////////////////////
function erase (id)		{
var  aa  = document.getElementById('r_' +id);
removeChildren(aa);
	
}