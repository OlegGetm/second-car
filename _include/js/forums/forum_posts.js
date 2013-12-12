function showForm()  {
			
			$("#button_1").fadeOut("fast", function(){$("#a6").fadeIn(1200)} );	
			}


function hideForm()  {
			$("#a6").fadeOut("fast", function(){$("#button_1").fadeIn(1800)} );
			}

function submitForm()  {
			$("#a6").hide();
			document.myform.submit();
			}


function showFormDown(level, postID)  {

		$('#input_level').val(level);
		$('#input_parentID').val(postID);
		
			showForm();
			window.location.href="#bottom";
			}


function quoteForm(id)  {
			
			var quoteAuthor = $("#author_" +id).text();         // имя цитируемого автора 
			var quoteText =	getSelectedText();					// текст цитаты

			if (quoteText.length == 0) {									// если выделения нет, цитата - все сообщение
				var nn = "#message_" +id;
				quoteText = '';
				$(nn +" >p").each( function()	{						//игнорируем вложенные цитаты
										quoteText =	quoteText +$(this).text() + '\n' ;
										} );

				quoteText = quoteText.replace(/(\n$)/, '');		// убрать последний перевод строки (лишний)
				}
			
			$("#quote_text").val(quoteText);
			$("#quote__author").val(quoteAuthor);
	
			$("#quote_block").show();
			showFormDown();
		
		}




function getSelectedText()		{           							// показ выделенного текста
					if(window.getSelection)				{
					return window.getSelection().toString();
				
				}	else if(document.getSelection)	{
					return document.getSelection();
				
				}	else if(document.selection)			{
					return document.selection.createRange().text;
				}
			}

