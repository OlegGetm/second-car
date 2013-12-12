$(document).ready(function() {   

$("#btnShowroom").show().click( function() { showShowroomPage() } );
 });
/* ..............................................................................................................................  */

var selectedBlockNumber = "100";
var myArray = new Array()

/* ..............................................................................................................................  */
function showShowroomPage() {

var shirma = $("<div>")
.attr("id", "shirma")
.css({"display":"block", "position":"absolute", "top":"0px", "left":"0px",  "width":"1200px", "height":"1200px", "padding":"15px", "background-color": "#000", "opacity":"0.60", "z-index":"500" });

shirma.appendTo($("body"));


var showroomPage = $("<div>")
.css({"display":"block", "position":"absolute", "top":"90px", "left":"260px",  "width":"301px", "height":"450px", "z-index":"700",  "background": "url(../_common/img/showroom_page.png)"   })
.appendTo($("body"));

$("<div>")
.css({"display":"block", "position":"absolute", "top":"409px", "left":"261px",  "width":"28px", "height":"28px", "z-index":"700", "cursor":"pointer"  })
.bind("click", function() {  showroomPage.remove();
										 shirma.remove();		 })
.appendTo(showroomPage);

var lenta = $("<div>")
.css({"display":"block", "position":"absolute", "top":"202px", "left":"36px",  "width":"210px", "height":"200px", "z-index":"700", "cursor":"pointer"  })
.appendTo(showroomPage);

lenta.bind("click", function() { 
							 showroomPage.remove();
							 insertShowroom(); })


var topic = $("<div>")
.css({"display":"block", "position":"absolute", "top":"22px", "left":"40px",  "width":"237px", "height":"40px", "z-index":"700", "cursor":"pointer"  })
.appendTo(showroomPage);

topic.bind("click", function() { 
							 showroomPage.remove();
							 insertShowroomTopic(); })

var right = $("<div>")
.css({"display":"block", "position":"absolute", "top":"62px", "left":"174px",  "width":"94px", "height":"94px", "z-index":"700", "cursor":"pointer"  })
.appendTo(showroomPage);

right.bind("click", function() { 
							 showroomPage.remove();
							 openDir(); })

}
/* ..............................................................................................................................  */
function insertShowroom() {
					$.ajax({
					'url': 				'../_common/ajax/showroom/show_exsist.php',
					'data': 					{	'hello': 	"hello" },
					'dataType':	 'json',
					'type':			 'POST',
					'success':		 insertShowroomAfter
				    });
}
/* ..............................................................................................................................  */

function insertShowroomAfter(data) {

var newPage = $("<div>")
.attr("id", "newPage")
.css({"display":"block", "position":"absolute", "top":"50px", "left":"130px",  "width":"640px", "height":"840px", "padding":"15px", "background-color": "#fff", "z-index":"700" });

newPage.appendTo($("#areaToShowroom"));

			$.each(data, function(i, val) {
			myArray[i] = ({"title": val.title, "type":val.type });								  
			} )

var leftBlock = $("<div>")
.css({"display":"block", "float":"left", "width":"274px", "height":"816px"  });
leftBlock.appendTo(newPage);
	

for (var i=1; i<11; i++)	{
	
$("<div>")
.attr("id", "topic_" +i)
.css({"display":"block", "position":"relative", "width":"232px", "height":"72px", "margin":"0 0 10px 0", "background-color": "#eaeaea"  })
.click(function () {
				 if ( $(this).text().length > 0)  { 												
				 alert("Сначала следует очистить этот блок");
				 }		else {
				 
							if(selectedBlockNumber != "100")	{
							$("#topic_" +selectedBlockNumber).css({"background-color": "#eaeaea"  });
							}
							$(this).css({"background-color": "#cd9a9a"  }) 
							selectedBlockNumber = (this.id).substr(6);
				 }
							})
.appendTo(leftBlock);	

 
 if(   myArray[i-1]["title"] != "no"   )  { 
 		$("#topic_" +i).css({"background-color": "#ffecca"  })
		
		$("<div>")
		.css({"position":"absolute", "top":"6px", "left":"10px", "font-weight":"bold"})
		.text(myArray[i-1]["title"]).appendTo($("#topic_" +i)) ;	
		
		$("<div>")
		.css({"position":"absolute", "bottom":"6px", "right":"10px" })
		.text(myArray[i-1]["type"]).appendTo($("#topic_" +i)) ;	
	
		var top = 82 * (i-1) +15 +"px";
		$("<div>")
		.attr("id", "delete_" +i)
		.css({"display":"block", "position":"absolute", "width":"19px", "height":"17px", "top": top, "left":"248px", "background": "#ccc url(../_common/img/showroom_delit.png)", "cursor":"pointer"  })
		.click(function () { 
					 if (confirm("Вы хотите очистить блок?")) {  deleteData((this.id).substr(7)); 	} 
					})
		.appendTo(newPage);	
		}
	}

var rightBlock = $("<div>")
.css({"display":"block", "float":"left", "width":"364px", "height":"816px" });
rightBlock.appendTo(newPage);


$("<div>").css({ "color": "#ccc", "margin":"10px 0 4px 0"  }).text("Заголовок")
.appendTo(rightBlock);	

$('<input type="text"/>').attr({ "id":	"title_a", "maxlength":"79" })
.css({"width":"340px", "height":"22px", "font":"normal 14px Arial, sans-serif", "padding":"4px 2px 1px" })
.val(title)
.appendTo(rightBlock);

$("<div>").css({ "color": "#ccc", "margin":"30px 0 4px 0"  }).text("Текст")
.appendTo(rightBlock);

$("<textarea/>").attr({ "id": "text_a" })
.css({"width":"340px", "height":"300px", "font":"normal 14px Arial, sans-serif", "padding":"2px" })
.text(txt)
.appendTo(rightBlock);

$('<input type="button"/>').attr("value", "OK")
.css({"margin-top":"10px", "padding":"0 6px", "font-weight":"normal", "cursor":"pointer" })
.click(function () { 
				 if (selectedBlockNumber != "100")		{

				$(this).remove(); 
				$("#btnCancel").remove();
				sendData(); 
								
				 }	else { alert("Выделите блок, в который будет добавлена заметка")}
				 })
.appendTo(rightBlock);

$('<input type="button"/>').attr({"value":"Отмена", "id": "btnCancel" })
.css({"margin-left":"20px", "padding":"0 4px", "cursor":"pointer" })
.click(function () {
							newPage.remove(); 
							$("#shirma").remove();
							})
.appendTo(rightBlock);

}
/* ..............................................................................................................................  */

function sendData() {

var editedText  = $("#text_a").val().replace(/(\n)/g, '\r\n'); 		// чтобы внести переводы строк в бд

$.ajax({
					'url': 				'../_common/ajax/showroom/showroom.php',
				
					'data': 					{	'pos': 		selectedBlockNumber,
													'title':   		$("#title_a").val(),
													'text': 		editedText,
													'url':      	url,
													'letter_id': letterId,
													'type': 		type,
													'photo': 	photo
													},
					'dataType':	 'json',
					'type':			 'POST',
					'success':		 responseData
				    });
}
/* ..............................................................................................................................  */
function deleteData(num) {
			$.ajax({
					'url': 				'../_common/ajax/showroom/showroom.php',
					'data': 					{	'delete': 'yes',
													'pos': 	num,
													'url':      url,
													'type':  type
													},
					'dataType':	 'json',
					'type':			 'POST',
					'success':		 responseDelete
				    });
}
/* ..............................................................................................................................  */

function responseData(data) {
	
if (data[0].good == "yes" )  {
			$("#newPage").remove();
			$("#shirma").remove();
		}		else	 {
		alert("Ошибка при записи ");
		}
		}
/* ..............................................................................................................................  */

function responseDelete(data) {
	
if (data[0].good == "yes" )  {
				$("#newPage").remove();
				$("#shirma").remove();	
				insertShowroom();
				//alert("Блок очищен");
		}		else	 {
		alert("Ошибка при удалении");
		}
		}


