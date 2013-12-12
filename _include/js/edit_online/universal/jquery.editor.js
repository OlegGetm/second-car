(function($){
$.fn.universalEdior = function(sqlName, idName, hiddenBlock) {

var oldText;

return this.each(function() {

$(this).click(function(event) {

			if ( $('#new_area').size() == 0 )  {  // если не открыто поле редактирования


			var element = $(this);

			oldText =  element.text() + '\n\u0009'; 							// текст абзаца с отступом
						
			var	textareaH =  element.height() +20;
			var	textareaW = element.width();
		
			$('<div></div>').attr('id', 'new_area').css({
											'display': 'block',
											'position': 'relative'
											}).insertAfter(element);
			
			element.hide();																		//  скрыть абзац
			$('#' +hiddenBlock).css('visibility', 'hidden');							// скрыть скрываемый блок
			
			$('<textarea></textarea>').attr('id', 'textarea_submit')			// создать textarea
							.css({	 'display': 'block',
										'position': 'relative',
								 'height': textareaH,
							           		'width': textareaW+8,
											'overflow-y': 'auto',
											'border-style': 'none',
											'padding':4,
											'background-color': '#fefaee',
											'font': 'normal 14px Arial,sans-serif',
									   		'line-height': '18px',
									   		'text-indent': '30px' 	})
			.val(oldText).appendTo('#new_area');
						
			$('<div></div>').attr('id', 'btn_ok')											// кнопка OK
								   .css({	'display': 'block',
								 				'height': '50px',
							           		    'width': '90px',
												'position': 'absolute',
												'top': '0px',
												'left': textareaW+20,
												'cursor': 'pointer',
												'background': 'url("_include/pics/edit_ok.png") no-repeat'
												  })
			.appendTo('#new_area')
			.bind('click', function() 	{ 
									element.next().attr('id', 'ancor');			//создать якорь для вставки после него нового текста  
									element.remove();
									editArticle() }   );
			

			$('<div></div>').attr('id', 'btn_cancel')									// кнопка Cancel
								   .css({	'display': 'block',
								 				'height': '48px',
							           		    'width': '90px',
												'position': 'absolute',
												'top': '50px',
												'left': textareaW+20,
												'cursor': 'pointer',
												'background': 'url("_include/pics/edit_cancel.png") no-repeat'
												  })
			.appendTo('#new_area')		
			.bind('click', function() {
													$('#new_area').remove();
													 element.show();
													 $('#' +hiddenBlock).css('visibility', 'visible'); // показать скрываемый блок
												   });
			}
	});
});


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function editArticle()	{
					
				var newText 	= $('#textarea_submit').val();
					   newText    = newText.replace(/(\u0009)/g, ''); 			// убрать отступы
					   newText    = newText.replace(/(\n)/g, '\r\n'); 			// чтобы внести переводы строк в бд
						   
					$('#btn_ok').remove();
					$('#btn_cancel').remove();
					
					$.ajax({
					'url': 				'_include/js/edit_online/universal/universal.edit.php',
					'data': 					{	'sql_name': 		sqlName,
													'id_name':			idName,
													'id': 					idNomer,
													'old_text':    		oldText,
													'new_text':    	newText 	},
					'dataType':	 'json',
					'type':			 'POST',
					'success':		 responseArticle
				    });
		 }


	function responseArticle(data)	{
						
					$('#textarea_submit').remove();
					
					$.each(data, function(i, val) {
					var parText = val.paragraph;
					$('<div></div>').text(parText)
					.css('text-indent','30px')
					.universalEdior(sqlName, idName, hiddenBlock)    //  bind to click
					.insertBefore('#ancor')
					.addClass('flash');													// целеуказание для вспышки
					} );
						
					 $('.flash').animate({													//  вспышка
									backgroundColor: '#fcc8c8'
									}, 350, function() {
									$(this).animate({backgroundColor:"#fff"}, 350);
									});
					 
					 $('#edited').css('background-color', '#fff');				// на всякий случай
					 
					 $('#' +hiddenBlock).css('visibility', 'visible'); 			// показать скрываемый блок
					 $('#ancor').attr('id', '');
	}

};

})(jQuery);