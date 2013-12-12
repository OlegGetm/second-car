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
 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

function removeChildren(node) {
   var children = node.childNodes
					  	  while(children.length) {
				  		  node.removeChild(children[0])
}	}

//////////////////////       BOOK -    ДОБАВЛЯЕМ  AJAX                      //////////////////////////////


function aElem(identifier) {
   return document.getElementById(identifier);
}



function aManageEvent(eventObj, event, eventHandler) {
   if (eventObj.addEventListener) {

      eventObj.addEventListener(event, eventHandler,false);
   } else if (eventObj.attachEvent) {
      event = "on" + event;
      eventObj.attachEvent(event, eventHandler);
   }
}

function aStopManagingEvent(eventObj,event,eventHandler) {
   if (eventObj.removeEventListener) {
      eventObj.removeEventListener(event,eventHandler,false);
   } else if (eventObj.detachEvent) {
      event = "on" + event;
      eventObj.detachEvent(event,eventHandler);
  }
}

function aCancelEvent(event) {
   if (event.preventDefault) {
      event.preventDefault(  );
      event.stopPropagation(  );
   } else {
      event.returnValue = false;
      event.cancelBubble = true;
   }
}

