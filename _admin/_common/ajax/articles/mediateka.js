$(document).ready(function() {

/* ........................................................................................  */	
	$(".overme").mouseover( function() 	{ 
				
			var par =this.id;	
			
												if ($(".icon_photo").length>0) 		{
														$(".icon_photo").remove();
														$(".icon_video").remove();
												}
								 								 
			var h =  $("#" +this.id).offset().top +$("#" +this.id).height() -4 +"px" ;
			
			$("<div>").addClass("icon_photo")
			 				.css({  
									"position": "absolute",
									"top": h,  "left": "700px",
									"width": "53px", "height": "36px",
									"background-image": "url(../_common/img/icon_photo.png)",
									"cursor": "pointer"
									})
							.click(function() 	{createPhotoForm(par) } )
							.appendTo($("body")) 


			$("<div>").addClass("icon_video")
			 				.css({  
									"position": "absolute",
									"top": h, "left": "650px",
									"width": "53px",  "height": "36px",
									"background-image": "url(../_common/img/icon_video.png)",
									"cursor": "pointer"
									})
							.click(function() 	{ createVideoForm(par);  })
							.appendTo($("body")) 
		
		});


/* ........................................................................................  */	
	$(".delete_image").click( function() 	{ 
		
		var 	imageID = 	(this.id.split('_'))[1];
		var confirmText = 'Удалить эту фотографию?';
		
		
		if (confirm(confirmText)) {
							$.ajax({
										type: 			'POST',   
										url: 				'../_common/ajax/articles/delete_photo.php',
										data: 			{	'image_id': 		imageID
															},
										dataType: 	'json',
										success: 		function() { 
															var url = window.location.href;
															window.location = url;
															}
										})
		}	
	});
/* ........................................................................................  */	
	$(".delete_video").click( function() 	{ 
		
		var 	videoID = 	(this.id.split('_'))[1];
		var  confirmText = 'Удалить этот видеоролик?';
		
		if (confirm(confirmText)) {
							$.ajax({
										type: 			'POST',   
										url: 				'../_common/ajax/articles/delete_video.php',
										data: 			{	'video_id': 		videoID 		
															},
										dataType: 	'json',
										success: 		function() { 
															var url = window.location.href;
															window.location = url;
															}
										})
		}	
	});	
/* ........................................................................................  */	
	$(".textSubscribe").click( function() 	{ 
										$(".icon_photo").remove();
										$(".icon_video").remove();
		
		var 	curentID 		= 	(this.id.split('_'))[1];
		var 	typeMedia 	= 	(this.id.split('_'))[0];
		
		var $div = $(this);
		var tempText = $div .text();
		var newDIV = $('<div />');
		$div.hide();
		
		var ta = $('<textarea/>').css({'border': '1px solid #ccc', 'padding': '4px 10px', 'margin':'10px 0 10px 10px', 'width': $div.width()-30 +'px', 'height': '90px', 'background':'#fff', 'overflow':'hidden', 'font':'bold 15px Arial, sans-serif'}).val(tempText).appendTo(newDIV);

		$('<div/>').appendTo(newDIV);
		var btnOK = $('<span />').text('OK').css({'padding-left':'20px', 'text-decoration':'underline', 'cursor':'pointer'}).appendTo(newDIV).click(function() 	{
									
									newDIV.remove();
									$div.text(ta.val()).show();
									
									$.ajax({
										type: 			'POST',   
										url: 				'../_common/ajax/articles/update_text.php',
										data: 			{	
																'type': 			typeMedia,
																'id': 				curentID,
																'text': 			ta.val()
															},
										dataType: 	'json',
										success: 		function() { 
															var url = window.location.href;
														//	window.location = url;
															}
												});
										});
		
		var btnCancel = $('<span />').text('Отмена').css({'padding-left':'20px', 'text-decoration':'underline', 'cursor':'pointer'}).appendTo(newDIV).click(function() 	{
											newDIV.remove();
											$div.show();
											});
		
	newDIV.insertAfter($div);
	});


});     

/////////////////////////////////////////////////////////////////////////

/* ........................................................................................  */
function createPhotoForm(par) {


	createBlackScreen();
	
	var shiftTop = defScroll().top +140;	
	var shiftLeft = document.body.clientWidth /2 -220; 	

	var photoDIV = $('<div/>').attr('id', 'photo_form').css({'display':'block', 'position':'absolute', 'padding':'30px', 'background-color':'#fff',  'z-index': '800', 'left': shiftLeft +'px', 'top': shiftTop +'px' });

	var myForm = $('<form/>').attr({'method': 'post', 'enctype': 'multipart/form-data', 'action': '../_common/ajax/articles/add_photo.php' });
	
	$('<p/>').addClass('label').css({'padding':'0 0 4px 0'}).text('Добавить фото').appendTo(myForm);
	$('<input type="file"/>').attr({'name': 'my_photo', 'size':'40' }).addClass('editor').css({'width':'390px'}).appendTo(myForm);
		
	$('<p/>').addClass('label').css({'padding':'20px 0 4px 0'}).text('Подпись').appendTo(myForm);
	$('<textarea/>').attr('name', 'text').css({'border': '1px solid #ccc', 'padding': '4px', 'width': '380px', 'height': '70px', 'background':'#fff', 'overflow':'hidden', 'font':'bold 15px Arial, sans-serif'}).appendTo(myForm);

	$('<div/>').css({'height':'30px'}).appendTo(myForm);

	$('<img />').attr({'src': '../_common/img/btn_cancel2.png', 'width':'70', 'height':'40'}).css({'margin-left':'236px', 'cursor':'pointer'}).appendTo(myForm)
												.click(function () { 
																		$("#blackScreen").remove(); 
																		photoDIV.remove(); 
												})	;

		$('<img />').attr({'src': '../_common/img/btn_edit.png', 'width':'71', 'height':'40'}).css({'margin-left':'16px', 'cursor':'pointer'}).appendTo(myForm)
											.click(function () {  
																	photoDIV.css('left', '-10000px');
																	$("#blackScreen").css({'opacity':'0.80'});
																	createLoaderIcon();
																	myForm.submit();
											});
	
	$('<input type="hidden"/>').attr('name', 'parag').val(par).appendTo(myForm);
	$('<input type="hidden"/>').attr('name', 'car_id').val(carID).appendTo(myForm);
	
	
	myForm.appendTo(photoDIV);
	photoDIV.appendTo($('body'));
}

/* ........................................................................................  */

function createVideoForm(par) {  

	createBlackScreen();
	
	var shiftTop = defScroll().top +140;	
	var shiftLeft = document.body.clientWidth /2 -220; 	

	var videoDIV = $('<div/>').attr('id', 'video_form').css({'display':'block', 'position':'absolute',  'padding':'24px', 'background-color':'#fff',  'z-index': '800', 'left': shiftLeft +'px', 'top': shiftTop +'px' });

	var myForm = $('<form/>').attr({'method': 'post', 'action': '../_common/ajax/articles/add_video.php' });
	$('<p/>').addClass('label').css({'padding':'10px 0 4px 0'}).text('Добавить код видеоролика').appendTo(myForm);
	var tt =$('<textarea/>').attr('name', 'sourse').css({'border': '1px solid #ccc', 'padding': '4px', 'width': '280px', 'height': '70px', 'background':'#fff', 'overflow':'hidden', 'font':'bold 15px Arial, sans-serif'}).appendTo(myForm);
	$('<p/>').addClass('label').css({'padding':'10px 0 4px 0'}).text('Сопроводительный текст').appendTo(myForm);

	
	$('<textarea/>').attr('name', 'text').css({'border': '1px solid #ccc', 'padding': '4px', 'width': '280px', 'height': '70px', 'background':'#fff', 'overflow':'hidden', 'font':'bold 15px Arial, sans-serif'}).appendTo(myForm);


	$('<div/>').css({'height':'30px'}).appendTo(myForm);
	
	$('<img />').attr({'src': '../_common/img/btn_cancel2.png', 'width':'70', 'height':'40'}).css({'margin-left':'130px', 'cursor':'pointer'})
												.appendTo(myForm)
												.click(function () { 
																		$("#blackScreen").remove(); 
																		videoDIV.remove(); 
												})	;

		$('<img />').attr({'src': '../_common/img/btn_edit.png', 'width':'71', 'height':'40'}).css({'margin-left':'16px', 'cursor':'pointer'})
											.appendTo(myForm)
											.click(function () {  
																	
															if (tt.val().length>0) 		{		
																	videoDIV.css('left', '-10000px');
																	createLoaderIcon();
																	myForm.submit();
															}
											});

	$('<input type="hidden"/>').attr('name', 'parag').val(par).appendTo(myForm);
	$('<input type="hidden"/>').attr('name', 'car_id').val(carID).appendTo(myForm);
	
	
	myForm.appendTo(videoDIV);
	videoDIV.appendTo($('body'));

}

/* ..........................................................................................  */
function createBlackScreen() {	
	 
	 $('<div/>').attr('id', 'blackScreen').css({'display':'block', 'width':document.body.clientWidth +'px', 'height':document.body.clientHeight +'px',  'background':'#000', 'opacity':'0.60', 'position':'absolute', 'top':'0px', 'left':'0px', 'z-index':'20'})
	.appendTo($('body'));
}
/* ..........................................................................................  */


function defScroll() {					//  определить координаты
      var x = y = 0;
      x = (window.scrollX) ? window.scrollX : document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft;
      y = (window.scrollY) ? window.scrollY : document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
      return {left:x, top:y};
}


/* ..........................................................................................  */

function createLoaderIcon() {	
				$('<div/>').css({  
				'position': 'absolute',
				'z-index':'500',
				'left': document.body.clientWidth /2 -120 +'px', 'top': defScroll().top +280 +'px',
				'width': '160px', 'height': '24px',
				'background-image': 'url(../_common/img/loading_76.gif)'
				}).appendTo($('body'));	

}







