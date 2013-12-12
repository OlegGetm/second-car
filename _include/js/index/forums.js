
$(document).ready(function() {

$("#tab_a1").click(function() 	{  
												$("#tab_a1").css("background", "#fff") ;
												$("#tab_a2").css("background", "url(_include/pics/bg_tab_1.jpg) repeat-x") ;
												ajSendForums('1') 
												});
$("#tab_a2").click(function()   {  
												$("#tab_a1").css("background", "url(_include/pics/bg_tab_1.jpg) repeat-x") ;
												$("#tab_a2").css("background", "#fff") ;
												ajSendForums('0') 
												});

}); 



		function ajSendForums(typeForums)	{
		$("#n333").empty();
		
					$.ajax({
									  type: 'POST',   
									  url: '_include/js/index/aj_forums.php',
									  data: 'type=' + typeForums,
									  dataType: 'json',
									  success: respForums  
								   })
		}
		
		
		function respForums(data)  {
				
			$.each(data.forums, function(i, val) {
			var url = "forum_posts.php?car=" +val.car +"&topic=" +val.topic;
			var title = val.title.replace(/&quot;/g,'\"')
			var text1 = val.brand +" " +val.model +":";
			var idName = "topic_" + (i+1);
			
			var divBlock = $("<div></div>").attr('id', idName).addClass("fm_block");
			var span = $("<span></span>").text(text1).addClass("fm_title").appendTo(divBlock);
			var div = $("<div></div>").text(title).addClass("fm_subtitle");
			var ahref = $("<a/>").attr("href", url).append(div).appendTo(divBlock);
			divBlock.appendTo($("#n333"));
			} );
		
		 }
