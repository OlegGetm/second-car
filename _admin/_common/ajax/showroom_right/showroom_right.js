var myBlock = -1;
var selectedPhoto = -1;

/* ..............................................................................................................................  */

function openDir() {
	
					$.ajax({
					'url': 				'../_common/ajax/showroom_right/open_dir.php',
					'data': 					{	'hello': 	"hello" },
					'dataType':	 'json',
					'type':			 'POST',
					'success':		 showFiles
				    });
}

/* ..............................................................................................................................  */


function showFiles(data) {

var newPage = $("<div>")
.attr("id", "newPage")
.css({"display":"block", "position":"absolute", "top":"4px", "left":"60px",  "width":"880px", "height":"1000px", "padding":"15px", "background-color": "#fff", "z-index":"700" });

newPage.appendTo($("#areaToShowroom"));


var leftBlock = $("<div>")
.css({"display":"block", "float":"left", "width":"374px", "height":"320px"  });
leftBlock.appendTo(newPage);
	

for (var i=1; i<4; i++)	{
	
$("<div>")
.attr("id", "topic_" +i)
.css({"display":"block", "position":"relative", "width":"245px", "height":"90px", "margin":"0 0 10px 0", "background-color": "#eaeaea"  })
.click(function () {
							if(myBlock != "-1")	{
							$("#topic_" +myBlock).css({"background-color": "#eaeaea"  });
							}
							$(this).css({"background-color": "#cd9a9a"  }) 
							myBlock = (this.id).substr(6);
							})
.appendTo(leftBlock);	
}
 
var rightBlock = $("<div>")
.css({"display":"block", "float":"left", "width":"364px", "height":"320px" });
rightBlock.appendTo(newPage);


$("<div>").css({ "color": "#ccc", "margin":"10px 0 4px 0"  }).text("Заголовок")
.appendTo(rightBlock);	

$('<input type="text"/>').attr({ "id":	"title_d", "maxlength":"79" })
.css({"width":"340px", "height":"22px", "font":"bold 15px Arial, sans-serif", "padding":"4px 2px 1px" })
.val(title)
.appendTo(rightBlock);


$('<input type="button"/>').attr("value", "OK")
.css({"margin":"50px 0 0 170px", "padding":"0 6px", "font-weight":"normal", "cursor":"pointer" })
.click(function () { 
				 if (selectedBlockNumber != "-1" && selectedPhoto != "-1")		{

				$(this).remove(); 
				$("#btnCancel").remove();
				sendRight(); 
								
				 }	else { alert("Выделите блок, в который будет добавлена заметка, и фоновое фото")}
				 })
.appendTo(rightBlock);

$('<input type="button"/>').attr({"value":"Отмена", "id": "btnCancel" })
.css({"margin-left":"20px", "padding":"0 4px", "cursor":"pointer" })
.click(function () {
							newPage.remove(); 
							$("#shirma").remove();	
							})
.appendTo(rightBlock);


var bottomBlock = $("<div>")
.css({"display":"block", "overflow":"auto", "overflow-x":"hidden", "width":"860px", "height":"510px", "margin":"30px 0 0 0px", "padding":"20px 10px 10px 10px", "background-color": "#e9e9e9", "border-top":"3px solid #767676"  })
.appendTo(newPage);

			$.each(data, function(i, val) {
				
			var lng = val.file_name.length
							
			$("<div>")
			.attr("id",   val.file_name.substr(0, lng-4) )
			.css({"display":"block", "float":"left", "width":"262px", "height":"120px", "overflow":"hidden", "margin":"0 20px 10px 0", "cursor":"pointer", "background": "#eaeaea url(../../_photos/backgrounds/" +val.file_name +")",  })								 			.click(function () {
							$(this).css({"opacity": "0.20" }) 
							selectedPhoto = this.id;
				}) 
				.appendTo(bottomBlock);
			} )

}


/* ..............................................................................................................................  */

function sendRight() {

$.ajax({
					'url': 				'../_common/ajax/showroom_right/showroom_right.php',
				
					'data': 					{	'pos': 	myBlock,
													'title':    $("#title_d").val(),
													'url':      url,
													'photo': selectedPhoto
													},
					'dataType':	 'json',
					'type':			 'POST',
					'success':		 responseRight
				    });
}

/* ..............................................................................................................................  */

function responseRight(data) {
	
if (data[0].good == "yes" )  {
			$("#newPage").remove();
				$("#shirma").remove();	
		}		else	 {
		alert("Ошибка при записи ");
		}
		}



