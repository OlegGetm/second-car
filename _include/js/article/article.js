$(function()  {

$(".parag_1").dblclick( function() { insertMiniForm(this.id) } );

addReplics();

 $('.photo_zoom').click( function()	 { 
								  var name = $(this).attr('rel');
								  photoZoom(name);    
								  } );

});	   
/* ..............................................................................................................................  */
		function addReplics() {
					$.ajax({
							  type: "POST",   
							  url: "_include/js/article/article_replics.php",
							  data: "article=" + idArticle,
							  dataType: "json",
							  success: respArticleReplics  
						   })
		}

/* ..............................................................................................................................  */
   function respArticleReplics(data)  {

	$.each(data, function(i, val) {
	
	 var name 		= val.name.replace(/&quot;/g,'\"')								  
	var allText   	= val.text.replace(/&quot;/g,'\"')	
	var chortText 	= (allText).substr(0, 34);
	var interest 		= val.interest;
	
	var prefix 			=  '#repl_'  +val.par;
	var leftID 				= '#t_' + val.par;	
	var limitTop 		= $(leftID).offset().top + $(leftID).height();  	// нижняя точка следующего абзаца
	var boobleLine 	= $("<div></div>").addClass("booble_line").text(chortText).appendTo(prefix);
	
	if ((limitTop-30)<parseInt(boobleLine.offset().top)) 	{
	boobleLine.remove();	
	
	if( $("#komment_" +val.par).size() < 1  )
	var komMent = $("<div></div>").attr("id", "komment_" +val.par).addClass("repl")
													.css({"margin-left": "0px", "cursor":"pointer" }).text("Все комментарии блока")
													.appendTo(prefix)
													.click( function() {   
	window.location="article_replics.php?car=" +idCar + "#block_"  +val.par;   
													});
	
	}  else {
	boobleLine.bind("mouseover", function(event){   boobleLine.css("background-color", "#ffedca");
							if( $(".booble").length <2 )	{
							flashBaloon(val.nums, name, interest, allText, getAbsolutePosition(this).y )  	
							}
					});
	
	boobleLine.bind("mouseout",   function() {   	boobleLine.css("background-color", "#fff");
													 			  			hideBaloon(val.nums)    	  	
																			});
	
	boobleLine.bind("click", function() {   
	window.location="article_replics.php?car=" +idCar + "#" +val.append_to + '_' + val.par;   
	});
	
	}     //  end else

	} );
	}
/* ..............................................................................................................................  */

function getAbsolutePosition(el) {
	var r = { x: el.offsetLeft, y: el.offsetTop };
	if (el.offsetParent) {
		var tmp = getAbsolutePosition(el.offsetParent);
		r.x += tmp.x;
		r.y += tmp.y;
	}
	return r;
}


function flashBaloon(num, name, interest, texts, cordY) { 
				
			var warp = $("<div></div>").attr("id", "warp_" +num).addClass("balloon_warp") ;
			var table = $("<table></table>").attr("id", "table_" +num).addClass('balloon');
			
			var tr1 = $("<tr></tr>");
			var tr2 = $("<tr></tr>");
			var tr3 = $("<tr></tr>");
			
			$("<td></td>").addClass("b1").appendTo(tr1);
			$("<td></td>").addClass("b2").appendTo(tr1);
			$("<td></td>").addClass("b3").appendTo(tr1);
			
			$("<td></td>").addClass("b8").appendTo(tr2);
			$("<td></td>").attr("id", "content_" +num).addClass("b0").appendTo(tr2);
			$("<td></td>").addClass("b4").appendTo(tr2);
			
			$("<td></td>").addClass("b7").appendTo(tr3);
			$("<td></td>").addClass("b6").appendTo(tr3);
			$("<td></td>").addClass("b5").appendTo(tr3);
			
			tr1.appendTo(table);
			tr2.appendTo(table);
			tr3.appendTo(table);	
			table.appendTo(warp);
			
				warp.css('top', (cordY -10) +'px')
						.appendTo($("#allContent")); 			
			
			var placeText = $('<div></div>').attr('id', 'place_' +num).css({'top': cordY +'px'})
																.addClass('placeText').appendTo($('#allContent')) ;
			
			
			$("<div></div>").addClass("balloon_name").text(name).appendTo($("#place_" +num));

				var tt = new Array();
				tt = texts.split("\n");
				$.each(tt, function(i, val) {
								$("<p></p>").css({ "margin-bottom": "3px" })
								.text(val).appendTo($("#place_" +num));
								});
				if(interest == 'edit')	{
				$("<div></div>").addClass("balloon_edit")
				.text("От редакции: информация учтена при правке статьи").appendTo($("#place_" +num));	 	}

	

			$("<div></div>").attr("id", "nosik_" +num).addClass("balloon_nos").css({"top": (cordY -4) +"px"})
										.appendTo($("#allContent")) ; 


////////////////////////////////////////////
 		var baloon = new Object();
		
		baloon.num = num;
		baloon.width			= 10;
		baloon.height			= 10;
		
		baloon.endHeight 	= placeText.height() +20;
		baloon.endWidth 	= 360;
		baloon.positionTop	= cordY - (baloon.width / 2) -4;
		

		baloon.speedX 		= 18;		// скорость приращения в ширину 
		baloon.speedY 		= Math.round( baloon.speedX * baloon.endHeight / baloon.endWidth );
		
		
		baloon.expand = function() {     ///...................................................................

			baloon.width 				+= baloon.speedX;
			baloon.height 				+= baloon.speedY;
			baloon.positionTop		-=  1;

	
				if (baloon.width < baloon.endWidth && baloon.height < baloon.endHeight)    	{
						
						$('#content_' +baloon.num).css({
				   		'width': baloon.width +'px',
						'height': baloon.height +'px'}); 
			
						$("#warp_" +baloon.num).css( 'top', baloon.positionTop +'px'); 
						
						setTimeout(baloon.expand, 10);

				}	else		{
				
				$('#content_' +baloon.num).css({ 'width': baloon.endWidth +'px',  'height':  baloon.endHeight +'px'	 }); 
				$('#warp_' +baloon.num).css('top', 	baloon.positionTop +'px');
				$('#place_' +baloon.num).css({ 'top': (baloon.positionTop +20) +'px', 'left': '380px' 	}) ; 
				}
			
		}		///...................................................................
		
		 baloon.expand();

} 
/* ..............................................................................................................................  */	  
   function hideBaloon(num) {
		$("#place_" +num).remove(); 
		$("#warp_"  +num).remove();	
		$("#nosik_" +num).remove();
   }
   
   
/* ....................................... Insert Form...............................................................  */   
function insertMiniForm(reciveID) {


var n = $("#form_101").length;
if(n<1)	{      // не открывать больше одной формы

var 	id = 	(reciveID.split('_'))[1];

 var aa = $("<div>").attr("id", "#aa_" +id).addClass("div_miniForm");


var actionUrl = 'article.php?article=' +idArticle +'&number=' +id +'#' +id;
      
	 	  
var myForm = $("<form/>").attr("name", "myform").attr("action", actionUrl).attr("method", "post").attr("id", "form_101").submit( function () {  return sendform() ; } );

var myTextarea = $("<textarea/>").attr("name", "text").attr("id", "text_101").addClass("mini_textarea").appendTo(myForm);
var myName = $('<input type="text"/>').attr("name", "name").attr("id", "name_101").addClass("mini_textinput").appendTo(myForm);
var btnOk = $('<input type="submit"/>').attr("value", "OK").addClass("mini_btn_ok").appendTo(myForm);
var btnCancel = $('<input type="button"/>').attr("value", "Отмена").addClass("mini_btn_cancel")
													.click(function () { 
																	 			aa.remove();
																				 })
													.appendTo(myForm);

myForm.appendTo(aa);
 aa.hide().insertAfter('#t_' +id).fadeIn(500);

$("#text_101").focus();

} }

/* ..............................................................................................................................  */	 
			function sendform () {
			if($("#name_101").val() =="") {
			$("#name_101").focus();
			alert ("Как вас зовут?");
			return false;
					}
			else if($("#text_101").val() =="") {
			$("#text_101").focus();
			alert ("Вы не добавили комментарий");
			return false;
			}
			else {
			return true;
			}	} 
/* ..............................................................................................................................  */	 
		 
							
function photoZoom(name)	 { 

var bigImgSrc 	= '_photos/articles/big/' +name; 
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
}

/* ..............................................................................................................................  */	 
function defScroll() {					//  определить координаты
      var x = y = 0;
      x = (window.scrollX) ? window.scrollX : document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft;
      y = (window.scrollY) ? window.scrollY : document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
      return {left:x, top:y};
}
