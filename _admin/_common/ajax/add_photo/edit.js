var loaderFlag = 0;

var mId = '';
var mParag = '';
var mBrand = '';
var mModel = '';
var mYearBegin = '';
var mType = '';

function magicForm (id, parag, brand, model, yearBegin)		{
	
mId = id;
mParag = parag;
mBrand = brand;
mModel = model;
mYearBegin = yearBegin;

var  aa 		  = document.getElementById('showform_'	+parag);		// место для формы
var  ab 		  = document.getElementById('a_'  +parag);		// текстовой блок

var h1 = ab.offsetHeight;
aa.style.top= h1+"px";

	var forms = document.getElementsByTagName('form');
	if (forms.length<1)   {  // не открывать больше одной формы

 var actionUrl = '../_common/ajax/add_photo/plus_photo.php?article_id=' +id  +'&num_parag=' +parag +'&brand=' +encodeURIComponent(brand)+'&model=' +encodeURIComponent(model) +'&year_begin=' +yearBegin;

eDiv = document.createElement('div');

eForm = document.createElement('form');
eForm.setAttribute('name', 'myform');
eForm.setAttribute("enctype","multipart/form-data");
eForm.setAttribute("method","post");
eForm.setAttribute("id", "x_" +parag);
eForm.className = 'magic_form';
eForm.setAttribute('action', actionUrl);
eForm.setAttribute('target', "hiddenframe");

eFile = document.createElement('input');
eFile.setAttribute('type', 'file');
eFile.setAttribute('name', 'my_photo');
eFile.className = 'div_5'; 
eFile.setAttribute('size', '30');
eForm.appendChild(eFile);

eDiv1 = document.createElement('div');
eDiv1.className = 'div_5'; 
eText1 = document.createTextNode('Alt');
eDiv1.appendChild(eText1);
eForm.appendChild(eDiv1);

eAltText = document.createElement('input');
eAltText.setAttribute('type', 'text');
eAltText.setAttribute('name', 'alt_text');
eAltText.className = 'photo_alt'; 
eForm.appendChild(eAltText);

eDiv2 = document.createElement('div');
eDiv2.className = 'div_5'; 
eText2 = document.createTextNode('Подпись');
eDiv2.appendChild(eText2);
eForm.appendChild(eDiv2);

eTextarea = document.createElement('textarea');
eTextarea.setAttribute("id", "x_" +parag);
eTextarea.setAttribute('name', 'text');
eTextarea.className = 'photo_textarea'; 
eForm.appendChild(eTextarea);

eButton = document.createElement('input');
eButton.setAttribute('type', 'submit');
eButton.setAttribute('value', 'Добавить');
eButton.className = 'btn_ok'; 

eForm.appendChild(eButton);

eCancel = document.createElement('input');
eCancel.setAttribute('type', 'button');
eCancel.setAttribute('value', 'Отмена');
eCancel.className = 'btn_cancel'; 
eCancel.onclick = function () {
												removeChildren(aa);
												};
eForm.appendChild(eCancel);

eDiv.appendChild(eForm);
aa.appendChild(eDiv);
	}
}


//////////////////////  загрузка фото /////////////////////////////////////////////////////

function loaderFrame() 		{
		if(!loaderFlag) 		{
  		loaderFlag = 1;
  		return;
		}

//Этот код будет выполняться после полной отправки данных
parag = mParag;
id 	= mId;

var  aa 		  = document.getElementById('showform_'	+parag);		// место для формы
removeChildren(aa);
var  ac 		  = document.getElementById('c_'	+parag);		// место для иконки
removeChildren(ac);

//alert("Файл загружен!");

if (xmlHttp) 	  { 	 
	  		if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0) 	 {
			
			var url = '../_common/ajax/add_photo/photo_to_page.php';
			var params = 'article_id=' + id  + '&num_parag=' + parag;

//alert (params);

			xmlHttp.open("POST", url, true);
			xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
			xmlHttp.onreadystatechange = backPhotoToPage;
			xmlHttp.send(params);
}	}
}

///////////////////////////   реакция на загрузку фото   ///////////////////////////

function backPhotoToPage ()		{

  		if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
		
		responseXml = xmlHttp.responseXML;
  		xmlDoc = responseXml.documentElement;
 	 	
		var imgName 	= xmlDoc.getElementsByTagName('img_name')[0].firstChild.data;
		var awidth		 	= xmlDoc.getElementsByTagName('width')[0].firstChild.data;
		var aheight 		= xmlDoc.getElementsByTagName('height')[0].firstChild.data;
		var altText 		= xmlDoc.getElementsByTagName('alt_text')[0].firstChild.data;
		var text 			= xmlDoc.getElementsByTagName('text')[0].firstChild.data;
		 
		 aheight = aheight*0.8;
		 awidth = awidth*0.8;
				parag = mParag;
				id 	= mId;
		
		var  d0 = document.getElementById('photo_'	+parag);			// место под фото
		d0.className = 'add_photo_0';
		
		img1 = document.createElement('img');
		img1.src = "../../../../_photos/articles/" +imgName ;
		img1.setAttribute('width', awidth); 
		img1.setAttribute('height', aheight);
		d0.appendChild(img1);
		
		dtxt = document.createElement('div');
		dtxt.setAttribute("id", "text_area_" +parag);
		d0.appendChild(dtxt);
		
		dalttxt = document.createElement('div');
		dalttxt.setAttribute("id", "alttext_area_" +parag);
		d0.appendChild(dalttxt);
		
		d1 = document.createElement('div');
		d1.setAttribute("id", "text_" +parag);
		d1.className = 'add_photo_1';
		d1.setAttribute('onclick', 'changeToInput(' +id +', ' +parag +', ' + '\'text\');');
		eText = document.createTextNode(text);
		d1.appendChild(eText);
		d0.appendChild(d1);
		
		d2 = document.createElement('div');
		d2.setAttribute("id", "alttext_" +parag);
		d2.className = 'add_photo_2';
		d2.setAttribute('onclick', 'changeToInput(' +id +', ' +parag +', ' + '\'alt_text\');');
		eAlt = document.createTextNode(altText);
		d2.appendChild(eAlt);
		d0.appendChild(d2);
		
		d3 = document.createElement('div');
		d3.className = 'add_photo_3';
		d3.setAttribute('onclick', 'delitPhoto(' +id +', ' +parag +' );');

		img2 = document.createElement('img');
		img2.src = "/_admin/_common/img/btn_delit.jpg";
		d3.appendChild(img2);
		d0.appendChild(d3);
		
		d4 = document.createElement('div');
		d4.className = 'add_photo_4';
		d4.setAttribute('onclick', 'replacePhoto(' +id +', ' +parag +' );');

		img3 = document.createElement('img');
		img3.src = "/_admin/_common/img/btn_replace.jpg";
		d4.appendChild(img3);
		d0.appendChild(d4);
		
}	 }

///////////////////////////////    при клике появляется форма редактирования  текста   /////////////////////

function changeToInput (id, parag, type)		{

var  ar 		  			= document.getElementById('photo_'	+parag);				// весь блок с фото

if (type == 'text')	{
		var  aEdited 		= document.getElementById('text_'	+parag);				// подпись
		var  aNoEdited 	= document.getElementById('alttext_'	+parag);			// alt-подпись
		var  ab 		  		= document.getElementById('text_area_'	+parag);		// место для textarea

}		else		{
	
		var  aEdited 		= document.getElementById('alttext_'	+parag);		
		var  aNoEdited 	= document.getElementById('text_'	+parag);			
		var  ab 		  		= document.getElementById('alttext_area_'	+parag);		// место для textarea
}

var  oldText  = aEdited.firstChild.nodeValue;
aEdited.style.display='none';
aNoEdited.style.display='none';

eDiv = document.createElement('div');
eForm = document.createElement('form');
eForm.setAttribute('name', 'myform');

eText = document.createTextNode(oldText);

eTextarea = document.createElement('textarea');
eTextarea.setAttribute("id", "ta_" +parag);

if (type == 'text')	{
eTextarea.setAttribute('name', 'text');
}	else		{
eTextarea.setAttribute('name', 'alt_text');
}
eTextarea.className = 'textarea_ajax_2'; 
eTextarea.appendChild(eText);
eForm.appendChild(eTextarea);

eButton = document.createElement('input');
eButton.setAttribute('type', 'button');
eButton.setAttribute('value', 'Править');
//eButton.className = 'btn_ok'; 
eButton.onclick = function () {
												editText(id, parag, type);
												};
eForm.appendChild(eButton);

eCancel = document.createElement('input');
eCancel.setAttribute('type', 'button');
eCancel.setAttribute('value', 'Отмена');
eCancel.onclick = function () {
												aEdited.style.display='block';
												aNoEdited.style.display='block';
												removeChildren(ab);
												};
//eCancel.className = 'mini_btn_cancel'; 
eForm.appendChild(eCancel);
eDiv.appendChild(eForm);
ab.appendChild(eDiv);

}

/////////////////////    редактирование подписи - отправка на сервер   ///////////////////////
function editText(id, parag, type)	{
			
		var  aa	= document.getElementById('ta_'	+parag);		// место для textarea
		var  tt = aa.value;		//  текст из  textarea
			
			if (xmlHttp) 	  { 	 
	  		if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0) 	 {
			
			var url = '../_common/ajax/add_photo/edit_text.php';

var params = 'tt=' + encodeURIComponent(tt) + '&article_id=' +id  +'&num_parag=' +parag +'&type=' +type;

mId = id;					// запомнить номер id и параграфа
mParag = parag;  	//
mType = type;  		//

			xmlHttp.open("POST", url, true);
			xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
			xmlHttp.onreadystatechange = newText;
			xmlHttp.send(params);
}   }	 }


/////////////////////    реакция на редактирование подписи  ///////////////////////

function newText() {
  if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
	
		responseXml = xmlHttp.responseXML;
  		xmlDoc = responseXml.documentElement;
 	 	var newText =xmlDoc.getElementsByTagName('text')[0].firstChild.data;
	
id = mId;
parag = mParag; 
type = mType;  
//alert(newText);

if (type == 'text')	{
var  aa 		= document.getElementById('text_area_'	+parag);	
var  ab 		= document.getElementById('text_'	+parag);				// подпись
var  ac 	= document.getElementById('alttext_'	+parag);			// alt-подпись
}  else    {
var  aa 		= document.getElementById('alttext_area_'	+parag);	
var  ab 		= document.getElementById('alttext_'	+parag);				// подпись
var  ac 	= document.getElementById('text_'	+parag);			// alt-подпись
}	
//var  ac   = document.getElementById('c'	+idDiv);		//  пустое поле для textarea
//var  ad   = document.getElementById('d'	+idDiv);		//  нижняя панель
removeChildren(aa);
ab.firstChild.data = newText;
ab.style.display='block';
ac.style.display='block';
} }

//////////////////////////////////////  удаление блока с фото   ///////////////////////////////////////

function delitPhoto(id, parag)			{
	
//mId = id;					// запомнить номер id и параграфа
//mParag = parag;  	//	

	var confirmText = "Вы хотите удалить это фото?";
	if (confirm(confirmText)) 	{

			if (xmlHttp) 	  { 	 
	  		if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0) 	 {

			var url = '../_common/ajax/add_photo/delit_photo.php';
			var params = 'article_id=' +id  +'&num_parag=' +parag;

			xmlHttp.open("POST", url, true);
			xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
			xmlHttp.onreadystatechange = delitSubmit;
			xmlHttp.send(params);
			}   }
			
	      var  aa = document.getElementById('photo_'	+parag);		// весь блок с  фото
		  var  ab = document.getElementById('c_'	+parag);		
		  removeChildren(aa);
		  aa.className = '';

brand = mBrand;
model = mModel;
yearBegin = mYearBegin;
		
		var  d0 = document.getElementById('c_'	+parag);			
		d0.className = 'add_photo_5';
		d0.setAttribute('onMouseOver', 'showLayer(' +parag +');');
		d0.setAttribute('onMouseOut', 'hiddenLayer(' +parag +');');		
		d0.setAttribute('onclick', 'magicForm(' +id +', ' +parag +', ' +'\'' +brand  +'\', ' +'\'' +model  +'\', '  +yearBegin  +');');		
		
		d1 = document.createElement('div');
		d1.className = 'add_photo_6';
		d1.setAttribute("id", "b_" +parag);
		
		img1 = document.createElement('img');
		img1.src = "/_admin/_common/img/fotik.png" ;
		img1.setAttribute('width', '60'); 
		img1.setAttribute('height', '43');
		d1.appendChild(img1);
		
		d0.appendChild(d1);

		
	} else { alert ('Фотография сохранена'); }

}

//////////////////////////////////////   реакция на удаление блока с фото   ///////////////////////////////////////

function delitSubmit() {

//parag = mParag; 

if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

alert ('Фотография удалена');

} }




