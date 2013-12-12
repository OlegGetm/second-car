
var contents  = new Array;
contents = [ 'about', 'drive', 'comfort', 'motor', 'body', 'transmis', 'podveska', 'electro', 'buy', 'plus']; 


$(function()  {
$(".btns_add").click( function() { insertMiniForm(this.id) } );
});	   



////////////////////////////////////////////    Insert Form

function insertMiniForm(id) {

var n = $("#form_101").length;
if(n<1)	{      // не открывать больше одной формы

 var aa = $("<div>").attr("id", "#aa_" +id);
 
 var actionUrl = 'portrait.php?car=' +carId +'&block=' +contents[id] +'#' +id;
    
  
var myForm = $("<form/>").attr({ "name": 		"myform",
							   						 "action": 		actionUrl,
													 "method": 	"post",
													 "id":				"form_101"     })
.css({"width":"400px", "margin-top":"20px", "padding":"15px", "background-color": "#ccc", "border":"0px solid #ccc" })
.submit( function () {  return sendform() ; } );

$("<div><div/>").css({"padding": "0px 0 4px 0px",  "font-weight": "bold", "color": "#fff" }).text("Ваше имя:").appendTo(myForm);

$('<input type="text"/>').attr({ "name": "name", "id":	"name_101", "maxlength":"79" })
.css({"width":"390px", "height":"22px", "font":"bold 16px Arial, sans-serif", "padding":"2px", "margin-bottom":"20px" })
.appendTo(myForm);

$("<div><div/>").css({"padding": "0px 0 4px 0px",  "font-weight": "bold", "color": "#fff" }).text("Текст:").appendTo(myForm);

$("<textarea/>").attr({ "name": "text", "id": "text_101" })
.css({"width":"390px", "height":"200px", "font":"bold 16px Arial, sans-serif", "padding":"2px" })
.appendTo(myForm);

var btnOk = $('<input type="submit"/>').attr("value", "OK")
.css({"margin-top":"30px", "padding":"0 6px", "font-weight":"bold", "cursor":"pointer" }).appendTo(myForm);

var btnCancel = $('<input type="button"/>').attr("value", "Отмена")
.css({"margin-left":"20px", "padding":"0 4px", "cursor":"pointer" })
													.click(function () {
																				aa.remove(); 
																				$("#" +id).show();
																				})
													.appendTo(myForm);
myForm.appendTo(aa);
$("#" +id).hide();
aa.hide().insertAfter("#" +id).fadeIn(1000);
$("#text_101").focus();
} }


			function sendform () {
			if($("#name_101").val() =="") {
			$("#name_101").focus();
			alert ("Как вас зовут?");
			return false;
					}
			else if($("#text_101").val() =="") {
			$("#text_101").focus();
			alert ("Вы не добавили комментарий");
			return false;
			}
			else {
			return true;
			}	} 