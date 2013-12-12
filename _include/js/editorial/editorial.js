$(document).ready(function(){  

	   $('#pointEditor').dblclick(function() { 
										

						
						
		$('<input />').attr('id', 'input_pointEditor').css({'width':'130px', 'border':'1px solid #ececec', 'padding':'2px', 'background':'#f4f4f4', 'margin':'0 6px 0 6px' })
		.appendTo($(this));
		
		
		$('<input />').attr({'type': 'button', 'value':'OK'}).appendTo($(this)) 
		.click(function() { 
							
							var txt = $('#pointEditor :text').val()
							$.ajax({
										type: 			'POST',   
										url: 				'_include/js/editorial/checkit.php',
										data: 			{	'txt': 	txt   },
										dataType: 	'json',
										success:   window.location.reload(true)
										})
												
												});
			
			
			
			
			
		})
	   
  });  