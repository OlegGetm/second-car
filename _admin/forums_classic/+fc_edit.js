$(function()  {
$(".text_edit").click( function() { textEdit(this.id) } );

$(".delete_topic").click(function () { 
								   
								   	var 	topicID		= 	(this.id.split('_'))[1]; 
									respDelitTopic(topicID)
													})

});	   


///////////////////////

function textEdit(id) {

var n = $("#single_button").length;
if(n<1)	{      					// не открывать больше одной формы

var tBox = $("#" +id);
var h 	= tBox.height();
var w 	= tBox.width();
var pd 	= tBox.css("padding");

var txt 	= tBox.html();			
	
var tArea = $("<textarea />").attr("id", "ta_" +id).addClass("temp_textarea")
									.css({  "width": w,
												"height": h+40,
												"padding": pd 	})
									.val(txt);
	
var divBox =$("<div>").attr("id", "box_" +id)
									.css({	"display": "block",
										      	"position": "relative",
										   		"width": w,
										   		"height": h+74  })
									.append(tArea);
			
var btnOK  =$("<div>").attr("id", "single_button")
									.css({	"display": "block",
											   "position": "absolute",
											   "bottom": "8px",
											   "right": "30px",
											   "width": "63px",
											   "height": "25px",
											   "background": "url('../_common/img/forum_btn_OK.png') no-repeat",
											   "cursor": "pointer"	})
				.click(function () {
				 var newText = tArea.val();
				 $("#single_button").css("left", "-1000px");
				 $("#button2").css("left", "-1000px");
				 $("#button3").css("left", "-1000px");    		
				  $.ajax({
							  type: "POST",   
							  url: "+fc_edit.php",
							  data: "post_id=" + id +"&message=" +newText,
							  dataType: "json",
							  success: respEditForum  
							})
				})
				 .appendTo(divBox);
								
var btnCancel  =$("<div>").attr("id", "button2")
										.css({
									   "display": "block",
									   "position": "absolute",
									   "bottom": "8px",
									   "right": "-30px",
									   "width": "63px",
									   "height": "25px",
									   "background": "url('../_common/img/forum_btn_Cancel.png') no-repeat",
									   "cursor": "pointer"
										}).click(function () {
																		divBox.remove(); 
																		tBox.show();
																		})
								.appendTo(divBox);
	
var btnDelit  =$("<div>").attr("id", "button3")
							.css({   "display": "block",
									   "position": "absolute",
									   "top": "0px",
									   "left": tBox.width()+18,
									   "width": "34px",
									   "height": "28px",
									   "background": "url('../_common/img/btn_delit.jpg') no-repeat",
									   "cursor": "pointer"  })
							.click(function () {
											 			respDelitPost(id)
														})
							.appendTo(divBox);	
	
	tBox.hide();
	divBox.insertAfter(tBox);
}	}

////////// ответ ajax
function respEditForum(data)  {      
	
	$.each(data.forum, function(i, val) {
    var newMessage = val.message.replace(/&quot;/g,'\"');		
	
	if ($.browser.msie)	{
	var newMessage 	= newMessage.replace(/\n/g, '<BR>');
	}  else {
	var newMessage 	= newMessage.replace(/\n/g, '<br>');		}
	
	var idPost = val.post_id;
	var rgbString = $("#" +idPost).parent().css("background-color");  // узнать перовоначальный цвет фона 
	
	if ($.browser.msie)			{
	var hexString 	= rgbString;
	}  else {
	hexString = RGBToHex(rgbString);     // функция ниже
	}

	
	 $("#box_" +idPost).remove(); 
	 $("#" +idPost).html(newMessage).show()
	 .animate({backgroundColor:"#e18383"}, 350)
	 .animate({backgroundColor: hexString}, 350);
	});
}


/////////////////////////////////////////////////////////////////////////////////
function respDelitPost(id)  {  
	
var confirmText = "Вы хотите удалить сообщение?";
if (confirm(confirmText)) {
	
	$.ajax({
				type: "POST",   
				url: "+fc_delit.php",
				data: "post_id=" + id,
				dataType: "json",
				success: 		function(data)		{ 
																var idPost = '#row_' + data[0].post_id;
																$(idPost).remove();
																}	
				})
} }

/////////////////////////////////////////////////////////////////////////////////
function respDelitTopic(topicID)  {  
	
var confirmText = "Вы хотите удалить всю тему форума?";
if (confirm(confirmText)) {
	
	$.ajax({
				type: "POST",   
				url: "+fc_delit.php",
				data: 	{	"topic_id":   topicID,
								"type": "delete_topic"
							},
				dataType: "json",
				success: 		function(data)		{   history.back();  	}	
				})
} }

/////////////////////////////////////////////////////////////////////////////////

function RGBToHex(value) {
        var re = /\d+/g;
        var matches = value.match(re);
        for( var i = 0; i < matches.length; i++ ) {
                matches[i] = parseInt(matches[i]).toString(16);
                if( matches[i].length < 2 ) matches[i] = '0'+matches[i];
        }
        return "#" + matches[0] + matches[1] + matches[2];
}

	
	
	
	
	