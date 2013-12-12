

var selectedBlock = "100";


function insertShowroomTopic() {


var newPage = $("<div>")
.attr("id", "newPage")
.css({"display":"block", "position":"absolute", "top":"50px", "left":"130px",  "width":"690px", "height":"400px", "padding":"15px", "background-color": "#fff", "z-index":"700" });

newPage.appendTo($("#areaToShowroom"));

for (var i=1; i<5; i++)	{
	
$("<div>")
.attr("id", "topic_" +i)
.css({"display":"block", "position":"relative", "width":"162px", "height":"110px", "float":"left", "margin":"0 10px 0 0", "cursor":"pointer", "background-color": "#eaeaea"  })
.click(function () {
				 
							if(selectedBlock != "100")	{
							$("#topic_" +selectedBlock).css({"background-color": "#eaeaea"  });
							}
							$(this).css({"background-color": "#cd9a9a"  }) 
							selectedBlock = (this.id).substr(6);
							})
.appendTo(newPage);	
}
 
 $("<div>").css({"display":"block", "clear": "both", "width":"10px", "height":"50px" })
.appendTo(newPage);	
 

$("<div>").css({"display":"block", "color": "#ccc", "margin":"0 0 4px 70px" }).text("Заголовок")
.appendTo(newPage);	

$('<input type="text"/>').attr({ "id":	"title_a", "maxlength":"79" })
.css({"width":"440px", "height":"22px", "font":"bold 16px Arial, sans-serif", "margin":"0 0 0 70px",  "padding":"2px 0 2px  2px" })
.val(title)
.appendTo(newPage);

$("<div>").css({ "clear":"both", "color": "#ccc", "margin":"20px 0 4px 70px"  }).text("Подзаголовок (внизу)")
.appendTo(newPage);	

$('<input type="text"/>').attr({ "id":	"title_b", "maxlength":"79" })
.css({"width":"340px", "height":"22px", "font":"bold 16px Arial, sans-serif", "padding":"4px 2px 1px", "margin":"0 0 0 70px" })
.appendTo(newPage);



$('<input type="button"/>').attr("value", "OK")
.css({  "margin":"50px 20px 0px 270px", "padding":"0 6px", "font-weight":"normal", "cursor":"pointer" })
.click(function () { 
				 if (selectedBlock != "100")		{

				$(this).remove(); 
				$("#btnCancel").remove();
				sendTopic();
				newPage.remove(); 
				shirma.remove();
								
				 }	else { alert("Выделите блок, в который будет добавлена заметка")}
				 })
.appendTo(newPage);

$('<input type="button"/>').attr({"value":"Отмена", "id": "btnCancel" })
.css({"margin-left":"20px", "padding":"0 4px", "cursor":"pointer" })
.click(function () {
							newPage.remove(); 
							$("#shirma").remove();
							})
.appendTo(newPage);

}
/* ..............................................................................................................................  */

function sendTopic() {



$.ajax({
					'url': 				'../_common/ajax/showroom_topic/showroom_topic.php',
				
					'data': 					{	'pos': 	selectedBlock,
													'title':    $("#title_a").val(),
													'subtitle': 	$("#title_b").val(),
													'url':      url
													},
					'dataType':	 'json',
					'type':			 'POST',
					'success':		 responseTopic
				    });
}
/* ..............................................................................................................................  */

function responseTopic(data) {
	
if (data[0].good == "yes" )  {
			$("#newPage").remove();
			$("#shirma").remove();
		}		else	 {
		alert("Ошибка при записи ");
		}
		}

