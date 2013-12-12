var numParag = 0;

$(document).ready(function() {   addEdit();         });		


/* ..............................................................................................................................  */
	function addEdit()	{
	$('.parag_1').click(function(event) {
	
		 if ( $('#new_area').size() == 0 )  {  										// если не открыто поле редактирования
		
			var	myDiv	= $(this);														// ссылка на ред. абзац
			var innerDiv = event.target;											
																									// номер и id абзаца - извлечь из id "count_" ...
			numParag = innerDiv.id;													// ...родительского DIV
			numParag = parseInt( numParag.substr(2) );
			
			// var	textAll =  $(this).text() + '\n\u0009'; 							// текст абзаца с отступом
			var	textAll =  $(this).text() ; 												// текст абзаца 
			
			var	divHeight =  $(this).height() +40;
			var	divWidth =  $(this).width();
			
			$('<div></div>').attr('id', 'new_area').css({ 'display': 'block', 'position': 'relative' })
									.insertAfter($(this));
			
			$(this).hide();																		//  скрыть абзац
			$('.booble_line').remove();  													// скрыть реплики

		
			$('<textarea></textarea>').attr('id', 'textarea_submit')			// создать textarea
							.css({	'display': 'block', 'position': 'relative',
								 		'height':divHeight, 'width': divWidth,
										'overflow-y': 'auto', 'border-style': 'none',
										'padding': '0px 4px', 'margin': '0 0px 0 30px',
										'background-color': '#fefaee', 'font': 'bold 16px Arial,sans-serif',
									   	'line-height': '18px', 'text-indent': '30px' 	
										})
			.val(textAll).appendTo('#new_area');
            
            $('#textarea_submit').TextAreaExpander(); 

			$('<div></div>').attr('id', 'btn_ok')											// кнопка OK
								   .css({	'display': 'block', 'height': '50px', 'width': '190px',
												'position': 'absolute', 'top': '0px', 'left': divWidth+50,
												'cursor': 'pointer', 'z-index': '500',
												'background': 'url("_include/pics/edit_ok.png") no-repeat'
												  })
			.appendTo('#new_area')
			.bind('click', function() 	{ editArticle() }   );


			$('<div></div>').attr('id', 'btn_cancel')									// кнопка Cancel
								   .css({	'display': 'block','height': '48px', 'width': '90px', 
												'position': 'absolute', 'top': '50px', 'left': divWidth+50,
												'cursor': 'pointer', 'z-index': 500,
												'background': 'url("_include/pics/edit_cancel.png") no-repeat'
												  })
			.appendTo('#new_area')		
			.bind('click', function() {
													$('#new_area').remove();
													 myDiv.show();
													 addReplics();	// показать реплики 
													  });

		 	 }
			 })	} ;

/* ..............................................................................................................................  */
		function editArticle()	{
				var editedText 	= $('#textarea_submit').val();
					 //// editedText    = editedText.replace(/(\u0009)/g, ''); 		// убрать отступы
					   editedText    = editedText.replace(/(\n)/g, '\r\n'); 			// чтобы внести переводы строк в бд
						   
					$('#btn_ok').remove();
					$('#btn_cancel').remove();
					
					$.ajax({
					'url': 				'_include/js/edit_online/article/edit.php',
					'data': 					{	'article_id': 		idArticle,
													'num_parag':    numParag,
													'text': 				editedText 	},
					'dataType':	 'json',
					'type':			 'POST',
					'success':		 responseArticle
				    });
		 }

/* ..............................................................................................................................  */
		function responseArticle(data)		{
						
				var shiftt =   parseInt(data[0].num) -1;
				var olderID;
				var newID;
						
				if(parseInt(data[0].num)>1)		{					// если добавлены абзацы
						
						$(".parag_1").each(function()		{		// изменить id последующих абзацев

										olderID = (this.id);
										olderID = parseInt(olderID.substr(2));										

													if (olderID > parseInt(numParag)  )	{
													newID =  "t_" + (olderID + shiftt);
													$(this).attr('id',  newID);
													}
						 } );
						
												//$(".photo_1").each(function()		{		// изменить id последующих фото
												//						oldID = parseInt(this.id);
												//						if (oldID > parseInt(positionID) )	{
												//							newID =  oldID + parseInt(shiftt);
												//							$(this).attr('id',  newID);
												//	}} );		
				
				}
						
		$('#new_area').remove();
			
		var editedDiv = "t_" +numParag;
		var	newText = (data[0].text);
		
		$('#' + editedDiv).text(newText).show()
														.animate({backgroundColor:"#fcc8c8"}, 350)
														.animate({backgroundColor:"#f8f8f8"}, 350);
						
		var count = 0;			
		$.each(data, function(i, val) { 
						
							if(count == 0) 		{						// пропуск первого добавленного абзаца
							count++;
							}	else		{
								
							var newId = "t_" + (numParag +count);
								
							$('<div></div>').attr('id', newId).addClass('parag_1')
							.text(val.text)
							.bind( 'click', function(event) 	{addEdit()     })
							.insertAfter($('#' + 't_' + (numParag + count -1)  ))
							.css('margin', '0px 10px 0px 0px')
							.animate({backgroundColor:"#fcc8c8"}, 350)
							.animate({backgroundColor:"#f8f8f8"}, 350);
							count++;
						  }
		});
					 
		addReplics();								// показать реплики 

	}

