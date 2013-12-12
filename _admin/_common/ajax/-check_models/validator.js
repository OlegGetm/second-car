var xmlHttp = createXmlHttpObject();
var showErrors = true;

function createXmlHttpObject()  {
try {
  xmlHttp = new XMLHttpRequest();
} catch (trymicrosoft) {
  try {
    xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (othermicrosoft) {
    try {
      xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (failed) {
      xmlHttp = null;
}	  }		}
			  if (!xmlHttp)		displayError("Error creating the XMLHttpRequest object.");
			  else 
				return xmlHttp;
}

function displayError($message)  { // ignore errors if showErrors is false
    if (showErrors)   {    // turn error displaying Off
    showErrors = false;
    alert("Error encountered: \n" + $message);
    // retry validation after 1 seconds
    setTimeout("validate();", 1000);
 }	}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////
function ajaxSelectModels() {
	  var brand = document.myform.brand.options [document.myform.brand.selectedIndex].text;
	  brand = encodeURIComponent(brand);
			if (xmlHttp) 	  { 	 
	  		if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0) 	 {
			 xmlHttp.open("POST", "../_common/ajax/check_models/check_models.php", true);
			xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xmlHttp.onreadystatechange = readResponseModels;
			xmlHttp.send("brand=" + brand);
			}
}   }


function readResponseModels()		{
  if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
  responseXml = xmlHttp.responseXML;
  xmlDoc = responseXml.documentElement;
  var long = xmlDoc.childNodes.length;
  long = long+1;

   		document.myform.model.options.length = 0
		document.myform.model.options[0] = new Option('Выберите');
  				for (i=1; i<long; i++)	{
				var num = i -1;
				var myModel =xmlDoc.getElementsByTagName('model')[num].firstChild.data;
			 	document.myform.model.options[i] = new Option(myModel);
				}
}	}

//////////////////////////////////////////////////////////////////////////////////////////////////////
function ajaxSelectYears()    {
if (xmlHttp) 	  { 	

	  var model = document.myform.model.options [document.myform.model.selectedIndex].text;
	  model = encodeURIComponent(model);
	  		if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0) 
		   {
			 xmlHttp.open("POST",  "../_common/ajax/check_models/check_years.php", true);
			xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xmlHttp.onreadystatechange = readResponseYears;
			xmlHttp.send("model=" + model);
			}
}	}

function readResponseYears() {
  if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
		var responseXml = xmlHttp.responseXML;
  		xmlDoc = responseXml.documentElement;
  		var long = xmlDoc.childNodes.length;
  	  		
		document.myform.year1.options.length = 0;
		document.myform.year2.options.length = 0;
				
		if (long == 2)
		{
		var myBegin =xmlDoc.getElementsByTagName('year1')[0].firstChild.data;
		var myEnd =xmlDoc.getElementsByTagName('year2')[0].firstChild.data;
		
		if (myEnd == "none") { myEnd = ""; }
		
		document.myform.year1.options[0] = new Option(myBegin);
		document.myform.year2.options[0] = new Option(myEnd);
		
		}	else {
		 document.myform.year1.options[0] = new Option('Выберите');
  		 	for (i=1; i<long+1; i++)	{
			var num = i -1;
			var myBegin =xmlDoc.getElementsByTagName('year1')[num].firstChild.data;
			 document.myform.year1.options[i] = new Option(myBegin);
		}
	}
}	}
////////////////////////////////////////////////////////////////////////////////////
function ajaxSelectYearEnd()    {
if (xmlHttp) 	  { 	 
	  var model = document.myform.model.options [document.myform.model.selectedIndex].text;
	  model = encodeURIComponent(model);
	  var yearbegin = document.myform.year_begin.options [document.myform.year_begin.selectedIndex].text;
	  yearbegin = encodeURIComponent(yearbegin);
	  
	  		if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0) 
		   {
			 xmlHttp.open("POST", "../_common/ajax/check_models/check_year_end.php", true);
			xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xmlHttp.onreadystatechange = readResponseYearEnd;
			xmlHttp.send("model=" + model + "&year1=" + year1);
			}
}	}

function readResponseYearEnd() {
  if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
	  
		var responseXml = xmlHttp.responseXML;
  		xmlDoc = responseXml.documentElement;
		var myEnd =xmlDoc.getElementsByTagName('year2')[0].firstChild.data;
		if (myEnd == "none") { myEnd = ""; }

		document.myform.year_end.options.length = 0;
		document.myform.year_end.options[0] = new Option(myEnd);

}	}
