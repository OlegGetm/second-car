$(document).ready(function() {

			$("#slider").easySlider({
				auto: true,
				continuous: true, 
				prevId: 		"prevBtn",
				nextId: 		"nextBtn",	
				speed: 		600,
				pause:		4000
				});
		
		$("#vlevo, #vpravo").mouseover( function() { $(this).css("background-position", "top") });
		$("#vlevo, #vpravo").mouseout  ( function() { $(this).css("background-position", "bottom") });
}); 
