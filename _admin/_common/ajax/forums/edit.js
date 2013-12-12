var memory_relica = '';

function changeToInput (idDiv)		{

var  aa 		  = document.getElementById('a'	+idDiv);		// вся реплика
var  ab 		  = document.getElementById('b'	+idDiv); 		// текст
var  ac 		  = document.getElementById('c'	+idDiv);		//  пустое поле для textarea
var  ad 		  = document.getElementById('d'	+idDiv);		// панель

var  oldText  = ab.firstChild.nodeValue;

ab.style.display='none';
ad.style.display='none';

eDiv = document.createElement('div');
eForm = document.createElement('form');
eForm.setAttribute('name', 'myform');

eText = document.createTextNode(oldText);

eTextarea = document.createElement('textarea');
eTextarea.setAttribute("id", "ta_" +idDiv);
eTextarea.setAttribute('name', 'text');
eTextarea.className = 'textarea_ajax'; 
eTextarea.appendChild(eText);
eForm.appendChild(eTextarea);

eButton = document.createElement('input');
eButton.setAttribute('type', 'button');
eButton.setAttribute('value', 'Править');
eButton.className = 'btn_ok'; 
eButton.onclick = function () {
												editReplica(idDiv);
												};

eForm.appendChild(eButton);

eCancel = document.createElement('input');
eCancel.setAttribute('type', 'button');
eCancel.setAttribute('value', 'Отмена');
eCancel.onclick = function () {
												ab.style.display='block';
												ad.style.display='block';
												removeChildren(ac);
												};
//eCancel.className = 'mini_btn_cancel'; 
eForm.appendChild(eCancel);
eDiv.appendChild(eForm);
ac.appendChild(eDiv);

}

///////////////////////////////////////////////////////////////////////////////////////////////
function editReplica(idDiv)	{
			
var  tt = (document.getElementById('ta_' +idDiv)).value;		//  текст из  textarea
			
			if (xmlHttp) 	  { 	 
	  		if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0) 	 {
			
			var url = '../_common/ajax/forums/edit_text_forum.php';

var params = 'tt=' + encodeURIComponent(tt) + '&portrait_id=' + idDiv;
memory_relica =  idDiv;  // запомнить номер реплики

			xmlHttp.open("POST", url, true);
			xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
			xmlHttp.onreadystatechange = newText;
			xmlHttp.send(params);
}   }	 }

function newText() {
  if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
	
		responseXml = xmlHttp.responseXML;
  		xmlDoc = responseXml.documentElement;
 	 	var newText =xmlDoc.getElementsByTagName('text')[0].firstChild.data;
	
idDiv = memory_relica;

var  ab   = document.getElementById('b'	+idDiv); 		// текст
var  ac   = document.getElementById('c'	+idDiv);		//  пустое поле для textarea
var  ad   = document.getElementById('d'	+idDiv);		//  нижняя панель
removeChildren(ac);
ab.firstChild.data = newText;
ab.style.display='block';
ad.style.display='block';
} }

/////////////////////////////////////////////////////////////////////////////////////////////

function setStatus(idReplic, radioValue)	{
	
			memory_relica = idReplic; 	// запомнить номер реплики
	
			if (xmlHttp) 	  { 	 
	  		if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0) 	 {

var url = '../_common/ajax/forums/edit_status_forum.php';

var params = 'portrait_id=' + idReplic + '&interest=' + radioValue;

			xmlHttp.open("POST", url, true);
			xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
			xmlHttp.onreadystatechange = confirmEditStatus;
			xmlHttp.send(params);
}   }	 }


function confirmEditStatus() {
  		if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
		
		responseXml = xmlHttp.responseXML;
  		xmlDoc = responseXml.documentElement;
 	 	var idRepl =xmlDoc.getElementsByTagName('id_forum')[0].firstChild.data;
		 var interest =xmlDoc.getElementsByTagName('interest')[0].firstChild.data;
		 
		var  aa = document.getElementById('a'	+memory_relica);			// вся реплика
		 
		var colorBack ="";
		if (interest == "yes") colorBack = "#fff2c7";
		if (interest == "no") colorBack = "#ccc";
		if (interest == "edit") colorBack = "#b4ff93";

		aa.style.backgroundColor = colorBack;
}	 }
///////////////////////////////////////////////////////////////////////////////////////////////////

function deleteRaw(idReplic)	{
	
	idR = idReplic;
	
	var confirmText = "Вы хотите удалить эту реплику?";
	if (confirm(confirmText)) 	{

			if (xmlHttp) 	  { 	 
	  		if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0) 	 {

			var url = '../_common/ajax/forums/delit_forum.php';
			var params = 'portrait_id=' + idReplic;

			xmlHttp.open("POST", url, true);
			xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
			xmlHttp.onreadystatechange = delitSubmit;
			xmlHttp.send(params);
			}   }
	} else { alert ('Сообщение сохранено'); }

}

function delitSubmit() {
  		if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

alert('Сообщение удалено');
var  aa = document.getElementById('a'	+idR);		// вся реплика
aa.style.display='none';

} }