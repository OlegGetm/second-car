$(document).ready(function(){  
						   
		
	$('.wrap_comment').each( function(){   
						
				var 	commentID	= 	(this.id.split('_'))[1]; 		
						
				$('<span/>').text('Удалить').css({'position':'absolute', 'top':'10px', 'right':'10px','text-decoration':'underline', 'color':'#ae4529', 'font-size':'12px', 'cursor':'pointer'}).click(function(){
							
						if(confirm('Удалить этот комментарий?'))	{
							
							$.ajax({
										type: 			'POST',   
										url: 				'_include/js/editorial/comment_delete.php',
										data: 			{	'comment_id': 	commentID   },
										dataType: 	'json',
										success:   window.location.reload(true)
										})
						}
							
				})
				.appendTo($(this))
								  
	 })
 });  