
function defScroll() {					//  определить координаты
      var x = y = 0;
      x = (window.scrollX) ? window.scrollX : document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft;
      y = (window.scrollY) ? window.scrollY : document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
      return {left:x, top:y};
}


function sendForm () {
var inputName = document.myform.name.value;
var inputText = document.myform.text.value;
		if(inputName.length == 0)  		 {
				alert ("Укажите ваше имя");
				return false;
		}   else if(inputText.length == 0) 		 {
				alert ("Добавьте текст");
				return false;
		}   else { 	document.myform.submit(); 		}
}

function toggleForm() {  $("#form_1, #buttonForm").toggle()  }


//////////////////////////////////////////////////
$(function()  {


		   $('.photo_zoom').click( function()	 { 
							
	
var bigImgSrc 	= '_photos/letters/' +$(this).attr('rel');
var directory 	= '_include/pics/fancy-zoom';

var ext				= ($.browser.msie && parseInt($.browser.version.substr(0,1)) < 7) ?  'gif' : 'png';


 var loadPic = new Image();
 loadPic.src =  bigImgSrc;
 
  if ($('#zoom').length == 0) {
    
    var tabl = '<div id="zoom" style="display:none; position:absolute; z-index:100;"> \
                  <table style="border-collapse:collapse;"> \
                    <tbody> \
                      <tr> \
                        <td class="tl" style="background:url(' + directory + '/tl.' + ext +') 0 0 no-repeat; width:20px; height:20px; overflow:hidden;" /> \
                        <td class="tm" style="background:url(' + directory + '/tm.' + ext +') 0 0 repeat-x; height:20px; overflow:hidden;" /> \
                        <td class="tr" style="background:url(' + directory + '/tr.' + ext +') 100% 0 no-repeat; width:20px; height:20px; overflow:hidden;" /> \
                      </tr> \
                      <tr> \
                        <td class="ml" style="background:url(' + directory + '/ml.' + ext +') 0 0 repeat-y; width:20px; overflow:hidden;" /> \
                        <td class="mm" style="background:#fff; vertical-align:top; padding:4px;"> \
                          <div id="zoom_content" style="padding:1px 1px;"> \
                          <img id="content_image" src= "' +bigImgSrc + '" /> \
						  </div> \
                        </td> \
                        <td class="mr" style="background:url(' + directory + '/mr.' + ext +') 100% 0 repeat-y;  width:20px; overflow:hidden;" /> \
                      </tr> \
                      <tr> \
                        <td class="bl" style="background:url(' + directory + '/bl.' + ext +') 0 100% no-repeat; width:20px; height:20px; overflow:hidden;" /> \
                        <td class="bm" style="background:url(' + directory + '/bm.' + ext +') 0 100% repeat-x; height:20px; overflow:hidden;" /> \
                        <td class="br" style="background:url(' + directory + '/br.' + ext +') 100% 100% no-repeat; width:20px; height:20px; overflow:hidden;" /> \
                      </tr> \
                    </tbody> \
                  </table> \
                    <div id="zoom_close"  style="display:block; background:url(' + directory + '/closebox.' + ext +') no-repeat; position:absolute; top:0; right:0; width:30px; height:30px; cursor:pointer;"></div> \
                </div>';
	

var blackScreen = $('<div/>').css({'display':'block', 'width':document.body.clientWidth +'px', 'height':document.body.clientHeight +'px', 'background':'#000', 'opacity':'0.40', 'position':'absolute', 'top':'0px', 'left':'0px', 'z-index':'20'})
	.appendTo($('body'));

    $('body').append(tabl);
	

	var shiftTop = defScroll().top +20;	
	
	var wScreen    = document.body.clientWidth
	var shiftLeft = 0;
	if(wScreen>900)		{ 	shiftLeft = (wScreen - 900) /2 -30; 	}	

	$('#zoom').css({'left': +shiftLeft +'px', 'top': +shiftTop +'px', 'cursor':'pointer'}).show();
	
	$('#zoom, #zoom_close').bind('click', function() { $('#zoom').remove();
																		 		  blackScreen.remove();
																					} );

		}
  
	});
		   
});